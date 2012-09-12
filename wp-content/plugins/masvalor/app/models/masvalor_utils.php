<?php

//Redirects users

function masvalor_location_redirect() {
	global $user;
	if ($user->data != null && checkUserType($user->user_login,'doctor')){
		$location =  home_url();
		wp_safe_redirect($location);
		exit();
		}
	if ($user->data != null && checkUserType($user->user_login,'company')){
		$location = home_url();
		wp_safe_redirect($location);
		exit();
		}
	if ($user->data != null && checkUserType($user->user_login,'masvalor-admin')){
		$location =  home_url();
		wp_safe_redirect($location);
		exit();
		}
	if ($user->data == null)
		masvalor_redirect('/lost-password/');
	else {
		$location =  home_url();
		wp_safe_redirect($location);
		exit();
	}
}

add_filter('login_redirect', 'masvalor_location_redirect', 10, 3);


$mv_username = null;

//Overrides the default upload folder
 function my_upload_dir($upload) {
	  global $mv_username;
	  $upload['subdir'] = '/profiles/' .  $mv_username;
	  $upload['path']   = $upload['basedir'] . $upload['subdir'];
	  $upload['url']    = $upload['baseurl'] . $upload['subdir'];
	  return $upload;
	}

function masvalor_doUpload($userid,$file){
	//Manage Uploads
	$userinfo = get_user_by('id', $userid);
	global $mv_username;
	$mv_username = $userinfo->data->user_login;
	require_once('wp-admin/includes/file.php');
	add_filter('upload_dir', 'my_upload_dir');
	// Hizo el guardado del temporal al destino final
	$upload = wp_handle_upload($file, array('test_form' => false));
	
    $name_arch = $upload['file'];
	if (!file_exists($name_arch)) {	
		// Error: el archivo temporal no fue guardado exitosamente.
		$text = __('Error: el archivo temporal no fue guardado exitosamente.');
		return $text;
	} 

	// Chequear existencia del index.html
	$upload['subdir'] = ABSPATH.'/wp-content/uploads/profiles/'.$mv_username;
	$index_file = $upload['subdir'].'/index.html';
	if (!file_exists($index_file)) {	
		// Creo index.html
		$ar = fopen($index_file,"a") or die("Problemas en la creacion de archivo index.html.");
	}
	
	remove_filter('upload_dir', 'my_upload_dir');
	$aux = explode("/",$upload['url']);
	$uploaded_name = $aux[sizeof($aux)-1];
	return $uploaded_name;
	//return "";
}


//Add a postulant
function masvalor_addPostulant($searchid,$postulants,$whoadd,$deleteold) {
	if (checkUserTypeById($whoadd,'masvalor-admin'))
		$type = 0;
	if (checkUserTypeById($whoadd,'company'))	
		$type = 1;
	if (checkUserTypeById($whoadd,'doctor'))	
		$type = 2;
	global $wpdb;
	$count = 0;
	$postulantsArray = explode(',',$postulants);
	if ($postulantsArray[0] != '' ){
		if ($deleteold == 'true'){
			//Deletes old postulations
			if ($type == 0 || $type == 1){
				foreach ($postulantsArray as $userid):
					$sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_searchresults WHERE type ='.$type.' AND searchid='.$searchid.' AND userid='.$userid.';';
					$wpdb->query($sql);
				endforeach;
			}
			//Insert postulations
			foreach ($postulantsArray as $userid):
				$sql = 'INSERT INTO '.$wpdb->prefix.'masvalor_searchresults (userid,searchid,type,date,whoadd)  VALUES('.$userid.','.$searchid.','.$type.',"'.date('Y-m-d').'",'.$whoadd.');';
				$result = $wpdb->query($sql);
				$count++;
			endforeach;
		}
		else {
			foreach ($postulantsArray as $userid):
				//Chequeo que no sea ya no sea candidato del tipo
				$sql = 'SELECT userid FROM '.$wpdb->prefix.'masvalor_searchresults WHERE type ='.$type.' AND searchid='.$searchid.' AND userid='.$userid.';';
				$data = $wpdb->get_results($sql,OBJECT_K);
				//Si se cumple, lo agrego como candidato del tipo
				if (sizeof($data) === 0){
					$result = $wpdb->insert( 				
						   $wpdb->prefix.'masvalor_searchresults', 
						   array(
								'type' => (int)$type,
								'searchid' => (int)$searchid, 		
								'userid' => (int)$userid,
								'whoadd' => (int)$whoadd,
								'date' => date('Y-m-d')
								),
						   array( 
								'%d',
								'%d',
								'%d',
								'%d',
								'%s'
						   )
					 );	
					$count++;
				}
			endforeach;
		}
			
	}
	//if ($result > 0)
		return __('Se establecieron').' '.$count.' '.__('Nuevos candidatos');
	/*else
		return __('Hubo un error al intentar agregar los candidatos');*/
}


//Add a postulant
function masvalor_removePostulant($searchid,$postulantid,$type) {
	global $wpdb;
	$sql = 'DELETE FROM '.$wpdb->prefix.'masvalor_searchresults WHERE type ='.$type.' AND searchid='.$searchid.' AND userid='.$postulantid.';';
	$wpdb->query($sql);
	echo $sql;
}

