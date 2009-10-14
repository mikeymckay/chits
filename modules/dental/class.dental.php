<?
  class dental extends module {
    
    // Author: Herman Tolentino MD
    // CHITS Project 2004
            
    // DENTAL HEALTH CARE PROGRAM MODULE
                           
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
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function dental() {
      $this->author = "Jeffrey V. Tolentino";
      $this->version = "0.1-".date("Y-m-d");
      $this->module = "dental";
      $this->description = "CHITS Module - Dental Health Care Program";
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                                                                                                                                        
                                                                                                                                          
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
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function init_menu() {
      if (func_num_args()>0) {
        $arg_list = func_get_args();
      }
      
      //print_r($arg_list);
                                                                                                                                                                                                                                            
      // set_menu parameters
      // set_menu([module name], [menu title - what is displayed], menu categories (top menu)], [script executed in class])
      module::set_menu($this->module, "Dental Records", "PATIENTS", "_dental");
      // set_detail parameters
      // set_detail([module description], [module version], [module author], [module name/id]
      module::set_detail($this->description, $this->version, $this->author, $this->module);
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                                                                                                                                                                                                                                                                        
    // Comment date: Oct 7, 2009, JVTolentino
    // The init_sql() function starts here.
    // This function will initialize the tables for Dental in CHITS DB.
    // Will add additional comments soon.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function init_sql() {
      if (func_num_args()>0) {
        $arg_list = func_get_args();
      }
      
      // The following codes will be used to create [m_dental_patient_ohc].
      // If needed, change the table name to follow proper naming conventions in CHITS.
      // The table reflects the standard format on how to collect data regarding 
      //    the patient's oral health condition. The entries on the fields [tooth_number]
      //    and [tooth_condition] should reflect what number the dentists actually used in their 
      //    patient/treatment record. See the IPTR given by Dr. Domingo for further reference.
      module::execsql("CREATE TABLE IF NOT EXISTS `m_dental_patient_ohc` (".
        "`ohc_id` float NOT NULL auto_increment COMMENT 'Patient Oral Health Condition',".
        "`consult_id` float NOT NULL,".
        "`patient_id` int(11) NOT NULL,".
        "`tooth_number` int(11) NOT NULL,".
        "`tooth_condition` varchar(5) collate swe7_bin NOT NULL,".
        "`date_of_oral` date NOT NULL,".
        "`dentist` float NOT NULL,".
        "PRIMARY KEY  (`ohc_id`)".
        ") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin COMMENT='Patient Oral Health Condition' AUTO_INCREMENT=1 ;");
        
        
      // The following codes will be used to create [m_lib_dental_tooth_condition]
      // If needed, change the table name to follow proper naming conventions in CHITS.
      // The table reflects the standard tooth conditions and their corresponding legends.
      // See the IPTR given by Dr. domingo for further reference.
      module::execsql("CREATE TABLE IF NOT EXISTS `m_lib_dental_tooth_condition` (".
        "`legend` varchar(5) collate swe7_bin NOT NULL COMMENT 'condition legend',".
        "`status` varchar(50) collate swe7_bin NOT NULL COMMENT 'tooth status Perma/Tempo',".
        "`condition` varchar(50) NOT NULL COMMENT 'condition description',".
        "PRIMARY KEY  (`legend`)".
        ") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;");
        
        
      // The following codes will be used to insert the initial records for
      //    m_lib_dental_tooth_condition.
      module::execsql("INSERT INTO `m_lib_dental_tooth_condition` (`legend`, `status`, `condition`) VALUES".
        "('D', 'Permanent', 'Decayed'),".
        "('F', 'Permanent', 'Filled'),".
        "('JC', 'Permanent', 'Jacket Crown'),".
        "('M', 'Permanent', 'Missing'),".
        "('P', 'Permanent', 'Pontic'),".
        "('S', 'Permanent', 'Supernumerary Tooth'),".
        "('Un', 'Permanent', 'Unerupted'),".
        "('X', 'Permanent', 'Indicated for Extraction'),".
        "('Y', 'Permanent', 'Sound/Sealed'),".
        "('d', 'Temporary', 'Decayed'),".
        "('e', 'Temporary', 'Missing'),".
        "('f', 'Temporary', 'Filled'),".
        "('jc', 'Temporary', 'Jacket Crown'),".
        "('p', 'Temporary', 'Pontic'),".
        "('s', 'Temporary', 'Supernumerary Tooth'),".
        "('un', 'Temporary', 'Unerupted'),".
        "('x', 'Temporary', 'Indicated for Extraction'),".
        "('y', 'Temporary', 'Sound/Sealed');");
     
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    // Comment date: Oct 13, 2009, JVTolentino
    // The drop_tables() function starts here.
    // This function will be used to drop tables from CHITS DB.
    // This function will be executed if the user opts to delete
    //    the tables associated with this module.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function drop_tables() {
      module::execsql("DROP TABLE `m_dental_patient_ohc`");
      module::execsql("DROP TABLE `m_lib_dental_tooth_condition`");
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    // Comment date: Oct. 13, 09, JVTolentino
    // The succeeding codes and functions will be used exclusively(??) for
    //    the 'CHITS - DENTAL HEALTH CARE PROGRAM MODULE'. These codes
    //    are open-source, so feel free to modify, enhance, and distribute
    //    as you wish.
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    // Comment date: Oct 6, '09
    // The following function will be used for acquiring tooth condition,
    // the condition will be retrieved from db later.
    // Delete and replace this comment if data are being retrieved from db.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function tooth_condition($tn) {
      return '-'.$tn.'-';
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
    
    
  
    
  
                                                                                                                                                                                                                                                                                                        
    function _dental() {
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
      $toothnumber = 0;
      $condition[$toothnumber] = 'Y';
  
      // upper-teeth (temporary)
      for($toothnumber=51; $toothnumber<=55; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
      for($toothnumber=61; $toothnumber<=65; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
  
      // upper-teeth (permanent)
      for($toothnumber=11; $toothnumber<=18; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
      for($toothnumber=21; $toothnumber<=28; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
  
      // lower-teeth (permanent)
      for($toothnumber=41; $toothnumber<=48; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
      for($toothnumber=31; $toothnumber<=38; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
  
      // lower-teeth (temporary)
      for($toothnumber=81; $toothnumber<=85; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
      for($toothnumber=71; $toothnumber<=75; $toothnumber++) {
        $condition[$toothnumber] = $this->tooth_condition($toothnumber);
      }
      // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      
      
      
      // Comment date: Oct 6, '09
      // The following codes will be used to output to the 
      //    screen the patient's personal info.
      // These data are based on my interview with Dr Leandro Domingo
      //    (Dental Health Coordinator - PHO) on Sep 24, '09.
      // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
      echo "&nbsp;";
      $patient_id = '1';
      $patient_name = $this->patient_name($patient_id);
      $patient_birthdate = $this->patient_birthdate($patient_id);
      $patient_place_of_birth = $this->patient_place_of_birth($patient_id);
      $patient_age = $this->patient_age($patient_id);
      $patient_sex = $this->patient_sex($patient_id);
      $patient_address = $this->patient_address($patient_id);
      $patient_occupation = $this->patient_occupation($patient_id);
      $patient_parent = $this->patient_parent($patient_id);
      $patient_medical_history = $this->patient_medical_history($patient_id);
  
      echo "<table border=3 bordercolor='009900' cellspacing=1 align='center' width=600>";
        echo "<tr>";
          echo "<th colspan=3 bgcolor=#CC9900#>Individual Patient Treatment Record</th>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Patient ID:</i> <b>$patient_id</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Name:</i> <b>$patient_name</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td><i>Date of Birth:</i> <b>$patient_birthdate</b></td>";
          echo "<td><i>Age:</i> <b>$patient_age</b></td>";
          echo "<td><i>Sex:</i> <b>$patient_sex</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Place of Birth:</i> <b>$patient_place_of_birth</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Address:</i> <b>$patient_address</b></td";    
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Occupation:</i> <b>$patient_occupation</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Parent/Guardian:</i> <b>$patient_parent</b></td>";
        echo "</tr>";
    
        echo "<tr>";
          echo "<td colspan=3><i>Medical History:</i> <b>$patient_medical_history</b></td>";
        echo "</tr>";
  
        echo "</table>";
        // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
        
        
        
        // Comment date: Oct 8, '09
        // The following codes are used to select a tooth_number
        //    and the condition for that particular tooth.
        // The selection will come entirely from the user.
        // Further comments will be added later.
        // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        echo "&nbsp;";
  
        echo "<table border=3 bordercolor='red' align='center' width=500>";
          echo "<tr>";
            echo "<th align='left' bgcolor='CC9900'>Set Patient's Tooth Condition</th>";
          echo "</tr>";
  
          echo "<tr>";
            echo "<td>";
              echo "<table align='center' border=0 cellspacing=0>";
    
              echo "<tr>";
                echo "<td width=200 align='left'>Select tooth number:</td>";
                //echo "<td width=200 align='left'><input type='text' size=5 name='tooth_number'></input></td>";
            
                echo "<td>";
                  echo "<select name='select_tooth'>";
                    for($i=55; $i>=51; $i--) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=61; $i<=65; $i++) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=18; $i>=11; $i--) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=21; $i<=28; $i++) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=48; $i>=41; $i--) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=31; $i<=38; $i++) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=85; $i>=81; $i--) {
                      echo "<option value=$i>$i</option>";
                    }
                
                    for($i=71; $i<=75; $i++) {
                      echo "<option value=$i>$i</option>";
                    }  
                  echo "</select>";
                echo "</td>";
              echo "</tr>";
    
              echo "<tr>";
                echo "<td width=200 align='left'>Select tooth condition:</td>";
                
                // Comment date: Oct 14, '09, JVTolentino
                // The following codes will be used to propagate a list box which will show
                //    all the possible tooth condition that a patient may have.
                // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                echo "<td>";
                  $query = "SELECT DISTINCT legend FROM m_lib_dental_tooth_condition ORDER BY legend";
                  $result = mysql_query($query)
                    or die ("Couldn't execute query.");
                  
                  echo "<select name='select_condition'>";  
                  while ($row = mysql_fetch_array($result)) {
                    extract($row);
                      echo "<option value='$legend'>$legend</option>";
                  }
                  echo "</select>";
                echo "</td>";     
                // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                
                echo "<td width=100 align='center'><input type='submit' value='Save'></input></td>";
              echo "</tr>";
    
            echo "</table>";
          echo "</td>";
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
      echo "&nbsp;";
  
      // upper-teeth-temporary symbols and conditions
      echo "<table border=3 bordercolor=#009900# align='center'>";
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
  
  
      // lower-teeth-permanent symbols and conditions
      echo "&nbsp;";
      echo "<table border=3 bordercolor=#009900# align='center'>";
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
    
    } // end of _dental()                 
  } // class ends here
?>
