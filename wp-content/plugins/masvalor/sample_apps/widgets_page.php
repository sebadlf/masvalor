<?php
/**
* Some sample widgets
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A class of widgets
*
* It can be handy to keep them all together in one class
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/
class widgets_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );
        $this->use_dispatcher = true;
        
    }
    
    /**
     * Gets a list of child and grandchild pages of the current page
     */
    function page_list() {
        
        array_shift( $this->request ); // 'page_list' controller request
        
        // have we been passed a parent_id to use?
        if( !($parent_id = intval( array_shift( $this->request ) ) ) ) {
            global $post;
            $parent_id = $post->ID;
        }
        
        $out = wp_list_pages( array( 'echo'=>0 , 'sort_column'=>'menu_order' , 'child_of'=>$parent_id , 'title_li'=>' ' ) );
        
        /**
         * $out contains html - no need to escape. We just replace the content with it.
         */
        $this->set_post_content($out);
        
    }

}


?>
