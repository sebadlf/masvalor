<?php
//
// $Id: tina_mvc_functions.php, v 0.00 Sat Jan 23 2010 21:47:32 GMT+0000 (IST) Francis Crossen $
//

/**
* General functions used throughout the Tina framework
*
* @package    Tina-MVC
* @subpackage Tina-Core-Helpers
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * Make a SQL datetime
 *
 * No checks are done on $ts parameter
 *
 * @param   integer $ts a unix timestamp. (Defaults to now)
 * @return  string  SQL datetime stamp ('YYYY-MM-DD HH:MM:SS')
 * @todo    Perhaps validation on the $ts parameter
 */
function tina_mvc_db_datetime($ts=FALSE) {
    
    if( $ts ) {
        return date( 'Y-m-d H:i:s', intval($ts) );
    }
    else {
        return date( 'Y-m-d H:i:s' );  
    }
    
}

/**
 * Format a SQL datetime as time using the Wordpress time format option
 *
 * @param   string $dt a MySQL date/time/datetime. (Defaults to now)
 * @return  string  the formatted time
 * @uses tina_mvc_pad_mysql_datetime()
 */
function tina_mvc_wp_time($dt=FALSE) {
    
    return date( get_option('time_format') , strtotime( tina_mvc_pad_mysql_datetime($dt) ) );
    
}

/**
 * Format a SQL datetime as date using the Wordpress links_updated_date_format format option
 *
 * This function may change or disappear in future versions. Experimental!
 * 
 * @param   string $dt a MySQL date/time/datetime. (Defaults to now)
 * @return  string  the formatted date
 * @uses tina_mvc_pad_mysql_datetime()
 */
function tina_mvc_wp_datetime($dt=FALSE) {
    
    return date( get_option('links_updated_date_format') , strtotime( tina_mvc_pad_mysql_datetime($dt) ) );
    
}

/**
 * Format a SQL datetime as time using the Wordpress time format option
 *
 * @param   string $dt a MySQL date/time/datetime. (Defaults to now)
 * @return  string  the formatted time
 * @uses tina_mvc_pad_mysql_datetime()
 */
function tina_mvc_wp_date($dt=FALSE) {
    
    return date( get_option('date_format') , strtotime( tina_mvc_pad_mysql_datetime($dt) ) );
    
}

/**
 * Take a MySQL date/time/datetime and ensure it matches 'yyyy-mm-dd hh:mm:ss'
 *
 * If only the time is passed, the date will be 0000-00-00. There is no serious error
 * checking done on the datetime, so dates like 9999-99-99 and times like 25:89:99
 * are considered valid.
 *
 * @param   string $dt
 * @return  string  MySQL datetime
 *
 * @todo check on valid format...
 */
function tina_mvc_pad_mysql_datetime( $dt='0000-00-00 00:00:00' ) {
    
    if( preg_match( '/^\d{2}:\d{2}:\d{2}$/' , $dt ) ) {
        // we have a time...
        return '0000-00-00 '.$dt;
        
    }
    elseif( preg_match( '/^\d{4}\-\d{2}\-\d{2}$/' , $dt ) ) {
        // we have date
        return $dt.' 00:00:00';
    }
    elseif ( preg_match( '/^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}:\d{2}$/' , $dt ) ) {
        // we have datetime
        return $dt;
    }
    else {
        tina_mvc_error( 'Invalid MySQL date, time or datetime: \''.$dt.'\'' );
    }
    
}

/**
 * Format a SQL datetime
 *
 * No checks are done on $dt parameter
 *
 * @param   string $format a datetime format. See PHP date() function
 * @param   string $dt a MySQL datetime
 * @return  string  formatted datetime
 * @todo    Perhaps validation on the $dt parameter
 */
