<?php
/**
* Template File: The Tina MVC Wordpress admin settings page.
*
* @package  Tina-MVC
* @subpackage Tina-Core
* @author   Francis Crossen <francis@crossen.org>
* @todo     Generally tidy this file and the Wordpress admin interface     
*/

/**
 * Make sure the TINA_MVC_PAGE_CONTROLLER_NAME is set so we can produce example links...
 */
if( !defined('TINA_MVC_PAGE_CONTROLLER_NAME') ) {
 define( 'TINA_MVC_PAGE_CONTROLLER_NAME' , 'tina-mvc-for-wordpress' );
}
/**
 * Security check - make sure we were included by the main plugin file
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<div>
<?php // an example of how to use a view file from within a view file... ?>
<?php echo $this->load_view('tina_mvc_logo_snippet', ($dummy=false), tina_mvc_find_tina_mvc_folder()."/misc");  ?>

 <p>Tina MVC is released to the community under the GPL v2 license by Francis Crossen, <a href="http://www.seeit.org" target="_blank">SeeIT.org</a>.</p>

 <p>For commercial support or for alternative licensing, <a href="http://www.seeit.org" target="_blank">contact us</a>.</p>

 <p>Enjoy<br >
 Fran.
 </p>

 <h3>Getting Started</h3>

 <p><em>Important:</em> The links to various sample controllers below all assume you have just installed Tina MVC and are using permalinks. If you are not using permalinks then go to <a href="<?php echo get_option('home'); ?>" target="_blank"><?php echo get_option('home'); ?></a> (opens in a new window/tab) and look at the 'Tina MVC for Wordpress' page.</p>

 <p>Copy the files from <code>sample_apps/</code> to <code>apps/</code> and call them. By default the Tina MVC front end controller pages are called 'tina-mvc-for-wordpress' (the public page) and 'tina' (the private page). If permalinks are enabled you (should) find it at <?php echo tina_mvc_make_controller_link( '', tina_mvc_make_controller_url() ); ?>. This will call the <?php echo tina_mvc_make_controller_link( '', 'index' ); ?> controller in the <code>tina_mvc/</code> folder.</p>
 
 <p>To call a different page controller, append the controller name to <?php echo tina_mvc_make_controller_link( '', tina_mvc_make_controller_url() ); ?>. For example to call the <code>sample_page.php</code> controller, use <?php echo tina_mvc_make_controller_link( 'sample', tina_mvc_make_controller_url('sample') ); ?>. Any further parameters will be passed on to the controller. For example <?php echo tina_mvc_make_controller_link( 'products/view/my-category', tina_mvc_make_controller_url('products/view/my-category') ); ?>.</p>
 <p>Note that any hyphens in your urls are converted to underscores in the page controllers and the class names. So:<br />

 <?php echo tina_mvc_make_controller_link( 'my-products/add-edit-product/mountain-bikes', tina_mvc_make_controller_url('my-products/add-edit-product/mountain-bikes') ); ?> will call <code>app/my_products_page.php</code> and autoload the my_products_page class. The constructor will be passed the request string 'my-products/add-edit-product/mountain-bikes' in an array with hyphens replaced by underscores.</p>
 
 <p>Copy <code>tina_mvc/app/index_*</code> to <code>app/</code> and edit to get you started. Tina MVC will use those files instead of the default ones in <code>tina_mvc/app/</code>.</p>

 <p>Then read the sample code - it's all documented there.</p>

 <h3>Your own apps</h3>
 
 <p>Tina MVC applications get their settings from a default <code>WP_PLUGIN_DIR.'/tina_mvc/tina_mvc_app_settings_sample.php'</code>. Copy it to <code>tina_mvc_app_settings.php</code> and edit it to your requirements. Tina MVC will use it instead.</p>

 <p>NB: If you edit any of the Tina MVC front end controller pages (for example by making one private) Tina MVC may 'lose' the front end controller. If this happens, deactivate and reactivate the plugin. This will reset the front end controller pages.</p>
 
 <p>When Tina MVC is updated it migrates your customisations and aplications (as long as you make sure they are in the backup/restore list). The default is <code>tina_mvc_app_settings.php</code>, <code>app/</code>, <code>app_css/</code>, <code>app_js/</code> and <code>app_emails</code>. This function currently doesn't work if the web server user cannot write to the wordpress folder. These folders are where all your customisations should reside. You can also add folders and files to this backup/restore list. Look at the (array) $tina_mvc_upgrade_backups</code> variable.</p> 
 
 <h2>Current Tina MVC Application Settings</h2>

<?php
/**
 * Grab the active settings file
 */
$setting_location = tina_mvc_find_app_folder();

