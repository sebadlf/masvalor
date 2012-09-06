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
		action: 'get_disciplines_group',
		comboid: 'discipline_group'
	};

	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboDisciplinesGroup').innerHTML = response;
		getDisciplinesSubGroup();
		document.getElementById('discipline_group').onchange = getDisciplinesSubGroup;
	});
});

function getDisciplinesSubGroup(){
	var data = {
			action: 'get_disciplines_sub_group',
			comboid: 'subdiscipline',
			group: jQuery('#discipline_group').val()
		};

	jQuery.post('../../../../../../wp-admin/admin-ajax.php', data, function(response) {
		document.getElementById('comboDisciplinesSubGroup').innerHTML = response;
	});
}

function addDiscipline(){
   
    if(confirm("\u00BFEst\u00e1 seguro que quiere guardar la disciplina?")) {   
		  subdisciplineid = document.getElementById('subdiscipline').value;
		  subdiscipline = document.getElementById('subdiscipline').options[document.getElementById('subdiscipline').selectedIndex].text;
		  group = document.getElementById('discipline_group').options[document.getElementById('discipline_group').selectedIndex].text;
		  if ( parent.addDiscipline(group,subdiscipline,subdisciplineid))
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
					<fieldset class="adminform" style="background-color: #E3E3E3;font-family:Verdana,arial,helvetica;">
						<legend>Disciplinas de Dominio</legend>
						<table class="admintable" >
							
							<tr>
								<td class="key" style="font-size:11px;">Disciplina (*)</td>
								<td id="comboDisciplinesGroup"></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Subdisciplina (*)</td>
								<td id="comboDisciplinesSubGroup"></td>
							</tr>
									
							<tr>                         
								<td style="padding-top:20px;float:left;">
									<input id="button" onclick="addDiscipline()" type="button"  value ="Guardar" />
								</td>
								
								<td style="padding-top:20px;">
								  <input id="buttoncancel" class="modal-close" onclick="closePopup()" type="button"  value ="Cancelar" />
								</td>
							</tr> 
							
						</table>
						
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>		
</form>
