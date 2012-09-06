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
<?php 
global $current_user;
get_currentuserinfo();
if ($current_user->data == null) {
?>
<h2><?php echo __('Ingresar como ') ?><?php echo strtoupper($V->usertype) ?></h2>

<h3><?php echo $V->msg;?></h3>

<fieldset style="background-color: #e3e3e3;">
<div style="margin-left: 20px;">
	<div class="wppb_holder" id="wppb_login">
		<form action="" method="post" class="sign-in">
			<p class="login-form-username">
				<label for="user-name">Nombre de usuario</label>
								<input name="username" id="username" class="text-input" value="" type="text">			</p><!-- .form-username -->

			<p class="login-form-password">
				<label for="password">Contrase&ntilde;a</label>
				<input name="password" id="password" class="text-input" type="password">
			</p><!-- .form-password -->
			<p class="login-form-submit">
				<input name="submit" class="submit button" value="Acceder" type="submit">
			</p><!-- .form-submit -->
			<input type="hidden" name="task" id="task" value="login"/>
		</form>
	</div>
</div>
</fieldset>
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


							

