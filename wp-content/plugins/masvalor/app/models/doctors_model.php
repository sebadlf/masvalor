<?php
/**
 * The users dashboard
 *
 * @package    Tina-MVC 30-71111969-4
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
    
   public function getData($filter_sel,$search,$limitStart,$itemsPerPage){
		global $wpdb;
		
		
		$sql = 'SELECT  u.user_login as username,mu.*,
		                (SELECT dis.name
						        FROM '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rld,'.$wpdb->prefix.'masvalor_subdisciplines subs
								WHERE  rld.subdisciplineid = subs.id AND subs.id_discipline=dis.id AND 
								       rld.userid = mu.userid       AND 
									   rld.ppal = 1
								LIMIT 0,1
     					)as name_dis ,
						(SELECT sub.name  
						        FROM '.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis
						        WHERE rdis.subdisciplineid = sub.id AND 
								      rdis.userid  = mu.userid      AND 
									  rdis.ppal =1
								LIMIT 0,1
						)as name_subdis,
						(SELECT prt.title FROM '.$wpdb->prefix.'masvalor_profiletitles prt 
						        WHERE prt.userid = mu.userid AND prt.type = 1 AND prt.ppal = 1
								LIMIT 0,1
						) as title,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
							WHEN 2 THEN "Desactivado"
							WHEN 3 THEN "En carencia"
							WHEN 4 THEN "Rechazado"
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u
						        WHERE u.ID = mu.userid'; 
		
		
		/*
		$sql = 'SELECT  u.user_login as username, mu.*,prt.title,sub.name AS name_subdis,dis.name AS name_dis,
					 CASE  mu.actived
						   WHEN 0 THEN "Pendiente" 
						   WHEN 1 THEN "Activado" 
						   WHEN 2 THEN "Desactivado"
						   WHEN 3 THEN "En carencia"
						   WHEN 4 THEN "Rechazado"
						END as actived
					FROM '.$wpdb->prefix.'masvalor_profiles mu
					LEFT JOIN '.$wpdb->prefix.'users u ON u.ID = mu.userid
					LEFT JOIN '.$wpdb->prefix.'masvalor_profiletitles prt ON prt.userid = mu.userid
					LEFT JOIN '.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis ON rdis.userid  = mu.userid
					LEFT JOIN '.$wpdb->prefix.'masvalor_subdisciplines sub ON rdis.subdisciplineid = sub.id
					LEFT JOIN '.$wpdb->prefix.'masvalor_rel_user_subdisciplines rld ON rld.userid = mu.userid
					LEFT JOIN '.$wpdb->prefix.'masvalor_subdisciplines subs ON rld.subdisciplineid = subs.id
					LEFT JOIN '.$wpdb->prefix.'masvalor_disciplines dis ON subs.id_discipline=dis.id
					WHERE prt.type = 1 AND 
						  prt.ppal = 1 AND 
						  rdis.ppal =1 AND
						  rld.ppal = 1';
						  
        */		
		
		//Filtramos, en caso de ser necesario
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
		if($_POST["order"] != '' && $_POST["order"] != null)
			$sql .= ' order by '.$_POST["order"].' '.$_POST["order_dir"];
		
		if ($limitStart !== null && $limitStart !== '' && $itemsPerPage !== null && $itemsPerPage !== '' )
			$sql .=" LIMIT {$limitStart},{$itemsPerPage}";	

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

	public function getUnactived($filter_sel,$search,$limitStart,$itemsPerPage){
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
		
		if ($limitStart !== null && $limitStart !== '' && $itemsPerPage !== null && $itemsPerPage !== '' )
			$sql .=" LIMIT {$limitStart},{$itemsPerPage}";	
		
		$unactived = $wpdb->get_results($sql);
		
		return $unactived;	
}
   public function getDataExportar() {
		global $wpdb;
			
		    
		$sql = 'SELECT  u.user_login as username,mu.*,
		                (SELECT dis.name
						        FROM '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rld,'.$wpdb->prefix.'masvalor_subdisciplines subs
								WHERE  rld.subdisciplineid = subs.id AND subs.id_discipline=dis.id AND 
								       rld.userid = mu.userid       AND 
									   rld.ppal = 1
								LIMIT 0,1
     					)as name_dis ,
						(SELECT sub.name  
						        FROM '.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis
						        WHERE rdis.subdisciplineid = sub.id AND 
								      rdis.userid  = mu.userid      AND 
									  rdis.ppal =1
								LIMIT 0,1
						)as name_subdis,
						(SELECT prt.title FROM '.$wpdb->prefix.'masvalor_profiletitles prt 
						                  WHERE prt.userid = mu.userid AND type = 1 AND prt.ppal = 1
										  LIMIT 0,1
						) as title,
						(SELECT ptes.title FROM '.$wpdb->prefix.'masvalor_profiletesis ptes 
						                  WHERE ptes.userid = mu.userid AND type = 1 
								LIMIT 0,1) as title_tesis,
						(SELECT ptes.topic FROM '.$wpdb->prefix.'masvalor_profiletesis ptes 
						                  WHERE ptes.userid = mu.userid AND ptes.type = 1 
								LIMIT 0,1) as topic_tesis,
						(select subs.name from '.$wpdb->prefix.'masvalor_subdisciplines subs,'.$wpdb->prefix.'masvalor_profiletesis rld 
										  where rld.id_subdiscipline=subs.id and rld.userid=mu.userid 
								LIMIT 0,1) as tesis_sub,
						(SELECT adc.name FROM '.$wpdb->prefix.'masvalor_profile_ca_zc ca,'.$wpdb->prefix.'masvalor_advisory_committees adc
						                  WHERE ca.id_doctor = mu.userid AND ca.id_ca = adc.id  
								LIMIT 0,1) as com_aser,
						(SELECT adc.name FROM '.$wpdb->prefix.'masvalor_profile_ca_zc ca,'.$wpdb->prefix.'masvalor_zones adc
						                  WHERE ca.id_doctor = mu.userid AND ca.id_zc = adc.id  
								LIMIT 0,1) as zona_conic,										  
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
							WHEN 2 THEN "Desactivado"
							WHEN 3 THEN "En carencia"
							WHEN 4 THEN "Rechazado"
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u
						        WHERE u.ID = mu.userid'; 

		
       /*  
		$sql= 'SELECT  u.user_login as username, mu.*,prt.title,sub.name AS name_subdis,
						dis.name AS name_dis,ptes.title AS title_tesis,
						ptes.topic AS topic_tesis,subs.name AS tesis_sub,adc.name AS com_aser,adc.name AS zona_conic,
						CASE  mu.actived
							   WHEN 0 THEN "Pendiente" 
							   WHEN 1 THEN "Activado" 
							   WHEN 2 THEN "Desactivado"
							   WHEN 3 THEN "En carencia"
							   WHEN 4 THEN "Rechazado"
						END as actived
				FROM ((wp_masvalor_profiles mu LEFT JOIN wp_users u ON u.ID = mu.userid)
				LEFT JOIN '.$wpdb->prefix.'masvalor_profiletitles prt ON prt.userid = mu.userid)
				LEFT JOIN '.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis ON rdis.userid  = mu.userid
				LEFT JOIN '.$wpdb->prefix.'masvalor_subdisciplines sub ON rdis.subdisciplineid = sub.id
				LEFT JOIN '.$wpdb->prefix.'masvalor_rel_user_subdisciplines rld ON rld.userid = mu.userid
				LEFT JOIN '.$wpdb->prefix.'masvalor_subdisciplines subs ON rld.subdisciplineid = subs.id
				LEFT JOIN '.$wpdb->prefix.'masvalor_disciplines dis ON subs.id_discipline=dis.id
				LEFT JOIN '.$wpdb->prefix.'masvalor_profiletesis ptes ON ptes.userid = mu.userid
				LEFT JOIN '.$wpdb->prefix.'masvalor_profile_ca_zc ca  ON ca.id_doctor = mu.userid
				LEFT JOIN '.$wpdb->prefix.'masvalor_advisory_committees adc ON ca.id_ca = adc.id  
				LEFT JOIN '.$wpdb->prefix.'masvalor_profile_ca_zc caa ON caa.id_doctor = mu.userid
				LEFT JOIN '.$wpdb->prefix.'masvalor_zones adcc ON caa.id_zc = adcc.id
				WHERE prt.type = 1 AND 
					  prt.ppal = 1 AND 
					  rdis.ppal =1 AND
					  rld.ppal = 1'; 
 
		*/
			  
		$data = $wpdb->get_results($sql);
		
		return $data;	

   }
   
    function delete($cid){
      global $wpdb;
      	  	   
	  $sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_profiles WHERE userid ='.$cid;
					 
      $data = $wpdb->get_results($sql);
   }
   
   
   
   
}
?>



