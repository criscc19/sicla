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
$e = 1;
//BOLOQUE PRODUCTOS

foreach($xml['product'] as $k=>$v){	

$prod = new Product($db);
$prod->ref = $v['ref'];
$prod->label = $v['type'].' - '.$v['name'];
$prod->description = $v['extendedinfo'];
$prod->type = 0;
$prod->fk_default_warehouse = 1;
$prod->url = $v['link360'];
if(!is_array($v['item_long']))$prod->width = $v['item_long'];
if(!is_array($v['item_hight']))$prod->height = $v['item_hight'];
if(!is_array($v['item_weight']))$prod->weight = $v['item_weight'];
$prod->status = 1;
$prod->status_buy = 1;
$prod->default_vat_code = 'HT';
$id = $prod->create($user);

$cat = new categorie($db);
$cat->fetch('',trim($v['categories']['category_name_1']));
$prodc = new Product($db);
$prodc->fetch($id);
$cat->add_type($prodc,'product');

/* if($e==10){
break;exit;	
}  */
 $e++;
}

?>