function tina_mvc_format_db_datetime( $format='', $dt=FALSE) {
    
    // for windows
    if( function_exists('strptime' ) ) {
        $dt = strptime( $dt, '%Y-%m-%d %H:%M:%S' );
        $dt = strtotime( $dt );
    }
    else {
        $ret = array();
        $ret['tm_hour'] = intval( substr( $dt,11,2) );
        $ret['tm_min'] = intval( substr( $dt,14,2) );
        $ret['tm_sec'] = intval( substr( $dt,17,2) );
        $ret['tm_mon'] = intval( substr( $dt,5,2) );
        $ret['tm_mday'] = intval( substr( $dt,8,2) );
        $ret['tm_year'] = intval( substr( $dt,0,4) ) - 1900;
    }
    return date( $format, mktime( $dt['tm_hour'], $dt['tm_min'], $dt['tm_sec'], $dt['tm_mon'], $dt['tm_mday'], $dt['tm_year']+1900 ) );
    
}

/**
 * Make a SQL time
 *
 * No checks are done on $ts parameter
 *
 * @param   integer $ts a unix timestamp. (Defaults to now)
 * @return  string  SQL time stamp ('HH:MM:SS')
 * @todo    Perhaps validation on the $ts parameter
 */
function tina_mvc_db_time($ts=FALSE) {
    
    if( $ts ) {
        return date( 'H:i:s', intval($ts) );  
    }
    else {
        return date( 'H:i:s' );  
    }
    
}

/**
 * Make a SQL date
 *
 * No checks are done on $ts parameter
 *
 * @param   integer $ts a unix timestamp. (Defaults to now)
 * @return  string  SQL time stamp ('YYYY-MM-DD')
 * @todo    Perhaps validation on the $ts parameter
 */
function tina_mvc_db_date($ts=FALSE) {
    
    if( $ts ) {
        return date( 'Y-m-d', intval($ts) );  
    }
    else {
        return date( 'Y-m-d' );  
    }
    
}

/**
 * Get a value from $_POST
 *
 * A centralised place to get $_POST data
 *
 * Wordpress has some funky ways of treating global $_POST and $_GET variables.
 * Look at wp-settings.php (line 624 for v2.9.1):
 * <code>
 * // If already slashed, strip.
 * if ( get_magic_quotes_gpc() ) {
 *	$_GET    = stripslashes_deep($_GET   );
 *	$_POST   = stripslashes_deep($_POST  );
 *	$_COOKIE = stripslashes_deep($_COOKIE);
 * }
 *
 * // Escape with wpdb.
 * $_GET    = add_magic_quotes($_GET   );
 * $_POST   = add_magic_quotes($_POST  );
 * $_COOKIE = add_magic_quotes($_COOKIE);
 * $_SERVER = add_magic_quotes($_SERVER);
 * </code>
 * Tina assumes that you want to deal with unescaped data. If you want to store
 * it in a DB then do your own escaping
 *
 * @param   string  $var Variable name to retrieve
 * @return  mixed The $_POST var
 */
function tina_mvc_get_Post($var=NULL) {
    
    // get from post...
    if(is_null($var)) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' required a non NULL argument');
    }
    
    if( array_key_exists( $var , $_POST ) ) {
        return stripslashes($_POST["$var"]);
    }
    else {
        return FALSE;
    }
    
}

/**
 * Get a value from $_GET
 *
 * @param   string  $var The variable name to retrieve
 * @return  mixed The $_GET var
 * @see     Notes in tina_mvc_get_post()
 */
function tina_mvc_get_Get($var=NULL) {
    
    if(is_null($var)) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' required a non NULL argument');
    }
    
    if( array_key_exists( $var , $_GET ) ) {
        return stripslashes($_GET["$var"]);
    }
    else {
        return FALSE;
    }
    
}

/**
 * Get a value from $_GET and if no set look in $_POST 
 *
 * @param   string  $var The variable name to retrieve
 * @return  mixed The $_GET/$_POST var
 * @uses    tina_mvc_get_Get() and tina_mvc_get_Post()
 * @see     Notes in tina_mvc_get_post()
 */
