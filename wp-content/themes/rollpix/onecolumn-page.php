<?php
/**
 * Template Name: One column, no sidebar
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */


get_header(); ?>

		<div style="clear:both"></div>

			
			<div class="middlediv">
			       
				    <!-- <div class="navigation2">  <!--menu Body-->
						
					<!--<div id="header-top-menu_body">
						    <?php /* wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'thirdty' ) );*/ ?> 
						</div>
									
						
					</div> <!--END navigation2--> <!--END menu Body-->
					
					<div id="header-top-menu_inferior">
							<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ) ); ?>
							
						</div>
			       <ul class="navigation3"> </ul>  <!--END navigation3-->
				   
				   			       
				    <div id="content">  <!--Contend-->
				   
							<div class="info_contenido">
								   
							     	
										<div class="volver">
												<a href="javascript:history.back(1)">
														<img src="wp-content/themes/rollpix/images/headers/volver.png">
												</a>
										</div>
										
																	
										
											<div id="portlet-borderless-container" >
												<?php  get_template_part( 'loop', 'index' );?>
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

