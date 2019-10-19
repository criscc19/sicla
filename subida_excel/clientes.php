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
$objPHPExcel->setActiveSheetIndex(1);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(1)->getHighestRow();
//var_dump($ref);

$bodega = 2;
for ($i = 3; $i <= $numRows; $i++) {
$cond_reglement_id = $objPHPExcel->getActiveSheet(1)->getCell('A'.$i)->getCalculatedValue();
$nivel_precio = $objPHPExcel->getActiveSheet(1)->getCell('C'.$i)->getCalculatedValue();	
$remise = $objPHPExcel->getActiveSheet(1)->getCell('D'.$i)->getCalculatedValue();	
$commercial_id = $objPHPExcel->getActiveSheet(1)->getCell('E'.$i)->getCalculatedValue();		
$ref = $objPHPExcel->getActiveSheet(1)->getCell('F'.$i)->getCalculatedValue();
$nombre = $objPHPExcel->getActiveSheet(1)->getCell('G'.$i)->getCalculatedValue();
$name_alias = $objPHPExcel->getActiveSheet(1)->getCell('H'.$i)->getCalculatedValue();
$phone = $objPHPExcel->getActiveSheet(1)->getCell('J'.$i)->getCalculatedValue();
$phone2 = $objPHPExcel->getActiveSheet(1)->getCell('K'.$i)->getCalculatedValue();
$fax = $objPHPExcel->getActiveSheet(1)->getCell('L'.$i)->getCalculatedValue();
$cedula = $objPHPExcel->getActiveSheet(1)->getCell('N'.$i)->getCalculatedValue();
$tipo_cedula = $objPHPExcel->getActiveSheet(1)->getCell('P'.$i)->getCalculatedValue();
$email = $objPHPExcel->getActiveSheet(1)->getCell('Q'.$i)->getCalculatedValue();
		$mascara = $conf->global->COMPANY_ELEPHANT_MASK_CUSTOMER;
		$element = 'societe';
		$referencia = 'code_client';
		$numero = get_next_value($db,$mascara,$element,$referencia ,$where,$soc,$obj->date,'next');

/*  		$soc = new Societe($db);
		$soc->name = $nombre;
		$soc->email = $email;
		$soc->name_alias = $nombre.' '.$apellido;
		$soc->country_id = 75;
		$soc->idprof1 = $cedula;		
		$soc->client = 1;
		$soc->fournisseur = 0;
		$soc->phone = $phone.' / '.$phone2;	
		$soc->fax = $fax;		
		$soc->address = '';		
		$soc->status = 1;
		$soc->forme_juridique_code = $tipo_cedula;		
		$soc->code_client = $ref;
		$soc->commercial_id = $commercial_id;		
		$societe = $soc->create($user);  */

		//update 
		$sql = $db->query('SELECT rowid FROM `llx_societe` WHERE `code_client` LIKE "'.$ref.'"');
		$id_soc = $db->fetch_object($sql)->rowid;
		$soc2 = new Societe($db);
		$soc2->fetch($id_soc);
		$soc2->email = $email;
		$soc2->phone = $phone2;	
		//$soc2->set_price_level($cond_reglement_id,$user);
		//$soc2->cond_reglement_id = $cond_reglement_id;
        
		//$res = $soc2->set_remise_client($remise,'descuentos',$user);
		$soc2->update($soc2->id,$user);
			
			
dol_print_error($db,$soc2->error);
//if($res < 0) {setEventMessages($prod->error, $prod->errors, 'errors');exit;}else{setEventMessages('Stock'.$v['ref'].' actualizado','');}
//echo $nombre.'->'.$name_alias.'->'.$cedula.'->'.$tipo_cedula.'->'.$fax.'->'.$email.'<br>';
}






?>