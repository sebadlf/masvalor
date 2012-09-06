<?php
require_once ('models/images_gallery_model.php');
class images_gallery_page extends tina_mvc_base_page_class {
	
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
		
        $this->images_gallery( $request,$msg);
    }
		 
    function images_gallery( $request,$msg) {
        global $current_user;
		get_currentuserinfo();
		$model = new images_galleryModel();
		$tpl_vars = new stdClass;
		
		$tina_mvcv_pages = get_option("tina_mvc_pages");
		$tpl_vars->pageid = $tina_mvcv_pages['masvalor']['page_id'];
        $tpl_vars->msg = $msg;
		
		//Nos fijamos si tenemos que subir alguna imagen al servidor, y en ese caso la subimos
		$image_path = $_FILES["image_path"];
		if($image_path["name"] != '') 
			$model->upload_image($_FILES);
		
		//Chequeamos si viene alguna imagen para eliminar y en ese caso llamamos al modelo para que la borre del directorio
		$to_delete = $_POST["to_delete"];
		if($to_delete != '')
			$model->delete_image($to_delete);
		
		//Llamamos al modelo para traer los datos del directorio, obvio despues de ejecutar el guardado y el borrado asi se actualiza correctamente
		$tpl_vars->images = $model->give_me_directory_data();
		
		if (!checkUserType($current_user->user_login,'masvalor-admin'))
				die(__('Invalid Access'));
		else{
			$this->set_post_title(__('Galeria de im&aacute;genes'));
			$this->set_post_content( $this->load_view('images_gallery', $tpl_vars ) );
		}	
    }

}


?>