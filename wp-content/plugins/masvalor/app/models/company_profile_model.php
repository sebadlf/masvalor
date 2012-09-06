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
include_once ('wp-content/plugins/masvalor/app/includes/pdfcreator/class.ezpdf.php');
 
 require_once ('masvalor_utils.php');
class companyProfileModel {
    
   public function accept($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companies', 
					   array(
						    'actived' => 1,
							), 
					   array(
						'userid' => (int)$cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
		$this->sendNotificationActived($_POST["main_contact_mail"]);
	}
	
	public function slope($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companies', 
					   array(
						    'actived' => 0,
							), 
					   array(
						'userid' => (int)$cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	public function state_off($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$adminid = $current_user->ID;
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companies', 
					   array(
						    'actived' => 2,
							), 
					   array(
						'userid' => (int)$cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	
	public function reject($cid){
		global $wpdb;
		$wpdb->show_errors();
		global $current_user;
		get_currentuserinfo();
		$email = $parameters['main_contact_mail'];
		$texto = $_POST["rejected"];
		$this->sendNotificationGeneral($email,$texto);
		$adminid = $current_user->ID;
		$wpdb->update( 				
				       $wpdb->prefix.'masvalor_companies', 
					   array(
						    'actived' => 3,
							), 
					   array(
						'userid' => (int)$cid
					   ),
					   array( 
							'%d',
					   ),
					   array( 
						'%d' 
					   ) 
			  	 );
	}
	
	function sendNotification($email){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/general.php?date='.date("d-m-Y").'&email='.$email.'&general_text='.$text);
		
		//$texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/index.html');
				
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-type: text/html\r\n";
		//$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: ".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Notificacion Masvalor";
		mail($email,$asunto,$texto,$headers);
		
	}
	
	function sendNotificationActived($email){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/company.php?date='.date("d-m-Y").'&email='.$email);
		
		//$texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/company.html');
				
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-type: text/html\r\n";
		//$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: ".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Notificacion Masvalor";
		mail($email,$asunto,$texto,$headers);
	}
	
	function sendNotificationGeneral($email,$text){
		
		global $current_user;
		get_currentuserinfo();
		$adminemail = $current_user->user_email;
		
		$texto = file_get_contents(home_url().'/wp-content/plugins/masvalor/app/includes/mailing/general.php?date='.date("d-m-Y").'&email='.$email.'&general_text='.$text);
		
		//$texto = $this->funcionHtmlDevuelto('wp-content/plugins/masvalor/app/includes/mailing/company.html');
				
		$headers = "MIME-Version: 1.1\r\n";
		$headers = "Content-type: text/html\r\n";
		//$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "From: ".$adminemail."\r\n"; // remetente
		$headers .= "Return-Path: ".$adminemail."\r\n"; // return-path*/
		$asunto ="Notificacion Masvalor";
		mail($email,$asunto,$texto,$headers);
	}
	
   public function save($parameters){
		global $wpdb;
		$userid = $parameters['userid'];
		$email = $parameters['main_contact_mail'];
		
		global $current_user;
		get_currentuserinfo();
		
		if (checkUserType($current_user->user_login,'masvalor-admin')){
			$actived = $parameters['actived'];
				if($actived == 0)
					$this->slope($userid);
				else{
					if($actived == 1){
						$this->accept($userid);
						$this->sendNotificationActived($email);
					}
					else{
						if($actived == 2){
						    $this->state_off($userid);
						    $desactived = $parameters['desactived'];
						    $this->sendNotification($desactived,$email);
						}
						else{
							$this->reject($userid);
							$rejected = $parameters['rejected'];
							$this->sendNotification($rejected,$email);
						}   
					
					}
				}
		
		}
		
		//Check if admin change the company username or password
		if (checkUserType($current_user->user_login,'masvalor-admin')){
			$new_username = $_POST['username_admin'];
			$new_password = $_POST['password_admin'];
			
			if($new_password != '' && $new_password != null)
				$wpdb->update('wp_users',array('user_login' => $new_username,'user_pass' => md5($new_password)),array('ID' => (int)$userid),array('%s','%s'),array('%d'));
			else
				$wpdb->update('wp_users',array('user_login' => $new_username),array('ID' => (int)$userid),array('%s'),array('%d'));
		}	
		
		
		//Company data
		$company_name = $parameters['company_name'];
		$business_name = $parameters['business_name'];
		$cuit_number = $parameters['cuit_number'];
		$type_industry = 0;
		$type_services = 0; 
		$type_education = 0;
		$type_go = 0;
		$type_ngo = 0;
		$type_selfemployment = 0;
		switch($parameters['type_laborsector']){
			case 'type_industry':$type_industry = 1;break;
			case 'type_services':$type_services = 1;break;
			case 'type_education':$type_education = 1;break;
			case 'type_go':$type_go = 1;break;
			case 'type_ngo':$type_ngo = 1;break;
			case 'type_selfemployment':$type_selfemployment = 1;break;
		}
		$marks_and_products = ($parameters['marks_and_products']);
		$description = ($parameters['description']);
		$antiquity = ($parameters['antiquity']);
		$amount_branch = ($parameters['amount_branch']);
		$street_name = ($parameters['street_name']);
		$street_number = ($parameters['street_number']);
		$floor_number = ($parameters['floor_number']);
		$department_number = ( $parameters['department']);
		$country = ($parameters['country']);
		$state = ($parameters['state']);
		$city = ($parameters['city']);
		$postal_code = ($parameters['cp']);
		$main_contact_mail = ($parameters['main_contact_mail']);
		$optional_contact_mail = ($parameters['optional_contact_mail']);
		$phone_numbers = ($parameters['phone_numbers']);
		$cell_numbers = ($parameters['cell_numbers']);
		//Manager data
		$manager_name = ($parameters['manager_name']);
		$manager_job_title = ($parameters['manager_job_title']);
		$manager_identity_type = ($parameters['manager_identity_type']);
		$manager_identity_number = ($parameters['manager_identity_number']);
		$manager_mail = ($parameters['manager_mail']);
		$manager_phone_numbers = ($parameters['manager_phone_numbers']);
		//Insert data in db
		$update = $wpdb->update( 
			$wpdb->prefix.'masvalor_companies', 
			array(
			 'name' => $company_name,
			 'business_name' => $business_name, 
			 'cuit_number' => $cuit_number, 
			 'type_industry' => $type_industry, 
			 'type_services' => $type_services, 
			 'type_education' => $type_education, 
			 'type_go' => $type_go, 
			 'type_ngo' => $type_ngo, 
			 'type_selfemployment' => $type_selfemployment, 
			 'marks_and_products' => $marks_and_products, 
			 'description' => $description, 
			 'antiquity' => $antiquity,
			 'amount_branch' => $amount_branch, 
			 'street_name' => $street_name, 
			 'street_number' => $street_number, 
			 'floor_number' => $floor_number, 
			 'department_number' => $department_number, 
			 'country' => $country, 
			 'state' => $state, 
			 'city' => $city, 
			 'postal_code' => $postal_code, 
			 'main_contact_mail' => $main_contact_mail, 
			 'optional_contact_mail' => $optional_contact_mail, 
			 'phone_numbers' => $phone_numbers, 
			 'cell_numbers' => $cell_numbers,
			 'manager_name' => $manager_name, 
			 'manager_job_title' => $manager_job_title, 
			 'manager_identity_type' => $manager_identity_type, 
			 'manager_identity_number' => $manager_identity_number, 
			 'manager_mail' => $manager_mail, 
			 'manager_phone_numbers' => $manager_phone_numbers
			), 
			array(
			 'userid' => (int)$userid 
			),
			array( 
			 '%s','%s','%s','%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'
			),
			array( 
			 '%d' 
			) 
		   );
		if ($update !== false)
			return __("Datos guardados con &eacute;xito");
		return __("Hubo un error al guardar los datos");
   }
   
   public function getData($id){
		global $wpdb;
		$sql = 'SELECT c.*,u.user_login FROM '.$wpdb->prefix.'masvalor_companies c,'.$wpdb->prefix.'users u
                		WHERE u.id = '.$id.' AND userid='.$id.';';
		
		$data = $wpdb->get_results($sql,OBJECT_K);
		foreach ($data as $aData):
			return $aData;
		endforeach;
		return null;
   }

/* 	public function getPdf(){
		$pdf =& new Cezpdf('a4');
		$pdf->selectFont('fonts/courier.afm');
		$datacreator = array (
							'Title'=>'Ejemplo PDF',
							'Author'=>'unijimpe',
							'Subject'=>'Ejemplo de PDF',
							'Creator'=>'unijimpe@hotmail.com',
							'Producer'=>'http://blog.unijimpe.net'
							);
		$pdf->addInfo($datacreator);
		$pdf->ezText("<b>Ejemplo de PDF en PHP</b>\n",20);
		$pdf->ezText("Esta es una prueba de pdf\n",12);
		$pdf->ezText("\n\n\n",10);
		$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"),10);
		$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n",10);
		$pdf->ezStream();
	} */
}
?>