<?php
/*
Plugin Name: Masvalor
Plugin URI: http://seeit.org/tina-mvc-for-wordpress/
Description: Plugin Masvalor, desarrollado a partir de Tina MVC for Wordpress, es un plugin que permite la gestion de Doctores, Empresas/instituciones y Ofertas de trabajo.
Author: Tsavo Group SRL <www.tsavogroup.com.ar> y Francis Crossen <francis@crossen.org>
Version: 1.0
Author URI: http://www.tsavogroup.com.ar
*/
/*
Copyright 2010, 2011 Francis Crossen (email: francis@crossen.org)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Tina MVC (Model-View-Controller) Wordpress Plugin - main plugin file.
 *
 * Tina MVC provides you with base classes and helper classes and functions on
 * which you build your Wordpress applications.
 *
 * It uses a lose model view controller pattern to abstract design and logic
 * and make life easier for you and your HTML designer.
 * 
 * Tina controllers are accessed through any of:
 *  - a Wordpress page (which acts as a front-end controller)
 *  - a controller call from a Tina MVC Wordpress widget
 *  - a controller call via a Wordpress shortcode
 *  - tina_mvc_call_page_controller() function from your theme file (or even another page controller)
 *
 *  Tina includes helper functiosn and classes:
 *   - a form helper for creating, displaying and processing HTML forms
 *   - a pagination helper for producing paginated lists from your custom SQL
 *   - a HTML form helper
 *   - general functions to help streamline your development efforts
 *
 * PHP 5.1+ & Wordpress 2.9.1+
 *
 * @package    Tina-MVC
 * @subpackage    Tina-Core-Classes
 * @author     Francis Crossen <francis@crossen.org>
 * @copyright  Francis Crossen <francis@crossen.org>
 * @license    GPL2
 */

/**
 * Get the name of the plugin folder
 *
 * If you change the folder name you must change the name of this file to match
 */
 
define( 'TINA_MVC_PLUGIN_DIR', dirname( __FILE__ ) );

/**
 * Include various Tina Framework utility functions.
 */
require_once( TINA_MVC_PLUGIN_DIR .'/app/models/masvalor_utils.php' );
require( TINA_MVC_PLUGIN_DIR . '/app/includes/ajaxcall.php' );
require( TINA_MVC_PLUGIN_DIR . '/tina_mvc/helpers/tina_mvc_functions.php' );
include( TINA_MVC_PLUGIN_DIR . '/tina_mvc/classes/tina_mvc_controller_class.php' );
include( TINA_MVC_PLUGIN_DIR . '/tina_mvc/classes/tina_mvc_base_page_class.php' );
include( TINA_MVC_PLUGIN_DIR . '/tina_mvc/classes/tina_mvc_base_model_class.php' );

/**
 * Tina MVC class loader
 *
 * We don't use PHP __autoload() to avoid conflicts with other plugins.
 *
 * Page controllers are located in the `tina_mvc/` or the `app/` folder. If a Tina controller
 * is called from a front end page controller, then the page controllers can be in a subfolder
 * with the same name as the 'post_name' (slug) as the front end controller page. By default these are
 * called `tina` (a private page) and `tina-mvc-for-wordpress` (a public page).
 *
 * You can also place your controllers in the app folder. If you do they will be
 * available through all of your front end page controllers.
 *
 * @param string $class_name the class name to load
 * @param mixed $params parameters to pass to the class constructor
 * @param string $called_from 'PAGE_FILTER', 'SHORTCODE' or 'WIDGET'
 * @param string $custom_folder look here for the page controller file
 * @param  string $shortcode_content the content encapsulated by the tina_mvc shortcode (if any)
 *
 * @return  object  an instance of the class name
 * @todo  for display_404 do we want to send a 404 header?
 * @todo use spl_autoload functions
 */
