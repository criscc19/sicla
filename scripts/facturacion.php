<?php


require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT."/compta/facture/class/facture.class.php";
require_once DOL_DOCUMENT_ROOT . '/comm/propal/class/propal.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';

			$sqb = $db->query('SELECT ue.bodega FROM llx_user_extrafields ue WHERE ue.fk_object='.$user->id.'');
			for ($e = 1; $e <= $db->num_rows($sqb); $e++) {
			$objs = $db->fetch_object($sqb);
			$bodega = $objs->bodega;
			}

//$mascara = $conf->global->COTIZACIONES_MASK;
$mascara = 'PROF-{000000+000000}';
$element = 'facture';
$referencia = 'facnumber';
$origin = GETPOST('origin');
$originid = GETPOST('originid');
$propal = new Propal($db);
$propal->fetch($originid);
$num = count($propal->lines);

$obj = new Facture($db);
$soc = new Societe($db);
$soc->fetch($propal->socid);

$ref = get_next_value($db,$mascara,$element,$referencia ,$where,$soc,$obj->date,'next');


$obj->ref            = $ref;
$obj->socid          = $propal->socid;	// Put id of third party (rowid in llx_societe table)
$obj->date           = mktime();
$obj->note           = $propal->note;
$obj->cond_reglement_id = 1;
$line1->multicurrency_code=$propal->multicurrency_code;
$i = 0;
for ($e = 1; $e <= $num; $e++) {
$line1=new FactureLigne($db);
$line1->label=$propal->lines[$i]->label;
$line1->description=$propal->lines[$i]->description;
$line1->qty=$propal->lines[$i]->qty;
$line1->subprice=$propal->lines[$i]->subprice;
$line1->multicurrency_subprice=$propal->lines[$i]->multicurrency_subprice;
$line1->remise_percent=$propal->lines[$i]->remise_percent;
$line1->tva_tx=$propal->lines[$i]->tva_tx;
$line1->fk_product=$propal->lines[$i]->fk_product;

$obj->lines[$e]=$line1;
$i++;
			}
//var_dump($obj->lines);exit;		
		

// Create invoice
$idobject=$obj->create($user,1);
if ($idobject > 0)
{
	// Change status to validated
	$result=$obj->validate($user,$ref,$bodega,1);
	if ($result > 0) print "OK Object created with id ".$idobject."\n";
	else
	{
		$error++;
		dol_print_error($db, $obj->error);
	}
}
else
{
	$error++;
	dol_print_error($db, $obj->error);
}


// -------------------- END OF YOUR CODE --------------------

if (! $error)
{
	$db->commit();
$fac = new facture($db);	
$fac->fetch($idobject);	
$fac->add_object_linked($origin,$originid);	
header('Location: ' . DOL_URL_ROOT . '/compta/facture/card.php?facid='.$idobject.'');
}
else
{
	print '--- end error code='.$error."\n";
	$db->rollback();
}

$db->close();

return $error;
// End of page
llxFooter();
$db->close();
