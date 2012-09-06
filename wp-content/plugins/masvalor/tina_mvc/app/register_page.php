<?php
/**
* The register controller
*
* Can be substituted for the Wordpress registration functions. Hides Wordpress
* from users
*
* @package    Tina-MVC
* @subpackage Tina-Core-Page-Controllers
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * Manages all registration, password, login functions
 *
 * @param   array $request extracted from $_GET - /controller/action/some/data
 * @return  null sets the page_content and page_title
 * 
 * @package    Tina-MVC
 * @todo    Users post-login dashboard page
 */
class register_page extends tina_mvc_base_page_class {
    
    /**
    * Check the request and call the appropriate class method
    *
    * @param   array $request extracted from $_GET - /controller/action/some/data
    */
    function __construct( $request ) {
        
        // permission override - this controller should be accessible to all...
        $this->role_to_view = FALSE;
        parent::__construct(  $request );
        
        // what action are we doing?
        // pop the first array element from $request ('user')...
        array_shift( $request );
        
        if( !$request OR ! is_array($request) ) {
            $this->index();
        }
        elseif( $request[0] == 'user_created' ) {
            $this->user_created( $request );
        }
        elseif( $request[0] == 'user_not_created' ) {
            $this->user_not_created( $request );
        }
        elseif( $request[0] == 'recover_password' ) {
            $this->recover_password( $request );
        }
        elseif( $request[0] == 'reset_password' ) {
            $this->reset_password( $request );
        }
        elseif( $request[0] == 'password_reset_sent' ) {
            $this->password_reset_sent( $request );
        }
        else {
            $this->index();
        }
        
    }
    
    /**
    * Default controller
    *
    * Displays and process the registration form. Will create a user and email
    * their login details to them on success
    */
    function index() {
        
        tina_mvc_include_helper('tina_mvc_form_helper');
        $f = new tina_mvc_form_helper_class( 'register_form' );
        
        $f->add_field( 'username', 'text', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL );
        $f->add_validation_rules('username', $_rules );
        
        $f->add_field( 'email', 'text', false, 'NONE', false, $def=FALSE );
        $_rules = array( 'required'=>NULL, 'EMAIL'=>NULL );
        $f->add_validation_rules('email', $_rules );
        
        if( get_option('tina_mvc_recaptcha_pub_key') AND get_option('tina_mvc_recaptcha_pri_key') ) {
            $f->add_field( 'are-you-human', 'recaptcha', 'Are you human?' );
        }
        else {
            $f->add_form_message(__('NB: This form would be more secure if you entered your reCaptcha keys in $tina_mvc_app_settings.php.'));
        }
        
        $f->add_field( 'submit-button', 'submit', '', 'NONE', false, 'Register' );
        
        $f->build_form();    // this also checks for validation errors and if posted...
        
        if( $applicant = $f->get_table_data() ) {
            
            require ( ABSPATH . WPINC . '/registration.php' );
            // username string is OK?
            if( ! validate_username( $applicant->username ) ) {
                $f->add_field_error_message('username',' contains invalid characters.'); // sets $f->validation_errors too
            }
            // username already exists?
            if( username_exists( $applicant->username ) ) {
                $f->add_field_error_message('username',' already exists in the system.');
            }
            // email already exists?
            if( email_exists( $applicant->email ) ) {
                $f->add_field_error_message('email',' already exists in the system.');
            }

            if( ! $f->validation_errors ) {
            
                $user_pass = wp_generate_password();
                $user_id = wp_create_user( $applicant->username, $user_pass, $applicant->email );
                
                if ( !$user_id ) {
                    wp_redirect( tina_mvc_make_controller_url('register/user-not-created') );
                }
                
                // email the new user...
                $V = array( 'username'=>$applicant->username, 'password'=>$user_pass );
                tina_mvc_mail( $applicant->email , 'user_register' , $V );
                
                wp_redirect( tina_mvc_make_controller_url('register/user-created/'.urlencode( $applicant->username )  ) );
                exit();
                
            }
            
        }
        
        $this->set_post_title('User Registration');
        $vars = array();
        $vars['register_form'] = $f->get_form_html();
        $this->set_post_content( $this->load_view('register_register', $vars ) );
        
    }