function tina_mvc_get_GetPost($var) {
    
    // get from get or post...
    if($ret=tina_mvc_get_Get($var)) {
        return $ret;
    }
    else {
        return tina_mvc_get_Post($var);
    }
    
}

/**
 * Get the blog name in a Wordpress Multisite installation
 *
 * @return strng the blog name
 */
function tina_mvc_get_multisite_blog_name() {
    
    if( ! defined( 'TINA_MVC_MULTISITE_BLOG_NAME' ) ) {
    
        global $blog_id;
        $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
        
        if( $current_blog_details->path != '/' ) {
            // we are using subfolders...
            // we get it from the path... 
            $blog_name =   substr( $current_blog_details->path , 0, -1 );
            $s= strrpos( $blog_name , '/' );
            $blog_name = substr( $blog_name, $s+1 );
        }
        else {
            // using subdomains
            $blog_name = substr( $current_blog_details->domain , 0 , strpos( $current_blog_details->domain , '.' ) );
        }
        
        define( 'TINA_MVC_MULTISITE_BLOG_NAME' , $blog_name );
        
    }
    
    return TINA_MVC_MULTISITE_BLOG_NAME;
    
}

/**
 * Find the path to the Tina MVC plugin folder
 *
 * @return  string The path to the Tina MVC plugin folder (no trailing slash)
 */
function tina_mvc_find_plugin_folder() {
    return (TINA_MVC_PLUGIN_DIR);
}

/**
 * Find the path to your app folder
 *
 * This is where you should place your own page controllers, views and models
 * 
 * In multisite, in tina-mvc/multisite_app/sites/example/app or tina-mvc/multisite_app/default/app, in
 * non multisite, in tina-mvc/app.
 *
 * This is an internal helper function. You don't generally need to call it.
 * 
 * @return  string the path to your app folder (no trailing slash)
 * @uses    tina_mvc_find_plugin_folder()
 */
function tina_mvc_find_app_folder() {
    
    if( ! defined( 'TINA_MVC_PRIMARY_APP_FOLDER' ) ) {
        
        $primary_app_folder = FALSE;
        $secondary_app_folder = FALSE;
        
        if( get_option('tina_mvc_enable_multisite') ) {
            
            if( is_dir( ($d1=TINA_MVC_PLUGIN_DIR.'/app_multisite/sites/'.tina_mvc_get_multisite_blog_name()) ) ) {
                $primary_app_folder = $d1;
            }
            elseif( is_dir( ($d2=TINA_MVC_PLUGIN_DIR.'/app_multisite/default') ) ) {
                $primary_app_folder = $d2;
            }
            else {
                tina_mvc_error( "Can't find a suitable primary app folder in 'app_multisite'. Looked in $d1 and $d2" );
            }
            
            if( get_option('tina_mvc_multisite_app_cascade' ) ) {
                
                if( is_dir( ($d=TINA_MVC_PLUGIN_DIR.'/app_multisite/default') ) ) {
                    $secondary_app_folder = $d;
                }
                else {
                    tina_mvc_error( "Can't find a suitable secondary app folder in 'app_multisite'. Looked in $d" );
                }
                
            }
            
            
        }
        else {
            
            $primary_app_folder = tina_mvc_find_plugin_folder();
            
        }
        
        define( 'TINA_MVC_PRIMARY_APP_FOLDER' , $primary_app_folder.'/app' );
        
        if( $secondary_app_folder ) {
            define( 'TINA_MVC_SECONDARY_APP_FOLDER' , $secondary_app_folder.'/app' );
        }
        else {
            define( 'TINA_MVC_SECONDARY_APP_FOLDER' , TINA_MVC_PRIMARY_APP_FOLDER );
        }
        
    }
    
    return TINA_MVC_PRIMARY_APP_FOLDER;
    
}

