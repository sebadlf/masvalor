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
class form_consultationsModel {
    
   public function getData($filter_sel,$search,$filter_date_from,$filter_date_to){
		global $wpdb;
		
		
		
		$sql = 'SELECT con.*,user.user_login FROM '.$wpdb->prefix.'masvalor_consultations con'.','.'wp_users user
		                 WHERE con.userid = user.ID';
		
				
		if($search && ($filter_date_from == null || $filter_date_from == ''))
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		if($filter_date_from && ($search == null || $search == ''))
			$sql .= ' AND con.creation_date >="'.$filter_date_from.'" AND con.creation_date <= "'.$filter_date_to.'"';
			
		if($_POST["order"] != '' && $_POST["order"] != null)
			$sql .= ' order by '.$_POST["order"].' '.$_POST["order_dir"];
		
		$data = $wpdb->get_results($sql);
		
		return $data;	

   }
   
   function delete($cid){
      global $wpdb;
    
	  $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_consultations WHERE id ='.$cid;
						 
      $data = $wpdb->get_results($sql);
	  
   }
   

}
?>