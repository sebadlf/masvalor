<?php
/**
 * The users dashboard
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The users dashboard
 *
 * Users with Subscriber role are directed here. Link to
 * change personal details page
 *
 * @package    Tina-MVC
 * @todo       add a Wordpress action hook to direct the user here after login
 */
class report_offer_demandModel {

	function get_qty($id_subdiscipline,$name_state) {
		global $wpdb;
		$moving_check = $_POST["moving"];
		
		$moving_state = '';
		if($moving_check != null)
			$moving_state = ' and availability_move_state=1';
		
/* 		$sql = 'select u.state,count(u.userid) as doctors,sb.name as subbranch
				from (select userid,state from wp_masvalor_profiles where actived=1'.$where_state.$moving_state.') u
				join (select userid,subdisciplineid from wp_masvalor_rel_user_subdisciplines where ppal=1) ud on (u.userid=ud.userid) 
				join (select id,id_discipline from wp_masvalor_subdisciplines) d on (ud.subdisciplineid=d.id) 
				right join (select id,name from wp_masvalor_disciplines) sb on (d.id_discipline=sb.id) 
				group by u.state,sb.name
				order by u.state desc';	 */	
		$sql_offer= 'select count(*) as doc_qty from wp_masvalor_rel_user_subdisciplines rel,wp_masvalor_profiles pro where rel.subdisciplineid='.$id_subdiscipline.' and pro.state="'.$name_state.'" and rel.ppal=1 and pro.actived=1'.$moving_state;
		$sql_demand = 'select count(*) as doc_qty from wp_masvalor_rel_searchs_subdisciplines rel,wp_masvalor_companysearchs pro where rel.id_subdiscipline='.$id_subdiscipline.' and pro.state="'.$name_state.'" and pro.actived=1';
		
		$offer = $wpdb->get_var($sql_offer); 
		$demand = $wpdb->get_var($sql_demand);
		
		return $offer.'/'.$demand;
	}

/* 	function get_demand_data() {
		global $wpdb;
		$states_comb = $_POST["states_comb"];
		
		$where_state = '';
		if($states_comb != null && $states_comb != "") 
			$where_state = ' and state="'.$states_comb.'"';
		
		$sql = 'select state,count(*) as qty from wp_masvalor_companysearchs where actived=1'.$where_state.' group by state order by state';	
		$result = $wpdb->get_results($sql); 
		
		return $result;
	}
	
	function get_offer_data() {
		global $wpdb;
		$states_comb = $_POST["states_comb"];
		
		$where_state = '';
		if($states_comb != null && $states_comb != "") 
			$where_state = ' and state="'.$states_comb.'"';
			
		$sql = 'select state,count(*) as qty from wp_masvalor_profiles where actived=1'.$where_state.' group by state order by state';		
		$result = $wpdb->get_results($sql); 
		
		return $result;
	} */

	function get_qty_per_state($state) {
		global $wpdb;
		
		$sql_offer = 'select count(*) from wp_masvalor_rel_user_subdisciplines where userid in(select userid from wp_masvalor_profiles where state="'.$state.'" and actived=1) and ppal=1';
		$sql_demand = 'select count(*) from wp_masvalor_rel_searchs_subdisciplines where id_search in(select id from wp_masvalor_companysearchs where state="'.$state.'" and actived=1)';
		
		$offer = $wpdb->get_var($sql_offer);
		$demand = $wpdb->get_var($sql_demand);
		
		return $offer.'/'.$demand;
	}
	
	function get_qty_per_subdiscipline($id_subdiscipline) {
		global $wpdb;
		
		$sql_offer = 'select count(*) from wp_masvalor_rel_user_subdisciplines where subdisciplineid='.$id_subdiscipline.' and ppal=1 and userid in(select userid from wp_masvalor_profiles where actived=1)';
		$sql_demand = 'select count(*) from wp_masvalor_rel_searchs_subdisciplines where id_subdiscipline='.$id_subdiscipline.' and id_search in(select id from wp_masvalor_companysearchs where actived=1)';
		
		$offer = $wpdb->get_var($sql_offer);
		$demand = $wpdb->get_var($sql_demand);
		
		return $offer.'/'.$demand;
	}
	
	function get_all_subdisciplines() {
		global $wpdb;
		
		$sql = 'select id,name from wp_masvalor_subdisciplines';
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
	function get_all_states() {
		global $wpdb;
		
		$sql = 'select id,state from wp_masvalor_states';
		$result = $wpdb->get_results($sql);
		
		return $result;
	}
}
?>