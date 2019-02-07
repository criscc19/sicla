<?php
require 'main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/menu.class.php';


        $menu = new Menu();
 
	// Put here left menu entries
	// ***** START *****
 
	global $user,$conf,$langs,$dolibarr_main_db_name,$db;

	$mainmenu=(empty($_SESSION["mainmenu"])?'':$_SESSION["mainmenu"]);
	$leftmenu=(empty($_SESSION["leftmenu"])?'':$_SESSION["leftmenu"]);

	$id='mainmenu';
	$listofmodulesforexternal=explode(',',$conf->global->MAIN_MODULES_FOR_EXTERNAL);


	$usemenuhider = (GETPOST('testmenuhider','int') || ! empty($conf->global->MAIN_TESTMENUHIDER));

	// Show/Hide vertical menu
	if ($mode != 'jmobile' && $mode != 'topnb' && $usemenuhider && empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER))
	{
    	$showmode=1;
    	$classname = 'class="tmenu menuhider"';
    	$idsel='menu';

    	$menu->add('#', '', 0, $showmode, $atarget, "xxx", '', 0, $id, $idsel, $classname);
	}

	// Home
	$showmode=1;
	$classname="";
	if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "home") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
	else $classname = 'class="tmenu"';
	$idsel='home';

	$titlehome = $langs->trans("Home");
	if (! empty($conf->global->THEME_TOPMENU_DISABLE_IMAGE)) $titlehome = '&nbsp; <span class="fa fa-home"></span> &nbsp;';
	$menu->add('/index.php?mainmenu=home&amp;leftmenu=home', $titlehome, 0, $showmode, $atarget, "home", '', 10, $id, $idsel, $classname);

	// Members
	$tmpentry=array('enabled'=>(! empty($conf->adherent->enabled)),
	'perms'=>(! empty($user->rights->adherent->lire)),
	'module'=>'adherent');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "members") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='members';

		$menu->add('/adherents/index.php?mainmenu=members&amp;leftmenu=', $langs->trans("MenuMembers"), 0, $showmode, $atarget, "members", '', 18, $id, $idsel, $classname);
	}

	// Third parties
	$tmpentry=array('enabled'=>(( ! empty($conf->societe->enabled) && (empty($conf->global->SOCIETE_DISABLE_PROSPECTS) || empty($conf->global->SOCIETE_DISABLE_CUSTOMERS))) || ! empty($conf->fournisseur->enabled)), 'perms'=>(! empty($user->rights->societe->lire) || ! empty($user->rights->fournisseur->lire)), 'module'=>'societe|fournisseur');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
	    // Load translation files required by the page
        $langs->loadLangs(array("companies","suppliers"));

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "companies") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='companies';

		$menu->add('/societe/index.php?mainmenu=companies&amp;leftmenu=', $langs->trans("ThirdParties"), 0, $showmode, $atarget, "companies", '', 20, $id, $idsel, $classname);
	}

	// Products-Services
	$tmpentry=array('enabled'=>(! empty($conf->product->enabled) || ! empty($conf->service->enabled)), 'perms'=>(! empty($user->rights->produit->lire) || ! empty($user->rights->service->lire)), 'module'=>'product|service');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("products");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "products") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='products';

		$chaine="";
		if (! empty($conf->product->enabled)) {
			$chaine.=$langs->trans("TMenuProducts");
		}
		if (! empty($conf->product->enabled) && ! empty($conf->service->enabled)) {
			$chaine.=" | ";
		}
		if (! empty($conf->service->enabled)) {
			$chaine.=$langs->trans("TMenuServices");
		}

		$menu->add('/product/index.php?mainmenu=products&amp;leftmenu=', $chaine, 0, $showmode, $atarget, "products", '', 30, $id, $idsel, $classname);
	}

	// Projects
	$tmpentry=array('enabled'=>(! empty($conf->projet->enabled)),
	'perms'=>(! empty($user->rights->projet->lire)),
	'module'=>'projet');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("projects");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "project") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='project';

		$title = $langs->trans("LeadsOrProjects");	// Leads and opportunities by default
		$showmodel = $showmodep = $showmode;
		if (empty($conf->global->PROJECT_USE_OPPORTUNITIES))
		{
			$title = $langs->trans("Projects");
			$showmodel = 0;
		}
		if ($conf->global->PROJECT_USE_OPPORTUNITIES == 2) {
			$title = $langs->trans("Leads");
			$showmodep = 0;
		}

		$menu->add('/projet/index.php?mainmenu=project&amp;leftmenu=', $title, 0, $showmode, $atarget, "project", '', 35, $id, $idsel, $classname);
		//$menu->add('/projet/index.php?mainmenu=project&amp;leftmenu=&search_opp_status=openedopp', $langs->trans("ListLeads"), 0, $showmodel & $conf->global->PROJECT_USE_OPPORTUNITIES, $atarget, "project", '', 70, $id, $idsel, $classname);
		//$menu->add('/projet/index.php?mainmenu=project&amp;leftmenu=&search_opp_status=notopenedopp', $langs->trans("ListProjects"), 0, $showmodep, $atarget, "project", '', 70, $id, $idsel, $classname);
	}

	// Commercial
	$menuqualified=0;
	if (! empty($conf->propal->enabled)) $menuqualified++;
	if (! empty($conf->commande->enabled)) $menuqualified++;
	if (! empty($conf->supplier_order->enabled)) $menuqualified++;
	if (! empty($conf->supplier_proposal->enabled)) $menuqualified++;
	if (! empty($conf->contrat->enabled)) $menuqualified++;
	if (! empty($conf->ficheinter->enabled)) $menuqualified++;
	$tmpentry=array(
	    'enabled'=>$menuqualified,
	    'perms'=>(! empty($user->rights->societe->lire) || ! empty($user->rights->societe->contact->lire)),
	    'module'=>'propal|commande|supplier_order|contrat|ficheinter');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("commercial");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "commercial") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='commercial';

		$menu->add('/comm/index.php?mainmenu=commercial&amp;leftmenu=', $langs->trans("Commercial"), 0, $showmode, $atarget, "commercial", "", 40, $id, $idsel, $classname);
	}

	// Billing - Financial
	$menuqualified=0;
	if (! empty($conf->facture->enabled)) $menuqualified++;
	if (! empty($conf->don->enabled)) $menuqualified++;
	if (! empty($conf->tax->enabled)) $menuqualified++;
	if (! empty($conf->salaries->enabled)) $menuqualified++;
	if (! empty($conf->supplier_invoice->enabled)) $menuqualified++;
	if (! empty($conf->loan->enabled)) $menuqualified++;
	$tmpentry=array(
	   'enabled'=>$menuqualified,
	'perms'=>(! empty($user->rights->facture->lire) || ! empty($user->rights->don->lire) || ! empty($user->rights->tax->charges->lire) || ! empty($user->rights->salaries->read) || ! empty($user->rights->fournisseur->facture->lire) || ! empty($user->rights->loan->read)),
	   'module'=>'facture|supplier_invoice|don|tax|salaries|loan');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("compta");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "billing") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='billing';

		$menu->add('/compta/index.php?mainmenu=billing&amp;leftmenu=', $langs->trans("MenuFinancial"), 0, $showmode, $atarget, "billing", '', 50, $id, $idsel, $classname);
	}

	// Bank
	$tmpentry=array('enabled'=>(! empty($conf->banque->enabled) || ! empty($conf->prelevement->enabled)),
	'perms'=>(! empty($user->rights->banque->lire) || ! empty($user->rights->prelevement->lire)),
	'module'=>'banque|prelevement');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
	    // Load translation files required by the page
        $langs->loadLangs(array("compta","banks"));

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "bank") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='bank';

		$menu->add('/compta/bank/list.php?mainmenu=bank&amp;leftmenu=', $langs->trans("MenuBankCash"), 0, $showmode, $atarget, "bank", '', 52, $id, $idsel, $classname);
	}

	// Accounting
	$menuqualified=0;
	if (! empty($conf->comptabilite->enabled)) $menuqualified++;
	if (! empty($conf->accounting->enabled)) $menuqualified++;
	if (! empty($conf->asset->enabled)) $menuqualified++;
	$tmpentry=array(
	'enabled'=>$menuqualified,
	'perms'=>(! empty($user->rights->compta->resultat->lire) || ! empty($user->rights->accounting->mouvements->lire) || ! empty($user->rights->asset->read)),
	'module'=>'comptabilite|accounting');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("compta");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "accountancy") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='accountancy';

		$menu->add('/accountancy/index.php?mainmenu=accountancy&amp;leftmenu=', $langs->trans("MenuAccountancy"), 0, $showmode, $atarget, "accountancy", '', 54, $id, $idsel, $classname);
	}

	// HRM
	$tmpentry=array('enabled'=>(! empty($conf->hrm->enabled) || ! empty($conf->holiday->enabled) || ! empty($conf->deplacement->enabled) || ! empty($conf->expensereport->enabled)),
	'perms'=>(! empty($user->rights->hrm->employee->read) || ! empty($user->rights->holiday->write) || ! empty($user->rights->deplacement->lire) || ! empty($user->rights->expensereport->lire)),
	'module'=>'hrm|holiday|deplacement|expensereport');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("holiday");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "hrm") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='hrm';

		$menu->add('/hrm/index.php?mainmenu=hrm&amp;leftmenu=', $langs->trans("HRM"), 0, $showmode, $atarget, "hrm", '', 80, $id, $idsel, $classname);
	}

	// Tools
	$tmpentry=array(
	'enabled'=>1,
	'perms'=>1,
	'module'=>'');
	$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);
	if ($showmode)
	{
		$langs->load("other");

		$classname="";
		if ($_SESSION["mainmenu"] && $_SESSION["mainmenu"] == "tools") { $classname='class="tmenusel"'; $_SESSION['idmenu']=''; }
		else $classname = 'class="tmenu"';
		$idsel='tools';

		$menu->add('/core/tools.php?mainmenu=tools&amp;leftmenu=', $langs->trans("Tools"), 0, $showmode, $atarget, "tools", '', 90, $id, $idsel, $classname);
	}




	for($i = 0; $i < $num; $i++)
	{
		$idsel=(empty($newTabMenu[$i]['mainmenu'])?'none':$newTabMenu[$i]['mainmenu']);

		$showmode=isVisibleToUserType($type_user,$newTabMenu[$i],$listofmodulesforexternal);
		if ($showmode == 1)
		{
			$substitarray = array('__LOGIN__' => $user->login, '__USER_ID__' => $user->id, '__USER_SUPERVISOR_ID__' => $user->fk_user);
			$substitarray['__USERID__'] = $user->id;	// For backward compatibility
			$newTabMenu[$i]['url'] = make_substitutions($newTabMenu[$i]['url'], $substitarray);

		    // url = url from host, shorturl = relative path into dolibarr sources
			$url = $shorturl = $newTabMenu[$i]['url'];
			if (! preg_match("/^(http:\/\/|https:\/\/)/i",$newTabMenu[$i]['url']))	// Do not change url content for external links
			{
				$tmp=explode('?',$newTabMenu[$i]['url'],2);
				$url = $shorturl = $tmp[0];
				$param = (isset($tmp[1])?$tmp[1]:'');

				if (! preg_match('/mainmenu/i',$param) || ! preg_match('/leftmenu/i',$param)) $param.=($param?'&':'').'mainmenu='.$newTabMenu[$i]['mainmenu'].'&amp;leftmenu=';
				//$url.="idmenu=".$newTabMenu[$i]['rowid'];    // Already done by menuLoad
				$url = dol_buildpath($url,1).($param?'?'.$param:'');
				//$shorturl = $shorturl.($param?'?'.$param:'');
                $shorturl = $url;
				if (DOL_URL_ROOT) $shorturl = preg_replace('/^'.preg_quote(DOL_URL_ROOT,'/').'/','',$shorturl);
			}

			// Define the class (top menu selected or not)
			if (! empty($_SESSION['idmenu']) && $newTabMenu[$i]['rowid'] == $_SESSION['idmenu']) $classname='class="tmenusel"';
			else if (! empty($_SESSION["mainmenu"]) && $newTabMenu[$i]['mainmenu'] == $_SESSION["mainmenu"]) $classname='class="tmenusel"';
			else $classname='class="tmenu"';
		}
		else if ($showmode == 2) $classname='class="tmenu"';

		$menu->add($shorturl, $newTabMenu[$i]['titre'], 0, $showmode, ($newTabMenu[$i]['target']?$newTabMenu[$i]['target']:$atarget), ($newTabMenu[$i]['mainmenu']?$newTabMenu[$i]['mainmenu']:$newTabMenu[$i]['rowid']), ($newTabMenu[$i]['leftmenu']?$newTabMenu[$i]['leftmenu']:''), $newTabMenu[$i]['position'], $id, $idsel, $classname);
	}




	// Show personalized menus

	    $type_user =0;
	// Show personalized menus
        require_once DOL_DOCUMENT_ROOT.'/core/class/menubase.class.php';
        $newTabMenu=array();
        $menuArbo = new Menubase($db,'eldy');
        $menuArbo->menuLoad('', '', $type_user, 'eldy', $newTabMenu);
        $menuArbo->tabMenu=$newTabMenu;
