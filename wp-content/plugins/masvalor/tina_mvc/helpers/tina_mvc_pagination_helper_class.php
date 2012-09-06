<?php
/**
 * Pagination Helper class file
 *
 * Builds a paginated, sortable HTML table of results from data or SQL
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Helpers
 * @author     Francis Crossen <francis@crossen.org>
 */

/**
 * Include the base class
 */
require_once( tina_mvc_find_libs_folder().'/pagination/pagination_class.php' );

/**
 * Pagination Helper class file
 *
 * Builds a paginated, sortable HTML table of results from SQL
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Helpers
 * @param   string $pagername a unique name for the pager
 *
 * @todo Allow a default order to be set
 */
class tina_mvc_pagination_helper extends Paginator {

    var $sort_by;
    var $sort_ord;
    var $default_sort_by;
    var $default_sort_ord;
    var $pager_id;
    var $sql_results;
    var $custom_html_rows;
    var $suppress_sort = FALSE;
    var $do_not_allow_sort_on_these_columns = array();
    
    /**
     * Constructor
     *
     * Sets up the paginator
     *
     * @param   string $pagername  unique name for the pager e.g. 'users-list'
     */
    function __construct( $pagername=false ) {
        
        if(!$pagername) { tina_mvc_error("tina_mvc_pager_class Error: tina_mvc_pagination_class requires the \$pagername parameter."); }
        
        // required to save search results
        // requires the browser to accept cookies... IF permalinks are off
        session_start();
        
        $this->pagername = str_replace( ' ', '' , $pagername );
        $this->pager_id = $this->pagername.'_pager';
        
        parent::Paginator();
        
        global $wpdb;
        $this->wpdb = & $wpdb;
        
        $this->custom_html_rows = FALSE;
        $this->filter->fields = array();
        
    }
    
    /**
     * Set a SQL statement that will give the total number of rows of data
     *
     * NB: Make sure you escape your own SQL before passing it to this function
     *
     * @param string a properly formatted SQL string
     */
    public function set_count_from_sql( $sql='' ) {
        
        if(!$sql) {
            return FALSE;
        }
        
        $this->count_sql = $sql;
        
    }
    
    /**
     * Set the base url to this table
     *
     * This should be the url that gets you to the default table view
     *
     * This class will append strings to this url to support paging and order by
     * functions. You need to manually set this value as Wordpress may not be set
     * up to use the default permalinks (i.e. example.com/?p=123)
     *
     * @param string $u The base url to this table
     */
    public function set_base_url( $u='' ) {
        
        $this->base_url = $u;
        
    }
    
    /**
     * Get SQL results
     *
     * Use this to get the results as an array. Generally you use this to iterate
     * through the result set and make up your own HTML rows. You would use this
     * to prevent the use of the tina_mvc_table_helper to format results.
     *
     * @return array An array of objects - the results fo the SQL query
     * @see set_html_rows()
     */
    public function get_sql_rows() {
        
        $this->build_sql();
        
        if( ! $this->sql_results ) {
            
            return array();
            
        }
        
        return $this->sql_results;
        
    }
    
    /**
     * Set the HTML rows to be displayed
     *
     * This will override the use of tina_mvc_table_helper for formatting results.
     * Use $this->get_sql_rows() to retrieve results
     */
    public function set_html_rows( $rows ) {
        
        if( ! $rows ) {
            return FALSE;
        }
        if( ! is_array( $rows ) AND ! is_object( $rows ) ) {
            tina_mvc_error('$rows must be an array or object');
        }
        
        $this->sql_results = $rows;
        $this->custom_html_rows = TRUE;
        
        // are the rows array() of rows or array() of array()?
        foreach( $rows AS $r ) {
            if( is_array($r) OR is_object($r) ) {
                $this->custom_html_rows_are_strings = FALSE;
            }
            else {
                $this->custom_html_rows_are_strings = TRUE;
            }
            break;
        }
        
    }
    
