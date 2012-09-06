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

class doctorProfileModel {
    
	function sendNotification($email,$name,$lastname){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		// $texto = 'El sistema +Valor.doc le informa que ha sido activado como doctor y a partir de ahora se encuentra habilitado para operar en el sistema de forma completa.';
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/doctor-activated.php?date='.date("d-m-Y").'&email='.$email.'&name='.$name.'&lastname='.$lastname);
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= "From: ".$adminemail."\r\n"; // remitente
		$headers .= "Return-Path:".$adminemail."\r\n"; // return-path*/
		$asunto ="Activación Usuario +VALOR.Doc";
		mail($email,$asunto,$texto,$headers);
	}
	
	
	function sendManualNotification($email,$texto,$type,$name,$lastname){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$headers = "MIME-Version: 1.1\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= "From:".$adminemail."\r\n"; // remitente
		$headers .= "Return-Path:".$adminemail."\r\n"; // return-path*/
		if($type == 'rejected')
			$asunto ="Rechazo en +Valor.doc";
		elseif($type == 'desactived')
			$asunto = "Desactivación en +Valor.doc";
		elseif($type == 'pending')
			$asunto = "Desactivación de cuenta +VALOR.Doc";
			
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/desactivacion.php?date='.date("d-m-Y").'&email='.$email.'&name='.$name.'&lastname='.$lastname);
			
		mail($email,$asunto,$texto,$headers);
	}
	
	
	function give_me_doctor_email($id_doctor) {
		global $wpdb;
		$sql_query = 'select user_email from '.$wpdb->prefix.'users where ID='.$id_doctor;
		
		return $wpdb->get_var($sql_query);
	}
	
	function give_me_doctor_name($id_doctor) {
		global $wpdb;
		$sql_query = 'SELECT name FROM '.$wpdb->prefix.'masvalor_profiles WHERE userid='.$id_doctor;
		
		return $wpdb->get_var($sql_query);
	}
	
	function give_me_doctor_lastname($id_doctor) {
		global $wpdb;
		$sql_query = 'SELECT lastname FROM '.$wpdb->prefix.'masvalor_profiles WHERE userid='.$id_doctor;
		
		return $wpdb->get_var($sql_query);
	}
	
	
	
	function give_me_all_comisions() {
		global $wpdb;
		$sql_query = 'select id,name from '.$wpdb->prefix.'masvalor_advisory_committees order by name asc';
		
		return $wpdb->get_results($sql_query);
	}
	
