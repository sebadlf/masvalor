<?php
//
// $Id: user_page.php, v 0.00 Sun Jan 24 2010 19:01:26 GMT+0000 (IST) Francis Crossen $
//

/**
 * The user view, edit pages
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The user view/edit pages for their data
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @todo      write a 404 type page for our parent... we can call it in case there is no default controller called for example...    
 */
class user_page extends tina_mvc_base_page_class {
    
   /**
    * Check the request and call the appropriate class method
    *
    * @param   array $request extracted from $_GET - /controller/action/some/data
    * @author  Francis Crossen <francis@crossen.org>
    * @since   Sat Jan 23 2010 21:45:38 GMT+0000 (IST)
    * @version v 0.00 Sat Jan 23 2010 21:45:38 GMT+0000 (IST)
    */
    function __construct( $request ) {
        
        // permission override - this controller should be accessible to loged in users...
        $this->role_to_view = '';
        parent::__construct(  $request );
        
        // what action are we doing?
        // pop the first array element from $request ('user')...
        array_shift( $request );

        if( $request[0] == 'my_personal_data' ) {
            $this->my_personal_data( $request );
        }
        elseif ( $request[0] == 'edit_personal_data' ) {
            $this->edit_personal_data( $request );
        }
        else {
            // back to whence we came... we have no default controller here...
            wp_redirect( tina_mvc_make_controller_url('') );
        }
       
    }

    /**
     * Display the users personal data
     *
     * This function displays personal data with a link to edit it.
     * You override it by putting your own 'user_my_personal_data_view.php'
     * file in the app/ folder
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username (ignored here)
     * @todo set the post_title consistently throughout Tina
     */
    function my_personal_data( $request ) {
        
        $tpl_vars = new stdClass; // for the 'view'
        
        // get the users details...
        global $current_user;
        get_currentuserinfo();
        $tpl_vars->user = $current_user;
        
        $this->set_post_content( $this->load_view('user_my_personal_data', $tpl_vars ) );
        
    }
    
    /**
     * Edit users personal data
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username (ignored here)
     * @todo    add a 'data updated message' after a sucessful update.
     * @see form->add_form_message()
     * @todo    do we need to implement the Wordpress 'password_reset' action hook
     */
    function edit_personal_data( $request ) {
        
        $tpl_vars = new stdClass; // for the 'view'
        
        // get the users details...
        global $current_user;
        get_currentuserinfo();
        
        array_shift( $request ); // should be 'edit_personal_data'...
        
        if( $request AND $request[0] ) {            
            $form_message = $request[0]; // 'password_changed' or 'email_address_changed'
        }
        else {
            $form_message = FALSE;
        }
        
        $tpl_vars->user = $current_user;
        
        tina_mvc_include_helper('tina_mvc_form_helper');
        $f = new tina_mvc_form_helper_class( 'edit_email_form' );
        
        $f->add_field( 'email', 'text', false, 'NONE', false, $def=FALSE );
        
        $f->add_field( 'the_password', 'password', false, 'NONE', false, $def=FALSE );
        
        $f->add_field( 'submit-button', 'submit', '', 'NONE', false, 'Change Email address' );
        
        if( $form_message == 'email_address_changed' ) {
            $f->add_form_message( 'Email address changed' );
        }
        
        $f->build_form();    // this also checks for validation errors and if posted...
        
        if( $change_email = $f->get_table_data() ) {
            
            require ( ABSPATH . WPINC . '/registration.php' );
            global $wpdb;
            
            if( $change_email->email ) {
                
                // make sure it is OK
                if( $errStr = $f->validate_as_EMAIL( 'email' ) ) {                    
                    $f->add_field_error_message( 'email' ,$errStr);
                }
                
                if( !$f->validation_errors ) {
                    
                    // make sure it isn't attached to another user...
                    if( $test_user = get_user_by_email( $change_email->email ) ) {
                        $f->add_field_error_message( 'email' ,' is attached to another user.');
                    }
                    
                }
                
                  // verify password
                  $result = wp_authenticate( $current_user->user_login, $change_email->the_password );
                  
                  if( is_wp_error( $result ) ) {
                      
                      $f->add_field_error_message( 'the_password' ,' is incorrect.');
                      
                  }
                
                if( !$f->validation_errors ) {
                    
                    // update the email address
                    $new_user = array( 'ID'=>$current_user->ID, 'user_email'=>$change_email->email );
                    $user_id = wp_update_user( $new_user );
                    
                    if( ! $user_id ) {
                        $f->add_field_error_message( 'email' ,' or \'Password\' caused an unspecified problem. You could try again.');
                    }
                    
                }
                
                if( !$f->validation_errors ) {
                 
                    // we're done
                    wp_redirect( tina_mvc_make_controller_url('user/edit-personal-data/email-address-changed' ) );
                    exit();
                    
                }
                
                
            }
            
        }
        // if we got here without a redirect we need our form...
        $tpl_vars->edit_email_form = $f->get_form_html();
        
        tina_mvc_include_helper('tina_mvc_form_helper');
        $g = new tina_mvc_form_helper_class( 'edit_password_form' );
        
        $g->add_field( 'current_password', 'password', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL );
        $g->add_validation_rules('current_password', $_rules );
        
        $g->add_field( 'new_password', 'password', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL );
        $g->add_validation_rules('new_password', $_rules );
        
        $g->add_field( 'new_password_again', 'password', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL, 'EQUALTOFIELD'=>'new_password' );
        $g->add_validation_rules('new_password_again', $_rules );
        
        $g->add_field( 'submit-button', 'submit', '', 'NONE', false, 'Change Password' );
        
        if( $form_message == 'password_changed' ) {
            $g->add_form_message( 'Password changed' );
        }

        $g->build_form();    // this also checks for validation errors and if posted...
        
        if( $change_pass = $g->get_table_data() ) {
            
            require ( ABSPATH . WPINC . '/registration.php' );
            global $wpdb;
            
            // verify password
            $result = wp_authenticate( $current_user->user_login, $change_pass->current_password );
            
            if( is_wp_error( $result ) ) {
                
                $g->add_field_error_message( 'current_password' ,' is incorrect.');
                
            }
            
            if( !$g->validation_errors ) {
                
                // update the password
                wp_set_password( $change_pass->new_password, $current_user->ID );
                
                // login the user with the new credentials...
                $u = wp_signon( array( 'user_login'=>$current_user->user_login, 'user_password'=>$change_pass->new_password ), false );
                if( !is_wp_error($u) ) {
                    
                    // we're done
                    wp_redirect( tina_mvc_make_controller_url('user/edit-personal-data/password-changed' ) );
                    exit();
                    
                }
                else {
                    
                    $g->add_form_error_message( 'There was a problem logging you in after your password was changed.');
                    
                }
                
                
            }
           
        }
        // if we got here without a redirect we need our form...
        $tpl_vars->edit_password_form = $g->get_form_html();
        
        $this->set_post_content( $this->load_view('user_edit_personal_data', $tpl_vars ) );
        
    }
    
}


?>