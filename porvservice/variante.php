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

$object = new Product($db);
$object->fetch($id, 'M3027');
$prodattr = new ProductAttribute($db);
$prodattr_val = new ProductAttributeValue($db);
$prodcomb = new ProductCombination($db);

$sanit_features = array('1'=>'2');
$price_impact_percent = 0;
$price_impact = 0;
$weight_impact = 0;

$prodcomb->createProductCombination($object, $sanit_features, array(), $price_impact_percent, $price_impact, $weight_impact);
INSERT INTO `llx_product_attribute_combination` (`rowid`, `fk_product_parent`, `fk_product_child`, `variation_price`, `variation_price_percentage`, `variation_weight`, `entity`) VALUES (NULL, '3636', '3685', '0', '0', '0', '1');
INSERT INTO `llx_product_attribute_combination2val` (`rowid`, `fk_prod_combination`, `fk_prod_attr`, `fk_prod_attr_val`) VALUES (NULL, '5', '1', '2');
?>
<? php


require_once ('../ config / config.inc.php'); // PS_SHOP_PATH etc. 
 
require_once ('PSWebServiceLibrary.php');


define ('DEBUG', verdadero); 
define ('PS_SHOP_PATH', 'http://dev.mydomain.ca/magasin/'); 
define ('PS_WS_AUTH_KEY', 'MYAUTHKECODE');

$ id_product = '682';

 

// URL de la imagen externa desde donde descargará la imagen en la carpeta local 
$ remoteImageURL = "http://imagesdesproduits.aviviamobilier.com/imagesDesProduits/selecteur/v4/grandes/caissons_pieces/zonesArmoires84.jpg";


// guarda la imagen en la carpeta local 
$ dir_path_to_save = 'images /'; 


clase GetImage {

/ * 
-------------------------------------------------- ------------------------- 
Créditos de la clase GetImage: 
URL del repositorio de bits : http://www.bitrepository.com/web-programming/php/download -imagen.html
---------------------------------------------- --------------------------- 
* /

var $ source; 
var $ save_to; 
var $ set_extension; 
var $ calidad;

función de descarga ($ method = 'curl') // método predeterminado: cURL 
{ 
$ info = @GetImageSize ($ this-> source); 
$ mime = $ info ['mime'];

if (! $ mime) exit ('No se pudo obtener información de tipo mime. Asegúrese de que el archivo remoto sea realmente una imagen válida.');

// ¿Qué tipo de imagen? 
$ type = substr (strrchr ($ mime, '/'), 1);

switch ($ type)  
{ 
case 'jpeg': 
    $ image_create_func = 'ImageCreateFromJPEG'; 
    $ image_save_func = 'ImageJPEG'; 
    $ new_image_ext = 'jpg'; 
    
    // Mejor calidad: 100 
    $ calidad = isSet ($ this-> calidad)? $ esta-> calidad: 100; 
    descanso;

caso 'png': 
    $ image_create_func = 'ImageCreateFromPNG'; 
    $ image_save_func = 'ImagePNG'; 
    $ new_image_ext = 'png'; 
    
    // Nivel de compresión: de 0 (sin compresión) a 9 
    $ quality = isSet ($ this-> quality)? $ this-> calidad: 0; 
    descanso;

caso 'bmp': 
    $ image_create_func = 'ImageCreateFromBMP'; 
    $ image_save_func = 'ImageBMP'; 
    $ new_image_ext = 'bmp'; 
    descanso;

caso 'gif': 
    $ image_create_func = 'ImageCreateFromGIF'; 
    $ image_save_func = 'ImageGIF'; 
    $ new_image_ext = 'gif'; 
    descanso;

caso 'vnd.wap.wbmp': 
    $ image_create_func = 'ImageCreateFromWBMP'; 
    $ image_save_func = 'ImageWBMP'; 
    $ new_image_ext = 'bmp'; 
    descanso;

caso 'xbm': 
    $ image_create_func = 'ImageCreateFromXBM'; 
    $ image_save_func = 'ImageXBM'; 
    $ new_image_ext = 'xbm'; 
    descanso;

predeterminado:  
    $ image_create_func = 'ImageCreateFromJPEG'; 
    $ image_save_func = 'ImageJPEG'; 
    $ new_image_ext = 'jpg'; 
}

if (isSet ($ this-> set_extension)) 
{ 
$ ext = strrchr ($ this-> source, "."); 
$ strlen = strlen ($ ext); 
$ new_name = basename (substr ($ this-> source, 0, - $ strlen)). '.'. $ new_image_ext; 
} 
else 
{ 
$ new_name = basename ($ this-> source); 
}

$ save_to = $ this-> save_to. $ new_name;

    if ($ method == 'curl') 
    { 
    $ save_image = $ this-> LoadImageCURL ($ save_to); 
    } 
    elseif ($ method == 'gd') 
    { 
    $ img = $ image_create_func ($ this-> source);

        if (isSet ($ quality)) 
        { 
           $ save_image = $ image_save_func ($ img, $ save_to, $ quality); 
        } 
        else 
        { 
           $ save_image = $ image_save_func ($ img, $ save_to); 
        } 
    } 
    
    devolver $ save_image; 
}

función LoadImageCURL ($ save_to) 
{ 
$ ch = curl_init ($ this-> source); 
$ fp = fopen ($ save_to, "wb");

// configurar la URL y otras opciones apropiadas 
$ options = array (CURLOPT_FILE => $ fp, 
                 CURLOPT_HEADER => 0, 
                 CURLOPT_FOLLOWLOCATION => 1, 
                 CURLOPT_TIMEOUT => 60); // 1 minuto de tiempo de espera (debería ser suficiente)

curl_setopt_array ($ ch, $ options);

$ save = curl_exec ($ ch); 
curl_close ($ ch); 
fclose ($ fp);

devuelve $ save; 
} 
}


// inicializa la clase 
$ imagen = nueva GetImage;

$ image-> source = $ remoteImageURL;

$ image-> save_to = $ dir_path_to_save; // con barra al final al final

$ get = $ image-> download ('curl'); // usando GD

if ($ get) 
{ 
echo "La imagen se ha guardado."; 
}

$ nombre_imagen = nombre base ($ remoteImageURL);


// cambiar la ruta local donde se ha descargado la imagen "presta-api" es mi carpeta local desde donde ejecuto el script API 
// $ img_path = '\ wamp \ www \ presta-api \ images \\'. $ nombre_imagen;

$ img_path = $ _SERVER ['DOCUMENT_ROOT']. '/ magasin / webservice / images /'.$ nombre_imagen;

// echo ($ img_path); salida;

// la imagen se asociará con el ID del producto 4 
$ url = PS_SHOP_PATH. 'api / images / products /'.$ id_product; 
 
// echo ($ url); salida; 
 
$ ch = curl_init ();


curl_setopt ($ ch, CURLOPT_URL, $ url); 
curl_setopt ($ ch, CURLOPT_POST, true); 
// curl_setopt ($ ch, CURLOPT_PUT, true); Para editar una foto

curl_setopt ($ ch, CURLOPT_USERPWD, PS_WS_AUTH_KEY. ':'); 
curl_setopt ($ ch, CURLOPT_POSTFIELDS, array ('image' => "@". $ img_path. "; type = image / jpeg")); 
curl_setopt ($ ch, CURLOPT_RETURNTRANSFER, true);


if (curl_exec ($ ch) === false) 
{  
echo "<br> <br> Error:" .curl_error ($ ch). "<br>"; } 
else {echo '<br> <br> Imagen agregada para ID de producto'. $ id_product; echo ($ url); } 
curl_close ($ ch);


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