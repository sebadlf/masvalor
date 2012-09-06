<?php
require_once ('models/consultations_model.php');
class consultations_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new consultationsModel();
        if ($task == 'add'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/faq/');
			exit;
		}
		if ($task == 'delete'){
			$msg = $model->delete($cid);
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/consultations/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/faq/&cid='.$cid);
			exit;
		}
		
        $this->consultations( $request,$msg);
    }
	 	 
    function consultations( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		
		$model = new consultationsModel();
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
			
        	
		$tpl_vars->datas = $model->getData();
        $tpl_vars->msg = $msg;
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Consultas'));
			$this->set_post_content( $this->load_view('consultations', $tpl_vars ) );
		}
		
    }

}


?>