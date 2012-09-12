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

function getSelectedLaborSector($data) {
	switch("1"){
		case $data->type_industry: $selected = 'type_industry'; break;
		case $data->type_services: $selected = 'type_services'; break;
		case $data->type_education: $selected = 'type_education'; break;
		case $data->type_go: $selected = 'type_go'; break;
		case $data->type_ngo: $selected = 'type_ngo'; break;
		case $data->type_selfemployment: $selected = 'type_selfemployment'; break;
	}
	return $selected;
}

function getSelectedLaborRelationships($data) {
	switch("1"){
		case $data->type_dependencyrelationship: $selected = 'type_dependencyrelationship'; break;
		case $data->type_contractlabor: $selected = 'type_contractlabor'; break;
		case $data->type_contractproject: $selected = 'type_contractproject'; break;
		case $data->type_contractconsulting: $selected = 'type_contractconsulting'; break;
		case $data->type_other: $selected = 'type_other'; break;
		
	}
	return $selected;
}

function getSelectedAvailabilityTimes($data) {
	switch("1"){
		case $data->required_fulltime: $selected = 'required_fulltime'; break;
		case $data->required_parttime: $selected = 'required_parttime'; break;
		case $data->required_ondemand: $selected = 'required_ondemand'; break;
	}
	return $selected;
}


global $current_user;
	get_currentuserinfo();

?>

<?php require_once ('models/masvalor_utils.php'); ?>
    
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/columnas.css" type="text/css" />

    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/estilos.css" type="text/css" />

    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/pestanas.js"></script>

    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">
	
	<link type="text/css" href="wp-content/plugins/masvalor/app/includes/css/slider/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> 
    
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/slider/jquery-ui-1.8.16.custom.min.js"></script>
          
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
      
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
    

<script>
function selected_as_hired(){

  alert('Juan Perez Ha Sido Contratado!');
}

</script>	

<script language="javascript" type="text/javascript">

function validateNumber($number) { var numberReg = /^([0-9])*$/; return numberReg.test( $number );}

jQuery(document).ready(function($){
	var actived = <?php if($V->data !=null) echo $V->data->actived; else echo 0;?>;
	if ( actived == 2 ) {
        jQuery("#tab_container input").attr('disabled', true);
		jQuery("#tab_container :input").attr('disabled', true);
		jQuery("a").attr('disabled', true);
		jQuery("a").attr('onclick', " ");
		jQuery("img").attr('disabled', true);
		jQuery("img").attr('onclick', " ");
		jQuery("#reopen").attr('disabled', false);
    } 
	jQuery("#type_laborsector").attr('disabled',true);
	jQuery("#required_availabilitytime").attr('disabled',true);
});


function validateFields(){
			retorno = false;
			var msg = new Array();
		    var error = false;

		  if (jQuery("#start_date").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una fecha de inicio.');?>");
		   error = true;
		   }
		   
		  if (jQuery("#end_date").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una fecha de fin.');?>");
		   error = true;
		   }
		  		  
		  if (jQuery("#job_title").val() == ""){
			msg.push('<?php echo __('Debe ingresar un puesto laboral.');?>');
			error = true;
		  }
		  
		  if (!validateNumber(jQuery("#months_duration").val())){
			msg.push('<?php echo __('Debe ingresar los meses de duraci&oacute;n (solo numeros).');?>');
			error = true;
		  }
		  
		  if (jQuery("#job_description").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un descripcion del puesto.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#company").val() == ""){
			msg.push('<?php echo __('Debe ingresar una empresa/instituci&oacute;n.');?>');
			error = true;
		  }
		  
		  if (jQuery("#type_company").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un tipo de empresa.');?>");
		   error = true;
		   }
		   
		  if (jQuery("#company_description").val() == ""){
			msg.push('<?php echo __('Debe ingresar una descripcion de empresa.');?>');
			error = true;
		  }
		  
		  	   
		   if (jQuery("#location_department").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un sector de empresa.');?>");
		   error = true;
		   }
		   
		   
		   if (jQuery("#remuneration_offered").val() == ""){
				 msg.push("<?php echo __('Debe ingresar el monto m&iacute;nimo ofrecido.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#workload").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un sector de empresa.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#profile_description").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una descripci&oacute;.');?>");
		   error = true;
		   }
		  
		   if (jQuery("#gender").val() == ""){
			msg.push('<?php echo __('Debe ingresar un g&eacute;nero.');?>');
			error = true;
		   }
		  
		   if (jQuery("#country").val() == ""){
			msg.push('<?php echo __('Debe ingresar un pa&iacute;s.');?>');
			error = true;
		  }
		  
		  if (jQuery("#state").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una provincia.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#city").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una localidad.');?>");
		   error = true;
		   }
		   
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
}

