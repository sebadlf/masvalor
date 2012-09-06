<?php
/**
 * The users dashboard
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The users dashboard
 *
 * Users with Subscriber role are directed here. Link to
 * change personal details page
 *
 * @package    Tina-MVC
 * @todo       add a Wordpress action hook to direct the user here after login
 */
class newsModel {
    
   public function getData(){
		global $wpdb;
		
		$sql = 'SELECT pos.*,p.priority,p.post_date_espirate FROM '.$wpdb->prefix.'masvalor_publications p'.','.'wp_posts pos
		                 WHERE p.id_post = pos.ID AND name_publications like "Noticias" ORDER BY p.priority';
		
		
		$data = $wpdb->get_results($sql);
		
		return $data;	
		
		/*
		$id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='noticias' 
				"
			);
															
		$args = array(
			'category'        => $id_category[0]->term_id,
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => 'post',
			'post_status'     => 'publish' ); 	
			
		$posts_array = get_posts( $args ); 

		return	$posts_array;*/


   }
   
   function delete($cid){
	global $wpdb;
   
     wp_delete_post( $cid);
   
	  $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_publications WHERE id_post='.$cid;
	  $data = $wpdb->query($sql,OBJECT_K);



   }
   

}
?>