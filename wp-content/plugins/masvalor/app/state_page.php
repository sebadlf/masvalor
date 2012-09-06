<?php
require_once ('models/state_model.php');
class state_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new stateModel();
		if ($task == 'save'){
			$post = $_POST['post'];
			$cid = $_POST['cid'];
			$name = $_POST['name'];
			$country = $_POST['country'];
			$msg = $model->save($cid,$name,$country);			
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/states/');
			exit;
		}
		
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/states/');
			exit;
			
		}
				
        $this->addstate( $request,$msg);
    }
	 	 
    function addstate( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new stateModel();

        $tpl_vars = new stdClass; // for the 'view'	
		
        $tpl_vars->combos = new mv_comboUtils;		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		$cid = $_GET['cid'];
		$tpl_vars->data = $model->getData($cid);
        $tpl_vars->msg = $msg;
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{	
			$this->set_post_title(__('Agregar/Editar Paises'));
			$this->set_post_content( $this->load_view('state', $tpl_vars ) );
		}
		
    }

}


?>