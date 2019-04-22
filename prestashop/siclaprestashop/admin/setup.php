<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    htdocs/modulebuilder/template/admin/setup.php
 * \ingroup siclaprestashop
 * \brief   siclaprestashop setup page.
 */

// Load Dolibarr environment
$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/main.inc.php";
if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include dirname(substr($tmp, 0, ($i+1)))."/main.inc.php";
// Try main.inc.php using relative path
if (! $res && file_exists("../../main.inc.php")) $res=@include "../../main.inc.php";
if (! $res && file_exists("../../../main.inc.php")) $res=@include "../../../main.inc.php";
if (! $res) die("Include of main fails");

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/siclaprestashop.lib.php';
//require_once "../class/myclass.class.php";

// Translations
$langs->loadLangs(array("admin", "siclaprestashop@siclaprestashop"));

// Access control
if (! $user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');
$url = GETPOST('url');
$token = GETPOST('token');
$actualizar = GETPOST('actualizar');
if($action=='update'){

$res = $db->query('UPDATE llx_siclaprestashop_ajustes SET url="'.$url.'",token="'.$token.'",actualizar="'.$actualizar.'"');
if($res > 0){setEventMessages('Ajustes actualizados','');}
else{setEventMessages($db->error, $db->errors, 'errors');}
}

/*
 * Actions
 */
if ((float) DOL_VERSION >= 6)
{
	include DOL_DOCUMENT_ROOT.'/core/actions_setmoduleoptions.inc.php';
}


/*
 * View
 */

$page_name = "Configuracion de webservice";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.($backtopage?$backtopage:DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, 'object_siclaprestashop@siclaprestashop');

// Configuration header
$head = siclaprestashopAdminPrepareHead();
dol_fiche_head($head, 'settings', '', -1, "siclaprestashop@siclaprestashop");

$sq = 'SELECT rowid,url,token,actualizar from llx_siclaprestashop_ajustes';
$sql = $db->query($sq);

for ($p = 1; $p <= $db->num_rows($sql); $p++) {
$obl = $db->fetch_object($sql);
$rowid = $obl->rowid;
$url = $obl->url;
$token = $obl->token;
$actualizar = $obl->actualizar;
}

// Setup page goes here
echo $langs->trans("Configuracion de webservice").'<br><br>';

	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
	print '<input type="hidden" name="action" value="update">';

	print '<table class="noborder" width="100%">';
	print '<tr class="liste_titre"><td class="titlefield">'.$langs->trans("Parameter").'</td><td>'.$langs->trans("Value").'</td></tr>';

		print '<tr class="oddeven"><td>';
		print 'URL de la tienda';
		print '</td><td><input name="url"  class="flat" value="'.$url.'" placeholder="http://tienda.com"></td></tr>';
		
		print '<tr class="oddeven"><td>';
		print 'Token generado por el webservice';
		print '</td><td><input name="token"  class="flat" value="'.$token.'"></td></tr>';
		
		print '<tr class="oddeven"><td>';
		print 'Sincronizar automaticamente';
		print '</td><td><select name="actualizar">';
		print '<option value="0"'; 
		if($actualizar==0) echo
		' selected="selected"';
		print'>NO</option>';
		print '<option value="1"'; 
		if($actualizar==1) echo
		' selected="selected"';
		print'>SI</option>';		
		print'</select></tr>';		
		
	print '</table>';

	print '<br><div class="center">';
	print '<input class="button" type="submit" value="'.$langs->trans("Save").'">';
	print '</div>';

	print '</form>';
	print '<br>';





// Page end
dol_fiche_end();

llxFooter();
$db->close();

