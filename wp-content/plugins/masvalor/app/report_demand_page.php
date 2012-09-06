<?php
require_once ('models/report_demand_model.php');
class report_demand_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
        $this->report_demand( $request,$msg);
    }
		 
    function report_demand( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new report_demandModel();
		
		$tpl_vars = new stdClass;
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
	
		$tpl_vars->all_subdisciplines = $model->get_all_subdisciplines();
		
		$tpl_vars->all_states = $model->get_all_states();
		$tpl_vars->states_comb = $_POST["states_comb"];
		
		$i = 0;
		$all_datas = array();
		$subs_total = array();
		foreach($tpl_vars->all_states as $state) {
			foreach($tpl_vars->all_subdisciplines as $sub) {
				$all_datas[$i]->qty = $model->get_qty($sub->id,$state->state);
				$all_datas[$i]->state = $state->state;
				$i++;
			}
			if($tpl_vars->states_comb == '') {
				$all_datas[$i]->qty = $model->get_qty_per_state($state->state);
				$all_datas[$i]->state = $all_datas[$i-1]->state;
				$all_datas[$i]->is_end = true;
				$i++;
			}
		}
		
		if($tpl_vars->states_comb == '') {
			$sub_total = 0;
			foreach($tpl_vars->all_subdisciplines as $sub) {
				$subs_total[] = $model->get_qty_per_subdiscipline($sub->id);
				$sub_total = $sub_total+$model->get_qty_per_subdiscipline($sub->id);
			}
		}
	
		$tpl_vars->sub_total = $sub_total;
		$tpl_vars->subs_total = $subs_total;
		$tpl_vars->all_datas = $all_datas;
		
        $tpl_vars->msg = $msg;
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Reporte de la demanda'));
			$this->set_post_content( $this->load_view('report_demand', $tpl_vars ) );
		}	
    }

}


?>