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
class report_offerModel {
	function get_qty($id_subdiscipline,$name_state) {
		global $wpdb;
		$moving_check = $_POST["moving"];
		
		$moving_state = '';
		if($moving_check != null)
			$moving_state = ' and pro.availability_move_state=1';
		
/* 		$sql = 'select u.state,count(u.userid) as doctors,sb.name as subbranch
				from (select userid,state from wp_masvalor_profiles where actived=1'.$where_state.$moving_state.') u
				join (select userid,subdisciplineid from wp_masvalor_rel_user_subdisciplines where ppal=1) ud on (u.userid=ud.userid) 
				join (select id,id_discipline from wp_masvalor_subdisciplines) d on (ud.subdisciplineid=d.id) 
				right join (select id,name from wp_masvalor_disciplines) sb on (d.id_discipline=sb.id) 
				group by u.state,sb.name
				order by u.state desc';	 */	
		$sql= 'select count(*) as doc_qty from wp_masvalor_rel_user_subdisciplines rel,wp_masvalor_profiles pro where rel.subdisciplineid='.$id_subdiscipline.' and pro.state="'.$name_state.'" and rel.ppal=1 and rel.userid=pro.userid and pro.actived=1'.$moving_state;
		
		$result = $wpdb->get_var($sql); 
		
		return $result;
	}
	
/* 	function get_branchs_quantity() {
		global $wpdb;
		
		$sql = 'select count(*) from wp_masvalor_branchs';
		$result = $wpdb->get_var($sql);
		
		return $result;
	} */
	
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
	
	function get_all_states_for_comb() {
		global $wpdb;
		
		$sql = 'select state from wp_masvalor_states'.$where_state;
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
	function get_qty_per_state($state) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_rel_user_subdisciplines where userid in(select userid from wp_masvalor_profiles where state="'.$state.'" and actived=1) and ppal=1';

		return $wpdb->get_var($sql_query);
	}
	
	function get_qty_per_subdiscipline($id_subdiscipline) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_rel_user_subdisciplines where subdisciplineid='.$id_subdiscipline.' and ppal=1 and userid in(select userid from wp_masvalor_profiles where actived=1)';

		return $wpdb->get_var($sql_query);
	}
	
/* 	function get_subs_qty() {
		global $wpdb;
		
		$sql = 'select count(*) from wp_masvalor_subdisciplines';
		$result = $wpdb->get_var($sql);
		
		return $result;
	}  */
	
	function get_all_subdisciplines() {
		global $wpdb;
		
		$sql = 'select id,name from wp_masvalor_subdisciplines';
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
/* 	function get_branchs_with_subbranchs() {
		global $wpdb;
		
		$sql = 'select b.name as branch_name,sb.name as subbranch_name,sb.id as subbranch_id from wp_masvalor_branchs b,wp_masvalor_subbranchs sb where b.id=sb.id_branch';
		$result = $wpdb->get_results($sql);
		
		return $result;
	} */
	
/* 	function get_doctors_for_subbranch($name) {
		global $wpdb;
		
		$sql = 'select id from wp_masvalor_subbranchs where name="'.$name.'"';
		$id_subbranch = $wpdb->get_var($sql);
		$sql = 'select count(rel.id) from wp_masvalor_rel_user_disciplines rel,wp_masvalor_disciplines d where d.id_subbranch='.$id_subbranch.' and rel.disciplineid=d.id and rel.ppal=1';
		$result = $wpdb->get_var($sql);
		
		return $result;
	} */
}
?>

