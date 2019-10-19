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
require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
require_once DOL_DOCUMENT_ROOT.'/categories/class/categorie.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';

$ruta = 'clientes.xls';
require 'Classes/PHPExcel/IOFactory.php';	
// Cargo la hoja de cálculo
$objPHPExcel = PHPExcel_IOFactory::load($ruta);
//Asigno la hoja de calculo activa
$objPHPExcel->setActiveSheetIndex(0);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//var_dump($ref);

$bodega = 2;
for ($i = 2; $i <= $numRows; $i++) {
$ref = $objPHPExcel->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
$nombre = $objPHPExcel->getActiveSheet(0)->getCell('B'.$i)->getCalculatedValue();
$nombre_c = $objPHPExcel->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
$phone = $objPHPExcel->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
$fax = $objPHPExcel->getActiveSheet(0)->getCell('F'.$i)->getCalculatedValue();
$email = $objPHPExcel->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
		$mascara = $conf->global->COMPANY_ELEPHANT_MASK_CUSTOMER;
		$element = 'societe';
		$referencia = 'code_client';
		$numero = get_next_value($db,$mascara,$element,$referencia ,$where,$soc,$obj->date,'next');

 		$soc = new Societe($db);
		$soc->name = $nombre;
		$soc->email = $email;
		$soc->firstname = $nombre_c;
		$soc->country_id = 75;
		$soc->client = 1;
		$soc->fournisseur = 1;
		$soc->code_fournisseur = $ref;		
		$soc->phone = $phone;	
		$soc->fax = $fax;		
		$soc->address = '';		
		$soc->status = 1;
		$soc->code_client = $ref;
		$societe = $soc->create($user); 
var_dump($societe,$soc->errors);
		if($societe > 0 && $nombre_c !=''){
		$soc->create_individual($user);	
		//echo $societe.'<br>';
		}
			
			

//if($res < 0) {setEventMessages($prod->error, $prod->errors, 'errors');exit;}else{setEventMessages('Stock'.$v['ref'].' actualizado','');}
//echo $nombre.'->'.$name_alias.'->'.$cedula.'->'.$tipo_cedula.'->'.$fax.'->'.$email.'<br>';
}






?>