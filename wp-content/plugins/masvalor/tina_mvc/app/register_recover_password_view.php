<?php
/**
* Template File: Reset your password
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
<h2>Recover your password:</h2>

<?php echo $V['password_recover_form'] ?>

<p>We will email you with further instructions.</p>

<h3><?php echo tina_mvc_make_controller_link('', 'Need to login? Go here.') ?></h3>
