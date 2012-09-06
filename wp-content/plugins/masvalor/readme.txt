=== Plugin Name ===
Author: Francis Crossen (fcrossen)
Contributors: Francis Crossen (fcrossen)
Donate link: http://seeit.org/tina-mvc-for-wordpress
Tags: plugin, widget, mvc, shortcode, development, framework, helper
Requires at least: 2.9.1
Tested up to: 3.2.1
Dev version: 0.4.15
Stable tag: 0.4.14

Tina MVC is a Wordpress development framework that allows you to develop plugins, shortcodes and and widgets.

== Description ==

Tina MVC provides you with base classes and helper classes and functions on which you build your Wordpress applications.

It uses a lose model view controller pattern to abstract design and logic and make life easier for you and your HTML designer.

### Features:
* Completely separate your code from Wordpress themes. Your users can change their theme and still retain your application functionality.
* A helper class for generating and processing HTML forms.
* A helper class for generating paginated tables from SQL (for when custom posts are not appropriate).
* A helper class for generating HTML tables from your data.
* Separation of your code from core Tina MVC files for easy upgrades.
* Compact and non-intrusive. Currently 2 page filters plus, 1 action hook for widgets and 1 shortcode hook are used for basic usage.
* A function to allow you to call a Tina MVC controller from your theme file (breaks the MC) or from another controller.
* Flexible enough for quick procedural prototyping - don't like MVC? No problem!

### Demo Site
http://tina-mvc-demo.seeit.org/ (On a slow shared hosting account. Updated as time permits.)

### Tutorials
http://www.seeit.org/tina-mvc-for-wordpress/

### Documentation
http://www.seeit.org/tina-mvc-documentation/complete/ (Updated as time permits from the source. You can also generate your own using PhpDocumentor or similar.)

### License
This version is GPL v2 licensed. If you are interested in alternative licensing models, or in commercial support, please contact the author at http://www.seeit.org/about-us/.

### Support
Support for this version is available at http://wordpress.org/tags/tina-mvc?forum_id=10 or by leaving a comment at http://www.seeit.org/tina-mvc-for-wordpress/.

== Installation ==

