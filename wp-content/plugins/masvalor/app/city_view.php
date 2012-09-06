<?php  if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();?>

<?php require_once ('models/masvalor_utils.php'); ?>


<?php   		   
	   $date2 =$V->data->post_date;
	   $date = explode(' ',$date2);
	   $date2 = explode("-",$date[0]);
	   $dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
				
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
 
 
<script language="javascript" type="text/javascript">
function validateFields(){
			retorno = false;
			var msg = new Array();
		    var error = false;

		  if (jQuery("#name").val() == ""){
			msg.push('<?php echo __('Debe ingresar un nombre.');?>');
			error = true;
		  }
		  
		 
		   
		  if (error){
		  alert(msg.join('\n'));
		  return false;
		  }
		 else
		  return true;
		  
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

function saveForm(){
    if (validateFields()){
	    if(confirm("¿Est\u00e1 seguro que quiere guardar la cuidad?")) { 
			document.forms['adminForm'].task.value = 'save';
			document.forms['adminForm'].submit();
        }			
	}	
}


</script>  


<style>

#table_noticia thead{
  background-color: #adaeb2;
}

a{
 text-decoration: none;
 color:black;
}
</style>
           
			
	 <div style="margin-top:20px;font-size:14px">
				 <form action="" method="post" name="tinymce" id="adminForm">
					 <h3><?php echo __('Agregar/Editar Ciudad') ?></h3>
					  <br/>
					 <fieldset class="adminform" style="width: 636px;background-color: #ffffff;box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1) inset;color: #000000;">
							<table class="admintable" style="margin-left:37px;margin-top:15px;">										  
								
									
								<tr>
									<td class="key"><?php echo __('Pa&iacute;s'); ?>(*)</td>
									<td><?php echo $V->combos->getCountries(checkSubmited($V->data,'country'),'country') ?></td>
								</tr>
								
								<tr>
									<td class="key"><?php echo __('Provincia'); ?>(*)</td>
									<td id="stateContainer" ><?php echo $V->combos->getStates(checkSubmited($V->data,'state'),checkSubmited($V->data,'country'),'state') ?></td>
								</tr>
								
								<tr>
									<td><label for="post_title"><?php echo __('Ciudad') ?>(*)</label></td>
									<td><input name="name"  id="name" size="35" type="text" value="<?php echo $V->data->city;?>" /></td>
								</tr>
														  
							</table>
							
							<div style="float:left;padding-bottom: 20px;padding-left: 99px;padding-top: 20px;">	
								<a href="#" onclick="saveForm();" > <img src="wp-content/plugins/masvalor/app/includes/image/accept.png"></a> 
							</div>	
								
							<div style="float:left;padding-bottom: 20px;padding-left: 17px;padding-top: 24px;">
								<a href="<?php echo masvalor_getUrl(); ?>/cities/"> <img src="wp-content/plugins/masvalor/app/includes/image/cancel.png"></a> 
							</div>
					
					
						<input type="hidden" name="cid" id="cid" value="<?php echo $V->data->id;?>" />
						<input type="hidden" name="view" value="new" />
						<input type="hidden" name="task" id="task" value="" />
					</form>
							
	 </div>
		   
				