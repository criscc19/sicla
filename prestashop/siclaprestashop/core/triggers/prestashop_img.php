<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
require '../main.inc.php';
$action = GETPOST('action');
$prove = GETPOST('prove');
	$arrayofcss=array(
	'/subida_xml/datatables/datatables.css',
	'/subida_xml/datatables/FixedColumns-3.2.5/css/fixedColumns.dataTables.css'
	);
	$arrayofjs=array(
	'/subida_xml/datatables/datatables.js',
	'/subida_xml/datatables/FixedColumns-3.2.5/js/dataTables.fixedColumns.js',
	'/subida_xml/datatables/buttons.html5.js',
	'/subida_xml/datatables/pdfmake.js'
	);
	$title = 'Detalle de la cotización';
	llxHeader('',$title,'','',0,0,$arrayofjs,$arrayofcss);
/* http://print.makito.es:8080/user/xml/allstockgroupedfile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a

http://print.makito.es:8080/user/xml/PriceListFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a 

http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp 


http://print.makito.es:8080/user/xml/ItemPrintingFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a  */


//productos
/*
ref:2008
name:Nwovenband
type:Cinta Sombrero
composition:Non-Woven
otherinfo:Array
extendedinfo:Cinta de non-ven para sombrero, en variada gama de colores. Se sirve cortada en piezas de 67x2,7cm.
brand:Array
printcode:Array
item_long:67
item_hight:2.7
item_width:Array
item_diameter:Array
item_weight:2
masterbox_long:Array
masterbox_hight:Array
masterbox_width:Array
masterbox_weight:Array
masterbox_units:0
palet_units:126000
palet_boxs:42
palet_weight:580
categories:Array
link360:http://etools.boxpromotions.com/videos/2008/360/output/2008.html
linkvideo:Array
variants:Array
$action = GETPOST('action');
$prove = GETPOST('prove');
*/


//variante
/*
matnr:12008005000
refct:2008AMAS/T
colour:AMA
colftp:AMA
colourname:AMARILLO 
size:S/T
image500px:http://www.boxpromotions.com/imagenes/0-7999/2008-05.jpg	
*/


//categoria
/*
category_ref_1:31
category_name_1:VINO, ACCESORIOS DE BEBIDA Y HOSTELERÃA 
category_ref_2:Array
category_name_2:Array
category_ref_3:Array
category_name_3:Array
category_ref_4:Array
category_name_4:Array
category_ref_5:Array
category_name_5:Array
*/



print '<center><h2>Bienvenido a la interfas de importacion de datos de proveedores</h2></center>';
print '<center><b>Informacion extraida en tiempor real de la url: http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp</b></center><br><br><br><br>';
//$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
//$json = json_encode($xmlDoc);
//$xml = json_decode($json,TRUE);	
/* foreach($xml['product'][15]['categories'] as $k=>$v){
echo $k.':'.$v['category_name_1'].'<br>';	
}; */
//echo $xml['product'][15]['categories']['category_name_1'];
//exit;
//var_dump($xml['product'][0]);


$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
	
//BLOQUE MOSTRAR TODO//
/*  $e = 0;
foreach($xml['product'] as $k=>$v){
print '<tr><td>'.$e++.'</br>';	
foreach($v as $kk=>$vv){
if( !is_array($vv))	
echo $kk.':'.$vv.'</br>';
if( is_array($vv)){
foreach($vv as $f=>$r){
if( !is_array($vv))	 echo $f.':'.$r.'<br>';

if( is_array($r))
foreach($r as $ff=>$rr){
	
if( !is_array($rr)) echo $ff.':'.$rr.'<br>';
if( is_array($rr)){
foreach($rr as $fff=>$rrr){

if(strpos($rrr, 'imagenes')==true){echo $fff.':<br><img src="'.$rrr.'" width="100"><br>';}else{echo $fff.':'.$rrr.'<br>';}
}
}
}
}
} 
}
echo '</tr>';
if($e==50){
break;exit;	
}

}

print '</table>';  
exit;
 */
/*FIN BLOQUE MOSTRAR TODO*/