    /**
    * Password recovery page
    *
    * Displays and process the recovery form. Generates a Wordpress activation
    * key and emails the user a url to the password reset page
    * 
    * @param   array $request extracted from $_GET - /controller/action/some/data
    * @todo    See comments c. line 234 about security of non expiring hashes
    */
    function recover_password( $request) {
        
        tina_mvc_include_helper('tina_mvc_form_helper');
        $f = new tina_mvc_form_helper_class( 'recover_pass_form' );
        
        $f->add_field( 'username', 'text', false, 'NONE', false, $def=FALSE );
        
        $f->add_field( 'email', 'text', false, 'NONE', false, $def=FALSE );
        
        if( get_option('tina_mvc_recaptcha_pub_key') AND get_option('tina_mvc_recaptcha_pri_key') ) {
            $f->add_field( 'are-you-human', 'recaptcha', 'Are you human?' );
        }
        else {
            $f->add_form_message(__('NB: This form would be more secure if you entered your reCaptcha keys in $tina_mvc_app_settings.php.'));
        }
        
        $f->add_field( 'submit-button', 'submit', '', 'NONE', false, 'Reset Password' );
        
        $f->build_form();    // this also checks for validation errors and if posted...
        
        if( $recover = $f->get_table_data() ) {
            
            require ( ABSPATH . WPINC . '/registration.php' );
            global $wpdb;
            
            //echo "<pre>" . var_export( $recover,1) . '<br><br>';
            
            // require username or email...
            if( ! $recover->username AND ! $recover->email ) {
                $f->add_field_error_message('username',' or \'Email\' is required to reset your password.');
            }
            
            // are we still OK?
            if( ! $f->validation_errors ) {
                
                $u = FALSE;
                if( $recover->email ) {
                    
                    $u = get_user_by_email( $recover->email );
                    
                }
                else {
                    
                    $u = get_userdatabylogin( $recover->username );
                    
                }
                
                if( ! $u ) {
                    
                    $f->add_field_error_message('username','/\'Email\' does not exist in here. Sorry, try again.');
                    
                }
                
                if( ! $f->validation_errors ) { // are we still OK?
                    
                    do_action('lostpassword_post'); // play nice with other wp plugins...
                    
                    // we have... 
                    // $u->user_login;
                    // $u->user_email;
                    
                    do_action('retreive_password', $u->user_login);  // Misspelled and deprecated  // play nice with other wp plugins...
                    do_action('retrieve_password', $u->user_login);
                    
                    $allow = apply_filters('allow_password_reset', true, $u->ID);
                    
                    if( ! $allow ) {
                        
                        $f->add_field_error_message('username',' \''.$u->user_login.'\' is not allowed to reset their password.');
                        
                    }
                    
                    if( ! $f->validation_errors ) { // are we still OK?
                        
                        //  don't like this... why keep a hash valid forever - perhaps allow a delay between repeated requests ...?
                        // $hash = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $u->user_login));
                        // we'll figure out a better way of preventing DOS - trac#14 refers
                        
                        if ( TRUE OR empty($hash) ) {
                            
                            $hash = wp_generate_password(20, false);
                            do_action( 'retrieve_password_key', $u->user_login, $hash );
                            $wpdb->update($wpdb->users, array('user_activation_key' => $hash), array('user_login' => $u->user_login));
                        }
                        
                        // send the email...
                        $V = array( 'username'=>$u->user_login, 'hash'=>$hash );
                        tina_mvc_mail( $u->user_email , 'register_recover_password' , $V );
                        
                        wp_redirect( tina_mvc_make_controller_url('register/password-reset-sent/'.urlencode( $u->user_login )  ) );
                        exit();
                        // done...
                        
                    }
                    
                }
                
            }
            
            // if we're still here it's time to display the form...
            
        }
        
        
        $this->set_post_title('Reset Password');
        $vars = array();
        $vars['password_recover_form'] = $f->get_form_html();
        $this->set_post_content( $this->load_view('register_recover_password', $vars ) );
        
    }

