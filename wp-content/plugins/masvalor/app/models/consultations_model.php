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
class consultationsModel {
    
   public function getData(){
		global $wpdb;
		                                        
		/*$sql = 'SELECT pos.*,p.priority,p.post_date_espirate FROM '.$wpdb->prefix.'masvalor_publications p'.','.'wp_posts pos
		                 WHERE p.id_post = pos.ID AND name_publications like "Bitacora" ORDER BY p.priority';*/
		
		$sql = 'SELECT pos.*,p.priority,p.post_date_espirate,bi.type,
                          CASE bi.type 
						  WHEN "doctor" THEN (SELECT CONCAT(CONCAT(pr.lastname,","),pr.name) FROM '.$wpdb->prefix.'masvalor_profiles pr WHERE pr.userid = bi.userid)
   						  ELSE (SELECT com.name FROM '.$wpdb->prefix.'masvalor_companies com WHERE com.userid = bi.userid) 
						  END AS name_user 		
		                  FROM '.$wpdb->prefix.'masvalor_bitacoras bi,'.$wpdb->prefix.'masvalor_publications p'.','.'wp_posts pos
		                    WHERE p.id_post = pos.ID AND 
						       name_publications like "Bitacora" AND
							   bi.post_id = pos.ID  ORDER BY p.priority';
						 
		$data = $wpdb->get_results($sql);
		
		return $data;	
				
   }
   
   function delete($cid){
     global $wpdb;
     wp_delete_post( $cid);
	 
	 $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_publications WHERE id_post='.$cid;
	 $data = $wpdb->query($sql,OBJECT_K);
   
   }
   

}
?>