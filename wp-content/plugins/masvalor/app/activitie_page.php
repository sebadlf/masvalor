<?php
require_once ('models/activitie_model.php');
class activitie_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new activitieModel();
		if ($task == 'save'){
			$postTitle = $_POST['post_title'];
			$post = $_POST['post'];
			$cid = $_POST['cid'];
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$msg = $model->save($cid,$postTitle,$post,$start_date,$end_date);			
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activities/');
			exit;
		}
		
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activities/');
			exit;
			
		}
				
        $this->activitie( $request,$msg);
    }
	 	 
    function activitie( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new activitieModel();

        $tpl_vars = new stdClass; // for the 'view'	
				
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		$cid = $_GET['cid'];
		$tpl_vars->data = $model->getData($cid);
		$tpl_vars->dates = $model->getDataDates($cid);
			
        $tpl_vars->msg = $msg;
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Agregar/Editar Actividad'));
			$this->set_post_content( $this->load_view('activitie', $tpl_vars ) );
		}	
    }

}


?>