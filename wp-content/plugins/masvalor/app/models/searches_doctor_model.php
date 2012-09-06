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
class searches_doctorModel {
    
   public function getData($filter_sel,$search,$date_from,$date_to,$limitStart,$limitEnd){
		global $wpdb;
		$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city	FROM '.$wpdb->prefix.'masvalor_companysearchs
		                   WHERE actived = 1';
		
		if($search) 
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		else if($date_from || $date_to)
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$date_from."%' AND ( {$filter_sel} ) LIKE '%".$date_to."%' ";
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";
		
		$data = $wpdb->get_results($sql);
		
		
		$cant=0;
		foreach ($data as $idu):
			if($this->getDate($idu->id) !=null){   
				   $result[$cant]->id = $idu->id;
				   $result[$cant]->start_date = $idu->start_date;
				   $result[$cant]->end_date = $idu->end_date;
				   $result[$cant]->job_title = $idu->job_title;
				   $result[$cant]->company = $idu->company;
				   $result[$cant]->state = $idu->state;
				   $result[$cant]->country = $idu->country;
				   $result[$cant]->city = $idu->city;
				   $result[$cant]->annotated = $this->isApplicat($idu->id);
				   $result[$cant]->date = $this->getDate($idu->id);
				   $cant++;
			 }  
		endforeach;  
			
		return $result;	
		
	
   }
   
   
   public function getDate($id_search){
        global $wpdb;
		global $current_user;
	    get_currentuserinfo();
		$date = null;
		$sql = 'SELECT date FROM '.$wpdb->prefix.'masvalor_searchresults
		                   WHERE searchid = '.$id_search.' AND 	userid = '.$current_user->ID.' AND whoadd = '.$current_user->ID.'';
        
       	
		$data = $wpdb->get_results($sql);
		foreach ($data as $aData):
			return $aData->date;
		endforeach;
		return $date;	
   }
     
   
   public function getTotal($filter_sel,$search,$date_from,$date_to){
		global $wpdb;
		
		$sql = 'SELECT COUNT(id) count FROM '.$wpdb->prefix.'masvalor_companysearchs';
		if($search) 
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		else if($date_from || $date_to)
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$date_from."%' AND ( {$filter_sel} ) LIKE '%".$date_to."%' ";
		$data = $wpdb->get_results($sql);
		foreach ($data as $aData):
			return $aData->count;
		endforeach;
		return 0;	

   }
   
   function saveApplicat($cid){
      global $wpdb;
	  global $current_user;
	  get_currentuserinfo();
	  date_default_timezone_set('America/Argentina/Buenos_Aires');
	  $date=date("Y-m-d");
	    
	  
	  $wpdb->insert( 
			$wpdb->prefix.'masvalor_searchresults', 
			array(
			 'searchid' => $cid,
			 'userid' => $current_user->ID,
			 'type' => 2, 
			 'date' => $date,
			 'whoadd' => $current_user->ID			 
			), 
			array( 
				 '%d',
				 '%d', 
				 '%d',
				 '%s',
				 '%d'			 
			) 
		   );
   
   }
   
   function isApplicat($cid){
		global $wpdb;
		global $current_user;
		get_currentuserinfo();	
		
		$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_searchresults
		                 WHERE  type = 2 AND searchid = "'.$cid.'" AND userid = "'.$current_user->ID.'"';
		
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