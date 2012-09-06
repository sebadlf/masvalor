<?php
/*
// Copyright (c) 2011 JoomlaWorks Ltd. All rights reserved.
// Released under the GNU/GPL license: http://www.tsavo.com.ar
// More info at http://www.tsavo.com.ar
// Designed and developed by the Tsavo Group team
*/


?>

     <script language="JavaScript" src="wp-content/themes/rollpix/include/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/themes/rollpix/include/calendar/calendar.css">
	
<script language="javascript" type="text/javascript">
    
	function saveEducation(){ 
	  
	  	if(confirm("\u00BFEst\u00e1 seguro que quiere guardar la educacion?")) {  
	        createNewEducation('field',document.getElementById('title').value,document.getElementById('university').value,document.getElementById('from').value,document.getElementById('to').value,'completo');
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
						<legend>Educacion de grado Postgrado</legend>
						<table class="admintable" >
							
							<tr>
								<td class="key" style="font-size:11px;">Titulo Profesional (*)</td>
								<td><input class="text_area" type="text" name="title" id="title" value="" size="50" maxlength="250" /></td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Universidad (*)</td>
								<td><input class="text_area" type="text" name="university" id="university" value="" size="50" maxlength="250" /></td>
							</tr>
							
						     <tr>
								<td class="key" style="font-size:11px;">Desde(*)</td>
								<td><input class="text_area" type="text" name="from_date" id="from_date" value="" />
								<script language="JavaScript">
										new tcal ({
										'formname': 'adminForm',
										'controlname': 'from_date',                      
										});
								</script>
								</td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Hasta(*)</td>
								<td><input class="text_area" type="text" name="to_date" id="to_date" value=""/>
								<script language="JavaScript">
										new tcal ({
										'formname': 'adminForm',
										'controlname': 'to_date',                      
										});
								</script>
								</td>
							</tr>
							
							<tr>
								<td class="key" style="font-size:11px;">Estado (*)</td>
								<td>
									<select name="method_payment" >
										<option value=<?php echo esSelected("1","")?>> Completo </option>
										<option value=<?php echo esSelected("2","")?>> Incompleto </option>
										<option value=<?php echo esSelected("3","")?> > Proceso </option>
								   	</select>
															 
								</td>	
							</tr>		
							
							<td>                         
								<td style="padding-top:20px;float:left;">
									<input id="button" onclick="saveEducation()" type="button"  value ="Guardar" />
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
