<?php
require_once ('models/company_profile_model.php');
require_once ('models/masvalor_utils.php');
class company_profile_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
        // pop the first array element from $request ('user')...
        array_shift( $request );
		$model = new companyProfileModel();
        if ($task == 'save'){
			$msg = $model->save($_POST);
		}
		if ($task == 'accept'){
			$cid = $_GET['cid'];
			$msg = $model->accept($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/company-profile/&cid='.$msg);
			exit;
		}
		
		if ($task == 'back'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/companies/');
			exit;
		}
		
		
		if ($task == 'reject'){
			$cid = $_GET['cid'];
			$msg = $model->reject($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/company-profile/&cid='.$msg);
			exit;
		}
        $this->companyProfile( $request,$msg);
       
    }
	 	 
    function companyProfile( $request,$msg) {
        
		$model = new companyProfileModel();
		
		global $current_user;
		get_currentuserinfo();
		$userid = $_GET['cid'];
		$isAdmin = false;
		if (is_null($userid) || $userid == ''){
			if (!checkUserType($current_user->user_login,'company'))
				die(__('Invalid Access'));
				$userid = $current_user->ID;
			}
		else
			if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
			else
				if (checkUserType($current_user->user_login,'masvalor-admin'))
					$isAdmin = true;
		
		
        $tpl_vars = new stdClass; // for the 'view'	
		$tpl_vars->combos = new mv_comboUtils;
		$tpl_vars->isAdmin = $isAdmin;
        $tpl_vars->msg = $msg;
		$tpl_vars->userid = $userid;
		$tpl_vars->data = $model->getData($userid);
		$this->set_post_title(__('Perfil Empresa'));
        $this->set_post_content( $this->load_view('company_profile', $tpl_vars ) );
        
    }

}


?>