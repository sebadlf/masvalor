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

class doctorProfilePublicModel {
    
	public function accept($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
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
	}
	
	public function reject($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
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
		return __("Datos guardados con exito");
   }
   
    private function saveStep1($parameters){
		global $wpdb;
		$userid = $parameters['userid'];
		
		$imageFile  = $_FILES['identity_image_file'];
		if ((int)$imageFile['size'] <= (int)$parameters['identity_image_size'] ){
			if ($imageFile['name'] != '' && $imageFile['name'] != null){
				
				$identity_image = masvalor_doUpload($userid,$imageFile);
				}
			else 
				$identity_image = $parameters['identity_image'];
			}
		else 
			return __("Su imagen de identidad debe tener como m&aacute;ximo un tama&ntilde;o de ").$parameters['identity_image_size']." bytes";
		
		$cvFile  = $_FILES['cv_file'];
		if ($cvFile['size'] <= $parameters['cv_size'] ){
			if ($cvFile['name'] != '' && $cvFile['name'] != null)
				$cv = masvalor_doUpload($userid,$cvFile);
			else
				$cv = $parameters['cv'];
			}
		else 
			return __("Su cv debe tener como m&aacute;ximo un tama&ntilde;o de ").$parameters['cv_size']." bytes";
		$wpdb->show_errors();
		$doctor_name = $parameters['doctor_name'];
		$lastname = $parameters['lastname'];
		$birth_date = $parameters['birth_date'];
		$gender = $parameters['gender'];
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
		$marital_status = $parameters['marital_status'];
		$hobbies_sports_others = $parameters['hobbies_sports_others'];
		
		//Insert data in db
		$update = $wpdb->update( 
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'name' => $doctor_name,
			 'lastname' => $lastname,
			 'birth_date' => $birth_date,
			 'gender' => $gender,
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
			 'marital_status' => $marital_status,
			 'hobbies_sports_others' => $hobbies_sports_others,
			 'identity_image' => $identity_image,
			 'cv' => $cv
			), 
			array(
			 'userid' => (int)$userid 
			),
			array( 
			 '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'
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
				$titles[$i]['date_to'] = $aTitle[3];
				$titles[$i]['finalized'] = $aTitle[4];
				$titles[$i]['type'] = 0;
				$i++;
			endforeach;
		
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
				$titlesPos[$i]['date_to'] = $aTitle[3];
				$titlesPos[$i]['finalized'] = $aTitle[4];
				$titlesPos[$i]['type'] = 1;
				$i++;
			endforeach;

		//Manage Tesis
		$auxTesis = $parameters['tesis'];
		$tesisFiles  = $_FILES['tesisfiles'];
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
				$tesis[$i]['file'] = $aTesis[3];
				$tesis[$i]['type'] = 1;
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
		if ($disciplines == null || $disciplines == '')
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
		$update = $this->refreshDisciplines($userid,$disciplines);
		if ($update !== true)
			return $update;
		//Refresh Competencies
		$update = $this->refreshCompetencies($userid,$competencies);
		if ($update !== true)
			return $update;
		//Refresh Tesis
		$update = $this->refreshTesis($userid,1,$tesis,$tesisFiles,$tesisSize);
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
			 'from_date' => $title['date_from'],
			 'to_date' => $title['date_to'],
			 'finalized' => (int)$title['finalized']
			), 
			array( 
			 '%d','%d','%s','%d','%s','%s','%d'
			)
		   );
		   if ($insert === false)
			return $insert;
		endforeach;
		
		return true;
   }
   

   private function refreshDisciplines($userid,$disciplines){ 
		global $wpdb;
		//Delete all disciplines from user
		$sql = "
		DELETE FROM ".$wpdb->prefix."masvalor_rel_user_disciplines
		WHERE userid = ".$userid.";";
		$result = $wpdb->query($sql);
		
		if ($result === false)
			return $result;
		
		//Inserts all disciplines
		foreach ($disciplines as $discipline):
			$insert = $wpdb->insert( 
			$wpdb->prefix.'masvalor_rel_user_disciplines', 
			array(
			 'userid' => (int)$userid,
			 'disciplineid' => $discipline
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
   
   private function refreshCompetencies($userid,$competencies){ 
		global $wpdb;
		//Delete all disciplines from user
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
   private function refreshTesis($userid,$type,$tesis,$tesisFiles,$tesisSize){ 
		global $wpdb;
		
		//Uploads new Tesis
		$msg='';
		for ( $i = 0; $i<sizeof($tesisFiles['name']) ; $i++ ){
			$aTesisFile['name'] = $tesisFiles['name'][$i];
			$aTesisFile['type'] = $tesisFiles['type'][$i];
			$aTesisFile['tmp_name'] = $tesisFiles['tmp_name'][$i];
			$aTesisFile['error'] = $tesisFiles['error'][$i];
			$aTesisFile['size'] = $tesisFiles['size'][$i];
			if ( (int)$aTesisFile['size'] <= (int)$tesisSize  ){
				
				if ($aTesisFile['name'] != null && $aTesisFile['name'] != '')
					masvalor_doUpload($userid,$aTesisFile);
			}
			else
			{
				$msg .= __('Error el subir el fichero').' '.$aTesisFile['name'].__(' su tama&ntilde;o debe ser menor a ').$tesisSize.__(' bytes').'</br>';
				unset($tesis[$i]);
			}
		}
		//Delete all titles from user
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
			 'file' => $aTesis['file'],
			 'publication_date' => $aTesis['publication_date']
			), 
			array( 
			 '%d','%d','%s','%s','%s','%s'
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
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_profiles WHERE userid='.$id.';';
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
		$sql = 'SELECT d.id,d.name,d.branch FROM '.$wpdb->prefix.'masvalor_disciplines d,'.$wpdb->prefix.'masvalor_rel_user_disciplines rud WHERE rud.userid='.$id.' AND rud.disciplineid=d.id ;';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
   
   public function getCompetencies($id){
		global $wpdb;
		$sql = 'SELECT competitionid FROM '.$wpdb->prefix.'masvalor_rel_user_competencies WHERE userid='.$id.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		return $data;
   }
}
?>