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


?>

    
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
    
<style>


#tableSelectedEducation thead{
  background-color: #eeeeee;
}

#tableSelectedDisciplines thead{
  background-color: #eeeeee;
}

#tableconsultationResults thead{
  background-color: #eeeeee;
}

#tableSelectedEducation tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedEducationPos thead{
  background-color: #eeeeee;
}

#tableSelectedEducationPos tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedTesis thead{
  background-color: #eeeeee;
}

#tableSelectedTesis tbody{
   border-right: 1px solid;
   height:100%;
}


#tableSelectedExperiencia thead{
  background-color: #eeeeee;
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


.active a{
  color:black;
}
</style>


<script language="JavaScript">
  
	
  
  jQuery(document).ready(function(){
  
  
	var a = Math.ceil(Math.random() * 10)+ '';
	var b = Math.ceil(Math.random() * 10)+ '';       
	var c = Math.ceil(Math.random() * 10)+ '';  
	var d = Math.ceil(Math.random() * 10)+ '';  
	var e = Math.ceil(Math.random() * 10)+ '';  
	var f = Math.ceil(Math.random() * 10)+ '';  
	var g = Math.ceil(Math.random() * 10)+ '';  
	var code = a + ' ' + b + ' ' + ' ' + c + ' ' + d + ' ' + e + ' '+ f + ' ' + g;
	document.getElementById("txtCaptcha").value = code
	
	var country_combo = document.forms["adminForm"].country;
		var quantity = country_combo.length;
		for(i=0;i<quantity;i++) 
			if(country_combo[i].value == "Argentina")
				country_combo[i].selected = true; 
			
	refreshStates();
  });
  
  
 function getConsultationResults(type_user) {		
				
		if(ValidCaptcha()){	
		    if(validateFields(type_user)){
			
					jQuery("#loading").css({'display':'block'});

					auxArray = jQuery('[[name="laborrelationships[]"]:checked');
					labor_relationships = '';
					for (i=0;i<(auxArray.length);i++){
						if (i==0) labor_relationships += auxArray[i].value;
						else labor_relationships += ','+auxArray[i].value;
					}
					auxArray = jQuery('[[name="laborsectors[]"]:checked');
					labor_sectors = '';
					for (i=0;i<(auxArray.length);i++){
						if (i==0) labor_sectors += auxArray[i].value;
						else labor_sectors += ','+auxArray[i].value;
					}
					auxArray = jQuery('[[name="availabilitytimes[]"]:checked');
					availability_times = '';
					for (i=0;i<(auxArray.length);i++){
						if (i==0) availability_times += auxArray[i].value;
						else availability_times += ','+auxArray[i].value;
					}
					auxArray = jQuery('[[name="competencies[]"]:checked');
					competencies = '';
					for (i=0;i<(auxArray.length);i++){
						if (i==0) competencies += auxArray[i].value;
						else competencies += ','+auxArray[i].value;
					}
					auxArray = jQuery('[[name="disciplines[]"]');
					disciplines = '';
					for (i=0;i<(auxArray.length);i++){
						if (i==0) disciplines += auxArray[i].value;
						else disciplines += ','+auxArray[i].value;
					}
					//Get form data
					var data = {									
						action: 'get_consultation_result',
						gender: jQuery('#gender').val(),
						age_from: jQuery('#age_from').val(),
						age_to: jQuery('#age_to').val(),
						country: jQuery('#country').val(),
						state: jQuery('#state').val(),
						city: jQuery('#city').val(),
						availability_for_travel: jQuery('#availability_for_travel').is(':checked') ? true : false,
						availability_move_country: jQuery('#availability_move_country').is(':checked') ? true : false,
						availability_move_state: jQuery('#availability_move_state').is(':checked') ? true : false,
						gross_mensual_remuneration_min: jQuery('#gross_mensual_remuneration_min').val(),
						gross_mensual_remuneration_max: jQuery('#gross_mensual_remuneration_max').val(),
						laborsectors: labor_sectors,
						laborrelationships: labor_relationships,
						availabilitytimes: availability_times,
						competencies: competencies,
						disciplines: disciplines,
						titles: jQuery('#degree_title').val(),
						titlesPos: jQuery('#graduate_degree').val(),
						isadmin: '<?php echo $V->isAdmin;?>',
						matchalldisciplines: jQuery('#match_all_diciplines_and_skills').is(':checked')
					};
					jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
						jQuery("#consultationResults").html(response);
						jQuery("#loading").css({'display':'none'});
						jQuery("[name='tab2']").click();
					});
			}
			 
			}
            else alert("El n\u00famero ingresado no coincide con el n\u00famero de la imagen");			
		
 }
 
 function removeThis(anItem) {
	var child = document.getElementById(anItem);
	var parent = child.parentElement;
	parent.removeChild(child);
}
 
 
 function show_popup_education() {
	var src = "wp-content/themes/rollpix/include/popups/popup_education.php";
    jQuery.modal('<iframe src="' + src + '" height="250" width="700" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:255,
		padding:0,
		width:705,
	},
	overlayClose:true,
	onClose: function(dialog){
	  createNewEducation('field','Ingeniero');
	  var self = this;          
	  self.close();
	  
	},
	onOpen: function (dialog) {
		  dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
			  dialog.data.slideDown('slow');
			});
		  });
	}
	});
}

