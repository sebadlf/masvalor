<?php
/**
* Functions used by admin to manage the plugin
*
* Install, remove, and other infrequently used actions are stored here to keep
* the main plugin file small.
*
* @package    Tina-MVC
* @subpackage Tina-Core-Helpers
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * Wordpress function that installs the plugin - runs when plugin is activated or upgraded
 *
 * Install/Upgrades the Wordpress plugin. Takes settings from 'tina_mvc_app_settings_sample.php' or
 * 'tina_mvc_app_settings.php' and creates Wordpress pages and options accordingly.
 * 
 * This function will be run whenever the plugin is upgraded AFTER any saved settings
 * have been copied back to the tina-mvc. Check the $tina_mvc_upgrade_backups variable in the settings file
 *
 * You can have arbitrary code run on install by putting a function called tina_mvc_app_install in a file called
 * tina_mvc_app_install.php in the 'app_install_remove' folder
 *
 * @param boolean $upgrading set to true if function is called during plugin upgrade
 *
 * @see  tina_mvc_install()
 */
function tina_mvc_admin_install($upgrading) {
    
    global $wpdb;
    
    // find an app settings file...
    if( file_exists( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings.php' ) ) {
      include( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings.php' );
    }
    else {
      include( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings_sample.php' );
    }
    
    // are we using multisite app folders?
    if( ! empty( $tina_mvc_enable_multisite ) ) {
        
        $tina_mvc_enable_multisite_saved = $tina_mvc_enable_multisite;
        
        // we look for a settings file...
        // find an app settings file... based on the site name/id
        
        if( file_exists( ($f=tina_mvc_find_plugin_folder().'/app_multisite/sites/'.tina_mvc_get_multisite_blog_name().'/tina_mvc_app_settings.php' )) ) {
          include( $f );
        }
        elseif( $tina_mvc_multisite_app_cascade_saved AND file_exists( ($f=tina_mvc_find_plugin_folder().'/app_multisite/default/tina_mvc_app_settings.php' )) ) {
          include( $f );
        }
        else {
            
            trigger_error('No suitable applications found in \'app_multisite\' folder. Try copying from the sample apps folder.', E_USER_ERROR);
          
            // include( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings_sample.php' );
        }
        
        $tina_mvc_enable_multisite = $tina_mvc_enable_multisite_saved;
        
    }
    
    // for the Wordpress options
    $tina_mvc_options_pages = array();
    
    // grab the default page text.
    $post_content = get_tina_mvc_default_page_post_content();
    
    // loop through the pages....
    foreach( $tina_mvc_pages AS $p ) {
      
      // does the page exist...?
      $the_page = get_page_by_path( $p['page_name'] );
      
      if ( ! $the_page ) {
        
        // Create post object
        $_p = array();
        $_p['post_title'] = $p['page_title'];
        
        // check if we need to set a parent page.
        $parent_page_id = 0; // default
        $slash_pos = strrpos( $p['page_name'] , '/' ); // is there a path or just a name?
        
        if( $slash_pos !== FALSE) {
            
            $the_parent_page_name = substr( $p['page_name'] , 0, $slash_pos );
            $p['page_name'] = substr( $p['page_name'] , $slash_pos+1 , strlen($p['page_name']) - ($slash_pos+1) );
            
            if( $the_parent_page_name ) {
                $parent_page = get_page_by_path( $the_parent_page_name );
                $parent_page_id = $parent_page->ID;
            }
            
        }
        $_p['post_parent'] = $parent_page_id;
        
        $_p['post_name'] = $p['page_name'];
        $_p['post_content'] = $post_content;
        $_p['post_status'] = $p['page_status'];
        $_p['post_type'] = 'page';
        
        // MENu order?
        $menu_order = 0; // default
        if( array_key_exists( 'menu_order', $p ) ) {
            $menu_order = intval( $p['menu_order'] );
        }
        $_p['menu_order'] = $menu_order;
        
        $_p['comment_status'] = 'closed';
        $_p['comment_count '] = 0;
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1);
        
        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );
        
      }
      else {
        
        $the_page_id = $the_page->ID;
        
        //make sure the page is not trashed...
        $the_page->post_status = $p['page_status'];
        $the_page_id = wp_update_post( $the_page );
        
      }
      
      // get the page in case Wordpress messed with the page_name
      $_p = get_page( $the_page_id );
      
      // FOR the options
      $page_name = $_p->post_name;
      $page_id = $_p->ID;
      $page_data = array( 'page_title'=>$_p->post_title, 'page_name'=>$page_name, 'page_id'=>$page_id ); // handy to have them for later...
      
      $tina_mvc_options_pages[$page_name] = $page_data;
      $tina_mvc_options_pages[$page_id] = $page_data;
      
    }
    
    delete_option("tina_mvc_pages");
    add_option("tina_mvc_pages", $tina_mvc_options_pages, '', 'yes');
    
    // multisite apps enabled? this option is global
    $_opt = $tina_mvc_enable_multisite;
    delete_option("tina_mvc_enable_multisite");
    add_option("tina_mvc_enable_multisite", $_opt, '', 'yes');
    
    // multisite cascade apps? this setting is on a per-site basis
    $_opt = $tina_mvc_multisite_app_cascade;
    delete_option("tina_mvc_multisite_app_cascade");
    add_option("tina_mvc_multisite_app_cascade", $_opt, '', 'yes');
    
    // the default role to view...
    $_opt = $tina_mvc_default_role_to_view;    
    delete_option("tina_mvc_default_role_to_view");
    add_option("tina_mvc_default_role_to_view", $_opt, '', 'yes');
    
    // the tina_mvc_login_logout_redirect...
    $_opt = $tina_mvc_login_logout_redirect;
    delete_option("tina_mvc_login_logout_redirect");
    add_option("tina_mvc_login_logout_redirect", $_opt, '', 'yes');
    
    // the tina_mvc_logon_redirect_target...
    $_opt = $tina_mvc_logon_redirect_target;
    delete_option("tina_mvc_logon_redirect_target");
    add_option("tina_mvc_logon_redirect_target", $_opt, '', 'yes');
    
    // the tina_mvc_logout_redirect_target...
    $_opt = $tina_mvc_logout_redirect_target;
    delete_option("tina_mvc_logout_redirect_target");
    add_option("tina_mvc_logout_redirect_target", $_opt, '', 'yes');
    
    // the default capability to view...
    $_opt = $tina_mvc_default_capability_to_view;
    delete_option("tina_mvc_default_capability_to_view");
    add_option("tina_mvc_default_capability_to_view", $_opt, '', 'yes');
    
    // the reCaptcha api keys
    $_opt = $tina_mvc_recaptcha_pub_key;
    delete_option("tina_mvc_recaptcha_pub_key");
    add_option("tina_mvc_recaptcha_pub_key", $_opt, '', 'yes');
    $_opt = $tina_mvc_recaptcha_pri_key;
    delete_option("tina_mvc_recaptcha_pri_key");
    add_option("tina_mvc_recaptcha_pri_key", $_opt, '', 'yes');
    
    // the missing page controller action...
    $_opt = $tina_mvc_missing_page_controller_action;
    delete_option("tina_mvc_missing_page_controller_action");
    add_option("tina_mvc_missing_page_controller_action", $_opt, '', 'yes');
    
    // disable wpautop?
    $_opt = $tina_mvc_disable_wpautop;
    delete_option("tina_mvc_disable_wpautop");
    add_option("tina_mvc_disable_wpautop", $_opt, '', 'yes');
    
    // the backup list...
    delete_option("tina_mvc_upgrade_backups");
    add_option("tina_mvc_upgrade_backups", $tina_mvc_upgrade_backups, '', 'no');
    
    // bootstrap
    $_opt = $tina_mvc_enable_bootstrap_funcs;
    delete_option("tina_mvc_enable_bootstrap_funcs");
    add_option("tina_mvc_enable_bootstrap_funcs", $_opt, '', 'yes');
 
    // init bootstrap
    $_opt = $tina_mvc_enable_init_bootstrap_funcs;
    delete_option("tina_mvc_enable_init_bootstrap_funcs");
    add_option("tina_mvc_enable_init_bootstrap_funcs", $_opt, '', 'yes');
    
    // tina_mvc_user_data
    $_opt = $tina_mvc_user_data;
    delete_option("tina_mvc_user_data");
    add_option("tina_mvc_user_data", $_opt, '', 'yes');
   
	
    // finally
    delete_option("tina_mvc_plugin_active");
    add_option("tina_mvc_plugin_active", TRUE, '', 'yes');
	
	if( file_exists( tina_mvc_find_app_install_remove_folder().'/masvalor_app_install.php' ) ) {
		include( tina_mvc_find_app_install_remove_folder().'/masvalor_app_install.php' );
		if( function_exists( 'masvalor_create_db' ) ) {
			masvalor_create_db();
		}
		
	}
    
    // finally we flush permalinks
    // this is required if you are using custom posts
    flush_rewrite_rules();
    
}

/**
 * Wordpress function that removes the plugin - runs on deactivation
 *
 * You can have arbitrary code run on install by putting a function called tina_mvc_app_remove in a file called
 * tina_mvc_app_remove.php in the 'app_install_remove' folder
 * 
 */
function tina_mvc_admin_remove() {
    


    global $wpdb;
    
    //  the id of our pages...
    $the_pages = ( get_option( 'tina_mvc_pages' ) );
    
    if( $the_pages ) {
      
      foreach( $the_pages AS $_p ) {
        
        wp_delete_post( $_p['page_id'] );
        
      }
      
    }
    
    if( file_exists( tina_mvc_find_app_install_remove_folder().'/tina_mvc_app_remove.php' ) ) {
        
        include( tina_mvc_find_app_install_remove_folder().'/tina_mvc_app_remove.php' );
        if( function_exists( 'tina_mvc_app_remove' ) ) {
            
            tina_mvc_app_remove();
            
        }
        
    }
    
    // LEAVE OUT FOR THE MOMENT
    /*
    if( $check_init_bootstrap ) {
      $dir = tina_mvc_find_app_init_bootstrap_folder();
    }
    else {
      $dir = tina_mvc_find_app_bootstrap_folder();
    }
    $files = scandir( $dir );
    
    foreach( $files AS $f ) {
      $f = strtolower($f);
      if( !in_array( $f , array('.','..','index.php' )) AND (strpos( $f , '.php' ) !== FALSE) ) {
        
        include_once( $dir .'/'.$f );
        call_user_func( str_replace('.php','',$f) );
        
      }
      
    }
    */
    
    delete_option("tina_mvc_enable_multisite");
    delete_option("tina_mvc_multisite_app_cascade");
    delete_option("tina_mvc_pages");
    delete_option("tina_mvc_default_role_to_view");
    delete_option("tina_mvc_login_logout_redirect");
    delete_option("tina_mvc_logon_redirect_target");
    delete_option("tina_mvc_logout_redirect_target");
    delete_option("tina_mvc_default_capability_to_view");
    delete_option("tina_mvc_recaptcha_pub_key");
    delete_option("tina_mvc_recaptcha_pri_key");
    delete_option("tina_mvc_missing_page_controller_action");
    delete_option("tina_mvc_disable_wpautop");
    delete_option("tina_mvc_enable_bootstrap_funcs");
    delete_option("tina_mvc_user_data");
    delete_option("tina_mvc_enable_init_bootstrap_funcs");
    
    // finally
    delete_option('tina_mvc_plugin_active');
    
}


/**
 * Generic copy utility
 *
 * Thanks to Clay Lua (http://hungred.com) for illustrating the technique
 * 
 * @param   string $source 
 * @param   string $dest 
 * @return  boolean true
 */
function hpt_copyr($source, $dest)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        hpt_copyr("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    return true;
}

/**
* Delete a file, or a folder and its contents
*
* @author Aidan Lister <aidan@php.net>
* @version 1.0.2
* @see http://putraworks.wordpress.com/2006/02/27/php-delete-a-file-or-a-folder-and-its-contents/
*
* @param string $dirname Directory to delete
* @return bool Returns TRUE on success, FALSE on failure
*/
function hpt_rmdirr($dirname) {
    // Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
    
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
    
    // Loop through the folder
    $dir = dir($dirname);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
        
        // Recurse
        hpt_rmdirr("$dirname/$entry");
    }
    
    // Clean up
    $dir->close();
    return rmdir($dirname);
    
}

