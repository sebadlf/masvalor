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
 require_once('masvalor_utils.php');
class lost_passwordModel {
    
   public function lost_password($usertype){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (checkUserType($username,$usertype)){
			$creds = array();
			$creds['user_login'] = $username;
			$creds['user_password'] = $password;
			$creds['remember'] = true;
			$user = wp_signon( $creds, false );
			return  true;
		}
		else
			return "Usted no es un: ".strtoupper($usertype);
   }

   

}
?>