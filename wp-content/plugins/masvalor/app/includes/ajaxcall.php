<?php 

// Ajax Calls 


/*Languages combo*/
add_action('wp_ajax_get_langs', 'get_langs_callback');
add_action('wp_ajax_nopriv_get_langs', 'get_langs_callback');


function get_langs_callback() {
	$comboid = $_POST['comboid'];
	$value = $_POST['value'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getLanguages($value,$comboid);
	die();
}

/*Languages levels combos*/
add_action('wp_ajax_get_langs_levels', 'get_langs_levels_callback');
add_action('wp_ajax_nopriv_get_langs_levels', 'get_langs_levels_callback');


function get_langs_levels_callback() {
	$comboid = $_POST['comboid'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getLanguagesLevels(null,$comboid);
	die();
}

/*Universities combos*/
add_action('wp_ajax_get_universities', 'get_universities_callback');
add_action('wp_ajax_nopriv_universities_levels', 'get_universities_callback');


function get_universities_callback() {
	$comboid = $_POST['comboid'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getUniversities(null,$comboid);
	die();
}
/*Disciplines SubGroups combos*/
add_action('wp_ajax_get_disciplines_sub_group', 'get_disciplines_sub_group_callback');
add_action('wp_ajax_nopriv_disciplines_sub_group', 'get_disciplines_sub_group_callback');

function get_disciplines_sub_group_callback() {
	$comboid = $_POST['comboid'];
	$id_group = $_POST['group'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getDisciplinesSubGroups(null,$comboid,$id_group);
	die();
}

/*Disciplines Groups combos*/
add_action('wp_ajax_get_disciplines_group', 'get_disciplines_group_callback');
add_action('wp_ajax_nopriv_disciplines_group', 'get_disciplines_group_callback');

function get_disciplines_group_callback() {
	$comboid = $_POST['comboid'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getDisciplinesGroups(null,$comboid);
	die();
}

/*Disciplines combos*/
add_action('wp_ajax_get_disciplines', 'get_disciplines_callback');
add_action('wp_ajax_nopriv_get_disciplines', 'get_disciplines_callback');

function get_disciplines_callback() {
	$sub_group = $_POST['group'];
	$comboid = $_POST['comboid'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getDisciplines(null,$comboid,$sub_group);
	die();
}

/*States combo*/
add_action('wp_ajax_get_states', 'get_states_callback');
add_action('wp_ajax_nopriv_get_states', 'get_states_callback');


function get_states_callback() {
	$country = $_POST['country'];
	$comboid = $_POST['comboid'];
	$all = $_POST['all'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getStates(null,$country,$comboid,$all);
	die();
}

/*Cities combo*/
add_action('wp_ajax_get_cities', 'get_cities_callback');
add_action('wp_ajax_nopriv_get_cities', 'get_cities_callback');


function get_cities_callback() {
	$country = $_POST['country'];
	$state = $_POST['state'];
	$comboid = $_POST['comboid'];
	$all = $_POST['all'];
	$comboUtils = new mv_comboUtils();
	echo $comboUtils->getCities(null,$country,$state,$comboid,$all);
	die();
}

/*Get consultation results*/
add_action('wp_ajax_get_consultation_result', 'get_consultation_result_callback');
add_action('wp_ajax_nopriv_get_consultation_result', 'get_consultation_result_callback');


function get_consultation_result_callback() {
	$parameters = $_POST;
	echo masvalor_getConsultationResults($parameters);
	die();
}

/*Add postulants to a search*/
add_action('wp_ajax_add_postulants', 'add_postulants_callback');
add_action('wp_ajax_nopriv_add_postulants', 'add_postulants_callback');


function add_postulants_callback() {
	$searchid = $_POST['searchid'];
	$postulants = $_POST['postulants'];
	$whoadd = $_POST['whoadd'];
	$deleteold = $_POST['deleteold'];
	echo masvalor_addPostulant($searchid,$postulants,$whoadd,$deleteold);
	die();
}

/*Remove postulant from a search*/
add_action('wp_ajax_remove_postulant', 'remove_postulant_callback');
add_action('wp_ajax_nopriv_remove_postulant', 'remove_postulant_callback');


function remove_postulant_callback() {
	$searchid = $_POST['searchid'];
	$postulantid = $_POST['userid'];
	$type = $_POST['type'];
	echo masvalor_removePostulant($searchid,$postulantid,$type);
	die();
}

?>