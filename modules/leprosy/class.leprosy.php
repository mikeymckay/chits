<?
	class leprosy extends module {
		// Author: Herman Tolentino MD
		// CHITS Project 2004
		
		// LEPROSY CONTROL PROGRAM MODULE
		
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
		function leprosy() {
			$this->author = "Jeffrey V. Tolentino";
			$this->version = "0.1-".date("Y-m-d");
			$this->module = "leprosy";
			$this->description = "CHITS Module - Leprosy Control Program";  
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Oct 21, '09, JVTolentino
		// This function is somehow needed by the healthcenter class, the reason 
		//    is unknown.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function _details_leprosy() {
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
			
			print_r($arg_list);
			
			// set_menu parameters
			// set_menu([module name], [menu title - what is displayed], menu categories (top menu)], [script executed in class])
			//module::set_menu($this->module, "Dental Records", "PATIENTS", "_consult_dental");
			// set_detail parameters
			// set_detail([module description], [module version], [module author], [module name/id]
			module::set_detail($this->description, $this->version, $this->author, $this->module);
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// Comment date: Oct 7, 2009, JVTolentino
		// The init_sql() function starts here.
		// This function will initialize the tables for the Leprosy Module in Chits DB.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function init_sql() {
			if (func_num_args()>0) {
			$arg_list = func_get_args();
			}
			
			module::execsql("CREATE TABLE IF NOT EXISTS `m_leprosy_diagnosis` (".
				"`record_number` float NOT NULL AUTO_INCREMENT,".
				"`consult_id` float NOT NULL,".
				"`patient_id` float NOT NULL,".
				"`date_of_diagnosis` date NOT NULL,".
				"`patient_case` char(8) COLLATE swe7_bin NOT NULL,".
				"`classification` char(4) COLLATE swe7_bin NOT NULL,".
				"`mode_of_detection` char(25) COLLATE swe7_bin NOT NULL,".
				"`date_last_updated` date NOT NULL,".
				"`user_id` float NOT NULL,".
				"PRIMARY KEY (`record_number`)".
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
			module::execsql("DROP TABLE `m_leprosy_diagnosis`");
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// Comment date: Jan 19, 2010, JVTolentino
		// The succeeding codes and functions will be used exclusively(??) for
		//    the 'CHITS - LEPROSY CONTROL PROGRAM MODULE'. These codes
		//    are open-source, so feel free to modify, enhance, and distribute
		//    as you wish.
		// Some codes, especially thosed used for the required functions were copied
		//    from the dental module and pasted here, thus, the comment dates on those
		// 	functions.
		// Start date: Jan 19, 2010, JVTolentino
		// End date: under construction
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Jan 26, 2010, JVTolentino
		// This function will outline the NLCP Form 1 located at pp. 68-69 of the Manual of Procedures -
		// 	National Leprosy Control Program of the Department of Health.
		// The MoP was given by Dra. Lazatin of the Provincial Health Office after an interview
		// 	regarding the Leprosy Program of DOH.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_NLCPForm1() {
			$this->create_diagnosis_table();
			
			print "<br>";
			
			print "<table border=3 bordercolor='black' align='center' width=600>";
				print "<tr>";
					print "<th align='left' colspan=2 bgcolor=#CC9900#>Past History</th>";          
				print "</tr>";
				
				print "<tr>";
					print "<td colspan=2><b>Leprosy:</b></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td align=center>Treatment Received</td>";
					print "<td align=center>Duration of Treatment</td>";
				print "</tr>";
				
				print "<tr>";
					print "<td>Dapsone Monotherapy</td>";
					print "<td align='center'>".
						"<input type='text' name='duration_of_treatment_dapson_monotherapy' ".
						"size='40'></input></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td>WHO - Multi Drug Therapy</td>";
					print "<td align='center'>".
						"<input type='text' name='duration_of_treatment_who' ".
						"size='40'></input></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td>ROM Therapy</td>";
					print "<td align='center'>".
						"<input type='text' name='duration_of_treatment_rom' ".
						"size='40'></input></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td>Other MDT Regimen</td>";
					print "<td align='center'>".
						"<input type='text' name='duration_of_treatment_other_mdt' ".
						"size='40'></input></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td colspan=2><b>Other Illnesses:</b></td>";
				print "</tr>";
				
				print "<tr>";
					print "<td colspan=2>".
						"<input type='checkbox' name='other_illnesses_tb' value='tb'>TB</input><br>".
						"<input type='checkbox' name='other_illnesses_severe_jaundice' ".
						"value='severe_jaundice'>Severe Jaundice</input><br>".
						"<input type='checkbox' name='other_illnesses_peptic_ulcer' ".
						"value='peptic_ulcer'>Peptic Ulcer</input><br>".
						"<input type='checkbox' name='other_illnesses_kidney_disease' ".
						"value='kidney_disease'>Kidney Disease</input><br>".
						"Type other illnesses on the space provided below:<br>".
						"<input type='text' name='other_illnesses_text' size='70'></input><br>".
						"</td>";
				print "</tr>";
			print "</table>";
			
			
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Jan 27, 2010, JVTolentino
		// This function will printout on the page a table of the patient's diagnosis.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function create_diagnosis_table() {
			$loc_consult_id = $_GET['consult_id'];
			$loc_patient_id = healthcenter::get_patient_id($_GET['consult_id']);
				
			$query = "SELECT * FROM m_leprosy_diagnosis WHERE ".
				"consult_id = $loc_consult_id AND ".
				"patient_id = $loc_patient_id ";
			$result = mysql_query($query)
				or die ("Couldn't execute query.");
				
			if($row = mysql_fetch_assoc($result)) {
				list($year, $month, $day) = explode("-", $row['date_of_diagnosis']);
				$loc_date_of_diagnosis = str_pad($month, 2, "0", STR_PAD_LEFT)."/".str_pad($day, 2, "0", STR_PAD_LEFT)."/".$year;
				
				$loc_patient_case = $row['patient_case'];
				$loc_classification = $row['classification'];
				$loc_mode_of_detection = $row['mode_of_detection'];
				
				list($year, $month, $day) = explode("-", $row['date_last_updated']);
				$loc_date_last_updated = str_pad($month, 2, "0", STR_PAD_LEFT)."/".str_pad($day, 2, "0", STR_PAD_LEFT)."/".$year;
				$loc_userid = $row['user_id'];
				$loc_updated = 'Y';
			}
			else {
				$loc_date_of_diagnosis = date("m/d/Y");
				$loc_patient_case = "";
				$loc_classification = "";
				$loc_mode_of_detection = "";
				$loc_date_last_updated = date("m/d/Y");
				$loc_userid = "";
				$loc_updated = 'N';
			}
				
			print "<table border=3 bordercolor='black' align='center' width=600>";
				print "<tr>";
					if($loc_updated == 'Y') {
						print "<th align='left' bgcolor=#CC9900#>Diagnosis</th>";
						print "<th align='left' bgcolor=#CC9900#>".
							"<font color='red'>Patient was diagnosed on $loc_date_of_diagnosis.".
							"<br>This section has been updated last $loc_date_last_updated.</font></th>";
					}
					else {
						print "<th align='left' bgcolor=#CC9900#>Diagnosis</th>";
						print "<th align='left' bgcolor=#CC9900#>".
							"<font color='red'>This section has never been updated before.".
							"<br>Click the 'Save Diagnosis' button to update this section.</font></th>";
					}
				print "</tr>";
					
				print "<tr>";
					print "<td align='center' width='150'>";
						if($_POST['date_of_diagnosis'] == '') {
							print "<input type='text' name='date_of_diagnosis' ".
								"readonly='true' size=10 value='$loc_date_of_diagnosis'".
								"<a href=\"javascript:show_calendar4('document.form_leprosy.date_of_diagnosis', ".
								"document.form_leprosy.date_of_diagnosis.value);\">".
								"<img src='../images/cal.gif' width='16' height='16' border='0' ".
								"alt='Click Here to Pick up the Date'></a></input>";
						} 
						else {
							print "<input type='text' name='date_of_diagnosis' ".
								"readonly='true' size=10 value='".$_POST['date_of_diagnosis'].
								"'> <a href=\"javascript:show_calendar4('document.form_leprosy.date_of_diagnosis', ".
								"document.form_leprosy.date_of_diagnosis.value);\">".
								"<img src='../images/cal.gif' width='16' height='16' border='0' ".
								"alt='Click Here to Pick up the Date'></a></input>";
						}
					print "</td>";
					print "<td> Click the image on the left to change the date of diagnosis.</td>";
				print "</tr>";
				
				if($loc_patient_case == 'New Case') {
					print "<tr>";
						print "<td width='150'></td>";
						print "<td>".
							"<input type='radio' name='patient_case' value='New Case' checked>".
							"<font color='red'>New Case <br></font>".
							"<input type='radio' name='patient_case' value='Old Case'>".
							"Old Case</td>";
					print "</tr>";
				}
				else {
					print "<tr>";
						print "<td width='150'></td>";
						print "<td>".
							"<input type='radio' name='patient_case' value='New Case'>".
							"New Case <br>".
							"<input type='radio' name='patient_case' value='Old Case' checked>".
							"<font color='red'>Old Case</font></td>";
					print "</tr>";
				}
				
				if($loc_classification == 'SLPB') {
					print "<tr>";
					print "<td width='150' align='center'><i><b>CLASSIFICATION</i></b></td>";
					print "<td>".
						"<input type='radio' name='classification' value='SLPB' checked>".
						"<font color='red'>SLPB</font><br>".
						"<input type='radio' name='classification' value='PB'>".
						"PB<br>".
						"<input type='radio' name='classification' value='MB'>".
						"MB</td>";
					print "</tr>";
					}
				elseif($loc_classification == 'PB') {
					print "<tr>";
					print "<td width='150' align='center'><i><b>CLASSIFICATION</i></b></td>";
					print "<td>".
						"<input type='radio' name='classification' value='SLPB'>".
						"SLPB <br>".
						"<input type='radio' name='classification' value='PB' checked>".
						"<font color='red'>PB</font><br>".
						"<input type='radio' name='classification' value='MB'>".
						"MB</td>";
					print "</tr>";
				}
				else {
					print "<tr>";
					print "<td width='150' align='center'><i><b>CLASSIFICATION</i></b></td>";
					print "<td>".
						"<input type='radio' name='classification' value='SLPB'>".
						"SLPB<br>".
						"<input type='radio' name='classification' value='PB'>".
						"PB<br>".
						"<input type='radio' name='classification' value='MB' checked>".
						"<font color='red'>MB</font></td>";
					print "</tr>";
				}
				
				if($loc_mode_of_detection == 'Voluntary') {
					print "<tr>";
						print "<td width='150' align='center'><i><b>MODE<br>".
							"OF<br>".
							"DETECTION</b></i></td>";
						print "<td>".
							"<input type='radio' name='mode_of_detection' value='Voluntary' checked>".
							"<font color='red'>Voluntary</font><br>".
							"<input type='radio' name='mode_of_detection' value='Special Projects'>".
							"Special Projects<br>".
							"<input type='radio' name='mode_of_detection' value='Contact Examination'>".
							"Contact Examination</td>";
					print "</tr>";
				}
				elseif($loc_mode_of_detection == 'Special Projects') {
					print "<tr>";
						print "<td width='150' align='center'><i><b>MODE<br>".
							"OF<br>".
							"DETECTION</b></i></td>";
						print "<td>".
							"<input type='radio' name='mode_of_detection' value='Voluntary'>".
							"Voluntary<br>".
							"<input type='radio' name='mode_of_detection' value='Special Projects' checked>".
							"<font color='red'>Special Projects</font><br>".
							"<input type='radio' name='mode_of_detection' value='Contact Examination'>".
							"Contact Examination</td>";
					print "</tr>";
				}
				else {
					print "<tr>";
						print "<td width='150' align='center'><i><b>MODE<br>".
							"OF<br>".
							"DETECTION</b></i></td>";
						print "<td>".
							"<input type='radio' name='mode_of_detection' value='Voluntary'>".
							"Voluntary<br>".
							"<input type='radio' name='mode_of_detection' value='Special Projects'>".
							"Special Projects<br>".
							"<input type='radio' name='mode_of_detection' value='Contact Examination' checked>".
							"<font color='red'>Contact Examination</font></td>";
					print "</tr>";
				}
				
				print "<tr>";
					print "<td colspan=2 align='center'><input type='submit' name='submit_button' ".
						"value='Save Diagnosis'></input></td>";
				print "</tr>";
			print "</table>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Jan 27, 2010, JVTolentino
		// This function will be used to add or update a record in [m_leprosy_diagnosis].
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function diagnosis_record() {
			$loc_patient_id = $_POST['h_patient_id'];
			$loc_consult_id = $_POST['h_consult_id'];
			$loc_userid = $_POST['h_userid'];
			//$loc_date_of_diagnosis = $_POST['date_of_diagnosis'];
			list($month, $day, $year) = explode("/", $_POST['date_of_diagnosis']);
			$loc_date_of_diagnosis = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
			$loc_patient_case = $_POST['patient_case'];
			$loc_classification = $_POST['classification'];
			$loc_mode_of_detection = $_POST['mode_of_detection'];
			list($month, $day, $year) = explode("/", date("m/d/Y"));
			$loc_current_date = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
			
			$query = "SELECT consult_id, patient_id FROM m_leprosy_diagnosis WHERE ".
				"consult_id = $loc_consult_id AND ".
				"patient_id = $loc_patient_id ";
			$result = mysql_query($query)
				or die("Couldn't execute query. ".mysql_error());
			
			if(mysql_num_rows($result)) {
				$query = "UPDATE m_leprosy_diagnosis SET ".
					"date_of_diagnosis = '$loc_date_of_diagnosis', ".
					"patient_case = '$loc_patient_case', ".
					"classification = '$loc_classification', ".
					"mode_of_detection = '$loc_mode_of_detection', ".
					"date_last_updated = '$loc_current_date', ".
					"user_id = $loc_userid ".
					"WHERE consult_id = $loc_consult_id AND ".
					"patient_id = $loc_patient_id ";
				$result = mysql_query($query)
					or die("Couldn't execute query. ".mysql_error());
			}
			else {
				$query = "INSERT INTO m_leprosy_diagnosis ".
					"(consult_id, patient_id, date_of_diagnosis, patient_case, classification, ".
					"mode_of_detection, date_last_updated, user_id) ".
					"VALUES($loc_consult_id, $loc_patient_id, '$loc_date_of_diagnosis', '$loc_patient_case', ".
					"'$loc_classification', '$loc_mode_of_detection', '$loc_current_date', $loc_userid) ";
				$result = mysql_query($query)
					or die("Couldn't execute query. ".mysql_error());
			}
			
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// Comment date: Jan 27, 2010, JVTolentino
		// This function will be used to add records to 'Leprosy Module Tables' in CHITS DB.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function new_leprosy_record() {
			
			switch($_POST['submit_button']) {
				case 'Save Diagnosis':
					$this->diagnosis_record();
					break;
			}
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    
		// Comment date: Nov 04, '09, JVTolentino
		// This is the main function for the leprosy module.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function _consult_leprosy() {
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
					
					print "&nbsp;";
					$leprosy->show_NLCPForm1();
				
				} 
				else {
					print "&nbsp;";
					$leprosy->show_NLCPForm1();
					
				}
				
				echo "<input type='hidden' name='h_save_flag' value='GO'></input>";
			echo "</form>";
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
	} // class ends here
?>
