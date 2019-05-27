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

foreach($xml['product'] as $k=>$v){
$price_base_type = 'HT';
$vat_tx = '13';
$localtaxes_array = '';	
$npr = 0;
$psq = 0;

$precio1 = $v['price1'] * 45/100;
$precio2 = $v['price1'] + $precio1;
$precio3 = $precio2 * 95/100;
$precio4 = $precio2 + $precio3;
$prod = new Product($db);
$prod->fetch('',trim($v['ref']));

$precio11 = $v['price1'] * 45/100;
$precio22 = $v['price1'] + $precio11;
$precio33 = $precio22 * 95/100;
$precio44 = $precio22 + $precio33;


$prod->updatePrice($precio4, $price_base_type, $user, $vat_tx, $precio4, 1, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);
$prod->updatePrice($precio44, $price_base_type, $user, $vat_tx, $precio44, 2, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);

}



?>