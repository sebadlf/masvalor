<?php
//
// $Id: blank.php, v 0.00 Sun Feb 07 2010 12:22:43 GMT+0000 (IST) Francis Crossen $
//

/**
* A blank email template
*
* Allows sending of arbitrary emails by passing array( 'subject'=>'Subject', 'body'=>'Whatever' )
* to the template
*
* @package    Tina-MVC
* @subpackage Tina-Core-Email-Templates
*/

$_sitename = get_option('blogname');
$_address =  get_option('home');
$V = & $message_variables;

// email templates must use double quotes or the template variables will not get expanded

$e_subject = "[$_sitename] ".$V['subject'];

$e_body = <<<EOD
{$V['body']}
EOD;

?>