	function give_me_all_zones() {
		global $wpdb;
		$sql_query = 'select id,name from '.$wpdb->prefix.'masvalor_zones order by name';
		
		return $wpdb->get_results($sql_query);
	}
	
	
	public function accept($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(
						    'actived' => 1,
							), 
					   array(
						'userid' => $cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$doctor_email = $this->give_me_doctor_email($cid);
		$name = $this->give_me_doctor_name($cid);
		$lastname = $this->give_me_doctor_lastname($cid);
		$this->sendNotification($doctor_email,$name,$lastname);
	}
	
	
	public function getDisciplineNameById($id_discipline) {
		global $wpdb;
		$sql = 'select name from '.$wpdb->prefix.'masvalor_subdisciplines where id='.$id_discipline;
		return $wpdb->get_var($sql);
	}
	
	
	public function desactive($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$text_mail = $_POST['desactived_mail'];
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(
						    'actived' => 2,
							), 
					   array(
						'userid' => $cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$doctor_email = $this->give_me_doctor_email($cid);
		$name = $this->give_me_doctor_name($cid);
		$lastname = $this->give_me_doctor_lastname($cid);
		$this->sendManualNotification($doctor_email,$text_mail,'desactived',$name,$lastname);
	}
	
	
	public function reject($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$text_mail = $_POST['rejected_mail'];
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(
						    'actived' => 4,
							), 
					   array(
						'userid' => $cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$doctor_email = $this->give_me_doctor_email($cid);
		$name = $this->give_me_doctor_name($cid);
		$lastname = $this->give_me_doctor_lastname($cid);
		$this->sendManualNotification($doctor_email,$text_mail,'rejected',$name,$lastname);
	}
	
	public function pending($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$text_mail = $_POST['pending_mail'];
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(
						    'actived' => 0,
							), 
					   array(
						'userid' => $cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$doctor_email = $this->give_me_doctor_email($cid);
		$name = $this->give_me_doctor_name($cid);
		$lastname = $this->give_me_doctor_lastname($cid);
		$this->sendManualNotification($doctor_email,$text_mail,'pending',$name,$lastname);
	}
	
	public function carencia($cid) {
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$text_mail = $_POST['pending_mail'];
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_profiles', 
					   array(
						    'actived' => 3,
							), 
					   array(
						'userid' => $cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}	
	
   public function save($step,$parameters){
		if ($step == 'step1')
			$update = $this->saveStep1($parameters);
		if ($step == 'step2')
			$update = $this->saveStep2($parameters);
		if ($step == 'step3')
			$update = $this->saveStep3($parameters);
		if ($update !== true){
			return __('Hubo un error al guardar los datos'.'</br>'.$update);
			}
		return __("Datos guardados con &eacute;xito");
   }
   
   
  function getExitZone($id_doctor){
    global $wpdb;
	$sql = 'SELECT COUNT(*) AS count FROM '.$wpdb->prefix.'masvalor_profile_ca_zc WHERE id_doctor ='.$id_doctor;
	
	$data = $wpdb->get_results($sql);
			
	foreach ($data as $aData):
		$count= $aData->count;
	endforeach; 
	
	if($count > 0)
	  return true;
	else
      return false;	
	 
  }
  
  
  function getZoneSaved($user_id){
    global $wpdb;
			
	$sql = 'SELECT id_zc FROM '.$wpdb->prefix.'masvalor_profile_ca_zc WHERE id_doctor ='.$user_id;
	
	$data = $wpdb->get_results($sql);
			
	foreach ($data as $aData):
		$id_zc = $aData->id_zc;
	endforeach; 
	
	return $id_zc;
	 
   }
  
  
   function getComisionSaved($user_id){
		global $wpdb;
					
		$sql = 'SELECT id_ca FROM '.$wpdb->prefix.'masvalor_profile_ca_zc WHERE id_doctor ='.$user_id;
		
		$data = $wpdb->get_results($sql);
				
		foreach ($data as $aData):
			$id_ca = $aData->id_ca;
		endforeach; 
		
		return $id_ca;
   }
    
  
  
  function save_zones($id_doctor) {
	  global $wpdb;
	  $id_zone = $_POST["id_zone"];
	  
	  if(!$this->getExitZone($id_doctor)){	
		$wpdb->insert($wpdb->prefix.'masvalor_profile_ca_zc',array('id_doctor' => $id_doctor,'id_zc' => $id_zone),array('%d','%d'));
		
	  }else{
         $wpdb->update( 
					   $wpdb->prefix.'masvalor_profile_ca_zc', 
					   array(
						'id_zc' => $id_zone						
					   ), 
					   array(
						'id_doctor' => $id_doctor
					   ),
					   array( 
						'%d'						 
					   ),
					   array( 
						'%d' 
					   ) 
			  	   );	
		
	}		   
	 	
 }
    
  
   function save_comisions($id_doctor) {
	  global $wpdb;
	  $id_comision = $_POST["id_comision"];
	  
	  //$wpdb->update($wpdb->prefix.'masvalor_profile_ca_zc',array('id_doctor' => $id_doctor,'id_ca' => $id_comision),array('ID' => (int)$userid),array('%d','%d'),array('%d'));
      
	  $wpdb->update( 
					   $wpdb->prefix.'masvalor_profile_ca_zc', 
					   array(
						'id_ca' => $id_comision						
					   ), 
					   array(
						'id_doctor' => $id_doctor
					   ),
					   array( 
						'%d'						 
					   ),
					   array( 
						'%d' 
					   ) 
			  	   );
	  
	  
	  
  }
   
    private function saveStep1($parameters){
		global $wpdb;
		$userid = $parameters['userid'];
		
		global $current_user;
		get_currentuserinfo();
		
		if (checkUserType($current_user->user_login,'masvalor-admin')){
			$actived = $parameters['actived'];
			if($actived == 0)
				$this->pending($userid);
			else {
				if($actived == 1){
					$this->accept($userid);
					$this->sendNotification($email,$doctor_name,$lastname);
				}
				else {
					if($actived == 2){
						$this->desactive($userid);
						$desactived = $parameters['desactived'];
						$this->sendNotification($desactived,$email,$doctor_name,$lastname);
					}
					else {
						if($actived == 3){
							$this->carencia($userid);
						} else {
							$this->reject($userid);
							$rejected = $parameters['rejected'];
							$this->sendNotification($rejected,$email,$doctor_name,$lastname);
						}
					}   
				
				}
			}
			
/* 			$rejected = $parameters['rejected'];
			$desactived = $parameters['desactived'];
			$pending = $parameters['pending'];
			
			if($actived == 'on')
				$this->accept($userid);
			if($rejected == 'on')
				$this->reject($userid);
			if($desactived == 'on')
				$this->desactive($userid);
			if($pending == 'on')
				$this->pending($userid); */
		}
		
		$this->save_zones($userid);
		
		$imageFile  = $_FILES['identity_image_file'];

		if ((int)$imageFile['size'] <= (int)$parameters['identity_image_size'] && !strstr(utf8_decode($imageFile['name']),'ñ') && !strstr(utf8_decode($imageFile['name']),'Ñ')){
			if ($imageFile['name'] != '' && $imageFile['name'] != null){
				
				$identity_image = masvalor_doUpload($userid,$imageFile);
				}
			else 
				$identity_image = $parameters['identity_image'];
			}
		else 
			echo __("Su imagen de identidad debe tener como m&aacute;ximo un tama&ntilde;o de ").$parameters['identity_image_size']." bytes y no puede contener caract&eacute;res extra&ntilde;os.";
		
		$cvFile  = $_FILES['cv_file'];
		if ($cvFile['size'] <= $parameters['cv_size'] && !strstr(utf8_decode($imageFile['name']),'ñ') && !strstr(utf8_decode($imageFile['name']),'Ñ')){
			if ($cvFile['name'] != '' && $cvFile['name'] != null)
				$cv = masvalor_doUpload($userid,$cvFile);
			else
				$cv = $parameters['cv'];
			}
		else 
			echo __("Su cv debe tener como m&aacute;ximo un tama&ntilde;o de ").$parameters['cv_size']." bytes y su nombre no puede contener caract&eacute;res extra&ntilde;os.";
		$wpdb->show_errors();
		$doctor_name = $parameters['doctor_name'];
		$lastname = $parameters['lastname'];
		
		$birth_date = $parameters['birth_date'];
		$date2 = explode("-",$birth_date);
		$birth_date_form = $date2[2].'-'.$date2[1].'-'.$date2[0];
												
		
		$gender = $parameters['gender'];
		$cuit = $parameters['cuit'];	
		$nationality = $parameters['nationality'];
		$identity_type = $parameters['identity_type'];
		$identity_number = $parameters['identity_number'];
		$street_name = $parameters['street_name'];
		$street_number = $parameters['street_number'];
		$department_number = $parameters['department_number'];
		$floor_number = $parameters['floor_number'];
		$country = $parameters['country'];
		$state = $parameters['state'];
		$city = $parameters['city'];
		$postal_code = $parameters['postal_code'];
		$main_contact_mail = $parameters['main_contact_mail'];
		$optional_contact_mail = $parameters['optional_contact_mail'];
		$phone_numbers = $parameters['phone_numbers'];
		$cell_numbers = $parameters['cell_numbers'];
		$marital_status = $parameters['marital_status'];
		$hobbies_sports_others = $parameters['hobbies_sports_others'];
		
		//Check if admin change the doctor username or password
		if (checkUserType($current_user->user_login,'masvalor-admin')){
			$new_username = $_POST['username_admin'];
			$new_password = $_POST['password_admin'];
			
			if($new_password != '' && $new_password != null)
				$wpdb->update($wpdb->prefix.'users',array('user_login' => $new_username,'user_pass' => md5($new_password)),array('ID' => (int)$userid),array('%s','%s'),array('%d'));
			else
				$wpdb->update($wpdb->prefix.'users',array('user_login' => $new_username),array('ID' => (int)$userid),array('%s'),array('%d'));
		}	
		
		//Insert data in db
		$update = $wpdb->update( 
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'name' => $doctor_name,
			 'lastname' => $lastname,
			 'birth_date' => $birth_date_form,
			 'gender' => $gender,
			 'cuit'   => $cuit,
			 'nationality' => $nationality,
			 'identity_type' => $identity_type,
			 'identity_number' => $identity_number,
			 'street_name' => $street_name,
			 'street_number' => $street_number,
			 'department_number' => $department_number,
			 'floor_number' => $floor_number,
			 'country' => $country,
			 'state' => $state,
			 'city' => $city,
			 'postal_code' => $postal_code,
			 'main_contact_mail' => $main_contact_mail,
			 'optional_contact_mail' => $optional_contact_mail,
			 'phone_numbers' => $phone_numbers,
			 'cell_numbers' => $cell_numbers,
			 'marital_status' => $marital_status,
			 'hobbies_sports_others' => $hobbies_sports_others,
			 'identity_image' => $identity_image,
			 'cv' => $cv
			), 
			array(
			 'userid' => (int)$userid 
			),
			array( 
			 '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'
			),
			array( 
			 '%d' 
			) 
		   );
		if ($update !== false)
			return true;
		else
			return false;
   }
   
   private function saveStep2($parameters){
		global $wpdb;
		$userid = $parameters['userid'];
		$wpdb->show_errors();
		$tesisSize = $parameters['tesis_size'];
		$auxLanguages = $parameters['languages'];
		$languages = '';
		$i=0;
		if ($auxLanguages != null)
			foreach ($auxLanguages as $auxLanguage):
				if ($i===0)
					$languages .= $auxLanguage;
				else
					$languages .= '<*>'.$auxLanguage;
				$i++;
			endforeach;
			
		$this->save_comisions($userid);
		
		//Manage Titles Grade
		$auxTitles = $parameters['titles'];
		$titles = array();
		$i = 0;
		if ($auxTitles != null)
			foreach ($auxTitles as $auxTitle):
				$aTitle = explode('{*}',$auxTitle);
				$titles[$i]['title'] = $aTitle[0];
				$titles[$i]['university'] = $aTitle[1];
				$titles[$i]['date_from'] = $aTitle[2];
				
				$array_date = explode("-",$titles[$i]['date_from']);
				$titles[$i]['date_from'] = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];
				
				$titles[$i]['date_to'] = $aTitle[3];
				
				$array_date = explode("-",$titles[$i]['date_to']);
				$titles[$i]['date_to'] = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];		 
				
				if(strlen($titles[$i]['date_to']) == 4)
					$titles[$i]['date_to'] = $titles[$i]['date_to'].'-01-01';
				if(strlen($titles[$i]['date_from']) == 4)
					$titles[$i]['date_from'] = $titles[$i]['date_from'].'-01-01';					
				$titles[$i]['finalized'] = $aTitle[4];
				$titles[$i]['type'] = 0;
				$i++;
			endforeach;
			$ppal = $parameters['ppal_disc'];
		//Manage Titles Posgrade
		$auxTitlesPos = $parameters['titlesPos'];
		$titlesPos = array();
		$i = 0;
		if ($auxTitlesPos != null)
			foreach ($auxTitlesPos as $auxTitlePos):
				$aTitle = explode('{*}',$auxTitlePos);
				$titlesPos[$i]['title'] = $aTitle[0];
				$titlesPos[$i]['university'] = $aTitle[1];
				$titlesPos[$i]['date_from'] = $aTitle[2];
				
				$array_date = explode("-",$titlesPos[$i]['date_from']);
				$titlesPos[$i]['date_from'] = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];
				
				$titlesPos[$i]['date_to'] = $aTitle[3]; 
				
				$array_date = explode("-",$titlesPos[$i]['date_to']);
				$titlesPos[$i]['date_to'] = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];		
				
				if(strlen($titles[$i]['date_to']) == 4)
					$titlesPos[$i]['date_to'] = $titles[$i]['date_to'].'-01-01';
				if(strlen($titles[$i]['date_from']) == 4)
					$titlesPos[$i]['date_from'] = $titles[$i]['date_from'].'-01-01';	
				$titlesPos[$i]['finalized'] = $aTitle[4];
				$titlesPos[$i]['type'] = 1;
				$titlesPos[$i]['type_title'] = $aTitle[5];
				$titlesPos[$i]['ppal'] = $aTitle[6];
				$i++;
			endforeach;

		//Manage Tesis
		$auxTesis = $parameters['tesis'];
		$tesisFiles  = $_FILES['tesisfiles'];
		$defenseTesisFiles = $_FILES['defensefiles'];
		if($defenseTesisFiles == null || $defenseTesisFiles == '')
			$defenseTesisFiles = array();
		if ($tesisFiles == null || $tesisFiles == '')
			$tesisFiles  = array();
		$tesis = array();
		$i = 0;
		if ($auxTesis != null)
			foreach ($auxTesis as $aAuxTesis):
				$aTesis = explode('{*}',$aAuxTesis);
				$tesis[$i]['title'] = $aTesis[0];
				$tesis[$i]['topic'] = $aTesis[1];
				$tesis[$i]['publication_date'] = $aTesis[2];
				$array_date = explode("-",$tesis[$i]['publication_date']);
				$tesis[$i]['publication_date'] = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];		
				$tesis[$i]['file'] = str_replace(" ","_",$aTesis[3]);
				$tesis[$i]['type'] = 1;
				$tesis[$i]['disciplineid'] = $aTesis[4];
				$tesis[$i]['defense_file'] = str_replace(" ","_",$aTesis[5]);
				$tesis[$i]['fileExist'] = $aTesis[6];
				if($tesis[$i]['fileExist'] == 0) {				
					$today = getdate();
					$tesis[$i]['uri_title'] = ($today[0]+$i)."_title".strrchr($tesisFiles['name'][$i], '.');
					$tesis[$i]['uri_defense'] = ($today[0]+$i)."_defense".strrchr($defenseTesisFiles['name'][$i], '.');
				} else {
					$uri_title = explode('/',$aTesis[7]);
					$uri_defense = explode('/',$aTesis[8]);
					
					$uri_last = count($uri_title)-1; 
					$uri_def_last = count($uri_defense)-1;
					
					$tesis[$i]['uri_title'] = $uri_title[$uri_last];
					$tesis[$i]['uri_defense'] = $uri_defense[$uri_def_last];
					
				}
				$i++;
			endforeach;
		
				
		//Manage Experiences
		$auxExperiencies = $parameters['experiences'];
		$experiencies = '';
		$i=0;
		if ($auxExperiencies != null)
			foreach ($auxExperiencies as $auxExperiencie):
				if ($i === 0)
					$experiencies .= $auxExperiencie;
				else
					$experiencies .= '<*>'.$auxExperiencie;
				$i++;
			endforeach;
			
