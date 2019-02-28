<?php error_reporting(E_ERROR);?>

    <?php
	
//function dolar(){
                // abrimos la sesión cURL
                $ch = curl_init();

                // definimos la URL a la que hacemos la petición
                curl_setopt($ch, CURLOPT_URL,"http://indicadoreseconomicos.bccr.fi.cr/IndicadoresEconomicos/Cuadros/frmConsultaTCVentanilla.aspx");
                

                // recibimos la respuesta y la guardamos en una variable
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);

                // cerramos la sesión cURL
                curl_close ($ch);

                // hacemos lo que queramos con los datos recibidos
                // por ejemplo, los mostramos
                //print_r($remote_server_output);
//Generar el DOM
$doc = new DOMDocument;
$doc->loadHTML($remote_server_output, LIBXML_COMPACT | LIBXML_NONET);
/* $xmlDoc->load("note.xml");
print $xmlDoc->saveXML(); */

//$body = $doc->getElementsByTagName('body')->item(0);
/* $compra = $doc->getElementById('ctl00_lblMontoCompra');
$venta = $doc->getElementById('ctl00_lblMontoVenta'); */

$tabla = $doc->getElementById('DG');
$tr = $tabla->getElementsByTagName('tr');
//$td = $tr->getElementsByTagName('td');
$i = 0;
$a =0;
echo '<table>';
  	for ($e3 = 1; $e3 <= count($tr); $e3++) {	
		//echo $tr->item($i++);	
		echo '<tr>';
  	for ($e4 = 1; $e4 <= count($tr->item($i)->getElementsByTagName('td')); $e4++) {
	     echo utf8_decode('<td>'.$tr->item($i)->getElementsByTagName('td')->item($a)->nodeValue.'</td>');
		 $a++;
		}
		unset($a);
		$i++;
		echo '</tr>';
			} 
echo '</table>';

/* $json = json_encode($doc->getElementById('DG'));
	$tabla = json_decode($json,TRUE); */

/* foreach($tabla->getElementsByTagName('tr')->item(1) as $k=>$v){
	
echo $k.':'.$v.'<br>';	
}
 */
/* $json = json_encode($doc->getElementById('DG'));
$tabla = json_decode($json,TRUE); */

//var_dump($fci);

//echo $compra->nodeValue.'<br>';
//echo $venta->nodeValue;

/* include_once('init.php');
$db = DB::getInstance();
$c = array('d_compra'=>$compra->nodeValue,'d_venta'=>$venta->nodeValue);
$db->update('ajustes',1,$c); */
//}
?>

