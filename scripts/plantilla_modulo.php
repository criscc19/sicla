<?php 
	require '../main.inc.php';
	
	$arrayofcss=array(
	//'/css/main.css',
	//'plugins/css/bootstrap.css'
	);
	$arrayofjs=array(
	//'/pos/frontend/plugins/js/bootstrap.js'
	);
	
	llxHeader('',$langs->trans("Listado de cotizaciones"),'','',0,0,$arrayofjs,$arrayofcss);
	$currency_code = $conf->currency;
	
	print load_fiche_titre($langs->trans("Cotizaciones"));
	
	$sql = $db->query('SELECT * FROM llx_propal p WHERE p.date_valid IS NULL AND p.fk_user_author='.$user->id.'');
		for ($p = 1; $p <= $db->num_rows($sql); $p++) {
        $obj = $db->fetch_object($sql);
		echo $obj->ref;
		}
	
    dol_fiche_end();
    llxFooter();
	
	$db->close();
?>