function selectAsHired(userid) {
	document.forms['adminForm'].task.value = 'selecthired';
	document.forms['adminForm'].hiredid.value = userid; 
	document.forms['adminForm'].submit(); 
}

function saveForm(){
    if (validateFields()){
		document.forms['adminForm'].task.value = 'save';
		document.forms['adminForm'].submit(); 
	}	
}

function acceptSearch(){
	document.forms['adminForm'].task.value = 'accept';
	document.forms['adminForm'].submit(); 
}

function closeSearch(){
	document.forms['adminForm'].task.value = 'close';
	document.forms['adminForm'].submit(); 
}

function reOpenSearch(){
	document.forms['adminForm'].task.value = 'reopen';
	document.forms['adminForm'].submit(); 
}

function transformInPostulant() {
	auxArray = jQuery('[name="companyapplicants[]"]:checked');
	if (auxArray.length >= 1){
		document.forms['adminForm'].task.value = 'transform';
		document.forms['adminForm'].submit(); 
	}
	else 
		alert('<?php echo __('Debe seleccionar al menos un postulante de la lista de postulantes de la Empresa/Instituci\u00f3n'); ?>');	
}

function refreshStates(){
	var data = {
	action: 'get_states',
	country: jQuery('#country').val(),
	comboid: 'state'
	}
	
	jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
	document.getElementById('stateContainer').innerHTML = response;
	refreshCities();
	});
	
}

function checkPermanent(){
	if ( jQuery('#permanent').is(':checked') )
		document.getElementById('months_duration').value = '0';
	else
		document.getElementById('months_duration').value = '';
}

function refreshCities(){
	var data = {
	action: 'get_cities',
	country: jQuery('#country').val(),
	state: jQuery('#state').val(),
	comboid: 'city'
	}
	
	jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
	document.getElementById('cityContainer').innerHTML = response;
	});
}

function deleteRow(anItem,userid,type) {
	var data = {
	action: 'remove_postulant',
	userid: userid,
	type: type,
	searchid: jQuery('#cid').val()
	}
	
	jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
		var child = anItem;
		var parent = child.parentElement;
		parent.removeChild(child);
	});

	
}

function saveApplicat(cid){
   document.forms['adminForm'].task.value = 'saveApplicat';
   document.forms['adminForm'].cid.value = cid;
   document.forms['adminForm'].submit(); 
   //alert("Se Ha Postulado Satisfactoriamente");
}

</script>  


<?php
function esSelected($estado,$comparacion){   
    if ($estado == $comparacion){
       return $estado. ' selected';
    }  
    else return $estado;  
}

function isChecked($estado){   
    if ($estado == "checked")
       return $estado =' checked';
      
    return $estado;  
}


