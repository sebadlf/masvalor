<?php
/**
* Template File: Successfully created the user account
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
<h2>Account for "<?php echo $V['username'] ?>" Created</h2>

<p>Check your email account for your password. (You may need to check your SPAM folder for an email from '<?php echo tina_mvc_make_mail_from_address() ?>').</p>

<p>Proceed <?php echo tina_mvc_make_controller_link('', ' here to login.') ?></h2>
