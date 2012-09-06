<?php
//
// $Id: register_reset_password.php, v 0.00 Sat Jan 23 2010 22:35:27 GMT+0000 (IST) Francis Crossen $
//

/**
* Email Template: Your password was reset. Here is your new password
*
* @package    Tina-MVC
* @subpackage Tina-Core-Email-Templates
* @author     Francis Crossen <francis@crossen.org>
* @version    $Id: register_reset_password.php, v 0.00 Sat Jan 23 2010 22:34:31 GMT+0000 (IST) Francis Crossen $
* @since      Sat Jan 23 2010 22:34:31 GMT+0000 (IST)
* @access     public
* @see        http://www.SeeIT.org
*/

$_sitename = get_option('blogname');
$_address =  get_option('home');
$_login_link = tina_mvc_make_controller_url('');
$V = & $message_variables;

// email templates must use double quotes

$e_subject = "[$_sitename] Your new password.";

$e_body = <<<EOD
Dear {$V['username']},

Your password has been successfully reset. Your new login details are here:

Your username is: {$V['username']}
Your password is: {$V['password']}

To login to your account visit $_login_link.

You can change your password from your dashboard after you login.

Regards,
'{$_sitename}'
{$_address}

EOD;

?>
