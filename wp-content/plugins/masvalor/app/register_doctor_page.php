<?php
require_once ('models/register_doctor_model.php');
require_once ('models/masvalor_utils.php');
class register_doctor_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
		 
        // what action are we doing?
		$task = $_POST['task'];
        array_shift( $request );
		$model = new registerDoctorModel();
        if ($task == 'save'){
			$msg2 = null;
			$userid = $_POST['userid'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			
			$name = $_POST['doctor_name'];
			$lastname = $_POST['lastname'];
			
			global $current_user;
			get_currentuserinfo();
			$user_id = $current_user->ID;
					
			$tpl_vars = new stdClass; // for the 'view'	
			
			if($user_id != NULL OR $user_id != ""){
			    $msg = $model->register($username,$password,$email,$userid,$name,$lastname);
			}
            else{			
					if(!$this->existEmailUsername($username,$email))
						$msg = $model->register($username,$password,$email,$userid,$name,$lastname);
					else{
						$msg2 = 1; 
						$tpl_vars->msg2 = $msg2;			
							
					}
			}		
			
			//Login
			if ($msg != null && ($userid == null || $userid == '')){
				$creds = array();
				$creds['user_login'] = $username;
				$creds['user_password'] = $password;
				$creds['remember'] = false;
				$user = wp_signon( $creds, false );
				//Redirects to doctor profile
				masvalor_redirect('/doctor-profile/');
			}
		}
        $this->register( $request,$msg,$msg2);
       
    }
	 	 
    function register( $request,$msg,$msg2) {
        
		$model = new registerDoctorModel();
		
		
		global $current_user;
		get_currentuserinfo();
		$userid = $_GET['cid'];
		if (is_null($userid) || $userid == ''){
			if ($current_user->data != null && !checkUserType($current_user->user_login,'doctor'))
				die(__('Invalid Access'));
			else
				$userid = $current_user->ID;
			}
		else
			if (!checkUserType($current_user->user_login,'masvalor-admin'))
					die(__('Invalid Access'));
			else
				$current_user = get_user_by('id',$userid);
			
        $tpl_vars = new stdClass; // for the 'view'	
		
		
		$tpl_vars->term_condition = $model->getTerms_conditions();
		$tpl_vars->doctor_name = $model->getDoctorName();
        $tpl_vars->msg = $msg;
		$tpl_vars->msg2 = $msg2;
		$tpl_vars->userData = $current_user;
		$this->set_post_title(__('Registro Doctor'));
        $this->set_post_content( $this->load_view('register_doctor', $tpl_vars ) );
    }
	
	
	function existEmailUsername($username,$email){
    global $wpdb;
		
    $sql ='SELECT  COUNT(*) FROM '.$wpdb->prefix.'users
	                  WHERE user_login = "'.$username.'" OR user_email = "'.$email.'"';  
	

	$data = $wpdb->get_var($sql);
    
	if($data > 0)
		return true;
	else
		return false; 
   }
   
 
   
   

}


?>