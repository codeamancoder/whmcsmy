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
function getConfigurationFileContentWithNewLicenseKey($key) {
	$newline         = "\n";
	$display_errors  = false;
	$attachments_dir = $downloads_dir = $customadminpath = '';
	$db_host         = $db_username = $db_password = '';
	$db_name         = $cc_encryption_hash = $templates_compiledir = '';
	$mysql_charset   = $api_access_key = $autoauthkey = '';
	include(ROOTDIR . '/configuration.php');
	$output = sprintf('<?php%s$license = \'%s\';%s$db_host = \'%s\';%s$db_username = \'%s\';%s$db_password = \'%s\';%s$db_name = \'%s\';%s$cc_encryption_hash = \'%s\';%s$templates_compiledir = \'%s\';%s', $newline, $key, $newline, $db_host, $newline, $db_username, $newline, $db_password, $newline, $db_name, $newline, $cc_encryption_hash, $newline, $templates_compiledir, $newline);
	if($mysql_charset) {
		$output .= sprintf('$mysql_charset = \'%s\';%s', $mysql_charset, $newline);
	}
	if($attachments_dir) {
		$output .= sprintf('$attachments_dir = \'%s\';%s', $attachments_dir, $newline);
	}
	if($downloads_dir) {
		$output .= sprintf('$downloads_dir = \'%s\';%s', $downloads_dir, $newline);
	}
	if($customadminpath) {
		$output .= sprintf('$customadminpath = \'%s\';%s', $customadminpath, $newline);
	}
	if($api_access_key) {
		$output .= sprintf('$api_access_key = \'%s\';%s', $api_access_key, $newline);
	}
	if($autoauthkey) {
		$output .= sprintf('$autoauthkey = \'%s\';%s', $autoauthkey, $newline);
	}
	if($display_errors) {
		$output .= sprintf('$display_errors = %s;%s', 'true', $newline);
	}
	return $output;
}
define('ADMINAREA', true);
require('../init.php');
if(!($whmcs instanceof WHMCS_Init)) {
	exit('Failed to initialize application.');
}
$validLicenseErrorTypes = array('invalid', 'pending', 'suspended', 'expired', 'version', 'noconnection', 'change');
$licenseerror           = strtolower($whmcs->get_req_var('licenseerror'));
if(!in_array($licenseerror, $validLicenseErrorTypes)) {
	$licenseerror = $validLicenseErrorTypes[0];
}
$remote_ip               = WHMCS_Utility_Environment_CurrentUser::getip();
$performLicenseKeyUpdate = $whmcs->get_req_var('updatekey') === 'true';
$licenseChangeResult     = $match = $id = $roleid = '';
if($performLicenseKeyUpdate) {
	$authAdmin = new WHMCS_Auth();
	if(($authAdmin->getInfobyUsername($username) && $authAdmin->comparePassword($password))) {
		$roleid            = get_query_val('tbladmins', 'roleid', array(
			'id' => $authAdmin->getAdminID()
		));
		$result            = select_query('tbladminperms', 'COUNT(*)', array(
			'roleid' => $roleid,
			'permid' => '64'
		));
		$data              = mysql_fetch_array($result);
		$match             = $data[0];
		$newlicensekey     = trim($newlicensekey);
		$licenseKeyPattern = '/^[a-zA-Z0-9-]+$/';
		if(!$newlicensekey) {
			$licenseChangeResult = 'keyempty';
		} else {
			if(preg_match($licenseKeyPattern, $newlicensekey) !== 1) {
				$licenseChangeResult = 'keyinvalid';
			} else {
				if(!$match) {
					$licenseChangeResult = 'nopermission';
				} else {
					$newConfigurationContent = getConfigurationFileContentWithNewLicenseKey($newlicensekey);
					$fp                      = fopen('../configuration.php', 'w');
					fwrite($fp, $newConfigurationContent);
					fclose($fp);
					update_query('tblconfiguration', array(
						'value' => ''
					), array(
						'setting' => 'License'
					));
					redir('', 'index.php');
				}
			}
		}
	} else {
		$authAdmin->failedLogin();
		$licenseChangeResult = 'loginfailed';
	}
}
$licensing->forceRemoteCheck();
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>WHMCS - License ";
echo TitleCase($licenseerror);
echo "</title>\n";
echo "<style type=\"text/css\">\nbody {\n\tmargin: 0;\n	background-color: #F4F4F4;\n	background-image: url('images/loginbg.gif');\n	background-repeat: repeat-x;\n}\nbody, td, th {\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\n\tfont-size: 12px;\n\tcolor: #333;\n}\na, a:visited {\n\tcolor: #000066;\n\ttext-decoration: underline;\n}\na:hover {\n\ttext-decoration: none;\n}\nform {\n\tmargin: 0;\n\tpad";
echo "ding: 0;\n}\ninput, select {\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\n\tfont-size: 16px;\n}\n.login_inputs {\n\tpadding: 3px;\n	border: 1px solid #ccc;\n	font-size: 12px;\n}\n#logo {\n\ttext-align: center;\n	width: 420px;\n\tmargin: 30px auto 10px auto;\n\tpadding: 15px;\n}\n#login_container {\n\tcolor: #333;\n\tbackground-color: #fff;\n\ttext-align: left;\n\twidth: 430px;\n\tpadding: ";
echo "10px;\n\tmargin: 0 auto 10px auto;\n	-moz-border-radius: 10px;\n	-webkit-border-radius: 10px;\n	-o-border-radius: 10px;\n	border-radius: 10px;\n}\n#login_container #login {\n\ttext-align: left;\n\tmargin: 0;\n\tpadding: 20px 10px 20px 10px;\n}\n#login_container #login_msg {\n	background-color: #FAF4B8;\n	text-align: center;\n	padding: 10px;\n	margin: 0 0 1px 0;\n	-moz-border";
echo "-radius: 10px;\n	-webkit-border-radius: 10px;\n	-o-border-radius: 10px;\n	border-radius: 10px;\n}\n#login_container #extra_info {\n\tbackground-color: #D3D3D3;\n\ttext-align: left;\n\tpadding: 10px;\n\tmargin: 1px 0 0 0;\n	-moz-border-radius: 10px;\n	-webkit-border-radius: 10px;\n	-o-border-radius: 10px;\n	border-radius: 10px;\n}\n</style>\n</head>\n<body>\n<div id=\"logo\"><a href=\"logi";
echo "n.php\"><img src=\"images/loginlogo.png\" alt=\"WHMCS\" border=\"0\" /></a></div>\n<div id=\"login_container\">\n  <div id=\"login_msg\">\n	";
echo "<span style=\"font-size:14px;\">";
echo "<strong>License ";
echo TitleCase($licenseerror);
echo '</strong></span>
';
$changeError = '';
if($licenseChangeResult) {
	switch($licenseChangeResult) {
		case 'loginfailed': {
			$changeError = 'Login Details Incorrect';
			break;
		}
		case 'keyinvalid': {
			$changeError = 'You did not enter a valid license key';
			break;
		}
		case 'keyempty': {
			$changeError = 'You did not enter a new license key';
			break;
		}
		case 'nopermission': {
			$changeError = 'You do not have permission to make this change';
		}
	}
}
if($changeError) {
	echo '<span style="font-size: 14px; font-weight: bold;"> Failed</span><br />' . $changeError;
}
echo '        </div>
        <div id="login">

