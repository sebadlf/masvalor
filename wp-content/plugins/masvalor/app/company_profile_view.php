
 <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/slider/jquery-ui-1.8.16.custom.min.js"></script>
          
 <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
	
 <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/pdfcreator/jspdf.js"></script> 
 
<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/pdfcreator/libs/base64.js"></script> 

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/pdfcreator/libs/sprintf.js"></script>
 
<script type="text/javascript">
 
jQuery(document).ready(function($){



    if(jQuery("#company_name").val() == ""){
		
		var country_combo = document.forms["adminForm"].country;
		var quantity = country_combo.length;
		for(i=0;i<quantity;i++) 
			if(country_combo[i].value == "Argentina")
				country_combo[i].selected = true; 
		
		refreshStates();
    }
  
	
});


function validateEmail($email) { var emailReg = /^[a-zA-Z0-9_-]{2,}@[a-zA-Z0-9_-]{2,}\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,4})?$/; return emailReg.test( $email );}
function validatePhone($phone) { var phoneReg = /^([0-9\s])*$/; return phoneReg.test( $phone );}
function validateNumber($number) { var numberReg = /^([0-9])*$/; return numberReg.test( $number );}

function esCUITValida(inputValor) {
    inputString = inputValor.toString()
    if (inputString.length == 11) {
		var Caracters_1_2 = inputString.charAt(0) + inputString.charAt(1)
		if (Caracters_1_2 == "20" || Caracters_1_2 == "23" || Caracters_1_2 == "24" || Caracters_1_2 == "27" || Caracters_1_2 == "30" || Caracters_1_2 == "33" || Caracters_1_2 == "34") {
			var Count = inputString.charAt(0) * 5 + inputString.charAt(1) * 4 + inputString.charAt(2) * 3 + inputString.charAt(3) * 2 + inputString.charAt(4) * 7 + inputString.charAt(5) * 6 + inputString.charAt(6) * 5 + inputString.charAt(7) * 4 + inputString.charAt(8) * 3 + inputString.charAt(9) * 2 + inputString.charAt(10) * 1
			Division = Count / 11;
			if (Division == Math.floor(Division)) {
				return true
			}
		}
    }
    return false
}

