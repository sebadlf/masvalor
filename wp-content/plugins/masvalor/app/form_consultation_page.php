<?php
require_once ('models/form_consultation_model.php');
require_once ('models/masvalor_utils.php');
class form_consultation_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		$cid = $_GET['cid'];
		$searchid = $_GET['searchid'];
		$model = new form_consultationModel();
		global $current_user;
		get_currentuserinfo();
		$searchid = $_GET['searchid'];
		$userid = $current_user->ID;
		$isAdmin = false;
		$isCompany = false;
		$isGuest = false;
		if ( checkUserType($current_user->user_login,'masvalor-admin') ){
			$complete = true;
			$isAdmin = true;
		}
		else
			if ( $searchid != '' && $searchid != null && checkUserType($current_user->user_login,'company')  && $model->isOwner($current_user->data->ID,$searchid) )
				{
				$complete = false;
				$isCompany = true;
				}
			else
				if ( ($searchid == '' || $searchid == null) && !checkUserType($current_user->user_login,'company'))
					{
					$complete = false;
					$isGuest = true;
					}
				else
					if ( ($searchid == '' || $searchid == null) && checkUserType($current_user->user_login,'company'))  
						{
						$isCompany = true;
						$complete = false;
						}
					else
						die(__('Invalid Access'));
		
		
        // what action are we doing?
		$task = $_POST['task'];
				
		if ($task == 'save'){
			$msg = $model->save($cid);
           	if($msg == null)
 			   $msg=$cid;
			if (isset($_GET['searchid']))
				masvalor_redirect('/form_consultation/&cid='.$msg.'&searchid='.$searchid);
			else
				masvalor_redirect('/form_consultation/&cid='.$msg);
		}
		
		if ($task == 'notificationCompany'){
			$cid = $_POST['cid'];
			$msg = $model->notificationCompany($cid,$userid);
           	$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/form_consultation/&cid='.$cid);
			exit;
		}
		
		
		if ($task == 'cancel'){
			masvalor_redirect('/form_consultations/');
		}
				
        $this->form_consultation( $request,$msg,$searchid,$complete,$userid,$isAdmin,$isCompany,$isGuest);
    }
	 	 
    function form_consultation( $request,$msg,$searchid,$complete,$userid,$isAdmin,$isCompany,$isGuest) {
        global $current_user;
		get_currentuserinfo();
		$model = new form_consultationModel();

        $tpl_vars = new stdClass; // for the 'view'	
				
		$cid = $_GET['cid'];
		if ($cid != null && $cid != '')
			if (!checkUserType($current_user->user_login,'masvalor-admin'))
					die(__('Invalid Access'));
		
		if ($searchid != null && $searchid != '')
			$tpl_vars->searchData = $model->getSearchData($searchid);
		$tpl_vars->data = $model->getData($cid);
		$tpl_vars->disciplines = $model->getDisciplines($tpl_vars->data->diciplines_and_skills);
        $tpl_vars->msg = $msg;
		$tpl_vars->combos = new mv_comboUtils;
		$tpl_vars->searchid = $_GET['searchid'];
		$tpl_vars->checkbox = new mv_checkboxUtils;
		$tpl_vars->complete = $complete;
		$tpl_vars->userid = $userid;
		$tpl_vars->isAdmin = $isAdmin;
		$tpl_vars->isCompany = $isCompany;
		$tpl_vars->isGuest = $isGuest;
		$this->set_post_title(__('Alta Consulta'));
        $this->set_post_content( $this->load_view('form_consultation', $tpl_vars ) );
    }

}


?>