<?php
//
// $Id: tina_mvc_controller_class.php, v 0.00 Sat Jan 23 2010 22:08:09 GMT+0000 (IST) Francis Crossen $
//

/**
* The main Tina controller
*
* Responsible for taking the controller request and appying permissions to it.
* If called from the wordpress Tina page (the front end controller) it will
* check permissions and display a login form.
*
* @package    Tina-MVC
* @subpackage Tina-Core-Classes
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The main Tina controller
 *
 * Responsible for taking the controller request and applying permissions to it.
 * If called from the wordpress Tina page (the front end controller) it will
 * check permissions and display a login form.
 * 
 * @package    Tina-MVC
 * 
 * @param   array $request extracted from $_GET - /controller/action/some/data
 * @param   mixed $role_to_view FALSE allows general access, <> FALSE enforces
 *                              mandetory login or string role
 * @param   mixed $capability_to_view overrides the role_to_view above
 * @param   mixed $called_from 'PAGE_FILTER', 'WIDGET' or 'SHORTCODE'
 * @param   string $custom_folder an overriding location to look for the controller in
 * @param   string $shortcode_content the content encapsulated by the tina_mvc shortcode (if any)
 * 
 * @todo    role and group based permissions
 * @todo    move code out of the constructor
 * @todo    create a function to pull items from the $request array and move it to tina_mvc_functions.php
 * @todo    remove all the ugly debug echo statments
 * @todo    check the default post title is being set consistently
 */
class tina_mvc_controller_class {
    
    protected $request, $the_post_title, $the_post_content, $allow_http_redirects, $PAGE, $called_from;
    
    var $shortcode_content;
    
    function __construct( $request=false, $role_to_view=NULL, $capability_to_view=NULL, $called_from=FALSE, $custom_folder='', $shortcode_content='' ) {
        
        $this->called_from = $called_from;
        // we need this for the forms helper
        /**
         * @todo removed the requirement for $this->called_from - redundant
         */
        define( 'TINA_MVC_CONTROLLER_CALLED_FROM' , $this->called_from );
        
        if( $this->called_from == 'PAGE_FILTER' ) {
            $this->allow_http_redirects = TRUE;
        }
        else {
            $this->allow_http_redirects = FALSE;
        }
        
        if( !$request ) {
            $this->request = array( 'index' );
        }
        else {
            
            // a class name cannot contain a '-' if it is there we replace with an underscore
            if( strpos($request,'-') !== false ) {
                $request = str_replace('-','_',$request);
            }
            
            // we explode the request on '/'        
            $request = strip_tags( $request ); // xss filter...
            $this->request = explode('/',$request);
            
        }

		/*$aux_sub_controller_name_vars = explode('&',$this->request[0]);
        $sub_controller_name = $aux_sub_controller_name_vars[0].'_page';*/
        $sub_controller_name = $this->request[0].'_page';
        // we do this here so we can trigger a 404 without going through an authentication check.
        $this->PAGE = tina_mvc_get_instance_of( $sub_controller_name , $this->request, $this->called_from, $custom_folder, $shortcode_content );
        
        /**
         * @todo check if this is working. it sems to have got lost somewhere...
         */
        $this->the_post_title = get_option( "tina_mvc_page_title" );
        
        // echo '1:'; var_export( $role_to_view ); echo "<hr>";
        // echo '2:';var_export( $this->PAGE->role_to_view ); echo "<hr>";
        // echo '2a:'; var_export( $this->PAGE->role_to_view ); echo "<hr>";
        // the page controller can override the capability to view...
        if( ! is_null($this->PAGE->capability_to_view) ) {
            $capability_to_view = $this->PAGE->capability_to_view;
        }

        // we allow the sub controller to override permissions...
        if( ! is_null($this->PAGE->role_to_view) ) {
            $role_to_view = $this->PAGE->role_to_view;
        }
        elseif( is_null($role_to_view) ) {
            $role_to_view = get_option( 'tina_mvc_default_role_to_view' );
        }
        // if we are called from a SHORTCODE we might have been passed '-1' as a role_to_view...
        if( ($called_from == 'SHORTCODE') AND ($role_to_view == '-1') ) $role_to_view = FALSE;
        
        // finally, in case we have multiple role/capabilities...
        if( $role_to_view ) {
            $role_to_view = explode( ',', strtolower($role_to_view) );
        }
        if( $capability_to_view ) {
            $capability_to_view = explode( ',', strtolower($capability_to_view) );
        }
        
        // echo 'CHECK:'; var_export( $role_to_view ); echo "<hr>";
        // echo 'CHECK:'; var_export( tina_mvc_user_has_role($role_to_view) ); echo "<hr>";
        $_authenticated = FALSE; //  the default
        $_auth_rule = '---'; //  for debugging
        
        if( $role_to_view === FALSE ) { // no premissions required
            $_authenticated = TRUE;
            $_auth_rule = 'NONE'; //  for debugging
        }
        elseif( !$role_to_view AND !is_null($capability_to_view) AND $capability_to_view AND tina_mvc_user_has_capability($capability_to_view) ) { // capability required
            $_authenticated = TRUE;
            $_auth_rule = 'CAP'; //  for debugging
        }
        elseif( $role_to_view AND is_user_logged_in() AND tina_mvc_user_has_role($role_to_view) ) { // role required
            $_authenticated = TRUE;
            $_auth_rule = 'ROLE'; //  for debugging
        }
        elseif( ! $role_to_view AND ! $capability_to_view AND is_user_logged_in() ) { // $role_to_view AND $capability_to_view is '' or 0 - non-Boolean FALSE
            $_authenticated = TRUE;
            $_auth_rule = 'LOGIN'; //  for debugging
        }
        elseif( ($called_from!=='SHORTCODE') AND ($called_from!=='WIDGET') AND $this->do_login() ) { // we only do logins (and redirects) from the main front end controller
            //$_authenticated = TRUE;
            
            // we get here after the login has been sucessfully validated
            // we will redirect to the main controller - this is so the widgets (which have been initalised by Wordpress at this stage)
            // have already checked if a user is logged in and will not display content
            
            wp_redirect( tina_mvc_make_controller_url() );
            exit();
        }
        
        /**
         * Handy debugging code if you are having trouble with permissions...
         */
        /*
        echo 'r2v:'; var_export( $role_to_view ); echo "<br>";
        echo 'has(r2v):'; var_export( current_user_can($role_to_view) ); echo "<br>";
        echo 'c2v:'; var_export( $capability_to_view ); echo "<br>";
        echo 'has(c2v):'; var_export( current_user_can($capability_to_view) ); echo "<br>";
        echo 'AUTHRULE:'; var_export( $_auth_rule ); echo "<br>";
        echo 'AUTH:'; var_export( $_authenticated ); echo "<hr>";
        */
        if( $_authenticated ) {
            
            // are we using the dispatcher...?
            // will return true if the page controller has not set $PAGE->use_dispatcher = TRUE
            $this->PAGE->dispatch();
            
            if( $this->PAGE->get_post_title() ) {
                $this->the_post_title = $this->PAGE->get_post_title();
            }
            
            $this->the_post_content = $this->PAGE->get_post_content();
            
        }
        else {
            
            /**
             * @todo is this needed?
             */
            // $this->the_post_title = '';
            // $this->the_post_content = '';
            
        }
        
    }
    
