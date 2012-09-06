<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A simple shortcode
*
* Put the shortcode <code>[tina_mvc controller="shortcode" role_to_view="-1"]</code>
* in a post or page. You can also find it at : /tina-mvc-for-wordpress/shortcode
*
* The widgets_page.php file shows how to group all your widgets into one file (if you want)
* using the dispatcher method. You can do the same with your shortcodes.
*
* @see test_page.php notes on putting everything in the constructor and not using the add_var() and add_var_e() functions.
* 
* @package    Tina-MVC
* @author     Francis Crossen <francis@crossen.org>
*/
class shortcode_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );
        
        $out = '<div style="border: 1px dotted red; color: black; background-color: #fcc;">';
        $out .= 'This text is generated from the \'shortcode\' controller<br />';
        $out .= tina_mvc_db_time() . '<br />';
        $out .= tina_mvc_db_date();
        $out .= '</div>';
        
        $this->set_post_title('Happy '.date('l')); // Titles are not visible in shortcodes...
        $this->set_post_content($out);
        
    }

}


?>
