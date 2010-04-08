<?
	class sanitation extends module {
		// Author: Herman Tolentino MD
		// CHITS Project 2004
		
		// ENVIRONMENTAL SANITATION PROGRAM MODULE
		
		// Feel free to add additional comments anywhere.
		// Just add comment dates before the actual comment.
		
		// COMMENT DATE: Sep 25, '09
		// THESE ARE THE REQUIRED APIs/FUNCTIONS FOR EVERY MODULE
		// 1. init_deps()
		// 2. init_lang()
		// 3. init_stats()
		// 4. init_help()
		// 5. init_menu()
		// 6. init_sql()
		// 7. CONSTRUCTOR FUNCTION
		// 8. drop_tables()
		
		
		
		// Comment date: Sep 25, '09
		// The constructor function starts here
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sanitation() {
			$this->author = 'Jeffrey V. Tolentino';
			$this->version = '0.1-'.date('Y-m-d');
			$this->module = 'sanitation';
			$this->description = 'CHITS Module - Environmental Sanitation Program';  

			$this->members_info = array();
			$this->household_number;
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Oct 21, '09, JVTolentino
		// This function is somehow needed by the healthcenter class, the reason 
		//    is unknown.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function _details_sanitation() {
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		function init_deps() {
			module::set_dep($this->module, "module");
			module::set_dep($this->module, "healthcenter");
			module::set_dep($this->module, "patient");                               
		}
		
		
		
		function init_lang() {
		}	
		
		
		
		function init_stats() {
		}
		
		
		
		function init_help() {
		}
		
		
		
		// Comment date: Sep 25, '09
		// The init_menu() function starts here
		// This function is used to include a link to the menu pane,
		// to the pane at the bottom of the menu pane, and so on...
		// (The menu pane is located at the left side of the site)
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_menu() {
			if (func_num_args()>0) {
				$arg_list = func_get_args();
			}
			
			//print_r($arg_list);
			
			// set_menu parameters
			// set_menu([module name], [menu title - what is displayed], menu categories (top menu)], [script executed in class])
			module::set_menu($this->module, 'Sanitation', 'Environmental', '_consult_sanitation');
			// set_detail parameters
			// set_detail([module description], [module version], [module author], [module name/id]
			module::set_detail($this->description, $this->version, $this->author, $this->module);
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// Comment date: Oct 7, 2009, JVTolentino
		// The init_sql() function starts here.
		// This function will initialize the tables for the Sanitation Module in Chits DB.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_sql() {
			if (func_num_args()>0) {
			$arg_list = func_get_args();
			}

			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_household` (".
				"`record_number` float NOT NULL AUTO_INCREMENT,".
				"`household_number` float NOT NULL,".
				"`family_id` float NOT NULL,".
				"`water_supply` char(25) COLLATE swe7_bin NOT NULL,".
				"`sanitary_toilet` char(25) COLLATE swe7_bin NOT NULL,".
				"`disposal_of_solid_waste` char(25) COLLATE swe7_bin NOT NULL,".
				"`user_id` float NOT NULL,".
				"PRIMARY KEY (`record_number`)".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_household_list` (".
				"`household_number` float NOT NULL AUTO_INCREMENT,".
				"`user_id` float NOT NULL,".
				"`date_updated` date NOT NULL,".
				"PRIMARY KEY (`household_number`)".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=1 ;");
			
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// Comment date: Oct 13, 2009, JVTolentino
		// The drop_tables() function starts here.
		// This function will be used to drop tables from CHITS DB.
		// This function will be executed if the user opts to delete
		//    the tables associated with this module.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function drop_tables() {
			module::execsql("DROP TABLE `m_sanitation_household`");
			module::execsql("DROP TABLE `m_sanitation_hosuehold_list`");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// Comment date: Jan 19, 2010, JVTolentino
		// The succeeding codes and functions will be used exclusively(??) for
		//    the 'CHITS - ENVIRONMENTAL SANITATION PROGRAM MODULE'. These codes
		//    are open-source, so feel free to modify, enhance, and distribute
		//    as you wish.
		// Some codes, especially those used for the required functions were copied
		//    from the leprosy module and pasted here, thus, the comment dates on those
		// 	functions.
		// Start date: Mar 12, 2010, JVTolentino
		// End date: 
		// Version Release Date: 
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_primary_keys() {
			$query = "ALTER TABLE `m_sanitation_household` DROP PRIMARY KEY, ADD PRIMARY KEY(`record_number`)";
	                $result = mysql_query($query) or die("Couldn't execute query.");

			$query = "ALTER TABLE `m_sanitation_household_list` DROP PRIMARY KEY, ADD PRIMARY KEY(`household_number`)";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                function show_water_supply() {
			print "<table border=1 align='left'>";
                        	print "<tr>";
                                	print "<td align='left' colspan=2 bgcolor='CC9900'><i><b>Access to Improved or Safe Water Supply</i></b></td>";
                          	print "</tr>";

				print "<tr>";
					print "<td><input type='radio' name='water_supply' value='level_1'>Level I (Point Source)</input></td>";
					print "<td>Level I refers to a protected well (shallow and deep well), improved dug well, developed spring, or rainwater cistern with an outlet but without a distribution system.</td>";
				print "</tr>";

				print "<tr>";
					print "<td><input type='radio' name='water_supply' value='level_2'>Level II (Communal Faucet or Standpost System)</input></td>";
					print "<td>Level II refers to a system composed of a source, a reservoir, a piped distribution network, and a communal faucet located not more than 25 meters from the farthest house.</td>";
				print "</tr>";

				print "<tr>";
					print "<td><input type='radio' name='water_supply value='level_3'>Level III (Waterworks System)</input></td>";
					print "<td>Level III is a system with a source, transmission pipes, a reservoir, and a piped distribution network for household taps. Example of these are MWSS and water districts with individual household connections.</td>";
				print "</tr>";
                  	print "</table>";
                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                function show_sanitary_toilets() {
			print "<table border=1 align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan=2 bgcolor='CC9900'><i><b>Sanitary Toilets</i></b></td>";
                                print "</tr>";

				print "<tr>";
					print "<td><select name='sanitary_toilet'>";
						print "<option value=''>Choose One</option>";
						print "<option value='water_sealed'>Water Sealed</option>";
						print "<option value='pit_privy'>Pit Privy</option>";
						print "<option value='without'>Without</option>";
					print "</select></td>";
					print "<td>Sanitary toilets refer to households with flush toilets connected to sceptic tanks and/or sewerage system or any other approved treatment system, sanitary pit latrine or ventilated improved pit latrine.</td>";
				print "</tr>";
			print "</table>";

		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


		// Comment date: April 8, 2010, JVTolentino
		// This function will return an array, of which the values are in this order: 
		//	- patient lastname
		//	- patient firstname
		//	- family id
		//	- family role
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function search_household_members() {
			if(($_POST['household_member_lastname'] == '') && ($_POST['household_member_firstname'] == '')) return;
			$ln = $_POST['household_member_lastname'];
			$fn = $_POST['household_member_firstname'];

			$query = "SELECT a.patient_lastname, a.patient_firstname, b.family_id, b.family_role FROM m_patient a INNER JOIN m_family_members b ON a.patient_id = b.patient_id WHERE a.patient_lastname = '$ln' OR a.patient_firstname = '$fn' ORDER BY a.patient_firstname";
			$result = mysql_query($query) or die("Couldn't execute query.");

			$members_info = array();
			while(list($patient_lastname, $patient_firstname, $family_id, $family_role) = mysql_fetch_array($result)) {
				array_push($members_info, $patient_lastname);
				array_push($members_info, $patient_firstname);
				array_push($members_info, $family_id);
				array_push($members_info, $family_role);
			}
			return $members_info;
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_household_member() {
			print "<table border=3 bordercolor='black' align='center' width=600>";
                                print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>SEARCH HOUSEHOLD MEMBER</th>";
                                print "</tr>";

                                print "<tr>";
                                        print "<td>Lastname: <input type='text' name='household_member_lastname'></input></td>";
					print "<td>Firstname: <input type='text' name='household_member_firstname'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<td align='center' colspan='2'><input type='submit' name='submit_button' value='Search'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<th colspan='2' align='left' bgcolor='CC9900'>SELECT HOUSEHOLD MEMBER</th>";
				print "</tr>";

				if(count($this->members_info)>0) {
					print "<tr>";
						print "<td colspan='2'>";
						for($i=0; $i<count($this->members_info); $i=$i+4) {
							print "<input type='radio' name='household_member' value='".$this->members_info[$i+2]."'>".$this->members_info[$i].", ".$this->members_info[$i+1]." (".$this->members_info[$i+3].")</input><br>";
						}
						print "</td>";
					print "</tr>";

					print "<tr>";
						print "<td colspan='2' align='center'>To <i><b>edit a household</b></i>, select a family member and then click the 'Edit Household' button.&nbsp;<input type='submit' name='submit_button' value='Edit Household'></input></td>";
					print "</tr>";
				}
                        print "</table>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_household_sanitation() {
			print "<table border=3 bordercolor='black' align='center' width=600>";
				print "<tr>";
					print "<th align='left' bgcolor=#CC9900#>HOUSEHOLD SANITATION</th>";
				print "</tr>";

				print "<tr>";
					print "<td>";
					$this->show_water_supply();
					print "</td>";
				print "</tr>";

				print "<tr>";
					print "<td>";
					$this->show_sanitary_toilets();
					print "</td>";
				print "</tr>";
			print "</table>";

		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function household() {
			$this->show_household_sanitation();
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function create_household_number() {
			$userid = $_SESSION['userid'];
			list($month, $day, $year) = explode("/", date("m/d/Y"));
                        $current_date = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);

			$query1 = "INSERT INTO m_sanitation_household_list (user_id, date_updated) VALUES($userid, '$current_date')";
			$result1 = mysql_query($query1) or die("Couldn't execute query.");

			$query2 = "SELECT household_number FROM m_sanitation_household_list ORDER BY household_number DESC";
			$result2 = mysql_query($query2) or die("Couldn't execute query.");

			if($row = mysql_fetch_assoc($result2)) {
				return $row['household_number'];
			}	
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function create_household() {
			$household_number = $this->create_household_number();
			$family_id = $_POST['household_member'];
			$userid = $_SESSION['userid'];

			$query = "INSERT INTO m_sanitation_household (household_number, family_id, user_id) ".
				"VALUES($household_number, $family_id, $userid)";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 8, 2010, JVTolentino
		// This function will get the household number of a family
		// 	based on their family id.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_household_number() {
			if($_POST['household_member'] == '') {
				return;
			}
			else {
				$family_id = $_POST['household_member'];
			}

			$query = "SELECT household_number FROM m_sanitation_household ".
				"WHERE family_id = $family_id ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['household_number'];
			}
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function submit_button_clicked() {
			switch($_POST['submit_button']) {
				case 'Search':
					$this->members_info = $this->search_household_members();
					break;
				case 'Edit Household':
					$this->household_number = $this-get_household_number();
					break;
				case 'Create Household':
					if($_POST['household_member'] != '') {
						$this->create_household();
					}
					break;
			}
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Nov 04, '09, JVTolentino
		// This is the main function for the sanitation module.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function _consult_sanitation() {
			print "<form name='form_sanitation' action='$_POST[PHP_SELF]' method='POST'>";
				$sanitation = new sanitation;

				if(@$_POST['h_save_flag'] == 'GO') {
					$sanitation->submit_button_clicked();

					$sanitation->show_household_member();

					print "&nbsp;";
					//$sanitation->household();
				}
				else {
					$sanitation->show_household_member();

					print "&nbsp;";
					//$sanitation->household();
				}

				echo "<input type='hidden' name='h_save_flag' value='GO'></input>";

			print "</form>";




			/*
			echo "<form name='form_leprosy' action='$_POST[PHP_SELF]' method='POST'>";
				
				$leprosy = new leprosy;
				
				$leprosy->consult_id = $_GET['consult_id'];
				$leprosy->patient_id = healthcenter::get_patient_id($_GET['consult_id']);
				//$leprosy->patient_age = healthcenter::get_patient_age($_GET['consult_id']);
				$leprosy->userid = $_SESSION['userid'];
				
				//The following codes will initialize hidden textboxes and their values
				echo "<input type='hidden' name='h_consult_id' value='{$leprosy->consult_id}'></input>";
				echo "<input type='hidden' name='h_patient_id' value='{$leprosy->patient_id}'></input>";
				echo "<input type='hidden' name='h_userid' value='{$leprosy->userid}'></input>";
				
				if (@$_POST['h_save_flag'] == 'GO') {
					print "&nbsp;";
					$leprosy->new_leprosy_record();
					// test wether it still needed to initialize primary keys after a POST.
					//$leprosy->init_primary_keys();
					
					print "&nbsp;";
					$leprosy->show_NLCPForm1();
				
				} 
				else {
					print "&nbsp;";
					$leprosy->init_primary_keys();
					
					print "&nbsp;";
					$leprosy->show_NLCPForm1();
					
					
				}
				
				echo "<input type='hidden' name='h_save_flag' value='GO'></input>";
			echo "</form>";
			*/
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
	} // class ends here
?>
