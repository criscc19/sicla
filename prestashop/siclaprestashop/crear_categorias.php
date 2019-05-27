<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/genericobject.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/product.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/modules/product/modules_product.class.php';
require_once DOL_DOCUMENT_ROOT.'/variants/class/ProductAttribute.class.php';
require_once DOL_DOCUMENT_ROOT.'/variants/class/ProductAttributeValue.class.php';

$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
//*******BLOQUE DE CATEGORIAS ****///

$a = 1;
$cat = array();
foreach($xml['product'] as $kk=>$vv){
$cat[$vv['categories']['category_ref_1']] = $vv['categories']['category_name_1'];
}

foreach($cat as $ca){
$cattegoria = new Categorie($db);	
	$cattegoria->label			= $ca;
	$cattegoria->description	= 'Generada por Makito';
	$cattegoria->visible		= 1;
	$cattegoria->type			= 'product';
    $cattegoria->fk_parent = 1;
	$result = $cattegoria->create($user);
	
	$data=array('id_parent'=>2,'id_shop_default'=>1,'name'=>''.$ca.'','description'=>''.$ca.'','link_rewrite'=>'link_rewrite_test');
    make_categories($data);
}
//fin las categorias

//*******BLOQUE DE CATEGORIAS ****///





?>