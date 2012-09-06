<?php
//
// $Id: register_recover_password.php, v 0.00 Sat Jan 23 2010 22:36:42 GMT+0000 (IST) Francis Crossen $
//

/**
* Email Template: Someone requested a password reset. Here is a link
*
* @package    Tina-MVC
* @subpackage Tina-Core-Email-Templates
* @author     Francis Crossen <francis@crossen.org>
* @version    $Id: register_recover_password.php, v 0.00 Sat Jan 23 2010 22:34:31 GMT+0000 (IST) Francis Crossen $
* @since      Sat Jan 23 2010 22:34:31 GMT+0000 (IST)
* @access     public
* @see        http://www.SeeIT.org
*/


$V = & $message_variables;

$_sitename = get_option('blogname');
$_address =  get_option('home');
$urlencoded_username = urlencode( $V['username'] );
$_reset_link = tina_mvc_make_controller_url('register/reset-password/'.$urlencoded_username.'/'.$V['hash']);

// email templates must use double quotes

$e_subject = "[$_sitename] We have received a request to reset your password.";

$e_body = <<<EOD
Dear {$V['username']},

Someone visited '{$_sitename}' ({$_address}) and requested a
password reset for your account.

If you did not request a password reset, then just ignore this email and
nothing will happen. Otherwise click the following link to continue:

$_reset_link

Regards,
'{$_sitename}'
{$_address}

EOD;

?>