print '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
print 'Elija el proveedor a importar:
<select name="prove">
<option></option>
<option value="makito">Makito</option>
</select>';
print '<input class="button" type="submit" value="Cargar opciones">';
print '</form>';

if($prove == 'makito'){
	
print '<a class="button" href="'.$_SERVER['PHP_SELF'].'?action=productos&prove=makito">Importar productos de Makito</a><br><br><br>';	
print '<a class="button" href="'.$_SERVER['PHP_SELF'].'?action=categorias&prove=makito">Importar Categorias de Makito</a><br><br><br>';
print '<a class="button" href="'.$_SERVER['PHP_SELF'].'?action=variantes&prove=makito">Importar Variantes de Makito</a><br><br><br>';
}


if($action == 'productos' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
$e = 1;
//BOLOQUE PRODUCTOS
print '<table border="1" id="dtabla">';
print '<thead>';
print '<tr>';
print '<th>NUM</th>';
print '<th>REF</th>';
print '<th>LABEL</th>';
print '<th>DESCRIPCION</th>';
print '<th>LINK30</th>';
print '</tr>';
print '</thead>';
print '<tbody>';
foreach($xml['product'] as $k=>$v){

print '<tr>';
print '<td>'.$e++.'</td>';
print '<td>'.$v['ref'].'</td>';
print '<td>'.$v['type'].' - '.$v['name'].'</td>';
print '<td>'.$v['extendedinfo'].'</td>';
print '<td>'.$v['link360'].'</td>';
print '</tr>';
if($e==50){
break;exit;	
} 
 
}
print '</tbody>';
print '<tfoot>';
print '<tr>';
print '<th></th>';
print '<th></th>';
print '<th></th>';
print '<th></th>';
print '</tr>';
print '</tfoot>';
print '</table>'; 
//FIN BOLOQUE PRODUCTOS
}



if($action == 'categorias' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
//*******BLOQUE DE CATEGORIAS ****///

$a = 1;
$cat = array();
foreach($xml['product'] as $kk=>$vv){
$cat[$vv['categories']['category_ref_1']] = $vv['categories']['category_name_1'];
}
//aqui comienza las categorias

print '<b>Total de categorias:</b> '.count($cat).'<br>';
print '<table border="1">';
print '<tr>';
print '<td>NUM</td>';
print '<td>CATEGORIA</td>';
print '</tr>';
foreach($cat as $ca){
print '<td>'.$a++.'</td>';
print '<td>'.$ca.'</td>';

print '</tr>';
}
//fin las categorias

//*******BLOQUE DE CATEGORIAS ****///
}



