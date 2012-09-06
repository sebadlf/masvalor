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
class faqModel {
    
   public function getData($cid){	
		
		if ($cid == null or $cid == "" )
		   $row = null;
		else
			$row = get_post( $cid);
		
		return	$row;

   }
   
   
   public function save($cid,$postTitle,$post){
		
		   
		  global $wpdb;
		  $id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='faqs' 
				"
			); 
   					
 
	        global $user_ID;
	        
			if ($cid == null or $cid == "" ){
				$new_post = array(
					'post_title' => $postTitle,
					'post_content' => $post,
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_type' => 'post',
					'post_category' => array($id_category[0]->term_id),
				);
			 
				wp_insert_post($new_post);
			}
            else{
			
			      $my_post = array();
				  $my_post['ID'] = $cid;
				  $my_post['post_title'] = $postTitle;
				  $my_post['post_content'] = $post;
		
				  wp_update_post( $my_post );
			      
			}
			
			 
			
	 
	}
 		
}
?>