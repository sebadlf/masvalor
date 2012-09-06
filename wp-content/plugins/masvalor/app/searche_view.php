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


?>

<?php require_once ('models/masvalor_utils.php'); ?>
    
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/columnas.css" type="text/css" />

    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/estilos.css" type="text/css" />

    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/pestanas.js"></script>

    <!--
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
		 
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">
	
	<link type="text/css" href="wp-content/plugins/masvalor/app/includes/css/slider/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> 
    
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/slider/jquery-ui-1.8.16.custom.min.js"></script>
          
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
      
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
    
<style>

#tableSelectedEducation thead{
  background-color: #eee;
}

#tableSelectedEducation tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedEducationPos thead{
  background-color: #eee;
}

#tableSelectedEducationPos tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedTesis thead{
  background-color: #adaeb2;
}

#tableSelectedTesis tbody{
   border-right: 1px solid;
   height:100%;
}


#tableSelectedExperiencia thead{
  background-color: #adaeb2;
}
   
#tableSelectedExperiencia tbody{
   border-right: 1px solid;
   height:100%;
}
   
.floatLeft{
  float:left;
}

.campo{
  width:235px;
}

.ClaseColumna{
  width:100%;
}

.documentBox{
	border:4px solid black;
	width:350px;
	float:left;
	margin:25px;
	
}
.titleDocuments{
	width:100%;
	height:15px;
	padding:6px 0;
	color:black;
	display:block;
	font-weight:bold;
	text-align: center;
	
}

.key{
  width: 175px;
}

.active a{
  color:black;
}
</style>

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
	
	var tab = '<?php echo $_GET['showResult']; ?>';
	if (tab == '1')
		jQuery("[name='tab2']").click();
});

function removeThis(anItem) {
  if(confirm("\u00BFEst\u00e1 seguro que quiere guardar los cambios?")) { 
	var child = document.getElementById(anItem);
	var parent = child.parentElement;
	parent.removeChild(child);
	need_update = 1;
  }
}

function show_popup_diciplines() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_disciplines.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="200" width="630" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:200,
		padding:0,
		width:630
	},
	overlayClose:true,
	onClose: function(dialog){
	  var self = this;          
	  self.close();
	  
	}/*,
	onOpen: function (dialog) {
		  dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
			  dialog.data.slideDown('slow');
			});
		  });
	}*/
	});
}

function addDiscipline(discipline,subdiscipline,subdisciplineid,ppal){ 
		var id = (subdiscipline).split(' ').join('');
		id = id.toLowerCase();
		if ( document.getElementById(subdiscipline) == null){
  			newElem2 = "<tr id='"+id+"' >";


  			newElem2 += "<td>"+discipline+"</td>"; 
			newElem2 += "<td>"+subdiscipline+"</td>"; 
			newElem2 += '<td><input ';
			if(ppal == 1) {
				newElem2 += 'checked';
			}
			newElem2 += ' type="radio" name="ppal_disc" value="'+subdisciplineid+'"/></td>'; 
			newElem2 += '<td></td>'; 
			newElem2 += "<input type='hidden'  name='disciplines[]' value='"+subdisciplineid+"' />";
  			newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
  			newElem2 += "</tr>";
  			jQuery("#tableSelectedDisciplines").append(newElem2);
			need_update = 1;
  			return true;
  		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}

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
			msg.push('<?php echo __('Debe ingresar los meses de duraci\u00f3n (solo n\u00fameros).');?>');
			error = true;
		  }
		  
		  if (jQuery("#job_description").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un descripci\u00f3n del puesto.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#company").val() == ""){
			msg.push('<?php echo __('Debe ingresar una empresa/instituci\u00f3n.');?>');
			error = true;
		  }
		  
		  if (jQuery("#type_company").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un tipo de empresa.');?>");
		   error = true;
		   }
		   
		  if (jQuery("#company_description").val() == ""){
			msg.push('<?php echo __('Debe ingresar una descripci\u00f3n de empresa.');?>');
			error = true;
		  }
		  
		  	   
		   if (jQuery("#location_department").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un sector de empresa.');?>");
		   error = true;
		   }
		   
		   
		   if (jQuery("#remuneration_offered").val() == ""){
				 msg.push("<?php echo __('Debe ingresar la remuneraci\u00f3n m\u00ednima ofrecida.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#workload").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un sector de empresa.');?>");
		   error = true;
		   }
		   
		   if (jQuery("#profile_description").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una descripci\u00f3n.');?>");
		   error = true;
		   }
		  
		   if (jQuery("#gender").val() == ""){
			msg.push('<?php echo __('Debe ingresar un g\u00e9nero.');?>');
			error = true;
		   }
		  
		   if (jQuery("#country").val() == ""){
			msg.push('<?php echo __('Debe ingresar un pa\u00eds.');?>');
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
		   
		if ($("input[name=ppal_disc]:checked").size() != 1) {
			msg.push("<?php echo __('Debe elegir una disciplina principal.');?>");
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
	    if(confirm("\u00BFEst\u00e1 seguro que quiere guardar los cambios?")) { 
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit(); 
		}
	}	
}

