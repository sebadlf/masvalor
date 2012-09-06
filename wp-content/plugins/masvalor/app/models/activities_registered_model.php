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
class activities_registeredModel {
    
   public function getDataDoctor($cid){
		global $wpdb;
								
		$sql = 'SELECT act.id,pre.name,pre.lastname,pre.main_contact_mail  FROM '.$wpdb->prefix.'masvalor_activities_registered act'.','.$wpdb->prefix.'masvalor_profiles pre
		                 WHERE act.userid = pre.userid AND act.id_activity = '.$cid;
		
		$data = $wpdb->get_results($sql);
		
		return $data;	

    }
	
	public function getDataCompany($cid){
		global $wpdb;
		
			
		$sql = 'SELECT act.id,pre.name,pre.business_name,pre.main_contact_mail FROM '.$wpdb->prefix.'masvalor_activities_registered act'.','.$wpdb->prefix.'masvalor_companies pre
		                 WHERE act.userid = pre.userid AND act.id_activity = '.$cid;
		
		$data = $wpdb->get_results($sql);
		
		return $data;	

    }
   
   
   function delete($cid){
   	 
     global $wpdb;
	 $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_activities_registered WHERE id='.$cid.';';
	 $data = $wpdb->query($sql,OBJECT_K);
		 		 
   
   }
   

}
?>