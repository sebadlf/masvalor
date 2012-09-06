<?php
require_once ('models/doctor_profile_model.php');
require_once ('models/masvalor_utils.php');
class doctor_profile_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
				
        global $current_user;
		get_currentuserinfo();
		$userid = $_GET['cid'];
		if($userid == '' OR $userid == NULL) 
			$userid = $current_user->ID;
		
  		// pop the first array element from $request ('user')...
        array_shift( $request );
		$model = new doctorProfileModel();
        if ($task == 'save'){
		    
			$exit = $this->existDniCuit($_POST['identity_number'],$_POST['cuit'],$userid);
 		    if(!$exit){
				$step = $_POST['step'];
				$msg = $model->save($step,$_POST);
			}
			else{
			    $msg = "El número de dni o el cuit ya existen";
			}
			
			//$step = $_POST['step'];
			//$msg = $model->save($step,$_POST);
			
		}
		
		if ($task == 'back'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctors/');
			exit;
		}
		
		
		if ($task == 'accept'){
			$cid = $_GET['cid'];
			$msg = $model->accept($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor-profile/&cid='.$msg);
			exit;
		}
		if ($task == 'reject'){
			$cid = $_GET['cid'];
			$msg = $model->reject($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor-profile/&cid='.$msg);
			exit;
		}
        $this->doctorProfile( $request,$msg);
    }
	 	 
    function doctorProfile( $request,$msg) {
        
		$model = new doctorProfileModel();
		global $current_user;
		get_currentuserinfo();
		$userid = $_GET['cid'];
		$isCompany = false;
		$isAdmin = false;
		if (is_null($userid) || $userid == ''){
			if (!checkUserType($current_user->user_login,'doctor')){
			   if (!checkUserType($current_user->user_login,'masvalor-admin'))
					die(__('Invalid Access'));
			   else	
				$userid = $current_user->ID;
			}	
			else
				$userid = $current_user->ID;
			}
		else
			if ( checkUserType($current_user->user_login,'company') && masvalor_companyCanViewUser($current_user->ID,$userid) )
				$isCompany = true;
			else
				if (checkUserType($current_user->user_login,'masvalor-admin'))
					$isAdmin = true;
				else
					die(__('Invalid Access'));
	
        $tpl_vars = new stdClass; // for the 'view'	
		$tpl_vars->combos = new mv_comboUtils;
		$tpl_vars->checkbox = new mv_checkboxUtils;
        $tpl_vars->msg = $msg;
		$tpl_vars->userid = $userid;
		$tpl_vars->isCompany = $isCompany;
		$tpl_vars->isAdmin = $isAdmin;
		$tpl_vars->identity_image_size = masvalor_getParameter('identity_image_size');
		$tpl_vars->cv_size = masvalor_getParameter('cv_size');
		$tpl_vars->tesis_size = masvalor_getParameter('tesis_size');
		$tpl_vars->step = $_POST['step'];
		$tpl_vars->data = $model->getData($userid);
		$tpl_vars->titles = $model->getTitles($userid,0);
		
		foreach($tpl_vars->titles as $title) {
			$date_array = explode("-",$title->from_date);
			$title->from_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
			$date_array = explode("-",$title->to_date);
			$title->to_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
		}	
		
		$tpl_vars->titlesPos = $model->getTitles($userid,1);
		
		foreach($tpl_vars->titlesPos as $title) {
			$date_array = explode("-",$title->from_date);
			$title->from_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
			$date_array = explode("-",$title->to_date);
			$title->to_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
		}	
		
		$tpl_vars->tesisPos = $model->getTesis($userid,1); 
		
		foreach($tpl_vars->tesisPos as $title) {
			$date_array = explode("-",$title->publication_date);
			$title->publication_date = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
		}	
		
		$tpl_vars->disciplines = $model->getDisciplines($userid);
		$tpl_vars->competencies = $model->getCompetencies($userid);
		$tpl_vars->comisions = $model->give_me_all_comisions();
		$tpl_vars->zones = $model->give_me_all_zones();
		
		$tpl_vars->comisionsSaved = $model->getComisionSaved($userid);
		$tpl_vars->zonesSaved = $model->getZoneSaved($userid);
		
		
		foreach($tpl_vars->tesisPos as $tesis)
			$tesis->name_subdiscipline = $model->getDisciplineNameById($tesis->id_subdiscipline);
		
		$userinfo = get_user_by('id', $userid);
		$tpl_vars->username = $userinfo->data->user_login;
		$tpl_vars->doctor_state = $model->give_me_doctor_state($userid);
		$this->set_post_title(__('Perfil del doctor'));
        $this->set_post_content( $this->load_view('doctor_profile', $tpl_vars ) );
    }
	
	function existDniCuit($dni,$cuit,$userid){
    global $wpdb;
		
    $sql ='SELECT  COUNT(*) FROM '.$wpdb->prefix.'masvalor_profiles
	                  WHERE (identity_number = "'.$dni.'" OR cuit = "'.$cuit.'") AND 
					         userid != '.$userid;  
	
	$data = $wpdb->get_var($sql);
    
	if($data > 0)
		return true;
	else
		return false; 
		
   }
   

}


?>