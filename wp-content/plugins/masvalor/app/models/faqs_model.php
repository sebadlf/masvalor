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
class faqsModel {
    
   public function getData(){
		global $wpdb;
		$id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='faqs' 
				"
			);
															
		$args = array(
			'category'        => $id_category[0]->term_id,
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => 'post',
			'post_status'     => 'publish' ); 	
			
		$posts_array = get_posts( $args ); 

		return	$posts_array;

   }
   
   function delete($cid){
   
     wp_delete_post( $cid);
   
   }
   

}
?>