    /**
     * Parse the reset password link that a user was sent in their email
     *
     * Verifies the hash/key in the $request and resets the users password on
     * success and emails a new password
     *
     * @param   array $request extracted from $_GET - /controller/action/some/data
     */
    function reset_password( $request) {
        
        array_shift( $request ); // should be 'reset_password'...
        
        if( $request AND $request[0] ) {
            $username = strip_tags( urldecode( $request[0] ) );
        }
        else {
            $username = FALSE;
        }
        
        if( $request AND $request[1] ) {
            $hash = strip_tags( urldecode( $request[1] ) );
        }
        else {
            $hash = FALSE;
        }
        
        $V = array( 'no_hash_or_username'=>FALSE,
                    'no_hash'=>FALSE,
                    'bad_hash'=>FALSE,
                    'new_password_sent'=>FALSE ); // for the template... // also counts to flag errors...
        
        if( ! $hash AND ! $username ) {
            
            $V['no_hash_and_username'] = 'The link you followed to this page is invalid.';
            
        }
        else {
            
            // find the user...
            global $wpdb;
            
            if( ! ( $hash = preg_replace( '/[^a-z0-9]/i', '', $hash ) ) ) { // based on WP function...
            
                $V['no_hash'] = 'The link you followed contained a bad security key.';
            
            }
            else {
                
                $u = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $hash, $username ) );
                if ( empty( $u ) ) {
                    
                    $V['bad_hash'] = 'The link you followed was invalid.';
                    
                }
                else {
                    
                    $new_password = wp_generate_password();
                    do_action('password_reset', $u, $new_password);  // play nice with other plugins
                    wp_set_password($new_password, $u->ID);
                    update_usermeta($u->ID, 'default_password_nag', true); //Set up the Password change nag. // in case person logs into WP
                    $V['new_password_sent'] = 'Your password has been reset.';
                    
                    // email the user...
                    $vars = array( 'username'=>$u->user_login, 'password'=>$new_password );
                    tina_mvc_mail( $u->user_email , 'register_reset_password' , $vars );
                    
                }
                
            }
        }
        
        // finished. display the result page...
        $this->set_post_title('Reset Password');
        $this->set_post_content( $this->load_view('register_reset_password' , $V ) );
        
    }

    /**
     * Display a user created page
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username
     */
    function user_created( $request ) {
        
        array_shift( $request ); // should be 'user_created'...
        
        if( $request AND $request[0] ) {
            $username = strip_tags( urldecode( $request[0] ) ); // escape for HTML display...
        }
        else {
            $username = FALSE;
        }
        
        $vars = array('username'=>$username);
        $this->set_post_content( $this->load_view('register_user_created', $vars ) );
        
    }

    /**
     * Display a user NOT created page
     *
     * @param   array $request extracted from $_GET - (unused here)
     * @author  Francis Crossen <francis@crossen.org>
     * @since   Sat Jan 23 2010 22:27:18 GMT+0000 (IST)
     * @version v 0.00 Sat Jan 23 2010 22:27:18 GMT+0000 (IST)
     */
    function user_not_created( $request ) {
        
        $this->set_post_content( $this->load_view('register_user_not_created' ) );
        
    }

    /**
     * Display a password reset link sent page
     *
     * Dispalyed after a user has sucessfuly requested a password reset
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username - provides the username
     */
    function password_reset_sent( $request ) {
        
        array_shift( $request ); // should be 'password_reset_sent'...
        
        if( $request AND $request[0] ) {
            $username = strip_tags( urldecode( $request[0] ) ); // escape for HTML display...
        }
        else {
            $username = FALSE;
        }
        
        $vars = array('username'=>$username);
        $this->set_post_content( $this->load_view('register_password_reset_sent', $vars ) );
        
    }

}


?>