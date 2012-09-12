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

<script type="text/javascript" language="javascript">

function Active(cid){
   document.forms['adminForm'].task.value = 'active';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
}		
</script> 	


<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery-1.3.2.min.js"></script>
 <script language="javascript" type="text/javascript">
    
   $(document).ready(function() {
		$(".botonExcel").click(function(event) {
			$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
		});
	});
  
</script> 







<script language="javascript" type="text/javascript">

function saveDelete(cid){
    if(confirm("�Est\u00e1 seguro que quiere borrar el doctor?")) {
	   document.forms['adminForm'].task.value = 'delete';
	   document.forms['adminForm'].cid.value = cid;
	   document.forms['adminForm'].submit(); 
	}   
}

function order_grid(column_name,dir) {
	document.getElementById("order").value = column_name;
	document.getElementById("adminForm").submit();
	if(dir == 'desc')
		document.getElementById("order_dir").value = 'asc';
	else
		document.getElementById("order_dir").value = 'desc';
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

.admintable th {
	cursor:pointer;
}
</style>   
       									
			<div id="table_noticia" style=" font-size: 14px;margin-left: -55px;width: 733px;">
				<form action="" method="post" name="tinymce" id="adminForm">	
					<h2 style="margin-left:26px;"><?php echo __('Doctores') ?></h2>
    				 <br/>
					<table>
					<tr>
						 <td>
							<div>
							  <td style="width:100%;padding-left:26px;"><?php echo __('Filtro') ?>
								<input type="text" name="search" style="height: 13px;width: 193px;" id="search" value="<?php //echo $this->lists['search'] ?>" class="text_area" title="Filtro"/>   
								<select name="filter_sel" id="filter_sel" style="height: 26px;padding-top: 2px;">
								     <option value="lastname"><?php echo __('Apellido') ?> </option>
								     <option value="mu.name"><?php echo __('Nombre') ?> </option>
								     <option value="gender"><?php echo __('Sexo') ?></option>
									 <option value="mu.state"><?php echo __('Provincia') ?></option>
									 <option value="dis.name"><?php echo __('Disciplina') ?></option>
									 <option value="sub.name"><?php echo __('Subdisciplina') ?></option>
									 <option value="prt.title"><?php echo __('T&iacute;tulo') ?></option>
									 <option value="actived"><?php echo __('Estado') ?></option>
								</select>	
							
							   <button onclick="this.form.action = '<?php echo masvalor_getUrl().'/doctors/' ?>'; this.form.submit();" style="padding-top: 2px;"><?php echo __('Buscar') ?></button> 
							  <button style="padding-top: 2px;" onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='-1';this.form.submit();">Reset</button>
						    </div>	
							
							<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:683px;text-align:center;margin-bottom: 27px;">
									

							<div style="width:100%">
								<hr/>
							</div>	


									<thead>
									 <!--th><?php echo __('ID') ?></th-->
										<th onclick="order_grid('mu.name')"><?php echo __('Nombre') ?></th>
										<th onclick="order_grid('lastname')"><?php echo __('Apellido') ?></th>
										<th onclick="order_grid('gender')"><?php echo __('Sexo') ?></th>
										<th onclick="order_grid('mu.state')"><?php echo __('Lugar de Residencia') ?></th>
										<th onclick="order_grid('dis.name')"><?php echo __('Disciplina') ?></th>
										<th onclick="order_grid('sub.name')"><?php echo __('Subdisciplina') ?></th>
									    <!--th><?php echo __('Zona Conicet') ?></th>
										<th><?php echo __('Comision Asesora de Conicet') ?></th-->
										<th onclick="order_grid('prt.title')"><?php echo __('T&iacute;tulo Doctor') ?></th>
										<th onclick="order_grid('actived')"><?php echo __('Estado') ?></th>
										<th><?php echo __('Editar') ?></th>
									
									</thead>
									
									<tbody>
										
										<?php foreach ( $V->datas as $result ) 
										{?>

										<tr style="background-color:#eeeeee;">
											<!--td><?php echo $result->userid;?></td-->
											<td><?php echo $result->name;?></td>
											<td><?php echo $result->lastname;?></td>

											<td><?php echo $result->gender;?></td>
											<td><?php echo $result->city.','.$result->state;?></td>
											
											
											<td><?php echo $result->name_dis;?></td>
											<td><?php echo $result->name_subdis;?></td>
											<td><?php echo $result->title;?></td>
											<td><?php echo $result->actived;?></td>
											
											<?php /* ?>
											<!--td><?php echo $result->identity_number;?></td-->
											<?php
												$date2 = explode("-",$result->birth_date);
											   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
											?>
															
											<td><?php echo $dateend;?></td>
											<td><?php echo $result->main_contact_mail;?></td>
											
											
											<td>
											<?php 
												if ($result->cv != null && $result->cv != ''){
													$linkCv='wp-content/uploads/profiles/'.$result->username.'/'.$result->cv;
												?>
													<a style="color:#6899D3;" target="_blank" href="<?php echo $linkCv;?>" >
														<img alt="<?php echo __('Ver CV') ?>" title="<?php echo __('Ver CV') ?>" src="wp-content/plugins/masvalor/app/includes/image/cvdoc.png" />
													</a>	
												<?php } ?>
											</td>
										   <?php */ ?> 
											
											<td><a href="<?php echo masvalor_getUrl(); ?>/doctor-profile/&cid=<?php echo $result->userid;?>">
											   <img alt="<?php echo __('Editar') ?>" title="<?php echo __('Editar') ?>" src="wp-content/plugins/masvalor/app/includes/image/edit.png" /></a>
											</td>
										
										    <!--td style="font-size:14px;"><a href="#" title="Borrar" onclick="saveDelete('<?php echo $result->userid;?>');"> X </a></td-->
											
										</tr>
																					 
									<?php } ?>
																						
								  </tbody>


							  </table>
							  
									  
							<div class="paginator" style="margin-left:16px">
									<?php 
									$pages = ceil($V->count/$V->itemsPerPage);
									if ($pages > 1)
										for ($i=1;$i<=$pages;$i++){
											$pageLink = masvalor_getUrl().'/doctors/&limitstart='.(($i-1)*$V->itemsPerPage);
											
											//ECHO "<BR>".$pageLink. "<BR>";
											
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
									
									<div style="margin-top: 10px">
										Registros: <?php echo (int)$V->count; ?>	
									</div>
							</div>
							  
							  
							

							
						</td>
					</tr>	
					
					
						
				   </table> 
				   				   
					
				   
				    
				   
					<input type="hidden" name="cid" value="" />	
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="order" id="order" value="" />
					<input type="hidden" name="order_dir" id="order_dir" value="" />

				</form>
				
				
		</div>
			
			<table id="Exportar_a_Excel" class="admintable" style="display:none;font-size:11px;width:683px;text-align:center; margin-left: -27px;margin-bottom: 27px;">
			<div style="width:100%">
			  
				</div>	
					<thead style="background-color:#eeeeee;">
					    <th><?php echo __('ID') ?></th>
						<th><?php echo __('Nombre') ?></th>
						<th><?php echo __('Apellido') ?></th>
						<th><?php echo __('Estado') ?></th>
						<th><?php echo __('Sexo') ?></th>
						<th><?php echo __('Nacionalidad') ?></th>
						<th><?php echo __('Lugar de Residencia') ?></th>
						<th><?php echo __('Codigo Postal') ?></th>
						<th><?php echo __('Calle') ?></th>
						<th><?php echo __('Nro') ?></th>
						<th><?php echo __('Piso') ?></th>
						<th><?php echo __('Telefonos') ?></th>
						<th><?php echo __('Disciplina') ?></th>
						<th><?php echo __('Subdisciplina') ?></th>
						<th><?php echo __('Zona Conicet') ?></th>
				    	<th><?php echo __('Comision Asesora de Conicet') ?></th>
						<th><?php echo __('T&iacute;tulo Doctor') ?></th>
						<th><?php echo __('T&iacute;tulo Tesis') ?></th>
						<th><?php echo __('Tema Tesis') ?></th>
						<th><?php echo __('Subdisciplina Tesis'); ?></th>
						<th><?php echo __('DNI') ?></th>
						<th><?php echo __('Fecha Nacimiento') ?></th>
						<th><?php echo __('Email') ?></th>
					</thead>
								
					<tbody>
						<?php foreach ( $V->datasExport as $results ) {?>
															
							<tr>
								<td><?php echo $results->userid;?></td>
								<td><?php echo $results->name;?></td>
								<td><?php echo $results->lastname;?></td>
								<td><?php echo $results->actived;?></td>
								<td><?php echo $results->gender;?></td>
								<td><?php echo $results->nationality;?></td>
								<td><?php echo $results->city.','.$result->state;?></td>
								<td><?php echo $results->postal_code;?></td>
								<td><?php echo $results->street_name;?></td>
								<td><?php echo $results->street_number;?></td>
								<td><?php echo $results->floor_number;?></td>
								<td><?php echo $results->phone_numbers;?></td>
								<td><?php echo $results->name_dis;?></td>
								<td><?php echo $results->name_subdis;?></td>
								<td><?php echo $results->zona_conic;?></td>
								<td><?php echo $results->com_aser;?></td>
								<td><?php echo $results->title;?></td>
								<td><?php echo $results->title_tesis;?></td>
								<td><?php echo $results->topic_tesis;?></td>
								<td><?php echo $results->tesis_sub; ?></td>
								<td><?php echo $results->identity_number;?></td>
								
								<?php
									$date2 = explode("-",$results->birth_date);
								   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
								?>
												
								<td><?php echo $dateend;?></td>
								<td><?php echo $results->main_contact_mail;?></td>
								
							</tr>
																					 
						<?php } ?>
																						
				    </tbody>
								
			</table>	
				
<form action="wp-content/plugins/masvalor/app/ficheroexcel.php" method="post" target="_blank" id="FormularioExportacion" style="margin-left:-21px;">
		<p> <?php echo __('Exportar a Excel') ?> <img style="cursor:pointer;" src="wp-content/plugins/masvalor/app/includes/image/export_to_excel.gif" class="botonExcel" /></p>
		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>				

			
				
				