/*         $topmenu = $menuArbo->menuTopCharger('', '', $type_user, 'eldy', $newTabMenu);
		$leftmenu = $menuArbo->menuLeftCharger($newmenu, '', '', $type_user, 'eldy', $newTabMenu);
	var_dump($leftmenu);exit; */

	$num = count($newTabMenu);
	for($i = 0; $i < $num; $i++)
	{
		$idsel=(empty($newTabMenu[$i]['mainmenu'])?'none':$newTabMenu[$i]['mainmenu']);

		$showmode=isVisibleToUserType($type_user,$newTabMenu[$i],$listofmodulesforexternal);
		if ($showmode == 1)
		{
			$substitarray = array('__LOGIN__' => $user->login, '__USER_ID__' => $user->id, '__USER_SUPERVISOR_ID__' => $user->fk_user);
			$substitarray['__USERID__'] = $user->id;	// For backward compatibility
			$newTabMenu[$i]['url'] = make_substitutions($newTabMenu[$i]['url'], $substitarray);

		    // url = url from host, shorturl = relative path into dolibarr sources
			$url = $shorturl = $newTabMenu[$i]['url'];
			if (! preg_match("/^(http:\/\/|https:\/\/)/i",$newTabMenu[$i]['url']))	// Do not change url content for external links
			{
				$tmp=explode('?',$newTabMenu[$i]['url'],2);
				$url = $shorturl = $tmp[0];
				$param = (isset($tmp[1])?$tmp[1]:'');

				if (! preg_match('/mainmenu/i',$param) || ! preg_match('/leftmenu/i',$param)) $param.=($param?'&':'').'mainmenu='.$newTabMenu[$i]['mainmenu'].'&amp;leftmenu=';
				//$url.="idmenu=".$newTabMenu[$i]['rowid'];    // Already done by menuLoad
				$url = dol_buildpath($url,1).($param?'?'.$param:'');
				//$shorturl = $shorturl.($param?'?'.$param:'');
                $shorturl = $url;
				if (DOL_URL_ROOT) $shorturl = preg_replace('/^'.preg_quote(DOL_URL_ROOT,'/').'/','',$shorturl);
			}

			// Define the class (top menu selected or not)
			if (! empty($_SESSION['idmenu']) && $newTabMenu[$i]['rowid'] == $_SESSION['idmenu']) $classname='class="tmenusel"';
			else if (! empty($_SESSION["mainmenu"]) && $newTabMenu[$i]['mainmenu'] == $_SESSION["mainmenu"]) $classname='class="tmenusel"';
			else $classname='class="tmenu"';
		}
		else if ($showmode == 2) $classname='class="tmenu"';

		$menu->add($newTabMenu[$i]['url'], $newTabMenu[$i]['titre'], 0, $showmode, ($newTabMenu[$i]['target']?$newTabMenu[$i]['target']:$atarget), ($newTabMenu[$i]['mainmenu']?$newTabMenu[$i]['mainmenu']:$newTabMenu[$i]['rowid']), ($newTabMenu[$i]['leftmenu']?$newTabMenu[$i]['leftmenu']:''), $newTabMenu[$i]['position'], $id, $idsel, $classname);
	}

	// Sort on position






