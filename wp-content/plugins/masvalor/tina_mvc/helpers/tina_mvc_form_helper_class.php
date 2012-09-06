<?php
/**
* Form Helper class file
*
* Builds a form, checks and validates $_POST and $_GET variables and generates HTML for
* you
*
* @package    Tina-MVC
* @subpackage Tina-Core-Helpers
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * Form generation, validation class
 *
 * Builds a form, checks and validates $_POST variables and generates HTML for
 * you
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Helpers
 * @param   string $formname a unique name for the form
 * @param   bool $checkGet loog in $_GET?
 * @param   bool $doXML use XML entity endings?
 * @param   string $formaction where to send the form (defults to here)
 * @todo    catch recaptch file include() and incorrect public/private key errors
 * @todo    move the recaptcha include statement into this class
 * @todo    add the ability to prevent escaping for other messages???
 * @todo    add the ability to clear all form field values in case we want to display a blank form AFTER a user has submitted successfully
 * @todo    use the PHP Filter Functions once we can rely on having PHP >= 5.2
 */
class tina_mvc_form_helper_class {

    protected $formname, $message, $errors, $default_GPC_cleaner, $form_data, $recaptcha, $form_posted, $doXML, 
            $valid_field_types = array('TEXT','PASSWORD','CHECKBOX','RADIO','HIDDEN','SELECT','TEXTAREA','SUBMIT','RECAPTCHA','RESET','FILEUPLOAD','GMAP_LOCATION'),
            $fields_treated_as_buttons = array('SUBMIT','RESET'), 
            $valid_validation_rules = array('REQUIRED','EMPTY','MAX_STRLEN','MIN_STRLEN',
                                            'NEGATIVE','POSITIVE','INTEGER','MAX_VAL','MIN_VAL',
                                            'EMAIL','SQL_DATETIME','SQL_DATE', 'SQL_TIME','SQL_SHORT_TIME',
                                            'EQUALTOFIELD','GREATERTHANFIELD','LESSTHANFIELD',
                                            'REGEXP','RECAPTCHA'),
            $gmaps_js_already_added;
    /**
     * The $html_form* variables are used to style HTML. The strings are
     * run through sprintf to produce the final result.
     *
     * You can override them directly after you instantiate the form.
     *
     * @see get_form_html()
     */
    public $html_form = '<div class="tina_mvc_form">%s</div>',
           $html_form_message = '<div class="tina_mvc_form_message">%s</div>',
           $html_form_error = '<div class="tina_mvc_form_error_message">%s</div>',
           $html_form_pair = '<div class="tina_mvc_form_pair">%s</div>',
           $html_form_required_after_label = '',
           $html_form_required_after_input = ' (required) ',
           $html_form_label = '<span class="tina_mvc_form_label">%s </span>',
           $html_form_input = '<span class="tina_mvc_form_input">%s</span>',
           $html_form_radio_set = '<span class="tina_mvc_form_radio_set">%s</span>',
           $html_form_field_error = '<span class="tina_mvc_error">%s </span>',
           $html_form_field_message = '<div class="tina_mvc_form_field_message">%s</div>', // unused
           $html_form_button = '<div class="tina_mvc_form_button">%s</div>';
           
    /**
     * @var string Anything here is appended to the form after the closing form tag
     *
     * Currently used to add Google Map javascript.
     */
    public $html_form_append;
    
    /**
     * Constructor
     *
     * Sets up the form
     *
     * @param   string $formname a  unique name for the form e.g. 'new-user-form'
     * @param   bolean $checkGet whether or not to check $_GET as well as $_POST (untested)
     * @param   bolean $doXML add XML endings to tags like <br />
     * @param   string $formaction only required if the form is being posted elsewhere
     */
    function __construct( $formname=false, $checkGet=false, $doXML=false, $formaction=FALSE ) {
        
        if(!$formname) { echo ("tina_mvc_form_helper_class Error: tina_mvc_form_helper_class requires the \$formname parameter."); }
        
        $this->formname = str_replace( array(' ','-') , '', $formname );
        $this->message = false;
        $this->validation_errors = FALSE;
        $this->form_posted = null;
        $this->default_GPC_cleaner = false;
        $this->form_data->action = ( $formaction ? $formaction : $_SERVER['REQUEST_URI'] );
        $this->form_data->method = 'post';
        $this->form_data->enctype = 'enctype="application/x-www-form-urlencoded"';
        $this->form_data->check_Get = $checkGet;
        $this->doXML =  ( $doXML ? ' /' : '' );
        $this->html_form_append = '';
        $this->gmaps_js_already_added = FALSE;
        
        $this->add_framework_fields();
        
    }
    
    /**
     * Change the form name on clone
     *
     * @todo make this work!!!
     */
    function __clone() {
        
        tina_mvc_error('Not implemented');
       
       // check if we have a number at the end of the form
       if( ($c_pos = strrpos( $this->formname , '_' )) ) {
        $possible_numeric_bit = substr( $this->formname , $c_pos+1 );
        if( intval( $possible_numeric_bit ) ) {
            $possible_numeric_bit++;
        }
        else {
            $possible_numeric_bit = 1;
        }
        $this->formname = substr( $this->formname , 0 , $c_pos );
       }
       
       $this->formname .= '_'.$possible_numeric_bit;
       
    }
    
    private function add_framework_fields() {
        
        // a wp none field...
        $this->add_field( 'WP_NONCE', 'hidden', false, '_WP_NONCE', false, wp_create_nonce( $this->formname ) );
        // a flag to tell if we have been posted...
        $this->add_field( 'POSTED', 'hidden', false, '_POSTED_FLAG', false, '1' );
        
    }
    
    /**
     * Returns TRUE if the form was posted
     */
    public function form_posted() {
        return $this->have_we_been_posted();
    }

    /**
     * Returns TRUE if the form was posted with errors
     */
    public function form_errors() {
        return $this->errors;
    }
    
    private function have_we_been_posted() {
        if( is_null($this->form_posted) ) {
            $this->check_framework_fields();
        }
        return $this->form_posted;
    }

    private function check_framework_fields() {
        
        $post_var_name1 = $this->make_field_post_var_name('POSTED');
        $post_var_name2 = $this->make_field_post_var_name('WP_NONCE');
        
        $this->form_posted = ( tina_mvc_get_Post($post_var_name1) AND wp_verify_nonce( tina_mvc_get_Post($post_var_name2), $this->formname ) );
        
    }

