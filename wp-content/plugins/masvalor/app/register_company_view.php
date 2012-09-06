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
?>


    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/columnas.css" type="text/css" />

    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/css/estilos.css" type="text/css" />

    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/jquery.js"></script> 
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/js/pestanas.js"></script>

    <script language="JavaScript" src="wp-content/plugins/masvalor/app/includes/calendar/calendar_db.js"></script>
    <link rel="stylesheet" href="wp-content/plugins/masvalor/app/includes/calendar/calendar.css">
	
	<link type="text/css" href="wp-content/plugins/masvalor/app/includes/css/slider/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> 
    
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/slider/jquery-ui-1.8.16.custom.min.js"></script>
          
    <script type="text/javascript" src="wp-content/plugins/masvalor/app/includes/popup/jquery.simplemodal.1.4.2.min.js"></script>
    
<style>
fieldset.adminform {
    border: 1px solid #333333;
}

#tableSelectedEducation thead{
  background-color: #8A8669;
}

#tableSelectedEducation tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedEducationPos thead{
  background-color: #8A8669;
}

#tableSelectedEducationPos tbody{
   border-right: 1px solid;
   height:100%;
}

#tableSelectedTesis thead{
  background-color: #8A8669;
}

#tableSelectedTesis tbody{
   border-right: 1px solid;
   height:100%;
}


#tableSelectedExperiencia thead{
  background-color: #8A8669;
}
   
#tableSelectedExperiencia tbody{
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
</style>

<script type="text/javascript">

function validateEmail($email) { var emailReg = /^[a-zA-Z0-9_-]{2,}@[a-zA-Z0-9_-]{2,}\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,4})?$/; return emailReg.test( $email );}

