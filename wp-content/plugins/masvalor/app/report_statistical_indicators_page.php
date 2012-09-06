<?php
require_once ('models/report_statistical_indicators_model.php');
class report_statistical_indicators_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
		//Chequear que sea administrador.
		
        // what action are we doing?
		$task = $_POST['task'];
		$cid = $_POST['cid'];
		$model = new report_statistical_indicatorsModel();
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
				wp_redirect(home_url().'?page_id='.$pageid.'/report_statistical_indicators/');
				exit;
			}
		}
		if ($task == 'edit'){
			$tina_mvcv_pages = get_option("tina_mvc_pages");
			$pageid = $tina_mvcv_pages['masvalor']['page_id'];
			wp_redirect(home_url().'?page_id='.$pageid.'/activitie/&cid='.$cid);
			exit;
		}
		
        $this->report_statistical_indicators( $request,$msg);
    }
	 	 
    function report_statistical_indicators( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new report_statistical_indicatorsModel();
		
		$tpl_vars = new stdClass; // for the 'view'
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
		//Capturamos las variables de filtro para pasarlas al model
		
		$filter_sel = $_POST["filter_sel"];
		$search = $_POST["search"];
		$filter_date_from = $_POST["filter_date_from"];
		$filter_date_to = $_POST["filter_date_to"];	
    
	
		$tpl_vars->datas = $model->getData($filter_date_from,$filter_date_to);
		$tpl_vars->total_search = $model->getDataCount($filter_date_from,$filter_date_to);			
		$tpl_vars->total_effectiveness = $model->getEffectivenessPild($filter_date_from,$filter_date_to,$filter_sel);
		$tpl_vars->total_insertion = $model->getInsertion($filter_date_from,$filter_date_to,$filter_sel);
		$tpl_vars->total_volumeoftheOffer = $model->getVolume_of_the_Offer($filter_date_from,$filter_date_to);
		$tpl_vars->total_demand_volume = $model->getDemand_volume($filter_date_from,$filter_date_to);
		$tpl_vars->total_federal_outreach = $model->getFederal_outreach($filter_date_from,$filter_date_to);
		$tpl_vars->total_insertion_university = $model->getIntegration_SectorUniversity($filter_date_from,$filter_date_to);
		$tpl_vars->total_insertion_industry = $model->getIntegration_SectorIndustry($filter_date_from,$filter_date_to);
		$tpl_vars->total_insertion_services = $model->getIntegration_SectorServices($filter_date_from,$filter_date_to);
		$tpl_vars->total_insertion_go = $model->getIntegration_SectorNGo($filter_date_from,$filter_date_to);
		$tpl_vars->total_insertion_ngo = $model->getIntegration_SectorNGo($filter_date_from,$filter_date_to);
	    $tpl_vars->total_states = $model->getState($filter_date_from,$filter_date_to);
		$tpl_vars->total_disciplines = $model->getDisciplines($filter_date_from,$filter_date_to);
		$tpl_vars->total_demand_response = $model->getDemand_response($filter_date_from,$filter_date_to);
	    $tpl_vars->total_demand_satisfaction = $model->getDemand_satisfaction($filter_date_from,$filter_date_to);
		$tpl_vars->total_permanence = $model->getPermanence($filter_date_from,$filter_date_to);
	
	
        $tpl_vars->msg = $msg;
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Actividades'));
			$this->set_post_content( $this->load_view('report_statistical_indicators', $tpl_vars ) );
		}	
    }

}


?>