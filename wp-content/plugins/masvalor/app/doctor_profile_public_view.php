	<link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/columnas.css" type="text/css" />

    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/estilos.css" type="text/css" />

    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/pestanas_validate.js"></script>

    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">
	
	<link type="text/css" href="wp-content/plugins/masvalor/app/includes/css/slider/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> 
    
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/slider/jquery-ui-1.8.16.custom.min.js"></script>
          
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
    

<style>
fieldset.adminform {
    border: 1px solid #eee;
}

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
  background-color: #eee;
}

#tableSelectedTesis tbody{
   border-right: 1px solid;
   height:100%;
}


#tableSelectedExperiencia thead{
  background-color: #eee;
}
   
#tableSelectedExperiencia tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedDisciplines thead{
  background-color: #eee;
}
   
#tableSelectedDisciplines tbody{
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

#tableSelectedLanguage thead{
  background-color: #eee;
}


a{
 text-decoration: none;
 color:black;
}

.deleteDiv {
	width:10px;
}

th.deleteDiv {
	width:10px;
	background-color: #fff;
}
</style>
	


	
 

<script language="JavaScript">


jQuery(document).ready(function($){

	jQuery('.competence-checkbox').change(function(){
		setNeedUpdate();
	});
	
	jQuery('.laborsector-checkbox').change(function(){
		setNeedUpdate();
	});
	
	jQuery('.laborrelationship-checkbox').change(function(){
		setNeedUpdate();
	});
	
	jQuery('.availabilitytime-checkbox').change(function(){
		setNeedUpdate();
	});
	
	var tab = '<?php echo $V->step ?>';
	if (tab == 'step2')
		jQuery("[name='tab2']").click();
	if (tab == 'step3')
		jQuery("[name='tab3']").click();
	
	var isCompany = <?php if($V->isCompany) echo 1; else echo 0; ?>;
	if ( isCompany == 1 ) {
        jQuery("#tab_container input").attr('disabled', true);
		jQuery("#tab_container :input").attr('disabled', true);
		jQuery("a").attr('disabled', true);
		jQuery("a").attr('onclick', " ");
		jQuery("td").attr('onclick', " ");
		jQuery("img").attr('disabled', true);
		jQuery("img").attr('onclick', " ");
    } 
	
});

var need_update = 0;

function setNeedUpdate(){
	need_update = 1;
}

function removeThis(anItem) {
	var child = document.getElementById(anItem);
	var parent = child.parentElement;
	parent.removeChild(child);
	need_update = 1;
}

var activeModal = null;

 function show_popup_education() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_education.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="300" width="600" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:304,
		padding:0,
		width:600,
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

function show_popup_education_post() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_education_pos.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="300" width="600" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:304,
		padding:0,
		width:600,
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


function show_popup_tesis_postgrado() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_tesis_postgrado.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="300" width="500" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:304,
		padding:0,
		width:500,
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




function show_popup_experiencia_laboral() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_experiencia_laboral.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="300" width="500" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:304,
		padding:0,
		width:500,
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


function show_popup_diciplines() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_disciplines.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="200" width="500" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:204,
		padding:0,
		width:500,
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