function masvalor_StateCompany(){
    global $current_user;
	get_currentuserinfo();
		
    global $wpdb;
    
	$sql = 'SELECT actived FROM '.$wpdb->prefix.'masvalor_companies WHERE userid = '.$current_user->id;
	$datas = $wpdb->get_results($sql,OBJECT_K);
	$active = 0;
	
	foreach ($datas as $data):
		$active = (int)$data->actived;
	endforeach;
	
	return $active;
}

function masvalor_StateCompanyAdmin($userid){
    global $wpdb;
    
	$sql = 'SELECT actived FROM '.$wpdb->prefix.'masvalor_companies WHERE userid = '.$userid;
	$datas = $wpdb->get_results($sql,OBJECT_K);
	$active = 0;
	
	foreach ($datas as $data):
		$active = (int)$data->actived;
	endforeach;
	
	return $active;
}





//Checks user type
function checkUserType($username,$usertype){
		$userinfo = get_user_by('login', $username);
		$usermeta = get_user_meta($userinfo->ID, 'wp_capabilities', true);
		if ($usermeta[$usertype] == 1)
			return true;
		else
			return false;
   }

//Checks user type
function checkUserTypeById($userid,$usertype){
		$usermeta = get_user_meta($userid, 'wp_capabilities', true);
		if ($usermeta[$usertype] == 1)
			return true;
		else
			return false;
   }

//Checks if a company have the user assigned as applicant or candidate
function masvalor_companyCanViewUser($companyid,$userid){
	global $wpdb;
	$sql = 'SELECT COUNT(sr.id) as count FROM '.$wpdb->prefix.'masvalor_searchresults sr,'.$wpdb->prefix.'masvalor_companysearchs cs WHERE sr.searchid = cs.id AND cs.userid ='.$companyid.' AND sr.userid='.$userid.' AND ( type = 0 or type = 1 );';
	$datas = $wpdb->get_results($sql,OBJECT_K);
	$count = 0;
	foreach ($datas as $data):
		$count = (int)$data->count;
	endforeach;
	if ($count > 0)
		return true;
	else
		return false;
}
   
//Returns a system parameter value
function masvalor_getParameter($parameter){
		global $wpdb;
		$sql = 'SELECT parameter_value FROM '.$wpdb->prefix.'masvalor_systemparameters WHERE parameter_name="'.$parameter.'";';
		$datas = $wpdb->get_results($sql,OBJECT_K);
		
		foreach ($datas as $data):
			return $data->parameter_value;
		endforeach;
		return null;
}   
   
   
//Redirects to masvalor pages
function masvalor_redirect($path){
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$pageid = $tina_mvcv_pages['masvalor']['page_id'];	
		wp_redirect(home_url().'?page_id='.$pageid.$path);
		exit();
}

//Returns masvalor controller url
function masvalor_getUrl(){
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$pageid = $tina_mvcv_pages['masvalor']['page_id'];	
		return home_url().'/?page_id='.$pageid;
		
}


