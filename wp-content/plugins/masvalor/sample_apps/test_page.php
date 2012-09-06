<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* Another simple example that displays a `Hello World` type message and the current date and time
*
* Use it to debug your Tina MVC caching issues
*
* This is the simplest example of Tina MVC page controller. You should only use
* this in production if there are no premissions required to instantiate a
* tina_mvc_base_page_class object. Remember the constructor is always executed
* regardless of the permissions set to view the page.
*
* Normally you use the dispatcher method to call a method after the permissions
* have been checked.
*
* Also there are helper functions add_var() and add_var_e() for adding data to
* $this->template_vars and automatically escaping. See $this->load_view().
*
* In this case the data does not require escaping, so we just assign it directly
* to the page content.
*
* @package    Tina-MVC
* @author     Francis Crossen <francis@crossen.org>
*/
class test_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );
        
        // we just output the time and date as a sample
        $out = '<div style="border: 1px dotted black; color: white; background-color: black;">';
        $out .= 'This text is generated from the \'test\' controller<br />';
        $out .= tina_mvc_db_time() . '<br />';
        $out .= tina_mvc_db_date();
        $out .= '</div>';
        
        $this->set_post_title('Happy '.date('l'));
        $this->set_post_content($out);
        
    }
    
}


?>
