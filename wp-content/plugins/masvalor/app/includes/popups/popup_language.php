<?php
/*
// Copyright (c) 2011 JoomlaWorks Ltd. All rights reserved.
// Released under the GNU/GPL license: http://www.tsavo.com.ar
// More info at http://www.tsavo.com.ar
// Designed and developed by the Tsavo Group team
*/


?>

   <script language="JavaScript" src="../calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="../calendar/calendar.css"/>
	<script type="text/javascript" src="../js/jquery.js"></script> 

<script language="javascript" type="text/javascript">

jQuery(document).ready(function($){
	var data = {
		action: 'get_langs',
		comboid: 'lang'
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboLang').innerHTML = response;
	});
	
	var data = {
		action: 'get_langs_levels',
		comboid: 'read'
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboRead').innerHTML = response;
	});
	
	var data = {
		action: 'get_langs_levels',
		comboid: 'write'
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboWrite').innerHTML = response;
	});
	
	var data = {
		action: 'get_langs_levels',
		comboid: 'speak'
	};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboSpeak').innerHTML = response;
	});
});

	
function addLanguage(){ 
  lang = document.getElementById('lang').value;
  read = document.getElementById('read').value;
  write = document.getElementById('write').value;
  speak = document.getElementById('speak').value;
  
  if(confirm("\u00BFEst\u00e1 seguro que quiere guardar el idioma?")) { 
	  if (parent.addLanguage(lang,read,write,speak))  
		parent.activeModal.close();       
  }
  
}

	
function closePopup(){
   parent.activeModal.close();
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
					<fieldset class="adminform" style="background-color:#E3E3E3;font-family:Verdana,arial,helvetica;">
						<legend>Idiomas</legend>
						<table class="admintable" >
							
							<tr>
								<td class="key" style="font-size:11px;">Idioma(*)</td>
								<td id="comboLang"></td>
							</tr>
							
														
							<tr>
								<td class="key" style="font-size:11px;">Lee (*)</td>
								<td id="comboRead" ></td>	
							</tr>	
							
							<tr>
								<td class="key" style="font-size:11px;">Habla (*)</td>
								<td id="comboSpeak"></td>	
							</tr>		

							<tr>
								<td class="key" style="font-size:11px;">Escribe (*)</td>
								<td id="comboWrite"></td>	
							</tr>			
							
							<tr>                         
								<td style="padding-top:20px;float:left;">
								  <input id="button" class="modal-close" onclick="addLanguage()" type="button"  value ="Guardar" />
								</td>
							    
								<td style="padding-top:20px;float:left;">
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
