<?php
/*
// Copyright (c) 2011 JoomlaWorks Ltd. All rights reserved.
// Released under the GNU/GPL license: http://www.tsavo.com.ar
// More info at http://www.tsavo.com.ar
// Designed and developed by the Tsavo Group team
*/


?>
   	
	<script language="JavaScript" src="../simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="../simple-calendar/tcal.css">
	<script type="text/javascript" src="../js/jquery.js"></script> 
	
<script language="javascript" type="text/javascript">
jQuery(document).ready(function($){

	
	var data = {
		action: 'get_universities',
		comboid: 'university'
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboUniversities').innerHTML = response;
	});
	
});


function validateFields(){
    var msg = new Array();
	var error = false;
	
	if (jQuery("#title").val() == ""){
		 msg.push('Debe ingresar el t\u00edtulo.');
		 error = true;
		 }
	if (jQuery("#from_date").val() == ""){
		 msg.push('Debe ingresar la fecha en la que comenz\u00f3 a cursar.');
		 error = true;
		 }
	if ( jQuery("#to_date").val() == '' ){
		 msg.push('Debe ingresar la fecha en la que dej\u00f3 de cursar.');
		 error = true;
		 }
	
    if ( !validar_from() ){ 
		 msg.push('Debe ingresar la Fecha formateada dd-mm-aaaa.');
		 error = true;
	}

    if ( !validar_to() ){ 
		 msg.push('Debe ingresar la Fecha formateada dd-mm-aaaa.');
		 error = true;
	}		
		 
	if (error){
		alert(msg.join('\n'));
		return false;
		}
	else
		return true;
}

    
function addEducation(){ 
	if (validateFields()){
		if(parent.validate_dates(document.getElementById("from_date").value,document.getElementById("to_date").value)) {
			if(confirm("\u00BFEst\u00e1 seguro que quiere guardar la educaci\u00f3n?")) { 
				  title = document.getElementById('title').value;
				  universityid = document.getElementById('university').value;
				  university = document.getElementById('university')[document.getElementById('university').selectedIndex].innerHTML;
				  fromDate = document.getElementById('from_date').value;
				  toDate = document.getElementById('to_date').value;
				  stateValue = document.getElementById('state').value;
				  if ( parent.addEducation(title,university,fromDate,toDate,universityid,stateValue))	
                    parent.activeModal.close();  
				  	
			}
		}	
	}
}

function validar_from()
 {
 	var aux = document.getElementById("from_date").value;
	var new_fecha = aux.split('-');
	var dia = new_fecha[0];
	var mes = new_fecha[1];
	var anio = new_fecha[2];
    	
	if(dia.length == 2)
		if(mes.length == 2)
		  if(anio.length == 4)
				return true;
					
	return false;	 	 	 	
 }

 
 function validar_to()
 {
 	var aux = document.getElementById("to_date").value;
	var new_fecha = aux.split('-');
	var dia = new_fecha[0];
	var mes = new_fecha[1];
	var anio = new_fecha[2];
    	
	if(dia.length == 2)
		if(mes.length == 2)
		  if(anio.length == 4)
				return true;
					
	return false;	 	 	 	
 }

function closePopup(){
   parent.activeModal.close();
} 	
	
</script> 




<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm" >
	<table class="admintable" width="90%">
		
		<tbody>
			<tr >
				<td valign="top">
					<fieldset class="adminform" style="background-color: #E3E3E3;font-family:Verdana,arial,helvetica;">
						<legend>Educaci&oacute;n de grado</legend>
						<table class="admintable" >
							
							<tr>
								<td style="font-size:11px;" class="key">T&iacute;tulo Profesional (*)</td>
								<td><input class="text_area" type="text" name="title" id="title" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Universidad (*)</td>
								<td id="comboUniversities" >
								</td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Desde (*)</td>                                            
								 <td><input style="float:left;" type="text" name="from_date" id="from_date" class="tcal" value="" />
								 <p style="float: left;font-size: 11px;margin-left: 8px;margin-top: 3px;">(dd-mm-aaaa)</p>									
								</td>																 
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Hasta (*)</td>                                             
								 <td><input style="float:left;" type="text" name="to_date" id="to_date" class="tcal" value="" />
								 <p style="float: left;font-size: 11px;margin-left: 8px;margin-top: 3px;">(dd-mm-aaaa)</p>
								 </td>																 
							</tr>
							  							
							
							<tr>
								<td class="key" style="font-size:11px;">Estado (*)</td>
								<td>
									<select name="state" id="state" >
										<option value="1"> Completo </option>
										<option value="0"> Incompleto </option>
								   	</select>
															 
								</td>	
							</tr>		
							
							<tr>                         
								<td style="padding-top:20px;float:left;">
								  <input id="button" onclick="addEducation()" type="button"  value ="Guardar" />
								</td>
								
								<td style="padding-top:20px;">
								  <input id="button" class="modal-close" onclick="closePopup()" type="button"  value ="Cancelar" />
								</td>
							</tr> 
							
						</table>
						
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>		
</form>
