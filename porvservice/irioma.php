<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
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


/* $xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemPrintingFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);

//BLOQUE MOSTRAR TODO//
 $e = 0;
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
print '<a class="button" href="'.$_SERVER['PHP_SELF'].'?action=stock&prove=makito">Carga inicial de stock</a><br><br><br>';
}


if($action == 'productos' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
$e = 1;
//BOLOQUE PRODUCTOS

foreach($xml['product'] as $k=>$v){	

$prod = new Product($db);
$prod->ref = $v['ref'];
$prod->label = $v['type'].' - '.$v['name'];
$prod->description = $v['extendedinfo'];
$prod->type = 0;
$prod->fk_default_warehouse = 1;
$prod->url = $v['link360'];
if(!is_array($v['item_long']))$prod->width = $v['item_long'];
if(!is_array($v['item_hight']))$prod->height = $v['item_hight'];
if(!is_array($v['item_weight']))$prod->weight = $v['item_weight'];
$prod->status = 1;
$prod->status_buy = 1;
$prod->default_vat_code = 'HT';
$id = $prod->create($user);

$cat = new categorie($db);
$cat->fetch('',trim($v['categories']['category_name_1']));
$prodc = new Product($db);
$prodc->fetch($id);
$cat->add_type($prodc,'product');

 if($e==1){
break;exit;	
}  
 $e++;
}

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

foreach($cat as $ca){
$cattegoria = new Categorie($db);	
	$cattegoria->label			= $ca;
	$cattegoria->description	= 'Generada por Makito';
	$cattegoria->visible		= 1;
	$cattegoria->type			= 'product';
    $cattegoria->fk_parent = 1;
	$result = $cattegoria->create($user);
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

$e=0;
print '<table border="1">';
foreach($variantes as $k1=>$v1){



foreach($variantes[$k1] as $k2=>$v2){
	
	
//bolque subir imagenes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];
$url = $v2['imagen'];
$img = 'img/'.$v2['ref'].'/'.$ima[5];
$img2 = 'img/'.$k1.'/'.$ima[5];

//imagenes padre
/* file_put_contents($img2, file_get_contents($url));
$re1 = resize_image($img2,'img/'.$k1.'/thumbs/'.$ima_nom.'_mini.'.$ima_ext,100,110,80);
$re2 = resize_image($img2,'img/'.$k1.'/thumbs/'.$ima_nom.'_small.'.$ima_ext,100,120,80); */
//fin imagenes padre


//fin bolque subir imagenes

//bolque crear directorios	 variantes
/* if (!file_exists('img/'.$v2['ref'].'')) {
    mkdir('img/'.$v2['ref'].'', 0777, true);
}
if (!file_exists('img/'.$v2['ref'].'/thumbs')) {
    mkdir('img/'.$v2['ref'].'/thumbs', 0777, true);
} */
//fin bolque crear directorios	 variantes

//bolque subir imagenes variantes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];
$url = $v2['imagen'];
$img = 'img/'.$v2['ref'].'/'.$ima[5];
/* file_put_contents($img, file_get_contents($url));
$re1 = resize_image($img,'img/'.$v2['ref'].'/thumbs/'.$ima_nom.'_mini.'.$ima_ext,100,110,80);
$re2 = resize_image($img,'img/'.$v2['ref'].'/thumbs/'.$ima_nom.'_small.'.$ima_ext,100,120,80); */
//finbolque subir imagenes variantes
$ima = explode('/',$v2['imagen']);
$ima_arr = explode('.',$ima[5]);
$ima_nom = $ima_arr[0];
$ima_ext = $ima_arr[1];

}	
/* if($e==1){
break;exit;	
}  */
$e++;
}


llxFooter();

/* foreach($xml['product'][1]['variants']['variant'] as $k=>$v){
$ref = explode($v['colour'],$v['refct']);
echo $ref[0].'<br>';
echo $v['colour'].'<br>';
exit;
}
 */

//fin las categorias


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








if($action == 'stock' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/allstockgroupedfile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);
$e = 0;
//var_dump($xml['product'][0]['infostocks']['infostock']);exit;
foreach($xml['product'] as $k=>$v){
	$e++;
	$prod = new product($db);
	$prod->fetch('',trim($v['ref']));
	$stock = $v['infostocks']['infostock']['stock'];
//sumando stock
$prod->correct_stock(
$user,
1,//bodega
$stock,//cantidad
0,//modo
'Carga inicial desde makito',
'',
'Inventario carga inicial'
);

if($e==1){
break;exit;	
} 

}
}



if($action == 'precios' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/PriceListFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a');
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);

