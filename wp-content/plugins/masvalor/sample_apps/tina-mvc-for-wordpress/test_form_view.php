<?php
//
// $Id: test_form_view.php, v 0.00 Sun Feb 21 2010 17:50:08 GMT+0000 (IST) Francis Crossen $
//

/**
* A trivial view file for the test_form page controller
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
* @see        test_form_page.php the page controller
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<h1>Test Forms</h1>
<p>All forms are posted back to this page. The page is updated with the results of POSTed data without sending a browser redirect.
This is intentional so you can hit reload on your browser and re-POST the forms.</p>

<p>Remember it is sensible practice to send a browser redirect (use Wordpress wp_redirect() function with tina_mvc_make_controller_url() function) after updating
a persistent data store (usually MySQL). This prevents a browser reload from resubmitting the form.</p>

<p>If any form is POSTed sucessfully the data submitted will be shown after that form.</p>

<h2>Form 1</h2>
<p>A simple form showing all the different input types.</p>

<?php foreach( $V->form_1 AS $key => $value ): ?>
    <?php if( $key == 'the_form' ): ?>
        <h3><?php echo $key ?></h3>
        <?php echo $value ?>
    <?php else: ?>
        <h3><?php echo $key ?></h3>
        <pre><small><?php print_r( $value ) ?></small></pre>
    <?php endif; ?>    
<?php endforeach; ?>

<h2>Form 2</h2>
<p>A more complex example showing all the options available to you when defining inputs.</p>

<?php foreach( $V->form_2 AS $key => $value ): ?>
    <?php if( $key == 'the_form' ): ?>
        <h3><?php echo $key ?></h3>
        <?php echo $value ?>
    <?php else: ?>
        <h3><?php echo $key ?></h3>
        <pre><small><?php print_r( $value ) ?></small></pre>
    <?php endif; ?>    
<?php endforeach; ?>

<h2>Form 3</h2>
<p>Building on form 2, we load in an array of values into the form.
This will override any default values that have been set. This is how you populate a form with a database record.
</p>

<?php foreach( $V->form_3 AS $key => $value ): ?>
    <?php if( $key == 'the_form' ): ?>
        <h3><?php echo $key ?></h3>
        <?php echo $value ?>
    <?php else: ?>
        <h3><?php echo $key ?></h3>
        <pre><small><?php print_r( $value ) ?></small></pre>
    <?php endif; ?>    
<?php endforeach; ?>

<h2>Form 4</h2>
<p>Building on form 3, adding validation rules.
</p>

<?php foreach( $V->form_4 AS $key => $value ): ?>
    <?php if( $key == 'the_form' ): ?>
        <h3><?php echo $key ?></h3>
        <?php echo $value ?>
    <?php else: ?>
        <h3><?php echo $key ?></h3>
        <pre><small><?php print_r( $value ) ?></small></pre>
    <?php endif; ?>    
<?php endforeach; ?>

<pre><small><?php print_r( $V->debug ) ?></small></pre>
