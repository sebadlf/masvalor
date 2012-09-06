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
* @see test_page.php notes on putting everything in the constructor and not using the add_var() and add_var_e() functions.
* 
* @package    Tina-MVC
* @author     Francis Crossen <francis@crossen.org>
*/
class sample_page extends tina_mvc_base_page_class {
    
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        /**
         * Automatic routing with the dispatcher method.
         * @see dispatcher_example_page.php
         */
        $this->use_dispatcher = TRUE;
        
    }
    
    /**
     * A simple controller that outputs the day and the time.
     *
     * Note that the $request parameter is also available as a class property
     * $this->request
     * 
     * @param array $request the controller call
     */
    function index( $request=array() ) {
        
        /**
         * We just output the time and date as a sample - no bother with a view file
         */
        $out = '<div style="border: 1px dotted black; color: white; background-color: black;">';
        $out .= 'This text is generated from the \'sample\' controller<br />';
        $out .= tina_mvc_db_time() . '<br />';
        $out .= tina_mvc_db_date();
        $out .= '</div>';
        
        $this->set_post_title('Happy '.date('l'));
        $this->set_post_content($out);
        
    }
    
}


?>