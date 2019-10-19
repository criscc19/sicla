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
$objPHPExcel->setActiveSheetIndex(0);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//var_dump($ref);

$bodega = 1;
for ($i = 3; $i <= $numRows; $i++) {
		
$ref = $objPHPExcel->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
$label = $objPHPExcel->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
$categoria = $objPHPExcel->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
$stock = $objPHPExcel->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
$costo = $objPHPExcel->getActiveSheet(0)->getCell('K'.$i)->getCalculatedValue();
$precio1 = $objPHPExcel->getActiveSheet(0)->getCell('N'.$i)->getCalculatedValue();
$precio2 = $objPHPExcel->getActiveSheet(0)->getCell('Q'.$i)->getCalculatedValue();
$precio3 = $objPHPExcel->getActiveSheet(0)->getCell('T'.$i)->getCalculatedValue();
$precio4 = $objPHPExcel->getActiveSheet(0)->getCell('W'.$i)->getCalculatedValue();


		$prod = new Product($db);
		$prod->ref = $ref;
		$prod->label = $label;
		$prod->status = 1;
		$prod->status_buy = 1;
		$prod->type = 0;
	    $prod->fk_default_warehouse   = $bodega;
		$prod->default_vat_code = '13 (08 Tarifa general )';
		$prod->tva_tx = 13;
        $id = $prod->create($user);	
		if($id > 0){
		$cat = new categorie($db);
		$cat->fetch('',$categoria);
		$prodc = new Product($db);
		$prodc->fetch($id);
		$cat->add_type($prodc,'product');

		//variable necesarias para el precio
		$price_base_type = 'HT';
		$vat_tx = '13';
		$localtaxes_array = '';	
		$npr = 0;
		$psq = 0;
		$prodc->updatePrice($precio1, $price_base_type, $user, $vat_tx, '', 1, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);
		$prodc->updatePrice($precio2, $price_base_type, $user, $vat_tx, '', 2, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);
		$prodc->updatePrice($precio3, $price_base_type, $user, $vat_tx, '', 3, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);				
		$prodc->updatePrice($precio4, $price_base_type, $user, $vat_tx, '', 4, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);	

	    //agregando stock a bodega 
		//sumando stock
		$res = $prodc->correct_stock(
		$user,
		$bodega,//bodega 
		$stock,//cantidad
		0,//modo
		'Carga inicial desde makito',
		'',
		'Inventario carga inicial'
		);


		$prodc->cost_price = $costo;
		$prodc->update($id, $user);

		}






//echo $ref.'->'.$label.'->'.$categoria.'<br>';	
var_dump($i,$id,$pro->error);
//if($res < 0) {setEventMessages($prod->error, $prod->errors, 'errors');exit;}else{setEventMessages('Stock'.$v['ref'].' actualizado','');}

}






?>