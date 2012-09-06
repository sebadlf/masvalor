<?php

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	
	wp_head();
?>

<script type="text/Javascript">
function expandcollapse (postid) {
   whichpost = document.getElementById(postid);
   if (whichpost.className=="postshown") {
      whichpost.className="posthidden";
   }
   else {
      whichpost.className="postshown";
   }
}</script>

<script type="text/javascript" language="javascript">
		function allocateSidebarHeight() {
		var contentDom = document.getElementById("content");
		var sidebarDom = document.getElementById("access");
		if((contentDom.offsetHeight-1500) > sidebarDom.offsetHeight) {
		sidebarDom.style.height = (contentDom.offsetHeight-1500)+"px"; }
		}

		startList = function() {
		if (document.all&&document.getElementById) {
		navRoot = document.getElementById("nav");
		for (i=0; i<navRoot.childNodes.length; i++) {
		node = navRoot.childNodes[i];
		if (node.nodeName=="LI") {
		node.onmouseover=function() { this.className+=" over"; }
		node.onmouseout=function() { this.className=this.className.replace(" over", ""); } } } }
		allocateSidebarHeight(); }

		window.onload=startList;
</script>
</head>


<body <?php body_class(); 

 global $current_user;
 get_currentuserinfo();
 
 
?>>

 
<table id="wrapper" class="hfeed">
	<tbody>
        <tr>
	
			<td id="header">
					<div id="masthead">
						
						<div class="logo-masvalor">
							<a href="<?php echo home_url();?>">
								<img alt="+valor.doc" WIDTH="218" HEIGHT="113"  src="wp-content/themes/rollpix/images/custom/masvalordocnew.png">
							</a>
						</div>
						
						
						<div id="access" role="navigation">
								<div class="skip-link screen-reader-text">
										<a title="Saltar al contenido" href="#content">Saltar al contenido</a>
								</div>
								<div class="menu-header">
								    
									<div class="menu-header-login" >
										
										<?php if ( is_user_logged_in() ) {

											if ( checkUserType($current_user->user_login,'masvalor-admin') OR $current_user->user_login == 'admin')
												/*menu administrador users*/
												wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'seventh' ) );
											
											if (checkUserType($current_user->user_login,'doctor'))
												/*Menu doctor logueado*/
												wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'fifth' ) ); 
											
											if ( checkUserType($current_user->user_login,'company'))
											   /*Menu empresa logueado*/
											   wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'sixth' ) );
										}
										else
										   /*menu registro doctores/empresa*/
											wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'thirdty' ) );
																						
										?>	
									    									
									</div>																	
									
									<!--item de menu que siempre estan-->
									<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
									
									<?php if ( is_user_logged_in() ) {
										
											if ( checkUserType($current_user->user_login,'masvalor-admin') OR $current_user->user_login == 'admin')
												/*menu administrador*/
												wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ) );
										
									} ?>
									
									<?php //get_sidebar(); ?>	
									
								</div>
						</div>
														
					</div>
			</td>  <!-- end head-->
  