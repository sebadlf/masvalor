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
class index_page extends tina_mvc_base_page_class {
    
   /**
    * Check the request and call the appropriate class method
    *
    * @param   array $request extracted from $_GET - /controller/action/some/data
    */
    function __construct( $request=array() ) {
        
        // permission override - this controller should be accessible to loged in users...
        // $this->role_to_view = FALSE;
        parent::__construct(  $request );
        
        // what action are we doing?
        // pop the first array element from $request ('user')...
        array_shift( $request );
        
        $this->index( $request );
       
    }

    /**
     * Display the user dashboard
     *
     * This function displays a basic dashboard with a 'Hello World!' message.
     * It is expected that you override it by putting your own 'index_view.php'
     * file in the app/ folder
     *
     * @param   array $request extracted from $_GET - /controller/user-created/username (ignored here)
     * @todo set the post_title consistently throughout Tina
     */
    function index( $request ) {
        
        $tpl_vars = new stdClass; // for the 'view'
        
        // get the users details...
        global $current_user;
        get_currentuserinfo();
        $tpl_vars->user = $current_user;
        
        $tpl_vars->hello_world = "Hello World!";
        
        $this->set_post_content( $this->load_view('index', $tpl_vars ) );
        
    }

}


?>