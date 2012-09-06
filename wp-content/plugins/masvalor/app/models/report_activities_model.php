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
class report_activitiesModel {
    
   public function getData($filter_date_from,$filter_date_to){
		global $wpdb;
						
		$id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='Actividades Bitacoras' 
				"
			);
		
		$data = "";
		
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$args = array(
				'category'        => $id_category[0]->term_id,
				'orderby'         => 'post_date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish' ); 	
				
			$data = get_posts( $args ); 
			
			$cant=0;
			foreach ($data as $idu):
				   if(($idu->post_date >= $filter_date_from) && ($idu->post_date <= $filter_date_to)){	
					   $result[$cant]->id = $idu->id;
					   $result[$cant]->post_date = $idu->post_date;
					   $result[$cant]->post_content = $idu->post_content;
					   $cant++;
				   }
			endforeach;  
		
			
		}		
		
		  
		return $result;	

    }
    
	public function getDataCount($filter_date_from,$filter_date_to){
		global $wpdb;
						
		$id_category = $wpdb->get_results( 
				"
				SELECT term_id
				FROM $wpdb->terms
				WHERE name ='Actividades Bitacoras' 
				"
			);
		
		$data = "";
		
		if($filter_date_from != "" && $filter_date_to != ""){	
																	
			$args = array(
				'category'        => $id_category[0]->term_id,
				'orderby'         => 'post_date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish' ); 	
				
			$data = get_posts( $args ); 
			
			$cant=0;
			foreach ($data as $idu):
				   if(($idu->post_date >= $filter_date_from) && ($idu->post_date <= $filter_date_to)){	
					   $result[$cant]->id = $idu->id;
					   $result[$cant]->post_title = $idu->post_title;
					   $result[$cant]->post_date = $idu->post_date;
					   $cant++;
				   }
			endforeach;  
		
			
		}		
		
		  
		return $cant;	

    }
   

}
?>