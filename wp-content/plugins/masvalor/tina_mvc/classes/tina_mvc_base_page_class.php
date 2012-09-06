<?php
/**
* The Tina base page class
*
* @package    Tina-MVC
* @subpackage Tina-Core-Classes
*/

/**
 * The Tina base page class
 *
 * Setter and getter for the Wordpress $the_post_title, $the_post_content
 * variables.
 * Also loads HTML templates, merging them with PHP variables
 *
 * @package    Tina-MVC
 * @param   array $request extracted from $_GET - /controller/action/some/data
 * @todo    set the post_title consistently throughout Tina
 * @todo prevent the __constructor() having to call the appropriate method. need $this->dispatcher() that calls a method at run time based on $request.
 * this will avoid the complete controller running before authentication checks take place. Critical for controllers using authentication
 */
class tina_mvc_base_page_class {
    
    /**
     * @var array extracted from $_GET - /controller/action/some/data
     */
    protected $request;
    
    /**
     * @var string
     */
    protected $the_post_title, $the_post_content;
    
    /**
     * @var boolean whether to use the dispatcher method after creating an instance
     * of the derived class.
     * @see $this->dispatcher()
     */
    public $use_dispatcher = FALSE;
    
    /**
     * @var string if called from a non self-closing shortcode, the content
     * @see tina_mvc_shortcode_func()
     */
    public $shortcode_content = '';
    
    /**
     * @var object View data for passing to a template. Contains 2 objects, one
     * for escaped data and one for non escaped data
     * @see $this->add_var()
     * @see $this->add_var_e()
     */
    protected $template_vars;
    
    /**
     * @var array
     */
    public $role_to_view, $capability_to_view;
    
    function __construct( $request=array() ) {
        
        //$this->template_vars = new stdClass; // for template data
        
        $this->request = $request;
        
    }
    
    /**
     * Dispatcher method
     *
     * If there is no Tina MVC request, $this->index() is called. Otherwise we look
     * for a class method based on the request. This allows you to name your class
     * methods according to your actions. e.g. controller/my-action will be mapped
     * on to $this->my_action(). Default action is always $this->index()
     *
     * You should set $this->use_dispatcher = TRUE to enable its use
     *
     * Make any methods that you do not want called by the dispatcher method 'private'
     * for security and name them with a leading underscore to prevent the dispatcher
     * from trying to load them. E.g. '_my_method'
     */
    public function dispatch() {
        
        if( ! $this->use_dispatcher ) {
            return TRUE;
        }
        
        // what action are we doing?
        // pop the first array element from $request ('user')...
        array_shift( $this->request );
        
        //die(print_r( $this->request , 1 ));
        
        if( !$this->request OR ! is_array($this->request) OR ! $this->request[0] ) {
            
            $this->index();
            
        }
        else {
            
            $method = $this->request[0];
            if( method_exists( $this , $method ) AND ( strpos($method,'_') !== 0 ) ) {
                $this->$method( $this->request );
            }
            else {
                // tina_mvc_error( 'Method '.$method.' doesn\'t exist.' );   
                $this->index( $this->request );
            }
            
        }
        
    }
    
    /**
     * Retrieve the post title after it has been set by your application (if all went well)
     *
     * @return  string
     */
    public function get_post_title() {
        
        return $this->the_post_title;
        
    }
    
    /**
     * Retrieve the post content after it has been set by your application (if all went well)
     *
     * @return  string
     */
    public function get_post_content() {

        return $this->the_post_content;
        
    }
    
    /**
     * Set the post title from your application
     *
     * @param string
     */
    public function set_post_title($str) {
        
        $this->the_post_title = $str;
        
    }
    
    /**
     * Set the post content from your application
     *
     * @param string
     */
    public function set_post_content($str) {
        
        $this->the_post_content = $str;
        
    }
    
