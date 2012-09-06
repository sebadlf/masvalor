<?php  if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>

<script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 

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
			msg.push('<?php echo __('Debe ingresar una t\u00edtulo.');?>');
			error = true;
		  }
		  
		  if (jQuery("#post").val() == ""){
				 msg.push("<?php echo __('Debe ingresar un descripci\u00f3n.');?>");
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
		document.forms['adminForm'].task.value = 'save';
		document.forms['adminForm'].submit(); 
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
				 <form action="" method="post" name="tinymce" id="adminForm">
					 <h3><?php echo __('Agregar/Editar Faq') ?></h3>
					 <br/>
					 <fieldset class="adminform" style="width: 636px;background-color: #dddddd;font-size:arial;">
							<table class="admintable" style="margin-left:37px;margin-top:15px;">										  
							
							 
								 <tr>
									<td><label for="post_title"><?php echo __('Nombre') ?></label></td>
									<td><input name="post_title"  id="post_title" size="35" type="text" value="<?php echo $V->data->post_title;?>" /></td>
								 </tr>
																							
								  <tr>
									<td style="vertical-align: top;"><label for="post"><?php echo __('Descripci&oacute;n') ?></label></td>
									<td><textarea class="text_area" rows="7" cols="75" name="post" id="post"  size="600" maxlength="2048"  style="height: 384px; width: 463px;" /><?php echo $V->data->post_content;?></textarea></td>
								  </tr>
							  
							</table>
							
							<div style="float:left;padding-bottom: 20px;padding-left: 115px;padding-top: 20px;">	
								<!--<input id="save" name="save" type="button" onclick="saveForm();" value="<?php echo __('save') ?>" />-->
								<a href="#" onclick="saveForm();" > <img src="wp-content/plugins/masvalor/app/includes/image/accept.png"></a> 
							</div>	
								
							<div style="float:left;padding-bottom: 20px;padding-left: 17px;padding-top: 24px;">
								<a href="<?php echo masvalor_getUrl(); ?>/faqs/"> <img src="wp-content/plugins/masvalor/app/includes/image/cancel.png"></a> 
							</div>
					
					
						<input type="hidden" name="cid" id="cid" value="<?php echo $V->data->ID;?>" />
						<input type="hidden" name="view" value="new" />
						<input type="hidden" name="task" id="task" value="" />
					</form>
							
	 </div>
		   
				