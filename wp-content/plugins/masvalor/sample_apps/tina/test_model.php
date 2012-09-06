<?php
/**
* A model file
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A trivial example of loading a model
*
* So far the model only provides access to $model->DB - a reference to the global $wp_db
* object
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
*/
class test_model extends tina_mvc_base_model_class {
    
    function __construct(  $request ) {
        parent::__construct(  $request );
    }
    
}


?>