function verificationCaptcha(){

    if ($_POST){
		   $captcha_respuesta = recaptcha_check_answer ($captcha_privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
		
		if ($captcha_respuesta->is_valid) {
			  //todo correcto
			  //hacemos lo que se deba hacer una vez recibido el formulario válido
			  return true;
		   }else{
			  //El código de validación de la imagen está mal escrito.
			  return false;
			  $error_captcha = $captcha_respuesta->error;
		   }
	}

}

function masvalor_getTitleMain($id_user){
    global $wpdb;
    $sql = 'SELECT title FROM '.$wpdb->prefix.'masvalor_profiletitles 
						        WHERE userid = '.$id_user.' AND
 								      type = 0              AND 
								      ppal = 0';   
   
    		
    $datas = $wpdb->get_results($sql);
	foreach($datas as $data):	
	    return $data->title;
	endforeach;
	
	return null;	
   		
}

function masvalor_getTitlePostMain($id_user){
    global $wpdb;
    $sql = 'SELECT title FROM '.$wpdb->prefix.'masvalor_profiletitles 
						        WHERE userid = '.$id_user.' AND
 								      type = 1              AND 
								      ppal = 1';   
   
    $datas = $wpdb->get_results($sql);
	foreach($datas as $data):	
	    return $data->title;
	endforeach;
	
	return null;	
   		
}


//Returns a consultation results	
function masvalor_getConsultationResults($parameteres) {
	global $wpdb;
	
	$sql = 'SELECT p.birth_date as birth_date,p.name,p.lastname,p.gender,p.cv,p.userid,p.state,p.availability_move_state
			FROM '.$wpdb->prefix.'masvalor_profiles p WHERE p.actived = 1';
	$condition = ' AND ';
	if(isset($parameteres['gender']) && $parameteres['gender'] != 'Indistinto' ) {
		$sql .= $condition.'( p.gender ="'.$parameteres['gender'].'" )';
		$condition = ' AND ';
	}
	if(isset($parameteres['age_from']) && $parameteres['age_from'] != '' && isset($parameteres['age_to']) && $parameteres['age_to'] != '' ) {
		$sql .= $condition.'( (floor((unix_timestamp()-unix_timestamp(p.birth_date)) / (60*60*24*365))) >="'.$parameteres['age_from'].'" AND (floor((unix_timestamp()-unix_timestamp(p.birth_date)) / (60*60*24*365))) <= "'.$parameteres['age_to'].'" )';
		$condition = ' AND ';
	}
	if(isset($parameteres['country']) && $parameteres['country'] != '' && $parameteres['country'] != 'Cualquiera') {
		if ( isset($parameteres['availability_move_country']) && $parameteres['availability_move_country'] == 'true' ){
			$sql .= $condition.'( p.country like "%'.$parameteres['country'].'%" OR p.availability_move_country = 1)';
			$condition = ' AND ';
			}
		else {
			$sql .= $condition.'( p.country like "%'.$parameteres['country'].'%")';
			$condition = ' AND ';
		}
	}
	else
		if(isset($parameteres['availability_move_country']) && $parameteres['availability_move_country'] == 'true') {
			if ($condition != ' WHERE ')
				$condition = ' OR '; 
			$sql .= $condition.'( p.availability_move_country = 1 )';
			$condition = ' AND ';
		}
	if(isset($parameteres['state']) && $parameteres['state'] != '' && $parameteres['state'] != 'Cualquiera' ) {
		if(isset($parameteres['availability_move_state']) && $parameteres['availability_move_state'] == 'true') {
			$sql .= $condition.'( p.state like "%'.$parameteres['state'].'%" OR p.availability_move_state = 1)';
			$condition = ' AND ';
		}
		else {
			$sql .= $condition.'( p.state like "%'.$parameteres['state'].'%")';
			$condition = ' AND ';
		}
	}
	else
		if(isset($parameteres['availability_move_state']) && $parameteres['availability_move_state'] == 'true') {
			if ($condition != ' WHERE ')
				$condition = ' OR '; 
			$sql .= $condition.'( p.availability_move_state = 1 )';
			$condition = ' AND ';
		}
	if(isset($parameteres['city']) && $parameteres['city'] != '' && $parameteres['city'] != 'Cualquiera') {
		$sql .= $condition.'( p.city like "%'.$parameteres['city'].'%")';
		$condition = ' AND ';
	}
	if(isset($parameteres['availability_for_travel']) && $parameteres['availability_for_travel'] == 'true') {
		$sql .= $condition.'( p.availability_for_travel = 1 )';
		$condition = ' AND ';
	}
	if(isset($parameteres['gross_mensual_remuneration_max']) && $parameteres['gross_mensual_remuneration_max'] != '' 
		&& isset($parameteres['gross_mensual_remuneration_min']) && $parameteres['gross_mensual_remuneration_min'] != '')  {
		$sql .= $condition.'( p.expected_gross_mensual_remuneration <= '.$parameteres['gross_mensual_remuneration_max'];
		$sql .= ' AND p.expected_gross_mensual_remuneration >= '.$parameteres['gross_mensual_remuneration_min'].' )';
		$condition = ' AND ';
	}
	
	//Filter by labor Relationships
	$laborRelationships = explode(',',$parameteres['laborrelationships']);
	
	if ($laborRelationships[0] != '' ){
		$sql .= $condition.'(';
		$subconditon = '';
		foreach ($laborRelationships as $laborRelationship):
			switch($laborRelationship){
				case 'type_dependencyrelationship': $sql .= $subconditon.'p.prefer_lr_dependencyrelationship = 1';$subconditon=' OR ';break;
				case 'type_contractproject': $sql .= $subconditon.'p.prefer_lr_contractproject = 1';$subconditon=' OR ';break;
				case 'type_contractlabor': $sql .= $subconditon.'p.prefer_lr_contractlabor = 1';$subconditon=' OR ';break;
				case 'type_contractconsulting': $sql .= $subconditon.'p.prefer_lr_contractconsulting = 1';$subconditon=' OR ';break;
				case 'type_other': $sql .= $subconditon.'p.prefer_lr_other = 1';$subconditon=' OR ';break;
			}
		endforeach;
		$sql .=')';
	}
	
	//Filter by labor sectors
	$laborSectors = explode(',',$parameteres['laborsectors']);
	if ($laborSectors[0] != '' ){
		$sql .= $condition.'(';
		$subconditon = '';
		foreach ($laborSectors as $laborSector):
			switch($laborSector){
				case 'type_industry': $sql .= $subconditon.'p.prefer_ls_industry = 1';$subconditon=' OR ';break;
				case 'type_services': $sql .= $subconditon.'p.prefer_ls_services = 1';$subconditon=' OR ';break;
				case 'type_education': $sql .= $subconditon.'p.prefer_ls_education = 1';$subconditon=' OR ';break;
				case 'type_go': $sql .= $subconditon.'p.prefer_ls_go = 1';$subconditon=' OR ';break;
				case 'type_ngo': $sql .= $subconditon.'p.prefer_ls_ngo = 1';$subconditon=' OR ';break;
				case 'type_selfemployment': $sql .= $subconditon.'p.prefer_ls_selfemployment = 1';$subconditon=' OR ';break;
			}
		endforeach;
		$sql .=')';
	}
	
	//Filter by availability time
	$laborAvailabilityTimes = explode(',',$parameteres['availabilitytimes']);
	if ($laborAvailabilityTimes[0] != '' ){
		$sql .= $condition.'(';
		$subconditon = '';
		foreach ($laborAvailabilityTimes as $laborAvailabilityTime):
			switch($laborAvailabilityTime){
				case 'required_fulltime': $sql .= $subconditon.'p.prefer_at_fulltime = 1';$subconditon=' OR ';break;
				case 'required_parttime': $sql .= $subconditon.'p.prefer_at_parttime = 1';$subconditon=' OR ';break;
				case 'required_ondemand': $sql .= $subconditon.'p.prefer_at_ondemand = 1';$subconditon=' OR ';break;
			}
		endforeach;
		$sql .=')';
	}
	
	//Filter by competencies
	$competencies = explode(',',$parameteres['competencies']);
	if ($competencies[0] != '' ){
		$sql .= $condition.'( SELECT COUNT(ruc.id) FROM '.$wpdb->prefix.'masvalor_rel_user_competencies ruc WHERE p.userid = ruc.userid AND (';
		$subconditon = '';
		foreach ($competencies as $competence):
			$sql .= $subconditon.'ruc.competitionid ='.$competence;
			$subconditon = ' OR ';
		endforeach;
		$sql .=')';
		$sql .=') >= 1';
	}
	
	//Filter by disciplines
	$matchAll = $parameteres['matchalldisciplines'];
	$disciplines = explode(',',$parameteres['disciplines']);
	if ($disciplines[0] != '' ){
		$sql .= $condition.'( SELECT COUNT(rud.id) FROM '.$wpdb->prefix.'masvalor_rel_user_disciplines rud WHERE p.userid = rud.userid AND (';
		$subconditon = '';
		foreach ($disciplines as $discipline):
			$sql .= $subconditon.'rud.disciplineid ='.$discipline;
			if ($matchAll == 'true')
				$subconditon = ' AND ';
			else
				$subconditon = ' OR ';
		endforeach;
		$sql .=')';
		$sql .=') >= 1';
	}
	
	//Filter by titles
	$titles = explode(',',$parameteres['titles']);
	if ($titles[0] != '' ){
		$sql .= $condition.'( SELECT COUNT(pt.id) FROM '.$wpdb->prefix.'masvalor_profiletitles pt WHERE p.userid = pt.userid AND pt.type = 0 AND (';
		$subconditon = '';
		foreach ($titles as $title):
			$sql .= $subconditon.'LOWER(pt.title) like "%'.strtolower(trim($title)).'%"';
			$subconditon = ' OR ';
		endforeach;
		$sql .=')';
		$sql .=') >= 1';
	}
	
	//Filter by titlesPos
	$titlesPos = explode(',',$parameteres['titlesPos']);
	if ($titlesPos[0] != '' ){
		$sql .= $condition.'( SELECT COUNT(pt.id) FROM '.$wpdb->prefix.'masvalor_profiletitles pt WHERE p.userid = pt.userid AND pt.type = 1 AND (';
		$subconditon = '';
		foreach ($titlesPos as $titlePos):
			$sql .= $subconditon.'LOWER(pt.title) like "%'.strtolower(trim($titlePos)).'%"';
			$subconditon = ' OR ';
		endforeach;
		$sql .=')';
		$sql .=') >= 1';
	}

	global $current_user;
    get_currentuserinfo();
	//Do the query
	$datas = $wpdb->get_results($sql);
	$isAdmin = $parameteres['isadmin'];
	//Constructs table rows:
	ob_start();
	foreach ($datas as $data):?>
	
	    <?php if ($data->name != null) { 
			$aux = explode("-",$data->birth_date);
			foreach ($aux as $a) 
				if(strlen($a) == 4)
					$birth_year = $a;
			$age = 2012 - $birth_year;
		?>
			<tr>
				<td><input type="checkbox" name="userid[]" value="<?php echo $data->userid ?>"/></td>
				<td><?php echo $data->userid ?></td>
				<td><?php echo $data->name ?></td>
				
				<?php if ($isAdmin == '1') { ?>
					<td><?php echo $data->lastname ?></td>
				<?php } ?>
				<td><?php echo $age; ?></td>
				
				
				<?php if(checkUserType($current_user->user_login,'company')){ ?>
					<td><?php echo $data->gender ?></td>
					<td><?php echo $data->state; ?></td>
					
					<td><?php if($data->availability_move_state == 1)
                                    echo "Si";
                                else echo "No";  ?></td>
								
				<?php } ?>
				
								
				<td><?php echo masvalor_getTitleMain($data->userid); ?></td>
				<td><?php echo masvalor_getTitlePostMain($data->userid) ?></td>
				
				
				
				<?php if ($isAdmin == '5') { ?>
					<td><a href="<?php echo masvalor_getUrl().'/doctor-profile-public/&cid='.$data->userid ?>"><?php echo __('Ver'); ?></a></td>
				<?php } ?>
				
			<?php if ($isAdmin == '1') { ?>
				<td><a href="<?php echo masvalor_getUrl().'/doctor-profile/&fromdoctors=false&cid='.$data->userid ?>"><?php echo __('Ver'); ?></a></td>
				<td><a href="<?php echo home_url().'/wp-content/uploads/profiles/'.$data->userid.'/'.$data->cv ?>"><?php echo __('Ver'); ?></a></td>
			<?php } ?>
			
			</tr>
		<?php }?>
		
		<?php
	endforeach;
	?>
	<tr>                                    	
		<td colspan="7" align="left"><h3 style="margin-top:10px"><?php echo __('Resultados: ').count($datas) ?></h3></td>
	</tr>
	<?php
	$content =  ob_get_contents();
	ob_end_clean();
	return $content;
	
}
	
/************************************************************/

class mv_checkboxUtils {
	
	private function isInArray($value,$array,$element){
		if ($array != null){
			foreach ($array as $arrayElement) :
				if ($arrayElement->$element == $value)
					return true;
			endforeach;
		}
		return false;
	}
	
	// Contructs Compentencies Checkboxs
	public function getCompentencies($selectedsArray,$selectedsField,$id){
		global $wpdb;
		$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_compentencies order by name;';
		$datas = $wpdb->get_results($sql,OBJECT_K);
		ob_start();
		foreach ($datas as $data):
			?>
			<div class="checkbox-container">
				<input style="margin-right:12px;" class="competence-checkbox" <?php if ( $this->isInArray($data->id,$selectedsArray,$selectedsField) ) echo " checked"; ?> type="checkbox" id="<?php echo 'competence'.$data->id ?>" name="<?php echo $id ?>" value="<?php echo $data->id ?>" />
				<label for="<?php echo 'competence'.$data->id ?>" ><?php echo $data->name  ?></label>
			</div>
			<?php
		endforeach;
		$content =  ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	// Contructs Labor sector Checkboxs
	public function getLaborSectors($prefix,$selectedsData,$id){
		global $wpdb;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Industria';
		$aLaborSector->field = $prefix.'industry';
		$laborSectors[] = $aLaborSector;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Servicios';
		$aLaborSector->field = $prefix.'services';
		$laborSectors[] = $aLaborSector;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Educaci&oacute;n';
		$aLaborSector->field = $prefix.'education';
		$laborSectors[] = $aLaborSector;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Organizaci&oacute;n Gubernamental';
		$aLaborSector->field = $prefix.'go';
		$laborSectors[] = $aLaborSector;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Organizaci&oacute;n No Gubernamental';
		$aLaborSector->field = $prefix.'ngo';
		$laborSectors[] = $aLaborSector;
		
		$aLaborSector = new stdClass;
		$aLaborSector->name = 'Auto-empleo';
		$aLaborSector->field = $prefix.'selfemployment';
		$laborSectors[] = $aLaborSector;
		
		
		ob_start();
		foreach ($laborSectors as $aLaborSector):
			$actualField = $aLaborSector->field;
			?>
			<div class="checkbox-container">
				<input style="margin-right:12px;" class="laborsector-checkbox" <?php if ($selectedsData != null && $selectedsData->$actualField == 1) echo " checked"; ?> type="checkbox" id="<?php echo 'laborsector'.$aLaborSector->field ?>" name="<?php echo $id ?>" value="<?php echo $aLaborSector->field ?>" />
				<label for="<?php echo 'laborsector'.$aLaborSector->field ?>" ><?php echo $aLaborSector->name  ?></label>
			</div>
			<?php
		endforeach;
		$content =  ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	// Contructs Labor relationships Checkboxs
	public function getLaborRelationships($prefix,$selectedsData,$id){
		global $wpdb;
		
		$aLaborRelationship = new stdClass;
		$aLaborRelationship->name = 'Relaci&oacute;n de dependencia';
		$aLaborRelationship->field = $prefix.'dependencyrelationship';
		$laborRelationships[] = $aLaborRelationship;
		
		$aLaborRelationship = new stdClass;
		$aLaborRelationship->name = 'Contrato Laboral';
		$aLaborRelationship->field = $prefix.'contractlabor';
		$laborRelationships[] = $aLaborRelationship;
		
		$aLaborRelationship = new stdClass;
		$aLaborRelationship->name = 'Contrato por proyecto';
		$aLaborRelationship->field = $prefix.'contractproject';
		$laborRelationships[] = $aLaborRelationship;
		
		$aLaborRelationship = new stdClass;
		$aLaborRelationship->name = 'Contrato de consultor&iacute;a';
		$aLaborRelationship->field = $prefix.'contractconsulting';
		$laborRelationships[] = $aLaborRelationship;
		
		$aLaborRelationship = new stdClass;
		$aLaborRelationship->name = 'Otro';
		$aLaborRelationship->field = $prefix.'other';
		$laborRelationships[] = $aLaborRelationship;
		
		
		ob_start();
		foreach ($laborRelationships as $aLaborRelationship):
			$actualField = $aLaborRelationship->field;
			?>
			<div class="checkbox-container">
				<input style="margin-right:12px;" class="laborrelationship-checkbox" <?php if ($selectedsData != null && $selectedsData->$actualField == 1) echo " checked"; ?> type="checkbox" id="<?php echo 'laborsector'.$aLaborRelationship->field ?>" name="<?php echo $id ?>" value="<?php echo $aLaborRelationship->field ?>" />
				<label for="<?php echo 'laborsector'.$aLaborRelationship->field ?>" ><?php echo $aLaborRelationship->name  ?></label>
			</div>
			<?php
		endforeach;
		$content =  ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	// Contructus Availability time Checkboxs
	public function getAvailabilityTimes($prefix,$selectedsData,$id){
		global $wpdb;
		
		$aAvailabilityTime = new stdClass;
		$aAvailabilityTime->name = 'Jornada Completa';
		$aAvailabilityTime->field = $prefix.'fulltime';
		$availabilityTimes[] = $aAvailabilityTime;
		
		$aAvailabilityTime = new stdClass;
		$aAvailabilityTime->name = 'Jornada Parcial';
		$aAvailabilityTime->field = $prefix.'parttime';
		$availabilityTimes[] = $aAvailabilityTime;
		
		$aAvailabilityTime = new stdClass;
		$aAvailabilityTime->name = 'Por Demanda';
		$aAvailabilityTime->field = $prefix.'ondemand';
		$availabilityTimes[] = $aAvailabilityTime;
		ob_start();
		foreach ($availabilityTimes as $aAvailabilityTime):
			$actualField = $aAvailabilityTime->field;
			?>
			<div class="checkbox-container">
				<input style="margin-right:12px;" class="availabilitytime-checkbox" <?php if ($selectedsData != null && $selectedsData->$actualField == 1) echo " checked"; ?> type="checkbox" id="<?php echo 'availability'.$aAvailabilityTime->field ?>" name="<?php echo $id ?>" value="<?php echo $aAvailabilityTime->field ?>" />
				<label for="<?php echo 'availability'.$aAvailabilityTime->field ?>" ><?php echo $aAvailabilityTime->name  ?></label>
			</div>
			<?php
		endforeach;
		$content =  ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
}
/************************************************************/

class mv_comboUtils {

	//Contruct Labor Sectors combo
	public function getLaborSectors($prefix,$selected,$id){
	
			ob_start();
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Industria';
			$aLaborSector->field = $prefix.'industry';
			$laborSectors[] = $aLaborSector;
			
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Servicios';
			$aLaborSector->field = $prefix.'services';
			$laborSectors[] = $aLaborSector;
			
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Educaci&oacute;n';
			$aLaborSector->field = $prefix.'education';
			$laborSectors[] = $aLaborSector;
			
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Organizaci&oacute;n Gubernamental';
			$aLaborSector->field = $prefix.'go';
			$laborSectors[] = $aLaborSector;
			
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Organizaci&oacute;n No Gubernamental';
			$aLaborSector->field = $prefix.'ngo';
			$laborSectors[] = $aLaborSector;
			
			$aLaborSector = new stdClass;
			$aLaborSector->name = 'Auto-empleo';
			$aLaborSector->field = $prefix.'selfemployment';
			$laborSectors[] = $aLaborSector;
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($laborSectors as $aLaborSector):
			?>
				<option value="<?php echo $aLaborSector->field;?>" <?php if ($selected==$aLaborSector->field) echo 'selected'; ?> ><?php echo $aLaborSector->name;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Labor Relationships combo
	public function getLaborRelationships($prefix,$selected,$id){
	
			ob_start();
			$aLaborRelationship = new stdClass;
			$aLaborRelationship->name = 'Relaci&oacute;n de dependencia';
			$aLaborRelationship->field = $prefix.'dependencyrelationship';
			$laborRelationships[] = $aLaborRelationship;
			
			$aLaborRelationship = new stdClass;
			$aLaborRelationship->name = 'Contrato Laboral';
			$aLaborRelationship->field = $prefix.'contractlabor';
			$laborRelationships[] = $aLaborRelationship;
			
			$aLaborRelationship = new stdClass;
			$aLaborRelationship->name = 'Contrato por proyecto';
			$aLaborRelationship->field = $prefix.'contractproject';
			$laborRelationships[] = $aLaborRelationship;
			
			$aLaborRelationship = new stdClass;
			$aLaborRelationship->name = 'Contrato de consultor&iacute;a';
			$aLaborRelationship->field = $prefix.'contractconsulting';
			$laborRelationships[] = $aLaborRelationship;
			
			$aLaborRelationship = new stdClass;
			$aLaborRelationship->name = 'Otro';
			$aLaborRelationship->field = $prefix.'other';
			$laborRelationships[] = $aLaborRelationship;
						
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($laborRelationships as $aLaborRelationship):
			?>
				<option value="<?php echo $aLaborRelationship->field;?>" <?php if ($selected==$aLaborRelationship->field) echo 'selected'; ?> ><?php echo $aLaborRelationship->name;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Availability times combo
	public function getAvailabilityTimes($prefix,$selected,$id){
	
			ob_start();
			$aAvailabilityTime = new stdClass;
			$aAvailabilityTime->name = 'Jornada Completa';
			$aAvailabilityTime->field = $prefix.'fulltime';
			$availabilityTimes[] = $aAvailabilityTime;
			
			$aAvailabilityTime = new stdClass;
			$aAvailabilityTime->name = 'Jornada Parcial';
			$aAvailabilityTime->field = $prefix.'parttime';
			$availabilityTimes[] = $aAvailabilityTime;
			
			$aAvailabilityTime = new stdClass;
			$aAvailabilityTime->name = 'Por Demanda';
			$aAvailabilityTime->field = $prefix.'ondemand';
			$availabilityTimes[] = $aAvailabilityTime;
			
			
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($availabilityTimes as $aAvailabilityTime):
			?>
				<option value="<?php echo $aAvailabilityTime->field;?>" <?php if ($selected==$aAvailabilityTime->field) echo 'selected'; ?> ><?php echo $aAvailabilityTime->name;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Universities combo
	public function getUniversities($selected,$id){
			global $wpdb;
			$sql = 'SELECT * FROM '.$wpdb->prefix.'masvalor_universities Order By name;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			
			ob_start();
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($datas as $data):
				?>
				<option value="<?php echo $data->id;?>" <?php if ($selected==$data->name) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php
			endforeach;
			?>
			</select>
			<?php
			
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Searchs combo
	public function getSearchs($selected,$id,$isAdmin,$userid = null){
			global $wpdb;
			$sql = 'SELECT cs.id,c.name FROM '.$wpdb->prefix.'masvalor_companysearchs cs,'.$wpdb->prefix.'masvalor_companies c WHERE c.userid = cs.userid AND cs.actived = 1'; 
			if (!$isAdmin)
				$sql .= ' AND cs.userid = '.$userid;
			$sql .= ' order by c.name;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($datas as $data):
				?>
				<option value="<?php echo $data->id;?>" <?php if ($selected==$data->id) echo 'selected'; ?> ><?php echo $data->name.' - '.$data->id;?></option>
				<?php
			endforeach;
			?>
			</select>
			<?php
			
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Disciplines group combo
	public function getDisciplinesGroups($selected,$id){
			global $wpdb;
			$sql = 'SELECT id,name FROM '.$wpdb->prefix.'masvalor_disciplines Order By name;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($datas as $data):
				?>
				<option value="<?php echo $data->id; ?>" <?php if ($selected==$data->id) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php
			endforeach;
			?>
			</select>
			<?php
			
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	public function getDisciplinesSubGroups($selected,$id,$id_group){
			global $wpdb;
			$sql = 'SELECT id, name FROM '.$wpdb->prefix.'masvalor_subdisciplines where id_discipline='.$id_group . " Order By name";
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($datas as $data):
				?>
				<option value="<?php echo $data->id; ?>" <?php if ($selected==$data->id) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php
			endforeach;
			?>
			</select>
			<?php
			
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Disciplines group combo
	public function getDisciplines($selected,$id,$id_sub_group){
			global $wpdb;
			$sql = 'SELECT name, id FROM '.$wpdb->prefix.'masvalor_disciplines WHERE id_subbranch='.$id_sub_group . " Order By name";
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($datas as $data):
				?>
				<option value="<?php echo $data->id;?>" <?php if ($selected==$data->id) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php
			endforeach;
			?>
			</select>
			<?php
			
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Antiquities combo
	public function getAntiquities($selected,$id){
	
			ob_start();
			$antiquities[] = '0 a 4';
			$antiquities[] = '5 a 10';
			$antiquities[] = '11 a 25';
			$antiquities[] = 'mas de 25';
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($antiquities as $antiquity):
			?>
				<option value="<?php echo $antiquity;?>" <?php if ($selected==$antiquity) echo 'selected'; ?> ><?php echo $antiquity;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Languages Levels combo
	public function getLanguagesLevels($selected,$id){
	
			ob_start();
			$languageLevels = array ('Regular','Bien','Muy Bien');
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($languageLevels as $languageLevel):
			?>
				<option value="<?php echo $languageLevel;?>" <?php if ($selected==$languageLevel) echo 'selected'; ?> ><?php echo $languageLevel;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Languages  combo
	public function getLanguages($selected,$id){
	
			ob_start();
			$languages = array ('Alemán','Arabe','Búlgaro','Chino','Coreano','Croata','Dinamarqués','Español','Finlandés','Francés','Griego',
						'Hebreo','Holandés','Inglés','Irakí','Iraní','Italiano','Japonés','Mandarín','Noruego','Polaco','Portugués',
						'Rumano','Ruso','Sueco');
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($languages as $language):
			?>
				<option value="<?php echo $language;?>" <?php if ($selected==$language) echo 'selected'; ?> ><?php echo $language;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	
	//Contruct Marital status combo
	public function getMaritalStatus($selected,$id){
	
			ob_start();
			$maritalStatus[] = 'Casado';
			$maritalStatus[] = 'Divorciado';
			$maritalStatus[] = 'Soltero';
			$maritalStatus[] = 'Viudo';
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($maritalStatus as $aMaritalStatus):
			?>
				<option value="<?php echo $aMaritalStatus;?>" <?php if ($selected==$aMaritalStatus) echo 'selected'; ?> ><?php echo $aMaritalStatus;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Genders combo
	public function getGenders($indistinct,$selected,$id){
	
			ob_start();
			if($indistinct)
				$genders[] = 'Indistinto';
			$genders[] = 'Femenino';
			$genders[] = 'Masculino';
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($genders as $gender):
			?>
				<option value="<?php echo $gender;?>" <?php if ($selected==$gender) echo 'selected'; ?> ><?php echo $gender;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	
	//Contruct Antiquities combo
	public function getIdentityTypes($selected,$id){
	
			ob_start();
			$documentTypes[] = 'DNI';
			$documentTypes[] = 'Pasaporte';
			$documentTypes[] = 'LC';
			$documentTypes[] = 'LE';
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
			<?php
			foreach ($documentTypes as $documentType):
			?>
				<option value="<?php echo $documentType;?>" <?php if ($selected==$documentType) echo 'selected'; ?> ><?php echo $documentType;?></option>
			<?php
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Countries combo
	public function getCountries($selected,$id='country',$all = null){
			
			global $wpdb;
			$sql = 'SELECT name FROM '.$wpdb->prefix.'masvalor_countries Order By name;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			
			ob_start();
			
		
			?>
			<select name="<?php echo $id ?>" id="<?php echo $id ?>" onchange="refreshStates()">
			<?php
			if ($all == 1) {
				?>
				<option value="<?php echo 'Cualquiera';?>" <?php if ($selected=='Cualquiera') echo 'selected'; ?> ><?php echo 'Cualquiera';?></option>
				<?php
				}
			foreach ($datas as $data):
			if($data->name == 'Argentina') {?>
				<option selected value="<?php echo $data->name;?>" <?php if ($selected==$data->name) echo 'selected'; ?> ><?php echo $data->name;?></option>
			<?php } else { ?>
				<option value="<?php echo $data->name;?>" <?php if ($selected==$data->name) echo 'selected'; ?> ><?php echo $data->name;?></option>
			<?php }
			endforeach;
			?>
			</select>
			<?php
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct States combo (Filtering by $country)
	public function getStates($selected,$country,$id='state',$all = null){
			
			global $wpdb;
			$sql = 'SELECT state FROM '.$wpdb->prefix.'masvalor_states WHERE country = "'.$country.'" Order By state;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			
			if (sizeof($datas) > 0) {
				?>
				<select name="<?php echo $id ?>" id="<?php echo $id ?>" onchange="refreshCities()">
				<?php
				if ($all == 1) {
				?>
				<option value="<?php echo 'Cualquiera';?>" <?php if ($selected=='Cualquiera') echo 'selected'; ?> ><?php echo 'Cualquiera';?></option>
				<?php
				}
				foreach ($datas as $data):
				?>
					<option value="<?php echo $data->state;?>" <?php if ($selected==$data->state) echo 'selected'; ?> ><?php echo $data->state;?></option>
				<?php
				endforeach;
				?>
				</select>
				<?php
				}
			else {
			?>
				<input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $selected ?>" />
			<?php
			}
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	//Contruct Cities combo (Filtering by $state)
	public function getCities($selected,$country,$state,$id='city',$all = null){
			
			global $wpdb;
			$sql = 'SELECT city FROM '.$wpdb->prefix.'masvalor_cities WHERE state ="'.$state.'" AND country ="'.$country.'" Order By city;';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			
			if (sizeof($datas) > 0) {
				?>
				<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
				<?php
				if ($all == 1) {
				?>
				<option value="<?php echo 'Cualquiera';?>" <?php if ($selected=='Cualquiera') echo 'selected'; ?> ><?php echo 'Cualquiera';?></option>
				<?php
				}
				foreach ($datas as $data):
				?>
					<option value="<?php echo $data->city;?>" <?php if ($selected==$data->city) echo 'selected'; ?> ><?php echo $data->city;?></option>
				<?php
				endforeach;
				?>
				</select>
				<?php
				}
			else {
			?>
				<input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $selected ?>" />
			<?php
			}
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	public function getDoctors($selected,$id='doctors'){
			
			global $wpdb;
			$sql = 'SELECT userid, CONCAT(lastname," - ",name) as name FROM '.$wpdb->prefix.'masvalor_profiles WHERE actived = 1 ORDER BY name';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			
			if (sizeof($datas) > 0) {
				?>
				<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
				<?php
				foreach ($datas as $data):
				?>
					<option value="<?php echo $data->userid;?>" <?php if ($selected==$data->name) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php
				endforeach;
				?>
				</select>
				<?php
				}
			else {
			?>
				<input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $selected ?>" />
			<?php
			}
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;
	}
	
	
	public function getCompanies($selected,$id='companies'){
			
			global $wpdb;
			$sql = 'SELECT userid,name FROM '.$wpdb->prefix.'masvalor_companies WHERE actived = 1';
			$datas = $wpdb->get_results($sql,OBJECT_K);
			ob_start();
			
			if (sizeof($datas) > 0) {
				?>
				<select name="<?php echo $id ?>" id="<?php echo $id ?>" >
				<?php
				foreach ($datas as $data):
				?>
					<option value="<?php echo $data->userid;?>" <?php if ($selected==$data->userid) echo 'selected'; ?> ><?php echo $data->name;?></option>
				<?php


				endforeach;
				?>
				</select>
				<?php
				}
			else {
			?>
				<input type="text" name="<?php echo $id ?>" id="<?php echo $id ?>" value="<?php echo $selected ?>" />
			<?php
			}
			$content =  ob_get_contents();
			ob_end_clean();
			return $content;

	}
	
}


/**************************************************************************************/


  ?>