/**
 * Find the path to the app_libs folder
 *
 * A sensible place for your own 3rd party libraries
 *
 * @return  string the path to the app_libs folder (no trailing slash)
 */
function tina_mvc_find_app_libs_folder() {
    return tina_mvc_find_app_folder().'/../app_libs';
}

/**
 * Find the path to the app_install_remove folder
 *
 * Your code - run on install and remove - lives here
 *
 * @return  string the path to the app_install_remove folder (no trailing slash)
 */
function tina_mvc_find_app_install_remove_folder() {
    return tina_mvc_find_app_folder().'/../app_install_remove';
}

/**
 * Find the path to the Tina MVC libs folder
 *
 * A sensible place for 3rd party libraries (e.g. reCaptcha)
 *
 * @return  string the path to the Tina MVC libs folder (no trailing slash)
 */
function tina_mvc_find_libs_folder() {
    return tina_mvc_find_app_folder().'/../tina_mvc/libs';
}

/**
 * Find the path to the Tina MVC emails folder
 *
 * Email templates are placed here
 *
 * @return  string the path to the Tina MVC emails folder (no trailing slash)
 * @uses    tina_mvc_find_plugin_folder()
 * @deprecated since 2010-02-15
 */
function tina_mvc_find_emails_folder() {
    tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' has been depreciated since 2010-02-15.');
    return tina_mvc_find_plugin_folder().'/emails';
}

/**
 * Find the path to the Tina MVC tina_mvc folder
 *
 * All base Tina MVC files live here (controllers, views, etc)
 *
 * @return  string the path to the Tina MVC libs folder (no trailing slash)
 */
function tina_mvc_find_tina_mvc_folder() {
    return tina_mvc_find_plugin_folder().'/tina_mvc';
}

/**
 * Find the path to the Tina MVC app_bootstrap folder
 *
 * @return  string the path to the Tina MVC app_bootstrap folder (no trailing slash)
 */
function tina_mvc_find_app_bootstrap_folder() {
    return tina_mvc_find_app_folder().'/../app_bootstrap';
}

/**
 * Find the path to the Tina MVC app_init_bootstrap folder
 *
 * @return  string the path to the Tina MVC app_init_bootstrap folder (no trailing slash)
 */
function tina_mvc_find_app_init_bootstrap_folder() {
    return tina_mvc_find_app_folder().'/../app_init_bootstrap';
}

/**
 * Include a helper file from tina_mvc/helpers folder
 *
 * @param  string the name of the helper without the '_class.php'
 * @todo   remove inefficient include_once()
 */
function tina_mvc_include_helper( $helper ) {
    
  if ( file_exists(  ($_f=tina_mvc_find_tina_mvc_folder().'/helpers/'.$helper.'_class.php')) ) {
    include_once( $_f  );
  }
  else {
    tina_mvc_error( __FUNCTION__." ( $helper ) can't find ".$_f );
  }
    
}

/**
 * Make a url to a Tina MVC controller
 *
 * For example, you want to call 'my-app/my-action' and your current front end page controller is 'tina-mvc'
 * this will give you http://example.com/tina-mvc/my-app/my-action. This will fail when used from shortcodes and widgets
 * (because they are not accessed through a front end page controller). In that case you can specify
 * the absolute path to your controller by setting $absolute_controller_path to `true`
 *
 * This function can be called directly from with your controllers (for example if you want to do a browser header redirect)
 * but is normally used in view files (templates) with the tina_mvc_make_controller_link()
 * and tina_mvc_make_abs_controller_link() functions
 *
 * @param   string $controller The 'controller/action/data' we want to call
 * @param   boolean $absolute_controller_path set to `true` to prevent pre-pending the current front end controller to the url (for use in shortcodes and widgets). In this case you must specify the front end page controller in the contoller path e.g. 'tina-mvc/my-page-controller/some-action'
 *
 * @see     tina_mvc_make_controller_link() and tina_mvc_make_abs_controller_link()
 * @return  string An absolute URL to the controller
 * @todo   perhaps get a default front end controller page to direct someone to instead of get_option('home')...
 */
