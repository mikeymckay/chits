#!/bin/bash

if [ -z "$SUDO_USER" ]; then
  echo "$0 must be called from sudo. Try: 'sudo ${0}'"
  exit 1
fi

# Extract relevant lines from chits_install.sh and run them

START=`grep  -n "START OF DATABASE" chits_install.sh | cut -d: -f1`
END=`grep  -n "END OF DATABASE" chits_install.sh | cut -d: -f1`
OUTPUT_FILE="/tmp/setup_database_backup.sh"

echo "Note the database backup scripts are now part of the chits_install.sh script, and they will be installed automatically during chits installation."

echo "#!/bin/bash
if [ ! "$CHITS_LIVE_PASSWORD" ]; then 
  echo "Enter password for database user chits_live:"
  read CHITS_LIVE_PASSWORD
fi


" > $OUTPUT_FILE

sed -n "${START},${END} p" chits_install.sh >> $OUTPUT_FILE
chmod +x $OUTPUT_FILE
# Run it!
echo "Executing script setup script found here: ${OUTPUT_FILE}"
$OUTPUT_FILE