    /**
     * Add a field to the form
     *
     * @param   string $field_name a unique name for the field. The HTML label, id and name are constructed from this
     * @param   string $field_type see $this->valid_field_types for a list
     * @param   string $field_caption Specify text for form field's label. empty string or NULL to supress, otherwise one will be automagically generated
     * @param   string $db_table a table name. Use this to group fields
     * @param   string $db_field the field name, if different from the $field_name
     * @param   string $default a default value to use - overridden by $_POST and $_GET values or by using $this->load_field_data_array()
     * @param   string $extra_html_attributes added to the INPUT element. Use for things like javascript, READONLY, DISABLED attributes, etc
     */
    public function add_field( $field_name=false, $field_type=false, $field_caption=false, $db_table='NONE', $db_field=false, $default=false, $extra_html_attributes='' ) {
        
        if(!$field_name) {
            tina_mvc_error("tina_mvc_form_helper_class->add_field() requires the \$field_name parameter.");
        }
        
        $_field_name_test = str_replace( array('-','_') ,'', $field_name );
        if( !ctype_alnum($_field_name_test) ) {
            tina_mvc_error("tina_mvc_form_helper_class->add_field( \$field_name='$field_name' ): \$field_name must only contain [a-zA-Z-_].");
        }
        
        if(!$field_type) {
            tina_mvc_error("tina_mvc_form_helper_class->add_field() requires the \$field_type parameter.");
        }
        
        if( ! in_array( strtoupper($field_type), $this->valid_field_types )) {
          tina_mvc_error("tina_mvc_form_helper_class->add_field() '$field_type' is not a valid field type.");
        }

        if($field_caption === false) {
            $field_caption = ucwords( str_replace( array('-','_'), ' ', $field_name ) );
        }        
        
        if(!$db_field) {
          $db_field = $field_name;
        }
        
        if( strtoupper($field_type) == 'GMAP_LOCATION' ) {
            
            // cannot allow a hyphen in here - will cause javascript to fail
            if( strpos( $field_name , '-' ) !== FALSE ) {
                tina_mvc_error("tina_mvc_form_helper_class->add_field( \$field_name='$field_name' ): GMAP_LOCATION field name cannot contain hyphens.");
            }
            
            // is there a default value set?
            if( $default ) {    
                // split on comma...
                $_d = explode( ',' , $default );
                if( count( $_d ) != 3 ) {
                    tina_mvc_error("tina_mvc_form_helper_class->add_field() gmap_location value should be (string) 'latitude,longitude,zoom'.");
                }
                
            }
            else {
                $_d = array( 53.34703138449774, -6.280158281326294, 2 );
            }
            
            // set up the hidden fields
            $this->add_field( $field_name.'_lat' , 'hidden' , false , $db_table , $db_field.'_lat' , $_d[0], 'id="'.$this->make_field_id($field_name.'_lat').'"' );
            $this->add_field( $field_name.'_lng' , 'hidden' , false , $db_table , $db_field.'_lng' , $_d[1], 'id="'.$this->make_field_id($field_name.'_lng').'"' );
            $this->add_field( $field_name.'_zoom' , 'hidden' , false , $db_table , $db_field.'_zoom' , $_d[2], 'id="'.$this->make_field_id($field_name.'_zoom').'"' );
            
        }
        
        if(empty($this->form_data->fields->$field_name)) {
            if( strtoupper($field_type) == 'RECAPTCHA' ) {
                // make sure we have api keys defined...
                if( ! get_option('tina_mvc_recaptcha_pub_key') ) {
                    tina_mvc_error("tina_mvc_form_helper_class->add_field() '$field_type' requires reCaptcha api keys to be defined in tina_mvc_app_settings.php.");
                }
                /**
                 * reCathcha.net libs
                 */
                require_once( tina_mvc_find_libs_folder().'/recaptcha/recaptchalib.php');                
                $this->form_data->fields->$field_name->db_table = '_RECAPTCHA';  // no need to confuse it with the users table data...
                // while we are at it we will add a validation rule...
                $this->add_validation_rule( $field_name, 'recaptcha', NULL );
            }
            elseif( strtoupper($field_type) == 'FILEUPLOAD' ) {
                $this->form_data->enctype = 'enctype="multipart/form-data"';
                $this->form_data->fields->$field_name->db_table = $db_table;
            }
            else {
                $this->form_data->fields->$field_name->db_table = $db_table;
            }
            
            $this->form_data->fields->$field_name->db_field = $db_field;
            $this->form_data->fields->$field_name->post_var_name = $this->make_field_post_var_name( $field_name );
            $this->form_data->fields->$field_name->extra_html_attributes = $extra_html_attributes;
        }
        else {
          tina_mvc_error("tina_mvc_form_helper_class->add_field() '$field_name' already exists.");            
        }
        
        $this->form_data->tables->$db_table->$db_field = '';
        
        $this->form_data->fields->$field_name->field_type = $field_type;
        $this->form_data->fields->$field_name->field_caption = $field_caption;
        
        $this->form_data->fields->$field_name->field_value = $default;
        $this->form_data->tables->$db_table->$db_field = $default;
        $field_value = $this->get_field_value($field_name); // this also checks the posted values...        
        
    }
    
    /****
     * Get the value of a field...
     *  - also updates the field value if a POST value is submitted.
     */
    private function get_field_value( $fname ) {
        
        $val = $this->form_data->fields->$fname->field_value; // is set to FALSE by default when we $this->add_input()
        
        if( $this->have_we_been_posted() ) {
            
            if( strtoupper($this->form_data->fields->$fname->field_type) == 'FILEUPLOAD' ) {
                $val = $this->get_uploaded_file_data( $fname );
            }
            else{
                // look in GET/POST first...
                if( $this->form_data->check_Get AND (($_v=tina_mvc_get_Get( $this->form_data->fields->$fname->post_var_name )) !== FALSE )  ) {
                    $val = $_v;
                }
                elseif( ($_v=tina_mvc_get_Post( $this->form_data->fields->$fname->post_var_name)) !== FALSE ) {
                    $val = $_v;
                }
            }
            
        }
        
        $this->form_data->fields->$fname->field_value = $val;
        // in the DB data array...
        $table_name = $this->form_data->fields->$fname->db_table;
        $db_field_name = $this->form_data->fields->$fname->db_field;
        
        $this->form_data->tables->$table_name->$db_field_name = $val;
        
        return $val;
    
    }
    