function tina_mvc_get_instance_of( $class_name, $params = false, $called_from = FALSE, $custom_folder = '', $shortcode_content = '' ) {
    $my_page_controller         = false;
    $my_default_page_controller = false;
    $common_page_controller     = false;
    // used only if get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') set
    $my_secondary_page_controller = false;
    $my_default_secondary_page_controller = false;
    
    // are we called from a front end controller page?
    if ( defined( 'TINA_MVC_PAGE_CONTROLLER_NAME' ) ) {
        
        $my_page_controller_path    = tina_mvc_find_app_folder() . '/' . TINA_MVC_PAGE_CONTROLLER_NAME;
        $my_page_controller         = $my_page_controller_path . '/' . $class_name . '.php';
        $my_default_page_controller = $my_page_controller_path . '/index_page.php';
        // used only if get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') set
        $my_secondary_page_controller = TINA_MVC_SECONDARY_APP_FOLDER.'/'.TINA_MVC_PAGE_CONTROLLER_NAME.'/'.$class_name . '.php';
        $my_default_secondary_page_controller = TINA_MVC_SECONDARY_APP_FOLDER.'/'.$class_name . '.php';
    }
    elseif ( defined( 'TINA_MVC_PAGE_CONTROLLER_ID' ) ) {
        // find the page name...
        $tina_pages                 = get_option( 'tina_mvc_pages' );
        $my_page_controller_path    = tina_mvc_find_app_folder() . '/' . $tina_pages[TINA_MVC_PAGE_CONTROLLER_ID]['page_name'];
        $my_page_controller         = $my_page_controller_path . '/' . $class_name . '.php';
        $my_default_page_controller = $my_page_controller_path . '/index_page.php';
        // used only if get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') set
        $my_secondary_page_controller = TINA_MVC_SECONDARY_APP_FOLDER.'/'.$tina_pages[TINA_MVC_PAGE_CONTROLLER_ID]['page_name'].'/'.$class_name . '.php';
        $my_default_secondary_page_controller = TINA_MVC_SECONDARY_APP_FOLDER.'/'.$class_name . '.php';
    }
    
    // look in the app folder for any common controllers. your shortcode and widget controllers go here too
    $common_page_controller = tina_mvc_find_app_folder() . '/' . $class_name . '.php';
    
    /*
    tmpr( $a=TINA_MVC_PAGE_CONTROLLER_NAME );
    tmpr( $my_page_controller );
    tmpr( $my_default_page_controller );
    tmpr( $my_secondary_page_controller );
    tmpr( $my_default_secondary_page_controller );
    tmprd( $common_page_controller );
    */
    
    // look in a custom folder first...
    if ( $custom_folder AND file_exists( ( $custom_controller = $custom_folder . '/' . $class_name . '.php' ) ) ) {
        include_once( $custom_controller );
    }
    elseif ( !$custom_folder AND $my_page_controller AND file_exists( $my_page_controller ) ) {
        include_once( $my_page_controller );
    }
    elseif ( !$custom_folder AND file_exists( $common_page_controller ) ) {
       include_once( $common_page_controller );
    }
    elseif ( !$custom_folder AND get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') AND defined('TINA_MVC_SECONDARY_APP_FOLDER') ) {
        // check in the front page controller pages folders within app folder
        if( file_exists( $my_secondary_page_controller ) ) {
            include_once( $my_secondary_page_controller );
        }
        elseif( file_exists( $my_default_secondary_page_controller ) ) {
            include_once( $my_default_secondary_page_controller );
        }
    }
    elseif ( !$custom_folder AND file_exists( ( $_f = tina_mvc_find_tina_mvc_folder() . '/app/' . $class_name . '.php' ) ) ) {
        include_once( $_f );
    }
    else {
        
        /**
         * Can't find the controller
         */
        $error_title = 'Tina MVC Error: Page controller \'' . $class_name . '.php\' not found';
        
        $error_content = 'tina_mvc.php::' . __FUNCTION__ . '() (line ' . __LINE__ . ') File \'' . $class_name . '.php\' not found. Looked for:';
        
        /**
         * Were we passed a cuustom folder location?
         */
        if ( $custom_folder ) {
            $error_content .= "<br /> - $custom_controller (passed \"$custom_folder\" as a custom class folder location)";
        }
        else {
            if ( $my_page_controller ) {
                $error_content .= "<br /> - $my_page_controller";
            }
            $error_content .= "<br /> - $common_page_controller";
            $error_content .= "<br /> - " . tina_mvc_find_plugin_folder() . '/app/' . $class_name . '.php';
        }
        
        $error_content .= '<hr>';
        $error_content .= 'You can change how Tina MVC handles this condition by changing the value of
                       <code>$tina_mvc_missing_page_controller_action</code> in your application settings file at <code>tina_mvc_app_settings.php</code>.';
        
        /**
         * How should we handle the error
         *
         * Have we been called from a 'PAGE_FILTER' (Tina MVC front end controller page)?
         */
        if ( $called_from == 'PAGE_FILTER' ) {
            if ( !( $missing_action = get_option( 'tina_mvc_missing_page_controller_action' ) ) OR ( $missing_action == 'display_error' ) ) {
                $page = new tina_mvc_base_page_class();
                $page->set_post_title( $error_title );
                $page->set_post_content( $error_content );
                return $page;
                
            }
            elseif ( $missing_action == 'display_404' ) {
                global $wp_query;
                $wp_query->is_404    = true;
                $wp_query->is_single = false;
                $wp_query->is_page   = false;
                $page                = new tina_mvc_base_page_class();
                $page->set_post_title( 'Not Found' );
                $page->set_post_content( 'Sorry, but the page you are looking for is not here.' );
                return $page;
                
            }
            elseif ( $missing_action == 'display_index' ) {
                if ( file_exists( $my_default_page_controller ) ) {
                    include_once( $my_default_page_controller );
                }
                else {
                    include_once( $plugin_path . 'tina_mvc/app/index_page.php' );
                }
                
                return new index_page();
                
            }
            else {
                
                tina_mvc_error( '$tina_mvc_missing_page_controller_action \'' . $missing_action . '\' in $tina_mvc_app_settings not recognised.' );
                
            }
            
        }
        /**
         * Otherwise we have been called from 'WIDGET' or 'SHORTCODE'
         */
        else {
            
            $page = new tina_mvc_base_page_class();
            
            if ( get_option( 'tina_mvc_missing_page_controller_action' ) == 'display_error' ) {
                $page->set_post_title( $error_title );
                $page->set_post_content( $error_content );
            } else {
                $page->set_post_title( '' );
                $page->set_post_content( '' );
            }
            
            return $page;
            
        }
    }
    
    /**
     * Happy days - no errors!
     *
     * We found a page controller file...
     * Let's try to create an instance based on the filename.
     */
    // will fail if the class name has not been defined in one of the files included above
    if( ! class_exists( $class_name ) ) {
        $m = "Found a class file called '$class_name.php' but there is no corresponding
              '$class_name' class defined. (Did you copy a file and forget to rename the main class in it.)";
        tina_mvc_error( $m );
    }
    else {
        if ( $params !== false ) {
            $class = new $class_name( $params );
        } else {
            $class = new $class_name;
        }
        if ( $shortcode_content ) {
            $class->shortcode_content = $shortcode_content;
        }
        return $class;
    }
    
}

