<?php
	session_start();

	ob_start();

	require('./fpdf/fpdf.php');

	$db_conn = mysql_connect("localhost","$_SESSION[dbuser]","$_SESSION[dbpass]");
	mysql_select_db($_SESSION[dbname]);
	
	
	
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
			$m1 = explode('/',$_SESSION[sdate_orig]);
			$m2 = explode('/',$_SESSION[edate_orig]);
			
			$date_label = ($m1[0]==$m2[0])?$_SESSION[months][$m1[0]].' '.$m1[2]:$_SESSION[months][$m1[0]].' to '.$_SESSION[months][$m2[0]].' '.$m1[2];
			
			$municipality_label = $_SESSION[datanode][name];
			
			$this->SetFont('Arial','B',12);
			
			
			$this->Cell(0,5,'ENVIRONMENTAL ( '.$date_label.' )'.' - '.$municipality_label,0,1,'C');
			
			if(in_array('all',$_SESSION[brgy])):
				$brgy_label = '(All Barangays)';
			else:
				$brgy_label = '(';
				for($i=0;$i<count($_SESSION[brgy]);$i++) {
					$brgy = $_SESSION[brgy][$i];
					$q_brgy = mysql_query("SELECT barangay_name FROM m_lib_barangay WHERE barangay_id='$brgy'") or die("Cannot query: 139");
					
					list($brgyname) = mysql_fetch_array($q_brgy);
					
					if($i!=(count($_SESSION[brgy])-1)):
						$brgy_label.= $brgyname.', ';
					else:
						$brgy_label.= $brgyname.')';
					endif;
				}
			endif;
			
			$this->SetFont('Arial','',10);
			
			$this->Cell(0,5,$brgy_label,0,1,'C');		
			$w = array(100, 30, 30, 90, 90); //340
			$header = array('INDICATORS','No.','%','Interpretation','Recommendation/Actions Taken');
			
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
		
		
		
		function show_sanitation_summary() {
			$arr_indicators = array('Households (HH)', 
				'HH with access to improved or safe water supply?', 
				'  - Level I?',
				'  - Level II?',
				'  - Level III?',
				'HH with sanitary toilet facilities?',
				'HH with satisfactory disposal of solid waste?',
				'HH with complete basic sanitation facilities?',
				'Food Establishment',
				'Food Establishment with Sanitary Permit?',
				'Food Handlers',
				'Food Handlers with Health Certificates?',
				'Salt Samples Tested',
				'Salt Samples Tested found (+) for iodine');
			$header = array(100, 30, 30, 90, 90);	// 340

			$brgy_array = $this->get_brgy_array();
                        $brgy_array = implode(',',$brgy_array);




			$households = $this->get_households($brgy_array);

			for($i=0; $i<count($arr_indicators); $i++) {
				switch($i) {
					case 0: // Indicator #1: Households
						$col2 = $households;
						$col3 = '';
						break;
					case 1: // Indicator #2: HH w/ access to improved or safe water supply
						list($year, $month, $day) = explode("-", $_SESSION[sdate2]);
						$col2 = $this->get_households_with_access_to_water_supply($brgy_array, $year);
						$col3 = ($col2 / $households);
						break;
					case 2: // Indicator #3: Water Supply Level I
						list($year, $month, $day) = explode("-", $_SESSION[sdate2]);
                                                $col2 = $this->get_households_with_access_to_water_supply_by_level($brgy_array, $year, 1);
                                                $col3 = ($col2 / $households);
                                                break;
					case 3: // Indicator #3: Water Supply Level II
						list($year, $month, $day) = explode("-", $_SESSION[sdate2]);
                                                $col2 = $this->get_households_with_access_to_water_supply_by_level($brgy_array, $year, 2);
                                                $col3 = ($col2 / $households);
                                                break;
					case 4: // Indicator #3: Water Supply Level III
						list($year, $month, $day) = explode("-", $_SESSION[sdate2]);
                                                $col2 = $this->get_households_with_access_to_water_supply_by_level($brgy_array, $year, 3);
                                                $col3 = ($col2 / $households);
                                                break;
					default:
						$col2 = '';
						$col3 = '';
						break;
				}


				$row_content = array("\n".$arr_indicators[$i], "\n".$col2, "\n".$col3, '', '');
				$this->SetWidths($header);
				$this->Row($row_content);
			}
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


		// Comment date: May 3, 2010, JVTolentino
		// This function will return the number of households in the brgy/s.
		function get_households($brgy) {
			$query = "SELECT a.household_number FROM m_sanitation_household a ".
				"INNER JOIN m_family_address b ON a.family_id = b.family_id WHERE ".
				"b.barangay_id IN ($brgy) ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}



		// Comment date: May 3, 2010, JVTolentino
		// This function will return the number of households with access
		//	to improved or safe water supply in the brgy/s.
		function get_households_with_access_to_water_supply($brgy, $year_inspected) {
			$query = "SELECT b.household_number FROM m_family_address a ".
				"INNER JOIN m_sanitation_household b ON a.family_id = b.family_id ".
				"INNER JOIN m_sanitation_water_supply c ON b.household_number = c.household_number ".
				"WHERE year_inspected = $year_inspected AND ".
				"a.barangay_id IN ($brgy) ";
			$result = mysql_query($query) or die("Couldn't execute query.");

			return mysql_num_rows($result);
		}



		// Comment date: May 3, 2010, JVTolentino
		// This function will return the number of households with access
		// 	to improved or safe water supply (by level) in the brgy/s.
		function get_households_with_access_to_water_supply_by_level($brgy, $year_inspected, $level) {
			$query = "SELECT b.household_number FROM m_family_address a ".
                                "INNER JOIN m_sanitation_household b ON a.family_id = b.family_id ".
                                "INNER JOIN m_sanitation_water_supply c ON b.household_number = c.household_number ".
                                "WHERE c.year_inspected = $year_inspected AND ".
				"c.water_supply_level = $level AND ".
                                "a.barangay_id IN ($brgy) ";
                        $result = mysql_query($query) or die("Couldn't execute query.");

                        return mysql_num_rows($result);
		}
			
		
		
	} // end of class

	$pdf = new PDF('L','mm','Legal');
	$pdf->AliasNbPages();
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();

	$pdf->show_sanitation_summary();

	$pdf->Output();
?>
