<?php
/**
 * Tina MVC (Model-View-Controller) Wordpress Plugin - sample application settings.
 *
 * Sample settings for your application. If you want to override these (an it is assumed that you do) then
 * copy this file to tina_mvc_app_settings.php and customise it. If it exists it will be loaded
 * instead of this file.
 *
 * @package    Tina-MVC
 * @subpackage    Tina-Core
 * @author     Francis Crossen <francis@crossen.org>
 */

/**
 * Settings here are only read when the plugin is activated. If you change something here you MUST deactivate/reactivate
 */

/**
 * Wordpress Multisite only
 *
 * Tina MVC is happy in a multisite network as long as you are happy that each
 * blog uses exactly the same front end page controllers and applications.
 *
 * If you would like different blogs to use differet applications and/or different
 * settings, then you must enable this setting.
 * Do you want to use different apps for different sites on Wordpress Multisite?
 *
 * If you enable this apps are found in the app_multisite folder. Your files should go in
 * the app_multisite/sites/siteid/ folder. Also you can put default controllers (which will
 * be used if no file is found in the siteid folder) in the default folder.
 *
 * Tina_MVC will use a tina_mvc_app_settings.php file from the sites/siteid (or the default
 * folder only if $tina_mvc_multisite_app_cascade is set) in preference to this file
 *
 * This setting cannot be overridden by other tina_mvc_app_settings.php files.
 *
 * @see $tina_mvc_multisite_app_cascade
 */
$tina_mvc_enable_multisite = 0;

/**
 * Wordpress Multisite only
 * 
 * Do you want to allow cascading of app controllers?
 *
 * If you enable this, settings and apps are searched for in the app_multisite/sites/siteid/app folder and
 * then in app_multisite/default/app if no suitable controller/view/model is found.
 * 
 * This setting cannot be overridden by other tina_mvc_app_settings.php files.
 */
$tina_mvc_multisite_app_cascade = 0;

/**
 * The following settings can all be overridden by site specific app folders in a
 * multisite environment.
 */

/**
 * Front end page controllers. You should define these if you want a public (or private) page to act as a front end controller.
 * If you only require widget and/or shortcode functionality then leave $tina_mvc_pages = array() i.e. an empty array
 */
$tina_mvc_pages = array();
$tina_mvc_pages[] = array( 'page_title'=>'Masvalor', 'page_name'=>'masvalor', 'page_status'=>'publish' );
/**
 * You can also set up child ages and set menu_order:
 *
 * Child pages are setup by specifying the complete page path for the child page e.g. 'page_name' => 'parent-page/child-page'. This
 * changed in version 0.3.6.
 * 
 * $tina_mvc_pages[] = array( 'page_title'=>'A Tina MVC Child Page', 'page_name'=>'tina-mvc-for-wordpress/tina-mvc-child-page', 'page_status'=>'publish', 'menu_order'=>100 );
 */
$tina_mvc_pages[] = array( 'page_title'=>'masvalor Private', 'page_name'=>'masvalor-private', 'page_status'=>'private' );

$tina_mvc_default_role_to_view = '-1';

/**
 * People who do not have the following roles are redirected to a custom login page
 */
$tina_mvc_login_logout_redirect = 'administrator,editor';

/**
 * If you use the custom login functionality, where do you want to send your users
 * on login/logout?
 */
$tina_mvc_logon_redirect_target = '';
$tina_mvc_logout_redirect_target = '';

/**
 * Can be overridden from your page controllers
 */
$tina_mvc_default_capability_to_view = "";

/**
 * If you wish to use the reCaptcha input type in the form helper, you must
 * set your keys
 */
$tina_mvc_recaptcha_pub_key = '';
$tina_mvc_recaptcha_pri_key = '';

/**
 * Do you want to enable app_bootstrap functions?
 *
 * Each bootstrap function should be in its' own file (with the same name as the function) in the folder
 * app_bootstrap/.
 * 
 * e.g. myBootstrapFuncts() in file  myBootstrapFuncts.php
 * 
 * Bootstrap functions are executed for every wordpress page (not just the Tina MVC pages). By default
 * this is disabled.
 */
$tina_mvc_enable_bootstrap_funcs = 0;

/**
 * These are run on the init action hook. Place your function
 * in a file of the same name in app_init_bootstrap.
 * 
 * e.g. myInitBootstrapFuncts() in file  myInitBootstrapFuncts.php
 */
$tina_mvc_enable_init_bootstrap_funcs = 0;

/**
 * Used with the front end page controllers. You should define these if you want a public (or private) page to act as a front end controller.
 * If you only require widget and/or shortcode functionality then leave $tina_mvc_pages = array() i.e. an empty array
 *
 * @var $tina_mvc_missing_page_controller_action string 'display_error' displays a missing controller error, 'display_404'
 * shows the Wordpress '404' or 'page' or 'index' template (in order of preference), 'display_index' show the default
 * 'index' page controller for that front end controller (the <code>'index_page.php' </code>file)
 *
 * When widgets and shortcodes receive no content they just return blank content for the moment
 */
$tina_mvc_missing_page_controller_action = 'display_error'; 

/**
 * Do you want to disable wpautop() on Tina MVC pages?
 *
 * This Wordpress function can play havock with your view files. If you are happy with the markup in your templates then
 * enable this feature to prevent unexpected messing with your code.
 */
$tina_mvc_disable_wpautop = 1;

/**
 * You can put arbitrary data in this array
 *
 * It is stored in the wp_options table and autoloaded. Use an array, object, whatever you want
 */
$tina_mvc_user_data = array();

/**
 * Do you want to use different apps for different sites on Wordpress Multisite?
 *
 */

/**
 * A array of files and folders that will be backed up and restored when plugin is upgraded
 *
 * You can add your own folders and files to this array.
 *
 * When Tina MVC is upgraded it tries to create a folder called `tina_mvc_upgrade_backup` in the
 * `wp-content/upgrade` folder and copies any files and folders you specify in this array. After
 * the plugin is upgraded the files are copied back.
 * 
 * Important: You can only specify files and directories in the `tina-mvc` plugin folder.
 * Any directories will be recursively copied.
 */
$tina_mvc_upgrade_backups = array( 'tina_mvc_app_settings.php', 'app', 'app_css',
                                   'app_emails', 'app_libs', 'app_js', 'app_bootstrap',
                                   'app_init_bootstrap' , 'app_install_remove', 'app_multisite' );

?>