/**
 * Handler to parse the wordpress WP_Query object.
 *
 * Looks at the Wordpress query object and checks to see if a page has been
 * called and if that pages matches our front end controller.
 * If there is a match we mark the WP_Query object so tina_mvc_page_filter()
 * function is triggered.
 *
 * @param   object $q  WP_Query object passed by Wordpress
 * @return  object WP_Query object
 */
function tina_mvc_query_parser( $q ) {
    
    $tina_mvc_pages = get_option( "tina_mvc_pages" );
    
    /**
     * Are we *not* using permalinks?
     */
    if ( isset( $q->query_vars['page_id'] ) AND ( array_key_exists( $q->query_vars['page_id'], $tina_mvc_pages ) ) ) {
        
        /**
         * Check to prevent the query parser from jumping in on widget and shortcode calls.
         *
         * This would cause widget/shortcode content to be overwritten by page controller output
         * if the widget/shortcode is displayed on a Tina MVC front end controller page.
         * $tina_mvc_page_request flags a page request, *not* a widget or shortcode request.
         *
         * This code is repeated below.
         *
         * @todo remove duplicate code
         */
        global $tina_mvc_page_request;
        $tina_mvc_page_request = TRUE;
        // trigger_error('$tina_controller_called_from_page_filter - '.$tina_controller_called_from_page_filter, E_USER_WARNING );
        
        define( 'TINA_MVC_PAGE_CONTROLLER_ID', $q->query_vars['page_id'] );
        
        // remove the page id from the query string...
        $tina_mvc_request = str_ireplace( 'page_id=' . $q->query_vars['page_id'], '', $_SERVER['QUERY_STRING'] );
        // is there a trailing slash?
        
        if ( $tina_mvc_request AND $tina_mvc_request[0] == '/' ) {
            $tina_mvc_request = substr( $tina_mvc_request, 1 );
        }
        
        if ( !$tina_mvc_request ) {
            $tina_mvc_request = 'index';
        }
        
        $q->set( 'tina_mvc_request', $tina_mvc_request );
        $q->set( 'page_id', $q->query_vars['page_id'] );
        
    }
    /**
     * Else we might be using permalinks
     */
    elseif ( isset( $q->query_vars['pagename'] ) AND ( ( array_key_exists( $q->query_vars['pagename'], $tina_mvc_pages ) ) OR ( ( $_sl_pos = strpos( $q->query_vars['pagename'], '/' ) ) AND ( array_key_exists( ( $this_controller_name = substr( $q->query_vars['pagename'], 0, $_sl_pos ) ), $tina_mvc_pages ) ) ) ) ) {
        
        /**
         * This is repeated about 40 lines above. See comments there
         */
        global $tina_mvc_page_request;
        $tina_mvc_page_request = TRUE;
        // trigger_error('$tina_controller_called_from_page_filter - '.$tina_controller_called_from_page_filter, E_USER_WARNING );
        //tmprd( $q->query_vars['pagename'] );
        if ( strpos( $q->query_vars['pagename'], '/' ) === false ) { // we are just calling the base controller
            
            $tina_mvc_request = 'index';
            define( 'TINA_MVC_PAGE_CONTROLLER_NAME', $q->query_vars['pagename'] ); //  we also have $this_controller_name set from the check 1/2 dozen lines up
            
        } else {
            /*
            We need to get the action from the query strings... e.g. /myplugin/user/edit/3
            
            for example in each case below we want 'myplugin/test-form/1/2/3'
            
            [REQUEST_URI] => /francis/tina/myplugin/test-form/1/2/3
            [SCRIPT_NAME] => /francis/tina/index.php
            [PHP_SELF] => /francis/tina/index.php
            
            [REQUEST_URI] => /myplugin/test-form/1/2/3
            [SCRIPT_NAME] => /index.php
            [PHP_SELF] => /index.php
            */
            
            // tmpr( $_SERVER );
            
            // tmpr( $q->query_vars['page'] );
            // tmpr( $q->query_vars['pagename'] );
            $_request_uri = $_SERVER['REQUEST_URI'];
            
            // tmpr( $_request_uri );
            // tmpr( $a=tina_mvc_get_multisite_blog_name() );
            
            // if( ! empty( MULTISITE ) AND empty(SUBDOMAIN_INSTALL) ) {
            /*
            if( is_multisite() AND ! SUBDOMAIN_INSTALL ) {
                redundant
                // we need to strip the blog path from the request uri string
                global $blog_id;
                $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
                $_request_uri = substr( $_request_uri , strlen($current_blog_details->path) );
                
            }
            */
            
            $_slash_pos        = strrpos( $_SERVER['PHP_SELF'], '/' );
            $_bit_we_dont_want = substr( $_request_uri, 0, $_slash_pos + 1 );
            $tina_mvc_request  = substr( $_request_uri, strlen( $_bit_we_dont_want ) );
            
            // now extract the tina front end controller page from the request - required so we can construct links to it
            define( 'TINA_MVC_PAGE_CONTROLLER_NAME', substr( $tina_mvc_request, 0, strpos( $tina_mvc_request, '/' ) ) );
            $tina_mvc_request = substr( $tina_mvc_request, -1 * ( strlen( $tina_mvc_request ) - strlen( TINA_MVC_PAGE_CONTROLLER_NAME ) - 1 ) );
            
            
            // tmprd( ($w=("PAGE= ".TINA_MVC_PAGE_CONTROLLER_NAME." // EXTENDED REQUEST = $tina_mvc_request <hr>" )));
            //echo print_r($_SERVER['PHP_SELF'],1) . '|' .  print_r($_SERVER['REQUEST_URI'],1) . '<hr>';            
            //echo print_r(  $tina_mvc_request  ,1) . '|'  . '<hr>';            
            //die();
            
        }
        
        // htmlspecialchars() to prevent xss
        $q->set( 'tina_mvc_request', htmlspecialchars( $tina_mvc_request, ENT_QUOTES ) );
        
    } else {
        // NOT a Tina request. return here to allow easier debugging of Tina requests
        $q->set( 'tina_mvc_request', false );
        
        return $q;
    }
    
    // tmprd( $q );
    
    return $q;
    
}
add_filter( 'parse_query', 'tina_mvc_query_parser' );

