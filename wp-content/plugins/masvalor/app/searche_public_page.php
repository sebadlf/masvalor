<?php
require_once ('models/searche_public_model.php');
require_once ('models/masvalor_utils.php');
class searche_public_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new searche_publicModel();
		if ($task == 'save'){
			$cid = $_POST['cid'];
			$msg = $model->save($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/&cid='.$msg);
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
		if ($task == 'close'){
			$cid = $_POST['cid'];
			$msg = $model->close($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/&cid='.$msg);
			exit;
		}
		if ($task == 'reopen'){
			$cid = $_POST['cid'];
			$msg = $model->reopen($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/&cid='.$msg);
			exit;
		}
		
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche_public/');
			exit;
			
		}
				
        $this->searche_public( $request,$msg);
    }
	 	 
    function searche_public( $request,$msg) {
        
		global $current_user;
		get_currentuserinfo();
		
		$model = new searche_publicModel();

        $tpl_vars = new stdClass; // for the 'view'	
				
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		$cid = $_GET['cid'];
		$tpl_vars->data = $model->getData($cid);
		$tpl_vars->isApplicat = $model->isApplicat($cid);
		$tpl_vars->candidates = $model->getPostulants(0,$cid);
		$tpl_vars->postulates = $model->getPostulants(1,$cid);
		$tpl_vars->applicants = $model->getPostulants(2,$cid);
		$tpl_vars->can_post_and_mails = $model->can_postulate_or_received_search_mails($current_user->ID);
		global $current_user;
		get_currentuserinfo();
		
		$tpl_vars->hiredData = $model->getHiredData($tpl_vars->data->selected_profile);
        $tpl_vars->msg = $msg;
		$tpl_vars->complete = $complete;
		$tpl_vars->combos = new mv_comboUtils;
		$this->set_post_title(__('Busquedas Abiertas'));
        $this->set_post_content( $this->load_view('searche_public', $tpl_vars ) );
    }

}


?>