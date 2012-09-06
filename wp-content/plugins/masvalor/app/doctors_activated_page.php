<?php
require_once ('models/doctors_activated_model.php');
class doctors_activated_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        //what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new doctors_activatedModel();
        if ($task == 'add'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor/');
			exit;
		}
		if ($task == 'activadDoctors'){
			$msg = $model->activadDoctors();
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/doctors_activated/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/doctor/&cid='.$cid);
			exit;
		}
		
        $this->doctors_activated( $request,$msg);
    }
	 	 
    function doctors_activated( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		
		$filter_sel = $_POST['filter_sel'];
		$search = $_POST['search'];
		
		$model = new doctors_activatedModel();
		
		
		$itemsPerPage = 20;
		if (isset($_GET['limitstart']))		
			$limitStart = $_GET['limitstart'];
		else
			$limitStart = 0;
		$limitEnd = $limitStart + $itemsPerPage;
		$currpage = $limitEnd/$itemsPerPage;
		
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
			
		$tpl_vars->datas = $model->getData($filter_sel,$search,$limitStart,$itemsPerPage);
        $tpl_vars->count = $model->getTotal($filter_sel,$search);
		$tpl_vars->itemsPerPage = $itemsPerPage;
		$tpl_vars->currPage = $currpage;
		$tpl_vars->msg = $msg;
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{			
			$this->set_post_title(__('Doctores'));
			$this->set_post_content( $this->load_view('doctors_activated', $tpl_vars ) );
		}
		
    }

}


?>