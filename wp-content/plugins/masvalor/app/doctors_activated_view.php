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

 <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
 
<script language="javascript" type="text/javascript">

function activadDoctors(){
    if(confirm("\u00BFEst\u00e1 seguro que quiere aceptar a el/los doctor/es?")) {
		document.forms['adminForm'].task.value = 'activadDoctors';
		document.forms['adminForm'].submit(); 
	}
	
}


function checkUncheckAll(cid) {
    input = document.getElementById('userid');
	input.value +=cid + ',';
	
}

</script>  

  

<style>

#table_noticia thead{
  background-color: #aaaaaa;
}

a{
 text-decoration: none;
 color:black;
}
</style>
	 
											
			<div id="table_noticia" style=" font-size: 14px;margin-left: -55px;width: 733px;">
				<form action="" method="post" name="tinymce" id="adminForm">	
					<h2 style="margin-left:26px;"><?php echo __('Activaci&oacute;n Doctores') ?></h2>
    				 <br/>
					<table>
					<tr>
						 <td>
						 						  
							<div>
							  <td style="width:100%;padding-left:26px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
								  
								     <option value="lastname"><?php echo __('Apellido') ?> </option>
								     <!--option value="identity_number"><?php echo __('DNI') ?></option>
									 <option value="main_contact_mail"><?php echo __('E-mail') ?></option-->
								</select>	
							   <button onclick="this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
							  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						    </div>	
							
							<div style="float: right; margin-top: -4px;">
							    <a href="#" title="Activar" onclick="activadDoctors()" > <img WIDTH="36" HEIGHT="36" src="wp-content/plugins/masvalor/app/includes/image/actived.png"></a> 
						    </div>
							
							<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
									
							<div style="width:100%">
								<hr/>
							</div>	
								
									<thead>
									    <th><?php echo __('Nombre') ?></th>
										<th><?php echo __('Apellido') ?></th>
										<th><?php echo __('Disciplina') ?></th>
										<th><?php echo __('T&iacute;tulo Doctor') ?></th>
										<th><?php echo __('Activar') ?></th>
									</thead>
													
																
									<tbody>
									
										<?php foreach ( $V->datas as $result ) {?>
											<?php if(($result->name != '' && $result->name != null) && ($result->lastname != null && $result->lastname != '') && 
											          ($result->name_dis != '' && $result->name_dis != null) && ($result->title != null && $result->title != '') &&
													  ($result->title_tesis != '' && $result->title_tesis != null)&& ($result->identity_number != '' && $result->identity_number != null) &&
													  ($result->title_grad != '' && $result->title_grad != null) ) { ?>					
												<tr style="background-color:#eeeeee;">
													<td>
														 
														 <a href="/?page_id=425/doctor-profile/&cid=<?php $result->userid; ?>" target="_blank" ><?php echo $result->name;?></a>
													</td>
													<td><?php echo $result->lastname;?></td>
													<td><?php echo $result->name_dis;?></td>
													<td><?php echo $result->title;?></td>
													<td align="center"> 
														<input id="actived" type="checkbox" onclick="checkUncheckAll('<?php echo $result->userid; ?>')" name="actived"><br>
													</td>											
												</tr>
											<?php } ?>
																					 
									<?php } ?>
																						
								  </tbody>
							
							  </table>
						</td>
					</tr>		
				   </table> 
				   				   
					<div class="paginator" style="margin-left:35px">
							<?php 
							$pages = ceil($V->count/$V->itemsPerPage);
							if ($pages > 1)
								for ($i=1;$i<=$pages;$i++){
									$pageLink = masvalor_getUrl().'/doctors_activated/&limitstart='.(($i-1)*$V->itemsPerPage);
									if ($V->currPage != $i)
										$href = '<a href='.$pageLink.'>'.$i.'</a>';
									else
										$href = $i;
									if ($i==1)
										echo $href;
									else
										echo ' - '.$href;
								}
							?>
					</div>
				   
					<input type="hidden" name="cid" value="" />	
					<input type="hidden" name="userid" id="userid" value=""/>
					<input type="hidden" name="task" value="" />
			
				</form>
				
				
		</div>
			
			
				
				
