<?php
/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* Yet another sample paginator
*
* Illustrates the use of the tina_mvc_pagination_helper_class
*
* This shows how to supress sortable columns. In cases where your SQL statement is
* complex the Pagination Helper will munge your SQL code and cause errors when
* you click on a heading
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/
class sample_pagination_4_page extends tina_mvc_base_page_class {
    
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
        $P->set_base_url( tina_mvc_make_controller_url('sample-pagination-4') );
        
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
        
        /**
         * We will get the results and format custom HTML rows rather than allow
         * the pagination helper to give us a generic table. You should use escaped
         * HTML here.
         *
         * In this case we are just building some HTML. You would normally use a
         * view file instead of putting HTML in your page controller.
         */
        $rows = $P->get_sql_rows();
        
        //echo "<pre>"; var_dump( $rows ); die;
        
        /**
         * Iterate throught the results and build some HTML
         */
        foreach( $rows AS $i => & $r ) {
            
            if( $i % 2 ) {
                $bg = '#333';
                $fg = '#ccc';
            }
            else {
                $bg = '#ccc';
                $fg = '#333';
            }
            
            $r->{'Database ID'} = '<span style="color:'.$fg.';background:'.$bg.'">'.$wpdb->escape($r->{'Database ID'}).'</span>';
            $r->{'User Login'} = '<span style="color:'.$fg.';background:'.$bg.'"><a href="#" title="'.$wpdb->escape($r->{'Display Name'}).'">'.$r->{'User Login'}.'</a></span>';
            $r->{'A non-DB field (non-sortable)'} = '<span style="color:'.$fg.';background:'.$bg.'"><a href="#" title="'.$wpdb->escape($r->{'Display Name'}).'">'.$i.'</a></span>';
            
            /**
             * You can also unset() an entry here
             */
            // $r->{'Display Name'} = '<span style="color:'.$fg.';background:'.$bg.'">'.$wpdb->escape($r->{'Display Name'}).'</span>';
            unset( $r->{'Display Name'} );
            
        }
        
        /**
         * Set the rows, overriding the use of the html table helper
         */
        $P->set_html_rows( $rows );
        
        /**
         * This will prevent the helper from adding sortable column HTML to the
         * column heading 'A non-DB field (non-sortable)'.
         *
         * You cannot sort on columns that do not come directly from the database.
         */
        $P->suppress_sort( array('A non-DB field (non-sortable)') );
        
        $this->set_post_title('Pagination');
        $this->set_post_content( $P->get_html() );
        
    }
    
}


?>