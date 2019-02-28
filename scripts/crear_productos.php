<?php
require '/mainincphp';
$productos = array();
require_once DOL_DOCUMENT_ROOT'/product/class/productclassphp';
foreach($productos as $v){
$iv = $v['PRECIO'] * 13/100;
$price_iva = $v['PRECIO'] - $iv;
$pro = new product($db);
$pro->ref = $v['ref'];
//$soc->code_fournisseur =  $tmpcode;
$pro->label = $v['label'];
$pro->status = 1;
$pro->status_buy = 1;
$pro->type = 0;
$pro->tva_tx = 13;
$pro->price_base_type ='TTC';// TTC con iva, HT sin iva
$pro->price =$price_iva;//precio sin iva
$pro->price_ttc =$v['PRECIO'];//precio con iva
$result= $pro->create($user);
echo $result'<br>';
var_dump($pro->error);
}