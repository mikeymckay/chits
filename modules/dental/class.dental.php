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
                                                                                                                                        
      
      
      
    // Comment date: Oct 21, '09, JVTolentino
    // This function is somehow needed by the healthcenter class, the reason 
    //    is unknown.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function _details_dental() {
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
      //module::set_menu($this->module, "Dental Records", "PATIENTS", "_consult_dental");
      // set_detail parameters
      // set_detail([module description], [module version], [module author], [module name/id]
      module::set_detail($this->description, $this->version, $this->author, $this->module);
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
                                                                                                                                                                                                                                                                        
    // Comment date: Oct 7, 2009, JVTolentino
    // The init_sql() function starts here.
    // This function will initialize the tables for the Dental Module in CHITS DB.
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
        "`patient_id` int(11) NOT NULL,".
        "`consult_id` float NOT NULL,".
        "`is_patient_pregnant` tinyint(1) NOT NULL,".
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
    
    
    
    
    
    // Comment date: Oct 16, '09, JVTolentino
    // The following function will be used for acquiring tooth condition
    //    from m_dental_patient_ohc.
    // This function accepts two arguments:
    //    1. $tn -> corresponds to the field tooth_number
    //    2. $cid -> corresponds to the field consult_id
    // Initial assessment is that the function will not need the patient's
    //    id to get a unique record, likewise, the date of oral examination
    //    is also not required. The field consult_id will most probably be
    //    enough to get a unique tooth_condition for every oral examination.
    //    If these arguments prove flawed, change the arguments so that it 
    //    references the fields patient_id and date_of_oral.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function tooth_condition($tn, $cid) {
      $query = "SELECT `tooth_condition` FROM `m_dental_patient_ohc` WHERE `tooth_number` = ".$tn." AND `consult_id` = ".$cid."";
      $result = mysql_query($query)
        or die ("Couldn't execute query.");
      
      if($row = mysql_fetch_assoc($result)) {
        return $row['tooth_condition'];
      }
      else {
        return "&nbsp;";
      }
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    
    // Comment date: Oct 14, '09, JVTolentino
    // The following function is used to display the current date,
    //    and if needed, the ability to change the consult date of the
    //    patient. This is usually done when the patient's record 
    //    are being recorded days later after his original consulatation
    //    date.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function show_date_of_oral() {
      echo "<table border=3 bordercolor='red' cellspacing=1 align='center' width=600>";
        echo "<tr>";
          echo "<th align='left' colspan=2 bgcolor=#CC9900#>Date of Oral Examination</th>";          
        echo "</tr>";
        
        echo "<tr>";
          echo "<td align='center' width=200>";
            echo "<input type='text' name='date_of_oral' readonly='true' size=10 value='".date("m/d/Y").
            "'> <a href=\"javascript:show_calendar4('document.form_dental.date_of_oral', document.form_dental.date_of_oral.value);\">".
            "<img src='../images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the Date'></a></input>";
          echo "</td>";
          echo "<td> Click the image on the left to change the date of oral examination.</td>";
        echo "</tr>";
      echo "</table>";
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    
    // Comment date: Oct. 21, '09, JVTolentino
    // The following function is used to get the patient's teeth
    //    conditions.
    //
    // Comment date: Oct 21 (4:12PM), '09, JVTolentino
    // I will implement another feature in this function. The function will now
    //    accept one argument, the age of the patient, and use it to dynamically
    //    get only the relevant teeth numbers and conditions.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function get_teeth_conditions($p_age) {
      if($p_age < 6) { // tentative value for temporary teeth
        // upper-teeth (temporary)
        for($this->toothnumber=51; $this->toothnumber<=55; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
        for($this->toothnumber=61; $this->toothnumber<=65; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
        
        // lower-teeth (temporary)
        for($this->toothnumber=81; $this->toothnumber<=85; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
        for($this->toothnumber=71; $this->toothnumber<=75; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
      }
      else {
        // upper-teeth (permanent)
        for($this->toothnumber=11; $this->toothnumber<=18; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
        for($this->toothnumber=21; $this->toothnumber<=28; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
  
        // lower-teeth (permanent)
        for($this->toothnumber=41; $this->toothnumber<=48; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
        for($this->toothnumber=31; $this->toothnumber<=38; $this->toothnumber++) {
          $this->condition[$this->toothnumber] = $this->tooth_condition($this->toothnumber, $this->consult_id);
        }
      }
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    
    // Comment date: Oct 8, '09, JVTolentino
    // The following codes are used to select a tooth_number
    //    and the condition for that particular tooth.
    // The selection will come entirely from the user.
    //
    // Comment date: Oct 21 (4:21PM), '09, JVTolentino
    // I will implement another feature in this function. The function will now
    //    accept one argument, the age of the patient, and use it to dynamically
    //    show in the listbox the relevant teeth and conditions.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function select_tooth_and_condition($p_age) {
      echo "<table border=3 bordercolor='red' align='center' width=500>";
        echo "<tr>";
          echo "<th align='left' bgcolor='CC9900'>Set Patient's Tooth Condition</th>";
        echo "</tr>";
  
        echo "<tr>";
          echo "<td>";
            echo "<table align='center' border=0 cellspacing=0>";
              echo "<tr>";
                echo "<td width=200 align='left'>Select tooth number:</td>";
                echo "<td>";
                  echo "<select name='select_tooth'>";
                    if($p_age < 6) { // TENTATIVE VALUE FOR TEMPORARY TEETH
                      for($i=55; $i>=51; $i--) {
                        echo "<option value=$i>$i</option>";
                      }
                
                      for($i=61; $i<=65; $i++) {
                        echo "<option value=$i>$i</option>";
                      }
                
                      for($i=85; $i>=81; $i--) {
                        echo "<option value=$i>$i</option>";
                      }
                
                      for($i=71; $i<=75; $i++) {
                        echo "<option value=$i>$i</option>";
                      }
                    }
                    else {
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
                  if($p_age < 6) { // TENTATIVE VALUE FOR TEMPORARY TEETH
                    $query = "SELECT DISTINCT legend FROM m_lib_dental_tooth_condition WHERE status='Temporary' ORDER BY legend";
                  }
                  else {
                    $query = "SELECT DISTINCT legend FROM m_lib_dental_tooth_condition WHERE status='Permanent' ORDER BY legend";
                  }
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
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    
    // Comment date: Oct 6, '09
    // The following codes are used to populate a table with
    //   teeth symbols and conditions.
    // My initial plan is to refresh the page every
    //   tooth condition updates.
    // Will see if this is acceptable, especially
    //   when querying the db.
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function show_teeth_conditions($p_age) {
      echo "<table border=3 bordercolor=#009900# align='center'>";
        // upper-teeth-temporary symbols and conditions
        echo "<tr>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          for($this->toothnumber=55; $this->toothnumber>=51; $this->toothnumber--) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          for($this->toothnumber=61; $this->toothnumber<=65; $this->toothnumber++) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
        echo "</tr>";
  
        echo "<tr>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          for($this->toothnumber=55; $this->toothnumber>=51; $this->toothnumber--) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          for($this->toothnumber=61; $this->toothnumber<=65; $this->toothnumber++) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
        echo "</tr>";
          
        // upper-teeth-permanent symbols and conditions
        echo "<tr>";
          for($this->toothnumber=18; $this->toothnumber>=11; $this->toothnumber--) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          for($this->toothnumber=21; $this->toothnumber<=28; $this->toothnumber++) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
        echo "</tr>";
  
        echo "<tr>";
          for($this->toothnumber=18; $this->toothnumber>=11; $this->toothnumber--) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          for($this->toothnumber=21; $this->toothnumber<=28; $this->toothnumber++) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
        echo "</tr>";
      echo "</table>";
  
    
      echo "&nbsp;";
      echo "<table border=3 bordercolor=#009900# align='center'>";
        // lower-teeth-permanent symbols and conditions
        echo "<tr>";
          for($this->toothnumber=48; $this->toothnumber>=41; $this->toothnumber--) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          for($this->toothnumber=31; $this->toothnumber<=38; $this->toothnumber++) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
        echo "</tr>";
  
        echo "<tr>";
          for($this->toothnumber=48; $this->toothnumber>=41; $this->toothnumber--) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          for($this->toothnumber=31; $this->toothnumber<=38; $this->toothnumber++) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
        echo "</tr>";

        // lower-teeth-temporary symbols and conditions
        echo "<tr>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          for($this->toothnumber=85; $this->toothnumber>=81; $this->toothnumber--) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          for($this->toothnumber=71; $this->toothnumber<=75; $this->toothnumber++) {
            echo "<td align='center'>{$this->condition[$this->toothnumber]}</td>";
          }
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
        echo "</tr>";
        
        echo "<tr>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          for($this->toothnumber=85; $this->toothnumber>=81; $this->toothnumber--) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          for($this->toothnumber=71; $this->toothnumber<=75; $this->toothnumber++) {
            echo "<td align='center'><b>$this->toothnumber</b></td>";
          }
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
          echo "<td align='center'></td>";
        echo "</tr>";
      echo "</table>"; 
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
    // Comment date: Oct 21, '09, JVTolentino
    // Initial codes for inserting records
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    function new_dental_record() {
      $loc_patient_id = $_POST['h_patient_id'];
      $loc_consult_id = $_POST['h_consult_id'];
      $loc_patient_pregnant = $_POST['h_patient_pregnant'];
      $loc_tooth_number = $_POST['select_tooth'];
      $loc_tooth_condition = $_POST['select_condition'];
      $loc_date_of_oral = $_POST['date_of_oral'];
      list($month, $day, $year) = explode("/", $_POST['date_of_oral']);
      $loc_date_of_oral = $year."-".str_pad($month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
      $loc_dentist = $_POST['h_dentist'];
      
      
      $query = "SELECT COUNT(*) AS flag_tooth FROM `m_dental_patient_ohc` WHERE `tooth_number` = $loc_tooth_number AND `consult_id` = $loc_consult_id";
      $result = mysql_query($query)
        or die ("Couldn't execute query.");
      
      if($row = mysql_fetch_assoc($result)) {
        if($row['flag_tooth'] == 0) {
          $query = "INSERT INTO `m_dental_patient_ohc` (`patient_id`, `consult_id`, `is_patient_pregnant`, `tooth_number`, `tooth_condition`, `date_of_oral`, `dentist`) VALUES".
            "($loc_patient_id, $loc_consult_id, $loc_patient_pregnant, $loc_tooth_number, '$loc_tooth_condition', '$loc_date_of_oral', $loc_dentist)";  
        } 
        else {
          $query = "UPDATE `m_dental_patient_ohc` SET `tooth_number` = '$loc_tooth_number', `tooth_condition` = '$loc_tooth_condition' WHERE ".
            "`patient_id` = $loc_patient_id AND `consult_id` = $loc_consult_id AND `tooth_number` = $loc_tooth_number ";
        }
      }
      
      $result = mysql_query($query)
        or die ("Couldn't execute query.");
      
      
      
        
      
        
    
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    
                                                                                                                                                                                                                                                                                                      
    function _consult_dental() {
      echo "<form name='form_dental' action='$_POST[PHP_SELF]' method='POST'>";
      
      $dental = new dental;
      
      $dental->toothnumber = 0;
      $dental->condition[$dental->toothnumber] = 'Y';
      $dental->consult_id = $_GET['consult_id'];
      $dental->patient_id = healthcenter::get_patient_id($_GET['consult_id']);
      $dental->patient_age = healthcenter::get_patient_age($_GET['consult_id']);
      $dental->patient_pregnant = 0; // THIS VALUE IS FOR TESTING PURPOSES ONLY...YOU SHOULD FIND A WAY IF THE PATIENT IS REALLY PREGNANT OR NOT
      $dental->dentist = 1;  // THIS VALUE IS FOR TESTING PURPOSES ONLY...YOU SHOULD FIND OUT HOW TO GET THE ID OF THE CURRENT USER
      
      // The following codes will initialize hidden textboxes and their values
      echo "<input type='hidden' name='h_patient_id' value='{$dental->patient_id}'></input>";
      echo "<input type='hidden' name='h_consult_id' value='{$dental->consult_id}'></input>";
      echo "<input type='hidden' name='h_patient_pregnant' value='{$dental->patient_pregnant}'></input>";
      echo "<input type='hidden' name='h_dentist' value='{$dental->dentist}'></input>";
      
      if (@$_POST['h_save_flag'] == 'GO') {
        $dental->new_dental_record();
        
        echo "&nbsp;";
        $dental->show_date_of_oral();
      
        $dental->get_teeth_conditions($dental->patient_age);
      
        echo "&nbsp;";
        $dental->select_tooth_and_condition($dental->patient_age);

        echo "&nbsp;";
        $dental->show_teeth_conditions($dental->patient_age);
      }
      else {
        echo "&nbsp;";
        $dental->show_date_of_oral();
      
        $dental->get_teeth_conditions($dental->patient_age);
      
        echo "&nbsp;";
        $dental->select_tooth_and_condition($dental->patient_age);

        echo "&nbsp;";
        $dental->show_teeth_conditions($dental->patient_age);
      }
      
      echo "<input type='hidden' name='h_save_flag' value='GO'></input>";
      
        
      
      
      
        
      
      
      
      
    
    
        
  
  
  
  
  
  
  
  
  
  
  














      // FOLLOWING CODES IS FOR SHOWING ORAL HEALTH CONDITIONS A AND B IN IPTR

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
            "<input type='text' size=10 readonly='true' value='".date("m/d/Y")."'>"."</input>".
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
      
      echo "</form>";
    
    } // end of _dental()                 
  } // class ends here
?>