function tina_mvc_make_controller_url($controller='', $absolute_controller_path=false) {
    
    $home = get_home_url();
    
    
    if( $absolute_controller_path ) {
          $_page_link = "$home/$controller";
    }
    else {
      if( defined('TINA_MVC_PAGE_CONTROLLER_ID') ) { // no permalinks
          $_page_link = get_page_link( TINA_MVC_PAGE_CONTROLLER_ID ) . "/$controller";
      }
      elseif( defined('TINA_MVC_PAGE_CONTROLLER_NAME') ) {
          $_page_link = $home . '/' . TINA_MVC_PAGE_CONTROLLER_NAME . "/$controller";
      }
      else {
        
        $extraErrorMessage = "<pre><small>".print_r(debug_backtrace(),1)."</small></pre>";
        
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.': call to controller \''.$controller.'\' failed. `$absolute_controller_path==false` can ony be used when called from a front end controller page (i.e. NOT from a Widget or shortcode and NOT from a hook or action).'.$extraErrorMessage);
      }
    }
    
    return  $_page_link;
}

/**
 * Make a HTML link a Tina MVC controller
 *
 * Uses the current active Tina MVC front end page controller.
 *
 * @param   string $controller The 'controller/action/data' we want to call
 * @param   string $link_text The link text to display in the <a> element (default $controller)
 * @param   string $extra_attribs Attributes to put in the <a> tag. e.g. style or script attributes
 * @return  string An <a> element ready for browser output
 * @uses    tina_mvc_make_controller_url()
 */
function tina_mvc_make_controller_link($controller='', $link_text=FALSE, $extra_attribs='') {
    
    $ret = '<a href="' . tina_mvc_make_controller_url($controller) . '"';
    $ret .=  (  $extra_attribs  ?  ' ' . $extra_attribs  : '' );
    $ret .= '>' . (  $link_text  ?  $link_text  :  $controller )  . '</a>';
    return  $ret;
    
}

/**
 * Make an HTML link a Tina MVC controller.
 *
 * Uses this to make links to arbitrary Tina MVC front end page controllers. You should use this function in
 * your widget and shortcode page controllers when there is no active Tina MVC front end controller.
 * 
 * @param   string $controller The 'controller/action/data' we want to call
 * @param   string $link_text The link text to display in the <a> element (default $controller)
 * @param   string $extra_attribs Attributes to put in the <a> tag. e.g. style or script attributes
 * @return  string An <a> element ready for browser output
 * @uses    tina_mvc_make_controller_url()
 */
function tina_mvc_make_abs_controller_link($controller='', $link_text=FALSE, $extra_attribs='') {
    
    $ret = '<a href="' . tina_mvc_make_controller_url($controller, true) . '"';
    $ret .=  (  $extra_attribs  ?  ' ' . $extra_attribs  : '' );
    $ret .= '>' . (  $link_text  ?  $link_text  :  $controller )  . '</a>';
    return  $ret;
    
}

/**
 * Make a generic 'From:' email address
 *
 * Used by tina_mvc_mail() to make sure there is a consistent 'From:' address for any
 * emails generated by Tina MVC
 *
 * @param   string $local_user The local username to use. (Default: 'no-reply')
 * @return  string USER@SERVER email address
 * @uses    $_SERVER['SERVER_NAME']
 */
function tina_mvc_make_mail_from_address( $local_user='no-reply' ) {
    return 'no_reply@'.$_SERVER['SERVER_NAME'];
}

/**
 * Send an email
 *
 * Grabs an email message template and merges it with any variables you pass. Use this for
 * any emails you want to send through Tina MVC
 * 
 * @param   string $to The recipients address
 * @param   string $message_template Template to use (looks in 'emails' folder)
 * @param   mixed $message_variables Data to be merged into the message (usually array or object )
 * @uses    tina_mvc_make_mail_from_address()
 * @todo    sending attachments
 */
