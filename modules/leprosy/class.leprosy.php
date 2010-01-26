<?
	class leprosy extends module {
		// Author: Herman Tolentino MD
		// CHITS Project 2004
		
		// LEPROSY PROGRAM MODULE
		
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
			$this->description = "CHITS Module - Leprosy Program";  
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
			
			
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// Comment date: Oct 13, 2009, JVTolentino
		// The drop_tables() function starts here.
		// This function will be used to drop tables from CHITS DB.
		// This function will be executed if the user opts to delete
		//    the tables associated with this module.
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function drop_tables() {
		
		}
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// Comment date: Jan 19, 2010, JVTolentino
		// The succeeding codes and functions will be used exclusively(??) for
		//    the 'CHITS - LEPROSY PROGRAM MODULE'. These codes
		//    are open-source, so feel free to modify, enhance, and distribute
		//    as you wish.
		// Some codes, especially thosed used for the required functions were copied
		//    from the dental module and pasted here, thus, the comment dates on those
		// 	functions.
		// Start date: Jan 19, 2010, JVTolentino
		// End date: under construction
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		
		
		
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function show_NLCPForm1() {
			print "<table border=3 bordercolor='red' align='center' width=600>";
				print "<tr>";
					print "<th align='left' colspan=2 bgcolor=#CC9900#>Diagnosis</th>";          
				print "</tr>";
       
				print "<tr>";
					print "<td align='center' width='150'>";
						if($_POST['date_of_diagnosis'] == '') {
							print "<input type='text' name='date_of_diagnosis' ".
								"readonly='true' size=10 value='".date("m/d/Y").
								"'> <a href=\"javascript:show_calendar4('document.form_leprosy.date_of_diagnosis', ".
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
				
				print "<tr>";
					print "<td width='150'></td>";
					print "<td>".
						"<input type='radio' name='patient_case' value='new_case' checked>".
						"New Case <br>".
						"<input type='radio' name='patient_case' value='old_case'>".
						"Old Case</td>";
				print "</tr>";
				
				print "<tr>";
					print "<td width='150' align='center'><i><b>CLASSIFICATION</i></b></td>";
					print "<td>".
						"<input type='radio' name='classification' value='slpb' checked>".
						"SLPB <br>".
						"<input type='radio' name='classification' value='pb'>".
						"PB <br>".
						"<input type='radio' name='classification' value='mb'>".
						"MB</td>";
				print "</tr>";
				
				print "<tr>";
					print "<td width='150' align='center'><i>MODE<br>".
						"OF<br>".
						"DETECTION</i></td>";
					print "<td>".
						"<input type='radio' name='mode_of_detection' value='voluntary' checked>".
						"Voluntary <br>".
						"<input type='radio' name='mode_of_detection' value='special_projects'>".
						"Special Projects <br>".
						"<input type='radio' name='mode_of_detection' value='contact_examination'>".
						"Contact Examination</td>";
				print "</tr>";
			print "</table>";
			
			print "<br>";
			
			print "<table border=2 align='center' width=600>";
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
						"<input type='text' name='other_illnesses_text' size='80'></input><br>".
						"</td>";
				print "</tr>";
			print "</table>";
			
			print "<br>";
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
				$leprosy->patient_age = healthcenter::get_patient_age($_GET['consult_id']);
				$leprosy->userid = $_SESSION['userid'];
				
				//The following codes will initialize hidden textboxes and their values
				echo "<input type='hidden' name='h_consult_id' value='{$leprosy->consult_id}'></input>";
				echo "<input type='hidden' name='h_patient_id' value='{$leprosy->patient_id}'></input>";
				echo "<input type='hidden' name='h_userid' value='{$leprosy->userid}'></input>";
				
				if (@$_POST['h_save_flag'] == 'GO') {
				
				
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
