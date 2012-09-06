<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A sample paginator
*
* Illustrates the use of the tina_mvc_pagination_helper_class
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/
class sample_pagination_page extends tina_mvc_base_page_class {
    
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        /**
         * Automatic routing with the dispatcher method.
         * @see dispatcher_example_page.php
         */
        $this->use_dispatcher = TRUE;
        
        /**
         * Tina MVC helpers are not included by default
         */
        tina_mvc_include_helper('tina_mvc_pagination_helper');
        
    }
    
    /**
     * The default controller
     */
    function index() {
        
        global $wpdb;
        
        /**
         * We are using custom SQL here to demonstrate the use of the pager.
         *
         * Have a look at the Demo Data Creator plugin if you want to create many
         * dummy users for use with this example... or even better play with your own data
         *
         * The $base_sql is a properly escaped statement that will get you all the rows you want. ORDER BY and LIMIT clauses
         * are not set - they will be set automatically.
         */
        $base_sql = 'SELECT ID AS `Database ID`, user_login AS `User Login`, display_name AS `Display Name` FROM '.$wpdb->users;
        
        /**
         * A SQL statement to get the total number of rows returned in the above statement.
         */
        $count_sql = 'SELECT COUNT(ID) FROM '.$wpdb->users;
        
        /**
         * The HTML table ID is set from the parameter you ppass to the constructor
         */
        $P = new tina_mvc_pagination_helper( 'user_list' );
        
        $P->set_count_from_sql( $count_sql );
        
        /**
         * The url required to get to the default table view
         */
        $P->set_base_url( tina_mvc_make_controller_url('sample-pagination') );
        
        /**
         * Set up the filter.
         *
         * This allows a user to search on various fields (even if they are not
         * selected for display). This will output a form at the top of the table
         * of results.
         * 
         * Parameter is array ( 'Display Name' => 'mysql_field_name' )
         */
        $P->filter_box_on_fields( array(
                                        'User Login' => 'user_login',
                                        'Display Name' => 'display_name',
                                        'user_email' => 'user_email'
                                        )
                                 );
        
        $P->set_base_sql( $base_sql );
        
        /**
         * For the pagination links
         */
        $P->mid_range = 9; // use an object method instead
        
        $P->set_items_per_page( 10 );
        
        $P->set_default_sort_by( 'User Login' );
        $P->set_default_sort_order( 'desc' );
        
        $this->set_post_title('Pagination');
        $this->set_post_content( $P->get_html() );
        
    }
    
}


?>