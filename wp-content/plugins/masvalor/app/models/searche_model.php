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
require_once('masvalor_utils.php');
 
class searcheModel {
    
   public function getData($cid){	
		
		global $wpdb;
		if ($cid == null or $cid == "" )
		   $row = null;
		else{
			
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companysearchs WHERE id='.$cid.';';
			$data = $wpdb->get_results($sql,OBJECT_K);
			foreach ($data as $aData):
				return $aData;
			endforeach;
			return null;	
		}
				
		return	$row;

   }
   
   public function getDataCompany($id){	

		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_companies WHERE userid='.$id;
		$data = $wpdb->get_results($sql,OBJECT_K);
		if($data && $data != null && $data != '')
			foreach ($data as $aData):
				return $aData;
			endforeach;
		return null;
   }
   
    public function getPostulants($type,$searchid){	

		global $wpdb;
		$sql = 'SELECT (floor((unix_timestamp()-unix_timestamp(p.birth_date)) / (60*60*24*365))) as age,p.name,p.lastname,p.gender,p.userid,p.cv,sr.date FROM '.$wpdb->prefix.'masvalor_profiles p,'.$wpdb->prefix.'masvalor_searchresults sr WHERE p.userid = sr.userid AND searchid='.$searchid.' AND type='.$type.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;

   }
   
