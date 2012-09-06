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
   document.forms['adminForm'].task.value = 'delete';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
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
	 
						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<table>
			<tr>
					<td>
					<legend><h2><?php echo __('Inscriptos Actividad Nro') ?> : <?php echo $_GET['cid'] ?>  </h2></legend>
							
					<div style="float: right;margin-right: -274px;">
							<a href="javascript:history.back(1)">
									<img src="wp-content/themes/rollpix/images/headers/back.png">
							</a>
					</div>		
					
					<br/>	
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
					<legend><h3><?php echo __('Doctores') ?></h3></legend>
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('Nombre') ?></th>
								<th><?php echo __('Apellido') ?></th>
								<th><?php echo __('E-mail') ?></th>
								<th><?php echo __('Borrar') ?></th>
							</thead>
							
							<tbody>

							<?php  foreach ($V->datasDoctor as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->name;?></td>
											<td><?php echo $data->lastname;?></td>
											<td><?php echo $data->main_contact_mail;?></td>
											<td><a href="#" onclick="saveDelete('<?php echo $data->id;?>');"> X </a></td>
											<?php /*?>
											<th><a href="<?php echo masvalor_getUrl(); ?>/activitie/&cid=<?php echo $data->ID;?>">
												<img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
											</a></th>
											<?php */?>
										</tr>
							<?php }?>
										
											
																				
						  </tbody>
					</table>
					
					<div style="width:100%;margin-bottom: 45px;">
						<hr/>
					</div>
					
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
					 <legend><h3><?php echo __('Empresas')?></h3></legend>
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('Nombre') ?></th>
								<th><?php echo __('Raz&oacute;n Social') ?></th>
								<th><?php echo __('E-mail') ?></th>
								<th><?php echo __('Borrar') ?></th>
								
							</thead>
							
							<tbody>

							<?php  foreach ($V->datasCompany as $datas){ ?>
										<thead style="background-color: #eeeeee">
											<th><?php echo $datas->name;?></th>
											<th><?php echo $datas->business_name;?></th>
											<th><?php echo $datas->main_contact_mail;?></th>
											<th><a href="#" onclick="saveDelete('<?php echo $datas->id;?>');"> X </a></th>
											<?php /*?>
											<th><a href="<?php echo masvalor_getUrl(); ?>/activitie/&cid=<?php echo $data->ID;?>">
												<img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" />
											</a></th>
											<?php */?>
										</thead>
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
		
			
				
				
