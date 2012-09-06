<?php
/**
* Template File: Error creating the user account
*
* @package    Tina-MVC
* @subpackage Tina-Core-Views
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<h2>Account for "<?php echo $V['username'] ?>" was NOT created</h2>

<p>Sorry, but we encountered an error creating your account. Please 
<a href="mailto:<?php echo get_option('admin_email') ?>"contact the webmaster</a> for help.</p>

