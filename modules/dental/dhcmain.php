<?

  // Comment date: Oct 6, '09
  // The following function will be used for acquiring tooth condition,
  // the condition will be retrieved from db later.
  // Delete and replace this comment if data are being retrieved from db.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  function tooth_condition($tn) {
    return 'Y'.$tn;
  }
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  // Comment date: Oct 6, '09
  // The following functions will be used for acquiring the patient's
  //   personal info from a db.
  // Delete and replace this comment if data are being retrieved from db.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  function patient_name($p_id) {
    return 'Jeffrey V. Tolentino';
  }
  
  function patient_birthdate($p_id) {
    return 'July 27, 1991';
  }
  
  function patient_age($p_id) {
    return '18';
  }
  
  function patient_sex($p_id) {
    return 'Male';
  }
  
  function patient_place_of_birth($p_id) {
    return "find out if this is included in the patient's info in CHITS.";
  }
  
  function patient_address($p_id) {
    return 'Gerona, Tarlac';
  }
  
  function patient_occupation($p_id) {
    return 'dunno';
  }
  
  function patient_parent($p_id) {
    return 'none';
  }
  
  function patient_medical_history($p_id) {
    return "must find a way to link this to patient's medical history.";
  }
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  
  echo "<p>&nbsp</p>";
  
  
  // Comment date: Oct 6, '09
  // The following codes will be used to output to the 
  //    screen the patient's personal info.
  // These data are based on my interview with Dr Leandro Domingo
  //    (Dental Health Coordinator - PHO) on Sep 24, '09.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  $patient_id = '1';
  $patient_name = patient_name($patient_id);
  $patient_birthdate = patient_birthdate($patient_id);
  $patient_place_of_birth = patient_place_of_birth($patient_id);
  $patient_age = patient_age($patient_id);
  $patient_sex = patient_sex($patient_id);
  $patient_address = patient_address($patient_id);
  $patient_occupation = patient_occupation($patient_id);
  $patient_parent = patient_parent($patient_id);
  $patient_medical_history = patient_medical_history($patient_id);
  
  echo "<table border=1 cellspacing=1 align='center' width=600>";
    echo "<tr>";
      echo "<th colspan=3>Individual Patient Treatment Record</th>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Patient ID:</i> $patient_id</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Name:</i> $patient_name</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td><i>Date of Birth:</i> $patient_birthdate</td>";
      echo "<td><i>Age:</i> $patient_age</td>";
      echo "<td><i>Sex:</i> $patient_sex</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Place of Birth:</i> $patient_place_of_birth</td>";
    echo "</td>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Address:</i> $patient_address</td";    
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Occupation:</i> $patient_occupation</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Parent/Guardian:</i> $patient_parent</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=3><i>Medical History:</i> $patient_medical_history</td>";
    echo "</tr>";
  
  echo "</table>";
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  
  // Comment date: Oct 6, '09
  // The following codes will be used to output to the 
  //    screen the patient's Oral Health Condition (A), 
  //    and the ways the user can update/modify it.
  // These data are based on my interview with Dr Leandro Domingo
  //    (Dental Health Coordinator - PHO) on Sep 24, '09.
  
  // Comment date: Oct 6, '09 (16:15)
  // Check wether the user have to modify these
  //    data. It seems these data can be acquired when the dentist
  //    fills-up his/her Oral Health Condition chart(?).
  // The chart is located at the back of the photocopied Individual
  //    Treatment Record given by Dr Domingo.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  echo "<p>&nbsp</p>";
      
  // Oral Health Conditon (A)
  echo "<table border=1 align='center' width=600>";
    echo "<tr>";
      echo "<th align='left'>Oral Health Condition (A)</th>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Date of Oral Examination: ".
        "<input type='text' size=10 readonly='true' value='".date("Y-m-d")."'>"."</input>".
        "<i> (mm-dd-yyyy)</i>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Check the box on the left if condition is present on patient</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Dental Caries</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Gingivitis/Periodontal Disease</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Debris</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Calculus</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Abnormal Growth</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Cleft Lip/Palate</input>".
        "</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>".
        "<input type='checkbox'>Others (supernumerary/mesiodens, etc)</input>".
        "</td>";
    echo "</tr>";
    
  echo "</table>";
    
    
  // Oral Health Condition (B)
  echo "<table border=1 align='center' width='600'>";
    
    echo "<tr>";
      echo "<th align='left' colspan=2>Oral Health Condition (B)</th>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td colspan=2>Indicate number on the right side of the condition</td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Permanent Teeth Present</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Permanent Sound Teeth</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Decayed Teeth (D)</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Missing Teeth (M)</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Filled Teeth (F)</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Total DMF Teeth</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Temporary Teeth Present</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of Temporary Sound Teeth</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of decayed teeth (d)</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Number of filled teeth (f)</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";
    
    echo "<tr>";
      echo "<td>Total df Teeth</td>";
      echo "<td align='center'><input type='text' size=5></input></td>";
    echo "</tr>";     
  
  echo "</table>";
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  
  
  // Comment date: 0ct 6, '09
  // The following codes will be used to initialize the patient's
  // teeth conditions. The teeth and condition symbols are based on
  // information gathered during my interview with Dr Leandro Domingo
  //    (Dental Health Coordinator - PHO) on Sep 24, '09.
  // 	Permanent					Temporary
  // 	Legend		Tooth Condition			Legend
  //	Y		Sound/Sealed			y	(the original symbol is the check symbol, if possible, use it)
  //	D		Decayed				d
  //	F		Filled				f
  //	M		Missing				e
  //	X		Indicated for extraction	x
  //	Un		Unerupted			un
  //	S		Supernumerary tooth		s
  //	JC		Jacket Crown			jc
  //	P		Pontic				p
  //	
  //	Legend:
  //	S - Sealant
  //	PF - Permanent Filling (Composite, ??) ?? bad data due to poor photocopy
  //	TF - Temporary Filling
  // 	X - Extraction
  //	O - Others
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  echo "<p>&nbsp</p>";
  $toothnumber = 0;
  $condition[$toothnumber] = 'Y';
  
  // upper-teeth (temporary)
  for($toothnumber=51; $toothnumber<=55; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  for($toothnumber=61; $toothnumber<=65; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  
  // upper-teeth (permanent)
  for($toothnumber=11; $toothnumber<=18; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  for($toothnumber=21; $toothnumber<=28; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  
  // lower-teeth (permanent)
  for($toothnumber=41; $toothnumber<=48; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  for($toothnumber=31; $toothnumber<=38; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  
  // lower-teeth (temporary)
  for($toothnumber=81; $toothnumber<=85; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  for($toothnumber=71; $toothnumber<=75; $toothnumber++) {
    $condition[$toothnumber] = tooth_condition($toothnumber);
  }
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  
  // Comment date: Oct 8, '09
  // The following codes are used to select a tooth_number
  //    and the condition for that particular tooth.
  // The selection will come entirely from the user.
  // Further comments will be added later.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  echo "<table border=1 align='center' width=600>"; // make the border 0 later.
    echo "<tr>";
      echo "<th align='left'>SET PATIENT'S TOOTH CONDITION</th>"; 
    echo "</tr>";
  
  echo "</table>";
  
  
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
  
  
  
  
  // Comment date: Oct 6, '09
  // The following codes are used to populate a table with
  //   teeth symbols and conditions.
  // My initial plan is to refresh the page every
  //   tooth condition updates.
  // Will see if this is acceptable, especially
  //   when querying the db.
  // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  echo "<p>&nbsp</p>";
  
  // upper-teeth-temporary symbols and conditions
  echo "<table border=1 align='center' width=600>";
    echo "<tr>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      for($toothnumber=55; $toothnumber>=51; $toothnumber--) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      for($toothnumber=61; $toothnumber<=65; $toothnumber++) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
    echo "</tr>";
  
    echo "<tr>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      for($toothnumber=55; $toothnumber>=51; $toothnumber--) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      for($toothnumber=61; $toothnumber<=65; $toothnumber++) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
    echo "</tr>";
  
  
    // upper-teeth-permanent symbols and conditions
    echo "<tr>";
      for($toothnumber=18; $toothnumber>=11; $toothnumber--) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      for($toothnumber=21; $toothnumber<=28; $toothnumber++) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
    echo "</tr>";
  
    echo "<tr>";
      for($toothnumber=18; $toothnumber>=11; $toothnumber--) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      for($toothnumber=21; $toothnumber<=28; $toothnumber++) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
    echo "</tr>";
  echo "</table>";
  
  echo "<p>&nbsp</p>";
  
  
  // lower-teeth-permanent symbols and conditions
  echo "<table border=1 align='center'>";
    echo "<tr>";
      for($toothnumber=48; $toothnumber>=41; $toothnumber--) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      for($toothnumber=31; $toothnumber<=38; $toothnumber++) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
    echo "</tr>";
  
    echo "<tr>";
      for($toothnumber=48; $toothnumber>=41; $toothnumber--) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      for($toothnumber=31; $toothnumber<=38; $toothnumber++) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
    echo "</tr>";
  
  
    // lower-teeth-temporary symbols and conditions
    echo "<tr>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      for($toothnumber=85; $toothnumber>=81; $toothnumber--) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      for($toothnumber=71; $toothnumber<=75; $toothnumber++) {
        echo "<td align='center'>$condition[$toothnumber]</td>";
      }
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
    echo "</tr>";
  
    echo "<tr>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      for($toothnumber=85; $toothnumber>=81; $toothnumber--) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      for($toothnumber=71; $toothnumber<=75; $toothnumber++) {
        echo "<td align='center'><b>$toothnumber</b></td>";
      }
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
      echo "<td align='center'></td>";
    echo "</tr>";
  echo "</table>";
  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
  
?>