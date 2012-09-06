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
class citiesModel {
    
   public function getData(){
		
		global $wpdb;
		
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_cities';  
		
		$data = $wpdb->get_results($sql);
		
		return $data;	

   }
   
    public function delete($cid){
	  global $wpdb;
	  $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_cities WHERE id='.$cid.'';
	  $data = $wpdb->get_results($sql);
	
	}
	

}
?>