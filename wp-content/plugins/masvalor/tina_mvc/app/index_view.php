<?php
/**
* Template File: The users dashboard
*
* @package    Tina-MVC
* @subpackage Tina-Core-Views
* @author     Francis Crossen <francis@crossen.org>
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<?php // an example of how to use a view file from within a view file... ?>
<?php echo $this->load_view('tina_mvc_logo_snippet', ($_a=false), tina_mvc_find_tina_mvc_folder()."/misc");  ?>
<h2>This is a Tina MVC front end controller page</h2>

<p>You can have as many or as few front end controller pages as Wordpress allows pages. Alternatively if you are developing your own app, you can choose not to create the front end controller pages at all. This allows you to use Tina MVC for widget and plugin development only without creating any extra Wordpress pages. However if you want to use the Tina MVC login/user dashboard functionality, you will need at least one front end controller page.</p>

<h3>Have you just installed Tina MVC?</h3>
<p>If so you can copy the files and directories from <code>`sample_app/`</code> to <code>`app/`</code> to get you started. This will override this page with new content and some links to the sample page controllers.</p>
<p>The sample applications are all well documented and illustrate various use cases.</p>

<p>In fact this page serves as an example too. You will find it in <code>`tina-mvc/tina_mvc/`</code> in your Wordpress plugins folder. Look for <code>`index_page.php`</code> (the page controller) and <code>`index_view.php`</code> (the view file). You can copy them to the <code>`app/`</code> folder (or to `<code>app/tina-mvc-for-wordpress/`</code>) and customise them. They will be used in preference to these default ones.</p>

<hr>

<?php if ( $V->user->ID ) : // are we logged in ?>

<h3><?php echo $V->user->user_login ?>'s Dashboard</h3>

<h3>Your details</h3>

<table>
    <thead>
    </thead>
    <tbody>
        <tr>
            <td>Username:</td>
            <td><?php echo $V->user->user_login ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo $V->user->user_email ?></td>
        </tr>
    </tbody>
</table>

<p>Go <?php echo tina_mvc_make_controller_link('user/my-personal-data','here to view your personal data') ?>.</p>

<?php else : // are we logged in ?>

<h3>There is nobody logged in and there are no permissions to view this page.</h3>

<p>You can use this page as your staring point for Tina development.</p>

<?php endif; // are we logged in ?>

<h3>Cheesy I know, but here is the customary message passed from our page controller:</h3>

<p>The result of <code><?php echo esc_html('<?php echo $V->hello_world ?>') ?></code>:<?php echo $V->hello_world ?></p>

<p>This is the users post login dashboard or the public front end controller page (depending on the view permissions). You can override it with your own by copying this file ('index_view.php') into the 'app' folder
and customising it.</p>
