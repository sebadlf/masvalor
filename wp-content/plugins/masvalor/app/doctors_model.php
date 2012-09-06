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
class doctorsModel {    //$date_from,$date_to
    
   public function getData($filter_sel,$search,$limitStart,$limitEnd){
		global $wpdb;
		
		$sql = 'SELECT  u.user_login as username,mu.*,dis.name as name_dis,sub.name as name_subdis,prt.title,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
							WHEN 2 THEN "Desactivado"
							WHEN 3 THEN "En carencia"
							WHEN 4 THEN "Rechazado"
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis,
						       '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_subdisciplines sub,
							    '.$wpdb->prefix.'masvalor_profiletitles prt
						        WHERE u.ID = mu.userid AND 
								      rdis.userid = mu.userid AND 
									  rdis.subdisciplineid = sub.id AND 
									  rdis.ppal =1  AND
									  sub.id_discipline = dis.id AND
									  mu.userid = prt.userid AND 
									  prt.ppal = 1';  
									  
		//Filtramos, en caso de ser necesario
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		if($_POST["order"] != '' && $_POST["order"] != null)
			$sql .= ' order by '.$_POST["order"].' '.$_POST["order_dir"];
		
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";	

		$data = $wpdb->get_results($sql);
		
		return $data;	

   }
   
    public function getTotal($filter_sel,$search){
		global $wpdb;
		$sql = 'SELECT  COUNT(*) as count FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u WHERE u.ID = userid';  

		//Filtramos, en caso de ser necesario
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		$data = $wpdb->get_var($sql);
		
		return $data;
   }

	public function getUnactived($filter_sel,$search,$limitStart,$limitEnd){
		global $wpdb;
	
		
		$sql = 'SELECT  u.user_login as username,mu.*,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u
						        WHERE u.ID = mu.userid AND actived = 0';  
									  
		//Filtramos, en caso de ser necesario
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";	
		
		$unactived = $wpdb->get_results($sql);
		
		return $unactived;	
}
   public function getDataExportar(){
		global $wpdb;
	
		
		/*$sql = 'SELECT  u.user_login as username,mu.*,dis.name as name_dis,sub.name as name_subdis,prt.title,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis,
						       '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_subdisciplines sub,
							    '.$wpdb->prefix.'masvalor_profiletitles prt
						        WHERE u.ID = mu.userid AND 
								      rdis.userid = mu.userid AND 
									  rdis.subdisciplineid = sub.id AND 
									  rdis.ppal =1  AND
									  sub.id_discipline = dis.id AND
									  mu.userid = prt.userid AND 
									  prt.ppal = 1';  */
									  
		$sql = 'SELECT  u.user_login as username,mu.*,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u
						        WHERE u.ID = mu.userid';  
									  
		$data = $wpdb->get_results($sql);
		
		return $data;	

   }
}
?>