function addDiscipline(branch,discipline,disciplineid){
		var fields = disciplineid;
		var id = (disciplineid+discipline).split(' ').join('');
		if ( document.getElementById(id) == null){
  			  			  	  
  			newElem2 = "<tr id='"+id+"' >";
  			newElem2 += "<td>"+branch+"</td>";
  			newElem2 += "<td>"+discipline+"</td>"; 
			newElem2 += "<td></td>"; 
  			newElem2 += "<input type='hidden' name='disciplines[]' value='"+fields+"' />";
  			//newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
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

function addEducation(title,university,from,to,universityid,stateValue){
		var fields = title.trim() + '{*}' + universityid + '{*}' + from + '{*}' + to + '{*}' + stateValue;
		if (stateValue == 1)
			state='<?php echo __('Completo') ?>';
		else
			state='<?php echo __('Incompleto') ?>';
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
  			  			  	  
  			newElem2 = "<tr id='"+id+"' >";
  			newElem2 += "<td>"+title.trim()+"</td>";
  			newElem2 += "<td>"+university+"</td>"; 
  			newElem2 += "<td>"+from+"</td>";
			newElem2 += "<td>"+to+"</td>";
			newElem2 += "<td>"+state+"</td>";
  			newElem2 += "<input type='hidden'  name='titles[]' value='"+fields+"' />";
  			
  			newElem2 += "</tr>";
  			jQuery("#tableSelectedEducation").append(newElem2);
			need_update = 1;
  			return true;
  			
  		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}

function addEducationPos(title,university,from,to,universityid,stateValue){
		var fields = title.trim() + '{*}' + universityid + '{*}' + from + '{*}' + to + '{*}' + stateValue;
		var state;
		if (stateValue == 1)
			state='<?php echo __('Completo') ?>';
		else
			state='<?php echo __('Incompleto') ?>';
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
  			  			  	  
  			newElem2 = "<tr id='"+id+"' >";
  			newElem2 += "<td>"+title.trim()+"</td>";
  			newElem2 += "<td>"+university+"</td>"; 
  			newElem2 += "<td>"+from+"</td>";
			newElem2 += "<td>"+to+"</td>";
			newElem2 += "<td>"+state+"</td>";
  			newElem2 += "<input type='hidden' name='titlesPos[]' value='"+fields+"' />";
  			
  			newElem2 += "</tr>";
  			jQuery("#tableSelectedEducationPos").append(newElem2);
			need_update = 1;
  			return true;
  			
  		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}

function addTesis(title,theme,publication_date,file,fileName,link){
		var fields = title.trim() + '{*}' + theme + '{*}' + publication_date + '{*}' + fileName;
		var newFileInput = document.createElement("input"); 
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
			if (file != null){
				newFileInput = file;}
			else{
				newFileInput.type = 'file';}
			newElem2 = "<tr id='"+id+"' >";
			if (link != null)
				newElem2 += "<td><a target='_blanc' href='"+link+"'>"+title.trim()+"</a></td>";
			else
				newElem2 += "<td>"+title.trim()+"</td>";
			newElem2 += "<td>"+theme+"</td>"; 
			newElem2 += "<td>"+publication_date+"</td>"; 
			newElem2 += "<input type='hidden' name='tesis[]' value='"+fields+"' />";
			//newElem2 += "<td class='deleteDiv'  onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
			newElem2 += "</tr>";
			jQuery("#tableSelectedTesis").append(newElem2);
			newFileInput.style.display = "none";
			newFileInput.name = 'tesisfiles[]';
			document.getElementById(title.split(' ').join('')).appendChild(newFileInput);
			need_update = 1;
			return true;
		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}

function addExperience(company,jobTitle,area,fromDate,toDate){
		var fields = company + '{*}' + jobTitle + '{*}' + area + '{*}' + fromDate + '{*}' + toDate;
		var id = (company+jobTitle).split(' ').join('');
		if ( document.getElementById(id) == null){
			newElem2 = "<tr id='"+id+"' >";
			newElem2 += "<td>"+company+"</td>";
			newElem2 += "<td>"+jobTitle+"</td>"; 
			newElem2 += "<td>"+area+"</td>"; 
			newElem2 += "<td>"+fromDate+"</td>"; 
			newElem2 += "<td>"+toDate+"</td>"; 
			newElem2 += "<input type='hidden' name='experiences[]' value='"+fields+"' />'";
			
			newElem2 += "</tr>";
			jQuery("#tableSelectedExperiencia").append(newElem2);
			need_update = 1;
			return true;
		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}


function addLanguage(language,level_speak,level_write,level_read){

		var fields = language + '{*}' + level_speak + '{*}' + level_write + '{*}' + level_read;
		var id = language.split(' ').join('');
		if ( document.getElementById(id) == null){
			newElem2 = "<tr id='"+id+"' >";
			newElem2 += "<td>"+language+"</td>";
			newElem2 += "<td>"+level_speak+"</td>"; 
			newElem2 += "<td>"+level_read+"</td>"; 
			newElem2 += "<td>"+level_write+"</td>"; 
			newElem2 += "<input type='hidden'  name='languages[]' value='"+fields+"' />";
			
			newElem2 += "</tr>";
			jQuery("#tableSelectedLanguage").append(newElem2);
			need_update = 1;
			return true;
		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
  		
}



function show_popup_language(){
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_language.php";
    activeModal =jQuery.modal('<iframe src="' + src + '" height="260" width="490" style="border:0"></iframe>', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:263,
		padding:0,
		width:492,
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

</script>


<script type="text/javascript">



function checkExtension(element,extensions){ 
	allowed_extensions = extensions.split(',')
	extension = (element.value.substring(element.value.lastIndexOf("."))).toLowerCase();
	permitited = false;
	for (var i = 0; i < allowed_extensions.length; i++) {
		 if (allowed_extensions[i] == extension) {
		 permitited = true;
		 break;
		 }
	  }
	  if (!permitited) {
		 alert("Compruebe la extension de los archivos a subir. \nSolo se pueden subir archivos con extensiones: " + allowed_extensions.join()); 
		 element.value = "";
		 }
		 
	setNeedUpdate();
}


function acceptDoctor(){
	document.forms['adminForm'].task.value = 'accept';
	document.forms['adminForm'].submit(); 
}

function rejectDoctor(){
	document.forms['adminForm'].task.value = 'reject';
	document.forms['adminForm'].submit(); 
}


function validateEmail($email) { var emailReg = /^[a-zA-Z0-9_-]{2,}@[a-zA-Z0-9_-]{2,}\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,4})?$/; return emailReg.test( $email );}
function validatePhone($phone) { var phoneReg = /^([0-9\s])*$/; return phoneReg.test( $phone );}
function validateNumber($number) { var numberReg = /^([0-9])*$/; return numberReg.test( $number );}




function validateFields(step){
    retorno = false;
    var msg = new Array();
	var error = false;
	
	//Validates first step
	if (step == 'step1'){
		if (jQuery("#doctor_name").val() == ""){
			 msg.push("<?php echo __('Debe ingresar un Nombre.');?>");
			 error = true;
			 }
		if (jQuery("#lastname").val() == ""){
			 msg.push('<?php echo __('Debe ingresar un Apellido.');?>');
			 error = true;
			 }
		if ( jQuery("#birth_date").val() == '' ){
			 msg.push('<?php echo __('Debe ingresar su Fecha de Nacimiento.');?>');
			 error = true;
			 }
		if (jQuery("#gender").val() == ''){
			msg.push('<?php echo __('Debe seleccionar un G\u00e9nero.');?>');
			error = true;
			 }
		if (jQuery("#description").val() == ''){
			msg.push('<?php echo __('Debe ingresar una descripci\u00f3n.');?>'); 
			error = true;
			 }
		if (jQuery("#nationality").val() == ''){
			msg.push('<?php echo __('Debe ingresar una nacionalidad.');?>'); 
			error = true;
			 }
		if (jQuery("#street_name").val() == ''){
			msg.push('<?php echo __('Debe ingresar la calle de su domicilio.');?>'); 
			error = true;
			 }	
		if (!validateNumber(jQuery("#street_number").val())){
			msg.push('<?php echo __('Debe ingresar el n\u00famero de calle de su domicilio.');?>'); 
			error = true;
			 }	
		if (jQuery("#identity_type").val() == ''){
			msg.push('<?php echo __('Debe seleccionar un Tipo de identidad.');?>'); 
			error = true;
			 }
		if ( !validateNumber(jQuery("#identity_number").val()) ){
			msg.push('<?php echo __('Debe ingresar un N\u00famero de identidad valido.');?>'); 
			error = true;
			 }
		if (jQuery("#country").val() == ''){
			msg.push('<?php echo __('Debe ingresar un Pa\u00eds');?>'); 
			error = true;
			 }
		if (jQuery("#state").val() == ''){
			msg.push('<?php echo __('Debe ingresar un Estado/Provincia.');?>'); 
			error = true;
			 }	
		if (jQuery("#city").val() == ''){
			msg.push('<?php echo __('Debe ingresar una Ciudad.');?>'); 
			error = true;
			 }
		if (!validateNumber(jQuery("#postal_code").val())){
			msg.push('<?php echo __('Debe ingresar su c\u00f3digo postal.');?>'); 
			error = true;
			 }
		if ( jQuery("#street_name").val() == '' ){
			msg.push('<?php echo __('Debe ingresar la calle su domicilio.');?>'); 
			error = true;
			 }
		if (!validateNumber(jQuery("#street_number").val())){
			msg.push('<?php echo __('Debe ingresar el n\u00famero de calle de su domicilio.');?>'); 
			error = true;
			 }
		
		if (!validateEmail(jQuery("#main_contact_mail").val())){
			msg.push('<?php echo __('Debe ingresar un mail de contacto profesional v\u00e1lido.');?>'); 
			error = true;
			 }
		if (!validatePhone(jQuery("#phone_numbers").val()))
			if ( jQuery("#phone_numbers").val() == '' ){
				msg.push('<?php echo __('Debe ingresar al menos un n\u00famero de tel\u00e9fono de contacto profesional v\u00e1lido.');?>'); 
				error = true;
			 }
		if ( jQuery("#marital_status").val() == '' ){
			msg.push('<?php echo __('Debe seleccionar su estado civil.');?>'); 
			error = true;
			 }
			 
		if (error){
			alert(msg.join('\n'));
			return false;
			}
		else
			return true;
	}
	return true;
}

function submitForm(step){
	if (validateFields(step)){
		document.getElementById('adminForm').task.value = 'save';
		document.getElementById('adminForm').step.value = step;
		document.getElementById('adminForm').submit();
		}
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
	setNeedUpdate();
	});
	
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
	setNeedUpdate()
	});
}

