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
class images_galleryModel {
	function give_me_directory_data() {
		define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
		define('FCPATH', __FILE__);
		define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
		define('PUBPATH',str_replace(SELF,'',FCPATH)); 
	
		$unlinking = PUBPATH.$name;
		$pos_models = strpos($unlinking,'models');
		$truncate_unlinking = substr($unlinking,0,$pos_models);
		$definitive_unlinking = $truncate_unlinking.'includes/images_gallery/';
		
		$path = $definitive_unlinking;
		$dir = opendir($path);
		$img_total=0;
		
		while ($elemento = readdir($dir)) {
			if (strlen($elemento)>3) {
				$img_array[$img_total]=$elemento;
			}
			$img_total++;
		}
		return $img_array;
	}
	
	function upload_image($image) {
		define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
		define('FCPATH', __FILE__);
		define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
		define('PUBPATH',str_replace(SELF,'',FCPATH)); 
		
		$unlinking = PUBPATH.$name;
		$pos_models = strpos($unlinking,'models');
		$truncate_unlinking = substr($unlinking,0,$pos_models);
		$definitive_unlinking = $truncate_unlinking.'includes/images_gallery/';
	
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cad = "";
		
		for($i=0;$i<12;$i++) 
			$cad .= substr($str,rand(0,62),1);
			
		$destino = $definitive_unlinking;
		$sep=explode('image/',$_FILES["image_path"]["type"]); 
		$tipo=$sep[1]; 
		move_uploaded_file ( $image [ 'image_path' ][ 'tmp_name' ], $destino . '/' .$cad.'.'.$tipo);  
	}
	
	function delete_image($name) { 
		define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
		define('FCPATH', __FILE__);
		define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
		define('PUBPATH',str_replace(SELF,'',FCPATH)); 
		
		$unlinking = PUBPATH.$name;
		$pos_models = strpos($unlinking,'models');
		$truncate_unlinking = substr($unlinking,0,$pos_models);
		$definitive_unlinking = $truncate_unlinking.'/includes/images_gallery/'.$name;
		unlink($definitive_unlinking);
	}
}
?>