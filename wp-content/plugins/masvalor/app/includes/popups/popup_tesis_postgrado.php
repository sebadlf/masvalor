
	<script language="JavaScript" src="../simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="../simple-calendar/tcal.css">
	<script type="text/javascript" src="../js/jquery.js"></script>

<script language="javascript" type="text/javascript">	


jQuery(document).ready(function($){
	var data = {
		action: 'get_disciplines_group',
		comboid: 'discipline_group'
	};

	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboDisciplinesGroup').innerHTML = response;
		getDisciplinesSubGroup();
		document.getElementById('discipline_group').onchange = getDisciplinesSubGroup();
	});
});

function getDisciplinesSubGroup(){
	var data = {
			action: 'get_disciplines_sub_group',
			comboid: 'discipline_sub_group',
			group: jQuery('#discipline_group').val()
		};

	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboDisciplinesSubGroup').innerHTML = response;
	});
}

function addDiscipline(){ 
  disciplineid = document.getElementById('discipline').value;
  discipline = document.getElementById('discipline').options[document.getElementById('discipline').selectedIndex].text;
  subgroup = document.getElementById('discipline_sub_group').options[document.getElementById('discipline_sub_group').selectedIndex].text;
  group = document.getElementById('discipline_group').options[document.getElementById('discipline_group').selectedIndex].text;
  if ( parent.addDiscipline(group,subgroup,discipline,disciplineid))
	parent.activeModal.close();
}


function validateFields(){
    var msg = new Array();
	var error = false;
	
	if (jQuery("#title").val() == ""){
		 msg.push('Debe ingresar el t\u00edtulo de su Tesis.');
		 error = true;
		 }
	if (jQuery("#theme").val() == ""){
		 msg.push('Debe ingresar el tema de su Tesis.');
		 error = true;
		 }
	if (jQuery("#file").val() == ''){
		msg.push('Debe subir el archivo PDF de su Tesis.');
		error = true;
		 }
	if (jQuery("#defense").val() == ''){
		msg.push('Debe subir el archivo PDF de su Tesis.');
		error = true;
		 }
	
	if (jQuery("#file").val().lastIndexOf('ñ') != -1){ 
		msg.push('El servidor no permite subir archivos cuyos nombres contengan caracteres raros.');
		error = true;
	}
		 
	if (jQuery("#defense").val().lastIndexOf('ñ') != -1){
		msg.push('El servidor no permite subir archivos cuyos nombres contengan caracteres raros.');
		error = true;
	}
	
	if (!validar()){ 
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
		 alert("Compruebe la extensi?n de los archivos a subir. \nSolo se pueden subir archivos con extensiones: " + allowed_extensions.join()); 
		 element.value = "";
		 }
	
}


function addTesis(){ 
	if (validateFields()){
	  if(confirm("\u00BFEst\u00e1 seguro que quiere guardar la tesis?")) {
		  title = document.getElementById('title').value;
		  theme = document.getElementById('theme').value;
		  publicationDate = document.getElementById('publication_date').value;
		  file = document.getElementById('file');
		  defense_file = document.getElementById('defense');
		  disciplineid = document.getElementById('discipline_sub_group').value;
		  disciplinename = document.getElementById('discipline_sub_group').options[document.getElementById('discipline_sub_group').selectedIndex].text;
		  auxFileName = document.getElementById('file').value.split('\\');
		  auxDefenseFileName = document.getElementById("defense").value.split('\\');
		  fileName = auxFileName[auxFileName.length - 1];
		  defenseFileName = auxDefenseFileName[auxDefenseFileName.length - 1];
		  var link = null;
		  var defense_file_link = null;
		  if ( parent.addTesis(title,theme,publicationDate,file,fileName,link,disciplineid,disciplinename,defense_file,defenseFileName,defense_file_link,0/*fileExist*/))
			parent.activeModal.close(); 
	  }
	}
}
	
function closePopup(){
   parent.activeModal.close();
} 	

function validar()
 {
 	var aux = document.getElementById("publication_date").value;
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

<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm" >
	<table class="admintable" width="90%">
		
		<tbody>
			<tr >
				<td valign="top">
					<fieldset class="adminform" style="background-color: #E3E3E3;font-family:Verdana,arial,helvetica;">
						<legend>Tesis de Postgrado</legend>
						<table class="admintable" >
							
							<tr>
								<td class="key" style="font-size:11px;">T&iacute;tulo (*)</td>
								<td><input class="text_area" type="text" name="title" id="title" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Tema (*)</td>
								<td><input class="text_area" type="text" name="theme" id="theme" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Fecha de publicaci&oacute;n</td>                                            
								 <td><input style="float:left;" type="text" name="publication_date" id="publication_date" class="tcal" value="" />
								 <p style="float: left;font-size: 11px;margin-left: 8px;margin-top: 3px;">(dd-mm-aaaa)</p>
								 </td>																 
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Disciplina (*)</td>
								<td onclick="getDisciplinesSubGroup();" id="comboDisciplinesGroup"></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Subdisciplina (*)</td>
								<td id="comboDisciplinesSubGroup"></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Tesis (*)</td>
								<td><input class="text_area" onchange="checkExtension(this,'.pdf')" type="file" name="file" id="file" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Certificado de defensa (*)</td>
								<td><input class="text_area" onchange="checkExtension(this,'.pdf,.jpg,.png')" type="file" name="defense" id="defense" /></td>
							</tr>
							
							<tr>                         
								<td style="padding-top:20px;float:left;">
									<input id="button" onclick="addTesis()" type="button"  value ="Guardar" />
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