function show_popup_tesis_postgrado() {
	var src = "wp-content/themes/rollpix/include/popups/popup_tesis_postgrado.php";
    jQuery.modal('<iframe src="' + src + '" height="250" width="width: 700px;" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:255,
		padding:0,
		width:710,
	},
	overlayClose:true,
	onClose: function(dialog){
	  createNewEducationTesis('field','Ingeniero','Uni Tandil','2000','2009');
	  var self = this;          
	  self.close();
	  
	},
	onOpen: function (dialog) {
		  dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
			  dialog.data.slideDown('slow');
			});
		  });
	}
	});
}


function show_popup_education_post() {
	var src = "wp-content/themes/rollpix/include/popups/popup_education_post.php";
    jQuery.modal('<iframe src="' + src + '" height="250" width="700" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:255,
		padding:0,
		width:705,
	},
	overlayClose:true,
	onClose: function(dialog){
	  createNewEducationPost('field','Ingeniero','Uni Tandil','2000','2009','completo');
	  var self = this;          
	  self.close();
	  
	},
	onOpen: function (dialog) {
		  dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
			  dialog.data.slideDown('slow');
			});
		  });
	}
	});
}

function show_popup_diciplines() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_disciplines.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="300" width="500" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:320,
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
  			newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
  			newElem2 += "</tr>";
  			jQuery("#tableSelectedDisciplines").append(newElem2);
  			return true;
  			
  		}
  		else {
		alert("<?php echo __('Este elemento ya ha sido agregado') ?>");
		return false;
		}
}

function hide_MonthsDuration(){

  document.getElementById('months_duration').style.display ='none';
  
}

</script>



<script>

  function DrawCaptcha()
    {
        var a = Math.ceil(Math.random() * 10)+ '';
        var b = Math.ceil(Math.random() * 10)+ '';       
        var c = Math.ceil(Math.random() * 10)+ '';  
        var d = Math.ceil(Math.random() * 10)+ '';  
        var e = Math.ceil(Math.random() * 10)+ '';  
        var f = Math.ceil(Math.random() * 10)+ '';  
        var g = Math.ceil(Math.random() * 10)+ '';  
        var code = a + ' ' + b + ' ' + ' ' + c + ' ' + d + ' ' + e + ' '+ f + ' ' + g;
        document.getElementById("txtCaptcha").value = code
    }

    // Validate the Entered input aganist the generated security code function   
    function ValidCaptcha(){
        var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
        var str2 = removeSpaces(document.getElementById('txtInput').value);
        if (str1 == str2) return true;        
        return false;
        
    }

    // Remove the spaces from the entered and generated code
    function removeSpaces(string)
    {
        return string.split(' ').join('');
    }
    
 
</script>	

<script language="javascript" type="text/javascript">
function validateFields(type_user){
			retorno = false;
			var msg = new Array();
		    var error = false;
			
		    if(type_user == 'Administrator') {
					error = false;
		    } else {
			   if (jQuery("#graduate_degree").val() == "") {
                   if (jQuery("#degree_title").val() == "") {
					 msg.push("<?php echo __('Debe ingresar alguno de los dos t\u00edtulos para la consulta.');?>");
				     error = true;		   
					}
				}
			}
		   	 
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
}

