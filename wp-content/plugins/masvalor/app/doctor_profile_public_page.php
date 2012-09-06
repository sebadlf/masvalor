<?php
require_once ('models/doctor_profile_public_model.php');
require_once ('models/masvalor_utils.php');
class doctor_profile_public_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
		
        // pop the first array element from $request ('user')...
        array_shift( $request );
		$model = new doctorProfilePublicModel();
        if ($task == 'save'){
			$step = $_POST['step'];
			$msg = $model->save($step,$_POST);
		}
		if ($task == 'accept'){
			$cid = $_GET['cid'];
			$msg = $model->accept($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor-profile-public/&cid='.$msg);
			exit;
		}
		if ($task == 'reject'){
			$cid = $_GET['cid'];
			$msg = $model->reject($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor-profile-public/&cid='.$msg);
			exit;
		}
        $this->doctorProfile( $request,$msg);
       
    }
	 	 
    function doctorProfile( $request,$msg) {
        
		$model = new doctorProfilePublicModel();
		global $current_user;
		get_currentuserinfo();
		$userid = $_GET['cid'];
		$isCompany = false;
		$isAdmin = false;
		/*
		if (is_null($userid) || $userid == ''){
			if (!checkUserType($current_user->user_login,'doctor'))
				die(__('Invalid Access'));
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
		*/			
							
			
	
	
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
		$tpl_vars->titlesPos = $model->getTitles($userid,1);
		$tpl_vars->tesisPos = $model->getTesis($userid,1);
		$tpl_vars->disciplines = $model->getDisciplines($userid);
		$tpl_vars->competencies = $model->getCompetencies($userid);
		
		$userinfo = get_user_by('id', $userid);
		$tpl_vars->username = $userinfo->data->user_login;
		$this->set_post_title(__('Doctor Profile Public'));
        $this->set_post_content( $this->load_view('doctor_profile_public', $tpl_vars ) );
        
    }

}


?>