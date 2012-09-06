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
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>

<script type="text/JavaScript" language="JavaScript">
	function put_in_hidden(img_name) {
		document.getElementById("to_delete").value = img_name;
		document.getElementById("adminForm").submit();
	}
</script>

<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<?php 
		echo '<h2>Galer&iacute;a de im&aacute;genes del sitio</h2><br />';
		echo '<table>';
			echo '<thead>';
				echo '<th align="center">Nombre</th>';
				echo '<th align="center">Ver imagen</th>';
				echo '<th align="center">Eliminar</th>';
			echo '</thead>';
			echo '<tbody>';
				foreach($V->images as $img) {
					echo '<tr>';
					echo '<td align="center">'.$img.'</td>';
			?>		<td align="center"><a href="<?php echo home_url(); ?>/wp-content/plugins/masvalor/app/includes/images_gallery/<?php echo $img; ?>">Ver</a></td>
					<td align="center" style="cursor:pointer;" onclick="put_in_hidden('<?php echo $img; ?>')">X</td>
			<?php
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';
	?>
	
	<input type="hidden" name="to_delete" id="to_delete" value=""/>
</form>
<br />
<form action="" method="post" enctype="multipart/form-data" name="uploadForm" id="uploadForm"> 
    Imagen a subir: <input name="image_path" id="image_path" type="file"/> 
    <input name="upload_image" id="upload_image" type="submit" value="Subir"/>  
</form><br> <span id="image"></span> 