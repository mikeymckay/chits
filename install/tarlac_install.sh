#!/bin/bash
if [ -z "$SUDO_USER" ]; then
    echo "$0 must be called from sudo. Try: 'sudo ${0}'"
    exit 1
fi

echo "Press enter if unsure about the following questions"
echo "Do you want to upgrade all packages? ([y]/n)"
read UPGRADE_ALL

echo "Do you want to remove un-needed packages like games, music players and email? ([y]/n)"
read REMOVE

echo "Do you want to update your apt sources list to remove updates (for a faster install)? ([y]/n)"
read UPDATE_SOURCES

# These are for all configurations
PROGRAMS_TO_INSTALL='openssh-server wget vim'

if [ ! "${REMOVE}" = "n" ]; then
  PROGRAMS_TO_REMOVE="gnome-games gnome-games-data openoffice.org-common f-spot ekiga evolution pidgin totem totem-common brasero rhythmbox synaptic gimp"
fi

if [ ! "${UPDATE_SOURCES}" = "n" ]; then
  sed -i 's/^\(.*updates.*\)$/#\1/' /etc/apt/sources.list
  sed -i 's/^\(.*security.*\)$/#\1/' /etc/apt/sources.list
  apt-get update
fi

echo "
set bell-style none

\"\e[A\": history-search-backward
\"\e[B\": history-search-forward
\"\e[5C\": forward-word
\"\e[5D\": backward-word
\"\e\e[C\": forward-word
\"\e\e[D\": backward-word
\$if Bash
  Space: magic-space
\$endif" > /home/$SUDO_USER/.inputrc

# Call "install wget" to add wget to the list of programs to install
install () {
  PROGRAMS_TO_INSTALL="${PROGRAMS_TO_INSTALL} ${1}"
}

remove () {
  PROGRAMS_TO_REMOVE="${PROGRAMS_TO_REMOVE} ${1}"
}

set_mysql_root_password () {
  if [ ! "$MYSQL_ROOT_PASSWORD" ]; then 
    echo "Enter the root password to setup mysql with:"
    read MYSQL_ROOT_PASSWORD
  fi
  echo "mysql-server mysql-server/root_password select ${MYSQL_ROOT_PASSWORD}" | debconf-set-selections
  echo "mysql-server mysql-server/root_password_again select ${MYSQL_ROOT_PASSWORD}" | debconf-set-selections
  export MYSQL_ROOT_PASSWORD 
}

set_chits_live_password () {
  if [ ! "$CHITS_LIVE_PASSWORD" ]; then 
    echo "Enter password for database user chits_live:"
    read CHITS_LIVE_PASSWORD
  fi
  export CHITS_LIVE_PASSWORD
}

autoconnect_to_access_point() {
  NETWORK_MANAGER_SYSTEMS_CONNECTION_DIR=/etc/NetworkManager/system-connections
  DEFAULT_SSID_FILE="${NETWORK_MANAGER_SYSTEMS_CONNECTION_DIR}/Auto Default"
  if [ -e "${DEFAULT_SSID_FILE}" ]; then 
    return
  fi

  echo "Setting up NetworkManager to automatically connect to access point with SSD 'default' during boot"
  echo "Creating file at ${DEFAULT_SSID_FILE}"
  SSID_IN_BYTES="68;101;102;97;117;108;116;"
# Get this by running ruby -i -e 'print "Default".unpack("U*").map{|c|"#{c};"}'
# Change "default" to be name of SSID

  mkdir --parents "${NETWORK_MANAGER_SYSTEMS_CONNECTION_DIR}"

  echo "
[connection]
id=Auto default
type=802-11-wireless
autoconnect=true
timestamp=1258702919

[ipv4]
method=auto
ignore-auto-routes=false
ignore-auto-dns=false
dhcp-send-hostname=false
never-default=false

[ipv6]
method=ignore
ignore-auto-routes=false
ignore-auto-dns=false
never-default=false

[802-11-wireless]
ssid=${SSID_IN_BYTES}
mode=infrastructure
channel=0
rate=0
tx-power=0
mtu=0
" > "${DEFAULT_SSID_FILE}"

  chmod 600 "${DEFAULT_SSID_FILE}"


}

client () {
  echo "Client"
  install "tuxtype"
  apt-get --assume-yes install $PROGRAMS_TO_INSTALL
  apt-get --assume-yes remove $PROGRAMS_TO_REMOVE
  if [ ! "${UPGRADE_ALL}" = "n" ]; then
    apt-get --assume-yes upgrade
  fi

  autoconnect_to_access_point

# Make firefox launch automatically and point it at http://chits_server
  AUTOSTART_DIR=$HOME/.config/autostart
  mkdir --parents $AUTOSTART_DIR
  echo "[Desktop Entry]
Type=Application
Encoding=UTF-8
Version=1.0
Name=No Name
Name[en_US]=Firefox
Comment[en_US]=Firefox
Comment=Firefox
Exec=/usr/bin/firefox -fullscreen -no-remote -P default http://192.168.2.2
X-GNOME-Autostart-enabled=true" > $AUTOSTART_DIR/firefox.desktop

# Create firefox profile with kiosk/fullscreen mode enabled
  wget --output-document=tarlac_firefox_profile.zip http://github.com/mikeymckay/chits/raw/master/install/tarlac_firefox_profile.zip
# unzip this as the user to keep permissions right
  su $SUDO_USER -c "unzip tarlac_firefox_profile.zip"
}

