<?php

	session_start();

	ob_start();

	require('./fpdf/fpdf.php');

	$db_conn = mysql_connect("localhost","$_SESSION[dbuser]","$_SESSION[dbpass]");
	mysql_select_db($_SESSION[dbname]);
	
	
	
	// Comment date: Jan 05, 2010, JVTolentino
   	// The following are member functions of the PDF class. These functions are needed
	// 	for the basic operations of the class. DO NOT DELETE OR MODIFY THESE FUNCTIONS
	//		UNLESS, OF COURSE, YOU KNOW WHAT YOU'RE DOING ^^.
   	// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// 1. function SetWidths($w)
		// 2. function SetAligns($a)
		// 3. function Row($data)
		// 4. function CheckPageBreak($h)
		// 5. function NbLines($w,$txt)
		// 6. function Header()
		// 7. function Footer()
		// 8. function show_leprosy_summary()  	>> the main function used in showing the report
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
			$q_pop = mysql_query("SELECT SUM(population) FROM m_lib_population WHERE population_year='$_SESSION[year]'") 
				or die("Cannot query: 123". mysql_error());
			list($population)= mysql_fetch_array($q_pop);
			
			$this->q_report_header($population);
			$this->Ln(10);
			
			$this->SetFont('Arial','BI','20');
			$this->Cell(340,10,'National Leprosy Control Program',1,1,C);
			
			$this->SetFont('Arial','B','12');
			$w = array(80,30,30,30,30,70,70);
		//	$w = array(76,28,28,26,28,28,63,63);
			$this->SetWidths($w);

			$label = array('Indicators', 
				'Number (Male)', 
				'Number (Female)', 
				'Number (Total)',
				'Rate', 
				'Interpretation',
				'Recommendation/Actions Taken');
			$this->Row($label);


			/* the following code was taken from dental_quarter_report.
			$label = array('Indicators', 
				'Elig. Pop.', 
				'Number (Male)', 
				'Number (Female)', 
				'Number (Total)', 
				'%', 
				'Interpretation', 
				'Recommendation/Action Taken');
			$this->Row($label);
			*/
		}
		
		
		
		function q_report_header($population) {
			$this->SetFont('Arial','B','12');
			$this->Cell(0,5,'FHSIS REPORT FOR THE QUARTER: '.$_SESSION[quarter]."          YEAR: ".$_SESSION[year],0,1,L);
			$this->Cell(0,5, 'MUNICAPLITY/CITY NAME: '.$_SESSION[datanode][name],0,1,L);
			$this->Cell(0,5,'PROVINCE: '.$_SESSION[province]."          PROJECTED POPULATION OF THE YEAR: ".$population,0,1,L);
		}
		
		
		
		function show_leprosy_quarterly(){
			/*
			$arr_indicator = array('a' => 'Orally Fit Children 12-71 monthds old',
				'b' => 'Children 12-71 months old provided with BOHC?', 
				'c' => 'Adolescent & Youth (10-24 years) given BOHC?',
				'd' => 'Pregnant women provided with BOHC?',
				'e' => 'Older Person 60 years old & above provided with BOHC?');
			*/
			//$w = array(76,28,28,26,28,28,63,63);
			$w = array(80,30,30,30,30,70,70);
			$str_brgy = $this->get_brgy();    
			
			for($indicator_ctr = 1; $indicator_ctr <= 5; $indicator_ctr++) {
				$col2 = $this->get_data($_SESSION[sdate2], $_SESSION[edate2],
					$indicator_ctr, $str_brgy, 2);
				$col3 = $this->get_data($_SESSION[sdate2], $_SESSION[edate2], 
					$indicator_ctr, $str_brgy, 3);
				$col4 = $col2 + $col3;
			//	$col5 = $this->get_data($_SESSION[sdate2], $_SESSION[edate2], ``
			//		$indicator_ctr, $str_brgy, 5);
				//$col6; this column is empty
				//$col7; this column is empty
				
				switch($indicator_ctr) {
					case 1:
						$indicator = "Leprosy cases?";
						break;
					case 2:
						$indicator = "Leprosy cases below 15 yrs old?";
						break;
					case 3:
						$indicator = "Newly detected Leprosy cases?";
						break;
					case 4:
						$indicator = "Newly detected cases with Grade 2 disability?";
						break;
					case 5:
						$indicator = "Case cured?";
						break;
					default:
						break;
				}

				$leprosy_contents = array($indicator, $col2, $col3, $col4, $col5, '', '');
				$this->Row($leprosy_contents);
			}
		}
		
		
		
		function get_brgy(){  //returns the barangay is CSV format. to be used in WHERE clause for determining barangay residence of patient
			$arr_brgy = array();
			
			if(in_array('all',$_SESSION[brgy])):
				$q_brgy = mysql_query("SELECT barangay_id FROM m_lib_barangay ORDER by barangay_id ASC") 
					or die("Cannot query 252". mysql_error());
				while(list($brgy_id) = mysql_fetch_array($q_brgy)) {            
					array_push($arr_brgy,$brgy_id);
				}
			else:
				$arr_brgy = $_SESSION[brgy];
			endif;
			
			$str_brgy = implode(',',$arr_brgy);
			
			return $str_brgy;
        
		}       
		
		
		
		function get_data() {
			if(func_num_args() > 0) {
				$args = func_get_args();
				$start = $args[0];
				$end = $args[1];
				$indicator = $args[2];
				$brgy = $args[3];
				$col_code = $args[4];
			}
			
			
			// $col_code represents the column number on the report
			// Column 1 = Indicators
			// Column 2 = Number (Male)
			// Column 3 = Number (Female)
			// Column 4 = Number (Total)
			// Column 5 = Rate
			// Column 6 = Interpreation
			// Column 7 = Recommendation/Action Taken
			switch($col_code) {
				case '2':
					// Indicator #1: Leprosy Cases
					if($indicator == '1') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'M' AND ".
							"(date_of_diagnosis >= '$start' AND ".
							"date_of_diagnosis <= '$end') ";
						$result = mysql_query($query)
							or die("Couldn't execute query. case:2, indicator:1 ".mysql_error());
						return mysql_num_rows($result);
						break;
					}
					
					// Indicator #2: Leprosy cases below 15 yrs old?
					if($indicator == '2') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'M' AND ".
							"m_leprosy_diagnosis.patient_age < 15 AND ".
							"(date_of_diagnosis >= '$start' AND ".
							"date_of_diagnosis <= '$end') ";
						$result = mysql_query($query)
							or die("Couldn't execute query. case:2, indicator:1 ".mysql_error());
						return mysql_num_rows($result);
						break;
					}

					// Indicator #3: Newly detected Leprosy cases?
					if($indicator == '3') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'M' AND ".
							"m_leprosy_diagnosis.patient_case = 'New Case' AND ".
							"(date_of_diagnosis >= '$start' AND ".
							"date_of_diagnosis <= '$end') ";
						$result = mysql_query($query)
							or die("Couldn't execute query. case:2, indicator:1 ".mysql_error());
						return mysql_num_rows($result);
						break;
					}

					// Indicator #4: Newly detected cases with Grade 2 disability?

					// Indicator #5: Case cured?
					

				case '3':
					// Indicator #1: Leprosy Cases
					if($indicator == '1') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'F' AND ".
							"(m_leprosy_diagnosis.date_of_diagnosis >= '$start' AND ".
							"m_leprosy_diagnosis.date_of_diagnosis <= '$end') ";

					$result = mysql_query($query)
						or die("Couldn't execute query. case:3, indicator:1 ".mysql_error());
					return mysql_num_rows($result);

					break;
					}

					// Indicator #2: Leprosy cases below 15 yrs old?
					if($indicator == '2') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'F' AND ".
							"m_leprosy_diagnosis.patient_age < 15 AND ".
							"(date_of_diagnosis >= '$start' AND ".
							"date_of_diagnosis <= '$end') ";
						$result = mysql_query($query)
							or die("Couldn't execute query. case:2, indicator:1 ".mysql_error());
						return mysql_num_rows($result);
						break;
					}

					// Indicator #3: Newly detected Leprosy cases?
					if($indicator == '3') {
						$query = "SELECT DISTINCT m_leprosy_diagnosis.patient_id FROM m_leprosy_diagnosis ".
							"INNER JOIN m_patient ON m_leprosy_diagnosis.patient_id = m_patient.patient_id ".
							"WHERE m_patient.patient_gender = 'F' AND ".
							"m_leprosy_diagnosis.patient_case = 'New Case' AND ".
							"(date_of_diagnosis >= '$start' AND ".
							"date_of_diagnosis <= '$end') ";
						$result = mysql_query($query)
							or die("Couldn't execute query. case:2, indicator:1 ".mysql_error());
						return mysql_num_rows($result);
						break;
					}

					// Indicator #4: Newly detected cases with Grade 2 disability?

					// Indicator #5: Case cured?
					

				case '4':
					return;
					break;
				case '5':
					// need to find a way to compute for rate
					return;
					break;
				case '6':
					return;
					break;
				case '7':
					return;
					break;
				default:
					break;
					
				}	
		}
		
		
		
		function get_px_brgy(){
			if(func_num_args()>0):
				$arg_list = func_get_args();
				$pxid = $arg_list[0];
				$str = $arg_list[1];
			endif;
        
			$q_px = mysql_query("SELECT a.barangay_id FROM m_family_address a, m_family_members b WHERE b.patient_id='$pxid' AND b.family_id=a.family_id AND a.barangay_id IN ($str)") or die("cannot query 389: ".mysql_error());
			
			if(mysql_num_rows($q_px)!=0):
				return 1;
			else:   
				return ;
			endif; 
		}
		
		
		
		function Footer(){
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
		}
		
		
		
	} // end of class

	$pdf = new PDF('L','mm','Legal');

	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',10);

	$pdf->AddPage();

	$pdf->show_leprosy_quarterly();

	$pdf->Output();
?>
