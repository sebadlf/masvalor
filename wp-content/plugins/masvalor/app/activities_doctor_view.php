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
						
		<form action="" method="post" name="tinymce" id="adminForm">
			<h2><?php echo __('Mis Actividades') ?></h2>
			<table style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
			 <tr>
				 <td>
								   					
					<table id="tableSelectedEducation" class="admintable" style="width:650px;">
					<div style="width:100%">
						<hr/>
					</div>
					
							<thead style="background-color: #adaeb2;">
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha Inicio') ?></th>
								<th><?php echo __('Fecha Fin') ?></th>
								<th><?php echo __('Descripci&oacute;n') ?></th>
							
								<th><?php echo __('Fecha Inscripci&oacute;n') ?></th>
								
							</thead>
							
							<tbody>

							<?php  if($V->datas != null){
							         foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->post_title;?></td>
										<?php $start_date = explode('/',$data->start_date);
											  $start_date = implode('-',$start_date);    ?>
											<td><?php echo $start_date;?></td>
										<?php $end_date = explode('/',$data->end_date);
											  $end_date = implode('-',$end_date);    ?>
											<td><?php echo $end_date;?></td>
											
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
			
		  
			
		
		
			
				
				
