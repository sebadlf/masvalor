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
class activities_publicModel {
    
    public function getData(){
		global $wpdb;
		global $current_user;
		get_currentuserinfo();
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$date=date("Y-m-d");
				
		$sql = 'SELECT pos.id,pos.post_title,pos.post_content,act.start_date,act.end_date FROM '.$wpdb->prefix.'masvalor_activities act'.','.'wp_posts pos
		                 WHERE act.post_id = pos.ID AND act.end_date >= "'.$date.'" ';
				
		$data = $wpdb->get_results($sql);
		
		$cant=0;
		foreach ($data as $idu):
			   $result[$cant]->id = $idu->id;
			   $result[$cant]->post_title = $idu->post_title;
			   $result[$cant]->post_content = $idu->post_content;
			   $result[$cant]->start_date = $idu->start_date;
			   $result[$cant]->end_date = $idu->end_date;
			   $result[$cant]->annotated = $this->isApplicat($idu->id);
			   $cant++;
		endforeach;  
				
		return $result;	

    }
		
   
   function saveApplicat($cid){
      global $current_user;
	  get_currentuserinfo();
	  	  
	  global $wpdb;
	
	
	  $wpdb->insert( 
			$wpdb->prefix.'masvalor_activities_registered', 
			array(
			 'id_activity' => $cid,
			 'userid' => $current_user->ID			 	 
			), 
			array( 
				 '%d',
				 '%d'				 			 
			) 
		   );
    	 
   	
   }
   
   function isApplicat($cid){
		global $wpdb;
		global $current_user;
		get_currentuserinfo();	
		
		$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_activities_registered
		                 WHERE  id_activity = "'.$cid.'" AND userid = "'.$current_user->ID.'"';
		
		$data = $wpdb->get_results($sql);
		$count = 0;
		foreach ($data as $aData):
			$count = $aData->count;
		endforeach;
		if ($count > 0)
			return true;	
		else
			return false;	

    }
   

}
?>