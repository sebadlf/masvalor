<?php
require_once ('models/lost_password_model.php');
class lost_password_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
        array_shift( $request );
		$model = new lost_passwordModel();
        if ($task == 'lost_password'){
			$msg = $model->lost_password($usertype);
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/lost_password/&'.$usertype);
				exit;
			}
		}
		if ($task == 'logout'){
			wp_logout();
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/lost_password/&'.$usertype);
			exit;
		}
        $this->lost_password( $request,$msg,$usertype);
       
    }
	 	 
    function lost_password( $request,$msg,$usertype) {
        
		$model = new lost_passwordModel();

        $tpl_vars = new stdClass; // for the 'view'	
		
        $tpl_vars->msg = $msg;
		$tpl_vars->usertype = $usertype;
		$this->set_post_title('Ingreso al sistema');
        $this->set_post_content( $this->load_view('lost_password', $tpl_vars ) );
    }

}


?>