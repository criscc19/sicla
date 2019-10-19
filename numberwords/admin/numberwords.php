<?php
/* Copyright (C) 2005-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2009 Regis Houssin        <regis@dolibarr.fr>
 * Copyright (C) 2007      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * or see http://www.gnu.org/
 */

/**
 *	\file       htdocs/numberwords/admin/numberwords.php
 *	\ingroup    numberwords
 *	\brief      Setup page for numberwords module
 */


$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res && file_exists("../../../../main.inc.php")) $res=@include("../../../../main.inc.php");
if (! $res && file_exists("../../../../../main.inc.php")) $res=@include("../../../../../main.inc.php");
if (! $res && preg_match('/\/nltechno([^\/]*)\//',$_SERVER["PHP_SELF"],$reg)) $res=@include("../../../../dolibarr".$reg[1]."/htdocs/main.inc.php"); // Used on dev env only
if (! $res) die("Include of main fails");
require_once(DOL_DOCUMENT_ROOT."/core/lib/admin.lib.php");
require_once(DOL_DOCUMENT_ROOT."/core/class/html.formadmin.class.php");

if (!$user->admin) accessforbidden();

$langs->load("admin");
$langs->load("other");
$langs->load("numberwords@numberwords");

$newvaltest='';
$outputlangs=new Translate('',$conf);
$outputlangs->setDefaultLang($langs->defaultlang);

$action=GETPOST('action');
$value=GETPOST('value');
$level=GETPOST('level','int');

if (empty($conf->numberwords->enabled))
{
	print "Error: Module is not enabled\n";
	exit;
}


/*
 * Actions
 */

if ($action == 'test')
{
	if (trim($value) == '')
	{
		setEventMessage($langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("Example")),'errors');
	}
	else
	{
		if ($_POST["lang_id"]) $outputlangs->setDefaultLang($_POST["lang_id"]);

		$object = new StdClass();
		if ($level)
		{
			$object->total_ttc=price2num($value);
			$source='__TOTAL_TTC_WORDS__';
		}
		else
		{
			$object->number=price2num($value);
			$source='__NUMBER_WORDS__';
		}

		$substitutionarray=array();
	    complete_substitutions_array($substitutionarray, $outputlangs, $object);
		$newvaltest=make_substitutions($source,$substitutionarray);
	}
}



/*
 * View
 */

llxHeader();

$object=new stdClass();
$object->number='989';
$object->total_ttc='989.99';
$substitutionarray=array();
complete_substitutions_array($substitutionarray, $outputlangs, $object);

$html=new Form($db);
$htmlother=new FormAdmin($db);

$linkback='<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print_fiche_titre($langs->trans("NumberWordsSetup"),$linkback,'setup');

print $langs->trans("DescNumberWords").'<br>';
print '<br>';


$h=0;
$head[$h][0] = $_SERVER["PHP_SELF"];
$head[$h][1] = $langs->trans("Setup");
$head[$h][2] = 'tabsetup';
$h++;

$head[$h][0] = 'about.php';
$head[$h][1] = $langs->trans("About");
$head[$h][2] = 'tababout';
$h++;

dol_fiche_head($head, 'tabsetup', '');


// Mode
print '<form action="'.$_SERVER["PHP_SELF"].'" method="post">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="test">';
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Type").'</td>';
print '<td>'.$langs->trans("Example").'</td>';
print '<td>'.$langs->trans("Language").'</td>';
print '<td>&nbsp;</td>';
print '<td>'.$langs->trans("Result").'</td>';
print "</tr>\n";

$var=true;

$var=!$var;
print '<tr '.$bc[$var].'><td width="140">'.$langs->trans("Number").'</td>';
print '<td>'.$object->number.'</td>';
print '<td>'.$outputlangs->defaultlang.'</td>';
print '<td>&nbsp;</td>';
$newval=make_substitutions('__NUMBER_WORDS__',$substitutionarray);
print '<td>'.$newval.'</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td width="140">'.$langs->trans("Amount").'</td>';
print '<td>'.$object->total_ttc.'</td>';
print '<td>'.$outputlangs->defaultlang.'</td>';
print '<td>&nbsp;</td>';
$newval=make_substitutions('__TOTAL_TTC_WORDS__',$substitutionarray);
print '<td>'.$newval.'</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
$val=$level;
print '<td><select class="flat" name="level" '.$option.'>';
print '<option value="0" '.($_POST["level"]=='0'?'SELECTED':'').'>'.$langs->trans("Number").'</option>';
print '<option value="1" '.($_POST["level"]=='1'?'SELECTED':'').'>'.$langs->trans("Amount").'</option>';
print '</select>';
print '</td>';
print '<td><input type="text" name="value" class="flat" value="'.$_POST["value"].'"></td>';
print '<td>';
print $htmlother->select_language($_POST["lang_id"]?$_POST["lang_id"]:$langs->defaultlang,'lang_id');
print '</td>';
print '<td><input type="submit" class="button" '.$option.' value="'.$langs->trans("ToTest").'"></td>';
print '<td><strong>'.$newvaltest.'</strong>';
print '</td>';
print '</tr>';

print '</table>';

print "</form>\n";

dol_fiche_end();

// Warning on accurancy
list($whole, $decimal) = explode('.', $value);
if ($level)
{
	if (strlen($decimal) > $conf->global->MAIN_MAX_DECIMALS_TOT)
	{
		print '<font class="warning">'.$langs->trans("Note").': '.$langs->trans("MAIN_MAX_DECIMALS_TOT").': '.$conf->global->MAIN_MAX_DECIMALS_TOT.'</font>';
		print ' - <a href="'.DOL_URL_ROOT.'/admin/limits.php">'.$langs->trans("SetupToChange").'</a>';
	}
	else
	{
		print '<font class="info">'.$langs->trans("Note").': '.$langs->trans("MAIN_MAX_DECIMALS_TOT").': '.$conf->global->MAIN_MAX_DECIMALS_TOT.'</font>';
		print ' - <a href="'.DOL_URL_ROOT.'/admin/limits.php">'.$langs->trans("SetupToChange").'</a>';
	}
}
print '<br>';
print '<font class="info">'.$langs->trans("CompanyCurrency").': '.$conf->currency.'</font>';
print ' - <a href="'.DOL_URL_ROOT.'/admin/company.php">'.$langs->trans("SetupToChange").'</a>';


llxFooter();

$db->close();