</script>

<?php
/**
* Template File: The users dashboard
* 52428800
* @package    Tina-MVC
* @subpackage Tina-Core-Views
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();

global $mv_needUpdate;
$mv_needUpdate = 0;

function checkSubmited($object,$element,$submitname = null){
	if ( is_null($submitname) )
		$submitname = $element;
	if ( isset($_POST[$submitname]) ){
		if ( $_POST[$submitname] != $object->$element ){
			global $mv_needUpdate;
			$mv_needUpdate = 1;
			}
		return $_POST[$submitname];
		}
	else
		return $object->$element;
}

 

?>


<div id="table_noticia" style="font-size: 14px;margin-left: -82px;width: 770px;">


<div class="message" style="margin-left:8px;margin-bottom:20px;">
	 <h3 style="color:#ea0000"><?php  echo $V->msg ?></h3>
</div>

        <div style="float: right;margin-right: 26px;">
			<a href="javascript:history.back(1)">
				<img src="wp-content/themes/rollpix/images/headers/back.png">
			</a>
		</div>		

<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
       			    <h2 style="margin-left: 61px;"><?php echo __('Doctor'); ?></h2>
					<br/>
					<fieldset class="adminform" style="margin-left: 56px;width: 90%;background-color: #ffffff;font-family:Verdana,arial,helvetica;"">

						  <ul class="tabs">
							<li><a name="tab1" href="#tab1"><?php echo __('Datos Personales'); ?></a></li>                
							<li><a name="tab2" href="#tab2"><?php echo __('Datos Profesionales'); ?></a></li>
							<!--li><a name="tab3" href="#tab3"><?php echo __('Preferencias Laborales'); ?></a></li-->
						  </ul>
              
							<div class="tab_container2" id="tab_container">  
              
							  <!--Pestana1-->
								<div id="tab1" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
												<div class="Columna" id="Columna1">						
													
													
													
													<div id="Cont1">
															<table class="admintable" style="font-size:11px">
																
																<tr>                                    	
																	<td style="padding-bottom: 20px;">
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Nro Doctor'); ?>:</td>
																	<td><?php echo $V->data->userid; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Nombre'); ?>:</td>
																	<td><?php echo $V->data->name; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('G&eacute;nero'); ?>:</td>
																	<td><?php echo $V->data->gender; ?></td>
																</tr>	
																	
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																<tr>
																	<td class="key"><?php echo __('Fecha de Nacimiento'); ?>:</td>
																	<td><?php echo $V->data->birth_date; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																
																<tr>
																	<td class="key"><?php echo __('Nacionalidad'); ?>:</td>
																	<td><?php echo checkSubmited($V->data,'nationality') ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																
																<tr>
																	<td class="key"><?php echo __('Pais'); ?>:</td>
																	<td><?php echo $V->data->country; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																
																<tr>
																	<td class="key"><?php echo __('Provincia'); ?>:</td>
																	<td><?php echo $V->data->state; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																<tr>																
																	<td class="key"><?php echo __('Localidad'); ?>:</td>
																	<td><?php echo $V->data->city; ?></td>
																</tr>
																
																<tr>
																	<td><div style="margin-top:20px"/></td>
																</tr>
							
																
															</table>
															
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
											 
															
								
								<!--Fin Pestana1-->
								<!------------------------------------------------------------------------>
								
								
								<!--Pestana2-->
								<div id="tab2" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
											<div class="Columna" id="Columna1">
										
											 
											  <div class="Separator"></div>
										
											  <div id="Cont3">
												
												<table class="admintable" style="font-size:11px;width: 600px">
																																	
													<tr>
														<td class="key"><div style="margin-top:15px;"></div></td>
													</tr>
													
													<tr>
													    <td>
															  <legend><?php echo __('Idioma') ?></legend>
															    
																<table id="tableSelectedLanguage" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Idioma') ?></th>
																	<th><?php echo __('Lee') ?></th>
																	<th><?php echo __('Habla') ?></th>
																	<th><?php echo __('Escribe') ?></th>
																	
																  </thead>
																  <?php 
																  if ($V->data->langs_s_w_r != '' && $V->data->langs_s_w_r != null) {
																	$langs = explode('<*>',$V->data->langs_s_w_r);
																	foreach ($langs as $lang):
																		$langArray = explode('{*}',$lang);
																		$langName = $langArray[0];
																		$langSpeak = $langArray[1];
																		$langWrite = $langArray[2];
																		$langRead = $langArray[3];
																		?>
																		<script>
																			addLanguage('<?php echo $langName ?>','<?php echo $langSpeak ?>','<?php echo $langWrite ?>','<?php echo $langRead ?>')
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody> 
																	
																  </tbody>
															  </table>
														</td>
												    </tr>
													
													<tr>
													    <td>
															<div style="margin-top:30px; margin-bottom:30px;"/>	
														<td>
													</tr>
													
													
													
													<tr>
													    <td>
															  <legend><?php echo __('Educaci&oacute;n de Grado'); ?></legend>
															    
																<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Titulo Profesional'); ?></th>
																	<th><?php echo __('Universidad'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	<th><?php echo __('Estado'); ?></th>
																	 </thead>
																  <?php 
																  if ($V->titles != '' && $V->titles != null) {
																	foreach ($V->titles as $aTitle):
																		?>
																		<script>
																			addEducation('<?php echo $aTitle->title ?>','<?php echo $aTitle->university_name ?>','<?php echo $aTitle->from_date ?>','<?php echo $aTitle->to_date ?>','<?php echo $aTitle->university ?>','<?php echo $aTitle->finalized ?>');
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody>
   
																  </tbody>
															  </table>
														</td>
												    </tr>
													
													<tr>
													    <td>
															<div style="margin-top:30px; margin-bottom:30px;"/>	
														<td>
													</tr>
													
													<tr>
													    <td>
															  <legend><?php echo __('Educaci&oacute;n de Postgrado'); ?></legend>
															   
																<table id="tableSelectedEducationPos" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Titulo Profesional'); ?></th>
																	<th><?php echo __('Universidad'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	<th><?php echo __('Estado'); ?></th>
																	
																  </thead>
																  <?php 
																  if ($V->titlesPos != '' && $V->titlesPos != null) {
																	foreach ($V->titlesPos as $aTitlePos):
																		?>
																		<script>
																			addEducationPos('<?php echo $aTitlePos->title ?>','<?php echo $aTitlePos->university_name ?>','<?php echo $aTitlePos->from_date ?>','<?php echo $aTitlePos->to_date ?>','<?php echo $aTitlePos->university ?>','<?php echo $aTitlePos->finalized ?>');
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody>
 
																  </tbody>
															  </table>
														</td>
												    </tr>
													               
													<tr>
													    <td>
															<div style="margin-top:30px; margin-bottom:30px;"/>	
														<td>
													</tr>
													
													<tr>
													    <td>
															  <legend><?php echo __('Experiencia Laboral'); ?></legend>
															    
																<table id="tableSelectedExperiencia" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Empresa'); ?></th>
																	<th><?php echo __('Puesto'); ?></th>
																	<th><?php echo __('Area'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	
																  </thead>
																  <?php 
																  if ($V->data->experience != '' && $V->data->experience != null) {
																	$experiences = explode('<*>',$V->data->experience);
																	foreach ($experiences as $aExperience):
																		$aExperienceArray = explode('{*}',$aExperience);
																		$aExperienceCompany = $aExperienceArray[0];
																		$aExperienceJobTitle = $aExperienceArray[1];
																		$aExperienceArea = $aExperienceArray[2];
																		$aExperienceFromDate = $aExperienceArray[3];
																		$aExperienceToDate = $aExperienceArray[4];
																		?>
																		<script>
																			addExperience('<?php echo $aExperienceCompany ?>','<?php echo $aExperienceJobTitle ?>','<?php echo $aExperienceArea ?>','<?php echo $aExperienceFromDate ?>','<?php echo $aExperienceToDate ?>');
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody> 
																  </tbody>
															  </table>
														</td>
												    </tr>
													
													<tr>
													    <td>
															<div style="margin-top:30px; margin-bottom:30px;"/>	
														<td>
													</tr>
													
													
													<tr>
													    <td>
															  <legend><?php echo __('Disciplinas de Dominio'); ?></legend>
															   	<table id="tableSelectedDisciplines" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Rama'); ?></th>
																	<th><?php echo __('Disciplina'); ?></th>	
																	<th><?php echo __('Subrama'); ?></th>												
																	
																  </thead>
																  <?php 
																  if ($V->disciplines != '' && $V->disciplines != null) {
																	foreach ($V->disciplines as $discipline):
																		?>
																		<script>
																			addDiscipline('<?php echo $discipline->branch ?>','<?php echo $discipline->name ?>','<?php echo $discipline->id ?>');
																			need_update = 0;
																		</script>
																		<?php
																	endforeach;
																  }
																  ?>
																  <tbody>

																  </tbody>
															  </table>
														</td>
												    </tr>
													
													<tr>
													    <td>
															<hr style="margin-top:30px;"/>	
														<td>
													</tr>
													
													<tr>
														<td class="key" >
															<div style=" margin-bottom: 7px;padding-top: 13px;"><?php echo __('Otras disciplinas de dominio'); ?></div>
															<textarea class="text_area" rows="4" cols="100" name="other_disciplines" readonly="readonly" id="other_disciplines" onchange="setNeedUpdate()"  size="50" maxlength="500" style="height: 208px;width: 600px;" ><?php echo checkSubmited($V->data,'other_disciplines') ?></textarea>
														</td>
													</tr>
													
													<tr>
														<td>
														<table class="admintable" style="font-size:12px;" >
															  
															  <tr>
																<td>
																	<div style="margin-top:20px;"></div>	
																</td>
															  </tr>
															  
															  
															  <tr>
																 <td>
																	<fieldset style="width:181%;font-size:12px;">
																		<legend><?php echo __('Competencias/Habilidades destacadas'); ?></legend>
																		<?php 
																			echo $V->checkbox->getCompentencies($V->competencies,'competitionid','competencies[]');
																		?>																											 
																	</fieldset>
																
																	
																 </td>	
															 </tr>
														
														</table>
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
							</div> <!--pestanas-->
							  
					
						</fieldset>
										
				</td>
			</tr>
		</tbody>
	</table>		
	
	<input type="hidden" name="need_update" id="need_update" value="0" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="tab" id="tab" value="" />
	<input type="hidden" name="step" id="step" value="" />
	<input type="hidden" name="userid" id="userid" value="<?php echo $V->userid?>" />
</form>

</div>
<?php 
if ($mv_needUpdate === 1){
	?>
	<script>
		setNeedUpdate();
	</script>
	<?php }
?>