/**
 * Backup files before plugin upgrade
 *
 * Thanks to Clay Lua (http://hungred.com) for illustrating the technique
 *
 * @todo  move it all to the tine_mvc_admin_functions helper
 * @uses hpt_copyr()
 */
function tina_mvc_admin_hpt_backup() {
    
    // what config file are we using...?
    if( file_exists( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings.php' ) ) {
      include( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings.php' );
    }
    else {
      include( tina_mvc_find_plugin_folder().'/tina_mvc_app_settings_sample.php' );
    }
    
    // we now have $tina_mvc_upgrade_backups set...

    if( isset($tina_mvc_upgrade_backups) AND is_array($tina_mvc_upgrade_backups) ) {
      
      // make sure that the $tina_mvc_upgrade_backups is stored in the Wordpress options... we need them later!
      if( ! get_option('tina_mvc_upgrade_backups') ) {
        add_option("tina_mvc_upgrade_backups", $tina_mvc_upgrade_backups, '', 'no');
      }      
      
      // make a folder for backup...
      $bu_fldr = tina_mvc_find_plugin_folder().'/../../upgrade/tina_mvc_upgrade_backup';
      // try to create...
      if( ! is_dir($bu_fldr) AND ! mkdir($bu_fldr) ) {
        
        return  new WP_Error('no_permission', __('Wordpress cannot create a backup folder to keep your settings. You will have to manually upgrade Tina MVC.'). ' Tried: '.$bu_fldr );
        
      }
      else {
        
        foreach( $tina_mvc_upgrade_backups AS $item ) {
          
          if( file_exists( tina_mvc_find_plugin_folder()."/$item" ) ) {
            $result = hpt_copyr( tina_mvc_find_plugin_folder()."/$item", "$bu_fldr/$item" );  
          }
          
        }
        
      }    
      
    }    
    
}

/**
 * Recover files after plugin upgrade
 *
 * Thanks to Clay Lua (http://hungred.com) for illustrating the technique
 *
 * @uses hpt_copyr()
 * 
 */
function tina_mvc_admin_hpt_recover() {
    
    $tina_mvc_upgrade_backups = get_option('tina_mvc_upgrade_backups');
    
    // the the backup folder
    $bu_fldr = tina_mvc_find_plugin_folder().'/../../upgrade/tina_mvc_upgrade_backup';
    
    // we now have $tina_mvc_upgrade_backups set...
    if( isset($tina_mvc_upgrade_backups) AND is_array($tina_mvc_upgrade_backups) ) {
      
      if( ! is_dir($bu_fldr) ) {
        
        return  new WP_Error('no_backup_folder', __('The backup folder doesn\'t exist. You will have to manually upgrade Tina MVC.'));
        
      }
      else {
        
        foreach( $tina_mvc_upgrade_backups AS $item ) {
          
          if( file_exists("$bu_fldr/$item") ) {
            $result = hpt_copyr( "$bu_fldr/$item", tina_mvc_find_plugin_folder()."/$item" );  
          }
          
        }
        
      }
      
      if (is_dir($bu_fldr)) {
          //    hpt_rmdirr($bu_fldr);// we'll not delete anything until we know all is well!
      }
      
      // we've perhaps copied a new settings file. run tina_mvc_install() to re-read the
      // new settings... $upgrading=true
      tina_mvc_install( true );
      
    }
    
}

/**
 * The default page/post content for a Tina MVC front end controller page. Used on plugin activation
 *
 * @return  string default page content
 */
function get_tina_mvc_default_page_post_content() {
    
    return 
    "Esta pagina es el controlador del FRONT END, y solo sirve para controlar las vistas de Masvalor, este contenido solo se vera en la pagina si el plugin esta desactivado.";
    
}

?>