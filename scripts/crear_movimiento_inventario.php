<?php
require '../main.inc.php';
$hoja1 = array()
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

foreach($hoja1 as $v){
//sumando stock
$prod = new Product($db);
$prod->fetch($v['Id']);

$result = $prod->correct_stock(
$user,
5,
$v['stock'],//cantidad
0,// 0 sumara y 1 restara
'Subida masiva',//codigo de movimiento
'',
'Producto ingresado masivamente'//etiqueta del movimiento
);
echo $result.'<br>';//si es correcto regresara 1
}