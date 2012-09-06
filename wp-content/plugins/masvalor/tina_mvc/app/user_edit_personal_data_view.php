<?php
/**
* Template File: Edit personal account data
*
* @package    Tina-MVC
* @subpackage Tina-Core-Views
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<h2>Change <?php echo $V->user->user_login ?>'s personal data</h2>

<p>For your security we ask you to enter your password when changing email address.</p>

<h3>Change Email address</h3>

<?php echo $V->edit_email_form ?>

<h3>Change Password</h3>

<?php echo $V->edit_password_form ?>

<p>Back to <?php echo tina_mvc_make_controller_link('user/my-personal-data','my personal data page') ?>.</p>

<p>Back to <?php echo tina_mvc_make_controller_link('','my dashboard page') ?>.</p>

