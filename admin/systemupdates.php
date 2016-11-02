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
$licensing->forceRemoteCheck();
$aInt          = new WHMCS_Admin("Configure General Settings");
$aInt->title   = $aInt->lang('system', 'checkforupdates');
$aInt->sidebar = 'help';
$aInt->icon    = 'support';
ob_start();
infobox('Update Check', 'This page has been disabled. There is no reason to check for updates using this version.');
echo $infobox;
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
exit();
ob_start();
if(!$licensing->getKeyData('latestpublicversion')) {
	infoBox($aInt->lang('system', 'updatecheck'), $aInt->lang('system', 'connectfailed'), 'error');
	echo $infobox;
} else {
	echo "\n<br />\n\n";
	echo "<style>\n.versioncont {\n	margin:0 auto;\n	padding:0;\n	width:480px;\n}\n.versionyour {\n	float:left;\n	margin:0;\n	padding:10px 20px;\n	width:200px;\n	background-color:#535353;\n	border-bottom:1px solid #fff;\n	color: #fff;\n	font-size:20px;\n	text-align:right;\n	-moz-border-radius: 10px 0 0 0;\n	-webkit-border-radius: 10px 0 0 0;\n	-o-border-radius: 10p";
	echo "x 0 0 0;\n	border-radius: 10px 0 0 0;\n}\n.versionyournum {\n	float:left;\n	margin:0;\n	padding:5px 20px;\n	width:200px;\n	background-color:#666;\n	color: #fff;\n	font-family:Arial;\n	font-size:70px;\n	text-align:right;\n	-moz-border-radius: 0 0 0 10px;\n	-webkit-border-radius: 0 0 0 10px;\n	-o-border-radius: 0 0 0 10px;\n	border-radius: 0 0 0 10px;\n}\n.v";
	echo "ersionlatest {\n	float:left;\n	margin:0;\n	padding:10px 20px;\n	width:200px;\n	background-color:#035485;\n	border-bottom:1px solid #fff;\n	color: #fff;\n	font-size:20px;\n	text-align:left;\n	-moz-border-radius: 0 10px 0 0;\n	-webkit-border-radius: 0 10px 0 0;\n	-o-border-radius: 0 10px 0 0;\n	border-radius: 0 10px 0 0;\n}\n.versionlatestnum {\n	float:left;";
	echo "\n	margin:0;\n	padding:5px 20px;\n	width:200px;\n	background-color:#0467A2;\n	color: #fff;\n	font-family:Arial;\n	font-size:70px;\n	text-align:left;\n	-moz-border-radius: 0 0 10px 0;\n	-webkit-border-radius: 0 0 10px 0;\n	-o-border-radius: 0 0 10px 0;\n	border-radius: 0 0 10px 0;\n}\n.versionnoticecont {\n	width:700px;\n	margin:30px auto;\n}\n.newspost {\n";
	echo "	margin:10px auto;\n	padding:6px 15px;\n	width:80%;\n	background-color:#f8f8f8;\n	border:1px solid #ccc;\n	-moz-border-radius: 10px;\n	-webkit-border-radius: 10px;\n	-o-border-radius: 10px;\n	border-radius: 10px;\n}\n</style>\n\n<div class=\"versioncont\">\n<div class=\"versionyour\">";
	echo $aInt->lang('system', 'yourversion');
	echo "</div>\n<div class=\"versionlatest\">";
	echo $aInt->lang('system', 'latestversion');
	echo "</div>\n<div class=\"versionyournum\">";
	echo $CONFIG['Version'];
	echo "</div>\n<div class=\"versionlatestnum\">";
	echo $licensing->getKeyData('latestpublicversion');
	echo "</div>\n<div style=\"clear:both;\"></div>\n</div>\n\n";
	if($CONFIG['Version']!=$licensing->getKeyData('latestpublicversion')) {
		infoBox($aInt->lang('system', 'updatecheck'), $aInt->lang('system', 'upgrade') . " <a href=\"https://www.whmcs.com/members/clientarea.php\" target=\"_blank\">" . $aInt->lang('system', 'clickhere') . "</a>");
	} else {
		infoBox($aInt->lang('system', 'updatecheck'), $aInt->lang('system', 'runninglatestversion'));
	}
	echo "<div class=\"versionnoticecont\">" . $infobox . "</div>";
}
if(function_exists("json_decode")) {
	$feed = curlCall("https://www.whmcs.com/feeds/news.php", '');
	$feed = json_decode($feed, 1);
	$count = 0;
	foreach($feed as $news) {
		echo("<div class=\"newspost\"><h2>" . ($news["link"] ? "<a href=\"" . $news["link"] . "\" target=\"_blank\">" : '') . $news["headline"] . ($news["link"] ? "</a>" : '') . "</h2>\n    <p>" . $news["text"] . "</p>\n    <p style=\"font-size:10px;\">" . date("l, F jS, Y", strtotime($news["date"])) . "</p>\n    </div>\n    ");
		++$count;
	}
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();