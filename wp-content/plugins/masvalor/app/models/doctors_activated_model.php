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
class doctors_activatedModel {    //$date_from,$date_to
    
   public function getData($filter_sel,$search,$limitStart,$limitEnd){
		global $wpdb;
	
		
/* 		$sql = 'SELECT  pr.*,
		        (SELECT prt.title FROM '.$wpdb->prefix.'masvalor_profiletitles prt 
						                  WHERE prt.userid = pr.userid AND type = 0 AND prt.ppal = 1 ) as title,
				(SELECT sub.name FROM '.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis
						         WHERE rdis.userid = pr.userid        AND
								       rdis.subdisciplineid = sub.id AND 
									   rdis.ppal =1
						)as name_subdis						  
        		FROM '.$wpdb->prefix.'masvalor_profiles pr WHERE  pr.actived = 0';  */
							  
 		$sql = 'SELECT  u.user_login as username,mu.*,
		                (SELECT dis.name
						        FROM '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rld,'.$wpdb->prefix.'masvalor_subdisciplines subs
								WHERE  rld.subdisciplineid = subs.id AND 
								       subs.id_discipline=dis.id     AND 
								       rld.userid = mu.userid        AND 
									   rld.ppal = 1
     					LIMIT 0,1 )as name_dis ,
						(SELECT sub.name  
						        FROM '.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rdis
						        WHERE rdis.subdisciplineid = sub.id AND 
								      rdis.userid  = mu.userid      AND 
									  rdis.ppal =1
						LIMIT 0,1)as name_subdis,
						(SELECT prt.title FROM '.$wpdb->prefix.'masvalor_profiletitles prt 
						                  WHERE prt.userid = mu.userid AND 
										        type = 1 AND 
										        prt.ppal = 1
						LIMIT 0,1
						) as title,
						(SELECT prt.title FROM '.$wpdb->prefix.'masvalor_profiletitles prt 
						                  WHERE prt.userid = mu.userid AND 
										        type = 0 AND 
										        prt.ppal = 0
						LIMIT 0,1
						) as title_grad,
						(SELECT ptes.title FROM '.$wpdb->prefix.'masvalor_profiletesis ptes 
						                  WHERE ptes.userid = mu.userid AND type = 1 
								LIMIT 0,1) as title_tesis,
		                CASE  mu.actived
							WHEN 0 THEN "Pendiente" 
							WHEN 1 THEN "Activado" 
							WHEN 2 THEN "Desactivado"
							WHEN 3 THEN "En carencia"
							WHEN 4 THEN "Rechazado"
						END as actived
						FROM '.$wpdb->prefix.'masvalor_profiles mu,'.$wpdb->prefix.'users u
						        WHERE u.id = mu.userid AND
									  mu.actived = 0'; 	 
		
		//Filtramos, en caso de ser necesario
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
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
		
		$data = $wpdb->get_results($sql);
		
		foreach ($data as $aData):
			return $aData->count;
		endforeach;
		return 0;	
		

   }
   
   	function sendNotificationActived($email){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/company.php?date='.date("d-m-Y").'&email='.$email);
		
		//$texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/company.html');
				
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-type: text/html\r\n";
		//$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: ".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Notificacion Masvalor";
		mail($email,$asunto,$texto,$headers);
	}
   
   public function activadDoctors(){
        global $wpdb;
		$userid = $_POST['userid'];
	    $divide = explode(",",$userid);
      		
		foreach($divide as $idu):
           	$wpdb->query('UPDATE '.$wpdb->prefix.'masvalor_profiles SET actived = 1 WHERE userid ='.$idu);
			$sql_query = 'select main_contact_mail from '.$wpdb->prefix.'masvalor_profiles where userid='.$idu;
			$user_mail = $wpdb->get_var($sql_query);
			$this->sendNotificationActived($user_mail);
	    endforeach; 
   }
   

}
?>