';
if($licenseerror == 'suspended') {
	echo '<p>Your license key has been suspended.  Possible reasons for this include:</p>
            <ul>
                <li>Your license is overdue on payment</li>
                <li>Your license has been suspended for being used on a banned
                    domain</li>
                <li>Your license was found to be being used against the End User
                    License Agreement</li>
            </ul>
            <p>
                Got a new license key? <a
                    href="licenseerror.php?licenseerror=change">Click here to enter it</a>
            </p>
';
} else {
	if($licenseerror == 'pending') {
		echo '<p>The WHMCS License Key you just tried to access is still pending. This error occurs when we have not yet received the payment for your license.</p>
            <p>
                Got a new license key? <a
                    href="licenseerror.php?licenseerror=change">Click here to enter it</a>
            </p>
';
	} else {
		if($licenseerror == 'invalid') {
			echo '<p>Your license key is invalid. Possible reasons for this include:</p>
            <ul>
                <li>The license key has been entered incorrectly</li>
                <li>The domain being used to access your install has changed</li>
                <li>The IP address your install is located on has changed</li>
                <li>The directory you are using has changed</li>
            </ul>
            <p>
                If required, you can reissue your license on-demand from our client
                area @ <a href="http://nullrefer.com/?https://www.whmcs.com/members/clientarea.php"
                    target="_blank">www.whmcs.com/members/clientarea.php</a> which will
                update the allowed location details.
            </p>
            <p>
                Got a new license key? <a
                    href="licenseerror.php?licenseerror=change">Click here to enter it</a>
            </p>
';
		} else {
			if($licenseerror == 'expired') {
				echo '<p>Your license key has expired!  To resolve this you can:</p>
            <ul>
                <li>Check your email for a copy of the invoice or payment reminders</li>
                <li>Order a new license from <a href="http://nullrefer.com/?http://www.whmcs.com/order/"
                    target="_blank">www.whmcs.com/order</a></li>
            </ul>
            <p>
                If you feel this message to be an error, please contact us @ <a
                    href="http://nullrefer.com/?http://www.whmcs.com/get-support" target="_blank">www.whmcs.com/get-support</a>
            </p>
            <p>
                Got a new license key? <a
                    href="licenseerror.php?licenseerror=change">Click here to enter it</a>
            </p>
';
			} else {
				if($licenseerror == 'version') {
					echo '<p>
                You are using an Owned License for which the support & updates
                validity period expired before this release. Therefore in order to
                use this version of WHMCS, you first need to renew your support &
                updates access. You can do this from our client area @ <a
                    href="http://nullrefer.com/?https://www.whmcs.com/members/clientarea.php" target="_blank">www.whmcs.com/members/clientarea.php</a>
            </p>
            <p>
                If you feel this message to be an error, please contact us @ <a
                    href="http://nullrefer.com/?http://www.whmcs.com/get-support" target="_blank">www.whmcs.com/get-support</a>
            </p>
            <p>
                Got a new license key? <a
                    href="licenseerror.php?licenseerror=change">Click here to enter it</a>
            </p>
';
				} else {
					if($licenseerror == 'noconnection') {
						echo '<p>WHMCS has not been able to verify your license for the last few days.</p>
            <p>Before you can access your WHMCS Admin Area again, the license
                needs to be validated successfully. Please check & ensure that you
                don\'t have a firewall or DNS rule blocking outgoing connections to
                our website.</p>
            <p>
                For further assistance, please visit <a
                    href="http://nullrefer.com/?http://docs.whmcs.com/Licensing#Common_Errors"
                    target="_blank">http://docs.whmcs.com/Licensing</a>
            </p>
';
					} else {
						if($licenseerror == 'change') {
							echo '<p>You can change your license key by entering your admin login details
                and new key below. Requires full admin access permissions.</p>
';
							if(is_writable('../configuration.php')) {
							} else {
								echo '<p
                align=center style="color: #cc0000">
                <b>You must set the permissions for the configuration.php file to
                    777 so it can be written to before you can change your license key</b>
            </p>';
							}
							echo '
<form method="post"
                action="';
							echo $whmcs->getPhpSelf();
							echo '?licenseerror=change&updatekey=true">
                <table align=center>
                    <tr>
                        <td align="right">Username:</td>
                        <td><input type="text" name="username"></td>
                    </tr>
                    <tr>
                        <td align="right">Password:</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td align="right">New License Key:</td>
                        <td><input type="text" name="newlicensekey"></td>
                    </tr>
                </table>
                <p align="center">
                    <input type="submit" value="Change License Key">
                </p>
            </form>
';
						}
					}
				}
			}
		}
	}
}
echo '  </div>
</body>
</html>';