/**
 * Check if we have any bootstrap scripts to be run
 *
 * Scripts live in app_bootstrap/. Every PHP file (except index.php) in the directory
 * (but not subdirectories), is included and a PHP function named the same as the filename
 * is called.
 *
 * This allows you to do things like use wp_enqueue_script() with shortcodes and
 * widgets, or to use other Wordpress action hooks. The functions will be called on
 * every page load, not just with Tina MVC pages, so use sparingly.
 *
 * This feature can be disabled in tina_mvc_app_settings.php
 *
 * @param integer $check_init_bootstrap set to true to check the app_init_bootstrap folder instead
 * @todo  remove reliance on include_once()
 */
function tina_mvc_check_bootstrap_funcs( $check_init_bootstrap = FALSE ) {
    
    if ( $check_init_bootstrap ) {
        $tina_mvc_check_folder = tina_mvc_find_app_init_bootstrap_folder();
    } else {
        $tina_mvc_check_folder = tina_mvc_find_app_bootstrap_folder();
    }
    $tina_mvc_init_files = scandir( $tina_mvc_check_folder );
                        
    foreach ( $tina_mvc_init_files AS $tina_mvc_init_file ) {
        
        $tina_mvc_init_file = strtolower( $tina_mvc_init_file );
        if ( !in_array( $tina_mvc_init_file, array(
             '.',
            '..',
            'index.php' 
        ) ) AND ( strpos( $tina_mvc_init_file, '.php' ) !== FALSE ) ) {
            
            include_once( $tina_mvc_check_folder . '/' . $tina_mvc_init_file );
            
            $function = str_replace( '.php', '', $tina_mvc_init_file );
            if( function_exists($function) ) {
                call_user_func( str_replace( '.php', '', $tina_mvc_init_file ) );
            }
            
            
        }
        
    }
    
}