function get_pdf(base_url){
	
/* 	if(document.getElementById("business_name").value =="" || document.getElementById("street_name").value =="" || document.getElementById("street_number").value =="") {
	
	alert("Faltan completar datos para generar el contrato, verifique");
	}else{
	
	usuario = 'usuario';
	var miFechaActual = new Date();
	var dia = new Date();
	var dianum = miFechaActual.getDate();
	var doc = new jsPDF();

	var fecha=new Date();
	var diames=fecha.getDate();
	var diasemana=fecha.getDay();
	var mes=fecha.getMonth() +1 ;
	var ano=fecha.getFullYear() ;
	
	var textomes = new Array (12);
	  textomes[1]="Enero";
	  textomes[2]="Febrero";
	  textomes[3]="Marzo";
	  textomes[4]="Abril";
	  textomes[5]="Mayo";
	  textomes[6]="Junio";
	  textomes[7]="Julio";
	  textomes[7]="Agosto";
	  textomes[9]="Septiembre";
	  textomes[10]="Octubre";
	  textomes[11]="Noviembre";
	  textomes[12]="Diciembre";
	  
	var textoano = new Array (15);
	  textoano[2011]="once";
	  textoano[2012]="doce";
	  textoano[2013]="trece";
	  textoano[2014]="catorce";
	  textoano[2015]="quince";
	  textoano[2016]="dieciseis";
	  textoano[2017]="diecisiete";
	  textoano[2018]="dieciocho";
	  textoano[2019]="diecinueve";
	  textoano[2020]="veinte";
	  textoano[2021]="veintiuno";
	  textoano[2022]="ventidos";
	  textoano[2023]="ventitres";
	  textoano[2024]="venticuatro";
	  textoano[2025]="venticinco";
	
	doc.setFontSize(22);
	doc.text(40, 20, 'Programa +VALOR.Doc del CONICET');
	doc.text(60, 40, 'Convenio de Adhesion');
	
	doc.setFontSize(12);
	doc.text(20, 50, 'Entre el Consejo Nacional de Investigaciones Cientificas y Tecnicas, en adelante');	
	doc.text(20, 55, 'CONICET y '+document.getElementById("business_name").value+', en adelante '+usuario+', en el marco');	
	doc.text(20, 60, "del Programa +VALOR.Doc del CONICET 'Sumando Doctores al Desarrollo de");	
	doc.text(20, 65, "Argentina', acuerdan celebrar el presente convenio de");
	doc.text(20, 70, 'adhesion.----------------------------------------------------------------------------------------------');
	doc.text(20, 75, 'A tal efecto, el CONICET, con domicilio legal en Av. Rivadavia 1917, Ciudad');
	doc.text(20, 80, "del Programa +VALOR.Doc del CONICET 'Sumando Doctores al Desarrollo de");
	doc.text(20, 85, 'Autonoma de Buenos Aires y el '+usuario+', con domicilio legal en '+document.getElementById("street_name").value+' '+document.getElementById("street_number").value+',');
	doc.text(20, 90, 'representados respectivamente por su Presidenta Dra. Marta G. ROVIRA y su');
	doc.text(20, 95, 'XDirector EjecutivoX                   ,');
	doc.text(20, 100, 'acuerdan:---------------------------------------------------------------------------------------------');
	doc.text(20, 105, '');
	doc.text(20, 110, "PRIMERA: El Programa +VALOR.Doc 'Sumando Doctores al Desarrollo de");
	doc.text(20, 115, "Argentina' tiene como objetivo principal incrementar el aprovechamiento social del");
	doc.text(20, 120, 'conocimiento, promocionando y facilitando la insercion de doctores en el sector');
	doc.text(20, 125, 'productivo y de servicios, las universidades, la gestion publica y otros ambitos de la');
	doc.text(20, 130, 'sociedad.---------------------------------------------------------------------------------------------');
	doc.text(20, 135, '');
	doc.text(20, 140, 'SEGUNDA: A traves de su sitio Web el Programa +VALOR.Doc facilita el acceso y la');
	doc.text(20, 144, 'utilizacion de servicios y contenidos  relacionados con la busqueda de empleo  de');
	doc.text(20, 150, 'doctores, publicando ofertas de trabajo suministradas por empresas e instituciones');
	doc.text(20, 155, 'que deseen iniciar un proceso de seleccion e incorporacion de tales recursos');
	doc.text(20, 160, 'humanos.----------------------------------------------------------------------------------------------');
	doc.text(20, 165, '');
	doc.text(20, 170, 'TERCERA: El Programa +VALOR.Doc no interviene en la transaccion entre las');
	doc.text(20, 175, 'empresas/instituciones y los doctores. Por ello no puede garantizar la aptitud y');
	doc.text(20, 180, 'capacidad de los doctores para cubrir las vacantes. Ni tampoco asumira');
	doc.text(20, 185, 'responsabilidad sobre la autenticidad y actualidad de los datos consignados por los');
	doc.text(20, 190, 'doctores registrados en el Programa.------------------------------------------------------------------');
	doc.text(20, 195, '');
	doc.text(20, 200, 'CUARTA: La informacion que las empresas e instituciones oferentes de trabajo');
	doc.text(20, 205, 'registran en el sistema tiene caracter de declaracion jurada.');
	doc.text(20, 210, '');
	doc.text(20, 215, 'QUINTA: La empresa/institucion registrada autoriza expresamente al CONICET a');
	doc.text(20, 220, 'incorporar en el Sitio Web, a exclusivo criterio de este ultimo, su logo/marca de');
	doc.text(20, 225, 'titularidad con el unico fin de referenciar a dicho Usuario como participante del');
	doc.text(20, 230, 'Programa y usuario del sitio web. --------------------------------------------------------------------');
	
	doc.addPage();
	doc.text(20, 20, 'SEXTA: A partir de la suscripcion al presente convenio de adhesion la');
	doc.text(20, 25, 'empresa/institucion oferente de trabajo se compromete a informar de manera');
	doc.text(20, 30, 'fehaciente a los responsables del Programa en un termino de treinta (30) dias');
	doc.text(20, 35, 'sobre el avance de la busqueda,  el resultado de las entrevistas, o  la eventual');
	doc.text(20, 40, 'firma de un contrato de trabajo. Especificamente, se debera informar: 1) la');
	doc.text(20, 45, 'cantidad de postulantes que fueron entrevistados, del total de postulantes ofrecidos');
	doc.text(20, 50, 'por el Programa +VALOR.Doc; y 2) el resultado de dichas entrevistas, indicando si');
	doc.text(20, 55, 'alguno de los entrevistados ha obtenido el puesto, y quien.');
	doc.text(20, 60, '');
	doc.text(20, 65, 'SEPTIMA: El Programa +VALOR.Doc podra utilizar la informacion indicada en la');
	doc.text(20, 70, 'clausula quinta para dar publicidad/difusion y hacer publico el accionar y resultados');
	doc.text(20, 75, 'del Programa.------------------------------------------------------------------------------');
	doc.text(20, 80, '');
	doc.text(20, 85, 'OCTAVA: La utilizacion del servicio es gratuita, no correspondiendo percibir ni de la');
	doc.text(20, 90, 'empresa/institucion oferentes de trabajo, ni de los doctores demandantes de');
	doc.text(20, 95, 'trabajo, retribucion o costo alguno.------------------------------------------------------');
	doc.text(20, 100, '');
	doc.text(20, 105, 'NOVENA: La utilizacion del servicio en nombre de la empresa/institucion oferente');
	doc.text(20, 110, 'de trabajo, sera realizada por medio de un usuario y password asignado y');
	doc.text(20, 115, 'entregado por el CONICET.  La empresa/institucion oferente de trabajo es unica');
	doc.text(20, 120, 'responsable por el uso adecuado del sitio web, los privilegios otorgados y las');
	doc.text(20, 125, 'herramientas ofrecidas y el cumplimiento de los terminos y condiciones que preve');
	doc.text(20, 130, 'el sitio web del Programa.');
	doc.text(20, 135, '');
	doc.text(20, 140, 'DECIMA: El presente convenio entrara en vigor a partir de la fecha de su firma y');
	doc.text(20, 144, 'tendra vigencia indefinida, salvo que una de las partes comunicara a la otra su');
	doc.text(20, 150, 'decision de rescindirlo. En tal caso, debera notificarlo en forma fehaciente con');
	doc.text(20, 155, 'treinta (30) dias anticipacion a la fecha en que se pretende darle termino.-----------');
	doc.text(20, 160, '');
	doc.text(20, 165, 'DECIMO PRIMERA: Cualquier cuestion no prevista en el presente convenio o');
	doc.text(20, 170, 'diferencia entre las partes que surja de su aplicacion, sera resuelta por consenso');
	doc.text(20, 175, 'entre las partes. En caso de no ser posible arribar a un acuerdo, las partes se');
	doc.text(20, 180, 'someteran voluntariamente a la competencia de los Tribunales Federales de la');
	doc.text(20, 185, 'Capital Federal.');
	doc.text(20, 190, '');
	doc.text(20, 195, 'En prueba de conformidad se firman dos ejemplares de una mismo tenor y a un');
	doc.text(20, 200, 'solo efecto, en la Ciudad de Buenos Aires a los '+diames+' dias del mes de '+textomes[mes]);
	doc.text(20, 205, 'de dos mil '+textoano[ano]+'.----------------------------------------------------------------------------------');
	doc.text(20, 210, '');
	doc.text(20, 215, '');
	doc.text(20, 220, '');
	doc.text(20, 225, '');
	doc.text(20, 230, '');
	doc.setFontSize(16);
	 

	// Output as Data URI

	doc.output('datauri');
	} */
	
    var url_contrato =	encodeURI(base_url+'/wp-content/plugins/masvalor/app/includes/contracts/index.php?');
	var url_comp = 'business_name='+jQuery("#business_name").val()+'\u0026company_name='+jQuery("#company_name").val()+'\u0026company_address='+jQuery("#street_name").val()+' '+jQuery("#street_number").val()+' '+jQuery("#floor_number").val()+' '+jQuery("#department").val()+'\u0026job_charge='+jQuery("#manager_job_title").val()+'\u0026company_owner='+jQuery("#manager_name").val()+'\u0026state='+jQuery("#state").val()+'\u0026city='+jQuery("#city").val();
	window.open(url_contrato+url_comp);
	
} 

