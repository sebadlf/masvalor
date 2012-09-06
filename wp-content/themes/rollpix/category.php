<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

global $wpdb;
  $id_cases = $wpdb->get_results( 
		"
		SELECT term_id
		FROM $wpdb->terms
		WHERE name ='casos' 
		"
  ); 
  
  $id_news = $wpdb->get_results( 
		"
		SELECT term_id
		FROM $wpdb->terms
		WHERE name ='Noticias' 
		"
  ); 
  
get_header(); ?>

<?php require_once ('wp-content/plugins/masvalor/app/models/masvalor_utils.php'); ?>

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
					
					    <div class="search-form">
							<?php get_sidebar(); ?>	
						</div>
					     
					<?php }?>		

					
					</div>	
						
					<div class="container">
						
						<div style="float: right;margin-right: 68px;margin-top: 36px;">
							<a href="<?php echo home_url(); ?>"> <!--javascript:history.back(1)-->
									<img src="wp-content/themes/rollpix/images/headers/back.png">
							</a>
						</div>	
						
						<div id="content" role="main">
							
							<?php if($id_cases[0]->term_id == $_GET['cat']){ ?>	
								<div id="category_masvalor">
									<h1 style="margin-left:20px;"> Casos de &Eacute;xito</h1>
									<!--?php  get_template_part( 'loop', 'index' );?-->
									
									 <?php $datas = masvalor_getCategoryPublications("Casos");
											      foreach($datas as $data): ?>
												        <h2 class="entry-title">
															 <a rel="bookmark" title="Enlace permanente a noticia 2" href="/?p=<?php echo $data->ID; ?>">
																<?php echo $data->post_title; ?>
															 </a>
													    </h2>
												        
														<?php 
																$date= explode(" ", $data->post_date);
																$date2 = explode("-",$date[0]);
																$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
														?>
														
														<div class="entry-meta">
															<span class="meta-prep meta-prep-author">Publicado el <?php echo $dateend; ?></span>
														</div>
														<div class="entry-summary">
															<p>
																<?php $titulomostrado = substr($data->post_content,0,205);
																     echo  $titulomostrado."...";?>
															<a href="<?php echo home_url(); ?>/?p=<?php echo $data->ID; ?>">
																Sigue leyendo
																<span class="meta-nav">-></span>
															</a>
															</p>
														</div>
														
														<hr style="width:650px; margin-top:19px;"/>		
														
												<?php endforeach;?>
												
								</div>	
							<?php }else{?>
								  
								  <?php if($id_news[0]->term_id == $_GET['cat']){ ?>	
										<div id="category_masvalor">
											<h1 style="margin-left:20px;">Noticias</h1>	
											<!--?php  get_template_part( 'loop', 'index' );?-->
											
											    <?php $datas = masvalor_getCategoryPublications("Noticias");
											      foreach($datas as $data): ?>
												        <h2 class="entry-title">
															 <a rel="bookmark" title="Enlace permanente a noticia 2" href="/?p=<?php echo $data->ID; ?>">
																<?php echo $data->post_title; ?>
															 </a>
													    </h2>
												        
														<?php 
																$date= explode(" ", $data->post_date);
																$date2 = explode("-",$date[0]);
																$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
														?>
														
														<div class="entry-meta">
															<span class="meta-prep meta-prep-author">Publicado el <?php echo $dateend; ?></span>
														</div>
														<div class="entry-summary">
															<p>
																<?php $titulomostrado = substr($data->post_content,0,205);
																     echo  $titulomostrado."...";?>
															<a href="<?php echo home_url(); ?>/?p=<?php echo $data->ID; ?>">
																Sigue leyendo
																<span class="meta-nav">-></span>
															</a>
															</p>
														</div>

														
														<hr style="width:650px; margin-top:19px;"/>		
														
												<?php endforeach;?>
											
										</div>	
																  
								  <?php }else{?>
								      
									  <div id="category_masvalor">
											<h1 style="margin-left:20px;">Actividades</h1>	
											<!--?php  get_template_part( 'loop', 'index' );?-->
											
											<?php $datas = masvalor_getCategoryActivities();
											
											if (empty($datas)){
									   	
									   		echo "<div class='texto_prox_cat'>Pr&oacute;ximamente...</div>";
									   	
									   		}
									   		else 
									   		{
											   foreach($datas as $data): ?>
												        <h2 class="entry-title">
															 <a rel="bookmark" title="Enlace permanente a noticia 2" href="/?p=<?php echo $data->ID; ?>">
																<?php echo $data->post_title; ?>
															 </a>
													    </h2>
												        
														<?php 
																$date= explode(" ", $data->post_date);
																$date2 = explode("-",$date[0]);
																$dateend = $date2[2].'-'.$date2[1].'-'.$date2[0];
														?>
														
														<div class="entry-meta">
															<span class="meta-prep meta-prep-author">Publicado el <?php echo $dateend; ?></span>
														</div>
														<div class="entry-summary">
															<p>
																<?php $titulomostrado = substr($data->post_content,0,205);
																     echo  $titulomostrado."...";?>
																<a href="<?php echo home_url(); ?>/?p=<?php echo $data->ID; ?>">
																	Sigue leyendo
																	<span class="meta-nav">-></span>
																</a>
															</p>
														</div>
														
														<hr style="width:650px; margin-top:19px;"/>		
														
												<?php endforeach;
												
									   		} //else
												
												?>
												
									 </div>
										
								  <?php }?>
								  
							<?php }?>
							
						</div>	
					</div>	 
			
			</td>	 <!--END Contend-->
		</tr>	
	
<?php get_footer(); ?>