function tina_mvc_mail($to, $message_template=FALSE, $message_variables=FALSE ) {
    
    if( !$to OR !$message_template ) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' requires $to and $message_template arguments');
    }
    
    if( ! is_email($to) ) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' "'.$to.'" is not a valid email address');
    }
    
    /*
    if( ! array_key_exists( 'subject', $message_variables) OR ! array_key_exists( 'body', $message_variables) ) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' array() $message_variables must keys \'subject\' and \'body\'.');
    }
    */
    
    $headers = 'From: '.get_bloginfo( 'name' ).' Mailer <'.tina_mvc_make_mail_from_address().'>' . "\r\n\\";
    
    $tpl = tina_mvc_find_plugin_folder().'/app_emails/'.$message_template.'.php';
    
    if( ! file_exists($tpl) ) {
      $tpl = tina_mvc_find_tina_mvc_folder().'/emails/'.$message_template.'.php';
    }
    
    if( ! file_exists($tpl) ) {
        tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' $message_template "'.$tpl.'" not found in /app_emails or in /tina_mvc_emails.');
    }
    
    include($tpl); // sets $e_subject and $e_body
    
    return wp_mail( $to , $e_subject , $e_body, $headers, $attachments=FALSE);
    
}

/**
 * Check if a user has been assigned to a role
 *
 * This is safe to use when users can have multiple roles
 * 
 * @param   array|string $roles_to_check a list roles to check (array or comma separated string)
 * @return  bolean
 */
function tina_mvc_user_has_role( $roles_to_check=array() ) {
    
    if( ! $roles_to_check ) return FALSE;
    
    if( ! is_array( $roles_to_check ) ) {
        $roles_to_check = explode( ',', $roles_to_check );
    }
    
    global $current_user;
    get_currentuserinfo();
    $user_id = intval( $current_user->ID );

    if( ! $user_id ) {
      return FALSE;
    }
    
    $user = new WP_User( $user_id ); // $user->roles
    
    foreach( $roles_to_check AS $r) {
      if( in_array($r, $user->roles, FALSE) ) {
        return TRUE;
      }
    }
    
    return FALSE;

}

/**
 * Check if a user has been assigned a capability
 *
 * @param   array|string $cap_to_check a list capabilities to check (array or comma separated string)
 * @return  bolean
 */
function tina_mvc_user_has_capability( $cap_to_check=array() ) {
    
    if( ! $cap_to_check ) return FALSE;
    
    if( ! is_array( $cap_to_check ) ) {
        $cap_to_check = explode( ',', $cap_to_check );
    }

    global $current_user;
    get_currentuserinfo();
    $user_id = intval( $current_user->ID );
    
    if( ! $user_id ) {
        return FALSE;
    }
    else {
        
        $user = new WP_User( $user_id );
        
        foreach( $cap_to_check AS $c ) {
            if( current_user_can($c) ) return TRUE;
        }
        
    }
    
    return FALSE;  

}

/**
 * Call a Tina MVC page controller
 *
 * This can be used from within your own app or in a template file in your theme
 * 
 * @param   string $controller the page controller to call
 * @param   string $role_to_view comma separated list of roles
 * @param   string $capability_to_view comma separated list of capabilities
 * @param   string $custom_folder an overriding location to look for the controller in
 * 
 * @return  string the page content from the controller
 * 
 * @todo     verify assertion "// use shortcode here... same difference"
 * @todo     do we want to echo or return... i think return...
 */
function tina_mvc_call_page_controller( $controller, $role_to_view=FALSE, $capability_to_view=FALSE, $custom_folder='' ) {

    // check for -1 being passed to us - for compatibility with the shortcode call
    // we need to force a boolean value here... Wordpress was acting funny on me with Boolean values in options
    if( $role_to_view == '-1' ) {
      $role_to_view = FALSE;
    }
    
    $APP = new tina_mvc_controller_class( $controller, $role_to_view, $capability_to_view, $called_from='SHORTCODE', $custom_folder ); // use shortcode here... same difference
    
    return $APP->get_post_content();
    
}

