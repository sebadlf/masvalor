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
class searchesModel {
    
   public function getData($filter_sel,$search,$date_from,$date_to,$limitStart,$limitEnd){
		global $wpdb;
		
			
		$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city,
				CASE actived
					WHEN 0 THEN "Pendiente de aceptaci&oacute;n" 
					WHEN 1 THEN "Aceptada" 
					ELSE "Cerrada"
				END as actived FROM '.$wpdb->prefix.'masvalor_companysearchs';
		
		if($search) 
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		else if($date_from || $date_to)
			$sql .= " WHERE start_date >= '".$date_from."' AND start_date <= '".$date_to."' ";
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";
			
		/*var_dump($sql);*/
		
		$data = $wpdb->get_results($sql);
		return $data;	

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
   
  

}
?>