    /**
     * Include/Parse a HTML file and return as a string
     *
     * Looks for a file in the app or  folders named {$view}_view.php and
     * includes it. Any variables passed in $V are passed to the HTML file in the
     * global scope allowing the use of <?php echo $V->whatever ? > and 
     *  < ?= $V['array'][0] ? > template constructs.
     * In fact we can use < ? foreach($array as $element): ? > < ? endforeach; ? > 
     * just like in normal PHP mixed HTML/PHP templating.
     * {$view}_view.php is intended to be a HTML file
     *
     * Alternatively you can assign template data to $this->template_vars using $this->add_var()
     * and $this->add_var_e(). If data is in $this->template_vars it will  be used in preference
     * to data passed to this function.
     *
     * You should use <code>if( !defined('TINA_MVC_LOAD_VIEW') ) die;</code> or something
     * similar to avoid being able to call the template directly.
     *
     * @param   string $view the name of the view file (without '_view.php')
     * @param  mixed $V variable (usually array or object) passed to the included file for parsing
     * @param  string $custom_folder an overriding location to load the view from (relative to the Tina MVC plugin folder)
     *
     * @return string the parsed view file (usually HTML)
     *
     * @see $this->template_vars
     * 
     * @todo Tidy this room!
     */
    public function load_view($view=false, & $V=NULL, $custom_folder='') {
        
        if( ! $view ) {
            tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' ('.__LINE__.') requires $view argument.');
        }
        
        if( is_null( $V ) ) {
            $V = & $this->template_vars;            
        }
        
        // $view is appended by _view before trying to load it...
        $view_file = $view.'_view.php';
        $my_page_view = $view_file; // default
        
        if( ! defined('TINA_MVC_LOAD_VIEW') ) define('TINA_MVC_LOAD_VIEW',true);
        
        //custom location?
        if( $custom_folder ) {
            if( file_exists( ($inc = $custom_folder.'/'.$my_page_view) ) ) {
                $finc = str_replace( TINA_MVC_PLUGIN_DIR , '' , $inc );
                ob_start();
                echo "<!--// TINA_MVC VIEW FILE START: $finc //-->\r\n";
                include( $inc );
                echo "<!--// TINA_MVC VIEW FILE END: $finc //-->\r\n";
                return ob_get_clean();
            }
            else {
                $location_error = "1) $custom_folder/$my_page_view.<br />";
            }
        }
        else {
            
            // are we called from a front end controller page?
            if( defined('TINA_MVC_PAGE_CONTROLLER_NAME') ) {
              $my_page_view = TINA_MVC_PAGE_CONTROLLER_NAME."/$view_file";
            }
            elseif( defined('TINA_MVC_PAGE_CONTROLLER_ID') ) {
              // find the page name...
              $tina_pages = get_option('tina_mvc_pages');
              $my_page_view = $tina_pages[TINA_MVC_PAGE_CONTROLLER_ID]['page_name']."/$view_file";
            }
            
            if( file_exists( ($inc = tina_mvc_find_app_folder().'/'.$my_page_view) ) ) {
                $finc = str_replace( TINA_MVC_PLUGIN_DIR , '' , $inc );
                ob_start();
                echo "<!--// VIEW FILE START: $finc //-->\r\n";
                include( $inc );
                echo "<!--// VIEW FILE END: $finc //-->\r\n";
                return ob_get_clean();
            }
            elseif( file_exists( ($inc = tina_mvc_find_app_folder().'/'.$view_file) ) ) {
                $finc = str_replace( TINA_MVC_PLUGIN_DIR , '' , $inc );
                ob_start();
                echo "<!--// VIEW FILE START: $finc //-->\r\n";
                include( $inc );
                echo "<!--// VIEW FILE END: $finc //-->\r\n";
                return ob_get_clean();
            }
            // used only if get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') set
            elseif( get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') ) {
                
                if( ! ( file_exists( ($inc = TINA_MVC_SECONDARY_APP_FOLDER.'/'.$my_page_view) ) ) ) {
                    $inc = TINA_MVC_SECONDARY_APP_FOLDER.'/'. $view_file;
                }
                
                $finc = str_replace( TINA_MVC_PLUGIN_DIR , '' , $inc );
                ob_start();
                echo "<!--// VIEW FILE START: $finc //-->\r\n";
                include( $inc );
                echo "<!--// VIEW FILE END: $finc //-->\r\n";
                return ob_get_clean();
            }
            elseif( file_exists( ($inc = tina_mvc_find_tina_mvc_folder().'/app/'.$view_file) ) ) {
                $finc = str_replace( TINA_MVC_PLUGIN_DIR , '' , $inc );
                ob_start();
                echo "<!--// VIEW FILE START: $finc //-->\r\n";
                include( $inc );
                echo "<!--// VIEW FILE END: $finc //-->\r\n";
                return ob_get_clean();
            }
            elseif( is_string($V) ) {
                ob_start();
                echo "<!--// LOAD_VIEW() START: (no view file) //-->\r\n";
                echo $V;
                echo "<!--// LOAD_VIEW() END: (no view file) //-->\r\n";
                return ob_get_clean();
            }
            else {
                $location_error = "1) ".tina_mvc_find_app_folder().'/'.$my_page_view."<br />";
                $location_error .= "2) ".tina_mvc_find_app_folder().'/'.$view_file."<br />";
                
                if( get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') ) {
                    $location_error .= "2b) ".TINA_MVC_SECONDARY_APP_FOLDER.'/'.$my_page_view."<br />";
                    $location_error .= "2c) ".TINA_MVC_SECONDARY_APP_FOLDER.'/'.$view_file."<br />";
                }
                
                $location_error .= "3) ".tina_mvc_find_tina_mvc_folder().'/app/'.$view_file."<br />";
                $location_error .= "Also template variables were not a string and cannot be used in the Wordpress post content. This is what we got:";
                $location_error  .= "<pre><small>".print_r($V,1)."</small></pre>";
            }
            
        }
        