/**
 * Do we have init bootstrap actions to be run
 *
 * @uses tina_mvc_check_bootstrap_funcs()
 * @see tina_mvc_check_bootstrap_funcs()
 */
function tina_mvc_check_init_bootstrap_funcs() {
    tina_mvc_check_bootstrap_funcs( TRUE );
}

/**
 * Check if we have any init bootstrap scripts to be run
 *
 * Scripts live in app_init_bootstrap/. Every PHP file (except index.php) in the directory
 * (but not subdirectories), is included and a PHP function named the same as the filename
 * is called.
 * 
 * They are run on 'init' action hook
 *
 * This feature can be disabled in tina_mvc_app_settings.php
 * @uses tina_mvc_check_bootstrap_funcs()
 */
if ( get_option( 'tina_mvc_enable_init_bootstrap_funcs' ) ) {
    add_action( 'init', 'tina_mvc_check_init_bootstrap_funcs' );
}

/**
 * Page filter to detect a call to our controller and to pass control to it
 *
 * Checks $wp_query->get('tina_mvc_request') and if set triggers a call to
 * the Tina MVC framework. Sets the Wordpress post_title and post_content.
 * The (object) $wp_query is previously marked tina_mvc_query_parser()
 * to flag a call to our controller
 *
 * There is a Wordpress quirk that looses the type of the 'tina_mvc_default_role_to_view'
 * option. In the tina_mvc_settings.php file we use -1 instead of a boolean false
 * 
 * @param   array $posts A single element array of posts. This can be empty for pages like 'tina/some-page'
 * @todo - tina_mvc_get_empty_page_post() is not returning a complete page and is causing PHP Notice errors in templates 
 * @return  array $posts
 * @uses tina_mvc_check_bootstrap_funcs()
 */
function tina_mvc_page_filter( $posts ) {
    if ( get_option( 'tina_mvc_enable_bootstrap_funcs' ) ) {
        tina_mvc_check_bootstrap_funcs();
    }
    
    global $wp_query;
    // we use a global variable here because we may have multiple Tina controller calls in one page request and cannot redefine a constant...
    global $tina_mvc_page_request; // flags a page request, NOT a widget or shortcode request
    // not working...
    
    if ( $tina_mvc_page_request AND ($tina_mvc_request=$wp_query->get( 'tina_mvc_request' )) ) {
    // if ( $wp_query->get( 'tina_mvc_request' ) ) {
        
        if ( get_option( 'tina_mvc_disable_wpautop' ) ) {
            remove_filter( 'the_content', 'wpautop' );
        }
        
        //  if we have not been passed $posts, then generate an empty one...
        //  $posts is empty if it is a controller/subcontroller/whatever call
        if ( !$posts ) {
            $posts = array(
                 get_page_by_path( TINA_MVC_PAGE_CONTROLLER_NAME ) 
            );
        }
        
        // Required so we can make links using the page controller, remember we can have multiple front end page controllers.
        // This also serves to flag our tina_mvc_controlelr_class() that it has been called from this page filter
        // define('TINA_MVC_PAGE_CONTROLLER_ID', $posts[0]->ID ); 
        
        // global $tina_controller_called_from_page_filter;
        // $tina_controller_called_from_page_filter = TRUE;
        
        // we need to force a boolean value here... Wordpress was acting funny on me with Boolean values in options
        if ( ( $default_role_to_view = get_option( 'tina_mvc_default_role_to_view' ) ) == -1 ) {
            $default_role_to_view = false;
        }
        
        $default_capability_to_view = get_option( 'tina_mvc_default_capability_to_view' );
        
        $APP = new tina_mvc_controller_class( $tina_mvc_request, $default_role_to_view, $default_capability_to_view, $called_from = 'PAGE_FILTER' );
        $tina_mvc_page_request = FALSE; // done with this...
        
        /**
         * @todo check this statement
         *
         * if we have no app, we unset the posts and allow WP to use whatever 404 page it can find... 
         * this check should now be redundant since we are managing missing page_controllers in the tina_mvc_get_instance_of() function
         * 
         */
        if ( $APP ) {
            // we only have one post at $posts[0]
            if ( $APP->get_post_title() ) {
                $posts[0]->post_title = $APP->get_post_title();
            }
            $posts[0]->post_content = $APP->get_post_content();
            
        } else {
            // $posts = array();
            $wp_query->post_count = 0;
        }
        
    }
    
    return $posts;
    
}
add_filter( 'the_posts', 'tina_mvc_page_filter' );

/**
 * Handler to parse Tina MVC shortcodes
 *
 * Shortcodes may be self-closing or enclosing.
 * 
 * @param   array $attributes the shortcode attributes. $attributes['controller'] is required
 * @return  string The pre-escaped HTML to display
 */
