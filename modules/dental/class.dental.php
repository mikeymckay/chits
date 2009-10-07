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
      $this->author = 'Jeffrey V. Tolentino';
      $this->version = '0.1'.date("Y-m-d");
      $this->module = 'dental';
      $this->description = 'CHITS Module - Dental Health Care Program';
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
      module::set_menu($this->module, "Dental Records", "PATIENTS", "_dental");
      // set_detail parameters
      // set_detail([module description], [module version], [module author], [module name/id]
      module::set_detail($this->description, $this->version, $this->author, $this->module);
    }
    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                          
    function init_sql() {
    }
                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                          
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
