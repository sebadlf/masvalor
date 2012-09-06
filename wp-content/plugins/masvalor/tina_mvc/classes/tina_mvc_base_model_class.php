<?php
//
// $Id: tina_mvc_base_model_class.php, v 0.00 Sat Jan 23 2010 21:56:43 GMT+0000 (IST) Francis Crossen $
//

/**
* The base Tina model
*
* @package    Tina-MVC
* @subpackage Tina-Core-Classes
*/

/**
 * The base Tina model
 *
 * Derive your models from this class. So far the only thing we do is to globalise the $wpdb variable
 * and assign it as a class variable
 * 
 * @package    Tina-MVC
 * @todo    expand
 */
class tina_mvc_base_model_class {
    
    /**
     * The $wpdb object. It is public in case we want to run arbitrary SQL
     * 
     * @var object $DB A reference to $wpdb object
     */
    public $DB;
    
    /**
     * The rows retrieved from the database
     * @var mixed
     */
    public $results;

    /**
     * Variable to store SQL statements as
     * @var object
     */
    public $mysql;
    
    /**
     * Constructor
     */
    public function __construct() {
        
        global $wpdb;
        $this->DB = & $wpdb;
        
    }
    
}



?>