foreach($xml['product'] as $k=>$v){
$price_base_type = 'HT';
$vat_tx = '0';
$localtaxes_array = '';	
$npr = 0;
$psq = 0;

$precio1 = $v['price1'] * 45/100;
$precio2 = $v['price1'] + $precio1;
$precio3 = $precio2 * 95/100;
$precio4 = $precio2 + $precio3;
$prod = new Product($db);
$prod->fetch('',trim($v['ref']));

$precio11 = $v['price1'] * 45/100;
$precio22 = $v['price1'] + $precio11;
$precio33 = $precio22 * 95/100;
$precio44 = $precio22 + $precio33;


$prod->updatePrice($precio4, $price_base_type, $user, $vat_tx, $precio4, 1, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);
$prod->updatePrice($precio44, $price_base_type, $user, $vat_tx, $precio44, 2, $npr, $psq, 0, $localtaxes_array, $prod->default_vat_code);

}
}




if($action == 'colores' && $prove="makito"){
$xmlDoc = simplexml_load_file('http://print.makito.es:8080/user/xml/ItemDataFile.php?pszinternal=4f781ea0505b41a5562b4f5124afed0a&ldl=esp');
//$xml = simplexml_load_string($xmlDoc, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xmlDoc);
$xml = json_decode($json,TRUE);	
//*******BLOQUE DE CATEGORIAS ****///
//var_dump($xml['product'][0]['variants']);exit;
$cont = count($xml['product']);
$colores = array();
$variates = array();

for ($i = 0; $i <= $cont; $i++) {
if(isset($xml['product'][$i]['variants'])){
foreach($xml['product'][$i]['variants']['variant'] as $k=>$v){
if(isset($v['colour']) && !is_array($v['colour'])){
	
$ref = explode($v['colour'],$v['refct']);	
$variantes[$ref[0]][]= array('ref'=>$v['matnr'],'codigo'=>$v['colour'],'atributo'=>$v['colourname'],'talla'=>$v['size'],'imagen'=>$v['image500px']);
$llave = str_replace (' ', '',$v['colour']);
$colores[$llave] = array('color'=>$v['colourname'],'codigo'=>$llave);
} 	
}	
}

}

//creacion de valores de atributos
foreach($colores as $k=>$v){
	if(!is_array($v['color'])){
$objectval = new ProductAttributeValue($db);

		$objectval->fk_product_attribute = 1;
		$objectval->ref = $v['codigo'];
		$objectval->value = $v['color'];	
$objectval->create($user);
}		
//echo $v['codigo'].':'.$v['color'].'<br>';
}





$e=0;
print '<table border="1">';
foreach($variantes as $k1=>$v1){



foreach($variantes[$k1] as $k2=>$v2){
$padre = new Product($db);
$padre->fetch('',trim($k1));
//creando productos variantes
$prod = new Product($db);
$prod->ref = $v2['ref'];
$prod->label = $padre->label.'('.$v2['atributo'].')';
$prod->description = $padre->description;
$prod->type = 0;
$prod->fk_default_warehouse = 1;
$prod->url = $padre->url;
$prod->width = $padre->width;
$prod->height = $padre->height;
$prod->weight = $padre->weight;
$prod->status = 1;
$prod->status_buy = 1;
$prod->default_vat_code = 'HT';
$id = $prod->create($user);

$sq1 = $db->query('SELECT fk_categorie  FROM llx_categorie_product cp
JOIN llx_categorie c ON cp.fk_categorie=c.rowid
WHERE `fk_product` = '.$padre->id.'');
$cat_id = $db->fetch_object($sq1)->fk_categorie;

//agregando producto a categorias 
$cat = new categorie($db);
$cat->fetch($cat_id);
$prod = new Product($db);
$prod->fetch($id);
$cat->add_type($prod,'product');

//actualizando precios
$price_base_type = 'HT';
$vat_tx = '0';
$localtaxes_array = '';	
$npr = 0;
$psq = 0;
$prod->updatePrice($padre->multiprices[1], $price_base_type, $user, $vat_tx, $padre->multiprices[1], 1, $npr, $psq, 0, $localtaxes_array, $padre->default_vat_code);
$prod->updatePrice($padre->multiprices[2], $price_base_type, $user, $vat_tx, $padre->multiprices[2], 2, $npr, $psq, 0, $localtaxes_array, $padre->default_vat_code);

//obteniedo id del valor del attributo por referencia del product atribute
$sq1 = $db->query('SELECT rowid FROM llx_product_attribute_value WHERE ref="'.trim($v2['codigo']).'" AND fk_product_attribute=1');
$attib_id = $db->fetch_object($sq1)->rowid;
	
$db->query('INSERT INTO `llx_product_attribute_combination` 
(`fk_product_parent`, `fk_product_child`, `variation_price`, `variation_price_percentage`, `variation_weight`, `entity`) 
VALUES ("'.$padre->id.'", "'.$id.'", "0", "0", "0", "1")');

$comb_id = $db->last_insert_id('llx_product_attribute_combination');
$db->query('INSERT INTO `llx_product_attribute_combination2val` 
(`fk_prod_combination`, `fk_prod_attr`, `fk_prod_attr_val`) 
VALUES ("'.$comb_id.'", "1", "'.$attib_id.'")');
;


}	
if($e==1){
break;exit;	
}  
$e++;
}


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