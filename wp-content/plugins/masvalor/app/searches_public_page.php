<?php
require_once ('models/searches_public_model.php');
class searches_public_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new searches_publicModel();
        if ($task == 'add'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/');
			exit;
		}
		if ($task == 'saveApplicat'){
			$msg = $model->saveApplicat($cid);
			if ($msg){
				$tina_mvcv_pages = get_option("tina_mvc_pages");
				$pageid = $tina_mvcv_pages['masvalor']['page_id'];
				wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/&cid='.$cid);
			exit;
		}
		
        $this->searches_public( $request,$msg);
    }
	 	 
    function searches_public( $request,$msg) {
        
		$filter_sel = $_POST['filter_sel'];
		$search = $_POST['search'];
		$date_from = $_POST['filter_date_from'];
		$date_to = $_POST['filter_date_to'];
		$search_situation = $_POST['search_situation'];
		
		$model = new searches_publicModel();
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		
		$itemsPerPage = 20;
		if (isset($_GET['limitstart']))		
			$limitStart = $_GET['limitstart'];
		else
			$limitStart = 0;
		$limitEnd = $limitStart + $itemsPerPage;
		$currpage = $limitEnd/$itemsPerPage;
        	
		$tpl_vars->datas = $model->getData($filter_sel,$search,$date_from,$date_to,$limitStart,$limitEnd);
		$tpl_vars->count = $model->getTotal($filter_sel,$search,$date_from,$date_to);
		$tpl_vars->itemsPerPage = $itemsPerPage;
		$tpl_vars->currPage = $currpage;
		
        $tpl_vars->msg = $msg;
		$this->set_post_title(__('Busquedas'));
        $this->set_post_content( $this->load_view('searches_public', $tpl_vars ) );
    }

}


?>