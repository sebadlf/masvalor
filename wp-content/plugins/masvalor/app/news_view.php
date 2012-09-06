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
   
   if(confirm("¿Est\u00e1 seguro que quiere borrar la noticia?")) {
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
	    						
		<div id="table_noticia" style="font-size: 14px;margin-top: 20px;">
			<form action="" method="post" name="tinymce" id="adminForm">
			<table>
			<tr>
				 <td>
				 <legend><h2><?php echo __('Noticias') ?></h2></legend>
				 											
					<div style="float: right; margin-top: -22px;">
						<a href="<?php echo masvalor_getUrl(); ?>/new/"> <img src="wp-content/plugins/masvalor/app/includes/image/nuevo.png"></a> 
					</div>
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha') ?></th>
								<th><?php echo __('Fecha Vencimiento') ?></th>
								<th><?php echo __('Prioridad') ?></th>
								<th><?php echo __('Borrar') ?></th>
								<th><?php echo __('Editar') ?></th>
							</thead>
							
							<tbody>

							<?php  foreach ($V->datas as $data){ ?>
										<tr style="background-color: #e3e3e3">
											<td><?php echo $data->post_title;?></td>
											
											<?php
												  	$date= explode(" ", $data->post_date);
													$date2 = explode("-",$date[0]);
													$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
																								   
													if($data->post_date_espirate != NULL){
														$date= explode(" ", $data->post_date_espirate);
														$date2 = explode("-",$date[0]);
														$dateend_espeirate = $date2[2].'-'.$date2[1].'-'.$date2[0];
													}
													else $dateend_espeirate ="";
													
											 ?>
											
											<td><?php echo $dateend;?></td>
											<td><?php echo $dateend_espeirate;?></td>
											<td><?php echo $data->priority;?></td>



											<td><a href="#" onclick="saveDelete('<?php echo $data->ID;?>');"> X </a></td>
											<td><a href="<?php echo masvalor_getUrl(); ?>/new/&cid=<?php echo $data->ID;?>">
												<img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" /> </a></td>
										</tr>
							<?php }?>
										
											
																				
						  </tbody>
					</table>
				</td>
			</tr>		
		    </table>
			<input type="hidden" name="cid" value="" />	
			<input type="hidden" name="task" value="" />
			
		   
		</div>
		
			
				
				