/**
 * Escape a data structure for rendering in a browser
 *
 * Recurses into arrays and objects
 * @param   mixed $data An array or object containing data to be escaped
 * @return  mixed The $escaped $data
 * @uses    ent2ncr() to escape non-XML entities
 */
function tina_mvc_esc_html_recursive( $data=FALSE ) {
    
    if( ! $data ) return FALSE;
    
    if( is_array($data) OR is_object($data) ) {
        
        foreach( $data AS $key => & $value ) {
            
            // $key = htmlentities($key,ENT_QUOTES);
            $key = esc_html( $key );
            
            // $value = ent2ncr(htmlentities($data,ENT_QUOTES));
            $value = tina_mvc_esc_html_recursive( $value );
            
        }
        
    }
    else {
        $data = htmlentities($data,ENT_QUOTES);
    }
    
    return $data;

}

/**
 * Generate an empty Wordpress 'page' post
 *
 * When a Tina MVC sub controller is called (e.g. `tina/sub-controller`) the
 * function tina_mvc_page_filter() will be passed an empty $posts array. This
 * function creates a default $post
 * 
 * @return  array a Wordpress page
 * @todo trim down to the bare minimum. this is only used when we install to create the front end fonctroller page(s). Isn't it?
 */
function tina_mvc_get_empty_page_post() {
    
  $p = array(
    'ID' => 0,
    'menu_order' => 0, //If new post is a page, sets the order should it appear in the tabs.
    'comment_status' => 'closed', // 'closed' means no comments.
    'comment_count' => 0,
    'ping_status' => 'closed', // 'closed' means pingbacks or trackbacks turned off
    // 'pinged' => [ ? ] //?
    'post_author' => 1, //The user ID number of the author.
    'post_content' => 'Default from tina_mvc_get_empty_page_post()', //The full text of the post.
    'post_title' => 'Default from tina_mvc_get_empty_page_post()', //The full text of the post.
    'post_parent' => '',
    'post_date' => date('Y-m-d H:i:s'), //The time post was made.
    'post_date_gmt' => gmdate('Y-m-d H:i:s'), //The time post was made, in GMT.
    'post_excerpt' => '', //For all your post excerpt needs.
    'post_status' => 'publish', //Set the status of the new post. 
    'post_title' => '', //The title of your post.
    'post_type' => 'page', //Sometimes you want to post a page.
    'post_category' => array( '1' )
  );
  
  return (object) $p;

}

/**
 * Display a message as a PHP E_USER_NOTICE Error
 *
 * Handy for quick debugging when you can't use tmpr() or tmprd() but can view
 * your PHP error logs instead
 *
 * @param string $msg The message to log
 * @used trigger_error()
 */
function tina_mvc_log( $msg = '' ) {
    
    $reporting = ini_get('error_reporting');
    
    ini_set( 'error_reporting' , E_ALL );
    
    $bt = debug_backtrace();
    $msg = '[tina_mvc_log: ' . str_replace( TINA_MVC_PLUGIN_DIR.'/' , '' , $bt[0]['file'] ) . ':' . $bt[0]['line'] ."] $msg";

    trigger_error( $msg );
    
    ini_set( 'error_reporting' , $reporting );
    
}

/**
 * A basic error handler
 *
 * Tina calls this whenever it encounters an error. Hack this to help you
 * debug your applications
 * 
 * @param  string The error message
 * @todo    allow users to override without having to alter a core Tina file
 * @todo    nested HTML...? Mmmmmmm, not really MVC is it?
 */