		//Manage Disciplines
		$disciplines = $parameters['disciplines'];
		if($disciplines == null || $disciplines == '')
			$disciplines  = array();
		$otherDisciplines = $parameters['other_disciplines'];
		
		//Manage Competencies
		$competencies = $parameters['competencies'];
		if ($competencies == null || $competencies == '')
			$competencies  = array();
			
		//Insert data in db
		$update = $wpdb->update( 
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'langs_s_w_r' => $languages,
			 'experience' => $experiencies,
			 'other_disciplines' => $otherDisciplines
			), 
			array(
			 'userid' => (int)$userid 
			),
			array( 
			 '%s','%s','%s'
			),
			array( 
			 '%d' 
			) 
		   );
		if ($update === false)
			return $update;
		//Refresh Grade titles
		$update = $this->refreshTitles($userid,0,$titles);
		if ($update !== true)
			return $update;
		//Refresh Posgrade titles
		$update = $this->refreshTitles($userid,1,$titlesPos);
		if ($update !== true)
			return $update;
		//Refresh Disciplines
		$update = $this->refreshDisciplines($userid,$disciplines,$ppal);
		if ($update !== true)
			return $update;
		//Refresh Competencies
		$update = $this->refreshCompetencies($userid,$competencies);
		if ($update !== true)
			return $update;
		//Refresh Tesis
		$update = $this->refreshTesis($userid,1,$tesis,$tesisFiles,$tesisSize,$defenseTesisFiles);
		if ($update !== true)
			return $update;
		return true;
   }
   
   
   /* 
      $type 
		- 0: Grado
		- 1: Posgrado
      $titles = array of titles 
	*/
   private function refreshTitles($userid,$type,$titles){ 
		global $wpdb;
		//Delete all titles from user
		$sql = "
		DELETE FROM ".$wpdb->prefix."masvalor_profiletitles
		WHERE userid = ".$userid."
		AND type =".$type.";";
		$result = $wpdb->query($sql);
		
		if ($result === false)
			return $result;
		//Inserts all titles
		foreach ($titles as $title):
			$insert = $wpdb->insert( 
			$wpdb->prefix.'masvalor_profiletitles', 
			array(
			 'userid' => (int)$userid,
			 'type' => (int)$title['type'],
			 'title' => $title['title'],
			 'university' => (int)$title['university'],
			 'type_title' => $title['type_title'],
			 'from_date' => $title['date_from'],
			 'to_date' => $title['date_to'],
			 'ppal' => $title['ppal'],
			 'finalized' => (int)$title['finalized']
			), 
			array( 
			 '%d','%d','%s','%d','%s','%s','%s','%d','%d'
			)
		   );
		   if ($insert === false)
			return $insert;
		endforeach;
		
		return true;
   }
   

   private function refreshDisciplines($userid,$disciplines,$id_ppal){ 
		global $wpdb;
		//Delete all disciplines from user
		$sql = "
		DELETE FROM ".$wpdb->prefix."masvalor_rel_user_subdisciplines
		WHERE userid = ".$userid.";";
		$result = $wpdb->query($sql);
		
		if ($result === false)
			return $result;
		
		//Inserts all disciplines
		foreach ($disciplines as $discipline): 
			$insert = $wpdb->insert( 
			$wpdb->prefix.'masvalor_rel_user_subdisciplines', 
			array(
			 'userid' => (int)$userid,
			 'subdisciplineid' => $discipline
			), 
			array( 
			 '%d','%d'
			)
		   );
		   if ($insert === false)
			return $insert;
		   else
			$sql = 'update '.$wpdb->prefix.'masvalor_rel_user_subdisciplines set ppal=1 where subdisciplineid='.$id_ppal;
			$wpdb->query($sql);
		endforeach;
		return true;
   }
   
   private function refreshCompetencies($userid,$competencies){ 
		global $wpdb;
		//Delete all competencies from user
		$sql = "
		DELETE FROM ".$wpdb->prefix."masvalor_rel_user_competencies
		WHERE userid = ".$userid.";";
		$result = $wpdb->query($sql);
		
		if ($result === false)
			return $result;
		
		//Inserts all competencies
		foreach ($competencies as $competence):
			$insert = $wpdb->insert( 
			$wpdb->prefix.'masvalor_rel_user_competencies', 
			array(
			 'userid' => (int)$userid,
			 'competitionid' => $competence
			), 
			array( 
			 '%d','%d'
			)
		   );
		   if ($insert === false)
			return $insert;
		endforeach;
		return true;
   }
   
   
   
   /* 
      $type 
		- 0: Grado
		- 1: Posgrado
      $tesis = array of tesis 
	  $tesisFiles = array of tesis files
	*/
   private function refreshTesis($userid,$type,$tesis,$tesisFiles,$tesisSize,$defenseTesisFiles){ 
		global $wpdb;
		
		//Uploads new Tesis
		$msg='';
		for ( $i = 0; $i<sizeof($tesisFiles['name']) ; $i++ ){
				$aTesisFile['name'] = $tesis[$i]['uri_title']; //str_replace(" ","_",$tesisFiles['name'][$i]);
				$aTesisFile['type'] = $tesisFiles['type'][$i];
				$aTesisFile['tmp_name'] = $tesisFiles['tmp_name'][$i];
				$aTesisFile['error'] = $tesisFiles['error'][$i];
				$aTesisFile['size'] = $tesisFiles['size'][$i];
				$aDefenseTesisFile['name'] = $tesis[$i]['uri_defense']; //str_replace(" ","_",$defenseTesisFiles['name'][$i]);
				$aDefenseTesisFile['type'] = $defenseTesisFiles['type'][$i];
				$aDefenseTesisFile['tmp_name'] = $defenseTesisFiles['tmp_name'][$i];
				$aDefenseTesisFile['error'] = $defenseTesisFiles['error'][$i];
				$aDefenseTesisFile['size'] = $defenseTesisFiles['size'][$i];
				if($tesis[$i]['fileExist'] == 0) {
					if ( (int)$aTesisFile['size'] <= (int)$tesisSize  ){
						if ($aTesisFile['name'] != null && $aTesisFile['name'] != '' && $aDefenseTesisFile != null && $aDefenseTesisFile != ''){
								$msg .= masvalor_doUpload($userid,$aTesisFile);
								$msg .= masvalor_doUpload($userid,$aDefenseTesisFile);
						
							}
					} else {
						$msg .= __('Error el subir el fichero').' '.$aTesisFile['name'].__(' su tama&ntilde;o debe ser menor a ').$tesisSize.__(' bytes').'</br>';
						unset($tesis[$i]);
					}
				} 
			
		}
		//Delete all tesis from user
		$sql = "
		DELETE FROM ".$wpdb->prefix."masvalor_profiletesis
		WHERE userid = ".$userid."
		AND type =".$type.";";
		$result = $wpdb->query($sql);
		
		if ($result === false)
			return $result;
		//Inserts all tesis
		foreach ($tesis as $aTesis): 
			$insert = $wpdb->insert( 
			$wpdb->prefix.'masvalor_profiletesis', 
			array(
			 'userid' => (int)$userid,
			 'type' => (int)$aTesis['type'],
			 'title' => $aTesis['title'],
			 'topic' => $aTesis['topic'],
			 'file' => str_replace(" ","_",$aTesis['file']),
			 'defense_file' => str_replace(" ","_",$aTesis['defense_file']),
			 'publication_date' => $aTesis['publication_date'],
			 'id_subdiscipline' => $aTesis['disciplineid'],
			 'uri_title' => $aTesis['uri_title'],
			 'uri_defense' => $aTesis['uri_defense']
			), 
			array( 
			 '%d','%d','%s','%s','%s','%s','%s','%d','%s','%s'
			)
		   );
		   if ($insert === false)
			return $insert;
		endforeach;
		//Si hay errores los devuelvo
		if ($msg != '')
			return $msg;
		//Sino retorno true.
		else
			return true;
   }
   
    private function saveStep3($parameters){
		global $wpdb;
		$userid = $parameters['userid'];
		$wpdb->show_errors();
		$expected_labor_insertion = $parameters['expected_labor_insertion'];
		$expected_gross_mensual_remuneration = $parameters['expected_gross_mensual_remuneration'];
		$availability_for_travel = $parameters['availability_for_travel'] ? 1 : 0;
		$availability_move_state = $parameters['availability_move_state'] ? 1 : 0;
		$availability_move_country = $parameters['availability_move_country'] ? 1 : 0;

		//Manage Labor sector
		$auxLaborSectors = $parameters['laborsectors'];
		if ($auxLaborSectors == null || $auxLaborSectors=='')
			$auxLaborSectors= array();
		$laborSectors = new stdClass;
		$laborSectors->prefer_ls_services = 0;
		$laborSectors->prefer_ls_education = 0;
		$laborSectors->prefer_ls_industry = 0;
		$laborSectors->prefer_ls_go = 0;
		$laborSectors->prefer_ls_ngo = 0;
		$laborSectors->prefer_ls_selfemployment = 0;
		foreach ($auxLaborSectors as $auxLaborSector):
			$laborSectors->$auxLaborSector = 1;			
		endforeach;

		//Manage Labor relationships
		$auxLaborRelationships = $parameters['laborrelationships'];
		if ($auxLaborRelationships == null || $auxLaborRelationships=='')
			$auxLaborRelationships= array();
		$laborRelationships = new stdClass;
		$laborRelationships->prefer_lr_dependencyrelationship = 0;
		$laborRelationships->prefer_lr_contractlabor = 0;
		$laborRelationships->prefer_lr_contractproject = 0;
		$laborRelationships->prefer_lr_contractconsulting = 0;
		$laborRelationships->prefer_lr_other = 0;
		foreach ($auxLaborRelationships as $auxLaborRelationship):
			$laborRelationships->$auxLaborRelationship = 1;			
		endforeach;
		
		//Manage Availability time
		$auxAvailavilityTimes = $parameters['availabilitytimes'];
		if ($auxAvailavilityTimes == null || $auxAvailavilityTimes=='')
			$auxAvailavilityTimes= array();
		$availabilityTimes = new stdClass;
		$availabilityTimes->prefer_at_fulltime = 0;
		$availabilityTimes->prefer_at_parttime = 0;
		$availabilityTimes->prefer_at_ondemand = 0;
		foreach ($auxAvailavilityTimes as $auxAvailavilityTime):
			$availabilityTimes->$auxAvailavilityTime = 1;			
		endforeach;
		

		
		
			
		//Insert data in db
		$update = $wpdb->update(
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'job_expectations' => $expected_labor_insertion,
			 'expected_gross_mensual_remuneration' => $expected_gross_mensual_remuneration,
			 'prefer_ls_services' => $laborSectors->prefer_ls_services,
			 'prefer_ls_education' => $laborSectors->prefer_ls_education,
			 'prefer_ls_industry' => $laborSectors->prefer_ls_industry,
			 'prefer_ls_go' => $laborSectors->prefer_ls_go,
			 'prefer_ls_ngo' => $laborSectors->prefer_ls_ngo,
			 'prefer_ls_selfemployment' => $laborSectors->prefer_ls_selfemployment,
			 'prefer_lr_dependencyrelationship' => $laborRelationships->prefer_lr_dependencyrelationship,
			 'prefer_lr_contractlabor' => $laborRelationships->prefer_lr_contractlabor,
			 'prefer_lr_contractproject' => $laborRelationships->prefer_lr_contractproject,
			 'prefer_lr_contractconsulting' => $laborRelationships->prefer_lr_contractconsulting,
			 'prefer_lr_other' => $laborRelationships->prefer_lr_other,
			 'prefer_at_fulltime' => $availabilityTimes->prefer_at_fulltime,
			 'prefer_at_parttime' => $availabilityTimes->prefer_at_parttime,
			 'prefer_at_ondemand' => $availabilityTimes->prefer_at_ondemand,
			 'availability_for_travel' => $availability_for_travel,
			 'availability_move_state' => $availability_move_state,
			 'availability_move_country' => $availability_move_country,
			), 
			array(
			 'userid' => (int)$userid 
			),
			array( 
			 '%s','%s','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d','%d'
			),
			array( 
			 '%d' 
			) 
		   );
		if ($update === false)
			return $update;
