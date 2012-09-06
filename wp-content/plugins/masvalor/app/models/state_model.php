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
class stateModel {
    
   public function getData($cid){	
		 global $wpdb;
		
		if ($cid == null or $cid == "" )
		   $row = null;
		else{
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_states WHERE id='.$cid.'';
			$data = $wpdb->get_results($sql);
			
			foreach ($data as $aData):
				return $aData;
			endforeach;
			return null;	
		}
		
		return	$row;

   }
   
   
   public function save($cid,$name,$country){
		 		   
		    global $wpdb;
		  		  
	        global $user_ID;
	        
									
			if ($cid == null or $cid == "" ){
			
			  $wpdb->insert( 
				$wpdb->prefix.'masvalor_states', 
					array(
					    'country' => $country,
						'state' => $name						
						), 
					array( 
						'%s',
						'%s'						
					) 
				);
    				
			}
            else{
			
			 
			 $wpdb->update( 
						$wpdb->prefix.'masvalor_states', 
						array(
						'country' => $country,
						'state' => $name							
						), 
						array(
							'id' => $cid
							),
						array( 
						   '%s',
						   '%s'						   
					    ),
						array( 
						 	'%d' 
						)
					); 	 	
			      
			}
			
			 
			
	 
	}
	
	
 		
}
?>