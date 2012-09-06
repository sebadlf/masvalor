<?php
require_once ('models/searche_model.php');
require_once ('models/masvalor_utils.php');
class searche_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new searcheModel();
		if ($task == 'save'){
			$cid = $_POST['cid'];
			$msg = $model->save($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg.'&showResult=1');
			exit;
		}
		if ($task == 'accept'){
			$cid = $_POST['cid'];
			$msg = $model->accept($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;
		}
		
		if ($task == 'notificationDoctors'){
			$cid = $_POST['cid'];
			$msg = $model->notificationDoctors($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;
		}
		
		if ($task == 'back'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searches/');
			exit;
		}
		
		if ($task == 'close'){
			$cid = $_POST['cid'];
			$msg = $model->close($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;
		}
		if ($task == 'reopen'){
			$cid = $_POST['cid'];
			$msg = $model->reopen($cid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;
		}
		
		if ($task == 'selecthired'){
			$cid = $_POST['cid'];
			$hiredid = $_POST['hiredid'];
			$model->selectHired($cid,$hiredid);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			/*wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;*/
		}
		
		if ($task == 'transform'){
			$cid = $_POST['cid'];
			$transformList = $_POST['companyapplicants'];
			$model->transform($cid,$transformList);
           	if($msg == null)
 			   $msg=$cid;
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			/*wp_redirect(home_url().'?page_id='.$pageid.'/searche/&cid='.$msg);
			exit;*/
		}
		
		
		if ($task == 'cancel'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/searches/');
			exit;
			
		}
				
        $this->searche( $request,$msg);
    }
	 	 
    function searche( $request,$msg) {
        
		$model = new searcheModel();

        $tpl_vars = new stdClass; // for the 'view'	
				
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		$cid = $_GET['cid'];
		$tpl_vars->data = $model->getData($cid);
		$tpl_vars->candidates = $model->getPostulants(0,$cid);
		$tpl_vars->postulates = $model->getPostulants(1,$cid);
		$tpl_vars->applicants = $model->getPostulants(2,$cid);
		$tpl_vars->disciplines = $model->getDisciplines($cid);
		global $current_user;
		get_currentuserinfo();
		$tpl_vars->dataCompany = $model->getDataCompany($current_user->ID);
		$tpl_vars->current_user = $current_user;
		//Empresa editando
		if ($cid != '' && $cid != null && checkUserType($current_user->user_login,'company')  && $model->isOwner($current_user->data->ID,$cid) )
				$complete = false;
		else
			//Empresa creando nueva busqueda
			if ( $cid == '' || $cid == null && checkUserType($current_user->user_login,'company')){
				$complete = false;
				}
			else
				//Administrador editando busqueda
				if ($cid != '' && $cid != null && checkUserType($current_user->user_login,'masvalor-admin') )
					$complete = true;
				else
					die(__('Invalid Access'));
		$tpl_vars->hiredData = $model->getHiredData($tpl_vars->data->selected_profile);
        $tpl_vars->msg = $msg;
		$tpl_vars->complete = $complete;
		$tpl_vars->combos = new mv_comboUtils;
		$this->set_post_title(__('Edicion Busqueda'));
        $this->set_post_content( $this->load_view('searche', $tpl_vars ) );
    }

}


?>