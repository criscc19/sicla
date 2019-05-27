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

}
//fin creacion de valores de atributos

//creacion de valores de atributos prestashop
        $vari = $db->query('SELECT * FROM `llx_product_attribute_value`');
		for ($s = 1; $s <= $db->num_rows($vari); $s++) {       		
		$variantes = $db->fetch_object($vari);
        $data = array(
		'id_attribute_group'=>'2',
		'name'=>$variantes->value,
		'color'=>'#FFF'
		);
        $res = make_product_options($data);

		if($res >0){
		$db->query('INSERT INTO `llx_prestashop_combination`(`sicla_id`, `presta_id`, `valor`) VALUES ("'.$variantes->rowid.'","'.$res.'","'.$variantes->value.'")');	
		
		}
	
		} 




$e=1;

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


//************bloque de variantes presrashop
$com = $db->query('SELECT ps.presta_id,ps.valor FROM llx_prestashop_combination ps WHERE ps.sicla_id='.$fk_prod_attr_val.'');
for ($s = 1; $s <= $db->num_rows($com); $s++) {
$bjs = $db->fetch_object($com);
$id_variante_val = $bjs->presta_id;
$prodattrval = $bjs->valor;
}

$fk_parent = getProduct($padre->ref);
		$data = array(
		'option_id'=>$id_variante_val,
		'id_product'=>$fk_parent,
		'price'=>'0',
		'quantity'=>'0',
		'id_default_image'=>'0',
		'reference'=>$newproduct
		);		
		$res = add_combination($data);
//************fin bloque de variantes presrashop
}	
if($e==1){
break;exit;	
}  
$e++;
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