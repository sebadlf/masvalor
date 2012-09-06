<?php
//
// $Id: user_register.php, v 0.00 Sat Jan 23 2010 22:34:31 GMT+0000 (IST) Francis Crossen $
//

/**
* Email Template: Thank you for registering
*
* @package    Tina-MVC
* @subpackage Tina-Core-Email-Templates
* @author     Francis Crossen <francis@crossen.org>
* @version    $Id: user_register.php, v 0.00 Sat Jan 23 2010 22:34:31 GMT+0000 (IST) Francis Crossen $
* @since      Sat Jan 23 2010 22:34:31 GMT+0000 (IST)
* @access     public
* @see        http://www.SeeIT.org
*/

$_sitename = get_option('blogname');
$_address =  get_option('home');
$_login_link = tina_mvc_make_controller_url('');
$V = & $message_variables;

// email templates must use double quotes

$e_subject = "[$_sitename] Your account has been created.";

$e_body = <<<EOD
Dear {$V['username']},

You (or possibly someone else using your email address) signed up for an 
account on '{$_sitename}' at '{$_address}'. This account is now 
ready.

To activate your account visit $_login_link and log-in.

Your username is: {$V['username']}
Your password is: {$V['password']}

You can change your password from your dashboard after you login.

If you didn't register with us then simply ignore this email.

Regards,
'{$_sitename}'
{$_address}

EOD;

?>