function tina_mvc_shortcode_func( $attributes, $content = '' ) {
    $atts = shortcode_atts( array(
         'controller' => 'index',
        'role_to_view' => FALSE,
        'capability_to_view' => FALSE 
    ), $attributes );
    
    // check for -1 being passed to us by the shortcode call
    // we need to force a boolean value here... Wordpress was acting funny on me with Boolean values in options
    if ( $atts['role_to_view'] == '-1' ) {
        $atts['role_to_view'] = FALSE;
    }
    
    // we use a global variable here because we may have multiple Tina controller calls in one page request and cannot redefine a constant...
    global $tina_mvc_page_request; // flags a page request, NOT a widget or shortcode request
    $tina_mvc_page_request = FALSE;
    $APP = new tina_mvc_controller_class( $atts['controller'], $atts['role_to_view'], $atts['capability_to_view'], $called_from = 'SHORTCODE', $custom_folder = '', $content );
    
    $ret = $APP->get_post_content();
    
    if ( !$ret ) {
        return $content;
    } else {
        return $ret;
    }
    
}

/**
 * Run our Tina shortcodes early before wp_texturize() gets to it.
 *
 * @param   string $content the postpage content
 * @return  string
 * @see http://www.viper007bond.com/2009/11/22/wordpress-code-earlier-shortcodes/
 */
function tina_mvc_run_shortcode( $content ) {
    global $shortcode_tags;
    
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    $shortcode_tags      = array();
    
    add_shortcode( 'tina_mvc', 'tina_mvc_shortcode_func' );
    
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
    
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
    
    return $content;
}
add_filter( 'the_content', 'tina_mvc_run_shortcode', 7 );

/**
 * Add function to widgets_init that'll load our widget.
 */
 
//add_action( 'widgets_init', 'tina_mvc_load_widgets' );

/**
 * Register our widget.
 */
function tina_mvc_load_widgets() {
    register_widget( 'Tina_MVC_Widget' );
}

/**
 * The Tina MVC Widget
 * 
 * @package    Tina-MVC
 * @subpackage    Tina-Core-Classes
 */
class Tina_MVC_Widget extends WP_Widget {
    /**
     * Widget setup.
     */
    function Tina_MVC_Widget() {
        // settings
        $widget_ops = array(
             'classname' => 'tina_mvc',
            'description' => __( 'Call a Tina MVC framework controller', 'tina_mvc' ) 
        );
        
        // Widget control settings
        $control_ops = array(
             'width' => 250,
            'height' => 300,
            'id_base' => 'tina_mvc_widget' 
        );
        
        // Create the widget
        $this->WP_Widget( 'tina_mvc_widget', __( 'Tina MVC Widget', 'tina_mvc' ), $widget_ops, $control_ops );
        
    }
    
    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );
        
        // we use a global variable here because we may have multiple Tina controller calls in one page request and cannot redefine a constant...
        global $tina_mvc_page_request; // flags a page request, NOT a widget or shortcode request
        $tina_mvc_page_request = FALSE;
        
        // Our variables from the widget settings
        $capability_to_view = ''; // default
        $controller         = $instance['controller'];
        
        $role_to_view = ''; // default
        
        if ( $instance['no_role_to_view'] ) {
            $role_to_view = FALSE;
        } elseif ( $instance['role_to_view'] ) {
            $role_to_view = $instance['role_to_view'];
        } elseif ( $instance['capability_to_view'] ) {
            $capability_to_view = $instance['capability_to_view'];
        }
        
        $APP     = new tina_mvc_controller_class( $controller, $role_to_view, $capability_to_view, $called_from = 'WIDGET' );
        $content = $APP->get_post_content();
        
        if ( $content ) {
            // Tina widget is only displayed if the permissions check passes
            
            // Before widget (defined by themes)
            echo $before_widget;
            
            // Display the widget title if one was input (before and after defined by themes)
            if ( !( $tina_mvc_title = $APP->get_post_title() ) ) {
                $tina_mvc_title = $instance['title'];
            }
            $tina_mvc_title = apply_filters( 'widget_title', $tina_mvc_title );
            
            echo $before_title . $tina_mvc_title . $after_title;
            
            echo $content;
            
            // After widget (defined by themes)
            echo $after_widget;
            
        }
        
    }
    
    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        // Strip tags for title and name to remove HTML (important for text inputs)
        $instance['title']              = strip_tags( $new_instance['title'] );
        $instance['controller']         = strip_tags( $new_instance['controller'] );
        $instance['no_role_to_view']    = ( $new_instance['no_role_to_view'] ? 1 : 0 );
        $instance['role_to_view']       = strip_tags( $new_instance['role_to_view'] );
        $instance['capability_to_view'] = strip_tags( $new_instance['capability_to_view'] );
        
        return $instance;
        
    }
    
    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array(
             'title' => __( 'The default widget title', 'tina_mvc' ),
            'controller' => __( 'tina-mvc', 'tina_mvc' ) 
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
?>

            <!-- Widget Title: Text Input -->
            <p>
                    <label for="<?php
        echo $this->get_field_id( 'title' );
?>"><?php
        _e( 'Default Widget Title:', 'hybrid' );
?></label>
                    <input id="<?php
        echo $this->get_field_id( 'title' );
?>" name="<?php
        echo $this->get_field_name( 'title' );
?>" value="<?php
        echo $instance['title'];
?>" style="width:100%;" />
            </p>

            <!-- Role To View: Checkbox -->
            <p>
                    <label for="<?php
        echo $this->get_field_id( 'no_role_to_view' );
?>"><?php
        _e( 'Visible to all users (overrides all settings below)?', 'tina_mvc' );
?></label>
                    <input id="<?php
        echo $this->get_field_id( 'no_role_to_view' );
?>" name="<?php
        echo $this->get_field_name( 'no_role_to_view' );
?>" type="checkbox" value="1" <?php
        if ( $instance['no_role_to_view'] )
            echo 'checked';
?> />
            </p>

            <!-- Controller: Text Input -->
            <p>
                    <label for="<?php
        echo $this->get_field_id( 'controller' );
?>"><?php
        _e( 'Controller:', 'tina_mvc' );
?></label>
                    <input id="<?php
        echo $this->get_field_id( 'controller' );
?>" name="<?php
        echo $this->get_field_name( 'controller' );
?>" value="<?php
        echo $instance['controller'];
?>" style="width:100%;" />
            </p>

            <!-- Role To View: Text Input -->
            <p>
                    <label for="<?php
        echo $this->get_field_id( 'role_to_view' );
?>"><?php
        _e( 'Role To View (empty means user must be logged in):', 'tina_mvc' );
?></label>
                    <input id="<?php
        echo $this->get_field_id( 'role_to_view' );
?>" name="<?php
        echo $this->get_field_name( 'role_to_view' );
?>" value="<?php
        echo $instance['role_to_view'];
?>" style="width:100%;" />
            </p>

            <!-- Capability To View: Text Input -->
            <p>
                    <label for="<?php
        echo $this->get_field_id( 'capability_to_view' );
?>"><?php
        _e( 'Capability To View (overrides the above settings):', 'tina_mvc' );
?></label>
                    <input id="<?php
        echo $this->get_field_id( 'capability_to_view' );
?>" name="<?php
        echo $this->get_field_name( 'capability_to_view' );
?>" value="<?php
        echo $instance['capability_to_view'];
?>" style="width:100%;" />
            </p>

    <?php
    }
}

