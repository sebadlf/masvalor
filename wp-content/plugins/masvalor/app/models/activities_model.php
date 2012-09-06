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
class activitiesModel {
    
   public function getData($filter_sel,$search){
		global $wpdb;
		
		
		$sql = 'SELECT pos.*,act.start_date,act.end_date,act.priority,act.post_date_espirate FROM '.$wpdb->prefix.'masvalor_activities act'.','.'wp_posts pos
		                 WHERE act.post_id = pos.ID ORDER BY act.priority';
		
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		$data = $wpdb->get_results($sql);
		
		return $data;	

    }
   
   function delete($cid){
   
       global $wpdb;
	 $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_activities WHERE post_id='.$cid.';';
	 $data = $wpdb->query($sql,OBJECT_K);
		 		 
   
   }
   

}
?>