<?php
	session_start();

	ob_start();

	require('./fpdf/fpdf.php');

	$db_conn = mysql_connect("localhost","$_SESSION[dbuser]","$_SESSION[dbpass]");
	mysql_select_db($_SESSION[dbname]);

	// Author: Jeffrey V. Tolentino
	// Report Version: 1.0
	// Description: Dental - Target Client List
	// Version Released: Mar 2010
	
	
	// Comment date: Jan 05, 2010, JVTolentino
   	// The following are member functions of the PDF class. These functions are needed
	// 	for the basic operations of the class. DO NOT DELETE OR MODIFY THESE FUNCTIONS
	//	UNLESS, OF COURSE, YOU KNOW WHAT YOU'RE DOING ^^.
   	// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// 1. function SetWidths($w)
		// 2. function SetAligns($a)
		// 3. function Row($data)
		// 4. function CheckPageBreak($h)
		// 5. function NbLines($w,$txt)
		// 6. function Header()
		// 7. function Footer()
		// 8. function show_dental_tcl()  	>> the main function used in showing the report
	// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	
	

	class PDF extends FPDF {
		var $widths;
		var $aligns;
		var $page;	
		
		
		
		function SetWidths($w) {
			//Set the array of column widths
			$this->widths=$w;
		}
		
		
		
		function SetAligns($a) {
			//Set the array of column alignments
			$this->aligns=$a;
		}
		
		
		
		function Row($data) {
			//Calculate the height of the row
			$nb=0;
			for($i=0;$i<count($data);$i++)
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=5*$nb;
			
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++) {
				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C'; //sets the alignment of text inside the cell
				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
				//Draw the border
				$this->Rect($x,$y,$w,$h);
				//Print the text
				$this->MultiCell($w,5,$data[$i],0,$a);
				//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			//Go to the next line
			$this->Ln($h);
		}
		
		
		
		function CheckPageBreak($h) {
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}
		
		
		
		function NbLines($w,$txt) {
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb) {
				$c=$s[$i];
				if($c=="\n") {
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax) {
					if($sep==-1) {
						if($i==$j)
							$i++;
					}
					else
						$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}
		
		
		
		function Header() {
			$m1 = explode('/',$_SESSION[sdate_orig]);
			$m2 = explode('/',$_SESSION[edate_orig]);
			
			$date_label = ($m1[0]==$m2[0])?$_SESSION[months][$m1[0]].' '.$m1[2]:$_SESSION[months][$m1[0]].' to '.$_SESSION[months][$m2[0]].' '.$m1[2];
			
			$municipality_label = $_SESSION[datanode][name];
			
			$this->SetFont('Arial','B',12);
			
			$this->Cell(0,5, 'Target Client List for Dental Health Care Program ('.$_SESSION[sdate_orig].' to '.$_SESSION[edate_orig].')',0,1,'C');
			
			if($_SESSION[brgy] == 'all' || $_SESSION[brgy] == 'All') {
				$brgy_label = 'All Barangays';
			}
			else {
				$brgy_name = mysql_query("SELECT barangay_name FROM m_lib_barangay WHERE barangay_id='$_SESSION[brgy]'")
					or die("Couldn't execute query.");
				list($brgy_label) = mysql_fetch_array($brgy_name);
			}
			
			$this->SetFont('Arial','',10);
 
			$this->Cell(0,5, $brgy_label, 0, 1, 'C');
			$this->Cell(0,5,$_SESSION[datanode][name],0,1,'C');
			$this->Cell(0,5,'Province of '.$_SESSION[province],0,1,'C');

			$w = array(10,70,20,20,70,25,25,70,30); //340
			$header = array('#', 'Name', 'Age', 'Sex', 'Address', 'No. of df Teeth', 'No. of MDF Teeth', 'Service Acquired (Tooth Number)', 'Date of Oral');
			
			$this->SetWidths($w);
			$this->Row($header);
		}
		
		
		
		function Footer() {
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
		}



		// Comment date: Mar 05, 2010. JVTolentino
		// Because m_dental_patient_ohc doesn't have an age column, I need to calculate the patient's age
		// 	based on patient_dob (m_patient) and date_of_oral (m_dental_patient_ohc).
		// The following codes were taken from the following website, thanks to the author. I just made
		// 	made some minor modifications to suit my needs. Note: the gregoriantojd() function needs
		//	the date parts in the following order: month, day, year.
		// http://www.developertutorials.com/tutorials/php/calculating-difference-between-dates-php-051018/page1.html
		function dateDiff($dformat, $endDate, $beginDate) {
			$date_parts1=explode($dformat, $beginDate);
			$date_parts2=explode($dformat, $endDate);
			$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
			$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
			return $end_date - $start_date;
		} // end of function



		// Comment date: Mar 08, 2010. JVTolentino
		// This function is an attempt to modularize show_dental_tcl(). It will be used to
		//	get the patient's services acquired. Instead of putting these
		// 	codes in show_dental_tcl(), I decided to do it here. This function will
		// 	return an array of services acquired.
		// Note: This function will return all services in m_dental_services except OP and FL.
		function get_services_acquired($consult_id) {
			$query = "SELECT tooth_number, service_provided FROM m_dental_services WHERE ".
				"consult_id = $consult_id AND ".
				"(service_provided <> 'OP' AND service_provided <> 'FL')";
			$result = mysql_query($query) or die("Couldn't execute query.");

			$services = array();
			while(list($tn, $sp) = mysql_fetch_array($result)) {
				array_push($services, $tn, $sp);
			}

			return $services;
		} // end of function



		// Comment date: Mar 08, 2010. JVTolentino
		// This function will determine whether the patient acquired a certain service during
		// 	his/her consultation (based on the argument provided to the function)
		// 	This function will return 'Y' if the patient acquired
		// 	it, otherwise none will be returned.
		function patient_got_service($consult_id, $service) {
			if($service == '') return;

			$query = "SELECT service_provided FROM m_dental_services WHERE ".
				"consult_id = $consult_id AND ".
				"service_provided = '$service'";
			$result = mysql_query($query) or die("Couldn't execute query.");
		
			if(mysql_num_rows($result)) return 'Y';
		} // end of function



		function show_dental_tcl() {
			list($month, $day, $year) = explode("/", $_SESSION[sdate_orig]);
			$start = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
			list($month, $day, $year) = explode("/", $_SESSION[edate_orig]);
			$end = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);

			$ctr = 1;
			$w = array(10,70,20,20,70,25,25,70,30); //340
			$this->SetWidths($w);

			if($_SESSION[brgy] == 'All' || $_SESSION[brgy] == 'all') {
				$patients = "SELECT DISTINCT a.consult_id, b.patient_lastname, b.patient_firstname, b.patient_middle, b.patient_gender, ".
					"b.patient_dob, a.date_of_oral, d.address, e.barangay_name ".
					"FROM m_dental_patient_ohc a INNER JOIN m_patient b on a.patient_id = b.patient_id ".	// lastname, firstname, middle
                                        "INNER JOIN m_family_members c ON b.patient_id = c.patient_id ".                        // to get the family id in order
                                        "INNER JOIN m_family_address d ON c.family_id = d.family_id ".                          // to get the family address
                                        "INNER JOIN m_lib_barangay e ON d.barangay_id = e.barangay_id ".                        // and then family barangay
                                        "WHERE (a.date_of_oral >= '$start' AND a.date_of_oral <= '$end') ORDER BY a.date_of_oral";
			}
			else {
				$patients = "SELECT DISTINCT a.consult_id, b.patient_lastname, b.patient_firstname, b.patient_middle, b.patient_gender, ".
					"b.patient_dob, a.date_of_oral, d.address, e.barangay_name ".
					"FROM m_dental_patient_ohc a INNER JOIN m_patient b on a.patient_id = b.patient_id ".	// lastname, firstname, middle
                                        "INNER JOIN m_family_members c ON b.patient_id = c.patient_id ".                        // to get the family id in order
                                        "INNER JOIN m_family_address d ON c.family_id = d.family_id ".                          // to get the family address
                                        "INNER JOIN m_lib_barangay e ON d.barangay_id = e.barangay_id ".                        // and then family barangay
                                        "WHERE (a.date_of_oral >= '$start' AND a.date_of_oral <= '$end') AND ".
					"e.barangay_id = '$_SESSION[brgy]' ORDER BY a.date_of_oral";
			}

			$result = mysql_query($patients) or die("Couldn't execute query.");
                        $ctr = 1;

			while(list($consult_id, $ln, $fn, $mn, $patient_gender, $patient_dob, $patient_date_of_oral, $address, $barangay) = mysql_fetch_array($result)) {
                                $patient_name = $ln.", ".$fn." ".$mn;
				//$patient_age = $this->dateDiff("-", $patient_date_of_oral, $patient_dob)/365;
				$patient_age = round($this->dateDiff("-", $patient_date_of_oral, $patient_dob)/365, 0);
				$patient_address = $address.", ".$barangay;


				// the following codes will be used to get the patient's df teeth
				$df_query = "SELECT patient_id FROM m_dental_patient_ohc WHERE ".
					"consult_id = $consult_id AND ".
					"(tooth_condition = 'd' OR tooth_condition = 'f')";
				$df_result = mysql_query($df_query) or die("Couldn't execute query");

				$df_teeth = mysql_num_rows($df_result);


				// the following codes will be used to get the patient's MDF teeth
				$MDF_query = "SELECT patient_id FROM m_dental_patient_ohc WHERE ".
					"consult_id = $consult_id AND ".
					"(tooth_condition = 'M' OR tooth_condition = 'D' OR tooth_condition = 'F')";
				$MDF_result = mysql_query($MDF_query) or die("Couldn't execute query");

				$MDF_teeth = mysql_num_rows($MDF_result);


				// the following codes will determine if the patient had an OP.
				if($this->patient_got_service($consult_id, 'OP')) $services = 'Oral Prophylaxis';


				// the following codes will determine if the patient had an FL
				if($this->patient_got_service($consult_id, 'FL')) {
					if($services == '') {
						$services = 'Fluoride';
					}
					else {
						$services = $services.', Fluoride';
					}
				}


				// the following codes will get the services acquired by the patient.
				$services_arr = $this->get_services_acquired($consult_id);
				for($i=0; $i<count($services_arr); $i+=2) {
					if($services == '') {
						$services = $services_arr[$i+1].'('.$services_arr[$i].')';
					}
					else {
						$services = $services.', '.$services_arr[$i+1].'('.$services_arr[$i].')';
					}
				}
				

				$row_contents = array($ctr, $patient_name, $patient_age, $patient_gender, $patient_address, $df_teeth, $MDF_teeth, $services, $patient_date_of_oral);
                                $this->Row($row_contents);
				// reset $services
				$services = '';
                                $ctr++;
			}
		} // end of function


	
		function compute_indicators() {
			if(func_num_args() > 0) {
				$arg_list = func_get_args();
				$crit = $arg_list[0];
				$header = $arg_list[1];
			}
			
			
			
		}
		
		
		
		function get_max_month($date) {
			list($taon,$buwan,$araw) = explode('-',$date);
			$max_date = date("n",mktime(0,0,0,$buwan,$araw,$taon)); //get the unix timestamp then return month without trailing 0
			return $max_date;
		}
		
		
		
		function disp_blank_header($header_title,$target){
			$header = array(30,18,9,9,9,9,9,9,8,7,9,9,9,9,9,9,8,7,9,9,9,9,9,9,8,7,9,9,9,9,9,9,8,7,9,9);
			$this->SetWidths($header);
			$disp_arr = array($header_title,$target);
			for($x=0;$x<35;$x++) {
				array_push($disp_arr,'');
			}				
			$this->Row($disp_arr);
		}
		
		
		/*	
		function get_brgy_pop() {
			list($taon,$buwan,$araw) = explode('-',$_SESSION[edate2]);
			if(in_array('all',$_SESSION[brgy])):
				$q_brgy_pop = mysql_query("SELECT SUM(population) FROM m_lib_population WHERE population_year='$taon'") or die("Cannot query: 286");
			else:
				$str = implode(',',$_SESSION[brgy]);
				$q_brgy_pop = mysql_query("SELECT SUM(population) FROM m_lib_population WHERE population_year='$taon' AND barangay_id IN ($str)") or die("Cannot query: 372");
			endif;	

			if(mysql_num_rows($q_brgy_pop)!=0):
				list($populasyon) = mysql_fetch_array($q_brgy_pop);
			endif;		
			
			return $populasyon;
		}
		
		
		
		function get_quarterly_total($r_month,$target) {
			$q_total = array();
			$counter = 0;
			
			for($i=1;$i<=4;$i++) {
				//$sum = $r_month[$i+$counter] + $r_month[$i+$counter+1] + $r_month[$i+$counter+2];
				$q_total[$i] = $r_month[$i+$counter] + $r_month[$i+$counter+1] + $r_month[$i+$counter+2];
				//$q_total[$i] = round(($sum/$target),3)*100;
				$counter+=2;
			}
			return $q_total;
		}
		
		
		
		function get_target($criteria){
			if($criteria>=0 && $criteria<=2):
				$perc = '0.027';
			else:
				
			endif;
			return $perc;
		}
		
		
		
		function get_brgy_array(){
			$mga_brgy = array();
			if(in_array('all',$_SESSION[brgy])):
				$q_brgy = mysql_query("SELECT barangay_id FROM m_lib_barangay ORDER by barangay_id ASC") or die("Cannot query: 448");
				while(list($b_id)=mysql_fetch_array($q_brgy)){
					array_push($mga_brgy,$b_id);
				}
				return $mga_brgy;
			else:
				return $_SESSION[brgy];
			endif;	
		}
		
		
		
		function get_px_brgy() {
			if(func_num_args()>0):
				$arg_list = func_get_args();
				$pxid = $arg_list[0];
				$str = $arg_list[1];
			endif;
			
			$q_px = mysql_query("SELECT a.barangay_id FROM m_family_address a, m_family_members b WHERE b.patient_id='$pxid' AND b.family_id=a.family_id AND a.barangay_id IN ($str)") or die("cannot query :1061");
		
			if(mysql_num_rows($q_px)!=0):
				return 1;
			else:
				return ;
			endif;
		}
		*/
		
		
	} // end of class

	$pdf = new PDF('L','mm','Legal');
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->show_dental_tcl();

	$pdf->Output();
?>
