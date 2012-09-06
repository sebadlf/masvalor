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
class consultationModel {
    
   public function getData($cid){	
		
		if ($cid == null or $cid == "" )
		   $row = null;
		else
			$row = get_post( $cid);
		
		return	$row;

   }
   
   public function getDataPublication($cid){	
		
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_publications WHERE id_post ='.$cid.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		  foreach ($data as $aData):
		   return $aData;
		endforeach;
		return null;				
    }
    
    public function getDataUser($cid){	
		
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_bitacoras WHERE post_id ='.$cid.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		  foreach ($data as $aData):
		   return $aData;
		endforeach;
		return null;	
		
    }	
	
    public function saveUser($post_id,$cid,$userid,$type){
        global $wpdb;
		if ($cid == null or $cid == "" ){
	       	$sql = 'INSERT INTO '.$wpdb->prefix.'masvalor_bitacoras (post_id,userid,type) VALUES ('.$post_id.','.$userid.',"'.$type.'")';
		}
		else{
		 	$sql = 'UPDATE '.$wpdb->prefix.'masvalor_bitacoras SET userid='.$userid.',type= "'.$type.'"
                 			WHERE post_id='.$cid;
		
		}
		
		//var_dump($sql);
		
		$wpdb->get_var($sql);
   
    }
   public function save($cid,$postTitle,$post,$date){
		   $date2 = explode("-",$date);
		  $date_form = $date2[2].'-'.$date2[1].'-'.$date2[0];
		   
		   $post_date_espirate = $_POST['post_date_espirate'];
		   $priority = $_POST['priority'];
		   
		   $date2 = explode("-",$post_date_espirate);
		   $date_form_espirate = $date2[2].'-'.$date2[1].'-'.$date2[0];	
		  global $wpdb;
		  $id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='Actividades Bitacoras' 
				"
			); 
   					
 
	        global $user_ID;
	        
			if ($cid == null or $cid == "" ){
				$new_post = array(
					'post_title' => $postTitle,
					'post_content' => $post,
					'post_status' => 'publish',
					'post_date' => $date_form,
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
	            
								
				if($post_date_espirate != " "){
				
					$wpdb->insert( 
							$wpdb->prefix.'masvalor_publications', 
							array(
								'id_post' => $post_id[0]->id,
								'priority' => $priority,
								'post_date_espirate' => $date_form_espirate, 
								'name_publications' => "Bitacora" 
							), 
							array( 
								'%d',
								'%d', 
								'%s',
								'%s'							
							) 
						);
				
				} else{
				    
					$wpdb->insert( 
							$wpdb->prefix.'masvalor_publications', 
							array(
								'id_post' => $post_id[0]->id,
								'priority' => $priority,
								'name_publications' => "Bitacora" 
							), 
							array( 
								'%d',
								'%d', 
								'%s'							
							) 
						);
				
				
				}	
			}
            else{
			
			      $my_post = array();
				  $my_post['ID'] = $cid;
				  $my_post['post_title'] = $postTitle;
				  $my_post['post_content'] = $post;
				  $my_post['post_date'] = $date_form;		
				
				  wp_update_post( $my_post );
			      
                if($post_date_espirate != ""){						
				  
				  $wpdb->update( 
					   $wpdb->prefix.'masvalor_publications', 
					   array(
						'priority' => $priority,
						'post_date_espirate' => $date_form_espirate
					   ), 
					   array(
						'id_post' => $cid
					   ),
					   array( 
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
					   $wpdb->prefix.'masvalor_publications', 
					   array(
						'priority' => $priority						
					   ), 
					   array(
						'id_post' => $cid
					   ),
					   array( 
						'%d'						 
					   ),
					   array( 
						'%d' 
					   ) 
			  	   );
			}
			
			 
		}
			
	 
        $type = $_POST['type'];		
		$doctors = $_POST['doctors'];
		$companies = $_POST['companies'];
				
		if($type == "empresa")
		   $this->saveUser($post_id[0]->id,$cid,$companies,$type);	
		else
           $this->saveUser($post_id[0]->id,$cid,$doctors,$type);
	}
 		
}
?>