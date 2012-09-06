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
class form_consultationModel {
    
   public function getData($cid){	
		
		global $wpdb;
		if ($cid == null or $cid == "" )
		   $row = null;
		else{
			
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_consultations WHERE id='.$cid.';';
			$data = $wpdb->get_results($sql,OBJECT_K);
			foreach ($data as $aData):
				return $aData;
			endforeach;
			return null;	
		}
		return	$row;

   }
   
   public function getDisciplines($stringids){	
   
		$disciplines = explode(",",$stringids);
		global $wpdb;
		if ( $disciplines[0] != '') {
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_disciplines';
			$i = 0;
			foreach ($disciplines as $discipline):
				if ($i == 0)
					$sql.= " WHERE id =".$discipline;
				else
					$sql.= " OR id=".$discipline;
				$i++;
			endforeach;
			$datas = $wpdb->get_results($sql,OBJECT_K);
		}
		else 
			return null;
		return $datas;


   }
   
   public function getSearchData($id){	

		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs WHERE id='.$id.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		foreach ($data as $aData):
			return $aData;
		endforeach;
		
	return	$row;

   }
   
   function notificationCompany($cid,$userid){
	   global $wpdb;
	  $sql = 'SELECT  name,main_contact_mail FROM '.$wpdb->prefix.'masvalor_companies,'.$wpdb->prefix.'users u
							WHERE u.ID = userid AND userid = '.$cid;  
							
	  $data = $wpdb->get_results($sql);
	  
	  foreach ($data as $aData):
	        $name = $aData->name;
			$email = $aData->main_contact_mail;
	  endforeach; 	
	  
	  $texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/company.html');
	 //var_dump($texto);
	  
	  $headers = "MIME-Version: 1.1\r\n";
	  $headers = "Content-type: text/html\r\n";
	  $headers .= "From: fdinelli@tsavo.com.ar\r\n"; // remetente
	  $headers .= "Return-Path: fdinelli@tsavo.com.ar\r\n"; // return-path*/
	  $asunto ="Nuevos postulante para tu busqueda";
	  //$texto = "Se has agregado nuevos postulantes a tu busqueda N°:".$cid;
	  mail($email,$asunto,$texto,$headers);
		
		
	}
	
