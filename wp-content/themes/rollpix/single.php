<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

 
function isApplicat($cid){
		global $wpdb;
		global $current_user;
		get_currentuserinfo();	
		
		$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_activities_registered
		                 WHERE  id_activity = "'.$cid.'" AND userid = "'.$current_user->ID.'"';
		
		$data = $wpdb->get_results($sql);
		
		foreach ($data as $aData):
			$count = $aData->count;
		endforeach;
		
		if($count > 0)
		  return true;
		else
          return false;	

} 
 
 
global $wpdb;
  $id_activities = $wpdb->get_results( 
		"
		SELECT term_id
		FROM $wpdb->terms
		WHERE name ='actividades' 
		"
  );  
 
  $sql = 'SELECT COUNT(*)as count FROM '.$wpdb->prefix.'term_relationships 
		                                     WHERE object_id='.$_GET['p'].' AND
		                                           term_taxonomy_id = '. $id_activities[0]->term_id;
  
  $data = $wpdb->get_results($sql,OBJECT_K);
   foreach ($data as $aData):
		    $count=$aData->count;
   endforeach;
 
 
  
  if( $_GET['accept']==1){
    
	global $current_user;
	get_currentuserinfo();
	global $wpdb;
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$date=date("Y-m-d");
	
	
		$wpdb->insert( 
				$wpdb->prefix.'masvalor_activities_registered', 
				array(
				 'id_activity' => $_GET['p'],
				 'userid' => $current_user->ID,
				 'registration_date' => $date			 
				), 
				array( 
					 '%d',
					 '%d',
					 '%s'				 
				) 
			   );
			   
    
  }
 
 
 get_header();
 ?>

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
									<!-- 	<input type="text" name="log" id="user_login" class="input" value="Usuario" size="20" tabindex="10" /></label> -->
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
							<a href="javascript:history.back(1)">
									<img src="wp-content/themes/rollpix/images/headers/back.png">
							</a>
						</div>	
						
							 <?php if($_GET['accept']== 1){?>
								  <h2 style="color:red;  margin-bottom: -25px;;margin-left:33px;"><?php echo "Inscripci&oacute;n Registrada!";?></h2>
							 <?php } ?>
						
						<div id="content" role="main">
							<?php if($count ==0){?>		
							
								<div id="category_masvalor">
									<?php  get_template_part( 'loop', 'index' );?>
								</div> 
							
							<?php }else{ ?>	
								
								<div id="category_masvalor">
								   								
									<?php  get_template_part( 'loop', 'index' );?>
								    									
									
									<?php if(!isApplicat($_GET['p'])){ ?>
											
											<?php if($current_user->ID != null){ ?>
												 <form action="" method="post">
													<div style="float: right;margin-right: 45px;margin-top: -19px;">
														<a href="?p=<?php echo $_GET['p']?>/&accept=1" title="INSCRIBIRME">
															<input type="button" name="incribirme" id="incribirme" value="INSCRIBIRME" />
															<input type="hidden" name="accept" id="accept" value="1" />
														</a>
													</div>
												</form> 
										   <?php }else{ ?>
										         <div style="float: right;margin-right: 45px;margin-top: -5px;width: 270px;color:red">
												   <?php echo __('si quiere inscribirse a una actividad debe estar logueado como doctor.') ?>
										         <div>
										   <?php } ?>	
									<?php } ?>	   
								</div> 
								
							<?php } ?>		
						</div>	
					</div>	 
			
			</td>	<!--END Contend-->
     </tr>
	 
<?php get_footer(); ?>
