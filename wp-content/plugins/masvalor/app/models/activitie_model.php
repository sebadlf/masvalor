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
class activitieModel {
    
   public function getData($cid){	
		
		if ($cid == null or $cid == "" )
		   $row = null;
		else
			$row = get_post( $cid);
		
		return	$row;

   }
   
   public function getDataDates($cid){	
		
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_activities WHERE post_id='.$cid.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		  foreach ($data as $aData):
		   return $aData;
		endforeach;
		return null;				

   }
   
   public function save($cid,$postTitle,$post,$start_date,$end_date){
		
		    $post_date_espirate = $_POST['post_date_espirate'];
		    $priority = $_POST['priority'];
		   
		  global $wpdb;
		  $id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='actividades' 
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
				
				$post_id = $wpdb->get_results( 
						"
						SELECT MAX(ID) as id
						FROM $wpdb->posts
						
						"
					);
	    
			if($post_date_espirate != ""){
				
				$wpdb->insert( 
						$wpdb->prefix.'masvalor_activities', 
						array(
							'post_id' => $post_id[0]->id,
							'start_date' => $start_date, 
							'end_date' => $end_date, 
							'priority' => $priority,
							'post_date_espirate' => $post_date_espirate		
						), 
						array( 
							'%d',
							'%s', 
							'%s',
							'%d',
							'%s' 
						) 
					);
				
				}
				else{
				    
					$wpdb->insert( 
							$wpdb->prefix.'masvalor_activities', 
							array(
								'post_id' => $post_id[0]->id,
								'start_date' => $start_date, 
								'end_date' => $end_date,
								'priority' => $priority
							), 
							array( 
								'%d',
								'%s', 
								'%s',
								'%d'								
							) 
						);
				
			
			}
			
			}
            else{
			
			      $my_post = array();
				  $my_post['ID'] = $cid;
				  $my_post['post_title'] = $postTitle;
				  $my_post['post_content'] = $post;
		
				  wp_update_post( $my_post );
				  
                if($post_date_espirate != ""){
				   $wpdb->update( 
					   $wpdb->prefix.'masvalor_activities', 
					   array(
						'start_date' => $start_date, 
						'end_date' => $end_date, 
						'priority' => $priority,
						'post_date_espirate' => $post_date_espirate
					   ), 
					   array(
						'post_id' => $cid
					   ),
					   array( 
						'%s',
						'%s',
						'%d',
						'%s'
					   ),
					   array( 
						'%d'
					   ) 
			  	   );
				
				}
				else{	
     				$wpdb->update( 
					   $wpdb->prefix.'masvalor_activities', 
					   array(
						'start_date' => $start_date, 
						'end_date' => $end_date,
						'priority' => $priority					
						
										
					   ),
					   array( 
						'post_id' => $cid
					   ),
					   array( 
						'%s',
						'%s',
						'%d' 
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
			    }  
			}
			
			 
			
	 
	}
 		
}
?>