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
class helloModel {
    
   public function save(){
		global $wpdb;
		$name = $_POST['name'];
		$sql = 'INSERT INTO '.$wpdb->prefix.'example (name) VALUES ("'.$name.'")';
		if ($wpdb->query($sql) === false)
			return "Hubo un error";
		return "Datos guardados con exito";
   }
   
   public function getData($id){
		global $wpdb;
		$sql = 'SELECT id,name FROM '.$wpdb->prefix.'example WHERE id='.$id.';';
		$data = $wpdb->get_results($sql,OBJECT_K);
		if (isset($data[1]))
			return $data[1];
		else
			return null;
   }

}
?>