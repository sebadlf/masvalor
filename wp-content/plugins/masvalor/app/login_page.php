<?php
require_once ('models/login_model.php');
class login_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
		if (!is_null($_GET['doctor'])){
			$usertype = 'doctor';
			}
		else
			if (!is_null($_GET['empresa']))
				$usertype = 'empresa';
			else
				if (!is_null($_GET['administrador']))
					$usertype = 'administrador';
				else
					die('Invalid page');
        array_shift( $request );
		$model = new loginModel();
        if ($task == 'login'){
			$msg = $model->login($usertype);
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/login/&'.$usertype);
				exit;
			}
		}
		if ($task == 'logout'){
			wp_logout();
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/login/&'.$usertype);
			exit;
		}
        $this->login( $request,$msg,$usertype);
       
    }
	 	 
    function login( $request,$msg,$usertype) {
        
		$model = new loginModel();

        $tpl_vars = new stdClass; // for the 'view'	
		
        $tpl_vars->msg = $msg;
		$tpl_vars->usertype = $usertype;
		$this->set_post_title('Ingreso al sistema');
        $this->set_post_content( $this->load_view('login', $tpl_vars ) );
    }

}


?>