function gup( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}

function validateFields(){
    retorno = false;
    var msg = new Array();
	var error = false;

    if (jQuery("#company_name").val() == ""){
         msg.push("<?php echo __('Debe ingresar un nombre de fantas\u00eda.');?>");
		 error = true;
		 }
	if (jQuery("#business_name").val() == ""){
		 msg.push('<?php echo __('Debe ingresar una raz\u00f3n social.');?>');
		 error = true;
		 }
	if (!esCUITValida(jQuery("#cuit_number").val())){
		 msg.push('<?php echo __('Debe ingresar un n\u00famero de CUIT v\u00e1lido.');?>');
		 error = true;
		 }
    if (jQuery("#type_laborsector").val() == ''){
        msg.push('<?php echo __('Debe seleccionar un tipo de Empresa/Instituci\u00f3n.');?>');
		error = true;
		 }
	if (jQuery("#description").val() == ''){
        msg.push('<?php echo __('Debe ingresar una descripci\u00f3n.');?>'); 
		error = true;
		 }
	if (jQuery("#antiquity").val() == ''){
		msg.push('<?php echo __('Debe ingresar su antiguedad.');?>'); 
		error = true;
		 }
	if (jQuery("#street_name").val() == ''){
		msg.push('<?php echo __('Debe ingresar la calle de su domicilio.');?>'); 
		error = true;
		 }
	if(jQuery("#street_number").val() == '') {
			msg.push('<?php echo __('Debe ingresar el n\u00famero de calle de su domicilio.');?>'); 
			error = true;
		 }
	if (jQuery("#country").val() == ''){
		msg.push('<?php echo __('Debe ingresar un Pa\u00eds.');?>'); 
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
	if (jQuery("#cp").val() == ''){
		msg.push('<?php echo __('Debe ingresar su c\u00f3digo postal.');?>'); 
		error = true;
		 }
	if (jQuery("#main_contact_mail").val().indexOf('@', 0) == -1 || jQuery("#main_contact_mail").val().indexOf('.', 0) == -1){
		msg.push('<?php echo __('Debe ingresar un mail de contacto profesional v\u00e1lido.');?>'); 
		error = true;
		 }
	if (jQuery("#phone_numbers").val() == '') {
		msg.push('<?php echo __('Debe ingresar al menos un n\u00famero de telefono de contacto profesional v\u00e1lido.');?>'); 
		error = true;
		 }
	//Manager Validation
	if (jQuery("#manager_name").val() == ''){
		msg.push('<?php echo __('Debe ingresar el nombre del representante.');?>'); 
		error = true;
		 }
	if (jQuery("#manager_job_title").val() == ''){
		msg.push('<?php echo __('Debe ingresar el puesto del representante.');?>'); 
		error = true;
		 }
	if (jQuery("#manager_identity_type").val() == ''){
		msg.push('<?php echo __('Debe ingresar el tipo de identidad del representante.');?>'); 
		error = true;
		 }
	if (jQuery("#manager_identity_number").val() == '' || !validateNumber(jQuery("#manager_identity_number").val())){
		msg.push('<?php echo __('Debe ingresar el n\u00famero de identidad del representante.');?>'); 
		error = true;
		 }
	if (jQuery("#manager_mail").val().indexOf('@', 0) == -1 || jQuery("#manager_mail").val().indexOf('.', 0) == -1){
		msg.push('<?php echo __('Debe ingresar el mail de contacto del representante.');?>'); 
		error = true;
		 }
	if (jQuery("#manager_phone_numbers").val() == '' ) {
		msg.push('<?php echo __('Debe ingresar al menos un n\u00famero de telefono de contacto del representante.');?>'); 
		error = true;
		 }

		 
    if (error){
		alert(msg.join('\n'));
		return false;
		}
	else
		return true;
}

function submitForm(){
	if (validateFields()){
		document.getElementById('adminForm').task.value = 'save';
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
	});
}

