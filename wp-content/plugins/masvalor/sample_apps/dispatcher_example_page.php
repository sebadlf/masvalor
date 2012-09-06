<?php
/**
* A test for the dispatcher
*
* Shows you how to use the disatcher
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * Illustrates the use of the dispatcher
 *
 * @see test_page.php notes on putting everything in the constructor and not using the add_var() and add_var_e() functions.
 * 
 * @package    Tina-MVC
 * @subpackage  Tina-Sample-Apps
 */
class dispatcher_example_page extends tina_mvc_base_page_class {
    
    /**
    * Check the request and call the appropriate class method
    *
    * @param   array $request extracted from $_GET - /controller/action/some/data
    */
    function __construct( $request ) {
        
        // permission override - this controller should be accessible to all...
        $this->role_to_view = FALSE;
        parent::__construct(  $request );
        
        /**
         * This is what enables the dispatcher function. Your method will be called AFTER
         * permissions checks have been completed.
         */
        $this->use_dispatcher = TRUE;
        
    }
    
    /**
    * Default controller
    */
    function index() {
        
        $this->set_post_title('Hello from the \''.__FUNCTION__.'\' method!');
        $this->set_post_content( $this->_some_blurb() );
        
    }

    /**
    * Another controller
    */
    function another_controller() {
        
        $this->set_post_title('Hello from the \''.__FUNCTION__.'\' method!');
        $this->set_post_content( $this->_some_blurb() );
        
    }

    /**
    * Yet another controller
    */
    function yet_another_controller() {
        
        $this->set_post_title('Hello from the \''.__FUNCTION__.'\' method!');
        $this->set_post_content( $this->_some_blurb() );
        
    }

    /**
    * Some blurb
    *
    * You will note it is private to prevent it from being called in response to a
    * request. Name it with a leading underscore to prevent the dispatcher from executing
    * it. Follow this example
    */
    private function _some_blurb() {
        
        return
        'It Worked! (at '.tina_mvc_db_datetime().')'.
        '<hr>Valid Controllers:<br />'.
        tina_mvc_make_controller_link( 'dispatcher-example' ).' - <br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/index' ).' - The index (default) controller. Same as above. <br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/another-controller' ) . ' - The another-controller controller.<br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/yet-another-controller' ) . ' - The yet-another-controller controller.<br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/_some-blurb' ) . ' - This should be inaccessible - it is defined private and named with a leading underscore to prevent the dispatcher from executing it.<br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/private_function' ) . ' - Inaccessible - it is defined private. Clicking this will display a PHP error (if your server displays them) or a blank page.<br />'.
        tina_mvc_make_controller_link( 'dispatcher-example/doesnt-exist' ) . ' - A non existant controller.<br />'
        ;
        
    }
    
    /**
    * Private
    *
    * Cannot be loaded by the dispatcher. Will trigger a PHP error
    */
    private function private_function() {
        
        return true;
        'It Worked! It shouldn\'t have!'
        ;
        
    }
    
}


?>