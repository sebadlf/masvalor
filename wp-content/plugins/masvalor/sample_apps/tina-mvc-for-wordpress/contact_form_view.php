<?php
//
// $Id: contact_form_view.php, v 0.00 Sun Feb 21 2010 17:53:09 GMT+0000 (IST) Francis Crossen $
//

/**
* The view file for the contact_form page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
* @see        contact_form_page.php the page controller
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
/**
 * The variables you passed to the view file are available as $V in the local scope
 */
?>

<?php echo $V->emailed_ok_message ?>

<?php echo $V->the_form ?>
