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
class companiesModel {
    
   public function getData($filter_sel,$search,$limitStart,$limitEnd){
		global $wpdb;
		
		$sql = 'SELECT 	id,name,business_name,cuit_number,city,state,country,main_contact_mail,userid,type_industry,type_services,type_education,type_go,type_ngo,type_selfemployment,
						
						CASE actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Aceptado"
							WHEN 2 THEN "Desactivada" 
							WHEN 3 THEN "Rechazada" 
						END as actived
						FROM '.$wpdb->prefix.'masvalor_companies';
		
		if($search)
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		if($_POST["order"] != '' && $_POST["order"] != null)
			$sql .= ' order by '.$_POST["order"].' '.$_POST["order_dir"];
		
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";	
			
		$data = $wpdb->get_results($sql);

		return $data;	
   }
   
   public function getTotal($filter_sel,$search){
		global $wpdb;
		
		$sql = 'SELECT COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_companies';
		
		if($search)
			$sql .= " WHERE LOWER( {$filter_sel} ) LIKE '%".$search."%'";
			
		$data = $wpdb->get_results($sql);
		
		foreach ($data as $aData):
			return $aData->count;
		endforeach;
		return 0;	
			
}
   function delete($cid){
      global $wpdb;
      	  	   
	  $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_companies WHERE id ='.$cid;
					 
      $data = $wpdb->get_results($sql);
   }
   

}
?>