/*
		//Refresh Competencies
		$update = $this->refreshLaborSectors($userid,$competencies);
		if ($update !== true)
			return $update;*/
		return true;
   }
   
   
   public function getData($id){
		global $wpdb;
		$sql = 'SELECT pro.*,u.user_login FROM '.$wpdb->prefix.'masvalor_profiles pro,'.$wpdb->prefix.'users u WHERE pro.userid='.$id.' and u.ID='.$id;
		$data = $wpdb->get_results($sql,OBJECT_K);
		foreach ($data as $aData):
			return $aData;
		endforeach;
		return null;
   }
   
   public function getTitles($id,$type){
		global $wpdb;
		$sql = 'SELECT pt.*,u.name as university_name FROM '.$wpdb->prefix.'masvalor_profiletitles pt, '.$wpdb->prefix.'masvalor_universities u WHERE pt.university=u.id AND pt.userid='.$id.' AND pt.type='.$type.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
   
   public function getTesis($id,$type){
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_profiletesis WHERE userid='.$id.' AND type='.$type.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }

   public function getDisciplines($id){
		global $wpdb;
		$sql = 'SELECT sub.id as subdisciplineid,sub.name as subdiscipline_name,dis.name as discipline_name, rusd.ppal as ppal FROM '.$wpdb->prefix.'masvalor_disciplines dis,'.$wpdb->prefix.'masvalor_subdisciplines sub,'.$wpdb->prefix.'masvalor_rel_user_subdisciplines rusd WHERE rusd.userid='.$id.' AND rusd.subdisciplineid=sub.id AND sub.id_discipline=dis.id';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
   
   public function getCompetencies($id){
		global $wpdb;
		$sql = 'SELECT competitionid FROM '.$wpdb->prefix.'masvalor_rel_user_competencies WHERE userid='.$id.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
   
   public function give_me_doctor_state($id_doctor) {
		global $wpdb;
		$sql_query = 'select actived from '.$wpdb->prefix.'masvalor_profiles where userid='.$id_doctor;
		
		return $wpdb->get_var($sql_query);
   }
   
}
?>