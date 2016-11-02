<?php //00e56
// *************************************************************************
// *                                                                       *
// * WHMCS - The Complete Client Management, Billing & Support Solution    *
// * Copyright (c) WHMCS Ltd. All Rights Reserved,                         *
// * Version: 5.3.11                                                       *
// * BuildId: 4                                                            *
// * Build Date: 15 Dec 2014                                               *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: info@whmcs.com                                                 *
// * Website: http://www.whmcs.com                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.  This software  or any other *
// * copies thereof may not be provided or otherwise made available to any *
// * other person.  No title to and  ownership of the  software is  hereby *
// * transferred.                                                          *
// *                                                                       *
// * You may not reverse  engineer, decompile, defeat  license  encryption *
// * mechanisms, or  disassemble this software product or software product *
// * license.  WHMCompleteSolution may terminate this license if you don't *
// * comply with any of the terms and conditions set forth in our end user *
// * license agreement (EULA).  In such event,  licensee  agrees to return *
// * licensor  or destroy  all copies of software  upon termination of the *
// * license.                                                              *
// *                                                                       *
// * Please see the EULA file for the full End User License Agreement.     *
// *                                                                       *
// *************************************************************************
define('ADMINAREA', true);
require('../init.php');
if(!($whmcs instanceof WHMCS_Init)) {
	exit('Failed to initialize application.');
}
$aInt          = new WHMCS_Admin("Configure General Settings");
$aInt->title   = $aInt->lang('supportreq', 'title');
$aInt->sidebar = 'help';
$aInt->icon    = 'support';
ob_start();
infobox('Support Request', 'This page has been disabled. There is no reason to request support using this version.');
echo $infobox;
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
exit();
ob_start();
if($action == 'send') {
	if($name == "") {
		$errormessage .= $aInt->lang('supportreq', 'erroryourname') . ", ";
	}
	if($email == "") {
		$errormessage .= $aInt->lang('supportreq', 'erroryouremail') . ", ";
	}
	if($subject == "") {
		$errormessage .= $aInt->lang('supportreq', 'errorsubject') . ", ";
	}
	if($message == "") {
		$errormessage .= $aInt->lang('supportreq', 'errormessage') . ", ";
	}
	if($errormessage == "") {
		$mail           = new PHPMailer();
		$mail->From     = $email;
		$mail->FromName = $name;
		$mail->Subject  = $subject;
		$mail->CharSet  = $CONFIG['Charset'];
		if($CONFIG['MailType'] == 'mail') {
			$mail->Mailer = 'mail';
		} else if($CONFIG['MailType'] == 'smtp') {
			$mail->IsSMTP();
			$mail->Host = $CONFIG['SMTPHost'];
			$mail->Port = $CONFIG['SMTPPort'];
			if($CONFIG['SMTPSSL']) {
				$mail->SMTPSecure = $CONFIG['SMTPSSL'];
			}
			if($CONFIG['SMTPUsername']) {
				$mail->SMTPAuth = true;
				$mail->Username = $CONFIG['SMTPUsername'];
				$mail->Password = $CONFIG['SMTPPassword'];
			}
			$mail->Sender = $email;
		}
		$mail->Body = $message;
		$mail->AddAddress($department);
		$mail->Send();
		$mail->ClearAddresses();
		infoBox($aInt->lang('supportreq', 'submitsuccess'), $aInt->lang('supportreq', 'submitsuccessinfo'));
		echo $infobox;
		$sent = 'true';
	} else {
		infoBox($aInt->lang('supportreq', 'submiterror'), $errormessage);
		echo $infobox;
	}
}
if($sent != 'true') {
	if($errormessage == "") {
		$name    = $CONFIG['CompanyName'];
		$email   = $CONFIG['Email'];
		$message = $aInt->lang('supportreq', 'entermessage') . "\n\n### DEBUG INFORMATION ###\n\nRegistered to: " . $licensing->keydata['registeredname'] . "\nLicense Type: " . $licensing->keydata['productname'] . "\nLicense Key: " . $license . "\nLicense Expires: " . $licensing->keydata['nextduedate'] . "\nWHMCS URL: " . $CONFIG['SystemURL'] . "\nWHMCS Version: " . $CONFIG['Version'] . "\nPHP Version: " . phpversion() . "\nMySQL Version: " . mysql_get_server_info();
	}
	echo "\n<form method=\"post\" action=\"";
	echo $whmcs->getPhpSelf();
	echo "?action=send\">\n\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang('supportreq', 'yourname');
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"name\" size=\"40\" value=\"";
	echo $name;
	echo "\"></td></tr>\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang('supportreq', 'youremail');
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"email\" size=\"60\" value=\"";
	echo $email;
	echo "\"></td></tr>\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang('support', 'department');
	echo "</td><td class=\"fieldarea\">";
	echo "<select name=\"department\"><option value=\"support@whmcs.com\">";
	echo $aInt->lang('supportreq', 'support');
	echo "<option value=\"sales@whmcs.com\">";
	echo $aInt->lang('supportreq', 'sales');
	echo "<option value=\"licensing@whmcs.com\">";
	echo $aInt->lang('supportreq', 'licensing');
	echo "</select></td></tr>\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang('fields', 'subject');
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"subject\" size=\"80\" value=\"";
	echo $subject;
	echo "\"></td></tr>\n</table>\n\n<br />\n\n<textarea rows=\"20\" name=\"message\" style=\"width:100%;\">";
	echo $message;
	echo "</textarea>\n\n<p align=center><input type=\"submit\" value=\"";
	echo $aInt->lang('supportreq', 'send');
	echo "\" class=\"button\"> <input type=\"reset\" value=\"";
	echo $aInt->lang('supportreq', 'cancel');
	echo "\" class=\"button\"></p>\n\n<p>* ";
	echo $aInt->lang('supportreq', 'debuginfo');
	echo "</p>\n\n</form>\n\n";
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();