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
$e = 0;
//var_dump($xml['product'][0]['infostocks']['infostock']);exit;
foreach($xml['product'] as $k=>$v){
	$e++;
	$prod = new product($db);
	$prod->fetch('',trim($v['ref']));
	$stock = $v['infostocks']['infostock']['stock'];
//sumando stock
$prod->correct_stock(
$user,
1,//bodega
$stock,//cantidad
0,//modo
'Carga inicial desde makito',
'',
'Inventario carga inicial'
);

if($e==1){
break;exit;	
} 

}



?>