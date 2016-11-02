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
$aInt          = new WHMCS_Admin("Addon Modules", false);
$aInt->title   = $aInt->lang('utilities', 'addonmodules');
$aInt->sidebar = 'addonmodules';
$aInt->icon    = 'addonmodules';
global $jquerycode;
global $jscode;
$jquerycode = $jscode = "";
ob_start();
if(!$module) {
	header("Location: configaddonmods.php");
	ob_end_clean();
	exit();
} else {
	$modulelink   = "addonmodules.php?module={$module}";
	$result       = select_query('tbladdonmodules', 'value', array(
		'module'=>$module,
		'setting'=>'access'
	));
	$data         = mysql_fetch_array($result);
	$allowedroles = explode(",", $data[0]);
	$result       = select_query('tbladmins', 'roleid', array(
		'id'=>$_SESSION['adminid']
	));
	$data         = mysql_fetch_array($result);
	$adminroleid  = $data[0];
	$modulepath   = ROOTDIR . "/modules/addons/{$module}/{$module}.php";
	if(file_exists($modulepath)) {
		require($modulepath);
		if(function_exists($module . '_config')) {
			$configarray = call_user_func($module . '_config');
			$aInt->title = $configarray['name'];
			if(in_array($adminroleid, $allowedroles)) {
				$modulevars = array(
					'modulelink'=>$modulelink
				);
				$result     = select_query('tbladdonmodules', "", array(
					'module'=>$module
				));
				while($data = mysql_fetch_array($result)) {
					$modulevars[$data['setting']] = $data['value'];
				}
				$_ADDONLANG    = array();
				$addonlangfile = ROOTDIR . "/modules/addons/{$module}/lang/" . $aInt->language . ".php";
				if(file_exists($addonlangfile)) {
					require($addonlangfile);
				} else if($configarray['language']) {
					$addonlangfile = ROOTDIR . "/modules/addons/{$module}/lang/" . $configarray['language'] . ".php";
					if(file_exists($addonlangfile)) {
						require($addonlangfile);
					}
				}
				if(count($_ADDONLANG)) {
					$modulevars['_lang'] = $_ADDONLANG;
				}
				if($modulevars['version']!=$configarray['version']) {
					if(function_exists($module . '_upgrade')) {
						call_user_func($module . '_upgrade', $modulevars);
					}
					update_query('tbladdonmodules', array(
						'value'=>$configarray['version']
					), array(
						'module'=>$module,
						'setting'=>'version'
					));
				}
				$sidebar = '';
				if(function_exists($module . '_sidebar')) {
					$sidebar = call_user_func($module . '_sidebar', $modulevars);
				}
				$aInt->assign('addon_module_sidebar', $sidebar);
				if($aInt->adminTemplate=='blend'&&$sidebar) {
					echo "<div style=\"float:right;margin:0 20px 0 0;width:200px;border:1px solid #ccc;background-color:#efefef;padding:10px;\">" . $sidebar . "</div>";
				}
				if(function_exists($module . '_output')) {
					call_user_func($module . '_output', $modulevars);
				} else {
					echo "<p>" . $aInt->lang('addonmodules', 'nooutput') . "</p>";
				}
			} else {
				echo "<br /><br />\r\n<p align=\"center\"><b>" . $aInt->lang('permissions', 'accessdenied') . "</b></p>\r\n<p align=\"center\">" . $aInt->lang('addonmodules', 'noaccess') . "</p>\r\n<p align=\"center\">" . $aInt->lang('addonmodules', 'howtogrant') . "</p>";
			}
		} else {
			echo "<p>" . $aInt->lang('addonmodules', 'error') . "</p>";
		}
	} else {
		$pagetitle = str_replace('_', " ", $module);
		$pagetitle = titleCase($pagetitle);
		echo "<h2>{$pagetitle}</h2>";
		if(in_array($adminroleid, $allowedroles)) {
			$modulepath = ROOTDIR . "/modules/admin/{$module}/{$module}.php";
			if(file_exists($modulepath)) {
				require($modulepath);
			} else {
				echo "<p>" . $aInt->lang('addonmodules', 'nooutput') . "</p>";
			}
		} else {
			echo "<br /><br />\r\n<p align=\"center\"><b>" . $aInt->lang('permissions', 'accessdenied') . "</b></p>\r\n<p align=\"center\">" . $aInt->lang('addonmodules', 'noaccess') . "</p>\r\n<p align=\"center\">" . $aInt->lang('addonmodules', 'howtogrant') . "</p>";
		}
	}
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content    = $content;
$aInt->jquerycode = $jquerycode;
$aInt->jscode     = $jscode;
$aInt->display();