function refreshStates(){
	var data = {
	action: 'get_states',
	country: jQuery('#country').val(),
	all: 1,
	comboid: 'state'
	}
	
	jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
	document.getElementById('stateContainer').innerHTML = response;
	refreshCities();
	});
	
}

function refreshCities(){
	var data = {
	action: 'get_cities',
	country: jQuery('#country').val(),
	state: jQuery('#state').val(),
	all: 1,
	comboid: 'city'
	}
	
	jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
	document.getElementById('cityContainer').innerHTML = response;
	});
}



function saveForm(type_user){
    if (validateFields(type_user)){
	  if(confirm("¿Est\u00e1 seguro que quiere guardar los cambios?")) { 	
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit();
      }		
	}	
}

function checkUncheckAll() {
	if(jQuery('#result_checker').is(':checked'))
		jQuery('[name="userid[]"]').attr('checked',true);
	else
		jQuery('[name="userid[]"]').attr('checked',false);
}

function addPostulants() {
	auxArray = jQuery('[name="userid[]"]:checked');
	if (auxArray.length >= 1){
		jQuery("#loading_postulants").css({'display':'block'});
		
		postulants = '';
		for (i=0;i<(auxArray.length);i++){
			if (i==0) postulants += auxArray[i].value;
			else postulants += ','+auxArray[i].value;
		}
		var data = {
		action: 'add_postulants',
		searchid: jQuery('#searchid').val(),
		postulants: postulants,
		whoadd: jQuery('#userid').val(),
		deleteold:  jQuery('#delete_old').is(':checked') ? true : false	
		}
		
		jQuery.post('wp-admin/admin-ajax.php', data, function(response) {
			jQuery('#postulantResult').innerHTML = response;
			jQuery("#loading_postulants").css({'display':'none'});
		});
		}
	else 
		alert('<?php echo __('Debe seleccionar al menos un postulante de la lista'); ?>');	
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
    if ($estado == 1)
       return ' checked';
      
    return $estado;  
}


if ($V->data->name != null && $V->data->name  != '')
	$fromSearch = false;
else
	$fromSearch = true;

	
function getCompetences($competencies){
	$auxArray = explode(',',$competencies);
	if ($auxArray[0] == '')
		$auxArray = array();
	$return = array();
	foreach ($auxArray as $element):
		$newElement = new StdClass;
		$newElement->id = $element;
		$return[] = $newElement;
	endforeach;
	return $return;
}	

global $current_user;
get_currentuserinfo();	



?>
	  

<div id="table_noticia" style="font-size: 14px;margin-left: -17px;width: 679px;">
	
