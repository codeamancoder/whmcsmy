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
if(!function_exists('curl_init')) {
	echo '<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Critical Error</strong><br>CURL is not installed or is disabled on your server and it is required for WHMCS to run</div>';
	exit();
}
$result = select_query('tblconfiguration', 'COUNT(*)', array(
	'setting'=>'License'
));
$data   = mysql_fetch_array($result);
if(!$data[0]) {
	insert_query('tblconfiguration', array(
		'setting'=>'License'
	));
}
$licensing->remoteCheck();
if($licensing->getStatus()!='Active') {
	redir('licenseerror=' . $licensing->getStatus(), 'licenseerror.php');
}
if(!$licensing->checkOwnedUpdates()) {
	redir('licenseerror=version', 'licenseerror.php');
}
$adminfolder = $whmcs->get_admin_folder_name();
if((isset($_SESSION['adminid'])&&!isset($_SESSION['2fabackupcodenew']))) {
	redir('', 'index.php');
}
if(($CONFIG['AdminForceSSL']&&$CONFIG['SystemSSLURL'])) {
	if((!$_SERVER['HTTPS']||$_SERVER['HTTPS']=='off')) {
		header('Location: ' . $CONFIG['SystemSSLURL'] . '/' . $adminfolder);
		exit();
	}
}
$disableadminforgottenpw = ($whmcs->get_config('DisableAdminPWReset') ? true : false);
$action                  = $whmcs->get_req_var('action');
$sub                     = $whmcs->get_req_var('sub');
$incorrect               = $whmcs->get_req_var('incorrect');
$logout                  = $whmcs->get_req_var('logout');
$email                   = $whmcs->get_req_var('email');
$timestamp               = $whmcs->get_req_var('timestamp');
$verify                  = $whmcs->get_req_var('verify');
if(($action&&$disableadminforgottenpw)) {
	$action = '';
}
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WHMCS - Login</title>
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<style type="text/css">
body {
margin: 0;
background-color: #F4F4F4;
background-image: url(\'images/loginbg.gif\');
background-repeat: repeat-x;
}
body, td, th {
font-family: Tahoma, Arial, Helvetica, sans-serif;
font-size: 12px;
color: #333;
}
a, a:visited {
color: #000066;
text-decoration: underline;
}
a:hover {
text-decoration: none;
}
form {
margin: 0;
padding: 0;
}
input, select {
font-family: Tahoma, Arial, Helvetica, sans-serif;
font-size: 16px;
}
.login_inputs {
padding: 3px;
border: 1px solid #ccc;
font-size: 12px;
}
#logo {
text-align: center;
width: 420px;
margin: 30px auto 10px auto;
padding: 15px;
}
#login_container {
color: #333;
background-color: #fff;
text-align: left;
width: 430px;
padding: 10px;
margin: 0 auto 10px auto;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
-o-border-radius: 10px;
border-radius: 10px;
}
#login_container #login {
text-align: left;
margin: 0;
padding: 20px 10px 20px 10px;
}
#login_container #login_msg {
background-color: #FAF4B8;
text-align: center;
padding: 10px;
margin: 0 0 1px 0;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
-o-border-radius: 10px;
border-radius: 10px;
}
#login_container #extra_info {
background-color: #D3D3D3;
text-align: left;
padding: 10px;
margin: 1px 0 0 0;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
-o-border-radius: 10px;
border-radius: 10px;
}
</style>
<script language="javascript">
function sf(){ document.frmlogin.username.focus(); }
</script>
</head>
<body';
if(!$action) {
	echo ' onload="sf()"';
}
echo '>
<div id="logo"><a href="login.php"><img src="images/loginlogo.png" alt="WHMCS" border="0" /></a></div>
<div id="login_container">
';
$msgtitle = $msg = $reset = '';
if((((($action=='reset'&&!$disableadminforgottenpw)&&$email)&&$timestamp)&&$verify)) {
	$result    = select_query('tbladmins', '', array(
		'email'=>$email,
		'disabled'=>'0'
	));
	$data      = mysql_fetch_array($result);
	$adminid   = $data['id'];
	$firstname = $data['firstname'];
	$lastname  = $data['lastname'];
	$username  = $data['username'];
	$email     = $data['email'];
	$verifyval = md5($email . $timestamp . $adminid . $cc_encryption_hash);
	if((($adminid&&$verify==$verifyval)&&mktime(date('H'), date('i')-30, date('s'), date('m'), date('d'), date('Y'))<=$timestamp)) {
		$length      = 10;
		$seeds       = 'ABCDEFGHIJKLMNPQRSTUVYXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$str         = null;
		$seeds_count = strlen($seeds)-1;
		$i           = 0;
		while($i<$length) {
			$str .= $seeds[rand(0, $seeds_count)];
			++$i;
		}
		$newpassword = $str;
		update_query('tbladmins', array(
			'password'=>md5($newpassword),
			'loginattempts'=>'0'
		), array(
			'email'=>$email
		));
		$message .= 'Dear ' . $firstname . ',

As requested, your password for the admin area has now been reset.  Your new login details are as follows:

' . $CONFIG['SystemURL'] . (('/' . $adminfolder . '/
Username: ' . $username . '
Password: ' . $newpassword . '
') . '
You can change your password after login from the My Account section of the admin area.');
		$mail = new WHMCS_Mail($CONFIG['SystemEmailsFromName'], $CONFIG['SystemEmailsFromEmail']);
		$mail->Subject = 'Admin Password Reset Completed';
		$mail->Body    = $message;
		$mail->AddAddress($email);
		if(!$mail->Send()) {
			$msg = 'There was an error sending the email. Please try again.';
		} else {
			$msg = 'Success! Please check your email for the newly generated password.';
			logActivity('Password Reset Completed for Admin Username ' . $username);
		}
		$mail->ClearAddresses();
	} else {
		$msg = 'Invalid or Expired Link Followed. Please try again.';
	}
	$action   = '';
	$reset    = true;
	$msgtitle = 'Password Reset';
}
if(!$action) {
	if(isset($_SESSION['2faverify'])) {
		if(isset($_SESSION['2fabackupcodenew'])) {
			$msgtitle = 'Login Successful';
			$msg      = 'Backup Codes are valid once only. It will now be reset.';
		} else {
			$msgtitle = 'Two Factor Authentication';
			$msg      = ($incorrect ? 'The second factor you supplied was incorrect. Please try again.' : 'Your second factor is required to complete login.');
		}
	} else {
		if($incorrect) {
			$msgtitle = 'Login Failed. Please Try Again.';
			$msg      = 'Your IP has been logged and admins notified of this<br />failed login attempt.';
		} else {
			if($logout) {
				$msgtitle = 'Logged Out';
				$msg      = 'You have been successfully logged out.';
			} else {
				if($reset) {
				} else {
					$msgtitle = 'Welcome Back';
					$msg      = 'Please enter your login details below to authenticate.';
				}
			}
		}
	}
	echo '<div id="login_msg"><span style="font-size:14px;"><strong>' . $msgtitle . '</strong></span><br>' . $msg . '</div>';
	if(isset($_SESSION['2fabackupcodenew'])) {
		$twofa = new WHMCS_2FA();
		if($twofa->setAdminID($_SESSION['2faadminid'])) {
			$backupcode = $twofa->generateNewBackupCode();
			echo '<div id="login"><p align="center">Your New Backup Code is:</p><div style="margin:20px auto;padding:10px;width:280px;background-color:#F2D4CE;border:1px dashed #AE432E;text-align:center;font-size:20px;">' . $backupcode . '</div><p align="center">Write this down on paper and keep it safe.<br />It will be needed if you ever lose your 2nd factor device or it is unavailable to you again in future.</p><form method="post" action="dologin.php"><p align="center"><input type="submit" value="Continue to Admin Area &raquo;" /></p></form></div>';
		} else {
			echo '<div id="login">An error occurred. Please try again.</div>';
		}
	} else {
		if(isset($_SESSION['2faverify'])) {
			$twofa = new WHMCS_2FA();
			if($twofa->setAdminID($_SESSION['2faadminid'])) {
				if((!$twofa->isActiveAdmins()||!$twofa->isEnabled())) {
					WHMCS_Session::destroy();
					redir();
				}
				if($whmcs->get_req_var('backupcode')) {
					echo '<div id="login"><form method="post" action="dologin.php"><input type="hidden" name="backupcode" value="1" /><p align="center"><input type="text" name="code" size="25" /> <input type="submit" value="Login &raquo;" /></p><p align="center">Enter Your Backup Code Above to Login</p></form></div>';
				} else {
					$challenge = $twofa->moduleCall('challenge');
					if($challenge) {
						echo '<div id="login">' . $challenge . '<p align="center">Can\'t Access Your 2nd Factor Device? <a href="login.php?backupcode=1">Login using Backup Code</a></p></div>';
					} else {
						echo '<div id="login">Bad 2 Factor Auth Module. Please contact support.</div>';
					}
				}
			} else {
				echo '<div id="login">An error occurred. Please try again.</div>';
			}
		} else {
			echo '  <div id="login">
<form action="dologin.php" method="post" name="frmlogin" id="frmlogin">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td width="30%" align="right" valign="middle"><strong>Username</strong></td>
<td align="left" valign="middle"><input type="text" name="username" size="30" class="login_inputs" /></td>
</tr>
<tr>
<td width="30%" align="right" valign="middle"><strong>Password</strong></td>
<td align="left" valign="middle"><input type="password" name="password" size="30" class="login_inputs" /></td>
</tr>
<tr>
<td width="30%" align="right" valign="middle"><input type="checkbox" name="rememberme" id="rememberme" /></td>
<td align="left" valign="middle"><label for="rememberme" style="cursor:hand">Remember me until I logout.</label></td>
</tr>
<tr>
<td width="30%" align="right" valign="middle">&nbsp;</td>
<td align="left" valign="middle"><table width="100%" cellpadding="0" cellspacing="0"><tr><td><input type="submit" value="Login" class="button" /></td><td align="right">Language: <select name="language" class="login_inputs"><option value="">Default</option>';
			$adminlangs = array();
			$dh         = opendir('lang/');
			while(false!==($file = readdir($dh))) {
				if(is_file('lang/' . $file)) {
					$extension = explode('.', $file);
					$extension = end($extension);
					if($extension=='php') {
						$adminlangs[] = substr($file, 0, 0-4);
					}
				}
			}
			sort($adminlangs);
			foreach($adminlangs as $temp) {
				echo '<option value="' . $temp . '">' . ucfirst($temp) . '</option>';
			}
			closedir($dh);
			echo '</select></td></tr></table></td>
</tr>
</table>
</form>
</div>
';
		}
	}
} else {
	if(($action=='reset'&&!$disableadminforgottenpw)) {
		echo '<div id="login_msg"><span style="font-size:14px;"><strong>';
		if($sub=='send') {
			$result    = select_query('tbladmins', '', array(
				'email'=>$email
			));
			$data      = mysql_fetch_array($result);
			$adminid   = $data['id'];
			$firstname = $data['firstname'];
			$lastname  = $data['lastname'];
			$username  = $data['username'];
			$emailaddr = $data['email'];
			$disabled  = $data['disabled'];
			if($disabled==1) {
				echo 'Administrator Disabled</strong></span><br>Your Administrative account has been disabled.<br />';
			} else {
				if(!$adminid) {
					logActivity('Admin Password Reset Attempted for invalid Email: ' . $email);
					echo 'Email Address Not Found</strong></span><br>Your IP has been logged and admins notified of this<br />failed reset attempt.';
				} else {
					$timestamp = time();
					$hash      = md5($email . $timestamp . $adminid . $cc_encryption_hash);
					$url       = ($CONFIG['SystemSSLURL'] ? $CONFIG['SystemSSLURL'] : $CONFIG['SystemURL']);
					$url .= '/' . $adminfolder . '/login.php?action=reset&email=' . $email . '&timestamp=' . $timestamp . '&verify=' . $hash;
					$message       = ('Dear ' . $firstname . ',

A request was recently made to reset the password for admin username \'' . $username . '\'.

To confirm the request and complete the reset process, simply visit the url below:
' . $url . '
') . '
This link will only be valid for the next 30 minutes so if you didn\'t request this reset, you can simply ignore this email.

' . $CONFIG['SystemURL'] . ('/' . $adminfolder . '/');
					$mail          = new WHMCS_Mail($CONFIG['SystemEmailsFromName'], $CONFIG['SystemEmailsFromEmail']);
					$mail->Subject = 'Admin Password Reset Request';
					$mail->Body    = $message;
					$mail->AddAddress($email);
					if(!$mail->Send()) {
						echo 'Password Reset</strong></span><br />There was an error sending the email. Please try again.';
					} else {
						echo 'Password Reset</strong></span><br />Success! Please check your email for the next step...';
						logActivity('Password Reset Initiated for Admin Username ' . $username);
					}
					$mail->ClearAddresses();
				}
			}
		} else {
			echo 'Password Reset</strong></span><br>Enter your email address below to begin the process';
		}
		echo '  </div>
<div id="login">
<form action="login.php" method="post" name="frmlogin" id="frmlogin">
<input type="hidden" name="action" value="reset" />
<input type="hidden" name="sub" value="send" />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td width="30%" align="right" valign="middle">';
		echo '<strong>Email</strong></td>
<td align="left" valign="middle"><input type="text" name="email" size="30" /></td>
</tr>
<tr>
<td width="30%" align="right" valign="middle">&nbsp;</td>
<td align="left" valign="middle"><input type="submit" value="Reset Password" class="button" /></td>
</tr>
</table>
</form>
</div>
';
	}
}
echo '  <div id="extra_info">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left" valign="middle">IP Logged: ';
echo '<strong>';
echo $remote_ip;
echo '</strong></td>
</tr>
</table>
</div>
</div>
<div align="center">';
if(($CONFIG['SystemSSLURL']&&!$CONFIG['AdminForceSSL'])) {
	echo '<a href="';
	echo $CONFIG['SystemSSLURL'] . '/' . $adminfolder;
	echo '">Secure SSL Access</a>';
}
if(!$disableadminforgottenpw) {
	if(($CONFIG['SystemSSLURL']&&!$CONFIG['AdminForceSSL'])) {
		echo ' | ';
	}
	echo '<a href="login.php?action=reset">Forgot your password?</a>';
}
echo '</div>
</body>
</html>';