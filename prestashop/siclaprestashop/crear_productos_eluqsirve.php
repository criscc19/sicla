<html><head><title>CRUD Tutorial - Create example</title></head><body>
<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
* PrestaShop Webservice Library
* @package PrestaShopWebservice
*/

// Here we define constants /!\ You need to replace this parameters
define('DEBUG', true);
define('PS_SHOP_PATH', 'http://localhost/prestashop');
define('PS_WS_AUTH_KEY', 'UYMRWW17167Q92NP39IK575IJJDE38F7');
require_once('class/PSWebServiceLibrary.php');
$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);

$opt = array('resource' => 'products');

$xml = $webService->get(array('url' => PS_SHOP_PATH.'/api/products?schema=synopsis'));

$resources = $xml->children()->children();

 

unset($resources->position_in_category);

unset($resources->manufacturer_name);
unset($resources->quantity);
 

$resources->price = '2500.000';

$resources->active = '1';

//$resources->quantity = '50';

$resources->link_rewrite = 'blabla';

$resources->id = '4';

$resources->name->language[0][0] = 'blabla';

$resources->description->language[0][0] = '<p>blabla</p>';

$resources->description_short->language[0][0] = 'blabla';
$resources->state = '1';
$resources->associations = '';
$resources->reference = 'oiuouo';
 

$opt = array('resource' => 'products');

$opt['postXml'] = $xml->asXML();

$xml = $webService->add($opt);


?>
</body></html>
