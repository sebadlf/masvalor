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


<?php require_once ('models/masvalor_utils.php'); ?>

<style>
.login_form {

    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #E5E5E5;
    box-shadow: 0 4px 10px -1px rgba(200, 200, 200, 0.7);
    font-weight: normal;
    margin-left: 8px;
    padding: 1px 177px 28px;
}

.button-primary2{
    height: 32px !important;
    width: 206px !important;

}

#registro_lostpasswor{
     margin-left: 29px;
	 margin-top: 24px;
}

#registro_lostpasswor a {
   color:#6F6F6F;
}
</style>



<?php 
global $current_user;
get_currentuserinfo();
if ($current_user->data == null) {
?>
<h2 style="color:#ea0000" ><?php echo __('&#161;Error! - Su usuario o contrase&ntilde;a son inv&aacute;lidos') ?><?php echo strtoupper($V->usertype) ?></h2>

<p class="message">
        Por favor, escribe tu nombre de usuario o tu correo electr&oacute;nico. 
		Recibir&aacute;s un enlace para crear la contrase&ntilde;a nueva por 
		correo electr&oacute;nico.
</p>

<form class="login_form" name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
			
	<p>
	    <a style=" margin-left: -22px;" href="<?php echo esc_url( home_url( '/' ) ); ?>"> <img src="wp-content/plugins/masvalor/app/includes/image/masvalordoc.png"></a> 
		
		<label for="user_login" ><?php _e('Username or E-mail:') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20"  /></label>
	</p>
<?php do_action('lostpassword_form'); ?>  <?php //echo esc_attr( '' ); ?>
	<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/' ) ); ?>" />
	<p style=" margin-left: -19px;" class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary2" value="<?php esc_attr_e('Get New Password'); ?>" style="width:220px !important;"/></p>
   
</form>

	<div id="registro_lostpasswor" >	
	   <ul>	
		    <li><a href="<?php echo masvalor_getUrl(); ?>/register-doctor/"> Reg&iacute;strese como Doctor</a></li>
			<li><a href="<?php echo masvalor_getUrl(); ?>/register_company/"> Reg&iacute;strese como Empresa / Instituci&oacute;n</a></li>
	   </ul>
	</div>

<?php } else {?>

<fieldset style="background-color: #e3e3e3;">
	<div style="margin-left: 20px;">
		<div id="wppb_login" class="wppb_holder">
			<form action="" method="post" class="sign-out">
				<p class="alert"><?php echo __('Usted esta logeado como: ').$current_user->user_login.'.' ?></p>
				<p class="login-form-submit">
					<input name="submit" class="submit button" value="Log out" type="submit">
				</p>
				<input type="hidden" name="task" id="task" value="logout"/>
			</form>
		</div>
	</div>
</fieldset>

<?php }?>


<script>
	document.onload = hide();
	function hide(){
		var parent = document.getElementById("barra-superior");
		var loginForm = document.getElementsByClassName("login-form")[0];
		parent.removeChild(loginForm);
	}
</script>							

