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

function validateFields(){
    var msg = new Array();
	var error = false;
	
	if (jQuery("#company").val() == ""){
		 msg.push('Debe ingresar la empresa en la que trabaj\u00f3.');
		 error = true;
		 }
	if (jQuery("#job_title").val() == ""){
		 msg.push('Debe ingresar el cargo que ejerc\u00eda/ejerce en la empresa.');
		 error = true;
		 }
	if ( jQuery("#area").val() == '' ){
		 msg.push('Debe ingresar el \u00e1rea en la que trabaj\u00f3.');
		 error = true;
		 }
	if (jQuery("#from_date").val() == ''){
		msg.push('Debe ingresar la fecha en la que ingres\u00f3.');
		error = true;
		 }
	
	if (!validar_from()){ 
		 msg.push('Debe ingresar la Fecha formateada dd-mm-aaaa.');
		 error = true;
	}

    if (!validar_to()){ 
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


function addExperience(){ 
	if (validateFields()){
		if(parent.validate_dates(document.getElementById("from_date").value,document.getElementById("to_date").value)) {
			if(confirm("\u00BFEst\u00e1 seguro que quiere guardar la experiencia laboral?")) { 
				  company = document.getElementById('company').value;
				  jobTitle = document.getElementById('job_title').value;
				  area = document.getElementById('area').value;
				  fromDate = document.getElementById('from_date').value;
				  toDate = document.getElementById('to_date').value;
				  if ( parent.addExperience(company,jobTitle,area,fromDate,toDate))
					parent.activeModal.close(); 
			}		
		}
	}
}

function closePopup(){
   parent.activeModal.close();
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
 
</script> 


<?php
function esSelected($estado,$comparacion){   
    if ($estado == $comparacion){
       return $estado. ' selected';
    }  
    else return $estado;  
}
?>


<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm" >
	<table class="admintable" width="90%">
		
		<tbody>
			<tr >
				<td valign="top">
					<fieldset class="adminform" style="background-color: #E3E3E3;font-family:Verdana,arial,helvetica;">
						<legend>Experiencia Laboral</legend>
						<table class="admintable" >
							
							<tr>
								<td class="key" style="font-size:11px;">Empresa(*)</td>
								<td><input class="text_area" type="text" name="company" id="company" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Cargo (*)</td>
								<td><input class="text_area" type="text" name="job_title" id="job_title" value="" size="50" maxlength="250" /></td>
							</tr>
							
						    <tr>
								<td class="key" style="font-size:11px;">Area (*)</td>
								<td><input class="text_area" type="text" name="area" id="area" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Desde(*)</td>
								<td><input style="float:left;" class="tcal" type="text" name="from_date" id="from_date" value="" />
								<p style="float: left;font-size: 11px;margin-left: 8px;margin-top: 3px;">(dd-mm-aaaa)</p>
								</td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Hasta</td>
								<td><input style="float:left;" class="tcal" type="text" name="to_date" id="to_date" value="" />
								<p style="float: left;font-size: 11px;margin-left: 8px;margin-top: 3px;">(dd-mm-aaaa)</p>
								</td>
							</tr>
													
							
							<tr>                         
								<td style="padding-top:20px;float:left;">
									<input id="button" onclick="addExperience()" type="button"  value ="Guardar" />
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