    public function do_login() {
        
        if( $this->allow_http_redirects ) {
            
            tina_mvc_include_helper('tina_mvc_form_helper');
            $f = new tina_mvc_form_helper_class( 'login_form' );

            $f->add_field( 'user_login', 'text', false, 'NONE', false, $def=FALSE );
            $_rules = array( 'required'=>NULL );
            $f->add_validation_rules('user_login', $_rules );
            
            $f->add_field( 'user_password', 'password', false, 'NONE', false, $def=FALSE );
            $_rules = array( 'required'=>NULL );
            $f->add_validation_rules('user_password', $_rules );
                
            $f->add_field( 'remember', 'checkbox', false, 'NONE', false, $def=FALSE );
    
            $f->add_field( 'wp-submit', 'submit', $label='', 'NONE', false, 'Login' );
            
            $f->build_form();    // this also checks for validation errors and if posted...
            
            $_display_form = FALSE;
            if( $credentials = $f->get_table_data() ) { // form was submitted
                
                $u = wp_signon( get_object_vars( $credentials ), false );
                if( !is_wp_error($u) ) {
                    
                    return TRUE; // we are logged in and done ...
                    
                }
                else {
                    $f->add_form_error_message(  'The username and/or password is incorrect.' );
                }
                
            }
            
            // if we got here we are not authenticated - display the form...
            // if there is a _do_login view we will use it...
            
            $login_form = $f->get_form_html();
            
            //echo 
            
            if( $this->PAGE->view_file_exists('tina_mvc_do_login') ) {
                $page_vars = array();
                $page_vars['login_form'] = $login_form;
                $this->the_post_content = $this->PAGE->load_view('tina_mvc_do_login',$page_vars);
            }
            else {
                $this->the_post_content = $login_form;
            }
          
            return false;
            
        }
        
    }
    
    public function get_post_title() {
        return $this->the_post_title;
    }
    
    public function get_post_content() {
        return $this->the_post_content;
    }
    
}









?>