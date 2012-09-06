<?php
/**
* A sample page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* An example of the tina_mvc_html_table_helper in use
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/
class sample_html_table_helper_page extends tina_mvc_base_page_class {
    
    function __construct( $request=array() ) {
        
        parent::__construct(  $request );
        
        /**
         * Automatic routing with the dispatcher method.
         * @see dispatcher_example_page.php
         */
        $this->use_dispatcher = TRUE;
        
    }
    
    /**
     * Generate some data and use the tina_mvc_html_table_helper to generate HTML
     * tables
     */
    function index() {
        
        /**
         * Include the helper
         */
        tina_mvc_include_helper('tina_mvc_table_helper');
        
        /**
         * Quick and dirty... the HTML we'll output
         *
         * No fancy view files here...
         */
        $html_out = '';
        
        /**
         * The first table
         * 
         * Generate an array of data to format
         */
        $table_headings = array( 'column_one' , 'Column 2' , '<col-3>' );
        $table_data = array();
        for( $i=0; $i<5; $i++ ) {
            
            foreach( $table_headings AS $j => $heading ) {
                $table_data[$i][$heading] = rand();
            }
            
        }
        
        $table = new tina_mvc_table_helper( 'first_table' );
        $table->set_data( $table_data );
        
        $html_out .= '<h2>The First Table</h2>';
        $html_out .= $table->get_html();
        
        /**
         * All done
         */
        unset( $table );
        
        /**
         * The second table
         * 
         * Generate an object of data to format
         */
        $table_headings = array( '<a href="#">column_one</a>' , 'Column 2(&euro;)' , 'Now you see me -&gt; &lt;col-3&gt; and now you don\'t -&gt; <col-3>' );
        $table_data = new stdClass;
        for( $i=0; $i<12; $i++ ) {
            
            foreach( $table_headings AS $j => $heading ) {
                $table_data->$i->$heading = rand();
            }
            
        }
        
        $table = new tina_mvc_table_helper( 'second_table' );
        $table->set_data( $table_data );
        
        /**
         * Because we have proper HTML in the headers, we don't want to escape the
         * table headings
         */
        $table->do_not_esc_th( TRUE );
        
        $html_out .= '<h2>The Second Table</h2>';
        $html_out .= $table->get_html();
        
        $this->set_post_title('My Beautiful Tables');
        
        $this->set_post_content($html_out);
        
    }
    
}


?>
