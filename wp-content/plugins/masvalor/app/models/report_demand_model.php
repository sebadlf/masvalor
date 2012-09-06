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
class report_demandModel {
	function get_qty($id_subdiscipline,$name_state) {
		global $wpdb;
		
/* 		$sql = 'select u.state,count(u.userid) as doctors,sb.name as subbranch
				from (select userid,state from wp_masvalor_profiles where actived=1'.$where_state.$moving_state.') u
				join (select userid,subdisciplineid from wp_masvalor_rel_user_subdisciplines where ppal=1) ud on (u.userid=ud.userid) 
				join (select id,id_discipline from wp_masvalor_subdisciplines) d on (ud.subdisciplineid=d.id) 
				right join (select id,name from wp_masvalor_disciplines) sb on (d.id_discipline=sb.id) 
				group by u.state,sb.name
				order by u.state desc';	 */	
		$sql= 'select count(*) as doc_qty from wp_masvalor_rel_searchs_subdisciplines rel,wp_masvalor_companysearchs pro where rel.id_subdiscipline='.$id_subdiscipline.' and pro.state="'.$name_state.'" and pro.actived=1';
		
		$result = $wpdb->get_var($sql); 
		
		return $result;
	}
	
	function get_all_subdisciplines() {
		global $wpdb;
		
		$sql = 'select id,name from wp_masvalor_subdisciplines';
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
	function get_qty_per_state($state) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_rel_searchs_subdisciplines where id_search in(select id from wp_masvalor_companysearchs where state="'.$state.'" and actived=1)';

		return $wpdb->get_var($sql_query);
	}
	
	function get_qty_per_subdiscipline($id_subdiscipline) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_rel_searchs_subdisciplines where id_subdiscipline='.$id_subdiscipline.' and id_search in(select id from wp_masvalor_companysearchs where actived=1)';

		return $wpdb->get_var($sql_query);
	}
	
	function get_all_states() {
		global $wpdb;
		$states_comb = $_POST["states_comb"];
		
		$where_state = '';
		if($states_comb != null && $states_comb != "") 
			$where_state = ' where state="'.$states_comb.'"';
		
		$sql = 'select state from wp_masvalor_states'.$where_state;
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
}
?>