function acceptCompany(){
	document.forms['adminForm'].task.value = 'accept';
	document.forms['adminForm'].submit(); 
}

function rejectCompany(){
	document.forms['adminForm'].task.value = 'reject';
	document.forms['adminForm'].submit(); 
}

function submitBack(){
	document.getElementById('adminForm').task.value = 'back';
	document.getElementById('adminForm').submit();
	
}

function write_mail() {
	var option_selected = jQuery("#actived");
	if(option_selected.val() == '3') {
	   var mail_text = prompt("Se le enviara un correo electronico al doctor notificandole el rechazo:","Escriba aqui el texto del mensaje...");
	   while(mail_text == null)
	       mail_text = prompt("Se le enviara un correo electronico al doctor notificandole el rechazo:","Escriba aqui el texto del mensaje...");
	   jQuery("#rejected").val(mail_text);
	} else if(option_selected.val() == '2') {
	   var mail_text = prompt("Se le enviara un correo electronico al doctor notificandole la desactivacion:","Escriba aqui el texto del mensaje...");
	   while(mail_text == null)
		   mail_text = prompt("Se le enviara un correo electronico al doctor notificandole la desactivacion:","Escriba aqui el texto del mensaje...");
	   jQuery("#desactived").val(mail_text) = mail_text;
	}
}