/**
 * Only enable the following actions if Tina MVC is active
 */
if ( get_option( 'tina_mvc_plugin_active' ) AND ( get_option( 'tina_mvc_default_role_to_view' ) != -1 ) ) {
    /**
     * Redirect-on-logout to prevent 'Subscribers' from ever SEEING A Wordpress backend
     */
    function tina_mvc_logout_redirect() {
        // permalinks?
        if ( get_option( 'permalink_structure' ) ) {
            $target = get_option( 'tina_mvc_logout_redirect_target' );
        } else {
            // we need to find the page id...
            $page   = get_page_by_path( get_option( 'tina_mvc_logout_redirect_target' ) );
            $target = '?page_id=' . $page->ID;
            
        }
        
        wp_redirect( tina_mvc_make_controller_url( $target, true ) );
        exit();
        
    }
    add_action( 'wp_logout', 'tina_mvc_logout_redirect' );
    
    /**
     * Prevent users from accessing /wp-admin unless they have appropriate role
     *
     * @todo  Move the permalink/non-permalink logic to a function. It is used in other places in this file
     */
    function restrict_admin() {
        if ( !tina_mvc_user_has_role( explode( ',', get_option( 'tina_mvc_login_logout_redirect' ) ) ) ) {
            $target = ''; // default
            
            if ( get_option( 'tina_mvc_logon_redirect_target' ) ) {
                // we will redirect to there...
                // permalinks?
                // @todo - move this logic out to tina_mvc_functions.php
                if ( get_option( 'permalink_structure' ) ) {
                    $target = get_option( 'tina_mvc_logon_redirect_target' );
                } else {
                    // we need to find the page id...
                    $page = get_page_by_path( get_option( 'tina_mvc_logon_redirect_target' ) );
                    
                    $target = '?page_id=' . $page->ID;
                    
                }
                
            }
            
            wp_redirect( tina_mvc_make_controller_url( $target, true ) );
            exit();
            
        }
        
    }
    add_action( 'admin_init', 'restrict_admin', 1 );
    
    /**
     * Only use the following action if the role_to_view is NOT -1, i.e. if the default permissions require a logged in user
     */
    if ( ( get_option( 'tina_mvc_default_role_to_view' ) != -1 ) ) {
        /**
         * Prevent users from seeing the wp-login page unless they have appropriate permissions. This also intercepts the logout command
         * 
         * @todo  Move the permalink/non-permalink logic to a function. It is used in other places in this file
         */
        function restrict_wp_login() {
            if ( ( strpos( $_SERVER['SCRIPT_FILENAME'], 'wp-login.php' ) !== FALSE ) AND !tina_mvc_user_has_role( explode( ',', get_option( 'tina_mvc_login_logout_redirect' ) ) ) AND get_option( 'tina_mvc_logon_redirect_target' ) ) {
                // if the user wanted to logout we need to intercept that action
                if ( !empty( $_REQUEST['action'] ) AND ( $_REQUEST['action'] == 'logout' ) ) {
                    check_admin_referer( 'log-out' );
                    wp_logout();
                }
                
                // permalinks?
                if ( get_option( 'permalink_structure' ) ) {
                    $target = get_option( 'tina_mvc_logon_redirect_target' );
                } else {
                    // we need to find the page id...
                    $page   = get_page_by_path( get_option( 'tina_mvc_logon_redirect_target' ) );
                    $target = '?page_id=' . $page->ID;
                    
                }
                
                wp_redirect( tina_mvc_make_controller_url( $target, true ) ); // TRUE => makes an absolute url
                
                exit();
                
            }
            
        }
        add_action( 'init', 'restrict_wp_login' );
        
    }
    
}

