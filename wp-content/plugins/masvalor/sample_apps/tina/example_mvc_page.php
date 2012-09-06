<?php
/**
* A page controller using MVC
*
* This shows how to use built in functions to store variables for use in a page
* template (view file).
*
* 
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* A simple example of how to assign variables to a template/view and display it
*
* Access it at: /tina-mvc-for-wordpress/example-mvc
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @uses         example_mvc_view.php the example_mvc view file
*/
class example_mvc_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );            
            
        /**
         * This is what enables the dispatcher function. Your method will be called AFTER
         * permissions checks have been completed.
         *
         * Default method is $this->index()
         */
        $this->use_dispatcher = TRUE;
        
    }
    
    public function index() {
        
        /**
         * Some data that requires html escaping
         */
        $sample_unescaped_view_data = array('var1' => 'these should be escaped: & < > (ampersand, less-than, greater-than )',
                                            'arrVar' => array( 1,2,3 ),
                                            'var2' => 'Should match (first bit has been manually escaped, second part has not): &lt;em&gt;NOT emphasised&lt;/em&gt; == <em>NOT emphasised</em>',
                                  );
        
        /**
         * Add it to the page template variable property and escape
         */
        $this->add_var_e( 'var_e' , $sample_unescaped_view_data );
        
        /**
         * Some data that is already escaped
         */
        $sample_view_data = 'Following text should appear bold: <b>BOLD</b>';
        
        /**
         * Add it to the page template variable
         */
        $this->add_var( 'var_valid' , $sample_view_data );
        
        /**
         * Some unescaped data
         */
        $sample_invalid_view_data = 'Following is unescaped: & <script>alert(\'Tina says: careful passing unescaped data to your view file!\');</script>';
        
        /**
         * Add it to the page template variable (the wrong way)
         */
        $this->add_var( 'var_invalid' , $sample_invalid_view_data );
        
        /**
         * Because we are not passing view data to the load_view() method, the data
         * in $this->template_vars is used instead.
         *
         * The functions add_var_e() and add_var() add data as object properties of
         * $this->template_vars
         */
        $this->set_post_content( $this->load_view('example_mvc') );
        
        $this->set_post_title('Page title...');
        
    }

}


?>