<form class="adminForm" name="adminForm" enctype="multipart/form-data" action="" method="post">
	<table class="admintable" style="font-size:11px;width:100%;">
		
		<tbody>
			<tr>
				<td valign="top">
					<h2><?php echo __('Explorar registro de doctores') ?></h2>
					<br/>
					<fieldset class="adminform" style="margin-left:-11px;background-color: #ffffff;">
						            
						  <ul class="tabs">
							<li><a href="#tab1"><?php echo __('Consultas') ?></a></li>                
							<li><a href="#tab2" name="tab2"><?php echo __('Resultados') ?></a></li>
						  </ul>
              
							<div class="tab_container2">  
              
			  
							  <!--Pestana1-->
								<div id="tab1" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
											<div class="Columna" id="Columna1">
										     
											  <div id="Cont3">
												<table class="admintable">
													
													<?php if($V->isAdmin) { ?>
													
													<tr>
														<td>
													       <div style="margin-top:22px; margin-bottom:22px;"></div>	
												        </td>	
													</tr>
													
													<?php if($V->isAdmin) { ?>
													<tr <?php if (!$V->complete) echo "style='display:none'"?>>
														<td class="key"><?php echo __('Nombre')?></td>
														<td><input class="text_area" type="text" name="name"  size="50" id="name" value="<?php echo $V->data->name?>" /></td>
														<td><input id="save" name="save" type="button" onclick="saveForm('Administrator');" value="<?php echo __('Guardar Consulta') ?>" /></td>
													</tr>
													<?php } else { ?>
													<tr <?php if (!$V->complete) echo "style='display:none'"?>>
														<td class="key"><?php echo __('Nombre')?></td>
														<td><input class="text_area" type="text" name="name"  size="50" id="name" value="<?php echo $V->data->name?>" /></td>
														<td><input id="save" name="save" type="button" onclick="saveForm('Normal');" value="<?php echo __('Guardar Consulta') ?>" /></td>
													</tr>							
													<?php } ?>
													
													<tr>
														<td class="key"><?php echo __('G&eacute;nero') ?></td>
														<td>
														<?php 
														if (!$fromSearch)
															echo $V->combos->getGenders(true,$V->data->gender,'gender');
														else
															echo $V->combos->getGenders(true,$V->searchData->gender,'gender');
														?>
														</td>
													</tr>
												    
													<tr>
														<td class="key"><?php echo __('Edad Desde') ?></td>
														<td><input class="text_area" type="text" name="age_from"  size="10" id="age_from" value="<?php if (!$fromSearch) echo $V->data->age_from; else echo $V->searchData->age_from;?>" /></td>
																						
													</tr>
													
													<tr>
														<td class="key"><?php echo __('Edad Hasta') ?></td>
														<td><input class="text_area" type="text" name="age_to"  size="10" id="age_to" value="<?php if (!$fromSearch) echo $V->data->age_to; else echo $V->searchData->age_to;?>" /></td>
																						
													</tr>
													
													<?php }?>
													
													<?php if(checkUserType($current_user->user_login,'company') OR ($V->isAdmin)){ ?>
												
															<tr>
																<td class="key"><?php echo __('Pa&iacute;s de Residencia') ?></td>
																<td>
																	<?php 
																	if (!$fromSearch)
																		echo $V->combos->getCountries($V->data->country,'country',1); 
																	else
																		echo $V->combos->getCountries($V->searchData->country,'country',1); 
																	?>
																</td>
															</tr>
															
															<tr>
																<td class="key"><?php echo __('Provincia/Estado') ?></td>
																<td id="stateContainer" >
																	<?php 
																	if (!$fromSearch)
																		echo $V->combos->getStates($V->data->state,$V->data->country,'state',1);
																	else
																		echo $V->combos->getStates($V->searchData->state,$V->searchData->country,'state',1);
																	?>
																</td>
															</tr>	
												
													    <?php }?>
														
														<?php if($V->isAdmin) { ?>
																<br/>
																<tr>
																	<td class="key"><?php echo __('Ciudad') ?></td>
																	<td id="cityContainer">
																		<?php 
																		if (!$fromSearch)
																			echo $V->combos->getCities($V->data->city,$V->data->country,$V->data->state,'city',1);
																		else
																			echo $V->combos->getCities($V->searchData->city,$V->searchData->country,$V->searchData->state,'city',1) 
																		?>
																	</td>
																</tr>
													
													
												       
													
													<tr>    
														<td class="key" style="float:left; margin-top: 5px;"><?php echo __('Disponibilidad para mudarse de pa&iacute;s') ?></td>
														<td style="padding-top: 7px;">
														  <input name="availability_move_country" id="availability_move_country" <?php echo isChecked($V->data->availability_move_country); ?> TYPE="CHECKBOX" VALUE="<?php echo $V->data->availability_move_country; ?>"/>
														</td>
													</tr>
													
													<tr>    
														<td class="key" style="float:left; margin-top: 5px;"><?php echo __('Disponibilidad para mudarse de provincia') ?></td>
														<td style="padding-top: 7px;">
														   <INPUT name="availability_move_state" TYPE="CHECKBOX"  <?php echo isChecked($V->data->availability_move_state); ?> VALUE="<?php echo $V->data->availability_move_state; ?>"/>
														</td>
													</tr>
													
												
													
														<tr >
															<td colspan="3">
																<div style="margin-top:30px; margin-bottom:30px;"/>	
															</td>
														</tr>										
													
												
													<?php }?>
												
												
													<tr>
													<td class="key" style="vertical-align:top;"><?php echo __('T&iacute;tulo de Grado') ?></td>
													<td colspan="2" ><textarea class="text_area" rows="4" cols="100" name="degree_title" id="degree_title"  size="50" maxlength="1000" style="height:72px;;width: 446px;"><?php if (!$fromSearch) echo $V->data->degree_title; else echo $V->searchData->degree_title; ?></textarea></td>
														
													</tr>	
											
													<tr>
														<td>
															<div style="margin-bottom:30px;"/>	
														</td>
													</tr>	
											
													<tr>
													<td class="key" style="vertical-align:top;"><?php echo __('T&iacute;tulo de Postgrado') ?></td>
													<td colspan="2"><textarea class="text_area" rows="4" cols="100" name="graduate_degree" id="graduate_degree"  size="50" maxlength="1000" style="height:72px;width: 446px;""><?php if (!$fromSearch) echo $V->data->graduate_degree; else echo $V->searchData->graduate_degree; ?></textarea></td>
														
													</tr>	
													
													
													</table>
													<?php if($V->isAdmin) { ?>
														<table class="admintable" style="font-size:11px;width: 597px;">
															
															<tr>
																<td>
																	<div style="margin-top:20px; margin-bottom:20px;"/>	
																</td>
															</tr>
															
															<tr>
																<td>
																	  <legend><div style="font-size:12px;"><?php echo __('Disciplinas Requeridas') ?></div></legend>
																		<table id="tableSelectedDisciplines" class="admintable" style="margin-top: -2px;font-size:11px;width:90%;text-align:center;margin-bottom: 27px;">
																		 																		 
																			<div style="float:right;" >
																				<input id="addDiscipline" onclick="show_popup_diciplines()"type="button"  value ="Agregar" />
																			</div>
																																				
																			
																		 <thead>
																			<th><?php echo __('Rama') ?></th>
																			<th><?php echo __('Disciplina') ?></th>
																			<th></th>
																		  </thead>
																		  <?php 
																		  if ($V->disciplines != '' && $V->disciplines != null) {
																			foreach ($V->disciplines as $discipline):
																				?>
																				<script>
																					addDiscipline('<?php echo $discipline->branch ?>','<?php echo $discipline->name ?>','<?php echo $discipline->id ?>');
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
																						
												</table>
												
												
												<table class="admintable" style="font-size:12px">
													
													<tr>
													    <td>
															<div style="margin-top:30px; margin-bottom:20px;"/>	
														</td>
													</tr>
													
													<tr>    
														<td class="key" style="float:left; margin-top: 5px;"><label for="match_all_diciplines_and_skills"><?php echo __('Debe cumplir con todas las disciplinas') ?></label> <input id="match_all_diciplines_and_skills" name="match_all_diciplines_and_skills" <?php echo isChecked($V->data->match_all_diciplines_and_skills); ?> TYPE="CHECKBOX" VALUE="<?php echo $V->data->match_all_diciplines_and_skills; ?>"/></td>
														<td></td>
													</tr>												
												</table>													
												<?php } ?>
												
												<table>	
													
													<tr>
														<td>
															<div style="margin-top:10px;margin-bottom:20px">
														</td>
													</tr>	
													
													
													<tr>
														<td>
															<?php echo "(Por favor, ingrese el n&uacute;mero que aparece en la imagen)"?><br/>
															<input type="text" id="txtCaptcha" 
																style="background-image:url(wp-content/plugins/masvalor/app/includes/image/captcha.png); text-align:center; border:none;
																font-weight:bold; font-family:Modern" />
															  <input type="button" id="btnrefresh" value="Cambiar" onclick="DrawCaptcha();" />
															
														</td>
													</tr>
													<tr>
														<td>
															<input type="text" id="txtInput"/>    
														</td>
													</tr>
													
																										
													
													<tr>
														<td>
															<div style="margin-top:20px;margin-bottom:20px">
														</td>
													</tr>	
													<?php if($V->isAdmin) { ?>													
													<tr>
														<td><input id="do_search" name="save" style="margin-top:11px;" type="button" onclick="getConsultationResults('Administrator')" value="<?php echo __('Realizar consulta') ?>" /></td>
														<td><img id="loading" name="loading" src="wp-content/plugins/masvalor/app/includes/image/loading_transparent.gif" style="display:none;height: 40px;" /></td>
													</tr>
													<?php } else { ?>
													<tr>
														<td><input id="do_search" name="save" style="margin-top:11px;" type="button" onclick="getConsultationResults('Normal')" value="<?php echo __('Realizar consulta') ?>" /></td>
														<td><img id="loading" name="loading" src="wp-content/plugins/masvalor/app/includes/image/loading_transparent.gif" style="display:none;height: 40px;" /></td>
													</tr>
													<?php } ?>
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
										
											  
											  <div class="Separator"></div>
										
											  <div id="Cont3">
												<table class="admintable" style="font-size:11px;">
													
																										
													<table class="admintable" style="font-size:11px;width:600px">
																									
													
													<tr>
													    <td>
															  <legend><?php echo __('Resultado de la Consulta')?></legend>
																<table class="admintable" id="tableconsultationResults" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><input id="result_checker" type="checkbox" onclick="checkUncheckAll()" ></th>
																	
																	<th><?php echo __('Id')?></th>
																	<th><?php echo __('Nombre')?></th>
																	
																	<?php if($V->isAdmin) { ?>
																		<th><?php echo __('Apellido')?></th>
																	 <?php } ?>	
																	
																	<th><?php echo __('Edad')?></th>
																	
																	<?php if(checkUserType($current_user->user_login,'company')){ ?>
																		<th><?php echo __('Genero')?></th>
																		<th><?php echo __('Provincia')?></th>
																		<th><?php echo __('Dispuesto a Mudarse')?></th>
																	<?php } ?>
																	
																	<th><?php echo __('T&iacute;tulo Grado')?></th>
																	<th><?php echo __('T&iacute;tulo Doctor')?></th>
																															
																	 
																	<?php if($V->isAdmin) { ?>
																	<th><?php echo __('Perfil')?></th>
																	<th><?php echo __('CV')?></th>
																	 <?php } ?>
																	

																	
																  </thead>
																  
																  <tbody id="consultationResults" >
																     
																  </tbody>
															  </table>
														</td>
												    </tr>	
																									
													
													<tr>
														<td>
															<hr style="margin-top:40px;margin-bottom:40px"/>
														</td>
													</tr>	
																									
													<?php if(checkUserType($current_user->user_login,'company')){ ?>																								
														<tr>
															<td>
																<h4 style="margin-top:-18px;"><?php echo __('Para m&aacute;s informaci&oacute;n sobre los doctores
																				registrados, debe ingresar una b&uacute;squeda y contactarse con la Secretar&iacute;a del Programa +VALOR.Doc.');?> 
																</h4>
															</td>
													    </tr>		
													<?php } ?>		
													
												</table>	
												 <?php if(!$V->isGuest) { ?>
												<table class="admintable" style="font-size:11px; margin-top: 30px;" >												
													<tr>
														<td class="key"><?php echo __('Convertir en Candidatos de la B&uacute;squeda')?>(*)</td>
														<td>
															<?php 
															if (!$fromSearch)
																echo $V->combos->getSearchs(null,'searchid',$V->isAdmin,$V->userid);
															else
																echo $V->combos->getSearchs($V->searchid,'searchid',$V->isAdmin,$V->userid);
															?>				 
														</td>	
														<td>
															<input id="addPostulantsButton" onclick="addPostulants()" type="button"  value ="<?php echo __('Convertir en nuevos candidatos');?>" />
															<td><img id="loading_postulants" name="loading_postulants" src="wp-content/plugins/masvalor/app/includes/image/loading_transparent.gif" style="display:none;height: 40px;" /></td>
														</td>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td>
															<input type="checkbox" id="delete_old" name="delete_old" />
															<label for="delete_old" ><?php echo __('Borrar candidatos anteriores');?></label>
														</td>
													</tr>	
													<tr id="postulantResult"></tr>	

													
												</table>			
												
												<?php }else{ ?>
													
													<h4 class="legend"><?php echo __('Para m&aacute;s informaci&oacute;n sobre los doctores registrados, debe suscribir convenio de
                                                          adhesi&oacute;n al Programa +VALOR.Doc. Ver Empresas, Registraci&oacute;n.');?> 
													</h4>
													
												<?php } ?>
											
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
	<input type="hidden" name="userid"  id="userid" value="<?php echo $V->userid?>"/>
	<input type="hidden" name="task" id="task" value="" />	
	
</form>

</div>






	       

   

 