?>
	
       <div style="float: right;margin-right: -43px;">
			<a href="javascript:history.back(1)">
				<img src="wp-content/themes/rollpix/images/headers/back.png">
			</a>
		</div>			

	
 <form class="adminForm" name="adminForm" action="" method="post">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
					<h2><?php echo __('B&uacute;squeda') ?> : <?php echo $V->data->job_title; ?></h2>
					<br/>
					
					<fieldset class="adminform" style="width: 100%;background-color: #ffffff;">
						
         				<table class="admintable" style="font-size:11px;margin-left:25px;">
																			
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
	
							<tr>
								<td class="key"><?php echo __('Puesto Laboral') ?></td>
								<td><?php echo $V->data->job_title; ?></td>
							</tr>
																				
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n del puesto') ?></td>
								<td><?php echo $V->data->job_description; ?></td>
							</tr>
																				
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Empresa/Instituci&oacute;n') ?></td>
								<td><?php echo $V->data->company; ?></td>
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>	
							
							<tr>
								<td class="key"><?php echo __('Tipo Empresa/Instituci&oacute;n') ?></td>
								<?php if($_GET['cid'] != null):?>
									<td><?php echo $V->combos->getLaborSectors('type_',getSelectedLaborSector($V->data),'type_laborsector')?></td>
								<?php else: ?>		
									<td><?php echo $V->combos->getLaborSectors('type_',getSelectedLaborSector($V->dataCompany),'type_laborsector')?></td>
								<?php endif;?>	
							
							</tr>
																				
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n de la empresa') ?></td>
								<td><?php echo $V->data->company_description;?></td>
							   
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Ubicaci&oacute;n o Dependencia') ?></td>
								<td><?php echo $V->data->location_department; ?></td>
							</tr>
																														
						
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Meses de duraci&oacute;n') ?></td>
								<td>
									<?php if($V->data->months_duration == 0) {?>
										   <?php echo __('Permanente') ?>
									<?php }else{?>   
										 <?php echo $V->data->months_duration; ?>
									<?php }?>
								</td>	
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Carga horaria requerida') ?></td>
								<td><?php echo $V->combos->getAvailabilityTimes('required_',getSelectedAvailabilityTimes($V->data),'required_availabilitytime');?></td>
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
												    
							<tr>
								<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n del perfil') ?></td>
								<td><?php echo $V->data->profile_description; ?></td>
							</tr>
													
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Experiencia Laboral Requerida') ?></td>
								<td><?php echo $V->data->experience; ?></td>
							</tr>
																				
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('G&eacute;nero') ?></td>
								<td><?php echo $V->data->gender; ?></td>
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Edad Desde') ?></td>
								<td><?php echo $V->data->age_from; ?></td>
							</tr>
													
													
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Edad Hasta') ?></td>
								<td><?php echo $V->data->age_to; ?></td>
							</tr>
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>    
								<td class="key" style="float:left; margin-top: 5px;"><?php echo __('Requiere disponibilidad para viajar') ?></td>
								<td><input name="willingness_to_travel" readonly="readonly" id="willingness_to_travel" type="checkbox" <?php echo isChecked($V->data->willingness_to_travel); ?> value="<?php echo $V->data->willingness_to_travel; ?>"></td>
							</tr>
													
													
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Pa&iacute;s') ?></td>
								<td><?php echo $V->data->country; ?></td>
																
							</tr>
							
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Estado/Provincia') ?></td>
								<td><?php echo $V->data->state; ?></td>
							</tr>	
							
							<tr>
								<td><div style="margin-top:20px"/></td>
							</tr>
							
							<tr>
								<?php if ($current_user->ID != null){
								       if(checkUserType($current_user->user_login,'doctor')){?>
									<?php if($V->can_post_and_mails) { ?>
									
										<?php if ($V->isApplicat == false) { ?>
									
											<td>
												<div style="float:left;padding-bottom: 20px;padding-top: 20px;">	
													<input type="button"  onclick="saveApplicat('<?php echo $V->data->id;?>')" value="<?php echo __('Postularme') ?>" />
												</div>	
											</td>
											
										<?php 
									       	} else {
												echo '<td><div style="float:left;padding-bottom: 20px;padding-top: 20px; color:red; font-weight: bold;">Su postulación fue registrada exitosamente.</div></td>';
											} 
										?>
										
									<?php 
								       } else { 
								       		echo '<td><div style="float:left;padding-bottom: 20px;padding-top: 20px;">Su cuenta no se encuentra activada como doctor, no puede postularse a esta busqueda.</div></td>'; 
								       } ?>			
									<?php }?>
								<?php }else{?>
																	
									<td class="key"></td>
									<td>
										<div style="float:left;padding-bottom: 20px;padding-top: 20px;">
											<strong><?php echo __('Debe registrase para poder postularse a la b&uacute;squeda') ?></strong>
										</div>
									</td>
									
								<?php }?>
							</tr>	
							
						</table>
					
					</fieldset>
				
				</td>
			</tr>
		</tbody>
	</table>	
    <input type="hidden" name="cid" id="cid" value="<?php echo $V->data->id;?>" />
	<input type="hidden" name="task" id="task" value="" />	
</form>
 
