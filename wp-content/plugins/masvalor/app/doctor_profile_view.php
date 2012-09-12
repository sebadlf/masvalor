<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />

	<link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/columnas.css" type="text/css" />

    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/estilos.css" type="text/css" />

    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/pestanas_validate.js"></script>
     
	 <!--
    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
	
	
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">
	
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

#title{
  width: 175px; /* ancho que necesitas */
  /*height:50px;*/
  overflow: hidden;
  -o-text-overflow: ellipsis; /* para versiones de Opera inferiores a la 11*/
  -ms-text-overflow: ellipsis; /* para IE8*/
  white-space: -moz-pre-wrap; /* Mozilla */
  white-space: -hp-pre-wrap; /* HP printers */
  white-space: -o-pre-wrap; /* Opera 7 */
  white-space: -pre-wrap; /* Opera 4-6 */
  white-space: pre-wrap; /* CSS 2.1 */
  white-space: pre-line; /* CSS 3 (and 2.1 as well, actually) */
  word-wrap: break-word; /* IE */
  -moz-binding: url('xbl.xml#wordwrap'); /* Firefox (using XBL) */
  -moz-binding: url( 'bindings.xml#ellipsis' ); 
  margin-top: 0;
  text-overflow: ellipsis;
  
}

#title3{
  width: 175px; /* ancho que necesitas */
  overflow: hidden;
  -o-text-overflow: ellipsis; /* para versiones de Opera inferiores a la 11*/
  -ms-text-overflow: ellipsis; /* para IE8*/
  white-space: nowrap; /* Mozilla */
  white-space: -hp-pre-wrap; /* HP printers */
  white-space: -o-pre-wrap; /* Opera 7 */
  white-space: -pre-wrap; /* Opera 4-6 */
  white-space: nowrap; /* CSS 2.1 */
  white-space: nowrap; /* CSS 3 (and 2.1 as well, actually) */
  word-wrap: break-word; /* IE */
  -moz-binding: url('xbl.xml#wordwrap'); /* Firefox (using XBL) */
  -moz-binding: url( 'bindings.xml#ellipsis' ); 
  margin-top: 0;
  text-overflow: ellipsis;
  
}


#title2{
  width: 100px; 
  /*height:50px;*/
  overflow: auto;
  text-overflow: ellipsis;
  -o-text-overflow: ellipsis; /* para versiones de Opera inferiores a la 11*/
  -ms-text-overflow: ellipsis; /* para IE8*/
  white-space: -moz-pre-wrap; /* Mozilla */
  white-space: -hp-pre-wrap; /* HP printers */
  white-space: -o-pre-wrap; /* Opera 7 */
  white-space: -pre-wrap; /* Opera 4-6 */
  white-space: pre-wrap; /* CSS 2.1 */
  white-space: pre-line; /* CSS 3 (and 2.1 as well, actually) */
  word-wrap: break-word; /* IE */
  -moz-binding: url('xbl.xml#wordwrap'); /* Firefox (using XBL) */
}
</style>
	

<script>
/*$(function() {
    // Check if the browser supports the date input type
    if (!Modernizr.inputtypes.date){
        // Add the jQuery UI DatePicker to all
        // input tags that have their type attributes
        // set to 'date'
        $('input[type=date]').datepicker({
            // specify the same format as the spec
            dateFormat: 'yy-mm-dd'
        });
    }
});*/
</script>
	
 

<script language="JavaScript">
	