server () {
  echo "Server"
  set_mysql_root_password; 
  set_chits_live_password;

  install "autossh curl"
  apt-get --assume-yes install $PROGRAMS_TO_INSTALL
  apt-get --assume-yes remove $PROGRAMS_TO_REMOVE
  if [ ! "${UPGRADE_ALL}" = "n" ]; then
    apt-get --assume-yes upgrade
  fi

  SERVER_IP_ADDRESS=192.168.2.2
  SERVER_GATEWAY=192.168.2.1
  echo "Setting static IP for server to: ${SERVER_IP_ADDRESS} and gateway to ${SERVER_GATEWAY}"

  echo "
auto lo
iface lo inet loopback

auto wlan0
iface wlan0 inet static
  address ${SERVER_IP_ADDRESS}
  netmask 255.255.255.0
  gateway ${SERVER_GATEWAY}
" > /etc/network/interfaces

  autoconnect_to_access_point

  wget --output-document=chits_install.sh http://github.com/mikeymckay/chits/raw/master/install/chits_install.sh

  chmod +x chits_install.sh mysql_replication.sh setup_reverse_ssh_tunnel
  ./chits_install.sh


  PATH_TO_DBSELECT="/var/www/chits/modules/_dbselect.php"
  echo "Editing ${PATH_TO_DBSELECT} so that chits uses the mysql database chits_live"
  sed -i 's/chits_development/chits_live/' $PATH_TO_DBSELECT
  sed -i 's/chits_developer/chits_live/' $PATH_TO_DBSELECT
  sed -i "s/\"password\"/\"${CHITS_LIVE_PASSWORD}\"/" $PATH_TO_DBSELECT

  echo "Creating ssh keys so we can reverse ssh into the server"
  su $SUDO_USER -c "mkdir /home/$SUDO_USER/.ssh"
  su $SUDO_USER -c "ssh-keygen -N \"\" -f /home/$SUDO_USER/.ssh/id_rsa"

  echo "Setting up reverse autossh to run when network comes up"
  # TODO switch this to use more flexible script under separate github repo
  # Generate a random port number to use in the 10000 - 20000 range
  PORT_NUMBER=$[ ( $RANDOM % 10000 )  + 10000 ]
  MONITORING_PORT_NUMBER=$[ ( $RANDOM % 10000 )  + 20000 ]
  echo "#!/bin/sh
# ------------------------------
# Added by tarlac_install script
# ------------------------------
# See autossh and google for reverse ssh tunnels to see how this works

# When this script runs it will allow you to ssh into this machine even if it is behind a firewall or has a NAT'd IP address. 
# From any ssh capable machine you just type ssh -p $PORT_MIDDLEMAN_WILL_LISTEN_ON localusername@middleman

# This is the username on your local server who has public key authentication setup at the middleman
USER_TO_SSH_IN_AS=chitstunnel

# This is the username and hostname/IP address for the middleman (internet accessible server)
MIDDLEMAN_SERVER_AND_USERNAME=chitstunnel@chits.ph

# Port that the middleman will listen on (use this value as the -p argument when sshing)
PORT_MIDDLEMAN_WILL_LISTEN_ON=${PORT_NUMBER}

# Connection monitoring port, don't need to know this one
AUTOSSH_PORT=${MONITORING_PORT_NUMBER}

# Ensures that autossh keeps trying to connect
AUTOSSH_GATETIME=0

export AUTOSSH_GATETIME AUTOSSH_PORT

su -c "autossh -f -N -R *:${PORT_MIDDLEMAN_WILL_LISTEN_ON}:localhost:22 ${MIDDLEMAN_SERVER_AND_USERNAME} -oLogLevel=error  -oUserKnownHostsFile=/dev/null -oStrictHostKeyChecking=no" $USER_TO_SSH_IN_AS


" > /etc/network/if-up.d/reverse_ssh_tunnel

  chmod +x /etc/network/if-up.d/reverse_ssh_tunnel

#  echo "Uploading public key to lakota.vdomck.org"
#  PUBLIC_KEY_FILENAME=/tmp/`hostname`.public_key
#  cp /home/$SUDO_USER/.ssh/id_rsa.pub $PUBLIC_KEY_FILENAME
#  cat "\n#{PORT_NUMBER}" >> $PUBLIC_KEY_FILENAME
#  curl -F "file=@${PUBLIC_KEY_FILENAME}" lakota.vdomck.org:4567/upload

  echo "To setup replication, put all clients and server on the network and ready, run: 'sudo /var/www/chits/install/mysql_replication'"
}

client_and_server () {
  echo "Client & Server"
  set_mysql_root_password; 
  set_chits_live_password;
  client
  server
}

client_with_mysql_replication () {
  if [ ! "$MYSQL_ROOT_PASSWORD" ]; then 
    set_mysql_root_password; 
  fi
  install "mysql-server"
  client
  echo "Replication needs to be completed by logging onto the master computer and running the mysql_replication.sh script"
}

while : # Loop forever
do
cat << !

${PROGRAMS_TO_INSTALL}

1. Client with mysql replication (recommended)
2. Server with Client (recommended)
3. Client lite
4. Server lite
5. Exit

!

echo -n " Your choice? : "
read choice

case $choice in
1) client_with_mysql_replication; exit ;;
2) client_and_server; exit ;;
3) client; exit ;;
4) server; exit ;;
5) exit ;;
*) echo "\"$choice\" is not valid "; sleep 2 ;;
esac
done

exit
