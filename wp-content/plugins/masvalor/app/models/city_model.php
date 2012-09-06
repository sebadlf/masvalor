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
class cityModel {
    
   public function getData($cid){	
		 global $wpdb;
		
		if ($cid == null or $cid == "" )
		   $row = null;
		else{
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_cities WHERE id='.$cid.'';
			$data = $wpdb->get_results($sql);
			
			foreach ($data as $aData):
				return $aData;
			endforeach;
			return null;	
		}
		
		return	$row;

   }
   
   
   public function save($cid,$name,$country,$state){
		 		   
		    global $wpdb;
		  		  
	        global $user_ID;
	        
									
			if ($cid == null or $cid == "" ){
			
			  $wpdb->insert( 
				$wpdb->prefix.'masvalor_cities', 
					array(
					    'country' => $country,
						'state' => $state,
						'city' => $name						
						), 
					array( 
						'%s',
						'%s',
                        '%s' 						
					) 
				);
    				
			}
            else{
			
			 
			 $wpdb->update( 
						$wpdb->prefix.'masvalor_cities', 
						array(
						'country' => $country,
						'state' => $state,
						'city' => $name							
						), 
						array(
							'id' => $cid
							),
						array( 
						   '%s',
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