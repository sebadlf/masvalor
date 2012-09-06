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

<script language="javascript" type="text/javascript">

function saveDelete(cid){
    if(confirm("¿Est\u00e1 seguro que quiere borrar la Actividad?")) {  
	   document.forms['adminForm'].task.value = 'delete';
	   document.forms['adminForm'].cid.value = cid;
	   document.forms['adminForm'].submit(); 
	}   
}


</script>  

  
<style>

#table_noticia thead{
  background-color: #adaeb2;
}

a{
 text-decoration: none;
 color:black;
}
</style>
	 
						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px; margin-left: -37px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<h2  style="margin-left: 17px;"><?php echo __('Actividades') ?></h2>
			<br/>	
			<table>
			 <tr>
				 <td>
				
					
					<div>
					  <td style="width:100%;padding-left: 11px;"><?php echo __('Filtro') ?>
						<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="" class="text_area" title="Filtro"/>   
						<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;width: 88px;">
						    <option value="pos.post_title"><?php echo __('T&iacute;tulo') ?></option>
						</select>	
					   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
					  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
					</div>	
					
					
					<div style="float: right; margin-top: 6px;">
						<a href="<?php echo masvalor_getUrl(); ?>/activitie/"> <img src="wp-content/plugins/masvalor/app/includes/image/nuevo.png"></a> 
					</div>
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha Inicio') ?></th>
								<th><?php echo __('Fecha Fin') ?></th>
								<th><?php echo __('Fecha Vencimiento') ?></th>
								<th><?php echo __('Prioridad') ?></th>
								<th><?php echo __('Borrar') ?></th>
								<th><?php echo __('Editar') ?></th>
								<th><?php echo __('Inscriptos') ?></th>
							</thead>
							
							<tbody>

							<?php  foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->post_title;?></td>
											<td><?php echo $data->start_date;?></td>
											<td><?php echo $data->end_date;?></td>
											<td><?php echo $data->post_date_espirate;?></td>
											<td><?php echo $data->priority;?></td>

											<td><a href="#" onclick="saveDelete('<?php echo $data->ID;?>');"> X </a></td>
											<td><a href="<?php echo masvalor_getUrl(); ?>/activitie/&cid=<?php echo $data->ID;?>">
												<img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
											</a></td>
											
											<td><a href="<?php echo masvalor_getUrl(); ?>/activities_registered/&cid=<?php echo $data->ID;?>">
											    <img alt="<?php echo __('Inscriptos') ?>" title="<?php echo __('Inscriptos') ?>" src="wp-content/plugins/masvalor/app/includes/image/inscriptos.png" />
											</a></td>
										</tr>
							<?php }?>
										
											
																				
						  </tbody>
					</table>
				</td>
			 </tr>		
		    </table>
			<input type="hidden" name="cid" value="" />	
			<input type="hidden" name="task" value="" />
			
		   </form>
		  			
		</div>
		
			
				
				
