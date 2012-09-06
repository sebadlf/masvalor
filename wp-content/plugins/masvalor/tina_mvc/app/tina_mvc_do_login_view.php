<?php
/**
* Render a login page
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
<h2>Please login or register:</h2>

<h3>Already a user? Login here</h3>
<?php echo $V['login_form'] ?>

<p><?php echo tina_mvc_make_controller_link('register/recover-password', 'Need to Recover your password? Go here.') ?></p>

<h3><?php echo tina_mvc_make_controller_link('register', 'Need to Register? Go here.') ?> It only takes a minute.</h3>
