<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

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
										<input type="text" name="log" id="user_login" class="input" value="Usuario" size="20" tabindex="10" /></label>
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
						  
						  <div style="margin-top:16px;margin-left:16px;" id="category_masvalor">
						  
							<?php if ( have_posts() ) : ?>
							     <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
												<?php
												/* Run the loop for the search to output the results.
												 * If you want to overload this in a child theme then include a file
												 * called loop-search.php and that will be used instead.
												 */
												 get_template_part( 'loop', 'search' );
												?>
								<?php else : ?>
												<div id="post-0" class="post no-results not-found">
													<h2 class="entry-title"><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
													<div class="entry-content">
														<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
														<?php get_search_form(); ?>
													</div><!-- .entry-content -->
												</div><!-- #post-0 -->
								<?php endif; ?>
							</div>	
						</div>	
					</div>	 
			
			</td>	 <!--END Contend-->
	</tr>	
	
<?php get_footer(); ?>