function tina_mvc_error( $msg ) {
    
    $backtrace = debug_backtrace();
    $base_folder = ABSPATH;
    
    $error  = "<h2>Tina MVC Error</h2>\r\n";
    $error .= "<p><strong>".tina_mvc_esc_html_recursive($msg)."</strong></p>\r\n";
    $error .= "<p><strong>Backtrace:</strong><br><em>NB: file paths are relative to '".tina_mvc_esc_html_recursive($base_folder)."'</em></p>";
    
    $bt_out  = '';
    
    foreach( $backtrace AS $i => & $b ) {
        
        // tiwen at rpgame dot de comment in http://ie2.php.net/manual/en/function.debug-backtrace.php#65433
        if (!isset($b['file'])) $b['file'] = '[PHP Kernel]';
        if (!isset($b['line'])) {
            $b['line'] = 'n/a';   
        }
        else {
            $b['line'] = vsprintf('%s',$b['line']);
        }
        
        $b['function'] = tina_mvc_esc_html_recursive( $b['function'] );
        $b['class'] = tina_mvc_esc_html_recursive( $b['class'] );
        $b['object'] = tina_mvc_esc_html_recursive( $b['object'] );
        $b['type'] = tina_mvc_esc_html_recursive( $b['type'] );
        $b['file'] = tina_mvc_esc_html_recursive(str_replace( $base_folder, '', $b['file']));
        
        if( !empty($b['args']) ) {
            $args = '';
            foreach ($b['args'] as $j => $a) {
                if (!empty($args)) {
                    $args .= "<br>";
                }
                $args .= ' - Arg['.vsprintf('%s',$j).']: ('.gettype($a) . ') '
                      .'<span style="white-space: pre">'.tina_mvc_esc_html_recursive(print_r($a,1)).'</span>';
            }
            
            $b['args'] = $args;
            
        }
        
        $bt_out .= '<strong>['.vsprintf('%s',$i).']: '.$b['file'].' ('.$b['line'].'):</strong><br>';
        $bt_out .= ' - Function: '.$b['function'].'<br>';
        $bt_out .= ' - Class: '.$b['class'].'<br>';
        $bt_out .= ' - Type: '.print_r($b['type'],1).'<br>';
        $bt_out .= ' - Object: '.print_r($b['type'],1).'<br>';
        $bt_out .= $b['args'].'<hr>';
        $bt_out .= "\r\n";
        
    }

    // $error .= "<pre><small>".tina_mvc_esc_html_recursive(print_r($backtrace,1))."</small></pre>\r\n";
    $error .= '<div style="font-size: 70%;">'.$bt_out."</div>\r\n";
              
    wp_die( $error );
    exit();
}

/**
 * Handier way of doing print_r()
 *
 * @param mixed $arg Stuff to dump to screen...
 * @param string $label An optional label to output e.g. the variable name...
 */
function tina_mvc_print_r( & $arg=NULL , $label = 'Variable Dump' ) {
    
    global $tina_mvc_print_r_times_used;
    $tina_mvc_print_r_times_used = intval( $tina_mvc_print_r_times_used ) + 1;
    
    $bt = debug_backtrace();
    
    echo "<pre><small><hr><strong>[".str_replace(WP_PLUGIN_DIR,'',$bt[1]['file'])."::".$bt[1]['line']." tina_mvc_print_r() pass $tina_mvc_print_r_times_used] $label :</strong>";
    var_dump( $arg );
    echo "</small></pre>";
    
}

/**
 * Alias to tina_mvc_print_r()
 *
 * @see tina_mvc_print_r
 */
if( ! function_exists('tmpr') ) {
    function tmpr( & $a=NULL , $l= 'Variable Dump' ) {
        return tina_mvc_print_r($a,$l);
    }
}

/**
 * Alias to tina_mvc_print_r() and die();
 *
 * @see tina_mvc_print_r
 */
if( ! function_exists('tmprd') ) {
    function tmprd( & $a=NULL , $l= 'Variable Dump' ) {
        tina_mvc_print_r($a,$l);
        die();
    }
}

?>