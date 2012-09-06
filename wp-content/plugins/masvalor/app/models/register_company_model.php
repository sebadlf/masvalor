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
class registerCompanyModel {
    
   public function register($username,$password,$email,$userid){
		$errors = new WP_Error();
		global $wpdb;
		if ($userid == null || $userid == ''){
		
			//checks duplicated username
			if ( username_exists( $username ) )
				$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.' ) );
			
			//checks duplicated mail
			if ( email_exists( $email ) )
				$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
			$user_id = wp_create_user($username, $password, $email);
		}
		else{
			if ($password == '' || $password == null )
				$password = get_user_by('login', $username)->data->user_pass;
			
			$userData = array ('ID' => (int)$userid, 
			   'user_pass' => $password,
			   'user_email' => $email);
			$user_id = wp_update_user($userData);
		}
		
		if ( ! $user_id ||  $user_id==null || $user_id=='') {
			$errors->add( 'registerfail',  __( '<strong>ERROR</strong>: Registration fails.' ) );
			return $errors;
		}
		if ($userid == null || $userid == ''){
			//Set as company
			$usermeta = get_user_meta($user_id, 'wp_capabilities', true);
			$newUsermeta['company'] = 1;
			update_user_meta( $user_id, 'wp_capabilities', $newUsermeta, $usermeta);
			//Adds user to masvalor_companies table
			$wpdb->insert( 
			$wpdb->prefix.'masvalor_companies', 
			array(
			 'userid' => (int)$user_id,
			 'actived' => 0, 
			 'main_contact_mail' => $email 
			), 
			array( 
			 '%d',
			 '%d', 
			 '%s' 
			) 
		   );
		}
		else{
			//Updates user to masvalor_companies table
			$wpdb->update( 
			$wpdb->prefix.'masvalor_companies', 
			array(
			 'main_contact_mail' => $email 
			), 
			array(
			 'userid' => (int)$user_id 
			),
			array( 
			 '%s' 
			),
			array( 
			 '%d' 
			) 
		   );
		}

		return $user_id;

   }
   
   function getTerms_conditions(){
      
	global $wpdb;
																	
	$sql = 'SELECT post_content FROM '.$wpdb->prefix.'posts WHERE post_name = "terminos-y-condiciones" AND post_type = "page"';
	$data = $wpdb->get_results($sql,OBJECT_K);
	foreach ($data as $aData):
		return $aData->post_content;
	endforeach;
	
	return	null;

   }

}
?>