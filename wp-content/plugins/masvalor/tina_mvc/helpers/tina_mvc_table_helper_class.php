<?php
/**
 * Table Helper class file
 *
 * Builds a html table from your data
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Helpers
 * @author     Francis Crossen <francis@crossen.org>
 */

/**
 * Table Helper class file
 *
 * Builds a HTML table of results from data
 *
 * Column headings are taken from the array keys or object properties
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Helpers
 * @param   string $tablename a unique name for the form
 */
class tina_mvc_table_helper {
    
    var $html;
    var $data;
    var $tablename;
    var $do_not_esc_th;
    var $do_not_esc_td;

    /**
     * Constructor
     *
     * Sets up the table
     *
     * @param   string $tablename  unique name for the table e.g. 'users-list'
     */
    function __construct( $tablename=false ) {
        
        if(!$tablename) { tina_mvc_error("tina_mvc_table_helper_class Error: tina_mvc_table_helper_class requires the \$tablename parameter."); }
        
        $this->tablename = $tablename;
        
        $this->do_not_esc_th = FALSE;
        
    }
    
    /**
     * Set the data you wish to display
     *
     * @param mixed $data An array or object of data you want to display
     */
    public function set_data( $data = array() ) {
        
        $this->data = $data;
        
    }
    
    /**
     * Build the table and return HTML ready to echo to the browser
     *
     * @return string The HTML table
     */
    public function get_html() {
        
        $this->html = "<table id=\"{$this->tablename}\" class=\"tina_mvc_table\">";
        
        $this->html .= "<thead>";
        foreach( $this->data AS & $row ) {
            $this->html .= "<tr>";
            foreach( $row AS $f_name => & $f_value ) {
                
                if( $this->do_not_esc_th ) {
                    $this->html .= '<th>'.$f_name.'</th>';
                }
                else {
                    $this->html .= '<th>'.tina_mvc_esc_html_recursive($f_name).'</th>';
                }
                
            }
            $this->html .= "</tr>";
            break;
        }
        $this->html .= "</thead>";
        
        reset( $this->data );
        
        $this->html .= "<tbody>";
        foreach( $this->data AS & $row ) {
            $this->html .= "<tr>";
            foreach( $row AS $f_name => & $f_value ) {
                
                if( $this->do_not_esc_td ) {
                    $this->html .= '<td>'.$f_value.'</td>';
                }
                else {
                    $this->html .= '<td>'.tina_mvc_esc_html_recursive($f_value).'</td>';
                }
                
            }
            $this->html .= "</tr>";
        }
        $this->html .= "</tbody>";
        
        $this->html .= '</table>';
        
        return $this->html;
        
    }
    
    /**
     * Prevent escaping of the table headings
     *
     * These are taken from the array keys or object properties of
     * the data you have entered. You might want to pass HTML in which case you
     * do not want the text escaped.
     */
    public function do_not_esc_th( $tf=FALSE ) {
        
        $this->do_not_esc_th = (bool) $tf;
        
    }
    
    /**
     * Prevent escaping of the table cells
     *
     * These are taken from the array keys or object properties of
     * the data you have entered. You might want to pass HTML in which case you
     * do not want the text escaped.
     */
    public function do_not_esc_td( $tf=FALSE ) {
        
        $this->do_not_esc_td = (bool) $tf;
        
    }
    
}

?>