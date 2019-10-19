<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0); // 0 = Unlimited
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

$ruta = 'conteo3.xlsx';
require 'Classes/PHPExcel/IOFactory.php';	
// Cargo la hoja de cálculo
$objPHPExcel = PHPExcel_IOFactory::load($ruta);
//Asigno la hoja de calculo activa
$objPHPExcel->setActiveSheetIndex(0);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//var_dump($ref);

$bodega = 2;
for ($i = 6; $i <= $numRows; $i++) {
		
$ref = $objPHPExcel->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
$stock = $objPHPExcel->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
//echo $ref.':'.$stock.'<br>';
$prod = new product($db);
$prod->fetch('',$ref);
//echo $prod->ref.'->'.$stock.'<br>';
$res = $db->query('DELETE FROM `llx_product_stock` WHERE `fk_product` = '.$prod->id.' AND `fk_entrepot` = '.$bodega.'');
//echo $res.'<br>';
//sumando stock
$res = $prod->correct_stock(
$user,
$bodega,//bodega 
$stock,//cantidad
0,//modo
'Actualizacion de inventario de forma masiva',
'',
'Actualizacion de inventario de forma masiva'
);

//if($res < 0) {setEventMessages($prod->error, $prod->errors, 'errors');exit;}else{setEventMessages('Stock'.$v['ref'].' actualizado','');}

}






?>