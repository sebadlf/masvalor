<?php
/**
 * The Tina MVC Wordpress admin page
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Page-Controllers
 * @author     Francis Crossen <francis@crossen.org>
*/

/**
 * The Tina MVC Wordpress admin page
 *
 * @package    Tina-MVC
 */
class tina_mvc_wordpress_admin_page extends tina_mvc_base_page_class {
    
   /**
    * Check the request and call the appropriate class method
    *
    * @param   array $request extracted from $_GET - /controller/action/some/data
    */
    function __construct( $request=array() ) {
        
        parent::__construct( $request );
        
        $this->use_dispatcher = TRUE;
       
    }
    
    /**
     * Display the Wordpress admin page
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username (ignored here)
     * @todo set the post_title consistently throughout Tina
     */
    function index() {
        
        $this->set_post_content( $this->load_view('tina_mvc_wordpress_admin', ($dummy=FALSE), tina_mvc_find_tina_mvc_folder().'/classes' ) );
        
    }

}


?>