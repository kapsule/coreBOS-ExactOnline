<?php
/*************************************************************************************************
 * Copyright 2015 MajorLabel -- This file is a part of MajorLabel coreBOS Customizations.
 * Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
 * file except in compliance with the License. You can redistribute it and/or modify it
 * under the terms of the License. MajorLabel reserves all rights not expressly
 * granted by the License. coreBOS distributed by MajorLabel is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
 * applicable law or agreed to in writing, software distributed under the License is
 * distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing
 * permissions and limitations under the License. You may obtain a copy of the License
 * at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
*************************************************************************************************
*  Author       : MajorLabel, Guido Goluke
*************************************************************************************************/
require_once("Smarty_setup.php");
require_once("include/utils/utils.php");
global $adb,$log,$current_language,$app_strings,$theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty = new vtigerCRM_Smarty();
$smarty->assign('APP', $app_strings);
$mod =  array_merge(
		return_module_language($current_language,'ExactOnline'),
		return_module_language($current_language,'Settings'));
$smarty->assign("MOD", $mod);
$smarty->assign("THEME",$theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE_NAME", 'ExactOnline');
$smarty->assign("MODULE_ICON", 'modules/ExactOnline/images/syncSettingsIcon.png');
$smarty->assign("MODULE_TITLE", $mod['syncsettings']);
$smarty->assign("MODULE_Description", $mod['syncsettingsdesc']);

// Get the previously saved start and end range for the general ledgers, if any
include_once('modules/ExactOnline/classes/ExactSettingsDB.class.php');
$SDB = new ExactSettingsDB();

$smarty->assign("gl_start_range", $SDB->getDbValue('glaccounts_start'));
$smarty->assign("gl_stop_range", $SDB->getDbValue('glaccounts_stop'));

// This part saves the start and end range for the general ledgers you want to sync
if ($_POST['setGLrange'] == true) {
	$adb->pquery('UPDATE vtiger_exactonline_settings SET glaccounts_start=?, glaccounts_stop=? WHERE exactonlineid=?', array($_POST['GLstart'], $_POST['GLstop'],0));
}

$smarty->display(vtlib_getModuleTemplate('ExactOnline', 'syncSettings.tpl'));
?>