    /**
     * Return the complete HTML
     *
     * Navigation links appear before and after the table
     *
     * @return string
     */
    public function get_html() {
        
        if( ! $this->custom_html_rows ) {
            $this->build_sql();
        }
        
        if( ! $this->custom_html_rows_are_strings OR ! $this->custom_html_rows ) {
            
            // we'll just use the table helper to format a table
            
            tina_mvc_include_helper('tina_mvc_table_helper');
            
            $table = new tina_mvc_table_helper( 'sample_table' );
            
            // we need to change the headings to add the html links for sorting...
            foreach( $this->sql_results AS & $row ) {
                
                $new_row = new stdClass;
                
                foreach( $row AS $fname => $val ) {
                    
                    $other_order = 'asc';
                    $current_order = '&nbsp;&nbsp;';
                    // sorting?
                    if( $this->sort_by == $fname ) {
                        
                        if( $this->sort_ord == 'asc' ) {
                            $current_order = ' &uarr;';
                            $other_order = 'desc';
                        }
                        else {
                            $current_order = ' &darr;';
                            $other_order = 'asc';
                        }
                        
                    }
                    
                    if( ! $this->suppress_sort AND ! in_array($fname,$this->do_not_allow_sort_on_these_columns) ) {
                        $key = '<a href="'.$this->base_url.'1/0/'.'sort-'.urlencode($fname).'-'.$other_order.'#'.$this->pager_id.'">'.tina_mvc_esc_html_recursive($fname).'</a>';
                        $key .= "<span style=\"width:2em;\">$current_order</span>";
                    }
                    else {
                        $key = tina_mvc_esc_html_recursive($fname);
                    }
                    
                    $new_row->$key = $val;
                    
                }
                
                break;
                
            }
            $this->sql_results[0] = $new_row;
            reset( $this->sql_results );
            
            $table->set_data( $this->sql_results );
            
            $table->do_not_esc_th( TRUE );
            $table->do_not_esc_td( TRUE );
            
            $html_results = $table->get_html();
            
        }
        else {
            
            // we have custom HTML ready to go
            $html_results = '';
            
            foreach( $this->sql_results AS $row ) {
                
                $html_results .= $row . "\r\n";
                
            }
            
            
        }
        
        $html = '<div id="'.$this->pager_id.'">'."\r\n";
        
        $html .= $this->get_filter_box_html();
        
        $html .= parent::display_pages();
        
        $html .= $html_results;
        
        $html .= parent::display_pages();
        
        $html .= "\r\n</div>";
        
        return $html;
        
    }
    