foreach ($menu->liste as $k=>$m){
$submenu = new Menu();
		if ($m['idsel'] == 'home')
		{
			
			$langs->load("users");

			// Home - dashboard
			$submenu->add("/index.php?mainmenu=home&amp;leftmenu=home", $langs->trans("MyDashboard"), 0, 1, '', $m['idsel'], 'home', 0, '', '', '', '<i class="fa fa-bar-chart fa-fw paddingright"></i>');

			// Setup
			$submenu->add("/admin/index.php?mainmenu=home&amp;leftmenu=setup", $langs->trans("Setup"), 0, $user->admin, '', $m['idsel'], 'setup', 0, '', '', '', '<i class="fa fa-wrench fa-fw paddingright"></i>');

			if ($usemenuhider || empty($leftmenu) || $leftmenu=="setup")
			{
			    // Load translation files required by the page
                $langs->loadLangs(array("admin","help"));

				$warnpicto='';
				if (empty($conf->global->MAIN_INFO_SOCIETE_NOM) || empty($conf->global->MAIN_INFO_SOCIETE_COUNTRY))
				{
					$langs->load("errors");
					$warnpicto =' '.img_warning($langs->trans("WarningMandatorySetupNotComplete"));
				}
				$submenu->add("/admin/company.php?mainmenu=home", $langs->trans("MenuCompanySetup").$warnpicto,1);
				$warnpicto='';
				if (count($conf->modules) <= (empty($conf->global->MAIN_MIN_NB_ENABLED_MODULE_FOR_WARNING)?1:$conf->global->MAIN_MIN_NB_ENABLED_MODULE_FOR_WARNING))	// If only user module enabled
				{
					$langs->load("errors");
					$warnpicto = ' '.img_warning($langs->trans("WarningMandatorySetupNotComplete"));
				}
				$submenu->add("/admin/modules.php?mainmenu=home", $langs->trans("Modules").$warnpicto,1);
				$submenu->add("/admin/menus.php?mainmenu=home", $langs->trans("Menus"),1);
				$submenu->add("/admin/ihm.php?mainmenu=home", $langs->trans("GUISetup"),1);

				$submenu->add("/admin/translation.php?mainmenu=home", $langs->trans("Translation"),1);
				$submenu->add("/admin/defaultvalues.php?mainmenu=home", $langs->trans("DefaultValues"),1);
				$submenu->add("/admin/boxes.php?mainmenu=home", $langs->trans("Boxes"),1);
				$submenu->add("/admin/delais.php?mainmenu=home",$langs->trans("MenuWarnings"),1);
				$submenu->add("/admin/security_other.php?mainmenu=home", $langs->trans("Security"),1);
				$submenu->add("/admin/limits.php?mainmenu=home", $langs->trans("MenuLimits"),1);
				$submenu->add("/admin/pdf.php?mainmenu=home", $langs->trans("PDF"),1);
				$submenu->add("/admin/mails.php?mainmenu=home", $langs->trans("Emails"),1);
				$submenu->add("/admin/sms.php?mainmenu=home", $langs->trans("SMS"),1);
				$submenu->add("/admin/dict.php?mainmenu=home", $langs->trans("Dictionary"),1);
				$submenu->add("/admin/const.php?mainmenu=home", $langs->trans("OtherSetup"),1);
			}

			// System tools
			$submenu->add("/admin/tools/index.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("AdminTools"), 0, $user->admin, '', $m['idsel'], 'admintools', 0, '', '', '', '<i class="fa fa-server fa-fw paddingright"></i>');
			if ($usemenuhider || empty($leftmenu) || preg_match('/^admintools/',$leftmenu))
			{
			    // Load translation files required by the page
                $langs->loadLangs(array('admin', 'help'));

				$submenu->add('/admin/system/dolibarr.php?mainmenu=home&amp;leftmenu=admintools_info', $langs->trans('InfoDolibarr'), 1);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=='admintools_info') $submenu->add('/admin/system/modules.php?mainmenu=home&amp;leftmenu=admintools_info', $langs->trans('Modules'), 2);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=='admintools_info') $submenu->add('/admin/triggers.php?mainmenu=home&amp;leftmenu=admintools_info', $langs->trans('Triggers'), 2);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=='admintools_info') $submenu->add('/admin/system/filecheck.php?mainmenu=home&amp;leftmenu=admintools_info', $langs->trans('FileCheck'), 2);
				$submenu->add('/admin/system/browser.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('InfoBrowser'), 1);
				$submenu->add('/admin/system/os.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('InfoOS'), 1);
				$submenu->add('/admin/system/web.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('InfoWebServer'), 1);
				$submenu->add('/admin/system/phpinfo.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('InfoPHP'), 1);
				//if (function_exists('xdebug_is_enabled')) $submenu->add('/admin/system/xdebug.php', $langs->trans('XDebug'),1);
				$submenu->add('/admin/system/database.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('InfoDatabase'), 1);
				if (function_exists('eaccelerator_info')) $submenu->add("/admin/tools/eaccelerator.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("EAccelerator"),1);
				//$submenu->add("/admin/system/perf.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("InfoPerf"),1);
				$submenu->add("/admin/tools/dolibarr_export.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("Backup"),1);
				$submenu->add("/admin/tools/dolibarr_import.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("Restore"),1);
				$submenu->add("/admin/tools/update.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("MenuUpgrade"),1);
				$submenu->add("/admin/tools/purge.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("Purge"),1);
				$submenu->add("/admin/tools/listevents.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("Audit"),1);
				$submenu->add("/admin/tools/listsessions.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("Sessions"),1);
				$submenu->add('/admin/system/about.php?mainmenu=home&amp;leftmenu=admintools', $langs->trans('ExternalResources'), 1);

				if (! empty($conf->product->enabled) || ! empty($conf->service->enabled))
				{
					$langs->load("products");
				    $submenu->add("/product/admin/product_tools.php?mainmenu=home&amp;leftmenu=admintools", $langs->trans("ProductVatMassChange"), 1, $user->admin);
				}
			}

			$submenu->add("/user/home.php?leftmenu=users", $langs->trans("MenuUsersAndGroups"), 0, $user->rights->user->user->lire, '', $m['idsel'], 'users', 0, '', '', '', '<i class="fa fa-users fa-fw paddingright"></i>');
			if ($user->rights->user->user->lire)
			{
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="users")
				{
					$submenu->add("", $langs->trans("Users"), 1, $user->rights->user->user->lire || $user->admin);
					$submenu->add("/user/card.php?leftmenu=users&action=create", $langs->trans("NewUser"),2, ($user->rights->user->user->creer || $user->admin) && !(! empty($conf->multicompany->enabled) && $conf->entity > 1 && $conf->global->MULTICOMPANY_TRANSVERSE_MODE), '', 'home');
					$submenu->add("/user/list.php?leftmenu=users", $langs->trans("ListOfUsers"), 2, $user->rights->user->user->lire || $user->admin);
					$submenu->add("/user/hierarchy.php?leftmenu=users", $langs->trans("HierarchicView"), 2, $user->rights->user->user->lire || $user->admin);
					if (! empty($conf->categorie->enabled))
					{
						$langs->load("categories");
						$submenu->add("/categories/index.php?leftmenu=users&type=7", $langs->trans("UsersCategoriesShort"), 2, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
					}
					$submenu->add("", $langs->trans("Groups"), 1, ($user->rights->user->user->lire || $user->admin) && !(! empty($conf->multicompany->enabled) && $conf->entity > 1 && $conf->global->MULTICOMPANY_TRANSVERSE_MODE));
					$submenu->add("/user/group/card.php?leftmenu=users&action=create", $langs->trans("NewGroup"), 2, (($conf->global->MAIN_USE_ADVANCED_PERMS?$user->rights->user->group_advance->write:$user->rights->user->user->creer) || $user->admin) && !(! empty($conf->multicompany->enabled) && $conf->entity > 1 && $conf->global->MULTICOMPANY_TRANSVERSE_MODE));
					$submenu->add("/user/group/list.php?leftmenu=users", $langs->trans("ListOfGroups"), 2, (($conf->global->MAIN_USE_ADVANCED_PERMS?$user->rights->user->group_advance->read:$user->rights->user->user->lire) || $user->admin) && !(! empty($conf->multicompany->enabled) && $conf->entity > 1 && $conf->global->MULTICOMPANY_TRANSVERSE_MODE));
				}
			}

array_push($menu->liste[$k],['subenu'=>$submenu->liste]);
	}


		/*
		 * Menu THIRDPARTIES
		 */
		if ($m['idsel'] == 'companies')
		{
			// Societes
			if (! empty($conf->societe->enabled))
			{
				$langs->load("companies");
				$submenu->add("/societe/index.php?leftmenu=thirdparties", $langs->trans("ThirdParty"), 0, $user->rights->societe->lire, '', $m['idsel'], 'thirdparties');

				if ($user->rights->societe->creer)
				{
					$submenu->add("/societe/card.php?action=create", $langs->trans("MenuNewThirdParty"),1);
					if (! $conf->use_javascript_ajax) $submenu->add("/societe/card.php?action=create&amp;private=1",$langs->trans("MenuNewPrivateIndividual"),1);
				}
			}

			$submenu->add("/societe/list.php?leftmenu=thirdparties", $langs->trans("List"),1);

			// Prospects
			if (! empty($conf->societe->enabled) && empty($conf->global->SOCIETE_DISABLE_PROSPECTS))
			{
				$langs->load("commercial");
				$submenu->add("/societe/list.php?type=p&amp;leftmenu=prospects", $langs->trans("ListProspectsShort"), 1, $user->rights->societe->lire, '', $m['idsel'], 'prospects');
				/* no more required, there is a filter that can do more
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="prospects") $submenu->add("/societe/list.php?type=p&amp;sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;search_stcomm=-1", $langs->trans("LastProspectDoNotContact"), 2, $user->rights->societe->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="prospects") $submenu->add("/societe/list.php?type=p&amp;sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;search_stcomm=0", $langs->trans("LastProspectNeverContacted"), 2, $user->rights->societe->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="prospects") $submenu->add("/societe/list.php?type=p&amp;sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;search_stcomm=1", $langs->trans("LastProspectToContact"), 2, $user->rights->societe->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="prospects") $submenu->add("/societe/list.php?type=p&amp;sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;search_stcomm=2", $langs->trans("LastProspectContactInProcess"), 2, $user->rights->societe->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="prospects") $submenu->add("/societe/list.php?type=p&amp;sortfield=s.datec&amp;sortorder=desc&amp;begin=&amp;search_stcomm=3", $langs->trans("LastProspectContactDone"), 2, $user->rights->societe->lire);
				*/
				$submenu->add("/societe/card.php?leftmenu=prospects&amp;action=create&amp;type=p", $langs->trans("MenuNewProspect"), 2, $user->rights->societe->creer);
				//$submenu->add("/contact/list.php?leftmenu=customers&amp;type=p", $langs->trans("Contacts"), 2, $user->rights->societe->contact->lire);
			}

			// Customers/Prospects
			if (! empty($conf->societe->enabled) && empty($conf->global->SOCIETE_DISABLE_CUSTOMERS))
			{
				$langs->load("commercial");
				$submenu->add("/societe/list.php?type=c&amp;leftmenu=customers", $langs->trans("ListCustomersShort"), 1, $user->rights->societe->lire, '', $m['idsel'], 'customers');

				$submenu->add("/societe/card.php?leftmenu=customers&amp;action=create&amp;type=c", $langs->trans("MenuNewCustomer"), 2, $user->rights->societe->creer);
				//$submenu->add("/contact/list.php?leftmenu=customers&amp;type=c", $langs->trans("Contacts"), 2, $user->rights->societe->contact->lire);
			}

			// Suppliers
			if (! empty($conf->societe->enabled) && (! empty($conf->fournisseur->enabled) || ! empty($conf->supplier_proposal->enabled)))
			{
				$langs->load("suppliers");
				$submenu->add("/societe/list.php?type=f&amp;leftmenu=suppliers", $langs->trans("ListSuppliersShort"), 1, ($user->rights->fournisseur->lire || $user->rights->supplier_proposal->lire), '', $m['idsel'], 'suppliers');
				$submenu->add("/societe/card.php?leftmenu=suppliers&amp;action=create&amp;type=f",$langs->trans("MenuNewSupplier"), 2, $user->rights->societe->creer && ($user->rights->fournisseur->lire || $user->rights->supplier_proposal->lire));
			}

			// Categories
			if (! empty($conf->categorie->enabled))
			{
				$langs->load("categories");
				if (empty($conf->global->SOCIETE_DISABLE_PROSPECTS) || empty($conf->global->SOCIETE_DISABLE_CUSTOMERS))
				{
					// Categories prospects/customers
					$menutoshow=$langs->trans("CustomersProspectsCategoriesShort");
					if (! empty($conf->global->SOCIETE_DISABLE_PROSPECTS)) $menutoshow=$langs->trans("CustomersCategoriesShort");
					if (! empty($conf->global->SOCIETE_DISABLE_CUSTOMERS)) $menutoshow=$langs->trans("ProspectsCategoriesShort");
					$submenu->add("/categories/index.php?leftmenu=cat&amp;type=2", $menutoshow, 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
				}
				// Categories suppliers
				if (! empty($conf->fournisseur->enabled))
				{
					$submenu->add("/categories/index.php?leftmenu=catfournish&amp;type=1", $langs->trans("SuppliersCategoriesShort"), 1, $user->rights->categorie->lire);
				}
			}

			// Contacts
			$submenu->add("/societe/index.php?leftmenu=thirdparties", (! empty($conf->global->SOCIETE_ADDRESSES_MANAGEMENT) ? $langs->trans("Contacts") : $langs->trans("ContactsAddresses")), 0, $user->rights->societe->contact->lire, '', $m['idsel'], 'contacts');
			$submenu->add("/contact/card.php?leftmenu=contacts&amp;action=create", (! empty($conf->global->SOCIETE_ADDRESSES_MANAGEMENT) ? $langs->trans("NewContact") : $langs->trans("NewContactAddress")), 1, $user->rights->societe->contact->creer);
			$submenu->add("/contact/list.php?leftmenu=contacts", $langs->trans("List"), 1, $user->rights->societe->contact->lire);
			if (empty($conf->global->SOCIETE_DISABLE_PROSPECTS)) $submenu->add("/contact/list.php?leftmenu=contacts&type=p", $langs->trans("Prospects"), 2, $user->rights->societe->contact->lire);
			if (empty($conf->global->SOCIETE_DISABLE_CUSTOMERS)) $submenu->add("/contact/list.php?leftmenu=contacts&type=c", $langs->trans("Customers"), 2, $user->rights->societe->contact->lire);
			if (! empty($conf->fournisseur->enabled)) $submenu->add("/contact/list.php?leftmenu=contacts&type=f", $langs->trans("Suppliers"), 2, $user->rights->societe->contact->lire);
			$submenu->add("/contact/list.php?leftmenu=contacts&type=o", $langs->trans("ContactOthers"), 2, $user->rights->societe->contact->lire);
			//$submenu->add("/contact/list.php?userid=$user->id", $langs->trans("MyContacts"), 1, $user->rights->societe->contact->lire);

			// Categories
			if (! empty($conf->categorie->enabled))
			{
				$langs->load("categories");
				// Categories Contact
				$submenu->add("/categories/index.php?leftmenu=catcontact&amp;type=4", $langs->trans("ContactCategoriesShort"), 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
			}
		array_push($menu->liste[$k],['subenu'=>$submenu->liste]);	
		}
	/*
		 * Menu COMMERCIAL
		 */
		if ($m['idsel'] == 'commercial')
		{
			$langs->load("companies");

			// Customer proposal
			if (! empty($conf->propal->enabled))
			{
				$langs->load("propal");
				$submenu->add("/comm/propal/index.php?leftmenu=propals", $langs->trans("Proposals"), 0, $user->rights->propale->lire, '', $m['idsel'], 'propals', 100);
				$submenu->add("/comm/propal/card.php?action=create&amp;leftmenu=propals", $langs->trans("NewPropal"), 1, $user->rights->propale->creer);
				$submenu->add("/comm/propal/list.php?leftmenu=propals", $langs->trans("List"), 1, $user->rights->propale->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=0", $langs->trans("PropalsDraft"), 2, $user->rights->propale->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=1", $langs->trans("PropalsOpened"), 2, $user->rights->propale->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=2", $langs->trans("PropalStatusSigned"), 2, $user->rights->propale->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=3", $langs->trans("PropalStatusNotSigned"), 2, $user->rights->propale->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=4", $langs->trans("PropalStatusBilled"), 2, $user->rights->propale->lire);
				//if ($usemenuhider || empty($leftmenu) || $leftmenu=="propals") $submenu->add("/comm/propal/list.php?leftmenu=propals&viewstatut=2,3,4", $langs->trans("PropalStatusClosedShort"), 2, $user->rights->propale->lire);
				$submenu->add("/comm/propal/stats/index.php?leftmenu=propals", $langs->trans("Statistics"), 1, $user->rights->propale->lire);
			}

            // Customers orders
            if (! empty($conf->commande->enabled))
            {
                $langs->load("orders");
                $submenu->add("/commande/index.php?leftmenu=orders", $langs->trans("CustomersOrders"), 0, $user->rights->commande->lire, '', $m['idsel'], 'orders', 200);
                $submenu->add("/commande/card.php?action=create&amp;leftmenu=orders", $langs->trans("NewOrder"), 1, $user->rights->commande->creer);
                $submenu->add("/commande/list.php?leftmenu=orders", $langs->trans("List"), 1, $user->rights->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=0", $langs->trans("StatusOrderDraftShort"), 2, $user->rights->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=1", $langs->trans("StatusOrderValidated"), 2, $user->rights->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders" && ! empty($conf->expedition->enabled)) $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=2", $langs->trans("StatusOrderSentShort"), 2, $user->rights->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=3", $langs->trans("StatusOrderDelivered"), 2, $user->rights->commande->lire);
                //if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=4", $langs->trans("StatusOrderProcessed"), 2, $user->rights->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/list.php?leftmenu=orders&viewstatut=-1", $langs->trans("StatusOrderCanceledShort"), 2, $user->rights->commande->lire);
                $submenu->add("/commande/stats/index.php?leftmenu=orders", $langs->trans("Statistics"), 1, $user->rights->commande->lire);
            }

			// Suppliers orders
            if (! empty($conf->supplier_order->enabled))
			{
				$langs->load("orders");
				$submenu->add("/fourn/commande/index.php?leftmenu=orders_suppliers",$langs->trans("SuppliersOrders"), 0, $user->rights->fournisseur->commande->lire, '', $m['idsel'], 'orders_suppliers', 400);
				$submenu->add("/fourn/commande/card.php?action=create&amp;leftmenu=orders_suppliers", $langs->trans("NewOrder"), 1, $user->rights->fournisseur->commande->creer);
				$submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers", $langs->trans("List"), 1, $user->rights->fournisseur->commande->lire);

				if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=0", $langs->trans("StatusOrderDraftShort"), 2, $user->rights->fournisseur->commande->lire);
                if (($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") && empty($conf->global->SUPPLIER_ORDER_HIDE_VALIDATED)) $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=1", $langs->trans("StatusOrderValidated"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=2", $langs->trans("StatusOrderApprovedShort"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=3", $langs->trans("StatusOrderOnProcessShort"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=4", $langs->trans("StatusOrderReceivedPartiallyShort"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=5", $langs->trans("StatusOrderReceivedAll"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=6,7", $langs->trans("StatusOrderCanceled"), 2, $user->rights->fournisseur->commande->lire);
                if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&statut=9", $langs->trans("StatusOrderRefused"), 2, $user->rights->fournisseur->commande->lire);
                // Billed is another field. We should add instead a dedicated filter on list. if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders_suppliers") $submenu->add("/fourn/commande/list.php?leftmenu=orders_suppliers&billed=1", $langs->trans("StatusOrderBilled"), 2, $user->rights->fournisseur->commande->lire);


				$submenu->add("/commande/stats/index.php?leftmenu=orders_suppliers&amp;mode=supplier", $langs->trans("Statistics"), 1, $user->rights->fournisseur->commande->lire);
			}

			// Contrat
			if (! empty($conf->contrat->enabled))
			{
				$langs->load("contracts");
				$submenu->add("/contrat/index.php?leftmenu=contracts", $langs->trans("ContractsSubscriptions"), 0, $user->rights->contrat->lire, '', $m['idsel'], 'contracts', 2000);
				$submenu->add("/contrat/card.php?action=create&amp;leftmenu=contracts", $langs->trans("NewContractSubscription"), 1, $user->rights->contrat->creer);
				$submenu->add("/contrat/list.php?leftmenu=contracts", $langs->trans("List"), 1, $user->rights->contrat->lire);
				$submenu->add("/contrat/services_list.php?leftmenu=contracts", $langs->trans("MenuServices"), 1, $user->rights->contrat->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="contracts") $submenu->add("/contrat/services_list.php?leftmenu=contracts&amp;mode=0", $langs->trans("MenuInactiveServices"), 2, $user->rights->contrat->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="contracts") $submenu->add("/contrat/services_list.php?leftmenu=contracts&amp;mode=4", $langs->trans("MenuRunningServices"), 2, $user->rights->contrat->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="contracts") $submenu->add("/contrat/services_list.php?leftmenu=contracts&amp;mode=4&amp;filter=expired", $langs->trans("MenuExpiredServices"), 2, $user->rights->contrat->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="contracts") $submenu->add("/contrat/services_list.php?leftmenu=contracts&amp;mode=5", $langs->trans("MenuClosedServices"), 2, $user->rights->contrat->lire);
			}

			// Interventions
			if (! empty($conf->ficheinter->enabled))
			{
				$langs->load("interventions");
				$submenu->add("/fichinter/index.php?leftmenu=ficheinter", $langs->trans("Interventions"), 0, $user->rights->ficheinter->lire, '', $m['idsel'], 'ficheinter', 2200);
				$submenu->add("/fichinter/card.php?action=create&amp;leftmenu=ficheinter", $langs->trans("NewIntervention"), 1, $user->rights->ficheinter->creer, '', '', '', 201);
				$submenu->add("/fichinter/list.php?leftmenu=ficheinter", $langs->trans("List"), 1, $user->rights->ficheinter->lire, '', '', '', 202);
				$submenu->add("/fichinter/card-red.php?leftmenu=ficheinter", $langs->trans("ModelList"), 1, $user->rights->ficheinter->lire, '', '', '', 203);
				$submenu->add("/fichinter/stats/index.php?leftmenu=ficheinter", $langs->trans("Statistics"), 1, $user->rights->fournisseur->commande->lire);
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);
		}


		/*
		 * Menu COMPTA-FINANCIAL
		 */
		if ($m['idsel'] == 'billing')
		{
			$langs->load("companies");

			// Customers invoices
			if (! empty($conf->facture->enabled))
			{
				$langs->load("bills");
				$submenu->add("/compta/facture/list.php?leftmenu=customers_bills",$langs->trans("BillsCustomers"),0,$user->rights->facture->lire, '', $m['idsel'], 'customers_bills');
				$submenu->add("/compta/facture/card.php?action=create",$langs->trans("NewBill"),1,$user->rights->facture->creer);
				$submenu->add("/compta/facture/list.php?leftmenu=customers_bills",$langs->trans("List"),1,$user->rights->facture->lire, '', $m['idsel'], 'customers_bills_list');

				if ($usemenuhider || empty($leftmenu) || preg_match('/customers_bills(|_draft|_notpaid|_paid|_canceled)$/', $leftmenu))
				{
					$submenu->add("/compta/facture/list.php?leftmenu=customers_bills_draft&amp;search_status=0",$langs->trans("BillShortStatusDraft"),2,$user->rights->facture->lire);
					$submenu->add("/compta/facture/list.php?leftmenu=customers_bills_notpaid&amp;search_status=1",$langs->trans("BillShortStatusNotPaid"),2,$user->rights->facture->lire);
					$submenu->add("/compta/facture/list.php?leftmenu=customers_bills_paid&amp;search_status=2",$langs->trans("BillShortStatusPaid"),2,$user->rights->facture->lire);
					$submenu->add("/compta/facture/list.php?leftmenu=customers_bills_canceled&amp;search_status=3",$langs->trans("BillShortStatusCanceled"),2,$user->rights->facture->lire);
				}
				$submenu->add("/compta/facture/invoicetemplate_list.php?leftmenu=customers_bills_templates",$langs->trans("ListOfTemplates"),1,$user->rights->facture->creer,'',$m['idsel'],'customers_bills_templates');    // No need to see recurring invoices, if user has no permission to create invoice.

				$submenu->add("/compta/paiement/list.php?leftmenu=customers_bills_payment",$langs->trans("Payments"),1,$user->rights->facture->lire,'',$m['idsel'],'customers_bills_payment');

				if (! empty($conf->global->BILL_ADD_PAYMENT_VALIDATION))
				{
					$submenu->add("/compta/paiement/tovalidate.php?leftmenu=customers_bills_tovalid",$langs->trans("MenuToValid"),2,$user->rights->facture->lire,'',$m['idsel'],'customer_bills_tovalid');
				}
				$submenu->add("/compta/paiement/rapport.php?leftmenu=customers_bills_reports",$langs->trans("Reportings"),2,$user->rights->facture->lire,'',$m['idsel'],'customers_bills_reports');

				$submenu->add("/compta/facture/stats/index.php?leftmenu=customers_bills_stats", $langs->trans("Statistics"),1,$user->rights->facture->lire,'',$m['idsel'],'customers_bills_stats');
			}

			// Suppliers invoices
			if (! empty($conf->societe->enabled) && ! empty($conf->supplier_invoice->enabled))
			{
				$langs->load("bills");
				$submenu->add("/fourn/facture/list.php?leftmenu=suppliers_bills", $langs->trans("BillsSuppliers"),0,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills');
				$submenu->add("/fourn/facture/card.php?leftmenu=suppliers_bills&amp;action=create",$langs->trans("NewBill"),1,$user->rights->fournisseur->facture->creer, '', $m['idsel'], 'suppliers_bills_create');
				$submenu->add("/fourn/facture/list.php?leftmenu=suppliers_bills", $langs->trans("List"),1,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_list');

				if ($usemenuhider || empty($leftmenu) || preg_match('/suppliers_bills/', $leftmenu)) {
					$submenu->add("/fourn/facture/list.php?leftmenu=suppliers_bills_draft&amp;search_status=0", $langs->trans("BillShortStatusDraft"),2,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_draft');
					$submenu->add("/fourn/facture/list.php?leftmenu=suppliers_bills_notpaid&amp;search_status=1", $langs->trans("BillShortStatusNotPaid"),2,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_notpaid');
					$submenu->add("/fourn/facture/list.php?leftmenu=suppliers_bills_paid&amp;search_status=2", $langs->trans("BillShortStatusPaid"),2,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_paid');
				}

				$submenu->add("/fourn/facture/paiement.php?leftmenu=suppliers_bills_payment", $langs->trans("Payments"),1,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_payment');

				$submenu->add("/fourn/facture/rapport.php?leftmenu=suppliers_bills_report",$langs->trans("Reportings"),2,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_report');

				$submenu->add("/compta/facture/stats/index.php?mode=supplier&amp;leftmenu=suppliers_bills_stats", $langs->trans("Statistics"),1,$user->rights->fournisseur->facture->lire, '', $m['idsel'], 'suppliers_bills_stats');
			}

			// Orders
			if (! empty($conf->commande->enabled))
			{
				$langs->load("orders");
				if (! empty($conf->facture->enabled)) $submenu->add("/commande/list.php?leftmenu=orders&amp;viewstatut=-3&amp;billed=0&amp;contextpage=billableorders", $langs->trans("MenuOrdersToBill2"), 0, $user->rights->commande->lire, '', $m['idsel'], 'orders');
				//                  if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/", $langs->trans("StatusOrderToBill"), 1, $user->rights->commande->lire);
			}

			// Supplier Orders to bill
			if (! empty($conf->supplier_invoice->enabled))
			{
				if (! empty($conf->global->SUPPLIER_MENU_ORDER_RECEIVED_INTO_INVOICE))
				{
					$langs->load("supplier");
					$submenu->add("/fourn/commande/list.php?leftmenu=orders&amp;search_status=5&amp;billed=0", $langs->trans("MenuOrdersSupplierToBill"), 0, $user->rights->commande->lire, '', $m['idsel'], 'orders');
					//                  if ($usemenuhider || empty($leftmenu) || $leftmenu=="orders") $submenu->add("/commande/", $langs->trans("StatusOrderToBill"), 1, $user->rights->commande->lire);
				}
			}


			// Donations
			if (! empty($conf->don->enabled))
			{
				$langs->load("donations");
				$submenu->add("/don/index.php?leftmenu=donations&amp;mainmenu=billing",$langs->trans("Donations"), 0, $user->rights->don->lire, '', $m['idsel'], 'donations');
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="donations") $submenu->add("/don/card.php?leftmenu=donations&amp;action=create",$langs->trans("NewDonation"), 1, $user->rights->don->creer);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="donations") $submenu->add("/don/list.php?leftmenu=donations",$langs->trans("List"), 1, $user->rights->don->lire);
				// if ($leftmenu=="donations") $submenu->add("/don/stats/index.php",$langs->trans("Statistics"), 1, $user->rights->don->lire);
			}

			// Taxes and social contributions
			if (! empty($conf->tax->enabled) || ! empty($conf->salaries->enabled) || ! empty($conf->loan->enabled) || ! empty($conf->banque->enabled))
			{
				global $mysoc;

				$permtoshowmenu=((! empty($conf->tax->enabled) && $user->rights->tax->charges->lire) || (! empty($conf->salaries->enabled) && ! empty($user->rights->salaries->read)) || (! empty($conf->loan->enabled) && $user->rights->loan->read) || (! empty($conf->banque->enabled) && $user->rights->banque->lire));
				$submenu->add("/compta/charges/index.php?leftmenu=tax&amp;mainmenu=billing",$langs->trans("MenuSpecialExpenses"), 0, $permtoshowmenu, '', $m['idsel'], 'tax');

				// Social contributions
				if (! empty($conf->tax->enabled))
				{
					$submenu->add("/compta/sociales/list.php?leftmenu=tax_social",$langs->trans("MenuSocialContributions"),1,$user->rights->tax->charges->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_social/i',$leftmenu)) $submenu->add("/compta/sociales/card.php?leftmenu=tax_social&action=create",$langs->trans("MenuNewSocialContribution"), 2, $user->rights->tax->charges->creer);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_social/i',$leftmenu)) $submenu->add("/compta/sociales/list.php?leftmenu=tax_social",$langs->trans("List"),2,$user->rights->tax->charges->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_social/i',$leftmenu)) $submenu->add("/compta/sociales/payments.php?leftmenu=tax_social&amp;mainmenu=billing&amp;mode=sconly",$langs->trans("Payments"), 2, $user->rights->tax->charges->lire);
					// VAT
					if (empty($conf->global->TAX_DISABLE_VAT_MENUS))
					{
						$submenu->add("/compta/tva/list.php?leftmenu=tax_vat&amp;mainmenu=billing",$langs->transcountry("VAT", $mysoc->country_code),1,$user->rights->tax->charges->lire, '', $m['idsel'], 'tax_vat');
						if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_vat/i',$leftmenu)) $submenu->add("/compta/tva/card.php?leftmenu=tax_vat&action=create",$langs->trans("New"),2,$user->rights->tax->charges->creer);
						if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_vat/i',$leftmenu)) $submenu->add("/compta/tva/list.php?leftmenu=tax_vat",$langs->trans("List"),2,$user->rights->tax->charges->lire);
						if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_vat/i',$leftmenu)) $submenu->add("/compta/tva/index.php?leftmenu=tax_vat",$langs->trans("ReportByMonth"),2,$user->rights->tax->charges->lire);
						if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_vat/i',$leftmenu)) $submenu->add("/compta/tva/clients.php?leftmenu=tax_vat", $langs->trans("ReportByCustomers"), 2, $user->rights->tax->charges->lire);
						if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_vat/i',$leftmenu)) $submenu->add("/compta/tva/quadri_detail.php?leftmenu=tax_vat", $langs->trans("ReportByQuarter"), 2, $user->rights->tax->charges->lire);
						global $mysoc;

						//Local Taxes 1
						if($mysoc->useLocalTax(1) && (isset($mysoc->localtax1_assuj) && $mysoc->localtax1_assuj=="1"))
						{
							$submenu->add("/compta/localtax/list.php?leftmenu=tax_1_vat&amp;mainmenu=billing&amp;localTaxType=1",$langs->transcountry("LT1",$mysoc->country_code),1,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_1_vat/i',$leftmenu)) $submenu->add("/compta/localtax/card.php?leftmenu=tax_1_vat&action=create&amp;localTaxType=1",$langs->trans("New"),2,$user->rights->tax->charges->creer);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_1_vat/i',$leftmenu)) $submenu->add("/compta/localtax/list.php?leftmenu=tax_1_vat&amp;localTaxType=1",$langs->trans("List"),2,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_1_vat/i',$leftmenu)) $submenu->add("/compta/localtax/index.php?leftmenu=tax_1_vat&amp;localTaxType=1",$langs->trans("ReportByMonth"),2,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_1_vat/i',$leftmenu)) $submenu->add("/compta/localtax/clients.php?leftmenu=tax_1_vat&amp;localTaxType=1", $langs->trans("ReportByCustomers"), 2, $user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_1_vat/i',$leftmenu)) $submenu->add("/compta/localtax/quadri_detail.php?leftmenu=tax_1_vat&amp;localTaxType=1", $langs->trans("ReportByQuarter"), 2, $user->rights->tax->charges->lire);
						}
						//Local Taxes 2
						if($mysoc->useLocalTax(2) && (isset($mysoc->localtax2_assuj) && $mysoc->localtax2_assuj=="1"))
						{
							$submenu->add("/compta/localtax/list.php?leftmenu=tax_2_vat&amp;mainmenu=billing&amp;localTaxType=2",$langs->transcountry("LT2",$mysoc->country_code),1,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_2_vat/i',$leftmenu)) $submenu->add("/compta/localtax/card.php?leftmenu=tax_2_vat&action=create&amp;localTaxType=2",$langs->trans("New"),2,$user->rights->tax->charges->creer);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_2_vat/i',$leftmenu)) $submenu->add("/compta/localtax/list.php?leftmenu=tax_2_vat&amp;localTaxType=2",$langs->trans("List"),2,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_2_vat/i',$leftmenu)) $submenu->add("/compta/localtax/index.php?leftmenu=tax_2_vat&amp;localTaxType=2",$langs->trans("ReportByMonth"),2,$user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_2_vat/i',$leftmenu)) $submenu->add("/compta/localtax/clients.php?leftmenu=tax_2_vat&amp;localTaxType=2", $langs->trans("ReportByCustomers"), 2, $user->rights->tax->charges->lire);
							if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_2_vat/i',$leftmenu)) $submenu->add("/compta/localtax/quadri_detail.php?leftmenu=tax_2_vat&amp;localTaxType=2", $langs->trans("ReportByQuarter"), 2, $user->rights->tax->charges->lire);
						}
					}
				}

				// Salaries
				if (! empty($conf->salaries->enabled))
				{
					$langs->load("salaries");
					$submenu->add("/compta/salaries/list.php?leftmenu=tax_salary&amp;mainmenu=billing",$langs->trans("Salaries"),1,$user->rights->salaries->read, '', $m['idsel'], 'tax_salary');
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_salary/i',$leftmenu)) $submenu->add("/compta/salaries/card.php?leftmenu=tax_salary&action=create",$langs->trans("NewPayment"),2,$user->rights->salaries->write);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_salary/i',$leftmenu)) $submenu->add("/compta/salaries/list.php?leftmenu=tax_salary",$langs->trans("Payments"),2,$user->rights->salaries->read);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_salary/i',$leftmenu)) $submenu->add("/compta/salaries/stats/index.php?leftmenu=tax_salary", $langs->trans("Statistics"),2,$user->rights->salaries->read);
				}

				// Loan
				if (! empty($conf->loan->enabled))
				{
					$langs->load("loan");
					$submenu->add("/loan/list.php?leftmenu=tax_loan&amp;mainmenu=billing",$langs->trans("Loans"),1,$user->rights->loan->read, '', $m['idsel'], 'tax_loan');
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_loan/i',$leftmenu)) $submenu->add("/loan/card.php?leftmenu=tax_loan&action=create",$langs->trans("NewLoan"),2,$user->rights->loan->write);
					//if (empty($leftmenu) || preg_match('/^tax_loan/i',$leftmenu)) $submenu->add("/loan/payment/list.php?leftmenu=tax_loan",$langs->trans("Payments"),2,$user->rights->loan->read);
				}

				// Various payment
				if (! empty($conf->banque->enabled) && empty($conf->global->BANK_USE_OLD_VARIOUS_PAYMENT))
				{
					$langs->load("banks");
					$submenu->add("/compta/bank/various_payment/list.php?leftmenu=tax_various&amp;mainmenu=billing",$langs->trans("MenuVariousPayment"),1,$user->rights->banque->lire, '', $m['idsel'], 'tax_various');
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_various/i',$leftmenu)) $submenu->add("/compta/bank/various_payment/card.php?leftmenu=tax_various&action=create",$langs->trans("New"), 2, $user->rights->banque->modifier);
					if ($usemenuhider || empty($leftmenu) || preg_match('/^tax_various/i',$leftmenu)) $submenu->add("/compta/bank/various_payment/list.php?leftmenu=tax_various",$langs->trans("List"),2,$user->rights->banque->lire);
				}
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}

		/*
		 * Menu COMPTA-FINANCIAL
		 */
		if ($m['idsel'] == 'accountancy')
		{
			$langs->load("companies");

			// Accounting Expert
			if (! empty($conf->accounting->enabled))
			{
				$langs->load("accountancy");

				$permtoshowmenu=(! empty($conf->accounting->enabled) || $user->rights->accounting->bind->write || $user->rights->compta->resultat->lire);
				$submenu->add("/accountancy/index.php?leftmenu=accountancy",$langs->trans("MenuAccountancy"), 0, $permtoshowmenu, '', $m['idsel'], 'accountancy');

				// Chart of account
				$submenu->add("/accountancy/index.php?leftmenu=accountancy_admin", $langs->trans("Setup"),1,$user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin', 1);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/index.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("General"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_general', 10);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/journals_list.php?id=35&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("AccountingJournals"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_journal', 20);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/accountmodel.php?id=31&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("Pcg_version"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_chartmodel', 30);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/account.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("Chartofaccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_chart', 40);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/categories_list.php?id=32&search_country_id=".$mysoc->country_id."&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("AccountingCategory"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_chart', 41);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/defaultaccounts.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("MenuDefaultAccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_default', 50);
				if (! empty($conf->banque->enabled))
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/compta/bank/list.php?mainmenu=accountancy&leftmenu=accountancy_admin&search_status=-1", $langs->trans("MenuBankAccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_bank', 51);
				}
				if (! empty($conf->facture->enabled) || ! empty($conf->fournisseur->enabled))
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/admin/dict.php?id=10&from=accountancy&search_country_id=".$mysoc->country_id."&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("MenuVatAccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_default', 52);
				}
				if (! empty($conf->tax->enabled))
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/admin/dict.php?id=7&from=accountancy&search_country_id=".$mysoc->country_id."&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("MenuTaxAccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_default', 53);
				}
				if (! empty($conf->expensereport->enabled))
				{
					if (preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/admin/dict.php?id=17&from=accountancy&mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("MenuExpenseReportAccounts"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_default', 54);
				}
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/productaccount.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("MenuProductsAccounts"), 2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_product', 55);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/export.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("ExportOptions"),2, $user->rights->accounting->chartofaccount, '', $m['idsel'], 'accountancy_admin_export', 60);

				// Fiscal year
				if ($conf->global->MAIN_FEATURES_LEVEL > 1)     // Not yet used. In a future will lock some periods.
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_admin/',$leftmenu)) $submenu->add("/accountancy/admin/fiscalyear.php?mainmenu=accountancy&leftmenu=accountancy_admin", $langs->trans("FiscalPeriod"), 2, $user->rights->accounting->fiscalyear, '', $m['idsel'], 'fiscalyear');
				}

				// Binding
				if (! empty($conf->facture->enabled))
				{
					$submenu->add("/accountancy/customer/index.php?leftmenu=accountancy_dispatch_customer&amp;mainmenu=accountancy",$langs->trans("CustomersVentilation"),1,$user->rights->accounting->bind->write, '', $m['idsel'], 'dispatch_customer');
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_customer/',$leftmenu)) $submenu->add("/accountancy/customer/list.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_customer",$langs->trans("ToBind"),2,$user->rights->accounting->bind->write);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_customer/',$leftmenu)) $submenu->add("/accountancy/customer/lines.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_customer",$langs->trans("Binded"),2,$user->rights->accounting->bind->write);
				}
				if (! empty($conf->supplier_invoice->enabled))
				{
					$submenu->add("/accountancy/supplier/index.php?leftmenu=accountancy_dispatch_supplier&amp;mainmenu=accountancy",$langs->trans("SuppliersVentilation"),1,$user->rights->accounting->bind->write, '', $m['idsel'], 'dispatch_supplier');
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_supplier/',$leftmenu)) $submenu->add("/accountancy/supplier/list.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_supplier",$langs->trans("ToBind"),2,$user->rights->accounting->bind->write);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_supplier/',$leftmenu)) $submenu->add("/accountancy/supplier/lines.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_supplier",$langs->trans("Binded"),2,$user->rights->accounting->bind->write);
				}

				if (! empty($conf->expensereport->enabled))
				{
					$submenu->add("/accountancy/expensereport/index.php?leftmenu=accountancy_dispatch_expensereport&amp;mainmenu=accountancy",$langs->trans("ExpenseReportsVentilation"),1,$user->rights->accounting->bind->write, '', $m['idsel'], 'dispatch_expensereport');
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_expensereport/',$leftmenu)) $submenu->add("/accountancy/expensereport/list.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_expensereport",$langs->trans("ToBind"),2,$user->rights->accounting->bind->write);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_dispatch_expensereport/',$leftmenu)) $submenu->add("/accountancy/expensereport/lines.php?mainmenu=accountancy&amp;leftmenu=accountancy_dispatch_expensereport",$langs->trans("Binded"),2,$user->rights->accounting->bind->write);
				}

				// Journals
				if(! empty($conf->accounting->enabled) && ! empty($user->rights->accounting->comptarapport->lire) && $m['idsel'] == 'accountancy')
				{
					$submenu->add('',$langs->trans("Journalization"),1,$user->rights->accounting->comptarapport->lire);

					// Multi journal
					$sql = "SELECT rowid, code, label, nature";
					$sql.= " FROM ".MAIN_DB_PREFIX."accounting_journal";
					$sql.= " WHERE entity = ".$conf->entity;
					$sql.= " AND active = 1";
					$sql.= " ORDER BY label DESC";

					$resql = $db->query($sql);
					if ($resql)
					{
						$numr = $db->num_rows($resql);
						$i = 0;

						if ($numr > 0)
						{
							while ($i < $numr)
							{
								$objp = $db->fetch_object($resql);

								$nature='';

								// Must match array $sourceList defined into journals_list.php
								if ($objp->nature == 2 && ! empty($conf->facture->enabled)) $nature="sells";
								if ($objp->nature == 3 && ! empty($conf->fournisseur->enabled)) $nature="purchases";
								if ($objp->nature == 4 && ! empty($conf->banque->enabled)) $nature="bank";
								if ($objp->nature == 5 && ! empty($conf->expensereport->enabled)) $nature="expensereports";
								if ($objp->nature == 1) $nature="various";
								if ($objp->nature == 8) $nature="inventory";
								if ($objp->nature == 9) $nature="hasnew";

								// To enable when page exists
								if (empty($conf->global->ACCOUNTANCY_SHOW_DEVELOP_JOURNAL))
								{
									if ($nature == 'various' || $nature == 'hasnew' || $nature == 'inventory') $nature='';
								}

								if ($nature)
								{
									$langs->load('accountancy');
									$journallabel=$langs->transnoentities($objp->label);	// Labels in this table are set by loading llx_accounting_abc.sql. Label can be 'ACCOUNTING_SELL_JOURNAL', 'InventoryJournal', ...
									$submenu->add('/accountancy/journal/'.$nature.'journal.php?mainmenu=accountancy&leftmenu=accountancy_journal&id_journal='.$objp->rowid, $journallabel, 2, $user->rights->accounting->comptarapport->lire);
								}
								$i++;
							}
						}
						else
						{
							// Should not happend. Entries are added
							$submenu->add('',$langs->trans("NoJournalDefined"), 2, $user->rights->accounting->comptarapport->lire);
						}
					}
					else dol_print_error($db);
					$db->free($resql);
				}

				// General Ledger
				$submenu->add("/accountancy/bookkeeping/list.php?mainmenu=accountancy&amp;leftmenu=accountancy_generalledger",$langs->trans("Bookkeeping"),1,$user->rights->accounting->mouvements->lire);

				// Balance
				$submenu->add("/accountancy/bookkeeping/balance.php?mainmenu=accountancy&amp;leftmenu=accountancy_balance",$langs->trans("AccountBalance"),1,$user->rights->accounting->mouvements->lire);

				// Reports
				$langs->load("compta");

				$submenu->add("/compta/resultat/index.php?mainmenu=accountancy&amp;leftmenu=accountancy_report",$langs->trans("Reportings"),1,$user->rights->accounting->comptarapport->lire, '', $m['idsel'], 'ca');

				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/resultat/index.php?leftmenu=accountancy_report",$langs->trans("MenuReportInOut"),2,$user->rights->accounting->comptarapport->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/resultat/clientfourn.php?leftmenu=accountancy_report",$langs->trans("ByPredefinedAccountGroups"),3,$user->rights->accounting->comptarapport->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/resultat/result.php?leftmenu=accountancy_report",$langs->trans("ByPersonalizedAccountGroups"),3,$user->rights->accounting->comptarapport->lire);

				$modecompta='CREANCES-DETTES';
				if(! empty($conf->accounting->enabled) && ! empty($user->rights->accounting->comptarapport->lire) && $m['idsel'] == 'accountancy') $modecompta='BOOKKEEPING';	// Not yet implemented. Should be BOOKKEEPINGCOLLECTED
				if ($modecompta)
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/index.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ReportTurnover"),2,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/casoc.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ByCompanies"),3,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/cabyuser.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ByUsers"),3,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/cabyprodserv.php?leftmenu=accountancy_report&modecompta=".$modecompta, $langs->trans("ByProductsAndServices"),3,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/byratecountry.php?leftmenu=accountancy_report&modecompta=".$modecompta, $langs->trans("ByVatRate"),3,$user->rights->accounting->comptarapport->lire);
				}

				$modecompta='RECETTES-DEPENSES';
				//if (! empty($conf->accounting->enabled) && ! empty($user->rights->accounting->comptarapport->lire) && $m['idsel'] == 'accountancy') $modecompta='';	// Not yet implemented. Should be BOOKKEEPINGCOLLECTED
				if ($modecompta)
				{
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/index.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ReportTurnoverCollected"),2,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/casoc.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ByCompanies"),3,$user->rights->accounting->comptarapport->lire);
					if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/cabyuser.php?leftmenu=accountancy_report&modecompta=".$modecompta,$langs->trans("ByUsers"),3,$user->rights->accounting->comptarapport->lire);
					//if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/cabyprodserv.php?leftmenu=accountancy_report&modecompta=".$modecompta, $langs->trans("ByProductsAndServices"),3,$user->rights->accounting->comptarapport->lire);
					//if ($usemenuhider || empty($leftmenu) || preg_match('/accountancy_report/',$leftmenu)) $submenu->add("/compta/stats/byratecountry.php?leftmenu=accountancy_report&modecompta=".$modecompta, $langs->trans("ByVatRate"),3,$user->rights->accounting->comptarapport->lire);
				}
			}

			// Accountancy (simple)
			if (! empty($conf->comptabilite->enabled))
			{
				$langs->load("compta");

				// Bilan, resultats
				$submenu->add("/compta/resultat/index.php?leftmenu=report&amp;mainmenu=accountancy",$langs->trans("Reportings"),0,$user->rights->compta->resultat->lire, '', $m['idsel'], 'ca');

				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/resultat/index.php?leftmenu=report",$langs->trans("MenuReportInOut"),1,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/resultat/clientfourn.php?leftmenu=report",$langs->trans("ByCompanies"),2,$user->rights->compta->resultat->lire);
				/* On verra ca avec module compabilite expert
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/resultat/compteres.php?leftmenu=report","Compte de resultat",2,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/resultat/bilan.php?leftmenu=report","Bilan",2,$user->rights->compta->resultat->lire);
				*/
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/index.php?leftmenu=report",$langs->trans("ReportTurnover"),1,$user->rights->compta->resultat->lire);

				/*
				 if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/cumul.php?leftmenu=report","Cumule",2,$user->rights->compta->resultat->lire);
				if (! empty($conf->propal->enabled)) {
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/prev.php?leftmenu=report","Previsionnel",2,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/comp.php?leftmenu=report","Transforme",2,$user->rights->compta->resultat->lire);
				}
				*/
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/casoc.php?leftmenu=report",$langs->trans("ByCompanies"),2,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/cabyuser.php?leftmenu=report",$langs->trans("ByUsers"),2,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/cabyprodserv.php?leftmenu=report", $langs->trans("ByProductsAndServices"),2,$user->rights->compta->resultat->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/stats/byratecountry.php?leftmenu=report", $langs->trans("ByVatRate"),2,$user->rights->compta->resultat->lire);

				// Journaux
				//if ($leftmenu=="ca") $submenu->add("/compta/journaux/index.php?leftmenu=ca",$langs->trans("Journaux"),1,$user->rights->compta->resultat->lire||$user->rights->accounting->comptarapport->lire);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/journal/sellsjournal.php?leftmenu=report",$langs->trans("SellsJournal"),1,$user->rights->compta->resultat->lire, '', '', '', 50);
				if ($usemenuhider || empty($leftmenu) || preg_match('/report/',$leftmenu)) $submenu->add("/compta/journal/purchasesjournal.php?leftmenu=report",$langs->trans("PurchasesJournal"),1,$user->rights->compta->resultat->lire, '', '', '', 51);
			}

			// Assets
			if (! empty($conf->asset->enabled))
			{
				$langs->load("assets");
				$submenu->add("/asset/list.php?leftmenu=asset&amp;mainmenu=accountancy",$langs->trans("MenuAssets"), 0, $user->rights->asset->read, '', $m['idsel'], 'asset');
				$submenu->add("/asset/card.php?action=create",$langs->trans("MenuNewAsset"), 1, $user->rights->asset->write);
				$submenu->add("/asset/list.php?leftmenu=asset&amp;mainmenu=accountancy",$langs->trans("MenuListAssets"), 1, $user->rights->asset->read);
				$submenu->add("/asset/type.php?leftmenu=asset_type",$langs->trans("MenuTypeAssets"), 1, $user->rights->asset->read, '', $m['idsel'], 'asset_type');
				if ($usemenuhider || empty($leftmenu) || preg_match('/asset_type/',$leftmenu)) $submenu->add("/asset/type.php?leftmenu=asset_type&amp;action=create",$langs->trans("MenuNewTypeAssets"), 2, $user->rights->asset->write);
				if ($usemenuhider || empty($leftmenu) || preg_match('/asset_type/',$leftmenu)) $submenu->add("/asset/type.php?leftmenu=asset_type",$langs->trans("MenuListTypeAssets"), 2, $user->rights->asset->read);
			}
	array_push($menu->liste[$k],['subenu'=>$submenu->liste]);		
			
		}

		/*
		 * Menu BANK
		 */
		if ($m['idsel'] == 'bank')
		{
			// Load translation files required by the page
			$langs->loadLangs(array("withdrawals","banks","bills","categories"));

			// Bank-Caisse
			if (! empty($conf->banque->enabled))
			{
				$submenu->add("/compta/bank/list.php?leftmenu=bank&amp;mainmenu=bank",$langs->trans("MenuBankCash"),0,$user->rights->banque->lire, '', $m['idsel'], 'bank');

				$submenu->add("/compta/bank/card.php?action=create",$langs->trans("MenuNewFinancialAccount"),1,$user->rights->banque->configurer);
				$submenu->add("/compta/bank/list.php?leftmenu=bank&amp;mainmenu=bank",$langs->trans("List"),1,$user->rights->banque->lire, '', $m['idsel'], 'bank');
				$submenu->add("/compta/bank/bankentries_list.php",$langs->trans("ListTransactions"),1,$user->rights->banque->lire);
				$submenu->add("/compta/bank/budget.php",$langs->trans("ListTransactionsByCategory"),1,$user->rights->banque->lire);

				$submenu->add("/compta/bank/transfer.php",$langs->trans("MenuBankInternalTransfer"),1,$user->rights->banque->transfer);
			}

			if (! empty($conf->categorie->enabled))
			{
				$langs->load("categories");
				$submenu->add("/categories/index.php?type=5",$langs->trans("Rubriques"),1,$user->rights->categorie->creer, '', $m['idsel'], 'tags');
				$submenu->add("/compta/bank/categ.php",$langs->trans("RubriquesTransactions"),1,$user->rights->categorie->creer, '', $m['idsel'], 'tags');
			}

			// Prelevements
			if (! empty($conf->prelevement->enabled))
			{
				$submenu->add("/compta/prelevement/index.php?leftmenu=withdraw&amp;mainmenu=bank",$langs->trans("StandingOrders"),0,$user->rights->prelevement->bons->lire, '', $m['idsel'], 'withdraw');

				//if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/demandes.php?status=0&amp;mainmenu=bank",$langs->trans("StandingOrderToProcess"),1,$user->rights->prelevement->bons->lire);

				if (empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/create.php?mainmenu=bank",$langs->trans("NewStandingOrder"),1,$user->rights->prelevement->bons->creer);


				if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/bons.php?mainmenu=bank",$langs->trans("WithdrawalsReceipts"),1,$user->rights->prelevement->bons->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/list.php?mainmenu=bank",$langs->trans("WithdrawalsLines"),1,$user->rights->prelevement->bons->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/rejets.php?mainmenu=bank",$langs->trans("Rejects"),1,$user->rights->prelevement->bons->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/stats.php?mainmenu=bank",$langs->trans("Statistics"),1,$user->rights->prelevement->bons->lire);

				//if ($usemenuhider || empty($leftmenu) || $leftmenu=="withdraw") $submenu->add("/compta/prelevement/config.php",$langs->trans("Setup"),1,$user->rights->prelevement->bons->configurer);
			}

			// Gestion cheques
			if (empty($conf->global->BANK_DISABLE_CHECK_DEPOSIT) && ! empty($conf->banque->enabled) && (! empty($conf->facture->enabled) || ! empty($conf->global->MAIN_MENU_CHEQUE_DEPOSIT_ON)))
			{
				$submenu->add("/compta/paiement/cheque/index.php?leftmenu=checks&amp;mainmenu=bank",$langs->trans("MenuChequeDeposits"),0,$user->rights->banque->cheque, '', $m['idsel'], 'checks');
				if (preg_match('/checks/',$leftmenu)) $submenu->add("/compta/paiement/cheque/card.php?leftmenu=checks_bis&amp;action=new&amp;mainmenu=bank",$langs->trans("NewChequeDeposit"),1,$user->rights->banque->cheque);
				if (preg_match('/checks/',$leftmenu)) $submenu->add("/compta/paiement/cheque/list.php?leftmenu=checks_bis&amp;mainmenu=bank",$langs->trans("List"),1,$user->rights->banque->cheque);
			}

			// Cash Control
			if (! empty($conf->takepos->enabled) || ! empty($conf->cashdesk->enabled))
			{
				$permtomakecashfence = ($user->rights->cashdesk->use ||$user->rights->takepos->use);
				$submenu->add("/compta/cashcontrol/cashcontrol_list.php?action=list",$langs->trans("POS"),0,$permtomakecashfence, '', $m['idsel'], 'cashcontrol');
				$submenu->add("/compta/cashcontrol/cashcontrol_card.php?action=create",$langs->trans("NewCashFence"),1,$permtomakecashfence);
				$submenu->add("/compta/cashcontrol/cashcontrol_list.php?action=list",$langs->trans("List"),1,$permtomakecashfence);
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}

		/*
		 * Menu PRODUCTS-SERVICES
		 */
		if ($m['idsel'] == 'products')
		{
			// Products
			if (! empty($conf->product->enabled))
			{
				$submenu->add("/product/index.php?leftmenu=product&amp;type=0", $langs->trans("Products"), 0, $user->rights->produit->lire, '', $m['idsel'], 'product');
				$submenu->add("/product/card.php?leftmenu=product&amp;action=create&amp;type=0", $langs->trans("NewProduct"), 1, $user->rights->produit->creer);
				$submenu->add("/product/list.php?leftmenu=product&amp;type=0", $langs->trans("List"), 1, $user->rights->produit->lire);
				if (! empty($conf->stock->enabled))
				{
					$submenu->add("/product/reassort.php?type=0", $langs->trans("Stocks"), 1, $user->rights->produit->lire && $user->rights->stock->lire);
				}
				if (! empty($conf->productbatch->enabled))
				{
					$langs->load("stocks");
					$submenu->add("/product/reassortlot.php?type=0", $langs->trans("StocksByLotSerial"), 1, $user->rights->produit->lire && $user->rights->stock->lire);
					$submenu->add("/product/stock/productlot_list.php", $langs->trans("LotSerial"), 1, $user->rights->produit->lire && $user->rights->stock->lire);
				}
				if (! empty($conf->variants->enabled))
				{
					$submenu->add("/variants/list.php", $langs->trans("VariantAttributes"), 1, $user->rights->produit->lire);
				}
				if (! empty($conf->propal->enabled) || ! empty($conf->commande->enabled) || ! empty($conf->facture->enabled) || ! empty($conf->fournisseur->enabled) || ! empty($conf->supplier_proposal->enabled))
				{
					$submenu->add("/product/stats/card.php?id=all&leftmenu=stats&type=0", $langs->trans("Statistics"), 1, $user->rights->produit->lire && $user->rights->propale->lire);
				}

				// Categories
				if (! empty($conf->categorie->enabled))
				{
					$langs->load("categories");
					$submenu->add("/categories/index.php?leftmenu=cat&amp;type=0", $langs->trans("Categories"), 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
					//if ($usemenuhider || empty($leftmenu) || $leftmenu=="cat") $submenu->add("/categories/list.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
				}
			}

			// Services
			if (! empty($conf->service->enabled))
			{
				$submenu->add("/product/index.php?leftmenu=service&amp;type=1", $langs->trans("Services"), 0, $user->rights->service->lire, '', $m['idsel'], 'service');
				$submenu->add("/product/card.php?leftmenu=service&amp;action=create&amp;type=1", $langs->trans("NewService"), 1, $user->rights->service->creer);
				$submenu->add("/product/list.php?leftmenu=service&amp;type=1", $langs->trans("List"), 1, $user->rights->service->lire);
				if (! empty($conf->propal->enabled) || ! empty($conf->commande->enabled) || ! empty($conf->facture->enabled) || ! empty($conf->fournisseur->enabled) || ! empty($conf->supplier_proposal->enabled))
				{
					$submenu->add("/product/stats/card.php?id=all&leftmenu=stats&type=1", $langs->trans("Statistics"), 1, $user->rights->service->lire && $user->rights->propale->lire);
				}
				// Categories
				if (! empty($conf->categorie->enabled))
				{
					$langs->load("categories");
					$submenu->add("/categories/index.php?leftmenu=cat&amp;type=0", $langs->trans("Categories"), 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
					//if ($usemenuhider || empty($leftmenu) || $leftmenu=="cat") $submenu->add("/categories/list.php", $langs->trans("List"), 1, $user->rights->categorie->lire);
				}
			}

			// Warehouse
			if (! empty($conf->stock->enabled))
			{
				$langs->load("stocks");
				$submenu->add("/product/stock/index.php?leftmenu=stock", $langs->trans("Warehouses"), 0, $user->rights->stock->lire, '', $m['idsel'], 'stock');
				$submenu->add("/product/stock/card.php?action=create", $langs->trans("MenuNewWarehouse"), 1, $user->rights->stock->creer);
				$submenu->add("/product/stock/list.php", $langs->trans("List"), 1, $user->rights->stock->lire);
				$submenu->add("/product/stock/movement_list.php", $langs->trans("Movements"), 1, $user->rights->stock->mouvement->lire);

                $submenu->add("/product/stock/massstockmove.php", $langs->trans("MassStockTransferShort"), 1, $user->rights->stock->mouvement->creer);
                if ($conf->supplier_order->enabled) $submenu->add("/product/stock/replenish.php", $langs->trans("Replenishment"), 1, $user->rights->stock->mouvement->creer && $user->rights->fournisseur->lire);
			}

			// Inventory
			if ($conf->global->MAIN_FEATURES_LEVEL >= 2)
			{
    			if (! empty($conf->stock->enabled))
    			{
    				$langs->load("stocks");
					if (empty($conf->global->MAIN_USE_ADVANCED_PERMS))
					{
						$submenu->add("/product/inventory/list.php?leftmenu=stock", $langs->trans("Inventory"), 0, $user->rights->stock->lire, '', $m['idsel'], 'stock');
						$submenu->add("/product/inventory/card.php?action=create", $langs->trans("NewInventory"), 1, $user->rights->stock->creer);
						$submenu->add("/product/inventory/list.php", $langs->trans("List"), 1, $user->rights->stock->lire);
					}
					else
					{
						$submenu->add("/product/inventory/list.php?leftmenu=stock", $langs->trans("Inventory"), 0, $user->rights->stock->inventory_advance->read, '', $m['idsel'], 'stock');
						$submenu->add("/product/inventory/card.php?action=create", $langs->trans("NewInventory"), 1, $user->rights->stock->inventory_advance->write);
						$submenu->add("/product/inventory/list.php", $langs->trans("List"), 1, $user->rights->stock->inventory_advance->read);
					}
    			}
			}

			// Expeditions
			if (! empty($conf->expedition->enabled))
			{
				$langs->load("sendings");
				$submenu->add("/expedition/index.php?leftmenu=sendings", $langs->trans("Shipments"), 0, $user->rights->expedition->lire, '', $m['idsel'], 'sendings');
				$submenu->add("/expedition/card.php?action=create2&amp;leftmenu=sendings", $langs->trans("NewSending"), 1, $user->rights->expedition->creer);
				$submenu->add("/expedition/list.php?leftmenu=sendings", $langs->trans("List"), 1, $user->rights->expedition->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="sendings") $submenu->add("/expedition/list.php?leftmenu=sendings&viewstatut=0", $langs->trans("StatusSendingDraftShort"), 2, $user->rights->expedition->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="sendings") $submenu->add("/expedition/list.php?leftmenu=sendings&viewstatut=1", $langs->trans("StatusSendingValidatedShort"), 2, $user->rights->expedition->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="sendings") $submenu->add("/expedition/list.php?leftmenu=sendings&viewstatut=2", $langs->trans("StatusSendingProcessedShort"), 2, $user->rights->expedition->lire);
				$submenu->add("/expedition/stats/index.php?leftmenu=sendings", $langs->trans("Statistics"), 1, $user->rights->expedition->lire);
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}
		

		/*
		 * Menu PROJECTS
		 */
		if ($m['idsel'] == 'project')
		{
			if (! empty($conf->projet->enabled))
			{
				$langs->load("projects");

				$search_project_user = GETPOST('search_project_user','int');

				$tmpentry=array('enabled'=>(! empty($conf->projet->enabled)),
				'perms'=>(! empty($user->rights->projet->lire)),
				'module'=>'projet');
				$showmode=isVisibleToUserType($type_user, $tmpentry, $listofmodulesforexternal);

				$titleboth=$langs->trans("LeadsOrProjects");
				$titlenew = $langs->trans("NewLeadOrProject");	// Leads and opportunities by default
				if ($conf->global->PROJECT_USE_OPPORTUNITIES == 0)
				{
					$titleboth=$langs->trans("Projects");
					$titlenew = $langs->trans("NewProject");
				}
				if ($conf->global->PROJECT_USE_OPPORTUNITIES == 2) {	// 2 = leads only
					$titleboth=$langs->trans("Leads");
					$titlenew = $langs->trans("NewLead");
				}

				// Project assigned to user
				$submenu->add("/projet/index.php?leftmenu=projects".($search_project_user?'&search_project_user='.$search_project_user:''), $titleboth, 0, $user->rights->projet->lire, '', $m['idsel'], 'projects');
				$submenu->add("/projet/card.php?leftmenu=projects&action=create".($search_project_user?'&search_project_user='.$search_project_user:''), $titlenew, 1, $user->rights->projet->creer);

				if ($conf->global->PROJECT_USE_OPPORTUNITIES == 0)
				{
					$submenu->add("/projet/list.php?leftmenu=projets".($search_project_user?'&search_project_user='.$search_project_user:'').'&search_status=99', $langs->trans("List"), 1, $showmode, '', 'project', 'list');
				}
				elseif ($conf->global->PROJECT_USE_OPPORTUNITIES == 1)
				{
					$submenu->add("/projet/list.php?leftmenu=projets".($search_project_user?'&search_project_user='.$search_project_user:''), $langs->trans("List"), 1, $showmode, '', 'project', 'list');
					$submenu->add('/projet/list.php?mainmenu=project&amp;leftmenu=list&search_opp_status=openedopp&search_status=99&contextpage=lead', $langs->trans("ListOpenLeads"), 2, $showmode);
					$submenu->add('/projet/list.php?mainmenu=project&amp;leftmenu=list&search_opp_status=notopenedopp&search_status=99&contextpage=project', $langs->trans("ListOpenProjects"), 2, $showmode);
				}
				elseif ($conf->global->PROJECT_USE_OPPORTUNITIES == 2) {	// 2 = leads only
					$submenu->add('/projet/list.php?mainmenu=project&amp;leftmenu=list&search_opp_status=openedopp&search_status=99', $langs->trans("List"), 2, $showmode);
				}

				$submenu->add("/projet/stats/index.php?leftmenu=projects", $langs->trans("Statistics"), 1, $user->rights->projet->lire);

				// Categories
				if (! empty($conf->categorie->enabled))
				{
					$langs->load("categories");
					$submenu->add("/categories/index.php?leftmenu=cat&amp;type=6", $langs->trans("Categories"), 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
				}

				if (empty($conf->global->PROJECT_HIDE_TASKS))
				{
					// Project affected to user
					$submenu->add("/projet/activity/index.php?leftmenu=tasks".($search_project_user?'&search_project_user='.$search_project_user:''), $langs->trans("Activities"), 0, $user->rights->projet->lire);
					$submenu->add("/projet/tasks.php?leftmenu=tasks&action=create", $langs->trans("NewTask"), 1, $user->rights->projet->creer);
					$submenu->add("/projet/tasks/list.php?leftmenu=tasks".($search_project_user?'&search_project_user='.$search_project_user:''), $langs->trans("List"), 1, $user->rights->projet->lire);
				    $submenu->add("/projet/tasks/stats/index.php?leftmenu=projects", $langs->trans("Statistics"), 1, $user->rights->projet->lire);

				    $submenu->add("/projet/activity/perweek.php?leftmenu=tasks".($search_project_user?'&search_project_user='.$search_project_user:''), $langs->trans("NewTimeSpent"), 0, $user->rights->projet->lire);
				}
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}

		/*
		 * Menu HRM
		*/
		if ($m['idsel'] == 'hrm')
		{
			// HRM module
			if (! empty($conf->hrm->enabled))
			{
				$langs->load("hrm");

				$submenu->add("/user/list.php?leftmenu=hrm&mode=employee", $langs->trans("Employees"), 0, $user->rights->hrm->employee->read, '', $m['idsel'], 'hrm');
				$submenu->add("/user/card.php?action=create&employee=1", $langs->trans("NewEmployee"), 1,$user->rights->hrm->employee->write);
				$submenu->add("/user/list.php?leftmenu=hrm&mode=employee&contextpage=employeelist", $langs->trans("List"), 1,$user->rights->hrm->employee->read);
			}

			// Leave/Holiday/Vacation module
			if (! empty($conf->holiday->enabled))
			{
			    // Load translation files required by the page
                $langs->loadLangs(array("holiday","trips"));

				$submenu->add("/holiday/list.php?leftmenu=hrm", $langs->trans("CPTitreMenu"), 0, $user->rights->holiday->read, '', $m['idsel'], 'hrm');
				$submenu->add("/holiday/card.php?action=request", $langs->trans("New"), 1,$user->rights->holiday->write);
				$submenu->add("/holiday/list.php?leftmenu=hrm", $langs->trans("List"), 1,$user->rights->holiday->read);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="hrm") $submenu->add("/holiday/list.php?search_statut=1&leftmenu=hrm", $langs->trans("DraftCP"), 2, $user->rights->holiday->read);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="hrm") $submenu->add("/holiday/list.php?search_statut=2&leftmenu=hrm", $langs->trans("ToReviewCP"), 2, $user->rights->holiday->read);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="hrm") $submenu->add("/holiday/list.php?search_statut=3&leftmenu=hrm", $langs->trans("ApprovedCP"), 2, $user->rights->holiday->read);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="hrm") $submenu->add("/holiday/list.php?search_statut=4&leftmenu=hrm", $langs->trans("CancelCP"), 2, $user->rights->holiday->read);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="hrm") $submenu->add("/holiday/list.php?search_statut=5&leftmenu=hrm", $langs->trans("RefuseCP"), 2, $user->rights->holiday->read);
				$submenu->add("/holiday/define_holiday.php?action=request", $langs->trans("MenuConfCP"), 1, $user->rights->holiday->read);
				$submenu->add("/holiday/month_report.php", $langs->trans("MenuReportMonth"), 1, $user->rights->holiday->read_all);
				$submenu->add("/holiday/view_log.php?action=request", $langs->trans("MenuLogCP"), 1, $user->rights->holiday->define_holiday);
			}

			// Trips and expenses (old module)
			if (! empty($conf->deplacement->enabled))
			{
				$langs->load("trips");
				$submenu->add("/compta/deplacement/index.php?leftmenu=tripsandexpenses&amp;mainmenu=hrm", $langs->trans("TripsAndExpenses"), 0, $user->rights->deplacement->lire, '', $m['idsel'], 'tripsandexpenses');
				$submenu->add("/compta/deplacement/card.php?action=create&amp;leftmenu=tripsandexpenses&amp;mainmenu=hrm", $langs->trans("New"), 1, $user->rights->deplacement->creer);
				$submenu->add("/compta/deplacement/list.php?leftmenu=tripsandexpenses&amp;mainmenu=hrm", $langs->trans("List"), 1, $user->rights->deplacement->lire);
				$submenu->add("/compta/deplacement/stats/index.php?leftmenu=tripsandexpenses&amp;mainmenu=hrm", $langs->trans("Statistics"), 1, $user->rights->deplacement->lire);
			}

			// Expense report
			if (! empty($conf->expensereport->enabled))
			{
				$langs->load("trips");
				$submenu->add("/expensereport/index.php?leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("TripsAndExpenses"), 0, $user->rights->expensereport->lire, '', $m['idsel'], 'expensereport');
				$submenu->add("/expensereport/card.php?action=create&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("New"), 1, $user->rights->expensereport->creer);
				$submenu->add("/expensereport/list.php?leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("List"), 1, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=0&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Draft"), 2, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=2&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Validated"), 2, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=5&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Approved"), 2, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=6&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Paid"), 2, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=4&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Canceled"), 2, $user->rights->expensereport->lire);
				if ($usemenuhider || empty($leftmenu) || $leftmenu=="expensereport") $submenu->add("/expensereport/list.php?search_status=99&amp;leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Refused"), 2, $user->rights->expensereport->lire);
				$submenu->add("/expensereport/stats/index.php?leftmenu=expensereport&amp;mainmenu=hrm", $langs->trans("Statistics"), 1, $user->rights->expensereport->lire);
			}

			if (! empty($conf->projet->enabled))
			{
				if (empty($conf->global->PROJECT_HIDE_TASKS))
				{
					$langs->load("projects");

					$search_project_user = GETPOST('search_project_user','int');

					$submenu->add("/projet/activity/perweek.php?leftmenu=tasks".($search_project_user?'&search_project_user='.$search_project_user:''), $langs->trans("NewTimeSpent"), 0, $user->rights->projet->lire);
				}
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}
		

		/*
		 * Menu TOOLS
		 */
		if ($m['idsel'] == 'tools')
		{
			if (empty($user->socid)) // limit to internal users
			{
				$langs->load("mails");
				$submenu->add("/admin/mails_templates.php?leftmenu=email_templates", $langs->trans("EMailTemplates"), 0, 1, '', $m['idsel'], 'email_templates');
			}

			if (! empty($conf->mailing->enabled))
			{
				$submenu->add("/comm/mailing/index.php?leftmenu=mailing", $langs->trans("EMailings"), 0, $user->rights->mailing->lire, '', $m['idsel'], 'mailing');
				$submenu->add("/comm/mailing/card.php?leftmenu=mailing&amp;action=create", $langs->trans("NewMailing"), 1, $user->rights->mailing->creer);
				$submenu->add("/comm/mailing/list.php?leftmenu=mailing", $langs->trans("List"), 1, $user->rights->mailing->lire);
			}

			if (! empty($conf->export->enabled))
			{
				$langs->load("exports");
				$submenu->add("/exports/index.php?leftmenu=export",$langs->trans("FormatedExport"),0, $user->rights->export->lire, '', $m['idsel'], 'export');
				$submenu->add("/exports/export.php?leftmenu=export",$langs->trans("NewExport"),1, $user->rights->export->creer);
				//$submenu->add("/exports/export.php?leftmenu=export",$langs->trans("List"),1, $user->rights->export->lire);
			}

			if (! empty($conf->import->enabled))
			{
				$langs->load("exports");
				$submenu->add("/imports/index.php?leftmenu=import",$langs->trans("FormatedImport"),0, $user->rights->import->run, '', $m['idsel'], 'import');
				$submenu->add("/imports/import.php?leftmenu=import",$langs->trans("NewImport"),1, $user->rights->import->run);
			}
			
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}

		/*
		 * Menu MEMBERS
		 */
		if ($m['idsel'] == 'members')
		{
			if (! empty($conf->adherent->enabled))
			{
				// Load translation files required by the page
                $langs->loadLangs(array("members","compta"));

				$submenu->add("/adherents/index.php?leftmenu=members&amp;mainmenu=members",$langs->trans("Members"),0,$user->rights->adherent->lire, '', $m['idsel'], 'members');
				$submenu->add("/adherents/card.php?leftmenu=members&amp;action=create",$langs->trans("NewMember"),1,$user->rights->adherent->creer);
				$submenu->add("/adherents/list.php?leftmenu=members",$langs->trans("List"),1,$user->rights->adherent->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=-1",$langs->trans("MenuMembersToValidate"),2,$user->rights->adherent->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=1",$langs->trans("MenuMembersValidated"),2,$user->rights->adherent->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=1&amp;filter=uptodate",$langs->trans("MenuMembersUpToDate"),2,$user->rights->adherent->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=1&amp;filter=outofdate",$langs->trans("MenuMembersNotUpToDate"),2,$user->rights->adherent->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=0",$langs->trans("MenuMembersResiliated"),2,$user->rights->adherent->lire);
				$submenu->add("/adherents/stats/index.php?leftmenu=members",$langs->trans("MenuMembersStats"),1,$user->rights->adherent->lire);

				$submenu->add("/adherents/cartes/carte.php?leftmenu=export",$langs->trans("MembersCards"),1,$user->rights->adherent->export);
				if (! empty($conf->global->MEMBER_LINK_TO_HTPASSWDFILE) && ($usemenuhider || empty($leftmenu) || $leftmenu=='none' || $leftmenu=="members" || $leftmenu=="export")) $submenu->add("/adherents/htpasswd.php?leftmenu=export",$langs->trans("Filehtpasswd"),1,$user->rights->adherent->export);

				if (! empty($conf->categorie->enabled))
				{
					$langs->load("categories");
					$submenu->add("/categories/index.php?leftmenu=cat&amp;type=3", $langs->trans("Categories"), 1, $user->rights->categorie->lire, '', $m['idsel'], 'cat');
				}

				$submenu->add("/adherents/index.php?leftmenu=members&amp;mainmenu=members",$langs->trans("Subscriptions"),0,$user->rights->adherent->cotisation->lire);
				$submenu->add("/adherents/list.php?leftmenu=members&amp;statut=-1,1&amp;mainmenu=members",$langs->trans("NewSubscription"),1,$user->rights->adherent->cotisation->creer);
				$submenu->add("/adherents/subscription/list.php?leftmenu=members",$langs->trans("List"),1,$user->rights->adherent->cotisation->lire);
				$submenu->add("/adherents/stats/index.php?leftmenu=members",$langs->trans("MenuMembersStats"),1,$user->rights->adherent->lire);

				//$submenu->add("/adherents/index.php?leftmenu=export&amp;mainmenu=members",$langs->trans("Tools"),0,$user->rights->adherent->export, '', $m['idsel'], 'export');
				//if (! empty($conf->export->enabled) && ($usemenuhider || empty($leftmenu) || $leftmenu=="export")) $submenu->add("/exports/index.php?leftmenu=export",$langs->trans("Datas"),1,$user->rights->adherent->export);

				// Type
				$submenu->add("/adherents/type.php?leftmenu=setup&amp;mainmenu=members",$langs->trans("MembersTypes"),0,$user->rights->adherent->configurer, '', $m['idsel'], 'setup');
				$submenu->add("/adherents/type.php?leftmenu=setup&amp;mainmenu=members&amp;action=create",$langs->trans("New"),1,$user->rights->adherent->configurer);
				$submenu->add("/adherents/type.php?leftmenu=setup&amp;mainmenu=members",$langs->trans("List"),1,$user->rights->adherent->configurer);
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}

		// Add personalized menus and modules menus
		//var_dump($submenu->liste);    //

		// We update newmenu for special dynamic menus
		if (!empty($user->rights->banque->lire) && $m['idsel'] == 'bank')	// Entry for each bank account
		{
			require_once DOL_DOCUMENT_ROOT.'/compta/bank/class/account.class.php';

			$sql = "SELECT rowid, label, courant, rappro";
			$sql.= " FROM ".MAIN_DB_PREFIX."bank_account";
			$sql.= " WHERE entity = ".$conf->entity;
			$sql.= " AND clos = 0";
			$sql.= " ORDER BY label";

			$resql = $db->query($sql);
			if ($resql)
			{
				$numr = $db->num_rows($resql);
				$i = 0;

				if ($numr > 0) 	$submenu->add('/compta/bank/list.php',$langs->trans("BankAccounts"),0,$user->rights->banque->lire);

				while ($i < $numr)
				{
					$objp = $db->fetch_object($resql);
					$submenu->add('/compta/bank/card.php?id='.$objp->rowid,$objp->label,1,$user->rights->banque->lire);
					if ($objp->rappro && $objp->courant != Account::TYPE_CASH && empty($objp->clos))  // If not cash account and not closed and can be reconciliate
					{
						$submenu->add('/compta/bank/bankentries_list.php?action=reconcile&contextpage=banktransactionlist-'.$objp->rowid.'&account='.$objp->rowid.'&id='.$objp->rowid.'&search_conciliated=0',$langs->trans("Conciliate"),2,$user->rights->banque->consolidate);
					}
					$i++;
				}
			}
			else dol_print_error($db);
			$db->free($resql);
		}

		if (!empty($conf->ftp->enabled) && $m['idsel'] == 'ftp')	// Entry for FTP
		{
			$MAXFTP=20;
			$i=1;
			while ($i <= $MAXFTP)
			{
				$paramkey='FTP_NAME_'.$i;
				//print $paramkey;
				if (! empty($conf->global->$paramkey))
				{
					$link="/ftp/index.php?idmenu=".$_SESSION["idmenu"]."&numero_ftp=".$i;

					$submenu->add($link, dol_trunc($conf->global->$paramkey,24));
				}
				$i++;
			}
array_push($menu->liste[$k],['subenu'=>$submenu->liste]);			
		}		  



	}
	


