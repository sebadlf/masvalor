<?php
/**
* Template File: After processing a password reset link that was sent to a user
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
<h2>Reset Password:</h2>

<?php if( $V['no_hash_or_username'] ): ?>

    <h3><?php echo $V['no_hash_or_username'] ?></h3>
    <p>We could not find a security key and a username in the link you provided.</p>
    <p>If your email reader split the link we sent you over several lines, then
    perhaps it broke the link. Try to copy and paste it (as one line) into your browser and try again.
    </p>

<?php endif; ?>
<?php if( $V['no_hash'] ): ?>

    <h3><?php echo $V['no_hash'] ?></h3>
    <p>We could not find a security key in the link you provided.</p>
    <p>If your email reader split the link we sent you over several lines, then
    perhaps it broke the link. Try to copy and paste it (as one line) into your browser and try again.
    </p>

<?php endif; ?>
<?php if( $V['bad_hash'] ): ?>

    <h3><?php echo $V['bad_hash'] ?></h3>
    <p>The security key and username combination you provided is invalid.</p>
    <p>If your email reader split the link we sent you over several lines, then
    perhaps it broke the link. Try to copy and paste it (as one line) into your browser and try again.
    </p>
    <p>Alternatively your security key may have expired. You can go to the
    <?php echo tina_mvc_make_controller_link($controller='register/recover-password', $link_text='recover password page', $extra_attribs='') ?>
    and try again with a new link.
    </p>

<?php endif; ?>
<?php if( $V['new_password_sent'] ): ?>

    <h3><?php echo $V['new_password_sent'] ?></h3>
    <p>We have reset your password and email you with your new login details.</p>

<?php endif; ?>

<p><?php echo tina_mvc_make_controller_link('', 'Need to login? Go here.') ?></p>