if($action == 'variantes' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
//*******BLOQUE DE CATEGORIAS ****///
//var_dump($xml['product'][0]['variants']);exit;
$cont = count($xml['product']);
$variates = array();

for ($i = 0; $i <= $cont; $i++) {
if(isset($xml['product'][$i]['variants'])){
foreach($xml['product'][$i]['variants']['variant'] as $k=>$v){
if(isset($v['colour']) && !is_array($v['colour'])){
$ref = explode($v['colour'],$v['refct']);	
$variantes[$ref[0]][]= array('ref'=>$v['matnr'],'codigo'=>$v['colour'],'atributo'=>$v['colourname'],'talla'=>$v['size'],'imagen'=>$v['image500px']);
} 	
}	
}

}

$e = 1;
$p = 1;

foreach($variantes as $k1=>$v1 ){

foreach($v1 as $k2=>$v2 ){
//bolque crear directorios	 variantes
if (!file_exists('img2/'.$p.'')) {
    mkdir('img2/'.$p.'', 0777, true);
}	
	
//bolque subir imagenes variantes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];
$url = $v2['imagen'];
$img = 'img2/'.$p.'/'.$p.'.'.$ima_ext;
file_put_contents($img, file_get_contents($url));
$re1 = resize_image($img,'img2/'.$p.'/'.$p.'-cart_default.'.$ima_ext,125,125,100);
$re2 = resize_image($img,'img2/'.$p.'/'.$p.'-home_default.'.$ima_ext,250,250,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-large_default.'.$ima_ext,800,800,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-medium_default.'.$ima_ext,452,452,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-small_default.'.$ima_ext,98,98,100);
$sq = '
INSERT INTO `llx__prestashop_img`
(`padre`, `hijo`, `id_img`, `valor`, `codigo`)
 VALUES ("'.$k1.'","'.$v2['ref'].'","'.$p.'","'.$v2['atributo'].'","'.$v2['atributo'].'")';
$db->query($sq);

echo $k1.':'.$k2.':'.$v2['ref'].'<br>';

}
echo '<hr>';
/* if($e==2){
break;exit;	
} */
$e++;
$p++;
}

/* foreach($variantes as $k1=>$v1){

foreach($variantes[$k1] as $k2=>$v2){
$p++;
$e++;
//bolque crear directorios	 variantes
if (!file_exists('img2/'.$p.'')) {
    mkdir('img2/'.$p.'', 0777, true);
}


//fin bolque crear directorios	 variantes

//bolque subir imagenes variantes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];
$url = $v2['imagen'];
$img = 'img2/'.$p.'.'.$ima_ext;
file_put_contents($img, file_get_contents($url));

$re1 = resize_image($img,'img2/'.$p.'/'.$p.'-cart_default.'.$ima_ext,125,125,100);
$re2 = resize_image($img,'img2/'.$p.'/'.$p.'-home_default.'.$ima_ext,250,250,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-large_default.'.$ima_ext,800,800,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-medium_default.'.$ima_ext,452,452,100);
$re3 = resize_image($img,'img2/'.$p.'/'.$p.'-small_default.'.$ima_ext,98,98,100);
//finbolque subir imagenes variantes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];
print '<tr>';
print '<td>'.$v2['ref'].'</td>';
print '<td>'.$v2['codigo'].'</td>';
print '<td>'.$v2['atributo'].'</td>';
//print '<td><img src="'.$v2['imagen'].'" width="50px" height="50px"></td>';
print '<td><img src="img2/'.$p.'.'.$ima_ext.'" width="50px" height="50px"></td>';
print '<td>'.$v2['talla'].'</td>';
print '</tr>';	
}	
if($e==2){
break;exit;	
} 

} */
print '</table>';

llxFooter();

/* foreach($xml['product'][1]['variants']['variant'] as $k=>$v){
$ref = explode($v['colour'],$v['refct']);
echo $ref[0].'<br>';
echo $v['colour'].'<br>';
exit;
}
 */

//fin las categorias

//*******BLOQUE DE CATEGORIAS ****///
}

//*******REDIMENCIONAR IMAGEN****///
function resize_image($file,$target,$w, $h,$imgQuality,$crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagejpeg($dst,$target, $imgQuality);
    return $dst;
}
?>
<script>
$(document).ready( function () {
    $('#dtabla').DataTable(
	{
	 'language':{
	'sProcessing':     'Procesando...',
	'sLengthMenu':     'Mostrar _MENU_ registros',
	'sZeroRecords':    'No se encontraron resultados',
	'sEmptyTable':     'Ningún dato disponible en esta tabla',
	'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
	'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
	'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
	'sInfoPostFix':    '',
	'sSearch':         'Buscar:',
	'sUrl':            '',
	'sInfoThousands':  ',',
	'sLoadingRecords': 'Cargando...',
	'oPaginate': {
		'sFirst':    'Primero',
		'sLast':     'Último',
		'sNext':     'Siguiente',
		'sPrevious': 'Anterior'
	},
	'oAria': {
		'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
		'sSortDescending': ': Activar para ordenar la columna de manera descendente'
	}
},
'displayLength': '999999',
  dom: 'Bfrtip',
 buttons: [ 
            { extend: 'copyHtml5', footer: true,orientation: 'landscape',pageSize: 'A4' },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true,pageSize: 'A4',
			
			 messageTop: 'Productos importados',

			},
			{extend: 'print',footer: true,
			customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '8pt')
                     
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
			}
			],

	}
	);
} );
</script>