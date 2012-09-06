<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A test page that assignes variables directly instead of using a view template
*
* Access it at: /tina-mvc-for-wordpress/test
* 
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
*/
class test_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );
        
        $this->set_post_title('This is the page title');
            
        $content = "This is the post content. It is assigned directly from the page controller (i.e. without
                    a view (template) file.\r\n\r\n";
        $content .= "The Tina MVC request passed to the page controller is\r\n\r\n";
        $this->set_post_content( $content . print_r($request,1) );
        
    }

}


?>