    /**
     * Get parameters from $_POST and $_GET, build SQL statements, including sort
     * and order parameters, retrieve the count, retrieve the records
     */
    private function build_sql() {
        
        if( ! $this->base_url ) {
            tina_mvc_error( '$this->base_url must be set. See $this->set_base_url()' );
        }
        
        if( $this->base_url[strlen($this->base_url)-1] != '/' ) {
            $this->base_url .= '/'; // add a trailing '/' if it isn;t there... needed for the str_replace() function
        }
        
        // what page are we on?
        // we expect base_url/page_no/items_per_page/sort-FNAME-asc or desc - all items optional
        $current_url = (!empty($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/';
        
        // lose the base url part - we don;t want it...
        $page_and_per_page = str_replace( $this->base_url , '' , $current_url );
        $page_and_per_page = explode( '/', $page_and_per_page );
        
        $no_of_params = count( $page_and_per_page );
        
        if( $no_of_params >= 1 ) {
            $current_page = intval( $page_and_per_page[0] );
        }
        else {
            $current_page = 1;
        }
        
        if( $no_of_params >= 2 ) {
            
            if( strtolower($page_and_per_page[1]) == 'all' ) {
                $items_per_page = 'all' ;
            }
            elseif( strpos( $page_and_per_page[1] , 'sort-' ) !== FALSE ) {
                
                // we have a sort parameter...
                $this->get_sort_params_from_url( $page_and_per_page[1] );
                
            }
            else {
                $items_per_page = intval( $page_and_per_page[1] ) ;
            }
            
        }
        else {
            $items_per_page = FALSE;
        }
        
        if( $no_of_params >= 3 ) {
            
            // we have a sort parameter...
            $this->get_sort_params_from_url( $page_and_per_page[2] );
            
        }
        
        $this->tina_items_per_page = $items_per_page;
        $this->tina_page_no = $current_page;
        
        // now for some SQL...
        
        //tmprd( $_POST );
        
        // are we filtering?
        $filter_where_clause = FALSE; //default
        
        $this->filter_post_var = $this->pagername.'_filter_terms';
        
        $search_term = $this->wpdb->escape( $this->get_search_term() );
        
        // are we clearing?
        if( tina_mvc_get_Post( "{$this->filter_post_var}_clear" ) ) {
            $search_term = '';
        }
        
        $this->list_of_filter_fields = '';
        
        foreach( $this->filter->fields AS $display_name => $mysql_field ) {
            
            // the mysql field may have a period in it... e.g. table.column1
            $_field = explode( '.' , $mysql_field );
            $backticked_field = '';
            foreach( $_field AS $item ) {
                
                if( $backticked_field ) {
                    $backticked_field .= '.';
                }
                
                $backticked_field .= "`$item`";
                
            }
            
            $this->list_of_filter_fields .= ( $this->list_of_filter_fields ? ', ' : '' );
            
            $this->list_of_filter_fields .= tina_mvc_esc_html_recursive($display_name);
            
            if( $search_term ) {
                
                
                if( $filter_where_clause ) {
                    $filter_where_clause .= ' OR ';
                }
                $filter_where_clause .= "$backticked_field LIKE '%$search_term%'";
                
            }
            
        }
        
        if( $filter_where_clause ) {
            
            // we might already have a WHERE clause... if so we append...
            // this is a bit Q&D... will fail if WHERE appears within a SUB SELECT for example...
            if( stripos( $this->base_sql , 'WHERE' ) === FALSE ) {
                $filter_where_clause = " WHERE ($filter_where_clause) ";
            }
            else {
                $filter_where_clause = " AND ($filter_where_clause) ";
            }
            
        }
        
        // have we an order set?
        if( $this->sort_by ) {
            $order_clause = ' ORDER BY `'.$this->wpdb->escape($this->sort_by).'` '.strtoupper( $this->sort_ord ).' ';
        }
        elseif( ! empty( $this->default_sort_by ) )  {
            $order_clause = ' ORDER BY `'.$this->wpdb->escape($this->default_sort_by).'` ';
            if( ! empty( $this->default_sort_ord ) ) {
                $order_clause .= strtoupper( $this->sort_ord ).' ';
            }
        }
        else {
            $order_clause = ' '; // default
        }
        
        // get the count of total items
        $res = $this->wpdb->get_var( $this->count_sql . $filter_where_clause );
        if( $res === FALSE ) {
            
            ob_start();
            $this->wpdb->print_error();
            $err = ob_get_clean();
            
            tina_mvc_error( 'SQL Error: '. $err );
            
        }
        $this->items_total = $res;
        
        /**
         * get the paged links
         *
         * This also sets $this->limit for the following query
         */
        parent::paginate();
        
        $sql = $this->base_sql . $filter_where_clause . $order_clause;
        if( $this->items_total ) {
            // no limit if no results is zero
            $sql .= $this->limit;
        }
        
        $this->sql_results = $this->wpdb->get_results( $sql );
        
        global $EZSQL_ERROR;
        // tmprd( $EZSQL_ERROR );
        if( $EZSQL_ERROR ) {
            $msg = $EZSQL_ERROR[0]['error_str']." // ".'Query: '.$EZSQL_ERROR[0]['query'];
            tina_mvc_error( $msg );
        }
        
    }
    
    /**
     * Set the default sort order. Must correspond to a database field name or alias
     *
     * @param string
     */
    public function set_default_sort_by( $o=FALSE ) {
        
        if( $o ) {
            $this->default_sort_by = $o;
        }
        
    }
    
    /**
     * Set the default order by as asc or desc
     *
     * @param string 'asc' or 'desc'
     */
    public function set_default_sort_order( $o='asc' ) {
        
        if( $o == 'desc' ) {
            $this->default_sort_order = 'desc';
        }
        else {
            $this->default_sort_order = 'asc';
        }
        
    }
    
    /**
     * Set the rows per page
     *
     * @param mixed an integer or 'all'
     */
    public function set_items_per_page( $i=25 ) {
        
        if( $i == 'all' ) {
            $this->items_per_page = 'all';
        }
        else {
            $this->items_per_page = intval( $i );
        }
        
    }
    
    /**
     * The base SQL to product the table of results you want
     *
     * You can name columns by using 'SELECT fieldname AS `Field Name`...' in your
     * SQL. This SQL must agree with the SQL used to get theh total number of rows
     * set in $this->set_count_from_sql().
     *
     * The SQL statement should not include 'LIMIT' or 'ORDER BY' clauses
     *
     * NB: You must pass a valid SQL statement, we do no escaping for you here
     *
     * @param string $s the sql statement
     * @see $this->set_count_from_sql()
     */
    public function set_base_sql( $s='' ) {
        
        if( ! $s ) {
            tina_mvc_error( 'We need some SQL....' );
        }
        
        $this->base_sql = $s.' ';
        
    }
    
    /**
     * Used to get sort parameters from a url
     *
     * @see $this->get_html()
     */
    private function get_sort_params_from_url( $u ) {
        
        // we have a sort parameter...
        $sort_param = explode( '-' , $u );
        if( ! empty( $sort_param[1] ) ) {
            $this->sort_by = urldecode( $sort_param[1] );
        }
        if( ! empty( $sort_param[2] ) ) {
            $this->sort_ord = ( $sort_param[2] == 'desc' ? 'desc' : 'asc' );
        }
        
    }
    
    /**
     * Set a filter box at the top of the form
     *
     * We don't do any validation that the fields are correct, but we do escape
     * them. You may filter on any fields, but it may confuse your users
     * if the fields being filtered do not appear in the display.
     *
     * @param array Fields to filter by - array ( 'Display Name' => 'mysql_field_name' )
     */
    public function filter_box_on_fields( $fields=array() ) {
        
        if( ! $fields OR ! is_array( $fields ) ) {
            tina_mvc_error('Parameter must be a non-empty array()');
        }
        
        $this->filter = new stdClass;
        $this->filter->fields = $fields;
        $this->filtering = TRUE;
        
    }
    
    /**
     * Get the html form for the filter box
     */
    private function get_filter_box_html() {
        
        if( empty($this->filtering) ) {
            return '';
        }
        
        if( tina_mvc_get_Post( "{$this->filter_post_var}_clear" ) ) {
            $search_term_escaped = '';
        }
        else {
            $search_term_escaped = tina_mvc_esc_html_recursive( $this->get_search_term($this->filter_post_var) );
        }
        
        $html = '';
        $html .= '<FORM ACTION="'.$this->base_url.'#'.$this->pager_id.'" METHOD="post">';
        $html .= '<strong>Filter by '.$this->list_of_filter_fields.': </strong><br />';
        $html .= '<INPUT TYPE="TEXT" NAME="'.$this->filter_post_var.'" VALUE="'.$search_term_escaped.'" >';
        $html .= '<INPUT TYPE="SUBMIT" NAME="'.$this->filter_post_var.'_filter" VALUE="Filter">';
        $html .= '<INPUT TYPE="SUBMIT" NAME="'.$this->filter_post_var.'_clear" VALUE="Clear">';
        $html .= '</FORM>';
        
        return $html;
        
    }
    
    /**
     * Checks $_POST and $_SESSION for search terms or
     * if user has clicked the 'clear' button
     */
    private function get_search_term() {
        
        if( tina_mvc_get_Post( "{$this->filter_post_var}_clear" ) ) {
            $_SESSION[$this->filter_post_var] = '';
            $return = '';
        }
        elseif( ($s=tina_mvc_get_Post($this->filter_post_var)) ) {
            $_SESSION[$this->filter_post_var] = $s;
            $return = $s;
        }
        elseif( $_SESSION[$this->filter_post_var] ) {
            $return = $_SESSION[$this->filter_post_var];
        }
        else {
            $return = '';
        }
        
        return $return;
    
    }
    
    /**
     * Removed sortable column headings from the final output
     *
     * This is useful if you post process your rows of results after retrieval from
     * the database. If you change column headings, or make up new fields and use
     * $this->set_html_rows() to pass them back to the pagination helper, then
     * you will break the relationship between your final rows and the rows as
     * found in the database. In that case the clickable (sortable) headings will
     * not work
     *
     * @param $columns mixed 
     */
    public function suppress_sort($colums=TRUE) {
        
        if( is_array( $colums ) ) {
            $this->do_not_allow_sort_on_these_columns = $colums;
        }
        else {
           $this->suppress_sort = (bool) $colums;
        }
        
    }
    
}

?>
