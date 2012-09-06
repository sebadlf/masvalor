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
class report_offercazModel {
	function get_qty($id_commitee,$id_zone) {
		global $wpdb;
		
/* 		$sql = 'select u.state,count(u.userid) as doctors,sb.name as subbranch
				from (select userid,state from wp_masvalor_profiles where actived=1'.$where_state.$moving_state.') u
				join (select userid,subdisciplineid from wp_masvalor_rel_user_subdisciplines where ppal=1) ud on (u.userid=ud.userid) 
				join (select id,id_discipline from wp_masvalor_subdisciplines) d on (ud.subdisciplineid=d.id) 
				right join (select id,name from wp_masvalor_disciplines) sb on (d.id_discipline=sb.id) 
				group by u.state,sb.name
				order by u.state desc';	 */	
				
		$sql= 'select count(*) as doc_qty from wp_masvalor_profile_ca_zc rel,wp_masvalor_profiles pro where rel.id_ca='.$id_commitee.' and rel.id_zc="'.$id_zone.'" and pro.actived=1 and rel.id_doctor=pro.userid';
		
		$result = $wpdb->get_var($sql); 
		
		return $result;
	}
	
/* 	function get_branchs_quantity() {
		global $wpdb;
		
		$sql = 'select count(*) from wp_masvalor_branchs';
		$result = $wpdb->get_var($sql);
		
		return $result;
	} */
	
	function get_all_zones() {
		global $wpdb;
		$zones_comb = $_POST["zones_comb"];
		
		$where_zone = '';
		if($zones_comb != null && $zones_comb != "") 
			$where_zone = ' where id="'.$zones_comb.'"';
		
		$sql = 'select id,name from wp_masvalor_zones'.$where_zone;
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
	function get_all_zones_for_comb() {
		global $wpdb;
		
		$sql = 'select id,name from wp_masvalor_zones'.$where_zone;
		$result = $wpdb->get_results($sql);
		
		return $result;
	} 
	
	function get_qty_per_state($state) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_profile_ca_zc where id_zc='.$state.' and id_doctor in(select userid from wp_masvalor_profiles where actived=1)';

		return $wpdb->get_var($sql_query);
	}
	
	function get_qty_per_subdiscipline($id_subdiscipline) {
		global $wpdb;
		
		$sql_query = 'select count(*) from wp_masvalor_profile_ca_zc where id_ca='.$id_subdiscipline.' and id_doctor in(select userid from wp_masvalor_profiles where actived=1)';

		return $wpdb->get_var($sql_query);
	}
	
/* 	function get_subs_qty() {
		global $wpdb;
		
		$sql = 'select count(*) from wp_masvalor_subdisciplines';
		$result = $wpdb->get_var($sql);
		
		return $result;
	}  */
	
	function get_all_committees() {
		global $wpdb;
		
		$sql = 'select id,name from wp_masvalor_advisory_committees';
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

