<?php
//
// $Id: test_form_page.php, v 0.00 Sun Feb 21 2010 18:09:03 GMT+0000 (IST) Francis Crossen $
//

/**
* A page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
*/

/**
* An example of how to use tina_mvc_form_helper_class
*
* Access it at: /tina-mvc-for-wordpress/test-form. Because this is a simple example we are not
* using the dispatcher method. You should!
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @uses         test_form_view.php the example_mvc view file
* @author     Francis Crossen <francis@crossen.org>
*/
class test_form_page extends tina_mvc_base_page_class {
    
    function __construct( $request ) {
        
        parent::__construct(  $request );
        
        /**
         * Load the helper file
         */
        tina_mvc_include_helper('tina_mvc_form_helper');
        
        /**
         * @var object for holding data we will pass to the view file
         */
        $this->view_data = new stdClass;
        
        /**
         * If you are using view files, it is VERY likely you do not want Wordpress mangling your HTML.
         * If you do not, Wordpress will convert "\r\n" to <br> etc. See wpautop().
         *
         * You can also disable wpautop() for ALL your Tina pages in tina_mvc_application_settings.php
         *
         * @see http://codex.wordpress.org/Function_Reference/wpautop
         * @see tina_mvc_application_settings.php
         */
        remove_filter('the_content', 'wpautop');
        
        /**
         * Form 1
         * 
         * We will use the same base form and field data for all forms. The forms are presented in increasing order of
         * complexity - see notes at the beginning of each new form
         */
        
        /**
         * @var array radio options ( 'display_value' => 'POST value' )
         */
        $this->radio_options = array( 'first radio option'=> 1,
                                      'second radio option' => 2,
                                      'third radio option' => 'foo',
                                      'fourth radio option' => 'bar',
                                    );
        
        /**
         * @var array select options ( 'display_value' => 'POST value' )
         */
        $this->select_options = array( 'first select option'=> 1,
                                       'second select option' => 2,
                                       'third select option' => 'foo',
                                       'fourth select option' => 'bar',
                                      );
        
        /**
         * @var string data we want after the form has been POSTed
         */
        $this->fields_we_want = 'my_db_table'; // use this to group POSTed data
        
        /**
         * @var string data we will discard after form processing. Submit buttons, cancel buttons, whatever
         */
        $this->fields_we_dont_want = 'submit_buttons_and_stuff_like_that'; // we don't need these for data processing
        
        /**
         * Form 1
         */
        $form_1 = new tina_mvc_form_helper_class( 'form_1' );
        
        $form_1->add_field( 'a_text_input', 'text' , false, $this->fields_we_want );
        
        $form_1->add_field( 'a_password_input', 'password', false, $this->fields_we_want );
        
        $form_1->add_field( 'a_checkbox_input', 'checkbox' , false, $this->fields_we_want);
        
        $form_1->add_field( 'a_radio_input', 'radio' , false, $this->fields_we_want);
        $form_1->add_radio_options( 'a_radio_input' , $this->radio_options );
        
        $form_1->add_field( 'a_hidden_input', 'hidden', false, $this->fields_we_want, false, 'the value to POST' );
        
        $form_1->add_field( 'a_select_input', 'select', false, $this->fields_we_want );
        $form_1->add_select_options( 'a_select_input' , $this->select_options );        
        
        $form_1->add_field( 'a_textarea_input', 'textarea' , false, $this->fields_we_want);
        
        $form_1->add_field( 'a_file_upload_input', 'fileupload' , false, $this->fields_we_dont_want );
        
        $form_1->add_field( 'a_gmap_location_input_1', 'gmap_location' , false, $this->fields_we_want );
        
        /**
         * You must enter your recaptcha API keys into tina_mvc_app_settings.php to
         * enable recaptcha inputs
         */
        // $form_1->add_field( 'a-recaptcha-input', 'recaptcha' , NULL , $this->fields_we_dont_want );
        
        $form_1->add_field( 'a_submit_button', 'submit', false , $this->fields_we_dont_want , false , 'A Submit button' );
        
        $form_1->add_field( 'a_reset_button', 'reset' , false , $this->fields_we_dont_want , false , 'A Reset button'  );
        
        $form_1->build_form();
     
        if( $form_1_data_we_want = $form_1->get_table_data( $this->fields_we_want ) ) { // returns FALSE if there were validation errors...
            
            $this->view_data->form_1->data_we_want = $form_1_data_we_want;
            $this->view_data->form_1->data_we_dont_need = $form_1->get_table_data( $this->fields_we_dont_want );
            
        }
        
        $this->view_data->form_1->the_form = $form_1->get_form_html();
        
        $dummy_table_data = array( 'test_field' => 'test_field value', 'test-field2' => 'test-field2 value', 'non-existant field' => 'non-existant field value', 'test-field3' => 'SHOULDNT SEE THIS' );
        
        /**
         * Form 2
         * 
         * Here we are setting default values for each field (where this makes sense). Apart from that the example is the same.
         */
        $form_2 = new tina_mvc_form_helper_class( 'form_2' );
        
        $form_2->add_field( 'a_text_input', 'text' , 'The text label', $this->fields_we_want, 'text_db_field' , 'Text default value' , 'style="background:#afa;"' );
        
        $form_2->add_field( 'a_password_input', 'password', 'The password label', $this->fields_we_want , 'password_db_field' , 'This default value will be ignored' , 'style="background:#faa;"' );
        
        $form_2->add_field( 'a_checkbox_input', 'checkbox' , 'The checkbox label', $this->fields_we_want , 'checkbox_db_field' , 1 , 'onClick="alert(\'The checkbox says: Ouch!\')"' );
        
        $form_2->add_field( 'a_radio_input', 'radio' , 'The radio label', $this->fields_we_want , 'radio_db_field' , 'foo' , 'onClick="alert(\'The radio says: Ouch!\')"' );
        $form_2->add_radio_options( 'a_radio_input' , $this->radio_options );
        
        $form_2->add_field( 'a_hidden_input', 'hidden', 'Why would you label a hidden field?', $this->fields_we_want, 'hidden_db_field' , 'the value to POST' );
        
        $form_2->add_field( 'a_select_input', 'select', 'The select label', $this->fields_we_want , 'select_db_field' , 2 , 'style="color:blue;"' );
        $form_2->add_select_options( 'a_select_input' , $this->select_options );        
        
        $form_2->add_field( 'a_textarea_input', 'textarea' , 'The textarea label', $this->fields_we_want , 'textarea_db_field' , "Some default \r\n text" , 'style="font-size:small;"' );
        
        $form_2->add_field( 'a_file_upload_input', 'fileupload' , 'The fileupload label', $this->fields_we_dont_want , 'fileupload_variable_name' );
        
        $form_2->add_field( 'a_gmap_location_input_2', 'gmap_location' , "Where are you", $this->fields_we_want, 'gmap_lat_lng_zoom' , '20,55,1' );
        
        /**
         * You must enter your recaptcha API keys into tina_mvc_app_settings.php to
         * enable recaptcha inputs
         */
        // $form_2->add_field( 'a-recaptcha-input', 'recaptcha' , 'The recaptcha label' , $this->fields_we_dont_want );
        
        $form_2->add_field( 'a_submit_button', 'submit', 'The submit label is ignored' , $this->fields_we_dont_want , 'ignored' , 'A Submit button' );
        
        $form_2->add_field( 'a_reset_button', 'reset' , 'The reset label - ignored' , $this->fields_we_dont_want , 'ignored' , 'A Reset button'  );
        
        $form_2->build_form();
     
        if( $form_2_data_we_want = $form_2->get_table_data( $this->fields_we_want ) ) { // returns FALSE if there were validation errors...
            
            $this->view_data->form_2->data_we_want = $form_2_data_we_want;
            $this->view_data->form_2->data_we_dont_need = $form_2->get_table_data( $this->fields_we_dont_want );
            
        }
        
        $this->view_data->form_2->the_form = $form_2->get_form_html();
        
        /**
         * Form 3
         * 
         * Same as form 2 above, except we are demonstrating the use of the load_field_data_array() function
         * to populate a form with data.
         *
         * This is how you load persisted data (from a database record for example) into your form.
         */
        
        /**
         * @var array ( 'field_name' => 'field value' )
         */
        $this->sample_field_data_A_form_3 = array(
                                            'a_text_input' => '01 10 10',
                                            'a password input' => 'this db value will be ignored',
                                            'a_checkbox_input' => 0,
                                            'a_radio_input' => 1,
                                            'a_hidden_input' => 'hidden overridden from db',
                                            'a_select_input' => 'bar',
                                            'a_textarea_input' => "1,\r\n2,\r\n3, 4, 5, Once I caught a fish alive...",
                                            'a_file_upload_input' => 'this is signored',
                                            'a_gmap_location_input_1' => '22,57,7',
                                            'a_gmap_location_input_2' => '22,57,7',
                                            'a_gmap_location_input_3' => '22,57,7',
                                            'a_submit_button' => 'Submit value overridden - will be ignored',
                                            'a_reset_button' => 'Reset value overridden - will be ignored',
                                            'a-field-that-doesnt-exist' => 999999,
                                        );
        $this->sample_field_data_B_form_3 = array(
                                            'a_text_input' => '01 10 10 - ignored',
                                            'a password input' => 'this db value will be ignored',
                                            'a_checkbox_input' => 'bar',
                                            'a_radio_input' => 'bar',
                                            'a_hidden_input' => 'hidden NOT overridden from db',
                                            'a_select_input' => 'bar',
                                            'a_textarea_input' => "Ignored",
                                            'a_file_upload_input' => 'this is signored',
                                            'a_gmap_location_input_1' => '22,57,7',
                                            'a_gmap_location_input_2' => '22,57,7',
                                            'a_gmap_location_input_3' => '22,57,7',
                                            'a_submit_button' => 'Submit value overridden...',
                                            'a_reset_button' => 'Reset value overridden...',
                                            'a-field-that-doesnt-exist' => 999999,
                                        );
        
        $form_3 = new tina_mvc_form_helper_class( 'form_3' );
        
        $form_3->add_field( 'a_text_input', 'text' , 'The text label', $this->fields_we_want, 'text_db_field' , 'Text default value' );
        
        $form_3->add_field( 'a_password_input', 'password', 'The password label', $this->fields_we_want , 'password_db_field' );
        
        $form_3->add_field( 'a_checkbox_input', 'checkbox' , 'The checkbox label', $this->fields_we_want , 'checkbox_db_field' , 1 );
        
        $form_3->add_field( 'a_radio_input', 'radio' , 'The radio label', $this->fields_we_want , 'radio_db_field' , 'foo' );
        $form_3->add_radio_options( 'a_radio_input' , $this->radio_options );
        
        $form_3->add_field( 'a_hidden_input', 'hidden', 'Why would you label a hidden field?', $this->fields_we_want, 'hidden_db_field' );
        
        $form_3->add_field( 'a_select_input', 'select', 'The select label', $this->fields_we_want , 'select_db_field' , 2 );
        $form_3->add_select_options( 'a_select_input' , $this->select_options );        
        
        $form_3->add_field( 'a_textarea_input', 'textarea' , 'The textarea label', $this->fields_we_want , 'textarea_db_field' , "Some default \r\n text" );
        
        $form_3->add_field( 'a_file_upload_input', 'fileupload' , 'The fileupload label', $this->fields_we_dont_want , 'fileupload_variable_name' );
        
        $form_3->add_field( 'a_gmap_location_input_3', 'gmap_location' , "Where are you", $this->fields_we_want, 'gmap_lat_lng_zoom' , '70,70,1', 'style="height:250px;width:550px"' );
        
        /**
         * You must enter your recaptcha API keys into tina_mvc_app_settings.php to
         * enable recaptcha inputs
         */
        // $form_3->add_field( 'a-recaptcha-input', 'recaptcha' , 'The recaptcha label' , $this->fields_we_dont_want );
        
        $form_3->add_field( 'a_submit_button', 'submit', 'The submit label is ignored' , $this->fields_we_dont_want , 'ignored' , 'A Submit button' );
        
        $form_3->add_field( 'a_reset_button', 'reset' , 'The reset label - ignored' , $this->fields_we_dont_want , 'ignored' , 'A Reset button'  );
        
        /**
         * This will only load data into the specified table any field that is not assigned to the table that you
         * are loading data into will be ignored
         */
        $form_3->load_field_data_array( $this->fields_we_want, $this->sample_field_data_A_form_3 );
        
        $form_3->load_field_data_array( $this->fields_we_dont_want, $this->sample_field_data_B_form_3 );        
        
        $form_3->build_form();
     
        if( $form_3_data_we_want = $form_3->get_table_data( $this->fields_we_want ) ) { // returns FALSE if there were validation errors...
            
            $this->view_data->form_3->data_we_want = $form_3_data_we_want;
            $this->view_data->form_3->data_we_dont_need = $form_3->get_table_data( $this->fields_we_dont_want );
            
        }
        
        $this->view_data->form_3->the_form = $form_3->get_form_html();
        
        /**
         * Form 4
         * 
         * Same as form 3 above, but adding validation rules.
         *
         * You can add rules for a field/input one by one or all together.
         */
        
        $form_4 = new tina_mvc_form_helper_class( 'form_4' );
        
        $form_4->add_field( 'a_text_input', 'text' , 'The text label', $this->fields_we_want, 'text_db_field' , 'Text default value' );
        /**
         * Adding a single validation rule
         */
        $form_4->add_validation_rule( 'a_text_input' , 'required' , false ); // false, no arguments required.
        $form_4->add_validation_rule( 'a_text_input' , 'regexp' , '^[a-zA-Z0-9]+$' ); // false, no arguments required.
        
        $form_4->add_field( 'a_password_input', 'password', 'The password label', $this->fields_we_want , 'password_db_field' );
        /**
         * Adding several rules at once
         */
        $_rules = array( 'required' => NULL,
                         'min_strlen' => 5,
                         'max_strlen' => 10,
                         );
        $form_4->add_validation_rules( 'a_password_input', $_rules );
        
        $form_4->add_field( 'a_checkbox_input', 'checkbox' , 'The checkbox label', $this->fields_we_want , 'checkbox_db_field' , 1 );
        
        $form_4->add_field( 'a_radio_input', 'radio' , 'The radio label', $this->fields_we_want , 'radio_db_field' , 'foo' );
        $form_4->add_radio_options( 'a_radio_input' , $this->radio_options );
        
        $form_4->add_field( 'a_hidden_input', 'hidden', 'Why would you label a hidden field?', $this->fields_we_want, 'hidden_db_field' );
        
        $form_4->add_field( 'a_select_input', 'select', 'The select label', $this->fields_we_want , 'select_db_field' , 2 );
        $form_4->add_select_options( 'a_select_input' , $this->select_options );        
        
        $form_4->add_field( 'a_textarea_input', 'textarea' , 'The textarea label', $this->fields_we_want , 'textarea_db_field' , "Some default \r\n text" );
        
        $form_4->add_field( 'a_file_upload_input', 'fileupload' , 'The fileupload label', $this->fields_we_dont_want , 'fileupload_variable_name' );
        
        /**
         * You must enter your recaptcha API keys into tina_mvc_app_settings.php to
         * enable recaptcha inputs
         */
        // $form_4->add_field( 'a-recaptcha-input', 'recaptcha' , 'The recaptcha label' , $this->fields_we_dont_want );
        
        $form_4->add_field( 'a_submit_button', 'submit', 'The submit label is ignored' , $this->fields_we_dont_want , 'ignored' , 'A Submit button' );
        
        $form_4->add_field( 'a_reset_button', 'reset' , 'The reset label - ignored' , $this->fields_we_dont_want , 'ignored' , 'A Reset button'  );
        
        /**
         * This will only load data into the specified table any field that is not assigned to the table that you
         * are loading data into will be ignored
         */
        //$form_4->load_field_data_array( $this->fields_we_want, $this->sample_field_data_A_form_3 );
        
        //$form_4->load_field_data_array( $this->fields_we_dont_want, $this->sample_field_data_B_form_3 );        
        
        $form_4->build_form();
            
        if( $form_4_data_we_want = $form_4->get_table_data( $this->fields_we_want ) ) { // returns FALSE if there were validation errors...
            
            //die( '<pre>'.print_r($form_4,1) );
            
            $this->view_data->form_4->data_we_want = $form_4_data_we_want;
            $this->view_data->form_4->data_we_dont_need = $form_4->get_table_data( $this->fields_we_dont_want );
            
        }
        
        $this->view_data->form_4->the_form = $form_4->get_form_html();
        
        /**
         * Form examples finished. The remainder just sets the page title and contents
         */
        
        /**
         * Set the post (page) title and contents.
         */
        $this->set_post_title('Tina MVC Form Helper Examples');
        $this->set_post_content( $this->load_view( 'test_form' , $this->view_data ) );

        
    }

}

?>