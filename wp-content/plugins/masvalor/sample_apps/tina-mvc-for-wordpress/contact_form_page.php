<?php
//
// $Id: contact_form_page.php, v 0.00 Sun Feb 21 2010 19:41:03 GMT+0000 (IST) Francis Crossen $
//

/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A contact form
*
* Access it at: /tina-mvc-for-wordpress/contact-form
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @uses         contact_form_view.php the view file
*/
class contact_form_page extends tina_mvc_base_page_class {
 
    /**
     * Note we are using a PHP5 constructor here.
     */
    function __construct( $request ) {
 
        /**
         * Override the $role_to_view so anyone can access this page controller.
         */
        $this->role_to_view = FALSE;
 
        /**
         * Call the parent constructor. This is where permissions checks are carried out.
         */
        parent::__construct(  $request );
 
        /**
         * Include and create a new form object.
         */
        tina_mvc_include_helper('tina_mvc_form_helper');
        $f = new tina_mvc_form_helper_class( 'contact-us' );
        
        /**
         * <code>$f->add_form_message('Don\'t be tempted to enter any REAL information below...!');</code>
         * 
         * You'll see why later!
         */
        $f->add_form_message('Don\'t be tempted to enter any REAL information below...!');
 
        /**
         * Add a your_name field
         */    
        $f->add_field( 'your_name', 'text', FALSE, $db_table='default', $db_field=false, FALSE, $extraAttrib='' );
        $_rules = array( 'required'=>NULL  );
        $f->add_validation_rules( 'your_name', $_rules );
 
        /**
         * Add a your_email field
         */    
        $f->add_field( 'your_email', 'text', FALSE, $db_table='default', $db_field=false, FALSE, $extraAttrib='' );
        $_rules = array( 'required'=>NULL, 'email'=>NULL  );
        $f->add_validation_rules('your_email', $_rules );
 
        /**
         * Add a your_email_again field
         */            
        $f->add_field( 'your_email_again', 'text', FALSE, $db_table='not_needed', $db_field=false, FALSE, $extraAttrib='' );
        $_rules = array( 'required'=>NULL, 'email'=>NULL, 'equaltofield'=>'your_email'  );
        $f->add_validation_rules('your_email_again', $_rules );
 
        /**
         * Add a your_message field
         */            
        $f->add_field( 'your_message', 'textarea', FALSE, $db_table='default', $db_field=false, FALSE, $extraAttrib='' );
        $_rules = array( 'required'=>NULL  );
        $f->add_validation_rules( 'your_message', $_rules );
 
        /**
         * Add a reCaptcha field - if API keys are set. Go to http://www.recaptcha.net to get one.
         */            
        if( get_option('tina_mvc_recaptcha_pub_key') AND get_option('tina_mvc_recaptcha_pri_key') ) {
            $f->add_field( 'prove-you-are-human', 'recaptcha' );
        }
 
        /**
         * Add a Submit button
         */            
        $f->add_field( 'submit-button', 'submit', '', 'not_needed', false, 'Send Message' );
 
        /**
         * Add a Cancel button
         */            
        $f->add_field( 'cancel-button', 'submit', '', 'not_needed', false, 'Clear Form' );
 
        /**
         * Check if the cancel-button was submitted and redirect
         */
        if( $f->get_posted_field_value('cancel-button') ) {
 
            wp_redirect( $_SERVER['REQUEST_URI'] );
            exit();
 
        }
 
        /**
         * Build the form, checking for POSTed values and for validation errors
         */            
        $f->build_form();
        
        /**
         * Initialise a variable for view data. Array, object, you decide.
         */
        $view_data = new stdClass;
        
        /**
         * Look for table data. FALSE if not POSTed or validation errors. Default table is 'NONE'
         */
        if( $tbl = $f->get_table_data( 'default' ) ) {
 
            /**
             * Grab the POSTed variables for emailing. 
             */
            $form_data['subject'] = 'Contact Us form submission';
            $form_data['body'] = print_r( $tbl, 1 );
            
            $view_data->emailed_ok_message = 'Your message has been sent to <a href="http://www.mailinator.com/maildir.jsp?email=tina-mvc-for-wordpress">tina-mvc-for-wordpress@mailinator.com</a> (if your webserver can send email). Read the source of '
                                 .__FILE__.' to see how you can customise this app.';
            
            /**
             * Send an email
             */
            tina_mvc_mail( 'tina-mvc-for-wordpress@mailinator.com' , 'blank' , $form_data );
            
        }
        /**
         * Grab the HTML for the form. Includes any validation messages.
         */
        $view_data->the_form = $f->get_form_html();
        
        /**
         * Any POSTed data?
         */
        if( isset($form_data) ) {
 
            /**
             * Use the tina helper function to make sure any data we send to the view file is escaped.
             */
            $view_data->form_data = tina_mvc_esc_html_recursive( print_r($tbl, 1) );
        }
        else {
            $view_data->form_data = FALSE;
        }
 
        /**
         * Trivial example, but escaping is a good habit to get into
         */
        $post_title = tina_mvc_esc_html_recursive( 'Contact Us' );
 
        /**
         * Load the view file, and pass view data to it
         */
        $post_content = $this->load_view( 'contact_form', $view_data );
 
        /**
         * Finally assign the title and content and we are done.
         */
        $this->set_post_title( $post_title );
        $this->set_post_content( $post_content );
 
    }
 
}
 
?>