<?php
/**
* Template File: The users dashboard - with links to the various sample apps
*
* @package    Tina-MVC
* @subpackage Tina-Sample-Apps
* @author     Francis Crossen <francis@crossen.org>
* @version    $Id: index_view.php, v 0.00 Sat Jan 23 2010 21:39:58 GMT+0000 (IST) Francis Crossen $
*/

/**
 * You should include this check in every view file you write. The constant is defined in
 * tina_mvc_base_page->load_view() 
 */
if( ! defined('TINA_MVC_LOAD_VIEW') ) exit();
?>
<h1>Welcome to Tina MVC</h1>

<p>This is the sample Tina MVC front end controller page as shipped. The intention of this page is to give you links
to the various sample apps. It assumes you have copied `sample_apps/*` to `app/`. If you would like to revert
that action, then delete `app/*`.
</p>

<h2>Sample Applications:</h2>

<table>
    <thead>
    <tr>
        <th>Page Controller</th><th>Controller for widgets or shortcodes</th><th>Description</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('','tina-mvc-for-wordpress') ?></td>
            <td><?php echo tina_mvc_make_controller_link('','index') ?></td>
            <td>This page. In this case the `index_page.php` is loaded from `tina_mvc/app` but the view file (`index_view.php`)
            is overridden by `app/tina-mvc-for-wordpress/index_view.php`.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('contact-form','tina-mvc-for-wordpress/contact-form') ?></td>
            <td><?php echo tina_mvc_make_controller_link('contact-form','contact-form') ?></td>
            <td>A simple contact form using the Tina MVC form helper class (tina_mvc_form_helper_class.php).
            If you enter your <a href="http://www.recaptcha.net" target="_blank">reCaptcha</a>
            API keys in your <code>tina_mvc_app_settings.php</code> file, then a reCaptcha field will be used.
            Copy <code>tina_mvc_app_settings_sample.php</code> to get started.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('test-form','tina-mvc-for-wordpress/test-form') ?></td>
            <td><?php echo tina_mvc_make_controller_link('test-form','test-form') ?></td>
            <td>A more complex form. This should use all the field types available in the Tina MVC form helper class
            and serve as a tutorial in its use.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina/simple-form') ?></td>
            <td><?php echo tina_mvc_make_abs_controller_link('tina/simple-form','simple-form') ?></td>
            <td>A more complex form. This will/should use all the field types available in the Tina MVC form helper class
            and serve as a tutorial in its use.<br />
            Uses the default private front end page controller page (`tina`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina/test') ?></td>
            <td><?php echo tina_mvc_make_abs_controller_link('tina/test','test') ?></td>
            <td>A very simple test page showing how the Tina MVC page request is passed to your page controller.
            Does not use a view/template file.<br />
            Uses the default private front end page controller page (`tina`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina-mvc-for-wordpress/sample') ?><br />and<br />
                <?php echo tina_mvc_make_abs_controller_link('tina/sample') ?>
            </td>
            <td>
                <?php echo tina_mvc_make_abs_controller_link('tina/sample', 'sample') ?>
            </td>
            <td>A sample page for use in Widgets, shortcodes or pages. Because it is located in the `app/` folder it is accessible
            via any Tina MVC front end controller page. They can also be accessed with the `tina_mvc` shortcode or
            from the Tina MVC widget.<br />
            Can be accessed from any front end page controller page (default `tina` and `tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina-mvc-for-wordpress/shortcode') ?><br />and<br />
                <?php echo tina_mvc_make_abs_controller_link('tina/shortcode') ?>
            </td>
            <td>
                <?php echo tina_mvc_make_abs_controller_link('tina/shortcode', 'shortcode') ?>
            </td>
            <td>Another sample page for use in Widgets, shortcodes or pages.<br />
            Can be accessed from any front end page controller page (default `tina` and `tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina-mvc-for-wordpress/dispatcher-example') ?><br />and<br />
                <?php echo tina_mvc_make_abs_controller_link('tina/dispatcher-example') ?>
            </td>
            <td>
                <?php echo tina_mvc_make_abs_controller_link('tina/shortcode', 'dispatcher-example') ?>
            </td>
            <td>An example of the new dipatcher in action.<br />
            Can be accessed from any front end page controller page (default `tina` and `tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_abs_controller_link('tina-mvc-for-wordpress/widgets/page-list') ?><br />and<br />
                <?php echo tina_mvc_make_abs_controller_link('tina/widgets/page-list') ?>
            </td>
            <td>
                <?php echo tina_mvc_make_abs_controller_link('tina/widgets/page-list', 'widgets/page-list') ?>
            </td>
            <td>An example of how you might organise your widgets in a single class. This lists the child and grandchild pages of the current page<br />
            Can be accessed from any front end page controller page (default `tina` and `tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('sample-html-table-helper') ?></td>
            <td><?php echo tina_mvc_make_controller_link('sample-html-table-helper') ?></td>
            <td>An example of the HTML table helper. Formats an array or object of data into a HTML table (tina_mvc_html_table_helper_class.php).<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination') ?></td>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination') ?></td>
            <td>An example of the SQL pagination helper. Creates a table from your SQL and outputs a sortable
            HTML table with pagination links.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-2') ?></td>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-2') ?></td>
            <td>Another example of the SQL pagination helper. This example shows you how to retrieve the SQL results and to
            create your own HTML, overriding the use of the html table helper.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-3') ?></td>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-3') ?></td>
            <td>And a third example of the SQL pagination helper. This example shows you how to retrieve the SQL results and to
            create your own HTML, overriding the use of the html table helper.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
        <tr>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-4') ?></td>
            <td><?php echo tina_mvc_make_controller_link('sample-pagination-4') ?></td>
            <td>A forth example of the SQL pagination helper. When you retrieve SQL results
            and make up your own columns to pass back to the pagination helper,
            the sortable columns will not work. This example demonstrates how to suppress the
            addition of HTML for one or more columns.<br />
            Uses the default front end page controller page (`tina-mvc-for-wordpress`).</td>
        </tr>
    </tbody>
</table>

<h2>Shortcodes</h2>

<p>Tina MVC implements the `tina_mvc' shortcode as an enclosing or self-closing shortcode:

<code>[ tina_mvc controller='' role_to_view='whatever' capability_to_view='']</code><br /> and<br /> 
<code>[ tina_mvc controller='' role_to_view='whatever' capability_to_view='']default content[/tina_mvc]</code>

Only the controller attribute is required. Role and Capability to view can be entered as a comma separated list. To make the shortcode
visible to all users, use the value '-1'.
</p>

<h3>Shortcode example 1</h3>

<code>[ tina_mvc controller='sample' role_to_view='-1']</code>
[tina_mvc controller='sample' role_to_view='-1'] [/tina_mvc]

<h3>Shortcode example 2</h3>

<code>[ tina_mvc controller='shortcode' role_to_view='-1']</code>
[tina_mvc controller='shortcode' role_to_view='-1'] [/tina_mvc]

<h3>Shortcode example 3</h3>

<code>[ tina_mvc controller='sample' role_to_view='administrator,editor,author']&lt;b&gt;You are not `administrator`, `editor` or `author`!&lt;/b&gt;[/tina_mvc]</code>
[tina_mvc controller='sample' role_to_view='administrator']<b>You are not `administrator`, `editor` or `author`!</b>[/tina_mvc]

<h2>Widgets</h2>

<p>The Tina MVC Widget allows you to call a controller as a widget. If your page does not return any data the Widget is not displayed.

</p>

<?php if ( $V->user->ID ) : // are we logged in ?>

<h2>You are logged in as <?php echo $V->user->user_login ?></h2>

<h2>Your details</h2>

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

<h2>There is nobody logged in and there are no permissions required to view this page.</h2>

<?php endif; // are we logged in ?>
