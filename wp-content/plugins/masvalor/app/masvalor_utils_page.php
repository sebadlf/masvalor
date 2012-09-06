<?php
require_once ('models/masvalor_utils.php');
class masvalor_utils_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        // what action are we doing?
		$task = $_POST['task'];
        // pop the first array element from $request ('user')...
        array_shift( $request );
		$model = new mv_comboUtils();
        if ($task == 'getStates'){
			$msg = $model->save();
		}
		if ($task == 'getCities'){
			$msg = $model->save();
		}
       
    }

}


?>