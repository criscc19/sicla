<?php
define('DEBUG', false);
define('PS_SHOP_PATH', 'http://localhost/prestashop');
define('PS_WS_AUTH_KEY', 'UYMRWW17167Q92NP39IK575IJJDE38F7');
require_once('class/PSWebServiceLibrary.php');


function add_combination($data){
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
	try{
		$xml                                                                            = $webService->get(array('url' => PS_SHOP_PATH.'/api/combinations?schema=blank'));

		$combination                                                                    = $xml->children()->children();
		
		$combination->associations->product_option_values->product_option_values[0]->id = $data["option_id"];
		$combination->associations->images->image->id = $data["id_default_image"];
		$combination->reference                                                         = $data["code"];
		$combination->id_product                                                        = $data["id_product"];
		$combination->price                                                             = $data["price"]; //Prix TTC
		$combination->show_price                                                        = 1;
		$combination->quantity                                                          = $data["quantity"]; //Prix TTC
		$combination->minimal_quantity                                                  = 1;
		//$product_option_value->id                                                     = 1;    
		
		//var_dump($combination->associations->images);exit;	
		$opt                                                                            = array('resource' => 'combinations');
		$opt['postXml']                                                                 = $xml->asXML();
		sleep(1);
		$xml                                                                            = $webService->add($opt); 
		$combination                                                                    = $xml->combination;
	} catch (PrestaShopWebserviceException $e){
		return;
	}
	//insert stock
	return $combination;
}


function make_product_options($data){
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);	
	try{
		$xml                                              = $webService->get(array('url' =>  PS_SHOP_PATH.'/api/product_option_values?schema=blank'));
		
		$product_option_value                             = $xml->children()->children();
		
		//$product_option_value->id                       = 1;    
		$product_option_value->id_attribute_group         = $data["id_attribute_group"];
		
		$product_option_value->name->language[0][0]       = $data["name"];
		$product_option_value->name->language[0][0]['id'] = 1;
		
		
		$opt                                              = array('resource' => 'product_option_values');
		$opt['postXml']                                   = $xml->asXML();
		sleep(1);
		$xml                                              = $webService->add($opt); 
		$product_option_value                             = $xml->product_option_value;
	} catch (PrestaShopWebserviceException $e){
		return 0;
	}
	//insert stock
	return (int) $product_option_value->id;
}
$data = array('id_attribute_group'=>'2','name'=>'prueba atributo');
function make_father_product($data){
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);	
	try{
		$xml                                                                  = $webService->get(array('url' => PS_SHOP_PATH.'/api/products?schema=blank'));
		$product                                                              = $xml->children()->children();
		
		$product->price                                                       = $data["price"]; //Prix TTC
		$product->wholesale_price                                             =$data["price"]; //Prix d'achat
		$product->active                                                      = '1';
		$product->on_sale                                                     = 1; //on ne veux pas de bandeau promo
		$product->show_price                                                  = 1;
		$product->available_for_order                                         = 1;
		
		$product->name->language[0][0]                                        = $data["name"];
		$product->name->language[0][0]['id']                                  = 1;
		
		$product->description->language[0][0]                                 = $data["description"];
		$product->description->language[0][0]['id']                           = 1;
		
		$product->description_short->language[0][0]                           = $data["description"];
		$product->description_short->language[0][0]['id']                     = 1;
		$product->reference                                                   = $data["code"];
		
		$product->associations->categories->addChild('category')->addChild('id', $data["category_id"]);
		$product->id_category_default                                         = $data["category_id"];
		
		//$product->associations->stock_availables->stock_available->quantity = 1222;
		
		$opt                                                                  = array('resource' => 'products');
		$opt['postXml']                                                       = $xml->asXML();
		sleep(1);
		$xml                                                                  = $webService->add($opt); 
		
		$product                                                              = $xml->product;
	} catch (PrestaShopWebserviceException $e){
		return;
	}
	return (int) $product->id;
}


function make_product($data){
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);	
	try{
		$xml                                                                  = $webService->get(array('url' => PS_SHOP_PATH.'/api/products?schema=blank'));
		$product                                                              = $xml->children()->children();
		
		$product->price                                                       = $data["price"]; //Prix TTC
		$product->wholesale_price                                             =$data["price"]; //Prix d'achat
		$product->active                                                      = '1';
		$product->on_sale                                                     = 1; //on ne veux pas de bandeau promo
		$product->show_price                                                  = 1;
		$product->available_for_order                                         = 1;
		$product->state 													  = 1;
		$product->name->language[0][0]                                        = $data["name"];
		$product->name->language[0][0]['id']                                  = 1;
		
		$product->description->language[0][0]                                 = $data["description"];
		$product->description->language[0][0]['id']                           = 1;
		
		$product->description_short->language[0][0]                           = $data["description"];
		$product->description_short->language[0][0]['id']                     = 1;
		$product->reference                                                   = $data["code"];
		
		$product->associations->categories->addChild('category')->addChild('id', $data["category_id"]);
		$product->id_category_default                                         = $data["category_id"];
		
		//$product->associations->stock_availables->stock_available->quantity = 1222;
		
		$opt                                                                  = array('resource' => 'products');
		$opt['postXml']                                                       = $xml->asXML();
		sleep(1);
		$xml                                                                  = $webService->add($opt); 
		
		$product                                                              = $xml->product;
	} catch (PrestaShopWebserviceException $e){
		return;
	}
	//insert stock
	set_product_quantity($data["quantity"], $product->id, $product->associations->stock_availables->stock_available->id, $product->associations->stock_availables->stock_available->id_product_attribute);
	return $product->id;
}
/**
* Actualizar stock usando WS
*/

function set_product_quantity($quantity, $ProductId, $StokId, $AttributeId){
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);	
	try {
		$opt                             = array();
		$opt['resource']                 = "stock_availables";
		$opt['filter']                   = array('id_product' => $ProductId, "id_product_attribute" => $AttributeId);
		$xml                             = $webService->get($opt);
		$resources                       = $xml->children()->children()[0];
		$StokId                          = (int) $resources['id'][0];
		
		$xml                             = $webService->get(array('url' => PS_SHOP_PATH.'/api/stock_availables?schema=blank'));
		$resources                       = $xml -> children() -> children();
		$resources->id                   = $StokId;
		$resources->id_product           = $ProductId;
		$resources->quantity             = $quantity;
		$resources->id_shop              = 1;
		$resources->out_of_stock         =0;
		$resources->depends_on_stock     = 0;
		$resources->id_product_attribute =$AttributeId;
		
		$opt                             = array('resource' => 'stock_availables');
		$opt['putXml']                   = $xml->asXML();
		$opt['id']                       = $StokId;
		$xml                             = $webService->edit($opt);
	} catch (PrestaShopWebserviceException $ex) {
	}
}

//creando producto
/* $data = array('price'=>'3300.000','name'=>'prueba prueba','description'=>'descripcion','code'=>'ref01','category_id'=>'','category_id'=>'','quantity'=>20);
make_product($data);
 */
 
 
//creando valor de variante
/* $data = array('id_attribute_group'=>'2','name'=>'prueba atributo');
echo make_product_options($data); */

//creando combinacion
$data = array('option_id'=>'13','id_product'=>3,'code'=>'nuevo atributo','price'=>'3300.000','quantity'=>'15','id_default_image'=>'2');
$res = add_combination($data);
var_dump($res);