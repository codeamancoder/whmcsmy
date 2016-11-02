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
if(!defined('ROOTDIR')) {
	define('ROOTDIR', realpath(dirname(__FILE__)));
}
if(!defined('WHMCS')) {
	define('WHMCS', true);
}
function gracefulCoreRequiredFileInclude($path) {
	$fullpath = ROOTDIR . $path;
	if(file_exists($fullpath)) {
		include_once($fullpath);
	} else {
		exit('<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Down for Maintenance</strong><br>One or more required files are missing. If an install or upgrade is not currently in progress, please contact the system administrator.</div>');
	}
}
function getValidLanguages($admin = '') {
	$langs = WHMCS_Application::getinstance()->getValidLanguages($admin);
	return $langs;
}
function htmlspecialchars_array($arr) {
	return WHMCS_Application::getinstance()->sanitize_input_vars($arr);
}
gracefulCoreRequiredFileInclude('/includes/classes/WHMCS/Init.php');
gracefulCoreRequiredFileInclude('/includes/classes/WHMCS/Application.php');
gracefulCoreRequiredFileInclude('/includes/classes/WHMCS/Terminus.php');
spl_autoload_register(array('WHMCS_Application', 'loadClass'));
$terminus = WHMCS_Terminus::getinstance();
gracefulCoreRequiredFileInclude('/includes/dbfunctions.php');
gracefulCoreRequiredFileInclude('/includes/functions.php');
if(!defined('WHMCSDBCONNECT')) {
	if(defined('CLIENTAREA')) {
		gracefulCoreRequiredFileInclude('/includes/clientareafunctions.php');
	}
	if((defined('ADMINAREA')||defined('MOBILEEDITION'))) {
		gracefulCoreRequiredFileInclude('/includes/adminfunctions.php');
	}
}
$whmcs                = WHMCS_Application::getinstance();
$whmcsAppConfig       = $whmcs->getApplicationConfig();
$templates_compiledir = $whmcsAppConfig['templates_compiledir'];
$downloads_dir        = $whmcsAppConfig['downloads_dir'];
$attachments_dir      = $whmcsAppConfig['attachments_dir'];
$customadminpath      = $whmcsAppConfig['customadminpath'];
if(function_exists('mb_internal_encoding')) {
	$characterSet = ($whmcs->get_config('Charset') == '' ? 'UTF-8' : $whmcs->get_config('Charset'));
	mb_internal_encoding($characterSet);
}
$previousVersion = new WHMCS_Version_SemanticVersion('5.3.10-release.1');
if(WHMCS_Version_SemanticVersion::compare($whmcs->getDBVersion(), $previousVersion, '==')) {
	$whmcs->set_config('Version', $whmcs->getVersion()->getCanonical());
}
if($whmcs->doFileAndDBVersionsNotMatch()) {
	if(file_exists('../install/install.php')) {
		header('Location: ../install/install.php');
		exit();
	}
	exit('<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Down for Maintenance (Err 2)</strong><br>An upgrade is currently in progress... Please come back soon...</div>');
}
$licensing = WHMCS_License::getinstance();
if($licensing->getVersionHash() != '7a1bbff560de83ab800c4d1d2f215b91006be8e6') {
	$terminus->doDie('License Checking Error');
} elseif(empty($CONFIG['License'])) {
	/* Team ECHO : Ensure we are brandfree. */
	$licensing->forceRemoteCheck();
}
if(file_exists(ROOTDIR . '/install/install.php')) {
	exit('<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Security Warning</strong><br>The install folder needs to be deleted for security reasons before using WHMCS</div>');
}
if(!$whmcs->check_template_cache_writeable()) {
	exit('<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Permissions Error</strong><br>The templates compiling directory \'' . $whmcs->get_template_compiledir_name() . '\' must be writeable (CHMOD 777) before you can continue.<br>If the path shown is incorrect, you can update it in the configuration.php file.</div>');
}
if(((defined('CLIENTAREA')&&$CONFIG['MaintenanceMode'])&&!$_SESSION['adminid'])) {
	if($CONFIG['MaintenanceModeURL']) {
		header('Location: ' . $CONFIG['MaintenanceModeURL']);
		exit();
	}
	exit('<div style="border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#cc0000;"><strong>Down for Maintenance (Err 3)</strong><br>' . $CONFIG['MaintenanceModeMessage'] . '</div>');
}
if(defined('CLIENTAREA')&&isset($_SESSION['uid'])&&!isset($_SESSION['adminid'])) {
	$twofa = new WHMCS_2FA();
	$twofa->setClientID($_SESSION['uid']);
	if($twofa->isForced()&&!$twofa->isEnabled()&&$twofa->isActiveClients()) {
		if($whmcs->get_filename() == 'clientarea'&&($whmcs->get_req_var('action') == 'security'||$whmcs->get_req_var('2fasetup'))) {
		} else {
			redir('action=security&2fasetup=1&enforce=1', 'clientarea.php');
		}
	}
}
if(isset($_SESSION['currency'])&&is_array($_SESSION['currency'])) {
	$_SESSION['currency'] = $_SESSION['currency']['id'];
}
if(!isset($_SESSION['uid'])&&isset($_REQUEST['currency'])) {
	$result = select_query('tblcurrencies', 'id', array(
		'id' => (int) $_REQUEST['currency']
	));
	$data   = mysql_fetch_array($result);
	if($data['id']) {
		$_SESSION['currency'] = $data['id'];
	}
}
if(defined('CLIENTAREA')&&isset($_REQUEST['language'])) {
	$whmcs->set_client_language($_REQUEST['language']);
}
$whmcs->loadLanguage();
if(defined('CLIENTAREA')&&$whmcs->isSSLAvailable()) {
	if((WHMCS_Session::get('FORCESSL')&&$whmcs->getCurrentFilename() == 'index')) {
		define('FORCESSL', true);
	}
	$reqvars = $_REQUEST;
	if(array_key_exists('token', $reqvars)) {
		unset($reqvars[token]);
	}
	if(($whmcs->shouldSSLBeForcedForCurrentPage()||defined('FORCESSL'))) {
		if(!$whmcs->in_ssl()) {
			$whmcs->redirectSystemSSLURL($whmcs->getCurrentFilename(false), $reqvars);
		}
	} else {
		if($whmcs->shouldNonSSLBeForcedForCurrentPage()) {
			if($whmcs->in_ssl()) {
				$whmcs->redirectSystemURL($whmcs->getCurrentFilename(false), $reqvars);
			}
		}
	}
}
load_hooks();