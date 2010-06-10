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

			// The following variables will be used for Sanitation/Household
			$this->family_members_info = array();
			$this->family_id;
			$this->household_number;
			$this->selected_household;


			// The following variable/s will be used for Templates
			$this->current_template = $_POST['h_current_template'];


			// The following variables will be used for Sanitation/Establishment
			$this->establishments_info = array();
			$this->selected_establishment = $_POST['h_selected_establishment'];
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
				"`user_id` float NOT NULL,".
				"PRIMARY KEY (`record_number`)".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_household_list` (".
				"`household_number` float NOT NULL AUTO_INCREMENT,".
				"`user_id` float NOT NULL,".
				"`date_updated` date NOT NULL,".
				"PRIMARY KEY (`household_number`)".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=1 ;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_water_supply` (".
  				"`household_number` float NOT NULL,".
  				"`water_supply_level` int(11) NOT NULL,".
  				"`year_inspected` int(11) NOT NULL,".
  				"`user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_sanitary_toilet` (".
				"  `household_number` float NOT NULL,".
				"  `sanitary_toilet` char(25) COLLATE swe7_bin NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_disposal_of_solid_waste` (".
				"  `household_number` float NOT NULL,".
				"  `disposal_of_solid_waste` enum('Y','N') COLLATE swe7_bin NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_establishment` (".
				"  `establishment_id` float NOT NULL AUTO_INCREMENT,".
				"  `name_of_establishment` char(50) COLLATE swe7_bin NOT NULL,".
				"  `owner` char(50) COLLATE swe7_bin NOT NULL,".
				"  `barangay_id` int(11) NOT NULL,".
				"  `user_id` float NOT NULL,".
				"  PRIMARY KEY (`establishment_id`)".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin AUTO_INCREMENT=1 ;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_sanitary_permit` (".
				"  `establishment_id` float NOT NULL,".
				"  `sanitary_permit` enum('Y','N') COLLATE swe7_bin NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_food_handlers` (".
				"  `establishment_id` float NOT NULL,".
				"  `food_handlers` int(11) NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_food_handlers_with_health_certificates` (".
				"  `establishment_id` float NOT NULL,".
				"  `food_handlers_with_health_certificates` int(11) NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_household_salt_samples` (".
				"  `household_number` float NOT NULL,".
				"  `salt_samples` char(25) COLLATE swe7_bin NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` int(11) NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


			module::execsql("CREATE TABLE IF NOT EXISTS `m_sanitation_establishment_salt_samples` (".
				"  `establishment_id` float NOT NULL,".
				"  `salt_samples` char(25) COLLATE swe7_bin NOT NULL,".
				"  `year_inspected` int(11) NOT NULL,".
				"  `user_id` float NOT NULL".
				") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");


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
			module::execsql("DROP TABLE `m_sanitation_water_supply`");
			module::execsql("DROP TABLE `m_sanitation_sanitary_toilets`");
			module::execsql("DROP TABLE `m_sanitation_disposal_of_solid_waste`");
			module::execsql("DROP TABLE `m_sanitation_establishment`");
			module::execsql("DROP TABLE `m_sanitation_sanitary_permit`");
			module::execsql("DROP TABLE `m_sanitation_food_handlers`");
			module::execsql("DROP TABLE `m_sanitation_food_handlers_with_health_certificates`");
			module::execsql("DROP TABLE `m_sanitation_household_salt_samples`");
			module::execsql("DROP TABLE `m_sanitation_establishment_salt_samples`");
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

			$query = "ALTER TABLE `m_sanitation_establishment` DROP PRIMARY KEY, ADD PRIMARY KEY(`establishment_id`)";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                function show_water_supply() {
			print "<table border='1' align='left'>";
                        	print "<tr>";
                                	print "<td align='left' colspan='2'><i><b>Access to Improved or Safe Water Supply</i></b></td>";
                          	print "</tr>";

				$water_supply_level = $this->get_last_water_supply_level($this->selected_household);

				print "<tr>";
					if($water_supply_level == 1) {
						print "<td><input type='radio' name='water_supply' value='level_1' checked>Level I (Point Source)</input></td>";
					}
					else {
						print "<td><input type='radio' name='water_supply' value='level_1'>Level I (Point Source)</input></td>";
					}
					print "<td>Level I refers to a protected well (shallow and deep well), improved dug well, developed spring, or rainwater cistern with an outlet but without a distribution system.</td>";
				print "</tr>";

				print "<tr>";
					if($water_supply_level == 2) {
						print "<td><input type='radio' name='water_supply' value='level_2' checked>Level II (Communal Faucet or Standpost System)</input></td>";
					}
					else {
						print "<td><input type='radio' name='water_supply' value='level_2'>Level II (Communal Faucet or Standpost System)</input></td>";
					}
					print "<td>Level II refers to a system composed of a source, a reservoir, a piped distribution network, and a communal faucet located not more than 25 meters from the farthest house.</td>";
				print "</tr>";

				print "<tr>";
					if($water_supply_level == 3) {
						print "<td><input type='radio' name='water_supply' value='level_3' checked>Level III (Waterworks System)</input></td>";
					}
					else {
						print "<td><input type='radio' name='water_supply' value='level_3'>Level III (Waterworks System)</input></td>";
					}
					print "<td>Level III is a system with a source, transmission pipes, a reservoir, and a piped distribution network for household taps. Example of these are MWSS and water districts with individual household connections.</td>";
				print "</tr>";
                  	print "</table>";
                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_water_supply_level($household_number, $year_inspected, $water_supply_level) {
			$query = "INSERT INTO m_sanitation_water_supply (household_number, water_supply_level, year_inspected, user_id) ".
				"VALUES($household_number, $water_supply_level, $year_inspected, {$_SESSION['userid']}) ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_water_supply_level($household_number, $year_inspected, $water_supply_level) {
			$query = "UPDATE m_sanitation_water_supply SET ".
				"water_supply_level = $water_supply_level, ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE household_number = $household_number ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn'tecute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_water_supply_level($household_number) {
			$query = "SELECT water_supply_level FROM m_sanitation_water_supply ".
				"WHERE household_number = $household_number ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['water_supply_level'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function water_supply_inspected($household_number, $year_inspected) {
			if(($household_number == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_water_supply ".
				"WHERE household_number = $household_number AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                function show_sanitary_toilets() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Sanitary Toilets</i></b></td>";
                                print "</tr>";

				$sanitary_toilet = $this->get_last_sanitary_toilet($this->selected_household);
				print "<tr>";
					print "<td><select name='sanitary_toilet'>";
						if($sanitary_toilet == '') {
							print "<option value='' selected>Choose One</option>";
						}
						else {
							print "<option value=''>Choose One</option>";
						}

						if($sanitary_toilet == 'Water Sealed') {
							print "<option value='Water Sealed' selected>Water Sealed</option>";
						}
						else {
							print "<option value='Water Sealed'>Water Sealed</option>";
						}

						if($sanitary_toilet == 'Pit Privy') {
							print "<option value='Pit Privy' selected>Pit Privy</option>";
						}
						else {
							print "<option value='Pit Privy'>Pit Privy</option>";
						}

						if($sanitary_toilet == 'Without') {
							print "<option value='Without' selected>Without</option>";
						}
						else {
							print "<option value='Without'>Without</option>";
						}
					print "</select></td>";
					print "<td>Sanitary toilets refer to households with flush toilets connected to sceptic tanks and/or sewerage system or any other approved treatment system, sanitary pit latrine or ventilated improved pit latrine.</td>";
				print "</tr>";
			print "</table>";

		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_sanitary_toilet($household_number, $year_inspected, $sanitary_toilet) {
			$query = "INSERT INTO m_sanitation_sanitary_toilet (household_number, sanitary_toilet, year_inspected, user_id) ".
                                "VALUES($household_number, '$sanitary_toilet', $year_inspected, {$_SESSION['userid']}) ";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_sanitary_toilet($household_number, $year_inspected, $sanitary_toilet) {
			$query = "UPDATE m_sanitation_sanitary_toilet SET ".
				"sanitary_toilet = '$sanitary_toilet', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE household_number = $household_number ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_sanitary_toilet($household_number) {
			$query = "SELECT sanitary_toilet FROM m_sanitation_sanitary_toilet ".
				"WHERE household_number = $household_number ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['sanitary_toilet'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sanitary_toilet_inspected($household_number, $year_inspected) {
			if(($household_number == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_sanitary_toilet ".
				"WHERE household_number = $household_number AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_disposal_of_solid_waste() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Disposal of Solid Waste</i></b></td>";
                                print "</tr>";

				$disposal_of_solid_waste = $this->get_last_disposal_of_solid_waste($this->household_number);

                                print "<tr>";
					if($disposal_of_solid_waste == 'Y') {
                                        	print "<td><input type='checkbox' name='disposal_of_solid_waste' value='Y' checked>".
							"With Satisfactory Disposal of Solid Waste</input></td>";
					}
					else {
						print "<td><input type='checkbox' name='disposal_of_solid_waste' value='Y'>".
                                                        "With Satisfactory Disposal of Solid Waste</input></td>";
					}
                                        print "<td>Satisfactory disposal of solid waste refers to households with garbage disposal through composting, burying, city/municipal system.</td>";
                                print "</tr>";
                        print "</table>";

                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_disposal_of_solid_waste($household_number, $year_inspected, $disposal_of_solid_waste) {
			$query = "INSERT INTO m_sanitation_disposal_of_solid_waste (household_number, disposal_of_solid_waste, year_inspected, user_id) ".
                                "VALUES($household_number, '$disposal_of_solid_waste', $year_inspected, {$_SESSION['userid']}) ";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_disposal_of_solid_waste($household_number, $year_inspected, $disposal_of_solid_waste) {
			$query = "UPDATE m_sanitation_disposal_of_solid_waste SET ".
				"disposal_of_solid_waste = '$disposal_of_solid_waste', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE household_number = $household_number ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_disposal_of_solid_waste($household_number) {
			$query = "SELECT disposal_of_solid_waste FROM m_sanitation_disposal_of_solid_waste ".
				"WHERE household_number = $household_number ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['disposal_of_solid_waste'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function disposal_of_solid_waste_inspected($household_number, $year_inspected) {
			if(($household_number == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_disposal_of_solid_waste ".
				"WHERE household_number = $household_number AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_household_salt_samples() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Salt Samples</i></b></td>";
                                print "</tr>";

				$household_salt_samples = $this->get_last_household_salt_samples($this->household_number);

				print "<tr>";
					switch($household_salt_samples) {
						case 'Not Tested':
							print "<td><select name='household_salt_samples'>".
                                                		"<option value='Not Tested' selected>Not Tested</option>".
                                                		"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                 	       			"</select></td>";
							break;
						case 'Positive For Iodine':
							print "<td><select name='household_salt_samples'>".
                                                		"<option value='Not Tested'>Not Tested</option>".
                                                		"<option value='Positive For Iodine' selected>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                        			"</select></td>";
							break;
						case 'Negative For Iodine':
							print "<td><select name='household_salt_samples'>".
                                                		"<option value='Not Tested'>Not Tested</option>".
                                               		 	"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine' selected>(-) for Iodine</option>".
                                      		  		"</select></td>";
							break;
						default:
							print "<td><select name='household_salt_samples'>".
                                                		"<option value='Not Tested' selected>Not Tested</option>".
                                                		"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                 	       			"</select></td>";
							break;
					}
					
					print "<td>Salt Samples Tested for Iodine. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>";
				print "</tr>";




                        print "</table>";

                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_household_salt_samples($household_number, $year_inspected, $salt_samples) {
			$query = "INSERT INTO m_sanitation_household_salt_samples (household_number, salt_samples, year_inspected, user_id) ".
                                "VALUES($household_number, '$salt_samples', $year_inspected, {$_SESSION['userid']}) ";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_household_salt_samples($household_number, $year_inspected, $salt_samples) {
			$query = "UPDATE m_sanitation_household_salt_samples SET ".
				"salt_samples = '$salt_samples', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE household_number = $household_number ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_household_salt_samples($household_number) {
			$query = "SELECT salt_samples FROM m_sanitation_household_salt_samples ".
				"WHERE household_number = $household_number ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['salt_samples'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function household_salt_samples_inspected($household_number, $year_inspected) {
			if(($household_number == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_household_salt_samples ".
				"WHERE household_number = $household_number AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: April 8, 2010, JVTolentino
		// This function will return an array, of which the values are in this order: 
		//	- patient lastname
		//	- patient firstname
		//	- family id
		//	- family role
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function search_family_members() {
			if(($_POST['household_member_lastname'] == '') && ($_POST['household_member_firstname'] == '')) return;
			$ln = $_POST['household_member_lastname'];
			$fn = $_POST['household_member_firstname'];

			if(($ln != '') && ($fn == '')) {
				$query = "SELECT a.patient_lastname, a.patient_firstname, b.family_id, b.family_role ".
                                "FROM m_patient a INNER JOIN m_family_members b ON a.patient_id = b.patient_id ".
                                "WHERE a.patient_lastname LIKE '%{$ln}%' ORDER BY a.patient_firstname";
			}
			elseif (($ln == '') && ($fn != '')) {
				$query = "SELECT a.patient_lastname, a.patient_firstname, b.family_id, b.family_role ".
                                "FROM m_patient a INNER JOIN m_family_members b ON a.patient_id = b.patient_id ".
                                "WHERE a.patient_firstname LIKE '%{$fn}%' ORDER BY a.patient_firstname";
			}
			else {
				$query = "SELECT a.patient_lastname, a.patient_firstname, b.family_id, b.family_role ".
                                "FROM m_patient a INNER JOIN m_family_members b ON a.patient_id = b.patient_id ".
                                "WHERE a.patient_lastname LIKE '%{$ln}%' AND a.patient_firstname LIKE '%{$fn}%' ORDER BY a.patient_firstname";
			}

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
		function show_search_family_member() {
			if($this->selected_household == '') {
				if(($this->family_id != '') && ($this->household_number == '')) return;
				if(($this->family_id != '') && ($this->household_number != '')) return;
			}
			else {
				//if($this->selected_household != '') return;
			}
			print "<table border=3 bordercolor='black' align='center' width=600>";
                                print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>SEARCH FAMILY MEMBER</th>";
                                print "</tr>";

                                print "<tr>";
                                        print "<td>Lastname: <input type='text' name='household_member_lastname'></input></td>";
					print "<td>Firstname: <input type='text' name='household_member_firstname'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<td align='center' colspan='2'><input type='submit' name='submit_button' value='Search'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<th colspan='2' align='left' bgcolor='CC9900'>SELECT FAMILY MEMBER</th>";
				print "</tr>";

				if(count($this->family_members_info)>0) {
					print "<tr>";
						print "<td colspan='2'>";
						for($i=0; $i<count($this->family_members_info); $i=$i+4) {
							print "<input type='radio' name='family_id' value='".$this->family_members_info[$i+2]."'>".$this->family_members_info[$i].", ".$this->family_members_info[$i+1]." (".$this->family_members_info[$i+3].")</input><br>";
						}
						print "</td>";
					print "</tr>";

					print "<tr>";
						if($this->selected_household == '') {
							print "<td colspan='2' align='center'>".
								"To <i><b>edit a household</b></i>, ".
								"select a family member and then click the 'Edit Household' button. ".
								"<input type='submit' name='submit_button' value='Edit Household'></input></td>";
						}
						else {
							print "<td colspan='2' align='center'>".
								"<input type='submit' name='submit_button' value='Add Family To Household'></input></td>";
						}
					print "</tr>";
				}
                        print "</table>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		/*
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_household_sanitation() {
			print "<table border=3 bordercolor='black' align='center' width=600>";
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
		*/



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function search_household_members() {
			$household_members = array();
			if($this->selected_household == '') return $household_members;

			$query = "SELECT c.patient_lastname, c.patient_firstname, b.family_role, b.family_id ".
				"FROM m_sanitation_household a INNER JOIN m_family_members b ON a.family_id = b.family_id ".
				"INNER JOIN m_patient c ON b.patient_id = c.patient_id ".
				"WHERE a.household_number = ".$this->selected_household." AND b.family_role = 'Head' ORDER BY c.patient_lastname";
			$result = mysql_query($query) or die("Couldn't execute query.");

			while(list($patient_lastname, $patient_firstname, $family_role, $family_id) = mysql_fetch_array($result)) {
				array_push($household_members, $patient_lastname);
				array_push($household_members, $patient_firstname);
				array_push($household_members, $family_role);
				array_push($household_members, $family_id);
			}
			return $household_members;
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function delete_household_member($household_number, $family_id) {
			if(($household_number == '') || ($family_id == '')) return;

			$query = "DELETE FROM m_sanitation_household WHERE household_number = $household_number AND family_id = $family_id ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function household_members_count($household_number) {
			if($household_number == '')  return;

			$query = "SELECT household_number FROM m_sanitation_household WHERE household_number = $household_number ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 12, 2010, JVTolentino
		// This function will create a household table based on 
		// 	household_number.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_household_control() {
			print "<table border=3 bordercolor='black' align='center' width=600>";
                                print "<tr>";
						print "<th align='left' bgcolor='CC9900'>HOUSEHOLD (ID # {$this->household_number})</th>";
				print "</tr>";

				if(($this->family_id == '') && ($this->selected_household == '')) {
					print "<tr><td align='center'>Please select a family first to continue...</td></tr>";
				}
				elseif(($this->family_id != '') && ($this->household_number == '') && ($this->selected_household == '')) {
					print "<tr>";
						print "<td align='center'>Click this button if you're done editing. &nbsp;".
							"<input type='submit' name='submit_button' value='Done Editing'></input>".
							"</td>";
					print "</tr>";

					print "<tr>";
						print "<td align='center'>To <b><i>create a household</i></b> for this family, ".
							"click the 'Create a Household' button. &nbsp;".
							"<input type='submit' name='submit_button' value='Create a Household'></input></td>";
					print "</tr>";
				}
				elseif(($this->family_id != '') && ($this->household_number != '') && ($this->selected_household == '')) {
					print "<tr>";
						print "<td align='center'>Click this button if you're done editing. &nbsp;".
							"<input type='submit' name='submit_button' value='Done Editing'></input>".
                                                        "</td>";
                                        print "</tr>";

					print "<tr>";
                                                print "<td align='center'>To <b><i>select this household</i></b> for editing, ".
                                                        "click the 'Select This Household' button. &nbsp;".
                                                        "<input type='submit' name='submit_button' value='Select This Household'></input></td>";
                                        print "</tr>";
				}
				elseif($this->selected_household != '') {
					print "<tr>";
                                                print "<td align='center'>Click this button if you're done editing. &nbsp;".
                                                        "<input type='submit' name='submit_button' value='Done Editing'></input>".
                                                        "</td>";
                                        print "</tr>";

					$household_members = array();
					$household_members = $this->search_household_members();
					if(count($household_members)>0) {
                                        	print "<tr>";
							print "<td>";
								for($i=0; $i<count($household_members); $i+=4) {
									print "<input type='radio' name='household_member' value='".$household_members[$i+3]."'>".
										$household_members[$i].", ".$household_members[$i+1]." (".
										$household_members[$i+2].")</input><br>";;
								}
						print "</tr>";

						print "<tr>";
							print "<td align='center'>To <b><i>delete a family</i></b> from this household, select a family and ".
								"then click the 'Delete This Family' button. ".
								"<input type='submit' name='submit_button' value='Delete This Family'></input></td>";
                                        	print "</tr>";
					}

					print "<tr>";
						print "<th align='left' bgcolor='CC9900'>INDICATORS</th>";
					print "</tr>";

					print "<tr>";
						list($month, $day, $year) = explode("/", date("m/d/Y"));
						$current_year = $year;
						print "<td><select name='year_inspected'>".
							"<option value='".($current_year-3)."'>".($current_year-3)."</option>".
							"<option value='".($current_year-2)."'>".($current_year-2)."</option>".
							"<option value='".($current_year-1)."'>".($current_year-1)."</option>".
							"<option value='$current_year' selected>$current_year</option>".
							"<option value='".($current_year+1)."'>".($current_year+1)."</option>".
							"</select>".
							" Use the dropdown box on the left to select the <b><i>year of inspection</i></b>.</td.";
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

					print "<tr>";
                                                print "<td>";
                                                        $this->show_disposal_of_solid_waste();
                                                print "</td>";
                                        print "</tr>";

					print "<tr>";
                                                print "<td>";
                                                        $this->show_household_salt_samples();
                                                print "</td>";
                                        print "</tr>";

					print "<tr>";
						print "<td align='center'><input type='submit' name='submit_button' value='Save Household Sanitation'>".
							"</input></td>";
					print "</tr>";
				}

			print "</table>";
		}
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>



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


		// Comment date: Apr 19, 2010. JVTolentino
		// Made a minor adjustment to this function, instead of getting the family id from
		// 	$this->family_id, it will be passed as an argument to this function.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function create_household($household_number, $family_id) {
			if(($household_number == '') || ($family_id == '')) return;
			//$family_id = $this->family_id;
			$userid = $_SESSION['userid'];

			$query = "INSERT INTO m_sanitation_household (household_number, family_id, user_id) ".
				"VALUES($household_number, $family_id, $userid)";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 8, 2010, JVTolentino
		// This function will get the household number of a family
		// 	based on their family id.
		// Comment date: Apr 13, 2010, JVTolentino
		// Simplified this function.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_household_number($family_id) {
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
		function household_submit_button_clicked() {
			switch($_POST['submit_button']) {
				case 'Search':
					$this->family_members_info = $this->search_family_members();
					break;
				case 'Done Editing':
					$this->family_id = '';
					$this->household_number = '';
					$this->selected_household = '';
					break;
				case 'Edit Household':
					if($_POST['family_id'] != '') {
						$this->family_id = $_POST['family_id'];
						$this->household_number = $this->get_household_number($this->family_id);
					}
					break;
				case 'Create a Household':
					$this->household_number = $this->create_household_number();
					$this->create_household($this->household_number, $this->family_id);
					break;
				case 'Select This Household':
					$this->selected_household = $this->household_number;
					break;
				case 'Add Family To Household':
					//print $_POST['family_id'];
					if(($this->selected_household == '') || ($_POST['family_id'] == '')) return;
					$this->create_household($this->selected_household, $_POST['family_id']);
					break;
				case 'Delete This Family':
					if (($this->selected_household == '') || ($_POST['household_member'] == '')) return;
					$this->delete_household_member($this->selected_household, $_POST['household_member']);

					if($this->household_members_count($this->selected_household) == 0) {
						$this->household_number = '';
						$this->family_id = '';
						$this->selected_household = '';
					}
					break;
				case 'Save Household Sanitation':
					// The following codes are used for adding/updating water supply level of a household
					switch($_POST['water_supply']) {
						case 'level_1':
						$water_supply_level = 1;
						break;
					case 'level_2':
						$water_supply_level = 2;
						break;
					case 'level_3':
						$water_supply_level = 3;
						break;
					default:
						$water_supply_level = 0;
						break;
					}

					if($this->water_supply_inspected($this->selected_household, $_POST['year_inspected']) == 0) {
						$this->save_water_supply_level($this->selected_household, $_POST['year_inspected'], $water_supply_level);
					}
					else {
						$this->update_water_supply_level($this->selected_household, $_POST['year_inspected'], $water_supply_level);
					}
					// Code ends here for the previous comment


					// The following codes are used for adding/updating sanitary toilet of a household
					if($this->sanitary_toilet_inspected($this->selected_household, $_POST['year_inspected']) == 0) {
						$this->save_sanitary_toilet($this->selected_household, $_POST['year_inspected'], $_POST['sanitary_toilet']);
					}
					else {
						$this->update_sanitary_toilet($this->selected_household, $_POST['year_inspected'], $_POST['sanitary_toilet']);

					}
					// Code ends here for the previous comment


					// The following codes are used for updating the disposal of solid waste of a household
					if($_POST['disposal_of_solid_waste'] == 'Y') {
						$disposal_of_solid_waste = 'Y';
					}
					else {
						$disposal_of_solid_waste = 'N';
					}
					if($this->disposal_of_solid_waste_inspected($this->selected_household, $_POST['year_inspected']) == 0) {
						$this->save_disposal_of_solid_waste($this->selected_household, $_POST['year_inspected'], $disposal_of_solid_waste);
					}
					else {
						$this->update_disposal_of_solid_waste($this->selected_household, $_POST['year_inspected'], $disposal_of_solid_waste);
					}
					// Code ends here for the previous comment


					// The following codes are used for adding/updating household salt samples
					if($this->household_salt_samples_inspected($this->selected_household, $_POST['year_inspected']) == 0) {
						$this->save_household_salt_samples($this->selected_household, $_POST['year_inspected'], $_POST['household_salt_samples']);
					}
					else {
						$this->update_household_salt_samples($this->selected_household, $_POST['year_inspected'], $_POST['household_salt_samples']);
					}
					// Code ends here for the previous comment



					break;
				default:
					break;
			}
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 14, 2010, JVTolentino
		// In order to maintain the values of all global variables after every submits,
		// 	this function needs to be called (first) every time a new instance
		//	of the module is created. The hidden inputs must be given their values 
		// 	before the new instance is created (at the end of sanitation_household()).
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_global_var() {
			$this->family_id = $_POST['h_family_id'];
			$this->household_number = $_POST['h_household_number'];
			$this->selected_household = $_POST['h_selected_household'];
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 13, 2010, JVTolentino
		// This function is created to make the whole sanitation/household
		//	process be broken down into several stages.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sanitation_household() {
				$this->init_global_var();
				$this->household_submit_button_clicked();
				$this->show_search_family_member();

				print "&nbsp;";
				$this->show_household_control();

				print "<input type='hidden' name='h_family_id' value='".$this->family_id."'></input>";
				print "<input type='hidden' name='h_household_number' value='".$this->household_number."'></input>";
				print "<input type='hidden' name='h_selected_household' value='".$this->selected_household."'></input>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sanitation_establishment() {
			$this->establishment_submit_button_clicked();
			$this->show_create_establishment();
			print "&nbsp;";

			$this->show_search_establishment();
			print "&nbsp;";

			$this->show_establishment_control();


			// The following variable/s will be used to maintain the current values of the next instance's member variable/s.
			print "<input type='hidden' name='h_selected_establishment' value='{$this->selected_establishment}'></input>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function establishment_submit_button_clicked() {
			switch($_POST['submit_button']) {
				case 'Search':
					if($_POST['search_establishment'] == '') break;
					$this->establishments_info = $this->search_establishment($_POST['search_establishment']);
					break;
				case 'Create Establishment':
					if($_POST['new_establishment'] == '') break;
					if($_POST['new_establishment_owner'] == '') break;
					if($_POST['barangay'] == '') break;
					$this->create_establishment($_POST['new_establishment'], $_POST['new_establishment_owner'], $_POST['barangay']);
					break;
				case 'Select This Establishment':
					$this->selected_establishment = $_POST['establishment_id'];
					break;
				case 'Done Editing':
					$this->selected_establishment = '';
					break;
				case 'Save Establishment Sanitation':
					if($this->selected_establishment == '') break;
					if($_POST['name_of_selected_establishment'] == '') break;
					if($_POST['owner_of_selected_establishment'] == '') break;
					$this->update_establishment($this->selected_establishment, $_POST['name_of_selected_establishment'], $_POST['owner_of_selected_establishment']);

					// The following codes are used for adding/updating sanitary permits of a establishment
					if($this->sanitary_permit_inspected($this->selected_establishment, $_POST['year_inspected']) == 0) {
						$this->save_sanitary_permit($this->selected_establishment, $_POST['year_inspected'], $_POST['establishment_sanitary_permit']);
					}
					else {
						$this->update_sanitary_permit($this->selected_establishment, $_POST['year_inspected'], $_POST['establishment_sanitary_permit']);
					}
					// Code ends here for the previous comment


					// The following codes are used for adding/updating food handlers of a establishment
					if($this->food_handlers_inspected($this->selected_establishment, $_POST['year_inspected']) == 0) {
						$this->save_food_handlers($this->selected_establishment, $_POST['year_inspected'], $_POST['food_handlers']);
                                        }
                                        else {
                                                $this->update_food_handlers($this->selected_establishment, $_POST['year_inspected'], $_POST['food_handlers']);
                                        }
					// Code ends here for the previous comment


					// The following codes are used for adding/updating food handlers of a establishment
                                        if($this->food_handlers_with_health_certificates_inspected($this->selected_establishment, $_POST['year_inspected']) == 0) {
                                                $this->save_food_handlers_with_health_certificates($this->selected_establishment, $_POST['year_inspected'], $_POST['food_handlers_with_health_certificates']);
                                        }
                                        else {
                                                $this->update_food_handlers_with_health_certificates($this->selected_establishment, $_POST['year_inspected'], $_POST['food_handlers_with_health_certificates']);
                                        }
                                        // Code ends here for the previous comment


					// The following codes are used for adding/updating establishment salt samples
					if($this->establishment_salt_samples_inspected($this->selected_establishment, $_POST['year_inspected']) == 0) {
						$this->save_establishment_salt_samples($this->selected_establishment, $_POST['year_inspected'], $_POST['establishment_salt_samples']);
					}
					else {
						$this->update_establishment_salt_samples($this->selected_establishment, $_POST['year_inspected'], $_POST['establishment_salt_samples']);
					}
					// Code ends here for the previous comment


					break;

				default:
					break;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_create_establishment() {
			// Exit if there is currently a selected establishment
			if($this->selected_establishment != '') return;

			print "<table border=3 bordercolor='black' align='center' width=600>";
                      		print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>CREATE ESTABLISHMENT</th>";
                                print "</tr>";

				print "<tr>";
					print "<td>Name:</td>";
					print "<td><input type='text' name='new_establishment' size='50'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<td>Owner:</td>";
					print "<td><input type='text' name='new_establishment_owner' size='50'></input></td>";
				print "</tr>";

				$barangays = array();
				$barangays = $this->get_barangays();

				print "<tr>";
					print "<td>Location:</td>";
					print "<td><select name='barangay'>";
						for($i=0; $i<count($barangays); $i+=2) {
							print "<option value='{$barangays[$i]}'>{$barangays[$i+1]}</option>";
						}
					print "</select></td>";
				print "</tr>";

				print "<tr>";
					print "<td align='center' colspan='2'>";
					print "<input type='submit' name='submit_button' value='Create Establishment'></input>";
					print "</td>";
				print "</tr>";

			print "</table>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_barangays() {
			$query = "SELECT barangay_id, barangay_name FROM m_lib_barangay ORDER BY barangay_name";
			$result = mysql_query($query) or die("Couldn't execute query.");

			$barangays = array();
			while(list($barangay_id, $barangay_name) = mysql_fetch_array($result)) {
				array_push($barangays, $barangay_id, $barangay_name);
			}
			return $barangays;
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function create_establishment($name_of_establishment, $owner, $barangay_id) {
			$query = "INSERT INTO m_sanitation_establishment ".
				"(name_of_establishment, owner, barangay_id, user_id) ".
				"VALUES('$name_of_establishment', '$owner', $barangay_id, '{$_SESSION['userid']}')";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_establishment($establishment_id, $name_of_establishment, $owner) {
			$query = "UPDATE m_sanitation_establishment SET ".
				"name_of_establishment = '$name_of_establishment', ".
				"owner = '$owner', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE establishment_id = $establishment_id";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_search_establishment() {
			// Exit if there is a currently selected establishment for editing
			if($this->selected_establishment != '') return;

			print "<table border=3 bordercolor='black' align='center' width=600>";
                      		print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>SEARCH ESTABLISHMENT</th>";
                                print "</tr>";

				print "<tr>";
					print "<td>Name of Establishment: ";
					print "<input type='text' name='search_establishment' size='50'></input>";
					print "<input type='submit' name='submit_button' value='Search'></input>";
					print "</td>";
				print "</tr>";

				if(count($this->establishments_info)) {
					print "<tr>";
						print "<td>";
						for($i=0; $i<count($this->establishments_info); $i+=3) {
							print "<input type='radio' name='establishment_id' ".
								"value='{$this->establishments_info[$i]}'>".
								"{$this->establishments_info[$i+1]} (".
								"{$this->establishments_info[$i+2]})</input>";
							print "<br>";
						}
						print "</td>";
					print "</tr>";

					print "<tr>";
						print "<td align='center'>To <b><i>select a establishment</i></b> for editing, ".
							"select a establishment and click the 'Select This Establishment' button. ";
						print "<input type='submit' name='submit_button' value='Select This Establishment'>".
							"</input></td>";
					print "</tr>";
				}
			
			print "</table>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// Comment date: Apr 26, 2010. JVTolentino
		// This function will return an array with elements in the following order:
		//	1. establishment_id, 2. name_of_establishment, 3. owner.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function search_establishment($name_of_establishment) {
			$query = "SELECT establishment_id, name_of_establishment, owner FROM m_sanitation_establishment ".
				"WHERE name_of_establishment LIKE '%{$name_of_establishment}%' ORDER BY establishment_id ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			$establishment_info = array();
			while(list($establishment_id, $name_of_establishment, $owner) = mysql_fetch_array($result)) {
				array_push($establishment_info, $establishment_id, $name_of_establishment, $owner);
			}
			return $establishment_info;
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_establishment_control() {
			// Exit if there is no selected establishment for editing 
			if($this->selected_establishment == '') return;

			print "<table border=3 bordercolor='black' align='center' width=600>";
                      		print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>ESTABLISHMENT (ID # {$this->selected_establishment})</th>";
                                print "</tr>";

				print "<tr>";
					print "<td align='center' colspan='2'>Click this button if you're done editing. ".
						"<input type='submit' name='submit_button' value='Done Editing'></input></td>";
				print "</tr>";

				$name_of_establishment = $this->get_name_of_establishment($this->selected_establishment);
				print "<tr>";
					print "<td align='center'>Name of Establishment:</td>";
					print "<td align='center'><input type='text' name='name_of_selected_establishment' value='$name_of_establishment' size='50'></input></td>";
				print "</tr>";

				$owner_of_establishment = $this->get_owner_of_establishment($this->selected_establishment);
				print "<tr>";
					print "<td align='center'>Owner of Establishment:</td>";
					print "<td align='center'><input type='text' name='owner_of_selected_establishment' value='$owner_of_establishment' size='50'></input></td>";
				print "</tr>";

				print "<tr>";
					print "<th align='left' colspan='2' bgcolor='CC9900'>INDICATORS</th>";
				print "</tr>";

				print "<tr>";
					list($month, $day, $year) = explode("/", date("m/d/Y"));
					$current_year = $year;
					print "<td colspan='2'><select name='year_inspected'>".
						"<option value='".($current_year-3)."'>".($current_year-3)."</option>".
						"<option value='".($current_year-2)."'>".($current_year-2)."</option>".
						"<option value='".($current_year-1)."'>".($current_year-1)."</option>".
						"<option value='$current_year' selected>$current_year</option>".
						"<option value='".($current_year+1)."'>".($current_year+1)."</option>".
						"</select>".
						" Use the dropdown box on the left to select the <b><i>year of inspection</i></b>.</td.";
				print "</tr>";

				print "<tr>";
					print "<td colspan='2'>";
						$this->show_establishment_sanitary_permit();
					print "</td>";
				print "</tr>";

				print "<tr>";
					print "<td colspan='2'>";
                                                $this->show_establishment_food_handlers();
                                        print "</td>";
                                print "</tr>";

				print "<tr>";
					print "<td colspan='2'>";
                                                $this->show_establishment_food_handlers_with_health_certificates();
                                        print "</td>";
                                print "</tr>";

				print "<tr>";
					print "<td colspan='2'>";
                                                $this->show_establishment_salt_samples();
                                        print "</td>";
                                print "</tr>";

				print "<tr>";
					print "<td colspan='2' align='center'>".
						"<input type='submit' name='submit_button' value='Save Establishment Sanitation'>".
						"</input></td>";
				print "</tr>";

			print "</table>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_establishment_sanitary_permit() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Sanitary Permit</i></b></td>";
                                print "</tr>";

				$last_sanitary_permit = $this->get_last_sanitary_permit($this->selected_establishment);

				print "<tr>";
					if($last_sanitary_permit == 'Y') {
						print "<td><select name='establishment_sanitary_permit'>".
							"<option value='Y' selected>With Sanitary Permit</option>".
							"<option value='N'>Without Sanitary Permit</option>".
							"</select></td>";
					}
					else {
						print "<td><select name='establishment_sanitary_permit'>".
							"<option value='Y'>With Sanitary Permit</option>".
							"<option value='N' selected>Without Sanitary Permit</option>".
							"</select></td>";
					}
					print "<td>Sanitary Permit is a certification in writing of the city or municipal health officer or sanitary engineer that the establishment complies with the existing minimum sanitation requirements upon evaluation or inspection conducted in accordance with Presidential Decrees No. 522 and 856 and local ordinances.</td>";
				print "</tr>";
			print "</table>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_establishment_food_handlers() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Food Handlers</i></b></td>";
                                print "</tr>";

				$food_handlers = $this->get_last_food_handlers($this->selected_establishment);

                                print "<tr>";
					print "<td><select name='food_handlers'>";
						for($i=0; $i<=150; $i++) {
							if($food_handlers == $i) {
								print "<option value='$i' selected>$i Food Handlers</option>";
							}
							else {
								print "<option value='$i'>$i Food Handlers</option>";
							}
						}
					print "</select></td>";

                                        print "<td>Food handlers refer to the total number of food handlers employed in the establishment. A food handler is any person who handles, stores, prepares, serves food, drinks or ice who comes in contact with any eating or cooking utensils and food vending machines.</td>";
                                print "</tr>";
                        print "</table>";
                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                function show_establishment_food_handlers_with_health_certificates() {
                        print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Food Handlers With Health Certificates</i></b></td>";
                                print "</tr>";

				$food_handlers_with_health_certificates = $this->get_last_food_handlers_with_health_certificates($this->selected_establishment);

                                print "<tr>";
                                        print "<td><select name='food_handlers_with_health_certificates'>";
                                                for($i=0; $i<=150; $i++) {
							if($food_handlers_with_health_certificates == $i) {
                                                        	print "<option value='$i' selected>$i Food Handlers</option>";
							}
							else {
								print "<option value='$i'>$i Food Handlers</option>";
							}
                                                }
                                        print "</select></td>";
                                        print "<td>This refers to the total number of food handlers issued health certificates. A health certificates is a certification in writing, using the prescribed form, and issued by the municipal or city health officer to a person after passing the required physical and medical examinations and immunizations.</td>";
                                print "</tr>";
                        print "</table>";
                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_establishment_salt_samples() {
			print "<table border='1' align='left'>";
                                print "<tr>";
                                        print "<td align='left' colspan='2'><i><b>Salt Samples</i></b></td>";
                                print "</tr>";

				$establishment_salt_samples = $this->get_last_establishment_salt_samples($this->selected_establishment);

				print "<tr>";
					switch($establishment_salt_samples) {
						case 'Not Tested':
							print "<td><select name='establishment_salt_samples'>".
                                                		"<option value='Not Tested' selected>Not Tested</option>".
                                                		"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                 	       			"</select></td>";
							break;
						case 'Positive For Iodine':
							print "<td><select name='establishment_salt_samples'>".
                                                		"<option value='Not Tested'>Not Tested</option>".
                                                		"<option value='Positive For Iodine' selected>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                        			"</select></td>";
							break;
						case 'Negative For Iodine':
							print "<td><select name='establishment_salt_samples'>".
                                               		"<option value='Not Tested'>Not Tested</option>".
                                               		 	"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine' selected>(-) for Iodine</option>".
                                      		  		"</select></td>";
							break;
						default:
							print "<td><select name='establishment_salt_samples'>".
                                                		"<option value='Not Tested' selected>Not Tested</option>".
                                                		"<option value='Positive For Iodine'>(+) for Iodine</option>".
                                                		"<option value='Negative For Iodine'>(-) for Iodine</option>".
                                 	       			"</select></td>";
							break;
					}
					
					print "<td>Salt Samples Tested for Iodine. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>";
				print "</tr>";




                        print "</table>";

                }
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<




		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_name_of_establishment($establishment_id) {
			if($establishment_id == '') return;

			$query = "SELECT name_of_establishment FROM m_sanitation_establishment WHERE establishment_id = $establishment_id";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows) {
				$row = mysql_fetch_assoc($result);
				return $row['name_of_establishment'];
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_owner_of_establishment($establishment_id) {
			if($establishment_id == '') return;

			$query = "SELECT owner FROM m_sanitation_establishment WHERE establishment_id = $establishment_id";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows) {
				$row = mysql_fetch_assoc($result);
				return $row['owner'];
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_sanitary_permit($establishment_id, $year_inspected, $sanitary_permit) {
			$query = "INSERT INTO m_sanitation_sanitary_permit (establishment_id, sanitary_permit, year_inspected, user_id) ".
				"VALUES($establishment_id, '$sanitary_permit', $year_inspected, {$_SESSION['userid']}) ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_sanitary_permit($establishment_id, $year_inspected, $sanitary_permit) {
			$query = "UPDATE m_sanitation_sanitary_permit SET ".
				"sanitary_permit = '$sanitary_permit', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE establishment_id = $establishment_id ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_sanitary_permit($establishment_id) {
			$query = "SELECT sanitary_permit FROM m_sanitation_sanitary_permit ".
				"WHERE establishment_id = $establishment_id ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['sanitary_permit'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sanitary_permit_inspected($establishment_id, $year_inspected) {
			if(($establishment_id == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_sanitary_permit ".
				"WHERE establishment_id = $establishment_id AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_food_handlers($establishment_id, $year_inspected, $food_handlers) {
			$query = "INSERT INTO m_sanitation_food_handlers (establishment_id, food_handlers, year_inspected, user_id) ".
				"VALUES($establishment_id, $food_handlers, $year_inspected, {$_SESSION['userid']}) ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_food_handlers($establishment_id, $year_inspected, $food_handlers) {
			$query = "UPDATE m_sanitation_food_handlers SET ".
				"food_handlers = $food_handlers, ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE establishment_id = $establishment_id ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_food_handlers($establishment_id) {
			$query = "SELECT food_handlers FROM m_sanitation_food_handlers ".
				"WHERE establishment_id = $establishment_id ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['food_handlers'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function food_handlers_inspected($establishment_id, $year_inspected) {
			if(($establishment_id == '') || ($year_inspected == '')) return;

			$query = "SELECT food_handlers FROM m_sanitation_food_handlers ".
				"WHERE establishment_id = $establishment_id AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_food_handlers_with_health_certificates($establishment_id, $year_inspected, $food_handlers_with_health_certificates) {
			$query = "INSERT INTO m_sanitation_food_handlers_with_health_certificates (establishment_id, food_handlers_with_health_certificates, year_inspected, user_id) ".
				"VALUES($establishment_id, $food_handlers_with_health_certificates, $year_inspected, {$_SESSION['userid']}) ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_food_handlers_with_health_certificates($establishment_id, $year_inspected, $food_handlers_with_health_certificates) {
			$query = "UPDATE m_sanitation_food_handlers_with_health_certificates SET ".
				"food_handlers_with_health_certificates = $food_handlers_with_health_certificates, ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE establishment_id = $establishment_id ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_food_handlers_with_health_certificates($establishment_id) {
			$query = "SELECT food_handlers_with_health_certificates FROM m_sanitation_food_handlers_with_health_certificates ".
				"WHERE establishment_id = $establishment_id ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['food_handlers_with_health_certificates'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function food_handlers_with_health_certificates_inspected($establishment_id, $year_inspected) {
			if(($establishment_id == '') || ($year_inspected == '')) return;

			$query = "SELECT food_handlers_with_health_certificates FROM m_sanitation_food_handlers_with_health_certificates ".
				"WHERE establishment_id = $establishment_id AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function save_establishment_salt_samples($establishment_id, $year_inspected, $salt_samples) {
			$query = "INSERT INTO m_sanitation_establishment_salt_samples (establishment_id, salt_samples, year_inspected, user_id) ".
                                "VALUES($establishment_id, '$salt_samples', $year_inspected, {$_SESSION['userid']}) ";
                        $result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function update_establishment_salt_samples($establishment_id, $year_inspected, $salt_samples) {
			$query = "UPDATE m_sanitation_establishment_salt_samples SET ".
				"salt_samples = '$salt_samples', ".
				"user_id = {$_SESSION['userid']} ".
				"WHERE establishment_id = $establishment_id ".
				"AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function get_last_establishment_salt_samples($establishment_id) {
			$query = "SELECT salt_samples FROM m_sanitation_establishment_salt_samples ".
				"WHERE establishment_id = $establishment_id ORDER BY year_inspected DESC ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			if(mysql_num_rows($result)) {
				$row = mysql_fetch_assoc($result);
				return $row['salt_samples'];
			}
			else {
				return;
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function establishment_salt_samples_inspected($establishment_id, $year_inspected) {
			if(($establishment_id == '') || ($year_inspected == '')) return;

			$query = "SELECT year_inspected FROM m_sanitation_establishment_salt_samples ".
				"WHERE establishment_id = $establishment_id AND year_inspected = $year_inspected ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_switch_template() {
			print "<table border=3 bordercolor='black' align='center' width=600>";
                                print "<tr>";
                                        print "<th colspan='2' align='left' bgcolor='CC9900'>Switch Template</th>";
                                print "</tr>";

				print "<tr>";
					if($this->current_template == 'Households') {
						print "<td>";
						print "<input type='submit' name='submit_template' value='Switch To Establishments'></input>";
						print "</td>";
					}
					elseif($this->current_template == 'Establishments') {
						print "<td>";
                                                print "<input type='submit' name='submit_template' value='Switch To Households'></input>";
                                                print "</td>";
					}
				
					print "<td>Click the button on the left to switch between 'Sanitation/Household' and 'Sanitation/Establishment'.</td>";
				print "</tr>";
			print "</table>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_template() {
			if($this->current_template == 'Households') {
				$this->sanitation_household();
			}
			else {
				$this->sanitation_establishment();
			}
			print "<input type='hidden' name='h_current_template' value='{$this->current_template}'></input>";
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function switch_template_clicked() {
			if($_POST['h_current_template'] == '') {
				$this->current_template = 'Households';
			}
			elseif($_POST['submit_template'] == 'Switch To Households') {
				$this->current_template = 'Households';
			}
			elseif($_POST['submit_template'] == 'Switch To Establishments') {
				$this->current_template = 'Establishments';
			}
		}
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
			



		// Comment date: Nov 04, '09, JVTolentino
		// This is the main function for the sanitation module.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function _consult_sanitation() {
			print "<form name='form_sanitation' action='$_POST[PHP_SELF]' method='POST'>";
				$sanitation = new sanitation;

				$sanitation->init_primary_keys();

				$sanitation->switch_template_clicked();

				$sanitation->show_switch_template();
				print "&nbsp;";

				$sanitation->init_template();
			print "</form>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
	} // class ends here
?>
