<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

 global $current_user;
 get_currentuserinfo();
 
 
get_header(); ?>

							   
						   
			<td id="main">  <!--Contend-->
					
					<div id="barra-superior">					
						
						<?php if ( is_user_logged_in() ) { ?>
                        	<div class="login-form" style="margin-top:5px;margin-right: 34px;">
																
								<?php echo __('Hola') ?> <?php echo $current_user->user_login; ?>
							    
							     <a href="<?php echo wp_logout_url(home_url()) ?>">  <?php echo __('Salir') ?></a>	
							</div>
							
							<div class="search-form">
								<div id="search-form">
									<?php get_sidebar(); ?>	
								</div>
							</div>
							
						<?php }else{?>		
						
							<div class="login-form">
								<!-- <form name="loginform" id="loginform" action="http://masvalordoc.conicet.gov.ar/wp-login.php" method="post"> -->
								<form name="loginform" id="loginform" action="<?php echo wp_login_url(); ?>" method="post">
									<div class="input-label">
										<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
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
							
							<div class="search-form">
								<?php get_sidebar(); ?>	
							</div>
							
						<?php }?>	
						
							
					</div>	
						
					<div class="container">
						
						<div id="content" role="main">
							
							<div class="columna-central">
								
								<?php 
								 $args = masvalor_getHomeEntry();
								 
								 //get_template_part( 'loop', 'index' );					
								?>
								
								<div id="post-1" class="post-1 post type-post status-publish format-standard hentry category-home">
									<div class="entry-content" id="entry-content">
										<?php echo $args[0]->post_content;?>
									</div>
								</div>
								
						    </div>
									
								<?php 
								   $argsNews = masvalor_getCategoryNews();
								   $argsActivities = masvalor_getCategoryActivities();
								   
								?> 
									
							<div class="columna-derecha">
								<div class="noticias-destacadas">
								    <h1>Noticias</h1>
											
											<?php 
												$actual_date = date('Y-m-d');
											    $contN=1;
												foreach ($argsNews as $valor): 
												if($valor->post_date_espirate >= $actual_date) { 
											     if($contN <= 3): ?>
														<h2>
															<?php echo $valor->post_title;?>
													   </h2>
													
														<div class="\"texto\"">
																<a href="#"></a>
															<p>
													    <?php if(strlen($valor->post_content) > 190) { ?>
																<?php	echo substr($valor->post_content,0,190); ?>
																<a href="<?php echo home_url() ?>/?p=<?php echo $valor->ID; ?>">... [+]</a>
														<?php } else { ?>
																<?php echo $valor->post_content; ?>
														<?php } ?>
															</p>
														</div>
											<?php 
											      $contN++;
											      endif;
												  }
											     endforeach;?>
											
																						
								</div>
								
									
								<div class="actividades-destacadas">
								   <h1>Actividades</h1>
									   
									   <?php 
									          $cont=1;
									          foreach ($argsActivities as $valor2):
											    if($cont <= 3): 
											     ?>
											    
												<h2>
												    <?php echo $valor2->post_title;?>
											   </h2>
											
												<div class="\"texto\"">
														<a href="#"></a>
													<p>
													<?php if(strlen($valor2->post_content) > 190) { ?>
															<?php	echo substr($valor2->post_content,0,190); ?>
															<a href="<?php echo home_url() ?>/?p=<?php echo $valor2->ID; ?>">... [+]</a>
													<?php } else { ?>
															<?php echo $valor2->post_content; ?>
													<?php } ?>
													</p>
												</div>
											
										<?php 
										      $cont++;
											  endif;
										      endforeach;?>
									
									
									<?php /* ?>
									<h2>
										<a href="http://masvalordoc.conicet.gov.ar/?p=180">Actividades destacadas 1</a>
									</h2>
									
									<div class="\"texto\"">
										<a href="http://masvalordoc.conicet.gov.ar/?p=180"></a>
										<p>
											<a href="http://masvalordoc.conicet.gov.ar/?p=180">Ea mei nullam facete, omnis oratio offendit ius cu. Doming takimata repudiandae usu an, mei dicant takimata id, pri eleifend inimicus euripidis at. His vero singulis ea, quem euripidis abhorreant mei ut, et populo iriure vix. Usu ludus affert voluptaria ei, vix ea error defini...</a>
										</p>
									</div>
								    
									<?php */ ?>
									
								</div>	
								
							</div>	
							
					    </div>	
					</div>
									
			</td>	 <!--END Contend-->
		</tr>		
	
<?php get_footer(); ?>
