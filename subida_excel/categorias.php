<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');	
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
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
$ruta = 'productos.xlsx';
require 'Classes/PHPExcel/IOFactory.php';	
// Cargo la hoja de cálculo
$objPHPExcel = PHPExcel_IOFactory::load($ruta);
//Asigno la hoja de calculo activa
$objPHPExcel->setActiveSheetIndex(1);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
//var_dump($ref);

$bodega = 2;
for ($i = 2; $i <= $numRows; $i++) {
		
$padre = $objPHPExcel->getActiveSheet(1)->getCell('A'.$i)->getCalculatedValue();
$label = $objPHPExcel->getActiveSheet(1)->getCell('B'.$i)->getCalculatedValue();
if($padre !=''){
    $cat = new categorie($db);
    $cat->fetch('',$padre);
    $paren = $cat->id; 
}else{
$paren = 0;    
}
 
    $cattegoria = new Categorie($db);	
	$cattegoria->label			= $label;
	$cattegoria->description	= $label;
	$cattegoria->visible		= 1;
	$cattegoria->type			= 'product';
    $cattegoria->fk_parent = $paren;
    $result = $cattegoria->create($user);
    

//echo $ref.'->'.$label.'->'.$categoria.'<br>';	
//var_dump($padre,$label);
//if($res < 0) {setEventMessages($prod->error, $prod->errors, 'errors');exit;}else{setEventMessages('Stock'.$v['ref'].' actualizado','');}

}






?>