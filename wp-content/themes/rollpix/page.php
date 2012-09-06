<?php
require_once(WP_PLUGIN_DIR.'/event-calendar-scheduler/scheduler.php');


	global $current_user;
	get_currentuserinfo();
	//var_dump($current_user);

get_header(); ?>
				
			<td id="main">  <!--Contend-->
															
					<div id="barra-superior">
						
					<?php if ( is_user_logged_in() ) { ?>
					
						<div class="login-form" style="margin-top:5px;margin-right: 34px;">
																
							<?php echo __('Hola') ?> <?php echo $current_user->user_login; ?>
							    
						     <a href="<?php echo wp_logout_url(home_url()) ?>"><?php echo __('Salir') ?></a>	
						</div>
												
						<div class="search-form">
								<div id="search-form">
									<?php get_sidebar(); ?>	
								</div>
						</div>
					
					<?php }else{?>	
						
						<div class="login-form">
								<!--<form name="loginform" id="loginform" action="http://masvalordoc.conicet.gov.ar/wp-login.php" method="post">-->
								<form name="loginform" id="loginform" action="<?php echo wp_login_url(); ?>" method="post">								
								
								  <div class="input-label">
										<input type="text" name="log" id="user_login" class="input" value="usuario" size="20" tabindex="10" onblur="if (this.value == '') document.getElementById('user_login').value = 'usuario'" onfocus="document.getElementById('user_login').value = ''"/></label>
									</div>
									
									<div class="input-label">
										<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
									</div>
									
									<div class="submit">
											<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Ingresar" tabindex="100" />
											<input type="hidden" name="redirect_to" value="" />
											<input type="hidden" name="testcookie" value="1" />
									</div>

								</form>
						</div>
					
					    <div class="search-form" style="float:right;">   
							<?php get_sidebar(); ?>	
						</div>
						
					<?php }?>		

						
					</div>	
						
					<div class="container">
						<div id="content" role="main">
							<?php  get_template_part( 'loop', 'index' );?>
						</div>	
					</div>	 
			
			</td>	 <!--END Contend-->
	</tr>				
			
<!--?php get_sidebar(); ?-->					
<?php get_footer(); ?>
