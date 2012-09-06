<?php  if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

	    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
         <!--
    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">-->
	
	
	<script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.js"></script>
	<link rel="stylesheet" type="text/css" href="wp-content/plugins/masvalor/app/includes/simple-calendar/tcal.css">

<head>
 <script language="javascript" type="text/javascript" src="wp-content/plugins/masvalor/app/includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> 
 </script>
   <script language="javascript" type="text/javascript">
      tinyMCE.init({
         mode : "textareas",
         theme : "advanced",
		 theme_advanced_toolbar_location : "top"
      });
   </script>
</head> 
 
<?php require_once ('models/masvalor_utils.php');?> 
 
<?php   		   
	$date2 =$V->data->post_date;
	$date = explode(' ',$date2);
	
 ?>
 
 
<script language="javascript" type="text/javascript">
function validateFields(){
			retorno = false;
			var msg = new Array();
		    var error = false;

		  if (jQuery("#post_title").val() == ""){
			msg.push('<?php echo __('Debe ingresar una t\u00edtulo.');?>');
			error = true;
		  }
		  
		  if (jQuery("#post_date").val() == ""){
			msg.push('<?php echo __('Debe ingresar una fecha.');?>');
			error = true;
		  }
		
		  /*if (jQuery("#post").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un descripcion.');?>");
		   error = true;
		   }*/
		   
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
}



function saveForm(){
   if (validateFields()){
		if(confirm("¿Est\u00e1 seguro que quiere guardar la bit\u00e1cora?")) {
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit(); 
		}	
   }	
}

function viewNothing(){  
    document.getElementById('doctors').style.display ='none'; 
	document.getElementById('companies').style.display ='none';
}

function viewDoctors(){  
    document.getElementById('doctors').style.display ='table-row'; 
	document.getElementById('companies').style.display ='none';
}

function viewCompanies(){  
    document.getElementById('doctors').style.display ='none'; 
	document.getElementById('companies').style.display ='table-row';
}

</script>  

  
<style>

#table_noticia thead{
  background-color: #e3e3e3;
}

a{
 text-decoration: none;
 color:black;
}


#doctors{
   background-color: #FFFFFF;
   
    color: #000000;
    margin: 1px 1px 1px 3px;
}

#companies{
    background-color: #FFFFFF;
    color: #000000;
    margin: 1px 1px 1px 3px;
}	

</style>      

    <?php   		   
	    if($V->data->post_date != NULL){
		   $date2 =$V->data->post_date;
		   $date = explode(' ',$date2);
		   $date2 = explode("-",$date[0]);
		   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
		}		

		if($V->data_publications->post_date_espirate != NULL){
		   $date3 =$V->data_publications->post_date_espirate;
		   $date4 = explode(' ',$date3);
		   $date5 = explode("-",$date4[0]);
		   $dateend_espirate = $date5[2].'-'.$date5[1].'-'.$date5[0];
		   
		}else $dateend_espirate=" ";	

function esSelected($estado,$comparacion){   
    if ($estado == $comparacion){
       return $estado. ' selected';
    }  
    else return $estado;  
}

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
          
	 <div style="margin-top:20px;font-size:14px">
				 <form action="" method="post" name="tinymce" id="adminForm">
					 <h3><?php echo __('Agregar/Editar Act. Bit&aacute;cora') ?></h3>
					 <br/>
					 <fieldset class="adminform" style="width: 636px;background-color: #ffffff;box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1) inset;color: #000000;">
							
							<table class="admintable" style="margin-left:37px;margin-top:15px;">										  
							
							 
								 <tr>

								<td><label for="post_title"><?php echo __('Usuario') ?></label></td>
									 <td>
										<input onclick="viewNothing()"   type=radio name="type" value="<?php echo __('sin_user') ?>" ><?php echo __('Sin Usuario') ?><br>
										<input onclick="viewDoctors()"   type=radio name="type" value="<?php echo __('doctor') ?>"  ><?php echo __('Doctor') ?><br>
										<input onclick="viewCompanies()" type=radio name="type" value="<?php echo __('empresa') ?>" ><?php echo __('Empresa') ?><br>
									 <td>
								</tr>
								
								
								<tr id="doctors" style="display:none;">
									<td class="key"><?php echo __('Doctores'); ?></td>
									<td id="doctorContainer"><?php echo $V->combos->getDoctors(checkSubmited($V->data_user->userid,'name')) ?></td>
								</tr>
								
								
								<tr id="companies" style="display:none;">
									<td class="key"><?php echo __('Empresas'); ?></td>
									<td id="companyContainer"><?php echo $V->combos->getCompanies(checkSubmited($V->data_user->userid,'name')) ?></td>
								</tr>
								
								
								<tr>
									<td><label for="post_title"><?php echo __('Nombre') ?></label></td>
									<td><input name="post_title"  id="post_title" size="35" type="text" value="<?php echo $V->data->post_title;?>" /></td>
								 </tr>
									
								 <tr>
									<td class="key"><?php echo __('Fecha Inicio') ?></td>
									<td><input class="tcal" type="text" id="post_date" name="post_date"  value="<?php echo $dateend;?>" />
									(dd-mm-yyyy)
									</td>
								 </tr>	
								 

								  <tr>
									<td class="key"><?php echo __('Vencimiento') ?></td>
									<td><input class="tcal" type="text" name="post_date_espirate" id="post_date_espirate" value="<?php echo $dateend_espirate;?>" />
									(dd-mm-yyyy)
									</td>
								 </tr>	
								 
								  <tr>
									<td><label for="post_title"><?php echo __('Prioridad') ?></label></td>
									<td><input name="priority"  id="priority" size="6" type="text" value="<?php echo $V->data_publications->priority;?>" /></td>
								  </tr>
									
								  <tr>
									<td style="vertical-align: top;"><label for="post"><?php echo __('Descripci&oacute;n') ?></label></td>
									<td><textarea class="text_area" rows="7" cols="75" name="post" id="post"  size="600" maxlength="2048"  style="height: 384px; width: 463px;"/><?php echo $V->data->post_content;?></textarea></td>
								  </tr>
							  
							</table>
							
							<div style="float:left;padding-bottom: 20px;padding-left: 115px;padding-top: 20px;">	
								<!--<input id="save" name="save" type="button" onclick="saveForm();" value="<?php echo __('save') ?>" />-->
								<a href="#" onclick="saveForm();" > <img src="wp-content/plugins/masvalor/app/includes/image/accept.png"></a> 
							</div>	
							
							<div style="float:left;padding-bottom: 20px;padding-left: 17px;padding-top: 24px;">
								<a href="<?php echo masvalor_getUrl(); ?>/consultations/"> <img src="wp-content/plugins/masvalor/app/includes/image/cancel.png"></a> 
							</div>
					
					
						<input type="hidden" name="cid" id="cid" value="<?php echo $V->data->ID;?>" />
						<input type="hidden" name="view" value="new" />
						<input type="hidden" name="task" id="task" value="" />
					</form>
							
	 </div>
		   
				