1. Download and unzip
1. Upload the <code>tina-mvc</code> folder to the <code>/wp-content/plugins/</code> folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the `Tina MVC` entry in your Wordpress Administration `Settings` menu for a quick start
1. Navigate to the newly created `Tina MVC for Wordpress` page on your Wordpress site
1. You can now copy <code>sample_apps/*</code> to <code>app/</code> to get an idea of what Tina MVC can do

== Known Issues ==

= Upgrading =

The automatic upgrade feature is unreliable. It definitely will not work for you if your web server cannot write to the <code>wp-content</code> folder. * Always backup your apps. * 
You can upgrade manually:

1) Download and unzip; 2) Deactivate the plugin through the 'Plugins' menu in WordPress; 3) Backup `app_*`, `tina_mvc_app_settings.php` and any other files and folders you created; 
4) Delete the contents of the `tina-mvc` folder and copy back your backed up files; 5) Compare the new `tina_mvc_app_settings_sample.php` file with your `tina_mvc_app_settings.php` file and merge any changes; 
6) Reactivate the plugin

= Permalinks =

Tina MVC does not work with a custom permalink of '/%postname%/'. The preset permalink structures are fine.

== Frequently Asked Questions ==

= What is Tina MVC used for? =

It is used for all my Wordpress development at this stage. Wordpress became my development platform of choice in early 2010 and Tina MVC allows me to develop client sites as Wordpress plugins.

= Where can I get documentation? =

1. See http://www.seeit.org/tina-mvc-for-wordpress/ for tutorials
1. Try out some of samples in 'tina-mvc/the sample_apps' folder. They are all well commented.
1. See http://www.seeit.org/tina-mvc-documentation/complete/ for phpDocumentor documentation. This is generated from the source, but may not be completely up to date.

= How do I start writing my code? =

The default install will create 2 new Wordpress pages. One will be a public page that will act as a front end controller page.
It will contain some basic instructions on how to proceed. The package contains some sample applications to get you started. If you do anything funky with Tina MVC, why not submit it to us for inclusion as a sample?

= Does Tina MVC work with Wordpress Multisite? =

Yes. You can have all sites use the same application files, or have different application files for each blog within your network.

= I'm getting PHP Errors =

Minimum requirements are PHP 5.1 and Wordpress 2.9.1.

= My changes to <code>tina_mvc_app_settings.php</code> are being ignored... =

The <code>tina_mvc_app_settings.php</code> file is only checked on plugin activation. Deactivate/reactivate the plugin to load the new settings.

= Can Tina MVC create posts on activation like it does pages? =

Yes. Put your code into <code>tina-mvc/app_install_remove/tina_mvc_app_install.php</code>. Tina MVC will include it on activation and call the function <code>tina_mvc_app_install()</code>.

= Can my current controller use a view from inside another controllers folder? =

Yes. Just specify the view file name you want to use when you use the $this->load_view() function. You can also specify a custom location for your view file:
<code>$this->load_view( 'my_view_file' , FALSE , 'path/to/view/file/from/tina-mvc/folder' )</code>

= Why are there HTML template files in the plugin folder? =

Tina MVC applications are designed to be completely independent of the theme you use. The templates only format the post/page/shortcode/widget content.
You should be able to use any theme you want with a deployed Tina MVC application. This allows you to crack on with development while your designer (if there is one) deals with the theme.
Of course there is nothing to stop you putting code and calls to tina_mvc_call_page_controller() in your templates if you prefer.

= I'd love to see `insert feature here` in Tina MVC. How can I request this? =

See `Where can I get support?` below and just ask.

= Where can I get support? =

The 'Plugins and Hacks' forum (http://wordpress.org/tags/tina-mvc?forum_id=10) or at http://www.seeit.org/tina-mvc-for-wordpress/.

== Screenshots ==

1. Tina MVC for Wordpress.

== Changelog ==

= 0.4.15 =
 * 0.5 beta release
 * Enhancement: form helper function add_field_descriptive_text() new parameter to place description before or after input
 * Enhancement: pagination helper can suppress sortable column headings (see object var $suppress_sort)
 * Bug Fix: Minor - Missing template variables for 'reset password' view
 * Bug Fix: Minor - Check we are on SSL before constructing links
 
= 0.4.14 =
 * 0.5 beta release
 * Enhancement: New form helper function add_field_descriptive_text()
 * Enhancement: A friendlier error message for failed logins
 * Bug Fix: Minor - Validate that GMAP_LOCATION field name doesn't contain hyphens, also changed the correspoding sample file

= 0.4.13 =
 * 0.5 beta release
 * Bug Fix: Minor - Pagination helper bug with periods in mysql table columns (e.g.'mytable.mycolumn')
 * Bug Fix: Minor - Do not display pagination helper filter text input if no filter fields are defined
 * Enhancement: More flexible ways of passing custom rows to the pagination helper

= 0.4.12 =
 * Preparation for 0.5 release
 * Enhancement: Can override the use of the html table helper from the pagination helper

= 0.4.11 =
 * Preparation for 0.5 release
 * Bug Fix: Major - Fixed bugs in tina_mvc_get_multisite_blog_name() and tina_mvc_query_parser() with Multisite and subdirectories
 * Bug Fix: Minor - Pagination helper was producing malformed SQL under certain conditions
 
= 0.4.10 =
 * Preparation for 0.5 release
 * Bug Fix: Major - Pagination helper was extracting pager parameters incorrectly
 * Bug Fix: Minor - Incorrect controller links in a sample view file

= 0.4.9 =
 * Enhancement: added a SQL Pagination Helper and a HTML Table Helper
 * Enhancement: added sample files for the new helpers
 
= 0.4.8 =
 * Bug Fix: Minor - Bug in tina_mvc_find_libs_folder()
 * Bug Fix: Major - Incorrect identification of the front end controller page when using WP multisite subdirectory install
 * Bug Fix: Trivial - Wrong dev version at the top of the readme.txt file

= 0.4.7 =
 * Enhancement: added a span around each radio option (form helper). Helps with styling
 * Enhancement: Wordpress Multisite and cascading, site specific, app folders. Allows for app folders specific to each blog
 * Enhancement: we flush_rewrite_rules() on activation. Required if you are using custom posts

= 0.4.6 =
 * Enhancement: $tina_mvc_base_page_class->add_var() and add_var_e() for adding template view data for automatic use by the load_view() method
 * Enhancement: The example_mvc page controller uses the above functionality
 * Enhancement: added comments to sample apps on putting everything in the constructor and not using the add_var() and add_var_e() functions
 * Enhancement: added $tina_mvc_user_data to tina_mvc_app_settings_sample.php for user data. Stored in 'tina_mvc_user_data' wp option
 * Enhancement: added error checking for when we find a page controller but the class is not defined in it
 * Enhancement: added an ID to FORM element generated by the form helper class
 * Enhancement: Altered HTML comment added to page output when a view file is loaded ('TINA_MVC VIEW FILE START')
 * Bug Fix: Major - Fixed issue where the page filter was catching user wp_query calls when on a Tina MVC page controller page
 * Bug Fix: Major - tina_mvc_esc_html_recursive() was not escaping properly
 * Bug Fix: Minor - Removed the error handling directive from tina_mvc.php
 * Bug Fix: Minor - Pass-by-reference mistake in tina_mvc/apps/index_view.php
 
= 0.4.5 =
 * Bug Fix: form helper was not using the correct field caption for 2 validate_as_*() functions
 * Bug Fix: minor bug in 3 validation functions
 * Enhancement: added tmpr() and tmprd() (aliased to) tina_mvc_print_r() functions for print_r() style debugging
 * Enhancement: new validation function types - SQL_TIME and SQL_SHORT_TIME

= 0.4.4 =
 * Bug Fix: Google Maps javascript errors with more than one map per page
 * Bug Fix: Fixed password validation mistake caused by sloppy copy/paste (D'oh!)
 * Bug Fix: Minor error in forms_helper ($valid_validation_rules)
 * Enhancement: Added E_USER_NOTICE to the default error reporting.

= 0.4.3 =
 * Bug Fix: $tina_mvc_enable_init_bootstrap_funcs setting was broken
 * Enhancement: Replaced all php short open tags
 * New stable tag

= 0.4.2 =
 * Enhancement: Added various MySQL date, time and datetime formatting functions
 * Bug Fix: Password was not being verified properly on the user change email form
 * New stable tag

= 0.4.1 =
 * Enhancement: Form helper gets a 'GMAP_LOCATION' field input type
 * Enhancement: Form helper only loads reCaptcha libs if you define a reCaptcha field

= 0.4 =
 * New stable tag

= 0.3.6 =
 * Bug fix: In tina_mvc_app_settings.php - setting the parent page for a Tina front end controller page was not working
 * Bug fix: Various fixes ported from Tina MVC Commercial version
 * Bug fix: tina_mvc_functions.php - tina_mvc_get_GetPost() function
 * Enhancement: Better form helper sample app
 * Enhancement: HTML comments output before and after each parsed view file. Makes it easier for your designer to find a template
 * Change: $tina_mvc_disable_wpautop setting is enabled by default

= 0.3.5 =
 * Bug fix: Various small (and some not so small) bugs in the form helper
 * Bug fix: in tina_mvc_get_GetPost()
 * Enhancement: A new test form to demonstrate all form helper functionality (I hope)
 
= 0.3.4 =
 * Bug fix: Form helper was not returning the correct variables after form was submitted
 
= 0.3.3 =
 * Enhancement: Make it easier to change the name of the plugin folder name. See constant TINA_MVC_PLUGIN_DIR at the top of tina_mvc.php
 * Enhancement: New app settings option: disable wpautop() for Tina MVC pages
 * Enhancement: The form helper can manage file uploads now
 * Enhancement: added a form_errors() method to the form helper class
 
= 0.3.2 =
 * Enhancement: More control over setting up front end controller pages (see tina_mvc_app_settings_sample.php)
 
= 0.3.1 =
 * Bug fix: $request was not being passed to default 'index' controller method by the dispatcher

= 0.3 =
 * Complete reorganisation of core files
 * Rewrite of core page controllers and views
 * the form helper is not autoloaded any more. Use tina_mvc_include_helper('tina_mvc_form_helper') first
 * new function tina_mvc_call_page_controller() for use in your apps or theme template files
 * can use custom folder locations for page controllers `tina_mvc_call_page_controller()` and views `tina_mvc_base_page_class->load_view()` to separate core code from your own apps
 * tina_mvc_user_has_role() and tina_mvc_user_has_capability() accept comma seperated list or arrays
 * Added app_bootstrap feature - allows you to enqueue styles and scripts before page output begins when using widgets or shortcodes
 * Added app_init_bootstrap feature - allows you to run code (e.g. to register a custom post) at the init action hook
 * Changed how shortcodes are run - now we go before wp_texturizer()
 * The contents of a non self-enclosing shortcode are available to the page controller now
 * Added 'app_install_remove' to allow running arbitrary code on plugin install/remove. See tina_mvc_admin_install()/tina_mvc_admin_remove() in tina_mvc_admin_functions.php
 * Added a basic framework for unit tests (unfinished)
 * Removed the phpDocumentor tutorials folder.
 * Bug fix: tina_mvc_form_helper_class->validate_as_REGEXP() was broken
 * Fixed a possible XSS attack vector

= 0.2 =
* Rollup release of recent fixes and additions
 - Minor bug: Widget title was not being passed through apply_filters() if you used set_page_title() from your page controller
 - Edited the default front end controller page content
 - Added a logo
 - Added a sample application (widgets_page.php)
 - Fixed minor bug in a sample app
* Preparatory release prior to 0.3 release and reorganisation of plugin

= 0.1.12 =
* Release of recent changes
* Added a sample application (widgets_page.php)
* RC2 for 0.2

= 0.1.11.2 =
* Edited the default front end controller page content
* Added a logo

= 0.1.11.1 =
* Minor bug: Widget title was not being passed through apply_filters() if you used set_page_title() from your page controller

= 0.1.11 =
* Fixed a critical bug introduced in last commit

= 0.1.10.2 =
* Fixed a typo

= 0.1.10.1 =
* Added PHPDocumentor style manual
* Updated description

= 0.1.10 =
* Rollup and testing of recent fixes and additions
 - removal of the PHP __autoload() function requirement
 - new dispatcher method for auto excuting your mothods
 - $tina_mvc_missing_page_controller_action to manage missing controller errors
* Example page for the new dispatcher method
* RC1 for 0.2

= 0.1.9.4 =
* Widgets and shortcodes now display missing controller errors when $tina_mvc_missing_page_controller_action option == 'display_errors'

= 0.1.9.3 =
* Added 'tina_mvc_missing_page_controller_action' option
* Provides configurable behaviour of what happens when a missing page controller is called

= 0.1.9.2 =
* Removed the __autoload() function definition

= 0.1.9 =
* Pushed recent changes to a stable tag

= 0.1.8.2 =
* Backported various bug fixes from a app development session
* Started to add basic functionality to mvc models
* Changed version numbering system. x.x.x releases are kept for stable tags, x.x.x.x for the latest development version

= 0.1.8.1 =
* Bug in the contact-form sample controller. Made it more functional while I was at it.

= 0.1.8.1 =
* Bug in the contact-form sample controller. Made it more functional while I was at it.

= 0.1.8 =
* Custom pages for registration, login, password reminder
* Custom user landing page
* View files working properly with widgets and shortcodes
* Permissions (role and capability based) working
* Lots of minor bugfixes
* Lots of general tidying

= 0.1.7.5 =
* Release candidate 3 for 0.1.8
* Critical enhancement: New tina_mvc_app_settings_sample.php file. Added `$tina_mvc_logon_redirect_target`
* Major bugfix: fixed a bug introduced on last commit. Was causing load_view() to fail when used in widgets (and possibly shortcodes).

= 0.1.7.4 =
* Release candidate 2 for 0.1.8
* Major enhancement: added a new helper function to the forms helper.

= 0.1.7.3 =
* Release candidate for 0.1.8
* Critical enhancement: Tina MVC custom user pages should now be working fine.
* Major bugfix: Several helper functions were fixed. These were causing the redirect functionality to fail when you use the Tina MVC custom user pages.

= 0.1.7 =
* Minor bugfix: tina_mvc_make_controller_url() was creating an incorrect url for absolute controller paths.
* Trivial bugfix: In sample apps, index_view() was using the wrong function to create some links to sample apps.

= 0.1.6 =
* Added backup/restore functionality to migrate settings when Tina MVC is upgraded

= 0.1.5 =
* Tidied the PhpDocumentor tags.

= 0.1.4 =
* Fixed a bug that was causing tina_mvc_make_controller_url() to return incorrect paths to controllers

= 0.1.3 =
* Fixed a logic typo which was causing the http redirect from wp-admin/wp-login to fail if $default_role_to_view == '' instead of '-1' (the default setting).

= 0.1.2 =
* Changed the plugin folder name to tina-mvc (to match the Wordpress.org name)

= 0.1.1 =
* Minor change to the readme.txt file.

= 0.1 =
* Initial release to the wild.
