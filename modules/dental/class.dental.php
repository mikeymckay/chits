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
    function dental_health_care() {
      $this->author = "Jeffrey V. Tolentino";
      $this->version = "0.1".date("Y-m-d");
      $this->module = "dental";
      $this->description = "CHITS Module - Dental Health Care Program";
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                                                                                                                                        
                                                                                                                                          
    function init_deps() {
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
                                                                                                                                                                                                                                      
      // set_menu parameters
      // set_menu([module name], [menu title - what is displayed], menu categories (top menu)], [script executed in class])
      //module::set_menu($this->module, "Dental Records", "PATIENTS", "_dental");
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
        "`patient_id` int(11) NOT NULL,".
        "`tooth_number` int(11) NOT NULL,".
        "`tooth_condition` varchar(5) collate swe7_bin NOT NULL,".
        "`date_of_oral` date NOT NULL,".
        "`dentist` float NOT NULL,".
        "PRIMARY KEY  (`ohc_id`)".
        ") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin COMMENT='Patient Oral Health Condition' AUTO_INCREMENT=1 ;"
        
        
      // The following codes will be used to create [m_dental_tooth_condition]
      // If needed, change the table name to follow proper naming conventions in CHITS.
      // The table reflects the standard tooth conditions and their corresponding legends.
      // See the IPTR given by Dr. domingo for further reference.
      module::execsql("CREATE TABLE IF NOT EXISTS `m_dental_tooth_condition` (".
        "`legend` varchar(5) collate swe7_bin NOT NULL COMMENT 'condition legend',".
        "`status` varchar(50) collate swe7_bin NOT NULL COMMENT 'tooth status Perma/Tempo',".
        "`condition` varchar(50) NOT NULL COMMENT 'condition description',".
        "PRIMARY KEY  (`legend`)".
        ") ENGINE=InnoDB DEFAULT CHARSET=swe7 COLLATE=swe7_bin;"
      
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    
    
    function drop_tables() {
    }
                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                      
    function _dental() {
    
    // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    // IMPORTANT:
    //	THE CODE FOR THIS FUNCTION IS IN A SEPARATE FILE. (NAME dhcmain.php, 
    //  LOCATED AT chits_modules_factory, my working directory for chits modules).
    //  I WILL APPEND THE CONTENT OF THE FILE LATER HERE.
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
    echo "Hello World";
    
    }
     
                  
  } // class ends here
?>
