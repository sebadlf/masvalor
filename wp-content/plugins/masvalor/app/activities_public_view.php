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

<?php require_once ('models/masvalor_utils.php'); 

  global $current_user;
  get_currentuserinfo();

?>

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
				   <?php /* ?>
				   <br/>	
					
					<div>
					  <td align="left" width="50%"><?php echo __('Filtro') ?>
						<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="" class="text_area" title="Filtro"/>   
						<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;width: 88px;">
						  <option value=""> </option>
						  <option value=<?php //echo isSelect('p.anme',$var_search);?>><?php echo __('Nombre') ?></option>
						</select>	
					   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
					  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
					</div>	
					<?php */ ?>		
					
					<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:145%;text-align:center;margin-bottom: 27px;">
					<div style="width:145%">
						<hr/>
					</div>
					
							<thead>
								<th><?php echo __('T&iacute;tulo') ?></th>
								<th><?php echo __('Fecha Inicio') ?></th>
								<th><?php echo __('Fecha Fin') ?></th>
								<th><?php echo __('Descripci&oacute;n') ?></th>
							
								<?php if (checkUserType($current_user->user_login,'doctor') OR checkUserType($current_user->user_login,'company')){?>	
									<th><?php echo __('Anotarse') ?></th>
								
								<?php }?>
							</thead>
							
							<tbody>

							<?php  foreach ($V->datas as $data){ ?>
										<tr style="background-color:#eeeeee;">
											<td><?php echo $data->post_title;?></td>
											<td><?php echo $data->start_date;?></td>
											<td><?php echo $data->end_date;?></td>
											
											<td><a href="<?php echo home_url();?>/?p=<?php echo $data->id;?>" title="<?php echo __('Ver') ?>"><?php echo __('Ver') ?></a></td>
																						
											<?php if (checkUserType($current_user->user_login,'doctor') OR checkUserType($current_user->user_login,'company')){?>	
											
													<?php if(!$data->annotated) { ?>
													
														<td><a href="#" onclick="saveApplicat('<?php echo $data->id;?>');">
														   <img alt="<?php echo __('Anotate') ?>" title="<?php echo __('Anotate') ?>" WIDTH="16" HEIGHT="16" src="wp-content/plugins/masvalor/app/includes/image/nuevo.png" />
														</a></td>
													
													<?php }else{?>
													
														<td><a href="#" title="<?php echo __('Anotado') ?>">
														   <img alt="<?php echo __('Anotado') ?>" title="<?php echo __('Anotado') ?>" WIDTH="16" HEIGHT="16" src="wp-content/plugins/masvalor/app/includes/image/add_opac.png" />
														   </a>
														</td>
														
													<?php }?>
											<?php }?>
											
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
		
			
				
				
