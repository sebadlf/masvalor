<?php
/**
* Template File: The users dashboard
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
<?php // an example of how to use a view file from within a view file... ?>
<h2>This is a MVC example page</h2>

<h3><?php echo $V->msg ?></h3>
<form enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable" style="font-size:11px">
		<tr>
			<td class="key">Field de ejemplo</td>
			<td><input class="text_area" type="text" name="name" size="30" id="name" value="<?php echo $V->data->name ?>" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" size="30" id="submit" value="Guardar!" /></td>
			<td></td>
		</tr>
		<input type="hidden" name="task" id="task" value="save"/>
	</table>
</form>