$tina_mvc_settings_filename = tina_mvc_find_app_folder().'/../tina_mvc_app_settings.php';
?>

 <p>Active tina_mvc_app_settings file is:<br />
 <code><?php echo $tina_mvc_settings_filename; ?></code>.</p>

 <p><strong>Important: </strong>Tina MVC only reads these settings when you activate the plugin. Therefore if you make
 any changes here you will need to deactivate/reactivate Tina MVC.
 
 This may cause your Front End Controller page menu item to 'dissappear'. This is because the Front End Page Controller is deleted when you deactivate Tina MVC and
 created with a new page ID when Tina MVC is activated again.
 
 If enough people complain about this I will change the default behaviour... ;-)</p>
 
 <h2>Notes on the various settings</h2>
 
 <p><strong>Default role to view a front end controller page:</strong><br />
 
 <p>The front end controller page can be restricted to certain roles. This is the Wordpress page that is created when you enable Tina MVC plugin. Can be overidden by the subcontroller in tina_mvc_base_page_class.php.</p>

 <p>Possible values are:    <br />
     &bull; <code>-1</code>: No permissions are applied to the main controller - this disables the login functionality
    <br />
     &bull; <code>''</code> or <code>0</code>: User must be logged in. This enables the login, user registration, password recovery pages
    <br />
     &bull; <code>'SomeRole'</code>: User must be assigned to the 'SomeRole' role. Seperate multiple entries with commas.
    <br />
    <em>Example: -1</em>
 </p>

 <p><strong>Login/logout redirects:</strong><br />
 
 If the front end controller page requires permissions to view (or requires a user to be logged in) Tina MVC will redirect users when they login, logout and try to access the <code>/wp-admin pages</code>. Enter the user role(s) that will NOT be redirected (allows access to <code>/wp-admin</code>). NB: These are case sensitive. Wordpress default roles are lower case.<br />
     <em>Example: '<code>administrator,editor</code>'</em>
 </p>
 
 <p><strong>Logon redirect target:</strong><br />
  
  If `tina_mvc_default_role_to_view` is NOT equal to `-1` (i.e. if users must authenticate to view the controller) then a call to wp-login.php is redirected here. This should be a Tina front end page controller, or users will not be able to log in. If you leave this setting blank, users will be sent to wp-login.php as usual.
 Attempts to access /wp-admin/ (not exempted by the `tina_mvc_logon_redirect_target` option above) are also directed here. 
     <em>Example: '<code>tina-mvc-for-wordpress</code>'</em>
 </p>
 
 <p><strong>Logout redirect target:</strong><br />
  
  If redirected on logout, a user is sent here. Usually this is the front end page controller. Defaults to your Wordpress home page.
     <em>Example: '<code>tina-mvc-for-wordpress</code>'</em>
 </p>
 
 <p><strong>Default Capability to view the Front end controller page:</strong><br />
  
  Similar to above. The capability will overide any role restriction above. Note, users will still need to be logged in if you set this.</p>

 <p>Possible values are:    <br />
     &bull; <code>''</code> or <code>0</code>: Disables checks
    <br />
     &bull; '<code>SomeCapability</code>': User must have 'SomeCapability' capability. Seperate multiple entries with commas.
    <br />
    <em>Example: '<code>read,edit_comments</code>'</em>
 </p>

 <p><strong><a href="http://recaptcha.net/">ReCaptcha</a> Public Key and Private Key:</strong><br />
  
  If you have a <a href="http://recaptcha.net/" target="_blank">ReCaptcha</a> account you can enter your keys here. This makes the 'RECAPTCHA' input type available to you when you use the <code>tina_mvc_form_helper_class.php</code> form generator and processor. (See the <code>tina_mvc_include_helper()</code> helper function.)</p>

<h2>Current Tina MVC Front end Controller Pages</h2>

 <p>The front end controller pages are stored in the Wordpress options table. They are indexed by 'post_id' and by 'post_name' for quick access.</p>
 
<div style="background-color: #eaeaea;">
<code style="white-space: pre;"><?php echo esc_html(print_r( get_option( "tina_mvc_pages" ) , 1 )); ?></code>
</div>

<h2>Other Settings</h2>
<p>Look at the settings file below - everything is commented. If you get stuck, ask!</p>

<?php
    // the app settings file...
     $fh = fopen( $tina_mvc_settings_filename, 'r');
     $out = fread( $fh, filesize($tina_mvc_settings_filename) );
     fclose( $fh );
      $out = esc_html($out);
?>

 <h2>Complete Tina MVC Application Settings File</h2>

 <p>
 From <code><?php echo $tina_mvc_settings_filename; ?></code>.</p>

<div style="background-color: #eaeaea;">
<code style="white-space: pre; "><?php echo $out; ?></code>
</div>

<br />
</div>
