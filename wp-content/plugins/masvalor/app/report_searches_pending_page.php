<?php
require_once ('models/report_searches_pending_model.php');
class report_searches_pending_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new report_searches_pendingModel();
        if ($task == 'add'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activitie/');
			exit;
		}
		if ($task == 'delete'){
			$msg = $model->delete($cid);
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/report_searches_pending/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activitie/&cid='.$cid);
			exit;
		}
		
        $this->report_searches_pending( $request,$msg);
    }
	 	 
    function report_searches_pending( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new report_searches_pendingModel();
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		//Capturamos las variables de filtro para pasarlas al model
	
	        	
		$tpl_vars->datas = $model->getData();
		$tpl_vars->total = $model->getDataCount();		
			
        $tpl_vars->msg = $msg;
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Reporte Busquedas'));
			$this->set_post_content( $this->load_view('report_searches_pending', $tpl_vars ) );
		}
    }

}


?>