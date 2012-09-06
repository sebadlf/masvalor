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
class searches_activatedModel {
    
   public function getData($filter_sel,$search,$date_from,$date_to,$limitStart,$limitEnd){
		global $wpdb;
		
			
		$sql = 'SELECT id,start_date,end_date,job_title,company,state,country,city
				      FROM '.$wpdb->prefix.'masvalor_companysearchs WHERE actived = 0';
		
		if($search) 
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
			
		else if($date_from || $date_to)
			$sql .= " WHERE start_date >= '".$date_from."' AND start_date <= '".$date_to."' ";
		if ($limitStart !== null && $limitStart !== '' && $limitEnd !== null && $limitEnd !== '' )
			$sql .=" LIMIT {$limitStart},{$limitEnd}";
			
			
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
   
   
   public function activadSearches(){
        global $wpdb;
		$userid = $_POST['userid'];
	    $divide = explode(",",$userid);
      		
		foreach($divide as $idu):
           	$wpdb->query('UPDATE '.$wpdb->prefix.'masvalor_companysearchs SET actived = 1 WHERE id ='.$idu);
	    endforeach; 
				
		$sql = 'SELECT  userid FROM '.$wpdb->prefix.'masvalor_companysearchs WHERE id ='.$idu;
		$data = $wpdb->get_results($sql);
		foreach ($data as $aData):
	       $user_comp = $aData->userid;
	    endforeach; 
		
		$this->notificationCompany($userid);
		$this->notificationDoctors($cid);
		
   }
   
   
   function notificationDoctors($cid){
	 
	 global $wpdb;
	
	   $sql = 'SELECT  name,lastname,main_contact_mail FROM '.$wpdb->prefix.'masvalor_profiles,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND (actived=1 OR actived=3)';  
	   $data = $wpdb->get_results($sql);
		
	   foreach ($data as $aData):
	        $name = $aData->name;
			$lastname = $aData->lastname;			
	    	$email = $aData->main_contact_mail;
			$this->sendNotification($name,$lastname,$email);
	   endforeach; 	
	  
		
      return $cid;	
	
	}
	
	
	function notificationCompany($userid){
	 
	 global $wpdb;
	
	   $sql = 'SELECT  main_contact_mail FROM '.$wpdb->prefix.'masvalor_companies,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND userid ='.$userid;  
	   $data = $wpdb->get_results($sql);
		
	   foreach ($data as $aData):
	       	$email = $aData->main_contact_mail;
			$this->sendNotification($name,$lastname,$email);
	   endforeach; 	
	
	
	}
	
   
    function sendNotification($name,$lastname,$email){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/doctor.php?date='.date("d-m-Y").'&email='.$email);
		
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= "From:".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Nueva Busqueda Masvalor";
		mail($email,$asunto,$texto,$headers);
		
	}
   
   

}
?>