        // if we got here we have an error...
        $err_msg = '<h1>'.__FILE__.' :: '.__FUNCTION__.' ('.__LINE__.')</h1>';
        $err_msg .= "<strong>View '$view_file' not found. Looked for:<strong><br />";
        $err_msg .= $location_error;
        return $err_msg;
       
    }
    
    /**
     * Add a variable to $this->template_vars
     *
     * Allows you to drop your template variables into an object for retrieval by
     * $this->load_vew()
     *
     * The key is added as a property of (object) $this->template_vars
     *
     * @param   string $key the object property name to use when adding data
     * @param   mixed $v variable to add
     * @param   boolean $esc whether to escape data or not
     * @return  boolean
     * @see $this->template_vars
     * @see $this->add_var_e()
     * @see $this->load_view()
     */
    public function add_var( $key=NULL, $v=NULL , $esc=FALSE ) {
        
        if( is_null($key) ) {
            tina_mvc_error( '$key parameter is required.' );
        }
        
        if( $esc ) {
            $v = tina_mvc_esc_html_recursive( $v );
        }
        
        $this->template_vars->$key = $v;
        
    }
    
    /**
     * Add an escaped variable to $this->template_vars
     *
     * Any variables added using this will be escaed. Allows you to drop your
     * template variables into an object for retrieval by $this->load_vew()
     *
     * @param   string $key the object property name to use when adding data
     * @param   mixed $v variable to add
     * @return  boolean
     * @see $this->template_vars
     * @see $this->add_var()
     * @see $this->load_view()
     * @see tina_mvc_esc_html_recursive()
     */
    public function add_var_e( $key=NULL, $v=NULL ) {
        
        if( is_null($key) ) {
            tina_mvc_error( '$key parameter is required.' );
        }        
        
        $this->add_var( $key , $v , TRUE );
        
        return TRUE;
        
    }
    
    /**
     * Check if a view file exists
     *
     * Looks for a file in the app folder named {$view}_view.php.
     *
     * @param   string $view the name of the view file (without '_view.php')
     * @return  bool
     */
    public function view_file_exists($view=false) {
        
        if(!$view) {
            tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' ('.__LINE__.') requires $view argument.');
        }
        
        // $view is appended by _view before trying to load it...
        $view_file = $view.'_view.php';

        if( file_exists( ( tina_mvc_find_app_folder().'/'.$view_file) ) ) {
          return TRUE;
        }
        elseif( file_exists( ($inc = tina_mvc_find_tina_mvc_folder().'/app/'.$view_file) ) ) {
          return TRUE;
        }
        else {
          return FALSE;
        }
        
    }

    /**
     * Load a Tina MVC Model and return an instance
     *
     * Looks for a file in the app or  folders named {$model}_model.php and
     * includes it
     *
     * @param   string $model the name of the model file (without '_model.php')
     * @return  object an instance of the model class
     * @todo    move the logic that looks for the view file into a loader function. We should include all autoad actions (classes, views, models) into it to allow for expansion into library files, classes, css, etc 
     */
    public function load_model( $model=false ) {
        
        if(!$model) {
            tina_mvc_error(__FILE__.' :: '.__FUNCTION__.' ('.__LINE__.') requires $model argument.');
        }
        
        // $model is appended by _model before trying to load it...
        $model_file = $model.'_model.php';
        $my_model = $model_file; // default
            
        // are we called from a front end controller page?
        if( defined('TINA_MVC_PAGE_CONTROLLER_NAME') ) {
          $my_model = TINA_MVC_PAGE_CONTROLLER_NAME."/$model_file";
        }
        elseif( defined('TINA_MVC_PAGE_CONTROLLER_ID') ) {
          // find the page name...
          $tina_pages = get_option('tina_mvc_pages');
          $my_model = $tina_pages[TINA_MVC_PAGE_CONTROLLER_ID]['page_name']."/$model_file";
        }
        
        if( file_exists( ($inc = tina_mvc_find_app_folder().'/'.$my_model) ) ) {
            include_once( $inc );
        }
        elseif( file_exists( ($inc = tina_mvc_find_app_folder().'/'.$model_file) ) ) {
            include_once( $inc );
        }
        // used only if get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') set
        elseif( get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') ) {
            
            if( ! ( file_exists( ($inc = TINA_MVC_SECONDARY_APP_FOLDER.'/'.$my_model) ) ) ) {
                $inc = TINA_MVC_SECONDARY_APP_FOLDER.'/'. $model_file;
            }
            
            include_once( $inc );
            
        }
        elseif( file_exists( ($inc = tina_mvc_find_tina_mvc_folder().'/app/'.$model_file) ) ) {
            include_once( $inc );
        }
        else {
            $err_msg = __FILE__.' :: '.__FUNCTION__.' ('.__LINE__.")\r\n";
            $err_msg .= "Model '$model_file' not found. Looked for:\r\n";
            $err_msg .= "1) ".tina_mvc_find_app_folder().'/'.$my_model."\r\n";
            $err_msg .= "2) ".tina_mvc_find_app_folder().'/'.$model_file."\r\n";
            if( get_option('tina_mvc_enable_multisite') AND get_option('tina_mvc_multisite_app_cascade') ) {
                $err_msg .= "2a) ".TINA_MVC_SECONDARY_APP_FOLDER.'/'.$my_model."\r\n";
                $err_msg .= "2b) ".TINA_MVC_SECONDARY_APP_FOLDER.'/'.$model_file."\r\n";
            }
            $err_msg .= "3) ".tina_mvc_find_tina_mvc_folder().'/app/'.$model_file;
            tina_mvc_error( $err_msg );
        }
        
        $model_class = $model.'_model';
        return new $model_class();
       
    }

}









?>