    /****
     * Get the posted value of a field. Returns FALSE if the form was NOT posted.
     *
     * Use this to tell if a certain submit button was pressed, for example a cancel button. Note you
     * may not use this to get an uploaded file. Use get_uploaded_file_data() instead
     */
    public function get_posted_field_value( $fname ) {
        
        if( ! ( $this->have_we_been_posted() ) ) {
            return FALSE;
        }
        
        if( strtoupper($this->form_data->fields->$fname->field_type) == 'FILEUPLOAD' ) {
            tina_mvc_error( 'Use get_uploaded_file_location() with file uploads.' );
        }
        
        if( $this->form_data->check_Get ) {
            return( tina_mvc_get_Get($this->form_data->fields->$fname->post_var_name) );
        }
        else {
            return( tina_mvc_get_Post($this->form_data->fields->$fname->post_var_name) );
        }
        
    }
    
    /**
     * Retrieve the location of a file upload
     *
     * @param string $fname the field name
     * @return array the relevant entry from the $_FILES superglobal
     */
    public function get_uploaded_file_data( $fname ) {
        
        if( ! $this->have_we_been_posted() ) {
            tina_mvc_error( 'Cannot use this function before the form has been posted.' );
        }
        if(empty($this->form_data->fields->$fname)) {
            tina_mvc_error( "Field '$fname' doesn't exist." );
        }
        
        if( ! array_key_exists( $this->form_data->fields->$fname->post_var_name , $_FILES ) ) {
            tina_mvc_error( "\$_FILES[] entry is empty for field '$fname'. (Using \$_FILES['.".$this->form_data->fields->$fname->post_var_name.".']." );
        }
        return $_FILES[$this->form_data->fields->$fname->post_var_name];
        
    }

    /**
     * Add radio options to a RADIO field type
     *
     * @param   string $fname the field name
     * @param   array $radio_options array( array( 'display_value'=>'foo', 'post_value'=>'bar' ) )
     */
    public function add_radio_options( $fname=false, $radio_options=false ) {

        if(!$fname OR !$radio_options ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_radio_options() requires the \$fname and \$radio_options parameters.");
        }
        if(!isset($this->form_data->fields->$fname)) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_radio_options() field '$fname' doesn't exist - use tina_mvc_form_helper_class->add_field() first.");
        }

        $selected_field_val = $this->get_field_value( $fname );
        
        // loop throught array of radio options results and form an array of options...
        $r = array();
        foreach ($radio_options as $key => $value) { // loops through each row...
            $selected = ( $selected_field_val == $value );
            $r[] = array( 'display_value'=>$key, 'post_value'=>$value, 'selected'=>$selected);
        }
        
        $this->form_data->fields->$fname->field_html_radio_options = $r;
        
        return true;
        
    }

    /**
     * Add select options to a SELECT field type
     *
     * @param   string $fname the field name
     * @param   array $radio_options array( array( 'display_value'=>'foo', 'post_value'=>'bar' ) )
     */
    public function add_select_options( $fname=false, $select_options=false ) {

        if(!$fname OR !$select_options ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_select_options() requires the \$fname and \$select_options parameters.");
        }
        if(!isset($this->form_data->fields->$fname)) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_select_options() field '$fname' doesn't exist - use tina_mvc_form_helper_class->add_field() first.");
        }

