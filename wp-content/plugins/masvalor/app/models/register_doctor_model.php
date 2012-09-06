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
class registerDoctorModel {
    
   public function register($username,$password,$email,$userid,$name,$lastname){
		
		$errors = new WP_Error();
		global $wpdb;
		$wpdb->show_errors();
			   
		
		if ($userid == null || $userid == ''){
		
			//checks duplicated username
			if ( username_exists( $username ) ) {
				$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.' ) );
				return $errors;
			}
			
			//checks duplicated mail
			if ( email_exists( $email ) ) {
				$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
				return $errors;
			}
			
			$user_id = wp_create_user($username, $password, $email);
		}
		else{
			global $current_user;
			get_currentuserinfo();
			//checks duplicated mail
			if ( ($current_user->user_email != $email) && (email_exists( $email )) ) {
				$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
				return $errors;
			}
			
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
			//Set as doctor
			$usermeta = get_user_meta($user_id, 'wp_capabilities', true);
			$newUsermeta['doctor'] = 1;
			update_user_meta( $user_id, 'wp_capabilities', $newUsermeta, $usermeta);
			//Adds user to masvalor_profiles table
			if(($user_id == 1) || (!$this->existUserIdInProfile($user_id))) {
				return;
			}
			
			$wpdb->insert( 
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'userid' => (int)$user_id,
			 'actived' => 0, 
			 'main_contact_mail' => $email,
			 'name' => $name,
			 'lastname' => $lastname			 
			), 
			array( 
			 '%d',
			 '%d', 
			 '%s',
			 '%s',
			 '%s'			 
			) 
		   );
		}
		else{
			//Updates user to masvalor_companies table
			$wpdb->update( 
			$wpdb->prefix.'masvalor_profiles', 
			array(
			 'main_contact_mail' => $email,
			  'name' => $name,
			 'lastname' => $lastname				 
			), 
			array(
			 'userid' => (int)$user_id 
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
		return $user_id;

   }
   
   function getTerms_conditions(){
      
	global $wpdb;
		
	$sql = 'SELECT post_content FROM '.$wpdb->prefix.'posts WHERE post_name = "terminos-y-condiciones" AND post_type = "page"';
	$data = $wpdb->get_results($sql,OBJECT_K);
	foreach ($data as $aData):
		return $aData->post_content;
	endforeach;
	//var_dump($data);
	return	null;
 
   
   }
   
   function getDoctorName(){
    global $wpdb;
	global $current_user;
	get_currentuserinfo();
	$userid = $current_user->ID;
	
    $sql ='SELECT  name,lastname FROM '.$wpdb->prefix.'masvalor_profiles
	                  WHERE userid = '.$userid;  
	
	$data = $wpdb->get_results($sql);
       
    
    return $data;
   }
    
   
  function existUserIdInProfile($user_id){
    global $wpdb;
		
    $sql ='SELECT  COUNT(*) FROM '.$wpdb->prefix.'masvalor_profiles
	                  WHERE userid = '.$user_id;  
	
	$data = $wpdb->get_var($sql);
    
	if($data > 0)
		return true;
	else
		return false; 
		
   }
   

}
?>