<?php
require_once ('models/hello_model.php');
class hello_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
        // pop the first array element from $request ('user')...
        array_shift( $request );
		$model = new helloModel();
        if ($task == 'save'){
			$msg = $model->save();
		}
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/hello/');
			exit;
		}
        $this->hello( $request,$msg);
       
    }
	 	 
    function hello( $request,$msg) {
        
		$model = new helloModel();

        $tpl_vars = new stdClass; // for the 'view'	
		
        $tpl_vars->msg = $msg;
		$tpl_vars->data = $model->getData($_GET['cid']);
		
		$this->set_post_title('MVC Example');
        $this->set_post_content( $this->load_view('hello', $tpl_vars ) );
        
    }

}


?>