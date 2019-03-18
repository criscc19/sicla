<?php
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/product/stock/class/entrepot.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

$object = new Entrepot($db);

	$object->ref         = GETPOST("ref");
	$object->fk_parent   = 17;
	$object->libelle     = GETPOST("libelle");
	$object->description = GETPOST("desc");
	$object->statut      = GETPOST("statut");
	$object->lieu        = GETPOST("lieu");
	$object->address     = GETPOST("address");
	$object->zip         = GETPOST("zipcode");
	$object->town        = GETPOST("town");
	$object->country_id  = GETPOST("country_id");
	
	$id = $object->create($user);