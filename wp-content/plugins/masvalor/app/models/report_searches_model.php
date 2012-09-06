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
class report_searchesModel {
    
   public function getData($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
		$data = "";
		
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city,actived,status
					     FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.'';
		
		 $data = $wpdb->get_results($sql);	
		}		
				  
		return $data;	

    }
    
	
	
	
	public function getDataCount($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
						
			
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.'';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
		
		}
		
		return $count;	
		
    }
	
	public function getCountUnmet($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
						
			
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.' AND status LIKE "Insatisfecha" ';
			
			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
		
		}
		
		return $count;	
		
    }   

	public function getCountSatisfied($filter_date_from,$filter_date_to,$filter_sel){
		global $wpdb;
						
			
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companysearchs 
				          WHERE start_date >= '.$filter_date_from.' AND end_date >= '.$filter_date_to.' AND status LIKE "Satisfecha"';
				    			
			$data = $wpdb->get_results($sql);	
			
			$count = 0;			
			
			foreach ($data as $aData):
				$count = $aData->count;
		   endforeach;
		
		}
		
		return $count;	
		
    }
	
}
?>