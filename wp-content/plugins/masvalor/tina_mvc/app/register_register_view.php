<?php
/**
* Template File: Register as a user
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
<h2>Register here:</h2>

<?php echo $V['register_form'] ?>

<p>We will email a password to you.</p>

<h3><?php echo tina_mvc_make_controller_link('', 'Need to login? Go here.') ?></h3>