	function funcionHtmlDevuelto($html){
		$file = fopen ("$html", "r");
		if (!$file) { echo "<p>No se puede abrir el archivo.\n"; exit;}
		$bufer = '';
		while (!feof($file)) { $bufer .= fgets($file, 4096);}
		fclose($file);
		return $bufer;
	} 
	
   
   public function save($cid){
		
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$age_to = $_POST['age_to'];
		$age_from = $_POST['age_from'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		$userid = $_POST['userid'];
		
		$availability_move_country = 0;
		if (isset($_POST['availability_move_country']))
			$availability_move_country = 1;
			
		$availability_move_state = 0;
		if (isset($_POST['availability_move_state']))
			$availability_move_state = 1;
			
		$degree_title = $_POST['degree_title'];
		$graduate_degree = $_POST['graduate_degree'];
		
		//manage disciplines
		$disciplines = $_POST['disciplines'];
		if ($disciplines == null || $disciplines == '')
			$disciplines = array();
		$diciplines_and_skills = '';
		$i=0;
		foreach ($disciplines as $discipline):
			if ($i == 0)
				$diciplines_and_skills.= $discipline;
			else
				$diciplines_and_skills.= ','.$discipline;
			$i++;
		endforeach;
				
		$match_all_diciplines_and_skills = 0;
		if (isset($_POST['match_all_diciplines_and_skills']))
			$match_all_diciplines_and_skills = 1;
		
		//Manage compentencies
		$competencies = $_POST['competencies'];
		if ($competencies == null || $competencies == '')
			$competencies = array();
		$competenciesString = '';
		$i=0;
		foreach ($competencies as $competence):
			if ($i == 0)
				$competenciesString.= $competence;
			else
				$competenciesString.= ','.$competence;
			$i++;
		endforeach;
		
		
		$gross_mensual_remuneration_min = $_POST['gross_mensual_remuneration_min'];
		$gross_mensual_remuneration_max = $_POST['gross_mensual_remuneration_max'];
		$availability_for_travel = 0;
		if (isset($_POST['availability_for_travel']))
			$availability_for_travel = 1;
		//Manage labor sector	
		$auxLaborSectors = $_POST['laborsectors'];
		if ($auxLaborSectors == null || $auxLaborSectors=='')
			$auxLaborSectors= array();
		$laborSectors = new stdClass;
		$laborSectors->type_industry = 0;
		$laborSectors->type_services = 0;
		$laborSectors->type_education = 0;
		$laborSectors->type_go = 0;
		$laborSectors->type_ngo = 0;
		$laborSectors->type_selfemployment = 0;
		foreach ($auxLaborSectors as $auxLaborSector):
			$laborSectors->$auxLaborSector = 1;			
		endforeach;
		
		//Manage Labor relationships
		$auxLaborRelationships = $_POST['laborrelationships'];
		if ($auxLaborRelationships == null || $auxLaborRelationships=='')
			$auxLaborRelationships= array();
		$laborRelationships = new stdClass;
		$laborRelationships->type_dependencyrelationship = 0;
		$laborRelationships->type_contractlabor = 0;
		$laborRelationships->type_contractproject = 0;
		$laborRelationships->type_contractconsulting = 0;
		$laborRelationships->type_other = 0;
		foreach ($auxLaborRelationships as $auxLaborRelationship):
			$laborRelationships->$auxLaborRelationship = 1;			
		endforeach;
		
		 //Manage Availability Times
		$auxAvailabilityTimes = $_POST['availabilitytimes'];
		
		if ($auxAvailabilityTimes == null || $auxAvailabilityTimes=='')
			$auxAvailabilityTimes= array();
		$availabilityTimes = new stdClass;
		$availabilityTimes->required_fulltime = 0;
		$availabilityTimes->required_parttime = 0;
		$availabilityTimes->required_ondemand = 0;
		foreach ($auxAvailabilityTimes as $availabilityTime):
			$availabilityTimes->$availabilityTime = 1;			
		endforeach;
		$maxid = null;		
	    global $wpdb;
	    $wpdb->show_errors();
		
		if ($cid == null or $cid == "" ){
				 $creation_date = date('d-m-Y');
				 $wpdb->insert( 
								$wpdb->prefix.'masvalor_consultations', 
								array(
									'name' => $name,
									'gender' => $gender,
									'age_to' => $age_to,
									'age_from' => $age_from,
									'country' => $country,
									'state' => $state,
									'city' => $city,
									'availability_move_country' => $availability_move_country,
									'availability_move_state' => $availability_move_state,
									'degree_title' => $degree_title,
									'graduate_degree' => $graduate_degree,
									'diciplines_and_skills' => $diciplines_and_skills,
									'match_all_diciplines_and_skills' => $match_all_diciplines_and_skills,
									'gross_mensual_remuneration_max' => $gross_mensual_remuneration_max,
									'gross_mensual_remuneration_min' => $gross_mensual_remuneration_min,
									'availability_for_travel' => $availability_for_travel,
									'type_industry' => $laborSectors->type_industry, 
									'type_services' => $laborSectors->type_services, 
									'type_education' => $laborSectors->type_education, 
									'type_go' => $laborSectors->type_go, 
									'type_ngo' => $laborSectors->type_ngo, 
									'type_selfemployment' =>$laborSectors->type_selfemployment,  
									'type_dependencyrelationship' => $laborRelationships->type_dependencyrelationship,
									'type_contractlabor' => $laborRelationships->type_contractlabor,
									'type_contractproject' => $laborRelationships->type_contractproject,
									'type_contractconsulting' => $laborRelationships->type_contractconsultations,
									'type_other' => $laborRelationships->type_other,
									'required_fulltime' => $availabilityTimes->required_fulltime,						
									'required_parttime' => $availabilityTimes->required_parttime,
									'required_ondemand' => $availabilityTimes->required_ondemand,
									'userid' => (int)$userid,
									'creation_date' => $creation_date,
									'competencies' => $competenciesString
								), 
								array( 
									'%s',
									'%s', 
									'%d',
									'%d',
									'%s', 
									'%s',
									'%s',
									'%d',
									'%d',
									'%s',
									'%s',
									'%s',
									'%d',
									'%d', 
									'%d', 
									'%d',
									'%d',
									'%d',
									'%d',									
									'%d', 
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d',
									'%s'
								) 
							);
				$maxid = $wpdb->insert_id;
				
		        } 
			else{
		        
				$wpdb->update( 
								$wpdb->prefix.'masvalor_consultations', 
								array(
									'gender' => $gender,
									'age_to' => $age_to,
									'age_from' => $age_from,
									'country' => $country,
									'state' => $state,
									'city' => $city,
									'availability_move_country' => $availability_move_country,
									'availability_move_state' => $availability_move_state,
									'degree_title' => $degree_title,
									'graduate_degree' => $graduate_degree,
									'diciplines_and_skills' => $diciplines_and_skills,
									'match_all_diciplines_and_skills' => $match_all_diciplines_and_skills,
									'gross_mensual_remuneration_max' => $gross_mensual_remuneration_max,
									'gross_mensual_remuneration_min' => $gross_mensual_remuneration_min,
									'availability_for_travel' => $availability_for_travel,
									'type_industry' => $laborSectors->type_industry, 
									'type_services' => $laborSectors->type_services, 
									'type_education' => $laborSectors->type_education, 
									'type_go' => $laborSectors->type_go, 
									'type_ngo' => $laborSectors->type_ngo, 
									'type_selfemployment' =>$laborSectors->type_selfemployment,  
									'type_dependencyrelationship' => $laborRelationships->type_dependencyrelationship,
									'type_contractlabor' => $laborRelationships->type_contractlabor,
									'type_contractproject' => $laborRelationships->type_contractproject,
									'type_contractconsulting' => $laborRelationships->type_contractconsulting,
									'type_other' => $laborRelationships->type_other,
									'required_fulltime' => $availabilityTimes->required_fulltime,						
									'required_parttime' => $availabilityTimes->required_parttime,
									'required_ondemand' => $availabilityTimes->required_ondemand,
									'userid' => $userid,
									'competencies' => $competenciesString					
								), 
								 array(
									'id' => $cid
									),
								array( 
									'%s', 
									'%d',
									'%d',
									'%s', 
									'%s',
									'%s',
									'%d',
									'%d',
									'%s',
									'%s',
									'%s',
									'%d',
									'%d', 
									'%d', 
									'%d',
									'%d',
									'%d',
									'%d',									
									'%d', 
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d', 
									'%d',
									'%d',
									'%d',
									'%s'									
								),
								array( 
									'%d' 
									) 								
							);
				
						    	 
		    }
		return $maxid;
		 
		 
	}
	
	public function isOwner($userid,$searchid){
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs WHERE id='.$searchid.' AND userid='.$userid.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		if (sizeof($data) == 0)
			return false;
		else
			return true;	
	}
 		
}
?>