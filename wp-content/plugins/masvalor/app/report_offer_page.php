<?php
require_once ('models/report_offer_model.php');
class report_offer_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
        $this->report_offer( $request,$msg);
    }
	 	 
/*  	function position_objects_array($buscado,$fuente) {
		for($i=0;$i<sizeof($fuente);$i++) 
			if($fuente[$i]->name == $buscado)
				return $i;	
		return -1;
	}

	function position_no_objects_array($buscado,$arreglo) {
		for($i=0;$i<sizeof($arreglo);$i++) 
			if($arreglo[$i] == $buscado)
				return $i;
		return -1;
	} */
		 
    function report_offer( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new report_offerModel();
		
		$tpl_vars = new stdClass;
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
	
/* 		$tpl_vars->loaded_states = array();
		$tpl_vars->loaded_subbranchs = array();
		$tpl_vars->branchs_with_subbranchs = $model->get_branchs_with_subbranchs();
		
		$last_branch = $tpl_vars->branchs_with_subbranchs[0]->branch_name;
		$cont = 0;
		foreach($tpl_vars->branchs_with_subbranchs as $bws) :
			if($bws->branch_name == $last_branch)
				$cont++;
			else {
				$tpl_vars->subbranchs_for_branch[] = $cont;
				$cont = 1;
			}
			$last_branch = $bws->branch_name;
		endforeach;
		$tpl_vars->subbranchs_for_branch[] = $cont;
		
		$tpl_vars->branchs_quantity = $model->get_branchs_quantity();
		
		foreach($tpl_vars->branchs_with_subbranchs as $bws) 
			if(!in_array($bws->subbranch_name,$tpl_vars->loaded_subbranchs)) 
				$tpl_vars->loaded_subbranchs[] = $bws->subbranch_name;
		
		foreach($tpl_vars->data as $data) {
			if($data->state != null) {
				$tpl_vars->prov = "";
				if($this->position_objects_array($data->state,$tpl_vars->loaded_states) == -1) {
					$tpl_vars->prov->name = $data->state;
					for($j=0;$j<sizeof($tpl_vars->loaded_subbranchs);$j++)
						if($data->subbranch == $tpl_vars->loaded_subbranchs[$j]) 
							$tpl_vars->prov->dis[$j] = $data->doctors;
					    else 
							$tpl_vars->prov->dis[$j] = 0;
					$tpl_vars->loaded_states[] = $tpl_vars->prov;
				} else { 
					$tpl_vars->prov = $tpl_vars->loaded_states[sizeof($tpl_vars->loaded_states)-1];
					$tpl_vars->prov->dis[$this->position_no_objects_array($data->subbranch,$tpl_vars->loaded_subbranchs)] = $data->doctors;
					$tpl_vars->loaded_states[sizeof($tpl_vars->loaded_states)-1] = $tpl_vars->prov;
				}
			} 
		}	 */
		
        $tpl_vars->msg = $msg;
		
		$tpl_vars->all_states_comb = $model->get_all_states_for_comb();
		$tpl_vars->all_states = $model->get_all_states();
		$tpl_vars->all_subdisciplines = $model->get_all_subdisciplines();
		$tpl_vars->states_comb = $_POST["states_comb"];
		// $tpl_vars->subdisciplines_qty = $model->get_subs_qty();
		
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
		$tpl_vars->all_datas = $all_datas;
		$tpl_vars->subs_total = $subs_total;
		
/* 		foreach($tpl_vars->loaded_subbranchs as $subbranch)
			$tpl_vars->subbranchs_quantity[] = $model->get_doctors_for_subbranch($subbranch); */
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Reporte de la oferta'));
			$this->set_post_content( $this->load_view('report_offer', $tpl_vars ) );
		}	
    }

}


?>