</script>

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



function esSelected($estado,$comparacion){   
    if ($estado == $comparacion){
       return $estado. ' selected';
    }  
    else return $estado;  
}


?>
<div class="message" style="margin-left:-10px;margin-bottom:20px;">
	 <h3 style="color:#ea0000"><?php  echo $V->msg ?></h3>
</div>

        <?php if ($V->isAdmin) { ?>
			<div style="float: right;margin-right: -30px;">
			   <!--a href="#" onclick="submitBack()"-->
			   <a href="javascript:history.back(1)">
					<img src="wp-content/themes/rollpix/images/headers/back.png">
			   </a>
			</div>
        <?php } ?>

<div id="table_noticia" style="font-size: 14px;margin-left: -13px;width: 679px;">

<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
					<h2><?php echo __('Registro de Empresas e Instituciones') ?></h2>
					<br/>
					<fieldset class="adminform" style="width: 100%;background-color: #fff;box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1) inset;color: #000000;">
						<table class="admintable" style="margin-left:37px;margin-top:15px;">
						
						 <fieldset>	
							
							
							<?php if ($V->isAdmin) {
							    if(masvalor_StateCompanyAdmin($V->data->userid)== 0){ ?>
                                    <tr>
										<td class="key"><?php echo __('Estado'); ?></td>
										<td>
											<select name="actived"  id="actived" onchange="write_mail()">
												<option value=<?php echo esSelected("0",$V->data->actived)?> > <?php echo __('Pendiente'); ?> </option>
												<option value=<?php echo esSelected("1",$V->data->actived)?> > <?php echo __('Activada'); ?> </option>
												<option value=<?php echo esSelected("3",$V->data->actived)?> > <?php echo __('Rechazada'); ?> </option>
											</select>
										</td>	
									</tr>
										
							   <?php }else{ ?>
										<?php if(masvalor_StateCompanyAdmin($V->data->userid)== 1){ ?>    
											<tr>
												<td class="key"><?php echo __('Estado'); ?></td>
												<td>
													<select name="actived" id="actived" onchange="write_mail()">
														<option value=<?php echo esSelected("1",$V->data->actived)?> > <?php echo __('Activada'); ?> </option>
														<option value=<?php echo esSelected("2",$V->data->actived)?> > <?php echo __('Desactivada'); ?> </option>
													</select>
																			 
												</td>	
											</tr> 
										<?php }else{ ?>   
										        <?php if(masvalor_StateCompanyAdmin($V->data->userid)== 2){ ?> 
										            <tr>
														<td class="key"><?php echo __('Estado'); ?></td>
															<td>
																<select name="actived" id="actived" onchange="write_mail()">
																	<option value=<?php echo esSelected("2",$V->data->actived)?> > <?php echo __('Desactivada'); ?> </option-->
																	<option value=<?php echo esSelected("1",$V->data->actived)?> > <?php echo __('Activada'); ?> </option>
																</select>
															</td>	
													</tr>
										 									 
	                                            <?php }else{ ?>  
													
													<tr>
														<td class="key"><?php echo __('Estado'); ?></td>
															<td>
																<select name="actived" id="actived" onchange="write_mail()">
																	<option value=<?php echo esSelected("3",$V->data->actived)?> > <?php echo __('Rechazada'); ?> </option>
																	<option value=<?php echo esSelected("0",$V->data->actived)?> > <?php echo __('Pendiente'); ?> </option>
																</select>
															</td>	
													</tr>
										 		<?php } ?>

										<?php } ?>	
							   <?php } ?>
							<?php } ?>
							
							<?php if ($V->isAdmin) {?>
							    <tr>
									<td class="key"><?php echo __('Nombre de usuario') ?>(*)</td>
									<td><input class="text_area" type="text" name="username_admin" size="33" id="username_admin" value="<?php echo $V->data->user_login ?>" /></td>
								</tr>
							
								<tr>
									<td class="key"><?php echo __('Contrase&ntilde;a') ?>(en blanco no cambia)</td>
									<td style="padding-left:3px;"><input class=" text_area" type="password" name="password_admin" size="33" id="password_admin" value=""/></td>
								</tr>
							
															
							<?php } ?>
							
							<tr>
							    <td>
								   <div  style="margin-top:10px;"/>
								</td>
							<tr>
							
							<tr>
								<td class="key"><?php echo __('Nombre') ?>(*)</td>
								<td><input class="text_area" type="text" name="company_name" size="33" id="company_name" value="<?php echo $V->data->name ?>" /></td>
								
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Raz&oacute;n Social') ?>(*)</td>
								<td><input class="text_area" type="text" name="business_name" size="33" id="business_name" value="<?php echo $V->data->business_name ?>" /></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('CUIT') ?>(*)</td> 
								<td><input class="text_area" type="text" name="cuit_number" size="33" id="cuit_number" value="<?php echo $V->data->cuit_number ?>" /> (sin guiones)</td>
							</tr>
															
							
							<tr>
								<td class="key"><?php echo __('Tipo de Empresa/Instituci&oacute;n') ?>(*)</td>
								
								<td><?php echo $V->combos->getLaborSectors('type_',getSelectedLaborSector($V->data),'type_laborsector')?></td>	
							</tr>
														
							<tr>
								<td class="key" style="vertical-align:top;"><?php echo __('Marcas y/o productos m&aacute;s conocidos') ?></td>
								<td><textarea class="text_area" rows="4" cols="100" name="marks_and_products" id="marks_and_products"  size="30" maxlength="1000" style="height: 111px;width: 250px;" /><?php echo $V->data->marks_and_products ?></textarea></td>
							</tr>
							
							<tr>
								<td class="key" style="padding-bottom: 96px;vertical-align:top;"><?php echo __('Descripci&oacute;n Empresa/Instituci&oacute;n') ?>(*)</td>
								<td><textarea class="text_area" rows="4" cols="100%" name="description" id="description"  size="33" maxlength="1000" style="height: 111px;width: 250px;" /><?php echo $V->data->description ?></textarea></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Cantidad de sucursales o dependencias') ?></td>
								<td><input class="required text_area" type="text" name="amount_branch"  size="4" id="amount_branch" value="<?php echo $V->data->amount_branch ?>" /></td>
							</tr>
						    
							
							<tr>
								<td class="key"><?php echo __('Antig&uuml;edad') ?>(*)</td>
								<td><?php echo $V->combos->getAntiquities($V->data->antiquity,'antiquity').__('(en a&ntilde;os)')?></td>
							</tr>
							
							
							<tr>
								<td class="key"><?php echo __('Calle') ?>(*)</td>
								<td><input class="required text_area" type="text" name="street_name"  size="33" id="street_name" value="<?php echo $V->data->street_name ?>" /></td>
							</tr>
							
							<tr>	
								<td class="key"><?php echo __('Nro.') ?>(*)</td>
								<td>
									<div style="float:left;">
										<input class="required text_area" type="text" name="street_number"  size="5" id="street_number" value="<?php echo $V->data->street_number ?>" />
									</div>
								
									<div style="float: left;margin-left: 8px;margin-right: 7px;margin-top: 7px;"><?php echo __('Piso') ?></div>
									<div style="float:left;">	
										<input class="text_area" type="text" name="floor_number"  size="5" id="floor_number" value="<?php echo $V->data->floor_number ?>" />
									</div>
									
									<div style="float: left;margin-left: 8px;margin-right: 7px;margin-top: 7px;"><?php echo __('Dpto.') ?></div>
									<div style="float:left;margin-left: 236px;margin-top: -31px;">	
										<input class="text_area" type="text" name="department"  size="5" id="department" value="<?php echo $V->data->department_number ?>" />
									</div>
								
								</td>
							
							</tr>
							
							<tr>							
								<td class="key"><?php echo __('CP') ?>(*)</td>
								<td><input class="required text_area" type="text" name="cp"  size="20" id="cp" value="<?php echo $V->data->postal_code ?>" /></td>
								
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Pa&iacute;s') ?>(*)</td>
								<td><?php echo $V->combos->getCountries($V->data->country,'country') ?></td>
								
							</tr>
							
							
							
							<tr>
								<td class="key"><?php echo __('Provincia') ?>(*)</td>
								<td id="stateContainer" ><?php echo $V->combos->getStates($V->data->state,$V->data->country,'state') ?></td>
								<!--td><input class="required text_area" type="text" name="state"  size="35" id="state" value="<?php echo $V->data->state ?>" /></td-->
							</tr>
							
							<tr>							
								<td class="key"><?php echo __('Localidad') ?>(*)</td>
								<td id="cityContainer"><?php echo $V->combos->getCities($V->data->city,$V->data->country,$V->data->state,'city') ?></td>
								<!--td><input class="required text_area" type="text" name="city"  size="35" id="city" value="<?php echo $V->data->city ?>" /></td -->
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Mail Principal') ?>(*)</td>
								<td><input class="text_area" type="text" name="main_contact_mail" size="33" id="main_contact_mail" value="<?php echo $V->data->main_contact_mail ?>" /></td>
							</tr>
								 
							<tr>
								<td class="key"><?php echo __('Mail Alternativo') ?></td>
								<td><input class="text_area" type="text" name="optional_contact_mail" size="33" id="optional_contact_mail" value="<?php echo $V->data->optional_contact_mail ?>" /></td>
							</tr>							
							
							<tr>
								<td class="key"><?php echo __('Tel&eacute;fono Fijo '); ?>(*)</td>
								<td><input class="text_area" type="text" onchange="setNeedUpdate()" name="phone_numbers"  size="33" id="phone_numbers" value="<?php echo $V->data->phone_numbers ?>" /></td>	
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Tel&eacute;fono Celular'); ?></td>
								<td><input class="text_area" type="text" onchange="setNeedUpdate()" name="cell_numbers"  size="33" id="cell_numbers" value="<?php echo $V->data->cell_numbers ?>" /></td>	
							</tr>
							
							<!--
							<tr>
								<td class="key" style="vertical-align:top;"><?php echo __('Tel&eacute;fonos') ?>(*)</td>
								<td><textarea class="text_area" rows="4" cols="100%" name="phone_numbers" id="phone_numbers"  size="33" maxlength="150" style="height: 111px;width: 250px;" /><?php echo $V->data->phone_numbers ?></textarea></td>
							</tr>
							-->	 
							
							</table>
							
							<table class="admintable" style="margin-left:37px;margin-top:15px;">
													
												
							<hr style="margin-top:30px; margin-bottom:22px;"/>	
							
							<h2 style="font-size:16px;text-align:left;margin-bottom: 22px;margin-left:15px;"><?php echo __('Datos del Representante') ?></h2>	

										
							<tr>
								<td class="key"><?php echo __('Nombre') ?>(*)</td>
								<td><input class="text_area" type="text" name="manager_name" size="35" id="manager_name" value="<?php echo $V->data->manager_name ?>" /></td>
							</tr>
						
							<tr>
								<td class="key"><?php echo __('Puesto') ?>(*)</td>
								<td><input class="text_area" type="text" name="manager_job_title" size="35" id="manager_job_title" value="<?php echo $V->data->manager_job_title ?>" /></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Tipo documento') ?>(*)</td>
								<td><?php echo $V->combos->getIdentityTypes($V->data->manager_identity_type,'manager_identity_type')?></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Documento') ?>(*)</td>
								<td><input class="text_area" type="text" name="manager_identity_number"  size="35" id="manager_identity_number" value="<?php echo $V->data->manager_identity_number ?>" /></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Mail') ?>(*)</td>
								<td><input class="text_area" type="text" name="manager_mail" size="35" id="manager_mail" value="<?php echo $V->data->manager_mail ?>" /></td>
							</tr>
							
							
							<tr>
								<td class="key" style="padding-bottom: 84px;vertical-align:top;"><?php echo __('Tel&eacute;fonos') ?>(*)</td>
								<td><textarea class="text_area" rows="4" cols="100%" name="manager_phone_numbers" id="manager_phone_numbers"  size="35" maxlength="150" style="height: 110px;width: 266px;" /><?php echo $V->data->manager_phone_numbers ?></textarea></td>
							</tr>
													
							
							<tr>                                    	
								<td style="padding-bottom: 20px;padding-left: 20px;padding-top: 20px;">
								<input id="save" onclick="submitForm();" type="button"  value ="<?php echo __('Guardar') ?>"/></td>
							</tr>
							
							<tr>                                    	
								<td style="padding-bottom: 20px;padding-left: 20px;padding-top: 20px;">
								
							</tr>
							<tr>
							     <td class="key" style="vertical-align:top; padding-top: 0px;"><input type="button" id="pdfcreate" onclick='get_pdf("<?php echo home_url(); ?>");'   value ="<?php echo __('Imprimir convenio') ?>"/></td>
								 <td><div style="float: left;margin-left: -32px;margin-top: 2px;">
									<!--img src="wp-content/plugins/masvalor/app/includes/image/save-pdf.png"></a-->
									 </div>
									 <div style="float: left;margin: 0 34px 19px 30px;font-size:10px;">			
										<?php echo __('(Descargue e imprima el siguiente contrato de participaci&oacute;n en el programa +VALOR.Doc y env&iacute;e una copia firmada a la Secretar&iacute;a Ejecutiva del Programa.')?>)
									  </div>
								 </td>
						
						        </tr>

						</fieldset>	
						
						</table>
						
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>		
	<input id="userid" type="hidden"  name="userid" value ="<?php echo $V->userid?>"/>
	<input id="task" type="hidden"  name="task" value =""/>
	<input type="hidden" id="rejected" name="rejected" value =""/>
	<input type="hidden" id="desactived" name="desactived" value =""/>

</form>
</div>
