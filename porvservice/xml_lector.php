<?php error_reporting(E_ERROR);?>
<!-- El tipo de codificación de datos, enctype, DEBE especificarse como sigue -->
<form enctype="multipart/form-data" action="subir.php" method="POST">
    <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
    Enviar este fichero: <input name="fichero_usuario" type="file" />
    <input type="submit" value="Enviar fichero" />
</form>
    <?php
echo 'xml/'.$_GET['fac'].'';exit;
$xmlDoc = simplexml_load_file('xml/'.$_GET['fac'].'');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);
//var_dump($xml[);
//var_dump($xmlDoc);
/* foreach($xml as $k=>$v){
echo $k.': '.$v.'<br>';
}  
 */
//echo '<hr><center>Emisor</center><hr>';
echo '<hr><center>Factura</center><hr>';
foreach($xml as $a=>$b){
if(is_array($b)){echo '';}else{echo '<b>'.$a.'</b>: '.$b.'<br>';}
	
}

echo '<hr><center>Emisor</center><hr>';
foreach($xml as $f=>$s){
if($f=='Emisor'){
foreach($s as $f2=>$s2){
if(is_array($s2)){echo '';}else{echo '<b>'.$f2.'</b>: '.$s2.'<br>';}	



if($f2=='Identificacion'){
foreach($s2 as $f5=>$s5){
	
echo '<b>'.$f5.'</b>: '.$s5.'<br>';

}	
}else{
echo '';
}

if($f2=='Ubicacion'){
foreach($s2 as $f3=>$s3){echo '<b>'.$f3.'</b>: '.$s3.'<br>';}	
}else{
echo '';
}



if($f2=='Telefono'){
foreach($s2 as $f4=>$s4){echo '<b>'.$f4.'</b>: '.$s4.'<br>';}	
}else{
echo '';
}



}	
}else{
echo '';
}

}


echo '<hr><center>Receptor</center><hr>';
foreach($xml['Receptor'] as $c=>$d){
if(is_array($d)){echo '';}else{echo '<b>'.$c.'</b>: '.$d.'<br>';}	



if($c=='Identificacion'){
foreach($d as $c2=>$d2){
	
echo '<b>'.$c2.'</b>: '.$d2.'<br>';

}	
}else{
echo '';
}

if($c=='Ubicacion'){
foreach($d as $c3=>$d3){
	
echo '<b>'.$c3.'</b>: '.$d3.'<br>';

}	
}else{
echo '';
}


if($c=='Telefono'){
foreach($d as $c4=>$d4){
	
echo '<b>'.$c4.'</b>: '.$d4.'<br>';

}	
}else{
echo '';
}




}


echo '<hr><center>Resumen de Factura</center><hr>';
foreach($xml['ResumenFactura'] as $e=>$f){
echo '<b>'.$e.'</b>: '.$f.'<br>';	
	
}


echo '<hr><center>Detalle</center><hr>';

foreach($xml['DetalleServicio']['LineaDetalle'] as $k=>$v){
echo '<hr><center>Numero de Linea : '.$v['NumeroLinea'].'</center><hr>';	
foreach($v as $k2=>$v2){
	
	
if($k2=='Codigo'){
foreach($v2 as $k3=>$v3){echo '<b>'.$k3.'</b>: '.$v3.'<br>';}	
}else{

}

if($k2=='Impuesto'){
	foreach($v2 as $k4=>$v4){echo '<b>'.$k4.'</b>: '.$v4.'<br>';}	
}else{
echo '';
}

if($k2=='Impuesto' || $k2=='Codigo'){echo '';}else{echo '<b>'.$k2.'</b>: '.$v2.'<br>';}
	

} 


} 


?>

