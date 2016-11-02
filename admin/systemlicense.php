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
$aInt          = new WHMCS_Admin('Main Homepage');
$aInt->title   = $aInt->lang('license', 'title');
$aInt->sidebar = 'help';
$aInt->icon    = 'support';
ob_start();
echo '
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="20%" class="fieldlabel">';
echo $aInt->lang('license', 'regto');
echo '</td><td class="fieldarea">';
echo $licensing->getRegisteredName();
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'key');
echo '</td><td class="fieldarea">';
echo $licensing->getLicenseKey();
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'type');
echo '</td><td class="fieldarea">';
echo $licensing->getProductName();
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'validdomain');
echo '</td><td class="fieldarea">';
echo (count($licensing->getKeyData('validdomains')) ? implode('<br />', $licensing->getKeyData('validdomains')) : 'None');
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'validip');
echo '</td><td class="fieldarea">';
echo (count($licensing->getKeyData('validips')) ? implode('<br />', $licensing->getKeyData('validips')) : 'None');
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'validdir');
echo '</td><td class="fieldarea">';
echo (count($licensing->getKeyData('validdirs')) ? implode('<br />', $licensing->getKeyData('validdirs')) : 'None');
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'brandingremoval');
echo '</td><td class="fieldarea">';
echo ($licensing->getBrandingRemoval() ? 'Yes' : 'No');
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'addons');
echo '</td><td class="fieldarea">';
echo (count($licensing->getActiveAddons()) ? implode('<br />', $licensing->getActiveAddons()) : 'None');
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'created');
echo '</td><td class="fieldarea">';
echo date('l, jS F Y', strtotime($licensing->getKeyData('regdate')));
echo '</td></tr>
<tr><td class="fieldlabel">';
echo $aInt->lang('license', 'expires');
echo '</td><td class="fieldarea">';
echo $licensing->getExpiryDate(true);
echo '</td></tr>
</table>

<p>';
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();