function acceptSearch(){
	document.forms['adminForm'].task.value = 'accept';
	document.forms['adminForm'].submit(); 
}

function notificationDoctors(){
	document.forms['adminForm'].task.value = 'notificationDoctors';
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
	
<div id="table_noticia" style="font-size: 14px;margin-left: -27px;width: 691px;">
	
 <form id="adminForm" class="adminForm" name="adminForm" action="" method="post">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
					<h2><?php echo __('Edici&oacute;n de B&uacute;squeda') ?></h2>
					<br/>
					<fieldset class="adminform" style="width: 100%;background-color: #ffffff;">
						
         
             
						  <ul class="tabs">
							<li><a name="tab1" href="#tab1"><?php echo __('B&uacute;squeda') ?></a></li>                
							<li><a name="tab2" href="#tab2"><?php echo __('Resultado') ?></a></li>
						  </ul>
              
							<div class="tab_container2" id="tab_container">  
              
			  
							  <!--Pestana1-->
								<div id="tab1" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
											<div class="Columna" id="Columna1">
										     
											 <div id="Cont3">
												<table class="admintable" style="font-size:11px">
													
													
													<h2 style="text-align:left; font-size:17px;;margin-bottom:30px">
													   <br/>
													   <?php echo __('Datos de la B&uacute;squeda') ?> 
													   <?php if ($V->data->id != null && $V->data->id != '') {?>
														   <?php //if($V->data->actived == 1) { ?>
														   <div style="float: right; margin-right: 9px;margin-top: 2px;">
																<a href="<?php echo masvalor_getUrl().'/form_consultation/&searchid='.$V->data->id; ?>" target="_blank" title="<?php echo __('Realizar Consulta') ?>"> <img src="wp-content/plugins/masvalor/app/includes/image/search.png"></a> 
														  </div>
														<?php //}?>
													  <?php }?>
													</h2>		
													
													
													<tr>
														<td class="key">ID</td>
														<td><?php echo  $V->data->id;?></td>
													</tr>
													
													
													<tr>
														<td class="key"><?php echo __('Fecha Inicio') ?>(*)</td>
														<td><input class="tcal" type="text" name="start_date" id="start_date" value="<?php echo $V->data->start_date; ?>" />
														(dd-mm-aaaa)
														</td>
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Fecha Fin') ?>(*)</td>
														<td><input class="tcal" type="text" name="end_date" id="end_date" value="<?php echo $V->data->end_date; ?>"  />
														(dd-mm-aaaa)
														</td>
													</tr>
																											
													<tr>
														<td class="key"><?php echo __('Puesto Laboral') ?>(*)</td>
														<td><input class="text_area" type="text" name="job_title"  size="50" id="job_title" value="<?php echo $V->data->job_title; ?>" /></td>
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n del puesto') ?>(*)</td>
														<td><textarea class="text_area" rows="4" cols="100" name="job_description" id="job_description"  size="50" maxlength="3000" style="height: 109px;width: 424px;"><?php echo $V->data->job_description; ?></textarea></td>
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Empresa/Instituci&oacute;n') ?>(*)</td>
														<?php if($_GET['cid'] != null):?>
															<td><input class="text_area" type="text" name="company"  size="50" id="company" value="<?php echo $V->data->company; ?>" /></td>
													    <?php else: ?>
														    <td><input class="text_area" type="text" name="company"  size="50" id="company" value="<?php echo $V->dataCompany->name; ?>" /></td> 
														<?php endif;?>
														
													</tr>
																									
													
													<tr>
														<td class="key"><?php echo __('Tipo Empresa/Instituci&oacute;n') ?>(*)</td>
														<?php if($_GET['cid'] != null):?>
															<td><?php echo $V->combos->getLaborSectors('type_',getSelectedLaborSector($V->data),'type_laborsector')?></td>
														<?php else: ?>
															<td><?php echo $V->combos->getLaborSectors('type_',getSelectedLaborSector($V->dataCompany),'type_laborsector')?></td>
														<?php endif;?>	
													
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n de la empresa') ?>(*)</td>
														<?php if($_GET['cid'] != null):?>
															<td><textarea class="text_area" rows="4" cols="100" name="company_description" id="company_description"  size="50" maxlength="1000" style="height: 109px;width: 424px;"><?php echo $V->data->company_description;?></textarea></td>
													    <?php else: ?>
														    <td><textarea class="text_area" rows="4" cols="100" name="company_description" id="company_description"  size="50" maxlength="1000" style="height: 109px;width: 424px;"><?php echo $V->dataCompany->description;?></textarea></td>
														<?php endif;?>
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Ubicaci&oacute;n o Dependencia') ?>(*)</td>
														<td><input class="text_area" type="text" name="location_department"  size="50" id="location_department" value="<?php echo $V->data->location_department; ?>" /></td>
													</tr>
															
													
													<tr>
														<td class="key"><?php echo __('Relaci&oacute;n Laboral Ofrecida') ?>(*)</td>
														<td><?php echo $V->combos->getLaborRelationships('type_',getSelectedLaborRelationships($V->data),'type_laborrelationships')?></td>
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Remuneraci&oacute;n Mensual Bruta') ?>(*) $</td>
														<td><input class="text_area" type="text" name="remuneration_offered"  size="20" id="remuneration_offered" value="<?php echo $V->data->remuneration_offered; ?>" />
														<?php echo __('Esta informaci&oacute;n no se mostrar&aacute; en las b&uacute;squedas.') ?>
														</td>
													</tr>	
													
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Otros Beneficios') ?></td>
														<td><textarea class="text_area" rows="4" cols="100" name="other_benefits" id="other_benefits"  size="50" maxlength="150" style="height: 109px;width: 424px;"><?php echo $V->data->other_benefits; ?></textarea></td>
													</tr>
													
																						
												</table>	
												<table class="admintable" style="font-size:11px"> 
													<tr>
														<td class="key"><?php echo __('Meses de duraci&oacute;n') ?></td>
														<td>
															<input class="text_area" type="text" name="months_duration"  size="5" id="months_duration" value="<?php echo $V->data->months_duration; ?>" />
															<td><INPUT NAME="permanent"  id="permanent" type="checkbox" value="" onchange="checkPermanent()" <?php if($V->data->months_duration == 0) echo " checked" ?>></td>
															<td class="key" style="float:left; margin-top: 5px;"><?php echo __('Permanente') ?></td>	
														</td>	
													</tr>
													
													
														<tr>
															<td class="key"><?php echo __('Carga horaria requerida') ?>(*)</td>
															<td><?php echo $V->combos->getAvailabilityTimes('required_',getSelectedAvailabilityTimes($V->data),'required_availabilitytime');?></td>
														</tr>
												</table>
													
													
												<table class="admintable" style="font-size:11px">
													
												
												 <hr style="margin-top:30px; margin-bottom:22px;"/>	
												
													
													<h2 style="text-align:left;font-size:17px;;margin-bottom:30px">
													   <?php echo __('Datos del Perfil') ?>
													</h2>
												    
												    
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Descripci&oacute;n del perfil') ?>(*)</td>
														<td><textarea class="text_area" rows="4" cols="100" name="profile_description" id="profile_description"  size="50" maxlength="3000" style="height: 109px;width: 424px;"><?php echo $V->data->profile_description; ?></textarea></td>
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Experiencia Laboral Requerida') ?></td>
														<td><textarea class="text_area" rows="4" cols="100" name="experience" id="experience"  size="50" maxlength="3000" style="height: 109px;width: 424px;"><?php echo $V->data->experience; ?></textarea></td>
													</tr>
													
													
													<tr>
														<td class="key"><?php echo __('G&eacute;nero') ?>(*)</td>
														<td><?php echo $V->combos->getGenders(true,$V->data->gender,'gender')?></td>
													</tr>
												    
													<tr>
														<td class="key"><?php echo __('Edad Desde') ?></td>
														<td><input class="text_area" type="text" name="age_from"  size="11" id="age_from" value="<?php echo $V->data->age_from; ?>"/></td>
																						
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Edad Hasta') ?></td>
														<td><input class="text_area" type="text" name="age_to"  size="11" id="age_to" value="<?php echo $V->data->age_to; ?>" />												</td>
																						
													</tr>
													
													<tr>    
														<td class="key" style="float:left; margin-top: 5px;"><?php echo __('Requiere disponibilidad para viajar') ?></td>
														<td><input name="willingness_to_travel" id="willingness_to_travel" type="checkbox" <?php echo isChecked($V->data->willingness_to_travel); ?> value="<?php echo $V->data->willingness_to_travel; ?>"></td>
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Pa&iacute;s') ?>(*)</td>
														<td><?php echo $V->combos->getCountries($V->data->country,'country') ?></td>
														<!--td><input class="text_area" type="text" name="country"  size="50" id="country" value="<?php echo $V->data->country; ?>" /></td-->
																						
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Estado/Provincia') ?>(*)</td>
														<td id="stateContainer" ><?php echo $V->combos->getStates($V->data->state,$V->data->country,'state') ?></td>
														<!--td><input class="text_area" type="text" name="state"  size="50" id="state" value="<?php echo $V->data->state; ?>" /></td-->
													</tr>	
													
													<tr>
														<td class="key"><?php echo __('Ciudad') ?>(*)</td>
														<td id="cityContainer"><?php echo $V->combos->getCities($V->data->city,$V->data->country,$V->data->state,'city') ?></td>
														<!--td><input class="text_area" type="text" name="city"  size="50" id="city" value="<?php echo $V->data->city; ?>" /></td-->
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Subdisciplinas Requeridas') ?></td>
														<td><input id="addDiscipline" onclick="show_popup_diciplines()" type="button"  value ="Agregar" /></td>
													</tr>
													
													<tr><td colspan="2">
																<table id="tableSelectedDisciplines" class="admintable" style="font-size:10px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>


																	<th><?php echo __('Disciplina'); ?></th>
																	<th><?php echo __('Subdisciplina'); ?></th>
																	<th><?php echo __('Principal'); ?></th>
																	<th class="deleteDiv"></th>
																  </thead>
																  <?php 
																  if ($V->disciplines != '' && $V->disciplines != null) {
																	foreach ($V->disciplines as $discipline):
																		?>
																		<script>
																			addDiscipline('<?php echo $discipline->discipline_name ?>','<?php echo $discipline->subdiscipline_name ?>','<?php echo $discipline->subdisciplineid ?>',<?php echo $discipline->ppal ?>);
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody>

																  </tbody>
															  </table></td>
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('T&iacute;tulo de Grado Requerido') ?></td>
														<td><textarea class="text_area" rows="4" cols="100" name="degree_title" id="degree_title"  size="50" maxlength="150" style="height: 109px;width: 424px;"><?php echo $V->data->degree_title;?></textarea></td>
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('T&iacute;tulo de Postgrado Requerido') ?></td>
														<td><textarea class="text_area" rows="4" cols="100" name="graduate_degree" id="graduate_degree"  size="50" maxlength="150" style="height: 109px;width: 424px;" ><?php echo $V->data->graduate_degree;?></textarea></td>
													</tr>
													
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;"><?php echo __('Competencias y Habilidades') ?></td>
														<td><textarea class="text_area" rows="4" cols="100" name="competencies_skills" id="competencies_skills"  size="50" maxlength="150" style="height: 109px;width: 424px;"><?php echo $V->data->competencies_skills; ?></textarea></td>
													</tr>
													
													<tr <?php if ($V->data->actived == 2) echo 'style="display:none"' ?>>
													   <td>
															<div style="float:left;padding-bottom: 20px;padding-top: 20px;">	
																<input id="save" name="save" type="button" onclick="saveForm();" value="<?php echo __('Publicar B&uacute;squeda') ?>" />
															</div>	
														</td>
													</tr>	
												
												</table>
												
											  </div>
										   </div>
										</div>
										
										</div>     
									</div>
								</div>
									
								<!------------------------------------------------------------------------>
								<!--Pestana2-->
								<div id="tab2" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
											<div class="Columna" id="Columna1">
										
											  <div id="Cont3">
												<table class="admintable" style="font-size:11px;">
														
													<table  style="font-size:11px;">
															<tr>
																<td class="key"><?php echo __('Estado') ?></td>
																<td>
																<?php if ($V->data->actived == 1) 
																	echo __('Aceptada');
																else
																	if ($V->data->actived == 2)
																		echo __('Cerrada'); 
																	else
																		echo __('Pendiente de aceptaci&oacute;n');  
																?>
																</td>	
																<?php if ($V->complete && $V->data->actived == 0 ) {?>
																<td><input type="button" value="<?php echo __('Aceptar B&uacute;squeda'); ?>" onclick="acceptSearch()" /></td>	
																<td><input type="button" value="<?php echo __('Notificar'); ?>" onclick="notificationDoctors()" /></td>
																<?php } ?>
																<?php if ($V->data->actived != 2 ) {?>
																<td><input type="button" value="<?php echo __('Cerrar B&uacute;squeda'); ?>" onclick="closeSearch()" /></td>	
																<?php } ?>
																<?php if ($V->complete && $V->data->status == 'Insatisfecha' ) {?>
																<td><input type="button" id="reopen" value="<?php echo __('Reabrir B&uacute;squeda'); ?>" onclick="reOpenSearch()" /></td>	
																<?php } ?>
															
																	
															
															</tr>
															
															<tr>
																<td class="key"><?php echo __('Situaci&oacute;n') ?></td>
																<td><?php echo $V->data->status ?></td>	
															</tr>
															
															<?php	$date2 = explode("-",$V->data->last_status_date);
																	$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];  ?>
																		
															
															<tr>
																<td class="key"><?php echo __('Fecha &Uacute;ltima situaci&oacute;n') ?></td>
																<td><?php echo $dateend ?></td>	
															</tr>	
															
												 </table>
												
											
												 <table class="admintable" style="font-size:11px;">
														<tr>
															<td>
																<hr style="margin-top:30px; margin-bottom:30px;"/>	
															</td>
														</tr>										
													
													
														<tr>
															<td>
																  <legend><?php echo __('Candidatos de la Empresa/Instituci&oacute;n') ?></legend>
																	<!--div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="selected_as_hired()" type="button"  value ="Seleccionar como Contratado" />
																	</div-->
																	<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width: 603px;text-align:center;margin-bottom: 27px;">
																	  <hr/>
																	  <thead>
																		<?php if ($V->complete) {?>
																			<th><!--input type="checkbox" name="checkall" onclick="checkall()" --></th>
																		<?php } ?>
																		<th><?php echo __('Nombre') ?></th>
																		<th><?php echo __('Apellido') ?></th>
																		<th><?php echo __('Edad') ?></th>
																		<th><?php echo __('G&eacute;nero') ?></th>
																		<th><?php echo __('Fecha Postulaci&oacute;n') ?></th>
																		<th><?php echo __('Perfil') ?></th>
																		<th></th>
																		<th></th>
																	  </thead>
																	  
																	  <tbody>
																		
																			 <?php foreach ($V->postulates as $postulate): ?>
																			<tr>
																				<?php if ($V->complete) {?>
																					<td><input type="checkbox" name="companyapplicants[]" value="<?php echo $postulate->userid?>" ></td>
																				<?php } ?>
																				<td><?php echo $postulate->name?></td>
																				<td><?php echo $postulate->lastname?></td>
																				<td><?php echo $postulate->age?></td>
																				<td><?php echo $postulate->gender?></td>
																				<td><?php echo $postulate->date?></td>
																				<td><a href="<?php echo masvalor_getUrl().'/doctor-profile/&cid='.$postulate->userid ?>">Ver</a></td>
																				<td  style="cursor:pointer" onclick="deleteRow(this.parentElement,'<?php echo $postulate->userid?>',1)">X</td>
																			</tr>
																	  <?php endforeach; ?>
																			
																 	  </tbody>
																    </table>
															</td>
														</tr>	
														<?php if ($V->complete) {?>
														<tr>
															<td><input  style="margin-bottom: 27px;" type="button" onclick="transformInPostulant()" value="<?php echo __('Transformar en Candidatos a la B&uacute;squeda'); ?>" ></td>
															<td></td>
														</tr>
														<?php } ?>
													
														<tr>
															<td>
																  <legend><?php echo __('Candidatos a la B&uacute;squeda') ?></legend>
																	<!--div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="selected_as_hired()" type="button"  value ="Seleccionar como Contratado" />
																	</div -->
																	<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width: 603px;text-align:center;margin-bottom: 27px;">
																	  <hr/>
																	  <thead>
																		<th><?php echo __('Nombre') ?></th>
																		<th><?php echo __('Apellido') ?></th>
																		<th><?php echo __('Edad') ?></th>
																		<th><?php echo __('G&eacute;nero') ?></th>
																		<th><?php echo __('Fecha Postulaci&oacute;n') ?></th>
																		<th><?php echo __('Perfil') ?></th>
																		<th><?php echo __('CV') ?></th>
																		<th></th>
																		<th></th>
																	 </thead>
																	  
																	  <tbody>
																	  <?php foreach ($V->candidates as $candidate): ?>
																			<tr>
																				<td><?php echo $candidate->name?></td>
																				<td><?php echo $candidate->lastname?></td>
																				<td><?php echo $candidate->age?></td>
																				<td><?php echo $candidate->gender?></td>
																				<td><?php echo $candidate->date?></td>
																				<td><a href="<?php echo masvalor_getUrl().'/doctor-profile/&cid='.$candidate->userid ?>">Ver</a></td>
																				<td><a href="<?php echo home_url().'/wp-content/uploads/profiles/'.$candidate->userid.'/'.$candidate->cv ?>">Ver</a></td>
																				<td><a title="<?php echo __('Seleccionar Profesional') ?>" href="#" onclick="selectAsHired('<?php echo $candidate->userid ?>')"><img src="wp-content/plugins/masvalor/app/includes/image/accept.png" height="13" width="13" /></a></td>
																				<td  style="cursor:pointer" onclick="deleteRow(this.parentElement,'<?php echo $candidate->userid?>',0)">X</td>
																			</tr>
																	  <?php endforeach; ?>
																				
																			
																		
																	  </tbody>
																  </table>
															</td>
														</tr>	
													   
													    <tr>
															<td>
																  <legend><?php echo __('Postulantes a la B&uacute;squeda') ?></legend>
																	<!--div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="selected_as_hired()" type="button"  value ="Seleccionar como Contratado" />
																	</div -->
																	<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width: 603px;text-align:center;margin-bottom: 27px;">
																	  <hr/>
																	  <thead>
																		<th><?php echo __('Nombre') ?></th>
																		<th><?php echo __('Apellido') ?></th>
																		<th><?php echo __('Edad') ?></th>
																		<th><?php echo __('G&eacute;nero') ?></th>
																		<th><?php echo __('Fecha Postulaci&oacute;n') ?></th>
																		<th><?php echo __('Perfil') ?></th>
																		<th><?php echo __('CV') ?></th>
																		<th></th>
																		<th></th>
																	  </thead>
																	  
																	  <tbody>
																		
																			 <?php foreach ($V->applicants as $applicant): ?>
																			<tr>
																				<td><?php echo $applicant->name?></td>
																				<td><?php echo $applicant->lastname?></td>
																				<td><?php echo $applicant->age?></td>
																				<td><?php echo $applicant->gender?></td>
																				<td><?php echo $applicant->date?></td>
																				<td><a href="<?php echo masvalor_getUrl().'/doctor-profile/&cid='.$applicant->userid ?>">Ver</a></td>
																				<td><a href="<?php echo home_url().'/wp-content/uploads/profiles/'.$applicant->userid.'/'.$applicant->cv ?>">Ver</a></td>
																				<td><a title="<?php echo __('Seleccionar Profesional') ?>" href="#" onclick="selectAsHired('<?php echo $applicant->userid ?>')"><img src="wp-content/plugins/masvalor/app/includes/image/accept.png" height="13" width="13" /></a></td>
																				<td  style="cursor:pointer" onclick="deleteRow(this.parentElement,'<?php echo $applicant->userid?>',2)">X</td>
																			</tr>
																	  <?php endforeach; ?>
																			
																 	  </tbody>
																    </table>
															</td>
														</tr>	
													   
														<tr>
															<td>
																<hr style=" margin-bottom: 25px;margin-top: 50px;"/>	
															</td>
														</tr>
													
														<tr>                                    	
															<td style="padding-top:20px;"><h2><?php echo __('Profesional Contratado: '); if ($V->hiredData != null) echo '<a href="'.masvalor_getUrl().'/doctor-profile/&cid='.$V->hiredData->userid.'">'.$V->hiredData->lastname.', '.$V->hiredData->name.'</a>' ; else echo __('Todav&iacute;a no ha seleccionado ning&uacute;n profesional') ?></h2></td>
														</tr>
													
												  </table>
												  
												
											  </div>
										   </div>
										</div>
										
									  </div>     
									</div>
								</div>
															
																				 
								 <!------------------------------------------------------------------------>
								
							</div> <!--pestanas-->
							  
					
					</fieldset>
				
				</td>
			</tr>
		</tbody>
	</table>	
    <input type="hidden" name="cid" id="cid" value="<?php echo $V->data->id;?>" />
	<input type="hidden" name="userid"  id="userid" value="<?php echo $V->current_user->ID; ?>"/>
	<input type="hidden" name="hiredid" id="hiredid" value="<?php echo $V->data->selected_profile;?>" />
	<input type="hidden" name="task" id="task" value="" />
</form>
 
</div> 