function validateFields(){
    retorno = false;
    var msg = new Array();
	var error = false;

    if (jQuery("#username").val() == ""){
         msg.push("<?php echo __('Debe ingresar un nombre de usuario.');?>");
		 error = true;
		 }
	if (jQuery("#userid").val() == '')
		if (jQuery("#password").val() == ""){
			 msg.push('<?php echo __('Debe ingresar un password.');?>');
			 error = true;
			 }
	if (jQuery("#userid").val() == '')
		if (jQuery("#password2").val() == ""){
			 msg.push('<?php echo __('Debe repetir el password.');?>');
			 error = true;
			 }
    if (jQuery("#password").val() != jQuery("#password2").val()){
        msg.push('<?php echo __('Ambas contrasenas deben coincidir.');?>');
		error = true;
		 }
	if (jQuery("#email").val().indexOf('@', 0) == -1 || jQuery("#email").val().indexOf('.', 0) == -1){
        msg.push('<?php echo __('Debe ingresar una direcci\u00f3n de email v\u00e1lida.');?>'); 
		error = true;
		 }
	if (jQuery("#userid").val() == '')
		if (!jQuery("#cb_tyc").is(':checked')){
			msg.push('<?php echo __('Debe aceptar los t\u00e9rminos y condiciones.');?>'); 
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
	jQuery("#username").attr('disabled',false);
	if (validateFields()){
		document.getElementById('adminForm').submit();
	}	
}

</script>


<?php 
if (is_wp_error($V->msg))
	foreach ($V->msg->get_error_codes() as $error):
		echo $V->msg->get_error_message($error);
	endforeach;

?>
<?php
	if ($V->userData->data == null)
		$newUser='true';
	  else
		$newUser='false';
?>

<div class="message" style="margin-left:-10px;margin-bottom:20px;">
  <h3 style="color:#ea0000"><?php  if ($V->msg!=null )echo __('Cambios guardados con &eacute;xito') ?></h3>
</div>         		  
			  
<div class="message" style="margin-left:-10px;margin-bottom:20px;">
  <h3 style="color:#ea0000"><?php  if ($V->msg2!=null )echo __('El Usuario y/o el email ya existen') ?></h3>
</div>
			  
<form action="" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable" width="100%">
		
		<tbody>
			<tr>
				<td valign="top">
				    <h2><?php echo __('Registro de Empresas e Instituciones') ?></h2>
					<br/>
					<fieldset class="adminform" style=";width: 98%;background-color: #fff;">
						
						<table class="admintable" style="margin-left:37px;">
							
							<tr>
							    <td class="key"><div style="margin-bottom:20px;"></div></td>
						    </tr>							
							
							<tr>
								<td class="key"><?php echo __('Nombre de usuario') ?>(*)</td>
								<td><input class="text_area" type="text" <?php if ($newUser=='false') echo 'disabled'?> name="username" size="56" id="username" value="<?php echo $V->userData->data->user_login ?>" /></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Nueva contrase&ntilde;a') ?></td>
								<td style="padding-left:3px;"><input class=" text_area" type="password" name="password" size="56" id="password" value=""/></td>
							</tr>
							
							<tr>
								<td class="key"><?php echo __('Verificar contrase&ntilde;a') ?></td>
								<td style="padding-left:3px;"><input class="text_area" type="password" name="password2" size="56" id="password2" value=""/></td>
							 </tr>
							 
							  <tr>
							     <td class="key"><div style="margin-top:15px;;"></div></td>
						      </tr>
							
							  <tr>
							     <td class="key"><div style="margin-bottom:20px;"></div></td>
						      </tr>
							  
							  <tr>
								<td class="key"><?php echo __('E-mail')?>(*)</td>
								<td style="padding-left:3px;" ><input class="text_area" type="text" name="email"  size="56" id="email" value="<?php echo $V->userData->data->user_email ?>" /></td>
							  </tr>   							
								
							  <tr>
							    <td class="key"><div style="margin-bottom:30px;"></div></td>
						      </tr>	
							  							  								
							  <tr <?php if ($newUser=='false') echo 'style="display:none"'?>>
								<td colspan="2"><div class="t-y-c" style="box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.1) inset;color: #000000;margin: 1px 1px 1px 3px;width: 531px;height:313px;overflow-x:hidden; overflow-y:scroll;background-color:#FFFFFF"><?php echo $V->term_condition ?></div></td>
							  </tr>	
						     
							  <tr>
							    <td class="key"><div style="margin-bottom:19px;"></div></td>
						      </tr>
							  
							  <tr <?php if ($newUser=='false') echo 'style="display:none"'?>>   
								<td><INPUT id="cb_tyc" name="dis_opt1" TYPE="CHECKBOX" VALUE=""></td>
								<td class="key" style="float:left;margin-bottom: -2px;margin-left: -79px;margin-top: 3px;"><?php echo __('Acepto los t&eacute;rminos y condiciones') ?></td>
							  </tr>	
							  
							  <?php /*?>
							   <tr>
									 <td class="key" style="vertical-align:top; padding-top: 22px;"><?php echo __('Contrato')?></td>
									 <td><div style="float: left;margin-left: -32px;margin-top: 13px;">
											<a href="wp-content/plugins/masvalor/app/includes/convenio-empresas-masvalor.pdf" target="_black" title="<?php echo __('Descargue Contrato')?>"> <img src="wp-content/plugins/masvalor/app/includes/image/save-pdf.png"></a>
										 </div>
										 <div style="float: left;margin-left: 30px;margin-top: 13px;font-size:10px;margin-right: 34px">			
											<?php echo __('(Descargue e imprima el siguiente contrato de participaci&oacute;n en el programa Mas Valor.COM y envie una copia firmada a XXXXXXX')?>)
										  </div>
									 </td>
							    </tr>
							  <?php */?>
							  
							  <tr>
								<td><input type="button" style="margin-top:16px;margin-bottom:20px;" name="register" onclick="submitForm()" class="submit button" value="<?php if ($newUser=='false') echo __('Actualizar'); else echo __('Registrarse'); ?>" /></td>
							  </tr>
						</table>
						
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="task" id="task" value="save"/>
	<input type="hidden" name="userid" id="userid" value="<?php echo $V->userData->data->ID ?>"/>
</form>

							

