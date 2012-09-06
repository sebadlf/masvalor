<?php  if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

		<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
        
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
 
 
<script language="javascript" type="text/javascript">
function validateFields(){
			retorno = false;
			var msg = new Array();
		    var error = false;

		  if (jQuery("#post_title").val() == ""){
			msg.push('<?php echo __('Debe ingresar un t\u00edtulo.');?>');
			error = true;
		  }
		  
		  		   
		   if (jQuery("#start_date").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una fecha de inicio.');?>");
		   error = true;
		   }
		   
		  if (jQuery("#end_date").val() == ""){
				 msg.push("<?php echo __('Debe ingresar una fecha de fin.');?>");
		   error = true;
		   }
		   
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
}

function saveForm(){
    if (validateFields()){
		if(confirm("¿Est\u00e1 seguro que quiere guardar la actividad?")) {  
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit(); 
		}	
	}	
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
</style>
        
		
       <div style="margin-top:20px;font-size:14px">
				 <form class="adminForm" name="adminForm" action="" method="post">
					 <h3><?php echo __('Agregar/Editar Actividad') ?></h3>
					 <br/>
					 <fieldset class="adminform" style="width: 636px;background-color: #ffffff;box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1) inset;color: #000000;">
							
							<table class="admintable" style="margin-left:37px;margin-top:15px;">										  
							
							 
								 <tr>
									<td><label for="post_title"><?php echo __('Nombre') ?></label></td>
									<td><input name="post_title"  id="post_title" size="35" type="text" value="<?php echo $V->data->post_title;?>" /></td>
								 </tr>
									
								 <tr>
									<td class="key"><?php echo __('Fecha Inicio') ?></td>
									<td><input class="tcal" type="text" name="start_date" id="start_date" value="<?php echo $V->dates->start_date;?>" />
									(dd-mm-yyyy)
									</td>
								 </tr>	
									
								 <tr>
									<td class="key"><?php echo __('Fecha Fin') ?></td>
									<td><input class="tcal" type="text" name="end_date" id="end_date" value="<?php echo $V->dates->end_date;?>"  />
									(dd-mm-yyyy)
									</td>
								 </tr>			
								
								  <tr>
									<td class="key"><?php echo __('Vencimiento') ?></td>
									<td><input class="tcal" type="text" name="post_date_espirate" id="post_date_espirate" value="<?php echo $V->dates->post_date_espirate;?>" />
									(dd-mm-yyyy)
									</td>
								 </tr>	
								 
								  <tr>
									<td><label for="post_title"><?php echo __('Prioridad') ?></label></td>
									<td><input name="priority"  id="priority" size="6" type="text" value="<?php echo $V->dates->priority;?>" /></td>
								  </tr>
								  
								  <tr>
									<td style="vertical-align: top;"><label for="post"><?php echo __('Descripci&oacute;n') ?></label></td>
									<td><textarea class="text_area" rows="7" cols="75" name="post" id="post"  size="60" maxlength="2048" style="height: 384px; width: 463px;"/><?php echo $V->data->post_content;?></textarea></td>
								  </tr>
							  
							</table>
							
							<div style="float:left;padding-bottom: 20px;padding-left: 115px;padding-top: 20px;">	
								<!--<input id="save" name="save" type="button" onclick="saveForm();" value="<?php echo __('save') ?>" />-->
								<a href="#" onclick="saveForm();" > <img src="wp-content/plugins/masvalor/app/includes/image/accept.png"></a> 
							</div>	
								
							<div style="float:left;padding-bottom: 20px;padding-left: 17px;padding-top: 24px;">
								<a href="<?php echo masvalor_getUrl(); ?>/activities/"> <img src="wp-content/plugins/masvalor/app/includes/image/cancel.png"></a> 
							</div>
					
						<input type="hidden" name="cid" id="cid" value="<?php echo $V->data->ID;?>" />
						<input type="hidden" name="view" value="new" />
						<input type="hidden" name="task" id="task" value="" />
					</form>
							
				</div>
		   