jQuery(document).ready(function($){

	if(jQuery("#identity_number").val() == ""){
		
		var country_combo = document.forms["adminForm"].country;
		var quantity = country_combo.length;
		for(i=0;i<quantity;i++) 
			if(country_combo[i].value == "Argentina")
				country_combo[i].selected = true; 
		
		refreshStates();
    }
  

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
  if(confirm("\u00BFEst\u00e1 seguro que quiere eliminar?")) { 
	var child = document.getElementById(anItem);
	var parent = child.parentElement;
	parent.removeChild(child);
	need_update = 1;
  }
}

var activeModal = null;

 function show_popup_education() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_education.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="270" width="750" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:274,
		padding:0,
		width:750,
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

/* function write_mail(what_check) {
	var check_box = jQuery("#"+what_check);
	if(check_box.attr("checked") == true) {
		if(what_check == 'rejected') {
			var mail_text = prompt("Se le enviara un correo electronico al doctor notificandole el rechazo:","Escriba aqui el texto del mensaje...");
			while(mail_text == null)
				mail_text = prompt("Se le enviara un correo electronico al doctor notificandole el rechazo:","Escriba aqui el texto del mensaje...");
			jQuery("#rejected_mail").val(mail_text);
		} else if(what_check == 'desactived') {
			var mail_text = prompt("Se le enviara un correo electronico al doctor notificandole la desactivacion:","Escriba aqui el texto del mensaje...");
			while(mail_text == null)
				mail_text = prompt("Se le enviara un correo electronico al doctor notificandole la desactivacion:","Escriba aqui el texto del mensaje...");
			jQuery("#desactived_mail").val(mail_text);
		} else if(what_check == 'pending') {
			var mail_text = prompt("Se le enviara un correo electronico al doctor notificandole que vuelve a estar pendiente:","Escriba aqui el texto del mensaje...");
			while(mail_text == null)
				mail_text = prompt("Se le enviara un correo electronico al doctor notificandole que vuelve a estar pendiente:","Escriba aqui el texto del mensaje...");
			jQuery("#pending_mail").val(mail_text);
		}
	}
}  */

function show_popup_education_post() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_education_pos.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="290" width="750" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:294,
		padding:0,
		width:750,
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
    activeModal = jQuery.modal('<iframe src="' + src + '" height="330" width="650" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
	
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:334,
		padding:0,
		width:650,
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
    activeModal = jQuery.modal('<iframe src="' + src + '" height="360" width="650" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:364,
		padding:0,
		width:650,
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

function validate_dates(begin_date,finish_date) {
	var begin = begin_date.split("-");
	var end = finish_date.split("-");
	
	begin_date = begin[2]+'-'+begin[1]+'-'+begin[0];
	finish_date = end[2]+'-'+end[1]+'-'+end[0];
	
	if(begin_date < finish_date)
		return true;
	else {
		alert('La fecha inicial siempre debe ser menor que la fecha final.');
		return false;
	}
}

function show_popup_diciplines() {
	var src = "wp-content/plugins/masvalor/app/includes/popups/popup_disciplines.php";
    activeModal = jQuery.modal('<iframe src="' + src + '" height="180" width="540" style="border:0">', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:184,
		padding:0,
		width:540
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

var normalize = (function() {
  var from = "??????????????????????????????????????????????",

      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );
 
  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' );
  }
 
})();

function removeDoctorTitle(type) {
	if(type == 'doctor')
		document.getElementById('have_doctor_title').value = '';
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

function addEducation(title,university,from,to,universityid,stateValue){
		title2= title.replace(/^\s+|\s+$/g, '');
		var fields = title2 + '{*}' + universityid + '{*}' + from + '{*}' + to + '{*}' + stateValue;
		if (stateValue == 1)
			state='<?php echo __('Completo') ?>';
		else
			state='<?php echo __('Incompleto') ?>';
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
  			  			  	  
  			newElem2 = "<tr id='"+id+"' >";
  			newElem2 += "<td id='title'>"+title2+"</td>";
  			newElem2 += "<td>"+university+"</td>"; 
  			newElem2 += "<td>"+from+"</td>";
			newElem2 += "<td>"+to+"</td>";
			newElem2 += "<td>"+state+"</td>";
  			newElem2 += "<input type='hidden'  name='titles[]' value='"+fields+"' />";
  			newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
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

function addEducationPos(title,university,from,to,universityid,stateValue,type_title){
        title2= title.replace(/^\s+|\s+$/g, '');
		var state;
		var ppal = 0;
		
		if(type_title == 'doctor') {
			document.getElementById('have_doctor_title').value = 'true';
			ppal = 1;
		}
		
		var fields = title2 + '{*}' + universityid + '{*}' + from + '{*}' + to + '{*}' + stateValue + '{*}' + type_title + '{*}' + ppal;
		
		if (stateValue == 1)
			state='<?php echo __('Completo') ?>';
		else
			state='<?php echo __('Incompleto') ?>';
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
  			  			  	  
  			newElem2 = "<tr id='"+id+"' >";
  			newElem2 += "<td id='title'>"+title2+"</td>";
  			newElem2 += "<td>"+university+"</td>"; 
			newElem2 += "<td>"+type_title+"</td>"; 
  			newElem2 += "<td>"+from+"</td>";
			newElem2 += "<td>"+to+"</td>";
			newElem2 += "<td>"+state+"</td>";
  			newElem2 += "<input type='hidden' name='titlesPos[]' value='"+fields+"' />";
  			newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\");removeDoctorTitle(\""+type_title+"\");' style='cursor:pointer'>X</td>";
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

function addTesis(title,theme,publication_date,file,fileName,link,disciplineid,disciplinename,defense_file,defense_file_name,link_defense,fileExist){
		title2= title.replace(/^\s+|\s+$/g, '');
		var fields = title2 + '{*}' + theme + '{*}' + publication_date + '{*}' + fileName + '{*}' + disciplineid + '{*}' + defense_file_name + '{*}' + fileExist + '{*}' + link + '{*}' + link_defense;
		var newFileInput = document.createElement("input"); 
		var newDefenseFileInput = document.createElement("input");
		var id = title.split(' ').join('');
		if ( document.getElementById(id) == null){
			if (file != null) { 
				newFileInput = file;
			} else { 
				newFileInput.type = 'file';
			}
			if(defense_file != null) {
				newDefenseFileInput = defense_file;
			} else {
				newDefenseFileInput.type = 'file';
			}
			newElem2 = "<tr id='"+id+"' >";
			if (link != null)
				newElem2 += "<td><a target='_blank' href='"+link+"'><p id='title3' title='"+title2+"'>"+title2+"</p></a></td>";
			else
				newElem2 += "<td><p id='title3'>"+title2+"</p></td>";
			if(link_defense != null)
				newElem2 += "<td id='title3'><a target='_blank' href='"+link_defense+"'>"+defense_file_name+"</a></td>";
			else
				newElem2 += "<td id='title3'>"+defense_file_name+"</td>";
			newElem2 += "<td>"+theme+"</td>"; 
			newElem2 += "<td>"+publication_date+"</td>"; 
			newElem2 += "<td>"+disciplinename+"</td>"; 
			newElem2 += "<input type='hidden' name='tesis[]' value='"+fields+"' />";
			newElem2 += "<td class='deleteDiv'  onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
			newElem2 += "</tr>";
			jQuery("#tableSelectedTesis").append(newElem2);
			newFileInput.style.display = "none";
			newDefenseFileInput.style.display = "none";
			newDefenseFileInput.name = 'defensefiles[]';
			newFileInput.name = 'tesisfiles[]';
			document.getElementById(title.split(' ').join('')).appendChild(newFileInput);
			document.getElementById(title.split(' ').join('')).appendChild(newDefenseFileInput);
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
			newElem2 += "<td id='title'>"+company+"</td>";
			newElem2 += "<td id='title'>"+jobTitle+"</td>"; 
			newElem2 += "<td>"+area+"</td>"; 
			newElem2 += "<td>"+fromDate+"</td>"; 
			newElem2 += "<td>"+toDate+"</td>"; 
			newElem2 += "<input type='hidden' name='experiences[]' value='"+fields+"' />'";
			newElem2 += "<td class='deleteDiv'  onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
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
			newElem2 += "<td class='deleteDiv' onclick='removeThis(\""+id+"\")' style='cursor:pointer'>X</td>";
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
    activeModal =jQuery.modal('<iframe src="' + src + '" height="240" width="380" style="border:0"></iframe>', {
	opacity:80,
	overlayCss: {backgroundColor:"#000"},
	closeHTML:"",
	containerCss:{
		backgroundColor:"#fff",
		borderColor:"#fff",
		height:244,
		padding:0,
		width:384,
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

		if (jQuery("#cuit").val() == ""){
			 msg.push('<?php echo __('Debe ingresar el nro de CUIT.');?>');
			 error = true;
			 }

		if ( jQuery("#birth_date").val() == '' ){ 
			 msg.push('<?php echo __('Debe ingresar su Fecha de Nacimiento.');?>');
			 error = true;
			 }
		
		if ( !validar() ){ 
			 msg.push('<?php echo __('Debe ingresar su Fecha de Nacimiento formateada dd-mm-aaaa.');?>');
			 error = true;
			 }		
			 
				 
		if (jQuery("#gender").val() == ''){
			msg.push('<?php echo __('Debe seleccionar un G\u00e9nero.');?>');
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
		if (!validateNumber(jQuery("#street_number").val()) || jQuery("#street_number").val() == ''){
			msg.push('<?php echo __('Debe ingresar el n\u00famero de calle de su domicilio.');?>'); 
			error = true;
			 }
		if (jQuery("#cv_file").val().indexOf("ñ") != -1){
			msg.push('<?php echo __('El servidor no permite subir archivos cuyos nombres contengan caracteres raros.');?>'); 
			error = true;
			 }				 
		if (jQuery("#identity_type").val() == ''){
			msg.push('<?php echo __('Debe seleccionar un Tipo de identidad.');?>'); 
			error = true;
			 }
		if ( !validateNumber(jQuery("#identity_number").val()) || jQuery("#identity_number").val() == ''){
			msg.push('<?php echo __('Debe ingresar un N\u00famero de identidad v\u00e1lido.');?>'); 
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
		if (jQuery("#postal_code").val() == ''){
			msg.push('<?php echo __('Debe ingresar su C\u00f3digo postal.');?>'); 
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
		
		if(jQuery("#main_contact_mail").val().indexOf('@', 0) == -1 || jQuery("#main_contact_mail").val().indexOf('.', 0) == -1){
			msg.push('<?php echo __('Debe ingresar una direcci\u00f3n de email v\u00e1lida.');?>'); 
			error = true;
			 }
		if (!validatePhone(jQuery("#phone_numbers").val()) || jQuery("#phone_numbers").val() == '')
			if ( jQuery("#phone_numbers").val() == '' ){
				msg.push('<?php echo __('Debe ingresar al menos un n\u00famero de tel\u00e9fono de contacto profesional v\u00e1lido.');?>'); 
				error = true;
			 }
		if ( jQuery("#marital_status").val() == '' ){
			msg.push('<?php echo __('Debe seleccionar su estado civil.');?>'); 
			error = true;
			 }

		var str = jQuery("#identity_image_file").val();
		if (str.indexOf("ñ") != -1){
			msg.push('<?php echo __('El nombre de los archivos a subir no pueden contener caracteres raros.');?>'); 
			error = true;
			 }		

		var str = jQuery("#cv_file").val();
		if (str == ''){
			if (jQuery("#cv").val() == ''){
				msg.push('<?php echo __('Debe agregar un archivo de CV.');?>'); 
				error = true;
			}
			
		} else if (str.indexOf("ñ") != -1){
			msg.push('<?php echo __('El nombre del CV archivos no puede contener caracteres raros.');?>'); 
			error = true;
		}		
		
		if (jQuery("#tableSelectedTesis tbody").html().length <= 100){
			msg.push("<?php echo __('Debe ingresar al menos una Tesis de Postgrado (Datos Personales).');?>");
			error = true;
		}
			 
			
		if (error){
			alert(msg.join('\n'));
			return false;
			}
		else
			return true;
	} else if(step == 'step2') { 

		error = false;
		
		if(jQuery("#tableSelectedEducationPos").html().length > 428) {
			var have_doctor_title = document.getElementById('have_doctor_title');
			
			if(have_doctor_title.value != 'true') {
				msg.push('<?php echo __('Al menos un t\u00edtulo de postgrado tiene que ser de tipo doctor.');?>'); 
				error = true;
			}
			
			if ($("input[name=ppal_disc]:checked").size() != 1) {
				msg.push("<?php echo __('Debe elegir una disciplina principal.');?>");
				error = true;
			}
	
		}

		if (jQuery("#tableSelectedTesis tbody").html().length <= 100){
			msg.push("<?php echo __('Debe ingresar al menos una Tesis de Postgrado.');?>");
			error = true;
		}
		
		if(error) {
			alert(msg.join('\n'));
			return false;
		}
	} else {

		if (jQuery("#tableSelectedTesis tbody").html().length <= 100){
			msg.push("<?php echo __('Debe ingresar al menos una Tesis de Postgrado (Datos Personales).');?>");
			error = true;
		}
		
		if (isNaN(jQuery("#expected_gross_mensual_remuneration").val())){
			msg.push('<?php echo __('El campo remuneracion es numerico.');?>'); 
			error = true;
		}
		if(error) {
			alert(msg.join('\n'));
			return false;
		}
	}
	return true;
}

function submitForm(step){
	if (validateFields(step)){
		if(confirm("¿Est\u00e1 seguro que quiere guardar los cambios?")) {  

		document.getElementById('adminForm').task.value = 'save';
		document.getElementById('adminForm').step.value = step;
		document.getElementById('adminForm').submit();
		}
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

function submitBack(from_doctors){
	if(from_doctors == 'false') {
		history.back();
	} else {
		document.getElementById('adminForm').task.value = 'back';
		document.getElementById('adminForm').submit();
	}
}


 function validar()
 {
 	var aux = document.getElementById("birth_date").value;
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

function esSelected($estado,$comparacion){   
    if ($estado == $comparacion){
       return $estado. ' selected';
    }  
    else return $estado;  
}

function give_me_doctor_state($id_doctor) {
	global $wpdb;
	$sql_query = 'select actived from wp_masvalor_profiles where userid='.$id_doctor;
	
	return $wpdb->get_var($sql_query);
}

?>



<div id="table_noticia" style="font-size: 14px;margin-left: -82px;width: 770px;">

<input type="hidden" name="have_doctor_title" id="have_doctor_title" value="" />

<div class="message" style="margin-left:8px;margin-bottom:20px;">
	 <h3 style="color:#ea0000"><?php  echo $V->msg ?></h3>
</div>
			<?php if ($V->isAdmin) { ?>
			
				<div style="float: right;margin-right: 26px;">
					<a href="#" onclick="submitBack('<?php echo $_GET["fromdoctors"]; ?>')">
						<img src="wp-content/themes/rollpix/images/headers/back.png">
					</a>
				</div>
				
             <?php } ?>
				
<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
       			    <h2 style="margin-left: 61px;"><?php echo __('Registro de Doctores'); ?></h2>
					<br/>
					<fieldset class="adminform" style="margin-left: 56px;width: 90%;background-color: #ffffff;font-family:Verdana,arial,helvetica;"">

						  <ul class="tabs">
							<li><a name="tab1" href="#tab1"><?php echo __('Datos Personales'); ?></a></li>                
							<li><a name="tab2" href="#tab2"><?php echo __('Datos Profesionales'); ?></a></li>
							<li><a name="tab3" href="#tab3"><?php echo __('Preferencias Laborales'); ?></a></li>
						  </ul>
              
							<div class="tab_container2" id="tab_container">  
              
							  <!--Pestana1-->
								<div id="tab1" class="tab_content">
								<!--Contenido del bloque de texto-->
									<div id="datos">                                    
										<div id="datosgenerales">
											<div class="ClaseColumna" style="width:100%">
												<div class="Columna" id="Columna1">						
													
													<!--div class="Separator"></div-->
													
													<div id="Cont1">
															<table class="admintable" style="font-size:11px">
																
																<tr>                                    	
																	<td style="padding-bottom: 20px;">
																</tr>
																
																<?php /* ?>
																<tr>
																	<td class="key"><?php echo __('Nombre'); ?>(*)</td>
																	<td><input class="text_area" onchange="setNeedUpdate()" type="text" name="doctor_name" size="33" id="doctor_name" value="<?php echo checkSubmited($V->data,'name','doctor_name') ?>" /></td>
																	<?php if ($V->isAdmin && $V->data->actived == 0 ) {?>
																	<td class="key"><?php echo __('Activar'); ?></td>
																	<td><input style="margin-left:15px;" type="checkbox" value="<?php echo __('Activar'); ?>" onclick="acceptDoctor()" /></td>	
																																		
																	<?php } ?>
																	<?php if ($V->isAdmin && $V->data->actived == 1 ) {?>
																	<td class="key"><?php echo __('Desactivar'); ?></td>
																	<td><input type="checkbox" style="margin-left:15px;" checked="checked" value="<?php echo __('Desactivar'); ?>" onclick="rejectDoctor()" /></td>	
																																		
																	<?php } ?>
																</tr>
																<?php */ ?>
																
																<tr>
																	<td class="key"><?php echo __('Nombre'); ?>(*)</td>
																	<td><input class="text_area" onchange="setNeedUpdate()" type="text" name="doctor_name" size="33" id="doctor_name" value="<?php echo checkSubmited($V->data,'name','doctor_name') ?>" /></td>
																	
																	
																	
							<?php if ($V->isAdmin) { ?>
                                    <tr>
										<td class="key"><?php echo __('Estado'); ?></td>
										<td>
											<select name="actived"  id="actived" onchange="write_mail()">
												<option value=<?php echo esSelected("0",$V->data->actived)?> > <?php echo __('Pendiente'); ?> </option>
												<option value=<?php echo esSelected("1",$V->data->actived)?> > <?php echo __('Activado'); ?> </option>
												<option value=<?php echo esSelected("2",$V->data->actived)?> > <?php echo __('Desactivado'); ?> </option>
												<option value=<?php echo esSelected("3",$V->data->actived)?> > <?php echo __('En carencia'); ?> </option>
												<option value=<?php echo esSelected("4",$V->data->actived)?> > <?php echo __('Rechazado'); ?> </option>
											</select>
										</td>	
									</tr>
									
							<?php } ?>
																	
																</tr>
																


																<tr>
																	<td class="key"><?php echo __('Apellido'); ?>(*)</td>
																	<td><input class="text_area" onchange="setNeedUpdate()" type="text" name="lastname" size="33" id="lastname" value="<?php echo checkSubmited($V->data,'lastname') ?>" /></td>
																</tr>
																
																<?php if ($V->isAdmin) {?>
																<tr>
																	<td class="key"><?php echo __('Nombre de usuario'); ?>(*)</td>
																	<td><input class="text_area" type="text" name="username_admin" id="username_admin" value="<?php echo checkSubmited($V->data,'user_login','user_login'); ?>"/></td>
																</tr>
																<tr>
																	<td class="key"><?php echo __('Contrase&ntilde;a'); ?>(en blanco no cambia)</td>
																	<td><input class="text_area" type="text" name="password_admin" id="password_admin" value=""/></td>
																</tr>
																<?php } ?>
																
																<?php
																	if($V->data->birth_date != NULL) {
																		$date2 = explode("-",$V->data->birth_date);
																		$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
																	}
																	?>
																
																<tr>
																	<td class="key"><?php echo __('Fecha Nacimiento'); ?>(*)</td>                                              <?php //echo checkSubmited($V->data,'birth_date') ?>
																	 <td><input type="text" name="birth_date" id="birth_date"  onchange="setNeedUpdate()" class="tcal" value="<?php echo $dateend; ?>" />
																	 (dd-mm-aaaa)
																	 </td>																 
																</tr>
																
																
																<tr>
																	<td class="key"><?php echo __('G&eacute;nero'); ?>(*)</td>
																	<td><?php echo $V->combos->getGenders(false,checkSubmited($V->data,'gender'),'gender') ?></td>
																	<script>
																		jQuery('#gender').change = setNeedUpdate;
																	</script>
																</tr>	
																					
																<tr>
																	<td class="key"><?php echo __('CUIL'); ?>(*)</td>
																	<td><input class="required text_area" onkeyup="this.value=this.value.replace(/[^\d]/,'')" onchange="setNeedUpdate()" type="text" name="cuit"  size="33" id="cuit" value="<?php echo checkSubmited($V->data,'cuit') ?>" />&nbsp;(sin guiones)</td>
																</tr>
																	
																<tr>
																	<td class="key"><?php echo __('Nacionalidad'); ?>(*)</td>
																	<td><input class="required text_area" onchange="setNeedUpdate()" type="text" name="nationality"  size="33" id="nationality" value="<?php echo checkSubmited($V->data,'nationality') ?>" /></td>
																</tr>
														
																<tr>
																	<div style="float:left;">
																		<td class="key"><?php echo __('Tipo'); ?>(*)</td>
																		<td><?php echo $V->combos->getIdentityTypes(checkSubmited($V->data,'identity_type'),'identity_type') ?></td>
																		<script>
																		jQuery('#identity_type').change = setNeedUpdate;
																	</script>
																	</div>
																</tr>	
																
																<tr>	
																	<td class="key"><?php echo __('Nro Documento'); ?>(*)</td>
																	<td><input class="required text_area" onchange="setNeedUpdate()" type="text" name="identity_number"  size="33" id="identity_number" value="<?php echo checkSubmited($V->data,'identity_number') ?>" /></td>
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Calle'); ?>(*)</td>
																	<td><input class="required text_area" onchange="setNeedUpdate()" type="text" name="street_name"  size="33" id="street_name" value="<?php echo checkSubmited($V->data,'street_name') ?>" /></td>
																</tr>	
																
																<tr>
																	<td class="key"><?php echo __('Nro.'); ?>(*)</td>
																	<td>
																		<div style="float:left;">
																			<input class="required text_area" type="text" onchange="setNeedUpdate()" name="street_number"  size="5" id="street_number" value="<?php echo checkSubmited($V->data,'street_number') ?>" />
																		</div>
																	
																		<div style="float: left;margin-left: 8px;margin-right: 7px;margin-top: 7px;"><?php echo __('Piso'); ?></div>
																		<div style="float:left;">	
																			<input class="text_area" type="text" onchange="setNeedUpdate()" name="floor_number"  size="5" id="floor_number" value="<?php echo checkSubmited($V->data,'floor_number') ?>" />
																		</div>
																		
																		<div style="float: left;margin-left: 8px;margin-right: 7px;margin-top: 7px;"><?php echo __('Dpto.'); ?></div>
																		<div style="float:left;margin-top: -2px;">	
																			<input class="text_area" type="text" onchange="setNeedUpdate()" name="department_number"  size="5" id="department_number" value="<?php echo checkSubmited($V->data,'department_number') ?>" />
																		</div>
																	
																	</td>
																
																</tr>
																
																
																<tr>
																	<td class="key"><?php echo __('Pa&iacute;s'); ?>(*)</td>
																	<td><?php echo $V->combos->getCountries(checkSubmited($V->data,'country'),'country') ?></td>
																</tr>
																
																
																<tr>
																	<td class="key"><?php echo __('Provincia'); ?>(*)</td>
																	<td id="stateContainer" ><?php echo $V->combos->getStates(checkSubmited($V->data,'state'),checkSubmited($V->data,'country'),'state') ?></td>
																</tr>
																
																<tr>																
																	<td class="key"><?php echo __('Localidad'); ?>(*)</td>
																	<td id="cityContainer"><?php echo $V->combos->getCities(checkSubmited($V->data,'city'),checkSubmited($V->data,'country'),checkSubmited($V->data,'state'),'city') ?></td>
																</tr>
																												
																
																<tr>
																	<td class="key"><?php echo __('Zona'); ?>(*)</td>
																	<td>
																		<select name="id_zone" id="id_zone">
																			<?php foreach($V->zones as $zone) { ?>
																						<!--option value="<?php echo $zone->id; ?>"><?php echo $zone->name; ?></option-->
																						
																						<option value=<?php echo esSelected($zone->id,$V->zonesSaved)?>><?php echo $zone->name; ?></option>
																						
																			<?php } ?>
																		</select>
																	</td>
																</tr>
																
																
																<tr>																
																	<td class="key"><?php echo __('CP.'); ?>(*)</td>
																	<td><input class="required text_area" type="text" onchange="setNeedUpdate()" name="postal_code"  size="33" id="postal_code" value="<?php echo checkSubmited($V->data,'postal_code') ?>" /></td>
																	
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Mail Principal'); ?>(*)</td>
																	<td><input class="required validate-email text_area" type="text" onchange="setNeedUpdate()" name="main_contact_mail"  size="33" id="main_contact_mail" value="<?php echo checkSubmited($V->data,'main_contact_mail') ?>" /></td>		
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Mail Alternativo'); ?></td>
																	<td><input class="required validate-email text_area" type="text" onchange="setNeedUpdate()" name="optional_contact_mail"  size="33" id="optional_contact_mail" value="<?php echo checkSubmited($V->data,'optional_contact_mail') ?>" /></td>	
																</tr>
																							
																<tr>
																	<td class="key"><?php echo __('Tel&eacute;fono Fijo '); ?>(*)</td>
																	<td><input class="text_area" type="text" onchange="setNeedUpdate()" name="phone_numbers"  size="33" id="phone_numbers" value="<?php echo checkSubmited($V->data,'phone_numbers') ?>" /></td>	
																</tr>
																
																<tr>
																	<td class="key"><?php echo __('Tel&eacute;fono Celular'); ?></td>
																	<td><input class="text_area" type="text" onchange="setNeedUpdate()" name="cell_numbers"  size="33" id="cell_numbers" value="<?php echo checkSubmited($V->data,'cell_numbers') ?>" /></td>	
																</tr>
																
																<!--
																<tr>
																	<td class="key" style="vertical-align:top;"><?php echo __('Telefonos'); ?>(*)</td>
																	<td><textarea class="text_area" rows="4" cols="100" name="phone_numbers" onchange="setNeedUpdate()" id="phone_numbers"  size="33" maxlength="500" style="height:111px;width: 242px;"><?php if($V->data->phone_numbers == null) echo "fijo: XXX-XXXXXXX,cel.: XXX-XXXXXXX"; else echo checkSubmited($V->data,'phone_numbers');?></textarea></td>
																</tr>
																-->

																<tr>
																	<td class="key"><?php echo __('Estado Civil'); ?>(*)</td>
																	<td><?php echo $V->combos->getMaritalStatus(checkSubmited($V->data,'marital_status'),'marital_status') ?></td>
																	<script>
																		jQuery('#marital_status').change = setNeedUpdate;
																	</script>
																</tr>
																
																<tr>
																	<td class="key" style="vertical-align:top;"><?php echo __('Otros Intereses, Deportes, Hobbies, etc'); ?></td>
																	<td><textarea class="text_area" rows="4" cols="100" onchange="setNeedUpdate()" name="hobbies_sports_others" id="hobbies_sports_others"  size="33" maxlength="500" style="height:111px;width: 242px;" ><?php echo checkSubmited($V->data,'hobbies_sports_others') ?></textarea></td>
																</tr>
																
																
																<tr>
																	<td class="key"><?php echo __('Cargue su Foto (tama&ntilde;o m&aacute;ximo 2 mb)'); ?></td>
																	<td >
																	 <input type="hidden" name="identity_image_size"  id="identity_image_size" value="<?php echo $V->identity_image_size; ?>" >
																	 <input type="hidden" name="identity_image" value="<?php echo $V->data->identity_image; ?>" >
																	 <input size="30"  onchange="checkExtension(this,'.jpg,.bmp,.gif,.png')" type="file" id="identity_image_file" name="identity_image_file"/>
																	</td>
																	
																</tr>
																
																</tr>
																	<td></td>
																	<td ><?php 
																		if ($V->data->identity_image != null && $V->data->identity_image != '')
																			$imgSrc='wp-content/uploads/profiles/'.$V->username.'/'.$V->data->identity_image;
																		else
																			$imgSrc='wp-content/plugins/masvalor/app/includes/sinfoto.jpg';
																		?>
																		<div style="margin-left: 3px;">
																			<img src="<?php echo $imgSrc; ?>" HEIGHT=64 alt="profile_image"></img>	
																	    </div>
																	</td>
																		
																</tr>
																
																
																
																<tr>
																	<td class="key"><?php echo __('Cargue su Cv'); ?>(*)</td>
																	<td style="float:left;">
																						
																	  <input type="hidden" name="cv_size" id="cv_size" value="<?php echo $V->cv_size; ?>">
																	  <input type="hidden" name="cv" id="cv" value="<?php echo $V->data->cv; ?>" >
																	  <input size="30"  onchange="checkExtension(this,'.pdf')" type="file" id="cv_file" name="cv_file"/>
																	</td>
																</tr>
																
																<tr>
																	<td></td>
																	<td >
																		<?php 
																		if ($V->data->cv != null && $V->data->cv != ''){
																			$linkCv='wp-content/uploads/profiles/'.$V->username.'/'.$V->data->cv;																		
																		?>
																			<a style="margin-left: 3px;" style="color:#6899D3;" Id="VerCV" target="_blank" href="<?php echo $linkCv;?>" >
																			  <img alt="<?php echo __('Ver CV') ?>"  WIDTH="32" HEIGHT="32" title="<?php echo __('Ver CV') ?>" src="wp-content/plugins/masvalor/app/includes/image/save-pdf.png" />
																			</a>	
																		<?php } ?>
																	</td>
																	
																</tr>

																
																<tr>                                    	
																	<td style="padding-bottom: 20px;padding-left: 20px;padding-top: 20px;">
																	<input id="save_step1" onclick="submitForm('step1')" type="button"  value ="Guardar"/></td>
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
															    <div style="float: right; margin-top: -22px;">
																		<input id="addLanguage" onclick="show_popup_language()" type="button"  value ="Agregar" />
																</div>
																<table id="tableSelectedLanguage" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Idioma') ?></th>
																	<th><?php echo __('Lee') ?></th>
																	<th><?php echo __('Habla') ?></th>
																	<th><?php echo __('Escribe') ?></th>
																	<th class="deleteDiv"></th>
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
															  <legend><?php echo __('Educaci&oacute;n de Grado');  ?> (*)</legend>
															    <div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="show_popup_education()"type="button"  value ="Agregar" />
																</div>
																<table id="tableSelectedEducation" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('T&iacute;tulo Profesional'); ?></th>
																	<th><?php echo __('Universidad'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	<th><?php echo __('Estado'); ?></th>
																	<th class="deleteDiv"></th>
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
															  <legend><?php echo __('Educaci&oacute;n de Postgrado'); ?> (*)</legend>
															    <div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="show_popup_education_post()"type="button"  value ="Agregar" />
																</div>
																<table id="tableSelectedEducationPos" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('T&iacute;tulo Profesional'); ?></th>
																	<th><?php echo __('Universidad'); ?></th>
																	<th><?php echo __('Tipo'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	<th><?php echo __('Estado'); ?></th>
																	<th class="deleteDiv"></th>
																  </thead>
																  <?php 
																  if ($V->titlesPos != '' && $V->titlesPos != null) {
																	foreach ($V->titlesPos as $aTitlePos):
																		?>
																		<script>
																			addEducationPos('<?php echo $aTitlePos->title ?>','<?php echo $aTitlePos->university_name ?>','<?php echo $aTitlePos->from_date ?>','<?php echo $aTitlePos->to_date ?>','<?php echo $aTitlePos->university ?>','<?php echo $aTitlePos->finalized ?>','<?php echo $aTitlePos->type_title ?>');
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
															  <legend><?php echo __('Tesis de Postgrado'); ?> (*)</legend>
															    <div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="show_popup_tesis_postgrado()" type="button"  value ="Agregar" />
																</div>
																<input type="hidden" name="tesis_size" id="tesis_size" value="<?php echo $V->tesis_size; ?>" >
																<table id="tableSelectedTesis" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('T&iacute;tulo'); ?></th>
																	<th><?php echo __('Certificado'); ?></th>
																	<th ><?php echo __('Tema'); ?></th>
																	<th><?php echo __('Fecha Publicaci&oacute;n'); ?></th>
																	<th><?php echo __('Subdisciplina'); ?></th>
																	<th class="deleteDiv"></th>
																  </thead>
																  <?php 
																  if ($V->tesisPos != '' && $V->tesisPos != null) {
																	foreach ($V->tesisPos as $aTesisPos):
																		?>
																		<script>
																			addTesis('<?php echo $aTesisPos->title ?>','<?php echo $aTesisPos->topic ?>','<?php echo $aTesisPos->publication_date ?>',null,'<?php echo $aTesisPos->file ?>','<?php echo 'wp-content/uploads/profiles/'.$V->username.'/'.$aTesisPos->uri_title?>','<?php echo $aTesisPos->id_subdiscipline ?>','<?php echo $aTesisPos->name_subdiscipline ?>',null,'<?php echo $aTesisPos->defense_file; ?>','<?php echo 'wp-content/uploads/profiles/'.$V->username.'/'.$aTesisPos->uri_defense?>',1);
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
															    <div style="float: right; margin-top: -22px;">
																		<input id="addEducation" onclick="show_popup_experiencia_laboral()"type="button"  value ="Agregar" />
																</div>
																<table id="tableSelectedExperiencia" class="admintable" style="font-size:11px;width:100%;text-align:center;margin-bottom: 27px;">
																  <hr/>
																  <thead>
																	<th><?php echo __('Empresa'); ?></th>
																	<th><?php echo __('Puesto'); ?></th>
																	<th><?php echo __('Area'); ?></th>
																	<th><?php echo __('Desde'); ?></th>
																	<th><?php echo __('Hasta'); ?></th>
																	<th class="deleteDiv"></th>
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
															  <legend><?php echo __('Disciplinas de Dominio'); ?> (*)</legend>
															    <div style="float: right; margin-top: -22px;">
																		<input id="addDiscipline" onclick="show_popup_diciplines()" type="button"  value ="Agregar" />
																</div>
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
															  </table>
														</td>
												    </tr>
													
													<tr>
													    <td>
															<div style="margin-top:30px;"/>	
														<td>
													</tr>
													

													
													<tr>
														<td class="key" >
															<div style=" margin-bottom: 7px;padding-top: 13px;"><?php echo __('Otras disciplinas de dominio'); ?></div>
															<textarea class="text_area" rows="4" cols="100" name="other_disciplines" id="other_disciplines" onchange="setNeedUpdate()"  size="50" maxlength="500" style="height: 208px;width: 600px;" ><?php echo checkSubmited($V->data,'other_disciplines') ?></textarea>
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
														<td class="key"><?php echo __('Comisi&oacute;n asesora'); ?>(*)</td>
														<td>
															<select name="id_comision" id="id_comision">
																<?php foreach($V->comisions as $com) { ?>
																	<!--option value="<?php echo $com->id; ?>"><?php echo $com->name; ?></option-->
																	
																	<option value=<?php echo esSelected($com->id,$V->comisionsSaved)?> > <?php echo $com->name; ?> </option>
																	
																<?php } ?>
															</select>
														</td>
													</tr>
															  <tr>
																 <td>
																	<fieldset style="width:181%;font-size:12px;">
																		<legend><?php echo __('Competencias/Habilidades destacadas'); ?> <strong><?php echo __('(M&aacute;ximo recomendado 5)'); ?></strong></legend>
																		<?php 
																			echo $V->checkbox->getCompentencies($V->competencies,'competitionid','competencies[]');
																		?>																											 
																	</fieldset>
																													
																 </td>	
															 </tr>
														
														</table>
														</td>
													</tr>
													
													<tr>                                    	
														<td style="padding-bottom: 20px;padding-left: 20px;padding-top: 20px;">
														<input id="save_step2" onclick="submitForm('step2')"type="button"  value ="Guardar" /></td>
													</tr>
													
												</table>
												
											  </div>
										   </div>
										 </div>
										
										</div>     
									</div>
								</div>
														
								<!------------------------------------------------------------------------>
								<!--pestana 3(cuenta corriente)-->
							
							<div id="tab3" class="tab_content">
								 <!--Contenido del bloque de texto-->
									<div id="datos">                                    
									  <div id="datosgenerales">
									  <!--de aca-->
										<div class="ClaseColumna" style="width:100%">
											<div class="Columna" id="Columna1">
										
											  <div id="Cont6">
																								
												<table class="admintable" style="font-size:12px">
																								
													<tr>
														<td class="key" style="padding-top: 2px;vertical-align: top;" >
														<div style=" margin-bottom: 7px;padding-top: 13px;"><?php echo __('Expectativa de Inserci&oacute;n Laboral'); ?></div> 
														<textarea onchange="setNeedUpdate()" class="text_area" rows="4" cols="100" name="expected_labor_insertion" id="expected_labor_insertion"  size="50" maxlength="800" style="height: 208px;width: 600px;"><?php echo $V->data->job_expectations ?></textarea>
														</td>
													</tr>
													
													<tr>
													    <td>
															<div style="margin-top:10px;"/>	
														<td>
													</tr>
													
													<tr>
													    <td>
															<fieldset style="width: 100%;font-size:12px;">
															<legend><?php echo __('Sector de Inserci&oacute;n Pretendida'); ?></legend>
															<?php 
																echo $V->checkbox->getLaborSectors('prefer_ls_',$V->data,'laborsectors[]');
															?>	
															</fieldset>
														</td>
													</tr>	
													
													<tr>
													    <td>
															<div style="margin-top:10px;"/>	
														<td>
													</tr>
																
													<tr>
													   <td>
															<fieldset style="width: 100%;font-size:12px;">
															<legend>Carga Horaria Pretendida</legend>
															<?php 
																echo $V->checkbox->getAvailabilityTimes('prefer_at_',$V->data,'availabilitytimes[]');
															?>	
															</fieldset>
														</td>
													</tr>
													
													<tr>
													    <td>
															<div style="margin-top:10px;"/>	
														<td>
													</tr>
													
													<tr>
														<td>
															<fieldset style="width:100%;font-size:12px;">
															<legend>Tipo de relaci&oacute;n laboral</legend>
															<?php 
																echo $V->checkbox->getLaborRelationships('prefer_lr_',$V->data,'laborrelationships[]');
															?>	
															</fieldset>
														</td>	
													</tr>
													
													<tr>
													    <td>
															<div style="margin-top:10px;"/>	
														<td>
													</tr>
													
												</table>
												
									
												
												<table class="admintable" style="font-size:11px">
													<tr>
														<td>
															<fieldset style="width: 135%;font-size:12px;">
																<legend>Disponibilidad de desarraigo</legend>
															   <div class="checkbox-container">
																	<input onchange="setNeedUpdate()" style="margin-right:12px;" <?php if ( $V->data->availability_for_travel == 1 ) echo " checked"; ?> type="checkbox" id="availability_for_travel" name="availability_for_travel" value="1" />
																	<label for="availability_for_travel" ><?php echo __('Disponibilidad para viajar')  ?></label>
															   </div>
															   <div class="checkbox-container">
																	<input onchange="setNeedUpdate()" style="margin-right:12px;" <?php if ( $V->data->availability_move_country == 1 ) echo " checked"; ?> type="checkbox" id="availability_move_country" name="availability_move_country" value="1" />
																	<label for="availability_move_country" ><?php echo __('Disponibilidad para mudarse al extranjero')  ?></label>
															   </div>
															   <div class="checkbox-container">
																	<input onchange="setNeedUpdate()" style="margin-right:12px;" <?php if ( $V->data->availability_move_state == 1 ) echo " checked"; ?> type="checkbox" id="availability_move_state" name="availability_move_state" value="1" />
																	<label for="availability_move_state" ><?php echo __('Disponibilidad para mudarse a otra provincia')  ?></label>
															   </div>
															</fieldset>

														</td>	
													</tr>
													
													<tr>
														<td>
															<table>
																
																<tr>
																	<td>
																		<div style="margin-top:20px;"/>	
																	<td>
																</tr>
																<tr>
																	<td class="key" style="font-size:12px;">Remuneraci&oacute;n mensual m&iacute;nima bruta pretendida $</td>
																	<td><input class="text_area" onchange="setNeedUpdate()" type="text" name="expected_gross_mensual_remuneration"  size="20" id="expected_gross_mensual_remuneration" value="<?php echo $V->data->expected_gross_mensual_remuneration ?>" /></td>
																</tr>
																	
																<tr>                         
																	<td style="padding-bottom: 20px;padding-left: 20px;padding-top: 20px;">
																	<input id="save_step3" onclick="submitForm('step3')"type="button"  value ="Guardar" /></td></td>
																</tr> 
																	
															</table>
														</td>
													</tr>
													
												</table>
											  </div> <!--Cont3-->
											</div>
										</div>
								   
												
									  <!--a aca-->  
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
	<input type="hidden" name="rejected_mail" id="rejected_mail" value="" />
	<input type="hidden" name="pending_mail" id="pending_mail" value="" />
	<input type="hidden" name="tab" id="tab" value="" />
	<input type="hidden" name="desactived_mail" id="desactived_mail" value="" />
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