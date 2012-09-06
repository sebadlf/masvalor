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

function saveApplicat(cid){
   document.forms['adminForm'].task.value = 'saveApplicat';
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
	
 <div id="table_noticia" style="font-size: 14px;margin-left: -23px;margin-top: 20px;">	
	<form action="" method="post" name="tinymce" id="adminForm">
			<table>
			<tr>
				 <td>
				 <legend><h2><?php echo __('Actividades') ?></h2></legend>
				  
				 					 
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:650px;text-align:center;margin-bottom: 27px;">
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha Inicio') ?></th>
								<th><?php echo __('Fecha Fin') ?></th>
								<th><?php echo __('Descripci&oacute;n') ?></th>
								<th><?php echo __('Anotarse') ?></th>
							</thead>
							
							<tbody>

							<?php  if($V->datas != null){
									 foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->post_title;?></td>
											<td><?php echo $data->start_date;?></td>
											<td><?php echo $data->end_date;?></td>
											<td><a href="<?php echo home_url();?>/?p=<?php echo $data->id;?>" title="<?php echo __('Ver') ?>"><?php echo __('Ver') ?></a></td>
															
											<?php
												$date2 = explode("-",$data->date);
											   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
											?>
															
											<td><?php echo $dateend;?></td>
											
										</tr>
									<?php }?>	
							<?php }?>
										
											
																				
						  </tbody>
					</table>
				</td>
			</tr>		
		    </table>
			<input type="hidden" name="cid" value="" />	
			<input type="hidden" name="task" value="" />
			
	</div>	
			
				
				
