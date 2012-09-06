<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A simple example of the tina_mvc_form_helper_class
*
* Access it at: /tina-mvc-for-wordpress/simple-form
* 
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
*/
class simple_form_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        parent::__construct(  $request );
        
        tina_mvc_include_helper('tina_mvc_form_helper');
        $f = new tina_mvc_form_helper_class( 'simple_form' );
    
        $f->add_field( 'firstname', 'text', false, 'NONE', false, $def=FALSE );
        
        $f->add_field( 'surname', 'text', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL );
        $f->add_validation_rules('surname', $_rules );
            
        $f->add_field( 'submit-button', 'submit', 'Send Label', 'NONE', false, 'SEND ON THE BUTTON' );
        
        $f->build_form();    // this also checks for validation errors and if posted...
        
        if( $tbl = $f->get_table_data() ) {
            
            $this->set_post_title('Simple Form (submitted)');
            $_pc = htmlentities(print_r($tbl,1));
            
        }
        else {
            
            $this->set_post_title('Simple Form');
            $_pc = $f->get_form_html();
            
        }
        
        $this->set_post_content( $_pc );
        
    }

}

?>