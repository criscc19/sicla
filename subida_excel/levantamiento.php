<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0); // 0 = Unlimited
require '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
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

$ruta = 'cuentas_por_cobrar.xls';
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
		

$cliente = $objPHPExcel->getActiveSheet(0)->getCell('A'.$i)->getCalculatedValue();
$tipo = $objPHPExcel->getActiveSheet(0)->getCell('C'.$i)->getCalculatedValue();
$ref = $objPHPExcel->getActiveSheet(0)->getCell('D'.$i)->getCalculatedValue();
$datef = $objPHPExcel->getActiveSheet(0)->getCell('E'.$i)->getCalculatedValue();
$vence = $objPHPExcel->getActiveSheet(0)->getCell('H'.$i)->getCalculatedValue();
$total = $objPHPExcel->getActiveSheet(0)->getCell('G'.$i)->getCalculatedValue();
$res_c = $db->query('SELECT rowid FROM `llx_societe` WHERE `code_client` LIKE "'.$cliente.'"');
$societe = $db->fetch_object($res_c)->rowid;


//echo $cedula.'->'.$cliente.'<br>';
if($societe > 0){
	$fac = new Facture($db);
	$fac->socid          = $societe;	// Put id of third party (rowid in llx_societe table)
	$fac->date           = strtotime($datef);
	$fac->note_public    = '';
	$fac->note_private   = '';
	$fac->type   = $tipo;	
	$fac->ref_client   = 'levantamiento de saldos';
	$fac->cond_reglement_id   =  2;
	$fac->date_lim_reglement      = strtotime($vence);
	$fac->mode_reglement_id    = 54;
	//$fac->shipping_method_id  = 1;
	//$fac->multicurrency_code = $factura->ResumenFactura->CodigoTipoMoneda->CodigoMoneda;
	$fac->multicurrency_code = 'CRC';
	//$fac->multicurrency_tx = $multicurrency_tx;
	$fac->user_author = $user->id;
	//echo  $v['rowid'].'<br><hr>';
	
	//creando factura
	$idobject=$fac->create($user);
	//var_dump($fac->error);exit;
   if($idobject){
	$pu_ht = $total; 
	$qty = 1; 
	$txtva = 0; 
	$txlocaltax1=0; 
	$txlocaltax2=0; 
	$fk_product=$fk_product;
	$remise_percent=$descuento; 
	$date_start=''; 
	$date_end=''; 
	$ventil=0; 
	$info_bits=0;
	$fk_remise_except='';
	$price_base_type='HT'; 
	$pu_ttc=''; 
	$type=1; 
	$rang=-1; 
	$special_code=0;
	$origin=''; 
	$origin_id=0; 
	$fk_parent_line=0; 
	$fk_fournprice=null; 
	$pa_ht=0;
	$label=  'LEVANTAMIENTO DE SALDOS'; 
	$array_options=0; 
	$situation_percent=100; 
	$fk_prev_id=0; 
	$fk_unit = null;
	$pu_ht_devise = '';
	
	$resp = $fac->addline($desc, $pu_ht, $qty, $txtva, $txlocaltax1, $txlocaltax2, $fk_product, $remise_percent, $date_start, $date_end, $ventil, $info_bits, $fk_remise_except, $price_base_type, $pu_ttc, $type, $rang, $special_code0, $origin, $origin_id, $fk_parent_line, $fk_fournprice, $pa_ht, $label, $array_options, $situation_percent, $fk_prev_id, $fk_unit, $pu_ht_devise);	   
   //dol_print_error($db,$fac->error);
}

$fac = new Facture($db);
$fac->fetch($idobject);
$resf = $fac->validate($user);
$db->query('UPDATE `llx_facture` SET `facnumber` = "'.$ref.'" WHERE `llx_facture`.`rowid` = '.$idobject.'');

}

}






?>