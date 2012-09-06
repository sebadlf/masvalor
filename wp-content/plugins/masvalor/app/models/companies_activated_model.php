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
class companies_activatedModel {
    
   public function getData($filter_sel,$search,$limitStart,$limitEnd){
		global $wpdb;
		
		$sql = 'SELECT 	id,name,business_name,cuit_number,city,state,country,main_contact_mail,userid,type_industry,type_services,type_education,type_go,type_ngo,type_selfemployment
									FROM '.$wpdb->prefix.'masvalor_companies WHERE actived = 0';
		
		if($search)
			$sql .= " AND LOWER( {$filter_sel} ) LIKE '%".$search."%'";
		
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
		$asunto ="Notificación +VALOR.Doc";
		mail($email,$asunto,$texto,$headers);
	}
   
   public function activadCompanies(){
        global $wpdb;
		$userid = $_POST['userid'];
	    $divide = explode(",",$userid);
      		
		foreach($divide as $idu):
           	$wpdb->query('UPDATE '.$wpdb->prefix.'masvalor_companies SET actived = 1 WHERE userid ='.$idu);
			$sql_query = 'select main_contact_mail from '.$wpdb->prefix.'masvalor_companies where userid='.$idu;
			$user_mail = $wpdb->get_var($sql_query);
			$this->sendNotificationActived($user_mail);
	    endforeach; 
   }
   
   
   

}
?>