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
class report_searches_pendingModel {
    
   public function getData(){
		global $wpdb;
		$data = "";
		
		$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city,actived
					     FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE status LIKE "Pendiente"';
		
		 $data = $wpdb->get_results($sql);	

		  
		return $data;	

    }
    
	public function getDataCount(){
		global $wpdb;
						
		
		$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE status LIKE "Pendiente"';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
		
		return $count;	
			
		
    }
   

}
?>