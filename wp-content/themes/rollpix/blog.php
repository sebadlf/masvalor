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

get_header(); ?>

		<div style="clear:both"></div>

			
			<div class="middlediv">
			       
				<!-- <div class="navigation2">  <!--menu Body-->
						
					<!--	<div id="header-top-menu_body">
						    <?php /* wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'thirdty' ) );*/?>
						</div>
									
						
					</div> <!--END navigation2--> <!--END menu Body-->
					
					
			       <ul class="navigation3"> </ul>  <!--END navigation3-->
				   
				   			       
				    <div id="content">  <!--Contend-->
				   
							<div class="info_contenido">
								   
							     	
										<div class="volver">
												<a href="javascript:history.back(1)">
														<img src="wp-content/themes/rollpix/images/headers/volver.png">
												</a>
										</div>
										
																	
										
											<div id="portlet-borderless-container" >
												<?php query_posts('cat=-0'); //gets all posts
													load_template( TEMPLATEPATH . '/index.php'); //loads index
												?>
											</div> 
											
										
											<div id="boton_subir_content" style="display: block;" name="subir">
												<a target="_top" href="#">    
													<img border="0" alt="" src="wp-content/themes/rollpix/images/headers/subir.png">
												</a>
											</div>
																											
							
							</div>
											
					</div>	 <!--END Contend-->
					
					
					<div style="clear:both"></div>

	
<?php get_footer(); ?>
