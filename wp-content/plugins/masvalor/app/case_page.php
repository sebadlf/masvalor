<?php
require_once ('models/case_model.php');
class case_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new caseModel();
		if ($task == 'save'){
			$postTitle = $_POST['post_title'];
			$post = $_POST['post'];
			$cid = $_POST['cid'];
			$msg = $model->save($cid,$postTitle,$post);			
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/cases/');
			exit;
		}
		
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/cases/');
			exit;
			
		}
				
        $this->addcase( $request,$msg);
    }
	 	 
    function addcase( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		
		$model = new caseModel();

        $tpl_vars = new stdClass; // for the 'view'	
				
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		$cid = $_GET['cid'];
		$tpl_vars->data = $model->getData($cid);
		$tpl_vars->data_publications = $model->getDataPublication($cid);
        $tpl_vars->msg = $msg;
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Agregar/Editar Caso'));
			$this->set_post_content( $this->load_view('case', $tpl_vars ) );
		}
		
    }

}


?>