/**
 * Wordpress function that installs the plugin - runs when plugin is activated or upgraded
 *
 * Install/Upgrades the Wordpress plugin. Takes settings from 'tina_mvc_app_settings_sample.php' or
 * 'tina_mvc_app_settings.php' and creates Wordpress pages and options accordingly.
 * 
 * This function will be run whenever the plugin is upgraded AFTER any saved settings
 * have been copied back to the tina-mvc. Check the $tina_mvc_upgrade_backups variable in the settings file
 *
 * @param boolean $upgrading set to true if function is called during plugin upgrade
 *
 * @see  tina_mvc_app_settings_sample.php ($tina_mvc_upgrade_backups var)
 * @uses tina_mvc_admin_install()
 * @todo  Allow for custom DB tables
 */
function tina_mvc_install( $upgrading = FALSE ) {
    // keep out of here to keep the main plugin file small...
    include_once( tina_mvc_find_tina_mvc_folder() . '/helpers/tina_mvc_admin_functions.php' );
    tina_mvc_admin_install( $upgrading );
    
}
/**
 * Register the activation hook
 */
register_activation_hook( __FILE__, 'tina_mvc_install' );

/**
 * Wordpress function that removes the plugin - runs on deactivation
 *
 * @uses tina_mvc_admin_remove()
 */
function tina_mvc_remove() {
    // keep out of here to keep the main plugin file small...
    include_once( tina_mvc_find_tina_mvc_folder() . '/helpers/tina_mvc_admin_functions.php' );
    tina_mvc_admin_remove();
    
}
/**
 * Register the deactivation hook
 */
register_deactivation_hook( __FILE__, 'tina_mvc_remove' );

/**
 * Following are only required for Administration
 */
if ( is_admin() ) {
    /**
     * The Administration - Settings - Tina MVC information screen
     */
    function tina_mvc_admin_html_page() {
        add_options_page( 'Tina MVC Options', 'Tina MVC', 'administrator', 'tina_mvc_options', 'tina_mvc_admin_settings_options_html' );
    }
    add_action( 'admin_menu', 'tina_mvc_admin_html_page' );
    
    function tina_mvc_admin_settings_options_html() {
        echo tina_mvc_call_page_controller( 'tina_mvc_wordpress_admin', 'administrator', FALSE, $custom_folder = tina_mvc_find_tina_mvc_folder() . '/classes' );
        
    }
    
    /**
     * Backup files before plugin upgrade
     *
     * Thanks to Clay Lua (http://hungred.com) for illustrating the technique
     *
     * @uses tina_mvc_admin_hpt_backup()
     */
    function hpt_backup() {
        // keep out of here to keep the main plugin file small...
        include_once( tina_mvc_find_tina_mvc_folder() . '/helpers/tina_mvc_admin_functions.php' );
        tina_mvc_admin_hpt_backup();
        
        
    }
    
    /**
     * Recover files after plugin upgrade
     *
     * Thanks to Clay Lua (http://hungred.com) for illustrating the technique
     *
     * @uses tina_mvc_admin_hpt_recover()
     * 
     */
    function hpt_recover() {
        // keep out of here to keep the main plugin file small...
        include_once( tina_mvc_find_tina_mvc_folder() . '/helpers/tina_mvc_admin_functions.php' );
        tina_mvc_admin_hpt_recover();
        
    }
    add_filter( 'upgrader_pre_install', 'hpt_backup', 10, 2 );
    add_filter( 'upgrader_post_install', 'hpt_recover', 10, 2 );
    
}

?>