   public function getDisciplines($id){
		global $wpdb;
		$sql = 'SELECT sub.id as subdisciplineid,sub.name as subdiscipline_name,dis.name as discipline_name, rusd.ppal as ppal FROM '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_searchs_subdisciplines rusd WHERE rusd.id_search='.$id.' AND rusd.id_subdiscipline=sub.id AND sub.id_discipline=dis.id';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
   	
    public function accept($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companysearchs', 
					   array(
						    'adminid' => $adminid, 		
						    'actived' => 1,
							'status' => 'En curso',
							'last_status_date' => date('Y-m-d')
							), 
					   array(
						'id' => $cid
					   ),
					   array( 
							'%d',
							'%d',
							'%s',
							'%s'
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
				 
		//notificar doctores		 
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
	
	function sendNotification($name,$lastname,$email){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/doctor.php?date='.date("d-m-Y").'&email='.$email);
		
		//$texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/doctor.html');
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= "From:".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Nueva Busqueda Masvalor";
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
	
	
	public function close($cid){
		global $wpdb;
		$wpdb->show_errors();
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companysearchs', 
					   array(	
						    'actived' => 2,
							'status' => 'Insatisfecha',
							'last_status_date' => date('Y-m-d')
							), 
					   array(
						'id' => $cid
					   ),
					   array( 
							'%d',
							'%s',
							'%s'
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	
	public function reopen($cid){
		global $wpdb;
		$wpdb->show_errors();
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companysearchs', 
					   array(	
						    'actived' => 1,
							'status' => 'En curso',
							'last_status_date' => date('Y-m-d')
							), 
					   array(
						'id' => $cid
					   ),
					   array( 
							'%d',
							'%s',
							'%s'
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	
	public function selectHired($cid,$userid){
		global $wpdb;
		$wpdb->show_errors();
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companysearchs', 
					   array(
							'actived' => 3,
						    'selected_profile' => (int)$userid, 		
							'status' => 'Satisfecha',
							'last_status_date' => date('Y-m-d')
							), 
					   array(
						'id' => $cid
					   ),
					   array( 
							'%d',
							'%d',
							'%s',
							'%s'
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(	
						    'actived' => 3
							), 
					   array(
						'userid' => $userid
					   ),
					   array( 
							'%d'
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	
	public function transform($cid,$transformList){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID; 
		foreach ($transformList as $transformid):
			//Chequeo que no sea ya no sea candidato del tipo 0
			$sql = 'SELECT userid FROM '.$wpdb->prefix.'masvalor_searchresults WHERE type = 0 AND searchid='.$cid.' AND userid='.$transformid;
			$data = $wpdb->get_results($sql);
			//Si se cumple, lo agrego como candidato del tipo 0
			if (sizeof($data) === 0){
				$wpdb->insert( 				
						   $wpdb->prefix.'masvalor_searchresults', 
						   array(
								'type' => 0,
								'searchid' => (int)$cid, 		
								'userid' => (int)$transformid,
								'whoadd' => (int)$adminid,
								'date' => date('Y-m-d')
								),
						   array( 
								'%d',
								'%d',
								'%d',
								'%d',
								'%s'
						   )
					 );
					}	
		endforeach;
	}
	
	
	public function getHiredData($userid){	

		global $wpdb;
		if ($userid != '' && $userid != null){
			$sql = 'SELECT p.name,p.lastname,p.gender,p.userid,p.cv FROM '.$wpdb->prefix.'masvalor_profiles p WHERE p.userid ='.$userid.';';
			$data = $wpdb->get_results($sql,OBJECT_K);
			foreach ($data as $aData):
				return $aData;
			endforeach;
		}
		return null;

   }
   
   public function save($cid){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$job_title = $_POST['job_title'];
		$job_description = $_POST['job_description'];
		$userid = $_POST['userid'];
		$company = $_POST['company'];
		$type_industry = 0;
		$type_services = 0; 
		$type_education = 0;
		$type_go = 0;
		$type_ngo = 0;
		$type_selfemployment = 0;
		$subdisciplines = $_POST["disciplines"];
		$disc_ppal = $_POST["ppal_disc"];
		
		switch($_POST['type_laborsector']){
			case 'type_industry':$type_industry = 1;break;
			case 'type_services':$type_services = 1;break;
			case 'type_education':$type_education = 1;break;
			case 'type_go':$type_go = 1;break;
			case 'type_ngo':$type_ngo = 1;break;
			case 'type_selfemployment':$type_selfemployment = 1;break;
		}
		
		$type_dependencyrelationship = 0;
		$type_contractlabor = 0; 
		$type_contractproject = 0;
		$type_contractconsulting = 0;
		$type_other = 0;
		switch($_POST['type_laborrelationships']){
			case 'type_dependencyrelationship':$type_dependencyrelationship = 1;break;
			case 'type_contractlabor':$type_contractlabor = 1;break;
			case 'type_contractproject':$type_contractproject = 1;break;
			case 'type_contractconsulting':$type_contractconsulting = 1;break;
			case 'type_other':$type_other = 1;break;
		}
		
		$required_fulltime = 0;
		$required_parttime = 0; 
		$required_ondemand = 0;
		switch($_POST['required_availabilitytime']){
			case 'required_fulltime':$required_fulltime = 1;break;
			case 'required_parttime':$required_parttime = 1;break;
			case 'required_ondemand':$required_ondemand = 1;break;
		}
		
		$company_description = $_POST['company_description'];
		$location_department = $_POST['location_department'];
		$employment_relationship = $_POST['employment_relationship'];
		$remuneration_offered = $_POST['remuneration_offered'];
		$other_benefits = $_POST['other_benefits'];
		$months_duration = $_POST['months_duration'];
		$workload = $_POST['workload'];
		$profile_description = $_POST['profile_description'];
		$experience = $_POST['experience'];
		$gender = $_POST['gender'];
		$age_to = $_POST['age_to'];
		$age_from = $_POST['age_from'];
		
		$willingness_to_travel = "";
		if (isset($_POST['willingness_to_travel'])) {
			$willingness_to_travel = "checked";
		} 
				
		$country = $_POST['country'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		$degree_title = $_POST['degree_title'];
		$graduate_degree = $_POST['graduate_degree'];
		// $disciplines_required = $_POST['disciplines_required'];
		$competencies_skills = $_POST['competencies_skills'];
		
		$maxid = null;		
	    global $wpdb;
		$wpdb->show_errors();
	    
		if ($cid == null or $cid == "" ) {

				 $wpdb->insert( 
								$wpdb->prefix.'masvalor_companysearchs', 
								array(
									'start_date' => $start_date, 
									'end_date' => $end_date, 
									'job_title' => $job_title, 
									'job_description' => $job_description,
									'company' => $company,									
									'userid' => $userid, 
									'type_industry' => $type_industry, 
									'type_services' => $type_services, 
									'type_education' => $type_education, 
									'type_go' => $type_go, 
									'type_ngo' => $type_ngo, 
									'type_selfemployment' => $type_selfemployment,  
									'company_description' => $company_description, 
									'location_department' => $location_department, 
									'type_dependencyrelationship' => $type_dependencyrelationship,
									'type_contractlabor' => $type_contractlabor,
									'type_contractproject' => $type_contractproject,
									'type_contractconsulting' => $type_contractconsulting,
									'type_other' => $type_other,									
									'remuneration_offered' => $remuneration_offered,
									'other_benefits' => $other_benefits,									
									'months_duration' => $months_duration, 
									'required_fulltime' => $required_fulltime, 	
									'required_parttime' => $required_parttime,
									'required_ondemand' => $required_ondemand,
									'profile_description' => $profile_description,
									'experience' => $experience,									
									'gender' => $gender, 
									'age_to' => $age_to, 
									'age_from' => $age_from, 
									'willingness_to_travel' => $willingness_to_travel, 
									'country' => $country,
									'city' => $city, 
									'state' => $state, 
									'degree_title' => $degree_title, 
									'graduate_degree' => $graduate_degree, 
									'competencies_skills' => $competencies_skills,
									'actived' => 0,
									'status' => 'Pendiente',
									'last_status_date' =>  date('Y-m-d')									
								), 
								array( 
									'%s',
									'%s', 
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
									'%s',
									'%s',
									'%d', 
									'%d',
									'%d',
									'%d',
									'%d',									
									'%s', 
									'%s',
									'%s', 
									'%d',
									'%d',
									'%d',
									'%s',
									'%s', 
									'%s',
									'%s',
									'%s', 
									'%s',
									'%s',
									'%s',
									'%s',
									'%s', 
									'%s',
									'%s',
									'%d', 
									'%s'
								) 
							);
				$maxid = $wpdb->insert_id;
				foreach($subdisciplines as $sub) {
					$ppal = 0;
					if($disc_ppal == $sub) {
						$ppal = 1;
					}
					$wpdb->insert($wpdb->prefix.'masvalor_rel_searchs_subdisciplines',array('id_subdiscipline' => $sub,'id_search' => $maxid,'ppal' => $ppal),array('%d','%d','%d'));
				}
				return $maxid;
			}else{
		        
				$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companysearchs', 
					   array(
						    'start_date' => $start_date, 
							'end_date' => $end_date, 
							'job_title' => $job_title, 
							'job_description' => $job_description,
							'company' => $company,									
							'type_industry' => $type_industry, 
							'type_services' => $type_services, 
							'type_education' => $type_education, 
							'type_go' => $type_go, 
							'type_ngo' => $type_ngo, 
							'type_selfemployment' => $type_selfemployment,  
							'company_description' => $company_description, 
							'location_department' => $location_department, 
							'type_dependencyrelationship' => $type_dependencyrelationship,
							'type_contractlabor' => $type_contractlabor,
							'type_contractproject' => $type_contractproject,
							'type_contractconsulting' => $type_contractconsulting,
							'type_other' => $type_other,	 
							'remuneration_offered' => $remuneration_offered, 
							'other_benefits' => $other_benefits,
							'months_duration' => $months_duration, 
							'required_fulltime' => $required_fulltime, 	
							'required_parttime' => $required_parttime,
							'required_ondemand' => $required_ondemand, 	
							'profile_description' => $profile_description,
							'experience' => $experience, 
							'gender' => $gender, 
							'age_to' => $age_to, 
							'age_from' => $age_from, 
							'willingness_to_travel' => $willingness_to_travel, 
							'country' => $country,
							'state' => $state, 
							'city' => $city, 
							'degree_title' => $degree_title, 
							'graduate_degree' => $graduate_degree, 
							'competencies_skills' => $competencies_skills							 
							), 
					   array(
						'id' => $cid
					   ),
					   array( 
							'%s',
							'%s', 
							'%s', 
							'%s',
							'%s',
							'%d',
							'%d',
							'%d',
							'%d',
							'%d',
							'%d',
							'%s',
							'%s',
							'%d', 
							'%d',
							'%d',
							'%d',
							'%d',									
							'%s', 
							'%s',
							'%s', 
							'%d',
							'%d',
							'%d',
							'%s',
							'%s', 
							'%s',
							'%s',
							'%s', 
							'%s',
							'%s',
							'%s',
							'%s',
							'%s', 
							'%s',
							'%s' 
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		 		
				$wpdb->query('delete from '.$wpdb->prefix.'masvalor_rel_searchs_subdisciplines where id_search='.$cid);

				foreach($subdisciplines as $sub) {
					$ppal = 0;
					if($disc_ppal == $sub) {
						$ppal = 1;
					}
					$wpdb->insert($wpdb->prefix.'masvalor_rel_searchs_subdisciplines',array('id_subdiscipline' => $sub,'id_search' => $cid,'ppal' => $ppal),array('%d','%d','%d'));
				}
				return $cid;
		    }
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