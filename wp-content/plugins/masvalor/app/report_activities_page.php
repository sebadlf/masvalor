<?php
require_once ('models/report_activities_model.php');
class report_activities_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new report_activitiesModel();
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
				wp_redirect(home_url().'?page_id='.$pageid.'/report_activities/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activitie/&cid='.$cid);
			exit;
		}
		
        $this->report_activities( $request,$msg);
    }
	 	 
    function report_activities( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new report_activitiesModel();
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		//Capturamos las variables de filtro para pasarlas al model
		
		$filter_sel = $_POST["filter_sel"];
		$search = $_POST["search"];
		$filter_date_from = $_POST["filter_date_from"];
		$filter_date_to = $_POST["filter_date_to"];	
        	
		$tpl_vars->datas = $model->getData($filter_date_from,$filter_date_to);
		$tpl_vars->total = $model->getDataCount($filter_date_from,$filter_date_to);		
		
        $tpl_vars->msg = $msg;
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Actividades'));
			$this->set_post_content( $this->load_view('report_activities', $tpl_vars ) );
		}	
    }

}


?>