//        die( print_r($select_options,1) );
        // grab the field value...
        $selected_field_val = $this->get_field_value( $fname );
        
        // loop throught array of radio options results and form an array of options...
        $r = array();
        foreach ($select_options as $key => $value) { // loops through each row...
            $selected = ( $selected_field_val == $value );
            $r[] = array( 'display_value'=>$key, 'post_value'=>$value, 'selected'=>$selected);
        }
        
        $this->form_data->fields->$fname->field_html_select_options = $r;
        
        return true;
        
    }

    /**
     * Add a validation rule to a field
     *
     * @param   string $fname the field name
     * @param   string $rule the rule name. See $this->valid_validation_rules
     * @param   mixed $args any required rule arguments. Usually a scalar value
     */
    public function add_validation_rule($fname,$rule,$args) {
        
        if(!$fname OR !$rule) {
            tina_mvc_error("tina_mvc_form_helper_class->add_validation_rules() requires the \$fname and \$rules parameters.");
        }
        if(!isset($this->form_data->fields->$fname)) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_validation_rules() field '$fname' doesn't exist - use tina_mvc_form_helper_class->add_field() first.");
        }
        
        if( !in_array(strtoupper($rule),$this->valid_validation_rules) ) {
            tina_mvc_error("tina_mvc_form_helper_class->add_validation_rules() - rule '".$rule."' does not exist.");
        }
        
        // handy for marking required fields later...
        if( strtoupper($rule) == 'REQUIRED' ) {
            $this->form_data->fields->$fname->required = TRUE;
        }
        
        $v_rule = array( 'rule'  => strtoupper($rule), 'parameters' => $args);
        
        $this->form_data->fields->$fname->validation_rules[] = $v_rule;
        
    }

    /**
     * Add an array of validation rules to a field
     *
     * @param   string $fname the field name
     * @param   array $rules an array of rule = array($rule => $args)
     * @uses    $this->add_validation_rule()
     */
    public function add_validation_rules( $fname=false, $rules=array() ) {
        
        if(!is_array($rules) OR !$rules) {
            tina_mvc_error("tina_mvc_form_helper_class->add_validation_rules() - \$rules parameter must be an array( '{rule_type}'=>'{rule_arguments}' ).");
        }

        foreach( $rules as $rule => $args ) {
            
            $this->add_validation_rule( $fname, $rule, $args );
            
        }
        
        return true;
        
    }

    /**
     * Generate the HTML for the form
     *
     * Also checks if the form has been posted and loads any posted variables. If
     * validation rules have been set they will be processed and error messages will be included in the HTML.
     *
     * If all went well and there are no validation errors, $this->validation_errors will be false and
     * the data will be available using $this->get_table_data($table_name).
     *
     * The HTML generated is always available via $this->get_form_html().
     */
    public function build_form() {
        
        /**
         * we will only run the validation rules if posted
         */        
            // the loop for validation checks
            foreach( $this->form_data->fields AS $field_name => $field_data ) {
                
                if( $this->have_we_been_posted() ) {
                    
                    // for gmap_location fields we need to check the hidden fields and set the parent meta field value accordingly
                    if( strtoupper( $field_data->field_type ) == 'GMAP_LOCATION' ) {
                        
                        $_v = floatval( $this->get_field_value( $field_name.'_lat' ) ) . ','
                              . floatval( $this->get_field_value( $field_name.'_lng' ) ) . ','
                              . intval( $this->get_field_value( $field_name.'_zoom' ) );
                        
                        $this->form_data->fields->$field_name->field_value = $_v;
                        
                        // where's the table?
                        $_db_table = $this->form_data->fields->$field_name->db_table;
                        $_db_field = $this->form_data->fields->$field_name->db_field;
                        
                        $this->form_data->tables->$_db_table->$_db_field = $_v;
                        
                    }
                    
                    // $html_BR = '<br'.$this->doXML.'>';
                    // check for validation errors...
                    if( isset($field_data->validation_rules) ) {
                        foreach( $field_data->validation_rules AS $rule ) {
                            
                            $val_fnc_name = 'validate_as_'.$rule['rule'];
                            
                            if( $failure_string = $this->$val_fnc_name( $field_name ) ) {
                                
                                $this->add_field_error_message($field_name,$failure_string);
                                
                            }
                            
                        }
                    }
                }
                                
                if( $this->form_data->fields->$field_name->html_input = $this->add_input( $field_name ) ) {
                    $this->form_data->fields->$field_name->html_label = $this->add_label( $field_name );
                }
             
            }
        
    }
    
    /**
     * Add descriptive text to a field
     *
     * @param   string $field_name the field name
     * @param   string $text the descriptive text
     * @param   boolean $add_before_input Place the description above or below the field
     */
    public function add_field_descriptive_text($field_name=FALSE,$text=FALSE,$add_before_input=TRUE) {
        
        if( ($field_name===FALSE) OR ($failure_string===FALSE) ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_field_descriptive_text() requires the \$field_name and \$failure_string parameters to be !== FALSE.");
        }
        
        $html_BR = '<br'.$this->doXML.'>';
        
        if( !isset($this->form_data->fields->$field_name->descriptive_text) ) {
            $this->form_data->fields->$field_name->descriptive_text = '';
        }
        else {
            $this->form_data->fields->$field_name->descriptive_text .= $html_BR;
        }
        $this->form_data->fields->$field_name->descriptive_text .= $text;
        $this->form_data->fields->$field_name->descriptive_text_before_input = $add_before_input;
        
    }
    
    /**
     * Add an error message to a field
     *
     * Also sets $this->validation_errors = true. This allows you to arbitrarily trigger
     * validation errors if you want to do any custom validation rules in your code
     * 
     * @param   string $field_name the field name
     * @param   string $failure_string the error message
     */
    public function add_field_error_message($field_name=FALSE,$failure_string=FALSE) {
        
        if( ($field_name===FALSE) OR ($failure_string===FALSE) ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_field_error_message() requires the \$field_name and \$failure_string parameters to be !== FALSE.");
        }

        $html_BR = '<br'.$this->doXML.'>';
        
        if( !isset($this->form_data->fields->$field_name->error_message) ) {
            $this->form_data->fields->$field_name->error_message = '';
        }
        else {
            $this->form_data->fields->$field_name->error_message .= $html_BR;
        }
        $this->form_data->fields->$field_name->error_message .= '\''.$this->form_data->fields->$field_name->field_caption .'\' '. $failure_string;
        $this->validation_errors = TRUE;
        
    }
    
    /**
     * Add an error message to the top of the form
     *
     * Also sets $this->validation_errors = true. This allows you to arbitrarily trigger
     * validation errors if you want to do any custom validation rules in your code
     * 
     * @param   string $error_string the error message
     * @param   boolean $escape set to false to prevent the message from being sanitised/escaped
     * @todo    code the escape feature - it is an aspiration at the moment!
     */
    public function add_form_error_message($error_string=FALSE, $escape=true) {
        
        if( ($error_string===FALSE) ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_form_error_message() requires \$error_string parameters to be !== FALSE.");
        }
        
        $html_BR = '<br'.$this->doXML.'>';
        
        if( !isset($this->form_data->form_error_message ) ) {
            $this->form_data->form_error_message = '';
        }
        else {
            $this->form_data->form_error_message .= $html_BR;
        }
        $this->form_data->form_error_message .= $error_string;
        $this->validation_errors = TRUE;
        
    }
    
    /**
     * Add a message to the top of the form
     *
     * Allows you to display a message WITHOUT setting $this->validation_errors = true.
     * For displaying messages
     * 
     * @param   string $message_string the message
     * @param   boolean $escape set to false to prevent the message from being sanitised/escaped
     * @todo    code the escape feature - it is an aspiration at the moment!
     */
    public function add_form_message($message_string=FALSE,$escape=true) {
        
        if( ($message_string===FALSE) ) {            
            tina_mvc_error("tina_mvc_form_helper_class->add_form_message() requires \$message_string parameters to be !== FALSE.");
        }
        
        $html_BR = '<br'.$this->doXML.'>';
        
        if( !isset($this->form_data->form_message ) ) {
            $this->form_data->form_message = '';
        }
        else {
            $this->form_data->form_message .= $html_BR;
        }
        $this->form_data->form_message .= $message_string;
        
    }
    
    private function esc_for_html_display( $v ) {
        
        $v = esc_attr($v);
        if( $this->doXML ) { 
            $v = ent2ncr( $v );
        }
        
        $v = wp_kses( $v, array() );
        
        return $v;
        
    }
    
    private function esc_for_html_element_name( $n ) {
        
        return $this->esc_for_html_display($n); // we will only allow [A..Za..z-_] so no check needed here... we escape ANYWAY for future-proofing
        
    }
    
    /**
     * This should probably be private
     */
    public function add_label( $fname ) {
        
        if(!$fname) {
            tina_mvc_error("tina_mvc_form_helper_class->add_label() \$field_name parameter is required.");
        }
        if(empty($this->form_data->fields->$fname)) {
            tina_mvc_error("tina_mvc_form_helper_class->add_label() \$field_name=$fname does not exist (use add_field() first).");
        }
        
        $h = '';
        // no label if the field_caption is blank
        if( $this->form_data->fields->$fname->field_caption ) {
            $h .= "<label for=\"".$this->make_field_id($fname)."\">".$this->esc_for_html_display($this->form_data->fields->$fname->field_caption)."</label>";
        }
        
        return $h;
        
    }
    
    /**
     * Get a field caption
     *
     * Generally used from outside the form helper to allow you access to an automatically generated label
     */
    public function get_label( $fname ) {
        
        return $this->esc_for_html_display($this->form_data->fields->$fname->field_caption);
        
    }
    
    /**
     * Import table data into your form
     *
     * This will set the values of any form fields that are named the same as your database fields
     * 
     * @param   string $table the table name to load into. Default `NONE`
     * @param   array|object $v( name => value ) pairs
     * @todo Move the checks for radio and select field types to a private function
     */
    public function load_field_data_array( $table=false, $v = FALSE ) {
        
        if(!$table AND empty( $this->form_data->tables->NONE ) ) {
            tina_mvc_error("tina_mvc_form_helper_class->load_field_data_array() requires the \$table parameter or table 'NONE' must exist.");
        }   
        if( empty($this->form_data->tables) OR empty($this->form_data->tables->$table) ) {
            tina_mvc_error("tina_mvc_form_helper_class->load_field_data_array() - table '$table' is not found.");
        }
        if(!$v ) {
            tina_mvc_error("tina_mvc_form_helper_class->load_field_data_array() requires the (array) \$v parameter.");
        }
        
        foreach( $v AS $fname => $fval ) {
            
            if( isset( $this->form_data->fields->$fname ) AND ( strtoupper($this->form_data->fields->$fname->field_type) != 'FILEUPLOAD' ) ) {
                
                $db_field_name = $this->form_data->fields->$fname->db_field;
                
                // the table...
                $the_table = $this->form_data->fields->$fname->db_table;
                
                if( $table == $the_table ) {
                    
                    $this->form_data->fields->$fname->field_value = $fval;
                    $this->form_data->tables->$table->$db_field_name = $fval;
                    
                    // if the field is a gmap_location we need to set the lat, lng and zoom fields too
                    if( strtoupper($this->form_data->fields->$fname->field_type) == 'GMAP_LOCATION' ) {
                        
                        $_map_vals = explode( ',' , $fval );
                        
                        $_lat_fname = $fname.'_lat';
                        $_lat_db_fname = $db_field_name.'_lat';
                        $this->form_data->fields->$_lat_fname->field_value = $_map_vals[0];
                        $this->form_data->tables->$table->$_lat_db_fname = $_map_vals[0];
                        
                        $_lng_fname = $fname.'_lng';
                        $_lng_db_fname = $db_field_name.'_lng';
                        $this->form_data->fields->$_lng_fname->field_value = $_map_vals[1];
                        $this->form_data->tables->$table->$_lng_db_fname = $_map_vals[1];
                        
                        $_zoom_fname = $fname.'_zoom';
                        $_zoom_db_fname = $db_field_name.'_zoom';
                        $this->form_data->fields->$_zoom_fname->field_value = $_map_vals[2];
                        $this->form_data->tables->$table->$_zoom_db_fname = $_map_vals[2];
                        
                    }
                    
                    
                    // if the field is a select or radio type we need to make sure the correct option is selected...                
                    if( strtoupper($this->form_data->fields->$fname->field_type) == 'SELECT' ) {
                        
                        foreach( $this->form_data->fields->$fname->field_html_select_options AS & $o ) {
                            if( $this->form_data->fields->$fname->field_value == $o['post_value'] ) {
                                $o['selected'] = 1;
                            }
                            else {
                                $o['selected'] = 0;
                            }
                        }
                        
                    }
                    elseif( strtoupper($this->form_data->fields->$fname->field_type) == 'RADIO' ) {
                        
                        foreach( $this->form_data->fields->$fname->field_html_radio_options AS & $o ) {
                            if( $this->form_data->fields->$fname->field_value == $o['post_value'] ) {
                                $o['selected'] = 1;
                            }
                            else {
                                $o['selected'] = 0;
                            }
                        }
                        
                    }
                    
                }
                
            }
        }
        
    }
    
    /**
     * Retrieve submitted data
     *
     * @param   string $table the table name. Default `NONE`
     * @return  mixed an array of ( name => value ) pairs or (bool) false if there were validation errors or the form was not submitted
     */
    public function get_table_data($table='NONE') {
        
        if(!$table) { tina_mvc_error("tina_mvc_form_helper_class->get_table_data() \$table cannot be passed empty."); }
        
        if( ! $this->validation_errors AND $this->have_we_been_posted() ) {
            return $this->form_data->tables->$table;
        }
        else {
            return FALSE;
        }
        
    }
    
    /**
     * @todo regexp to only allow only letters, numbers and underscore for $fname
     */
    private function add_input( $fname=false ) {
        
        // echo "DBG: input for $fname <br>";
        
        if(!$fname) { tina_mvc_error("tina_mvc_form_helper_class->add_input() \$field_name parameter is required."); }
        if(empty($this->form_data->fields->$fname)) { tina_mvc_error("tina_mvc_form_helper_class->add_input() \$field_name=$fname does not exist (use add_field() first)."); }
        
        // posted value is default whatever is passed - it is overridden by and GET or POST vars and also by $this->load_field_data_array();
        // default
        $field_value = $this->get_field_value( $fname );
        
        $field_type = strtoupper( $this->form_data->fields->$fname->field_type );
        
        $cleaned_field_name = $this->esc_for_html_element_name($this->form_data->fields->$fname->post_var_name);
        $cleaned_field_value = $this->esc_for_html_display( $field_value );
        
        if( $this->form_data->fields->$fname->extra_html_attributes ) {
            $extra_html_attributes = ' '.$this->form_data->fields->$fname->extra_html_attributes;
        }
        else {
            $extra_html_attributes = '';
        }
        
        $doXML = $this->doXML;
        
        // echo "DBG: switch for $fname <br>";
        
        switch ($field_type) {
        case 'TEXT':
          $_h = '<input type="text" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"$cleaned_field_value\"$extra_html_attributes$doXML>";
            break;
        case 'PASSWORD':
          $_h = '<input type="password" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"\"$extra_html_attributes$doXML>";
            break;
        case 'CHECKBOX':
          $_h = '<input type="checkbox" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"1\"";
          if($field_value) { 
            $_h .= " CHECKED";      
          }
          $_h .= "$extra_html_attributes$doXML>";
            break;        
        case 'RADIO':
          if( empty($this->form_data->fields->$fname->field_html_radio_options) ) {
            tina_mvc_error("tina_mvc_form_helper_class->add_input() field type RADIO requires add_radio_options()"); }
          $_h = '';
          foreach ($this->form_data->fields->$fname->field_html_radio_options AS $r_option) {
            
            $_tmp_html = '';
            
            $_cleaned_display_value = $this->esc_for_html_display( $r_option['display_value'] );
            
            $_cleaned_post_value = $this->esc_for_html_element_name( $r_option['post_value'] );
            $_tmp_html .= "<label for=\"".$this->make_field_id($fname).'_'.$_cleaned_post_value."\">$_cleaned_display_value</label>: <input id=\"".$this->make_field_id($fname)."\" type=\"radio\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"$_cleaned_post_value\"";
            if( $r_option['selected'] ) {
              $_tmp_html .= ' CHECKED';
            }
            $_tmp_html .= "$extra_html_attributes$doXML>\r\n";
            
            $_h .= sprintf( $this->html_form_radio_set , $_tmp_html );
            
          }
            break;
        case 'HIDDEN':
          $_h = "<input type=\"hidden\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"$cleaned_field_value\"$extra_html_attributes$doXML>";
            break;        
        case 'SELECT':  
          if( empty($this->form_data->fields->$fname->field_html_select_options) ) {
            tina_mvc_error("tina_mvc_form_helper_class->add_input() field type SELECT requires add_select_options()");
          }
          $_h = "<select id=\"".$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\"$extra_html_attributes>\r\n";
          $_h .= "<option value=\"\"></option>\r\n";
          foreach ($this->form_data->fields->$fname->field_html_select_options AS $r_option) {
            $_cleaned_display_value = $this->esc_for_html_display( $r_option['display_value'] );
            $_cleaned_post_value = esc_attr( $r_option['post_value'] );
            $_h .= "<option value=\"$_cleaned_post_value\"";
            if( $r_option['selected'] ) {
              $_h .= ' selected';
            }
            $_h .= ">$_cleaned_display_value</option>\r\n";
          }
          $_h .= "</select>";
          break;
        case 'TEXTAREA':
          $_h = '<textarea id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\"$extra_html_attributes>$cleaned_field_value</textarea>";
            break;
        case 'SUBMIT':
          $_h = '<input type="submit" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"$cleaned_field_value\"$extra_html_attributes$doXML>";
            break;
        case 'RESET':
          $_h = '<input type="reset" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\" value=\"$cleaned_field_value\"$extra_html_attributes$doXML>";
            break;
        case 'RECAPTCHA':
            $_h = recaptcha_get_html( get_option('tina_mvc_recaptcha_pub_key') );
            break;
        case 'FILEUPLOAD':
          $_h = '<input type="file" value=\"\" id="'.$this->make_field_id($fname)."\" name=\"".$this->make_field_post_var_name($fname)."\"$extra_html_attributes>";
            break;
        case 'GMAP_LOCATION':
          // $extra_html_attributes should be used to add width and height attributes to the map div. Else we pick a sensible default
          if( ! $extra_html_attributes ) {
            $extra_html_attributes = 'style="width:'.get_option('medium_size_w').'px;height:'.get_option('medium_size_w').'px"';
          }
          $_h = '<div '.$extra_html_attributes.' id="'.$this->make_field_id($fname.'_map_canvas').'"><em>If you do not see a Google Map here you have no working Internet connection or have Javascript disabled.</em></div>';
          // will be added after the closing form tag...
          $this->html_form_append .= $this->get_google_maps_js( $fname );
            break;
        default:
            tina_mvc_error("tina_mvc_form_helper_class->add_input() - unrecognised INPUT type '$field_type' for field '$fname'");
            break;
        }
        
        return $_h;
    
    }
    
    private function make_field_post_var_name( $f ) {
        return ($this->formname).'_'.($f);
    }

    private function make_field_id( $f ) {
        return $this->make_field_post_var_name($f);
    }
    
    /**
     * Get the form HTML for display
     *
     * @return  string the generated HTML ready for display
     * @uses get_form_pair_html()
     * @todo    Tidy - it is all a bit quick and dirty
     */
    public function get_form_html() {
        
        $html = '';
        
        $html .= '<form id="'.$this->formname.'" method="'.$this->form_data->method.'" action="'.$this->form_data->action.'" '.$this->form_data->enctype.'>'."\r\n";
        
        if( isset( $this->form_data->form_message ) ) {            
            $html .= sprintf( $this->html_form_message, $this->esc_for_html_display( $this->form_data->form_message ) ) . "\r\n";
        }
        
        if( isset( $this->form_data->form_error_message ) ) {            
            $html .= sprintf( $this->html_form_error, $this->esc_for_html_display( $this->form_data->form_error_message ) ) . "\r\n";
        }
        
        foreach( $this->form_data->fields AS $f ) {
            
            if( strtoupper($f->field_type) == 'HIDDEN' ) {
                // just dump it out...
                $html .= $f->html_input . "\r\n";
            }
            elseif( in_array( strtoupper($f->field_type), $this->fields_treated_as_buttons ) ) {
                $html .= sprintf( $this->html_form_button, $f->html_input ) . "\r\n";
            }
            else {
                
                if( isset($f->required) AND $f->required ) {
                    $f->html_label .= $this->html_form_required_after_label;
                    $f->html_input .= $this->html_form_required_after_input;
                }
                
                $tmp_html = '';
                // any descriptive text?
                if( $f->descriptive_text AND $f->descriptive_text_before_input ) {
                    $tmp_html .= '<div>'.esc_html($f->descriptive_text).'</div>';
                }
                // only if we have a label
                if( $f->html_label ) {
                    $tmp_html .= sprintf( $this->html_form_label, $f->html_label );
                }
                if( isset($f->error_message) ) {
                      $tmp_html .= sprintf( $this->html_form_field_error, $f->error_message );
                }
                $tmp_html .= sprintf( $this->html_form_input, $f->html_input );
                // any descriptive text?
                if( $f->descriptive_text AND ! $f->descriptive_text_before_input ) {
                    $tmp_html .= '<div>'.esc_html($f->descriptive_text).'</div>';
                }
                $html .= sprintf( $this->html_form_pair, $tmp_html ) . "\r\n";
                
            }
            
        }
        
        $html .= '</form>';
        
        $html .= $this->html_form_append;
        
        // wrap the form
        $html = sprintf( $this->html_form, $html );
        
        return $html;
        
    }

    /**
     * A quick and dirty way of grabbing the form data
     *
     * @return  string $this->form_data
     */
    public function get_form_data() {
        
        return "<pre><small>". htmlentities( print_r( $this->form_data, 1 ) )."</small></pre>";
        
    }

    /**
     * Locates a validation rule and its parameters for a specific field. This is needed by the
     * various 'validate_as_WHATEVER' functions.
     *
     * Validation rules return a string if there is a failure with an error message
     * and FALSE if all is OK
     *
     * @param string $fname the name of the field
     * @param string the rule name - must be in $this->valid_validation_rules
     * @return string
     * @see $this->valid_validation_rules
     * @see $this->build_form()
     */
    private function find_fld_val_rule_by_rule_type( $fname, $rtype='' ) {
        if( isset( $this->form_data->fields->$fname ) AND isset( $this->form_data->fields->$fname->validation_rules ) AND $this->form_data->fields->$fname->validation_rules ) {
            foreach( $this->form_data->fields->$fname->validation_rules AS $r ) {
                if( $rtype == $r['rule'] ) {
                    return $r;
                    break;
                }
            }
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_REQUIRED( $field_name ) {        
        if( !$this->get_field_value($field_name) ) {
            return (' is required');
        }
        else {
            return FALSE;
        }
    }

    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_EMPTY( $field_name ) {
        if( $this->get_field_value($field_name) ) {
            return (' must be empty');
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_MAX_STRLEN( $field_name ) {
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'MAX_STRLEN');
        $max_len = intval($rule['parameters']);
        if( strlen($this->get_field_value($field_name)) > $max_len ) {
            return (" must be shorter than $max_len characters long");
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_MIN_STRLEN( $field_name ) {
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'MIN_STRLEN');
        $min_len = intval($rule['parameters']);
        if( strlen($this->get_field_value($field_name)) < $min_len ) {
            return (" must be at least $min_len characters long");
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_NEGATIVE( $field_name ) {
        $val = $this->get_field_value($field_name);
        if( !is_numeric($val) ) {
            return " is not numeric";
        }
        elseif( $val >= 0 ) {
            return " must be a negative number";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_POSITIVE( $field_name ) {
        $val = $this->get_field_value($field_name);
        if( !is_numeric($val) ) {
            return " is not numeric";
        }
        elseif( $val <= 0 ) {
            return " must be a positive number";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_INTEGER( $field_name ) {
        $val = $this->get_field_value($field_name);
        if( $val != intval($val) ) {
            return " must be an integer";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_MAX_VAL( $field_name ) {
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'MAX_VAL');
        $max_val = intval($rule['parameters']);
        $val = $this->get_field_value($field_name);
        if( !is_numeric($val) ) {
            return " is not numeric";
        }
        elseif( $val > $max_val ) {
            return " cannot be greater than $max_val";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_MIN_VAL( $field_name ) {
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'MIN_VAL');
        $min_val = intval($rule['parameters']);
        $val = $this->get_field_value($field_name);
        if( !is_numeric($val) ) {
            return " is not numeric";
        }
        elseif( $val < $min_val ) {
            return " cannot be less than $min_val";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_EMAIL( $field_name ) {
        $val = $this->get_field_value($field_name);
        if( !is_email( $val, $check_dns=FALSE OR !$val ) ) {
          return ' is not a valid email address';
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_SQL_DATETIME( $field_name ) {
        $val = $this->get_field_value($field_name);
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $val, $matches)) {
            if (checkdate($matches[2], $matches[3], $matches[1])) {
                return FALSE;
            }
            // allow mysql zero
            if ( $val == '0000-00-00 00:00:00' ) {
                return FALSE;
            }
        }
        else {
            return " must be in YYY-MM-DD hh:mm:ss datetime format";
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_SQL_DATE( $field_name ) {
        $val = $this->get_field_value($field_name);
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $val, $matches)) {
            if (checkdate($matches[2], $matches[3], $matches[1])) {
                return FALSE;
            }
            // allow mysql zero
            if ( $val == '0000-00-00' ) {
                return FALSE;
            }
        }
        else {
            return ' must be in YYYY-MM-DD date format';
        }
    }

    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_SQL_TIME( $field_name ) {
        $val = $this->get_field_value($field_name);
        $err = ' must be in HH:MM:SS time format';
        if( strlen($val) != 8 OR count(($t=explode(':',$val))) != 3 ) {
            return $err;
        }
        // allow mysql zero
        if ( $val == '00:00:00' ) {        
            return FALSE;
        }
        if( $t[0] >= 0 AND $t[0] <= 23 AND $t[1] >= 0 AND $t[1] <= 59 AND $t[2] >= 0 AND $t[2] <= 59 ) {
            return FALSE;
        }
        return $err;
    }

    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_SQL_SHORT_TIME( $field_name ) {
        $val = $this->get_field_value($field_name);
        $err = ' must be in HH:MM time format';
        if( strlen($val) != 5 AND count($t=explode(':',$val)) != 2 ) {
            return $err;
        }
        // allow mysql zero
        if ( $val == '00:00' ) {
            return FALSE;
        }
        if( $t[0] >= 0 AND $t[0] <= 23 AND $t[1] >= 0 AND $t[1] <= 59 ) {
            return FALSE;
        }
        return $err;
    }

    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_EQUALTOFIELD( $field_name ) {
        $val = $this->get_field_value($field_name);
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'EQUALTOFIELD');
        $field_to_equal = $rule['parameters'];
        $val2 = $this->get_field_value($field_to_equal);
        if( !isset($this->form_data->fields->$field_to_equal) ) {
            tina_mvc_error("tina_mvc_form_helper_class->validate_as_EQUALTOFIELD() for '$field_name' - can't find a field named '$field_to_equal'.");;
        }
        $field_to_equal_caption = $this->form_data->fields->$field_to_equal->field_caption;        
        if( $val != $val2 ) {
            return " must equal '$field_to_equal_caption'";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_RECAPTCHA( $field_name ) {
        // $val = $this->get_field_value($field_name);
        // require( tina_mvc_find_libs_folder().'/recaptcha/recaptchalib.php'); // done at the top of this file...
        $resp = recaptcha_check_answer ( get_option('tina_mvc_recaptcha_pri_key') ,
                                $_SERVER['REMOTE_ADDR'],
                                tina_mvc_get_Post( 'recaptcha_challenge_field' ),
                                tina_mvc_get_Post( 'recaptcha_response_field' ) );
        if (!$resp->is_valid) {
            return " wasn't entered correctly. Go back and try it again.";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_LESSTHANFIELD( $field_name ) {
        $val = $this->get_field_value($field_name);
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'LESSTHANFIELD');
        $field_to_be_less_than = $rule['parameters'];
        $val2 = $this->get_field_value($field_to_be_less_than);
        if( !isset($this->form_data->fields->$field_to_be_less_than) ) {
            tina_mvc_error("tina_mvc_form_helper_class->validate_as_LESSTHANFIELD() for '$field_name' - can't find a field named '$field_to_be_less_than'.");;
        }
        $field_to_be_less_than_caption = $this->form_data->fields->$field_to_be_less_than->field_caption;        
        if( $val >= $val2 ) {
            return " must be less than '$field_to_be_less_than_caption'";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_GREATERTHANFIELD( $field_name ) {
        $val = $this->get_field_value($field_name);
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'GREATERTHANFIELD');
        $field_to_be_greater_than = $rule['parameters'];
        $val2 = $this->get_field_value($field_to_be_greater_than);
        if( !isset($this->form_data->fields->$field_to_be_greater_than) ) {
            tina_mvc_error("tina_mvc_form_helper_class->validate_as_GREATERTHANFIELD() for '$field_name' - can't find a field named '$field_to_be_greater_than'.");
        }
        $field_to_be_greater_than_caption = $this->form_data->fields->$field_to_be_greater_than->field_caption;
        if( $val <= $val2 ) {
            return " must be greater than '$field_to_be_greater_than_caption'";
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * Validation rule
     * @see $this->find_fld_val_rule_by_rule_type()
     */
    public function validate_as_REGEXP( $field_name ) {
        $val = $this->get_field_value($field_name);
        $rule = $this->find_fld_val_rule_by_rule_type($field_name,'REGEXP');
        $regexp = $rule['parameters'];
        if( !$regexp ) {
            tina_mvc_error("tina_mvc_form_helper_class->validate_as_REGEXP() for '$field_name' - can't find a REGEXP to test against.");;
        }
        if( ! preg_match('/'.$regexp.'/', $val ) ) {
            return ' is not valid';
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * A debug function
     */
    public function get_raw_form_data() {
        return $this->form_data;
    }
    
    private function get_google_maps_js( $fname , $lat=0 , $lng=0 , $zoom=8 ) {
        
        global $tina_mvc_controller_called_from;
        
        if( ! $fname ) {
            tina_mvc_error('$fname parameter is required');
        }
        
        $js = '';
        
        // shortcode, widget or page controller?
        if( ! $this->gmaps_js_already_added ) {
            if( $tina_mvc_controller_called_from == 'PAGE_FILTER' ) {
                
                // the scripts...
                wp_enqueue_script( 'GMapsAPI' , 'http://maps.google.com/maps/api/js?sensor=false' );
                
            }
            else {
                
                $js .= '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>'."\r\n";
                
            }
            $this->gmaps_js_already_added = TRUE;
        }
        
        // have we a posted value that will override the defaults?
        $lat = ( $this->get_field_value( $fname.'_lat' ) !== FALSE ) ? $this->get_field_value( $fname.'_lat' ) : $lat;
        $lng = ( $this->get_field_value( $fname.'_lng' ) !== FALSE ) ? $this->get_field_value( $fname.'_lng' ) : $lng;
        $zoom = ( $this->get_field_value( $fname.'_zoom' ) !== FALSE ) ? $this->get_field_value( $fname.'_zoom' ) : $zoom;
        
        // no need to use CDATA for xHTML - no '<' or '&' characters in the script...
        $js .= '        
            <script type="text/javascript">
                var '.$this->make_field_id($fname).'_latlng = new google.maps.LatLng( '.floatval($lat).', '.floatval($lng).' );    
                var '.$this->make_field_id($fname).'_myOptions = {
                  zoom: '.intval($zoom).',
                  center: '.$this->make_field_id($fname).'_latlng,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  navigationControl: true,
                  navigationControlOptions: {
                    style: google.maps.NavigationControlStyle.SMALL
                  },
                  scaleControl: false,
                  mapTypeControl: false,
                };
                var '.$this->make_field_id($fname).'_map = new google.maps.Map(document.getElementById("'.$this->make_field_id($fname.'_map_canvas').'"), '.$this->make_field_id($fname).'_myOptions);
                var '.$this->make_field_id($fname).'_markerOptions = {
                  map: '.$this->make_field_id($fname).'_map,
                  draggable: true,
                  position: '.$this->make_field_id($fname).'_latlng
                };
                var '.$this->make_field_id($fname).'_marker = new google.maps.Marker( '.$this->make_field_id($fname).'_markerOptions );
                function '.$this->make_field_id($fname).'_updateHTML(latlng , zoom ) {
                  document.getElementById("'.$this->make_field_id($fname.'_lat').'").value = latlng.lat();
                  document.getElementById("'.$this->make_field_id($fname.'_lng').'").value = latlng.lng();
                  document.getElementById("'.$this->make_field_id($fname.'_zoom').'").value = zoom;
                }
                '.$this->make_field_id($fname).'_updateHTML( '.$this->make_field_id($fname).'_latlng );
                google.maps.event.addListener('.$this->make_field_id($fname).'_map, \'click\', function(event) {
                  '.$this->make_field_id($fname).'_map.panTo(event.latLng);
                  '.$this->make_field_id($fname).'_marker.setPosition(event.latLng);
                  '.$this->make_field_id($fname).'_updateHTML( event.latLng , '.$this->make_field_id($fname).'_map.getZoom() );
                });    
                google.maps.event.addListener('.$this->make_field_id($fname).'_marker, \'dragend\', function(event) {
                  '.$this->make_field_id($fname).'_map.panTo(event.latLng);
                  '.$this->make_field_id($fname).'_updateHTML( event.latLng , '.$this->make_field_id($fname).'_map.getZoom() );
                });
                google.maps.event.addListener('.$this->make_field_id($fname).'_map, \'zoom_changed\', function() {
                  '.$this->make_field_id($fname).'_updateHTML( '.$this->make_field_id($fname).'_map.getCenter() , '.$this->make_field_id($fname).'_map.getZoom() );
                });
            </script>
        ';
        
        return $js;
        
    }


}

?>
