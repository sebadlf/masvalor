<?php
/**
* Template File: The users personal account data
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
<h2><?php echo $V->user->user_login ?>'s Personal data</h2>

<h3>Personal details</h3>

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

<p><?php echo tina_mvc_make_controller_link('user/edit-personal-data','Edit personal data (email, password, etc.)') ?>.</p>

<h3>Recent Stuff</h3>

<p>You would show things like the last 10 sales, tickets, posts, payments, whatever here...</p>
