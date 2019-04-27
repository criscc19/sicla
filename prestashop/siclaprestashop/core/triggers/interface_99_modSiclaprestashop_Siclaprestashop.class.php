<?php
/* Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    core/triggers/interface_99_modMyModule_MyModuleTriggers.class.php
 * \ingroup mymodule
 * \brief   Example trigger.
 *
 * Put detailed description here.
 *
 * \remarks You can create other triggers by copying this one.
 * - File name should be either:
 *      - interface_99_modMyModule_MyTrigger.class.php
 *      - interface_99_all_MyTrigger.class.php
 * - The file must stay in core/triggers
 * - The class name must be InterfaceMytrigger
 * - The constructor method must be named InterfaceMytrigger
 * - The name property name must be MyTrigger
 */

require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';


/**
 *  Class of triggers for MyModule module
 */
class InterfaceSiclaprestashop extends DolibarrTriggers
{
	/**
	 * @var DoliDB Database handler
	 */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;

		$this->name = preg_replace('/^Interface/i', '', get_class($this));
		$this->family = "demo";
		$this->description = "MyModule triggers.";
		// 'development', 'experimental', 'dolibarr' or version
		$this->version = 'development';
		$this->picto = 'mymodule@mymodule';
		
	}

	/**
	 * Trigger name
	 *
	 * @return string Name of trigger file
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Trigger description
	 *
	 * @return string Description of trigger file
	 */
	public function getDesc()
	{
		return $this->description;
	}


	/**
	 * Function called when a Dolibarrr business event is done.
	 * All functions "runTrigger" are triggered if file
	 * is inside directory core/triggers
	 *
	 * @param string 		$action 	Event action code
	 * @param CommonObject 	$object 	Object
	 * @param User 			$user 		Object user
	 * @param Translate 	$langs 		Object langs
	 * @param Conf 			$conf 		Object conf
	 * @return int              		<0 if KO, 0 if no triggered ran, >0 if OK
	 */
	public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
	{

	    // Put here code you want to execute when a Dolibarr business events occurs.
		// Data and type of action are stored into $object and $action


            // Users
		    //case 'USER_CREATE':
		    //case 'USER_MODIFY':
		    //case 'USER_NEW_PASSWORD':
		    //case 'USER_ENABLEDISABLE':
		    //case 'USER_DELETE':
		    //case 'USER_SETINGROUP':
		    //case 'USER_REMOVEFROMGROUP':

		    // Actions
		    //case 'ACTION_MODIFY':
		    //case 'ACTION_CREATE':
		    //case 'ACTION_DELETE':

		    // Groups
		    //case 'GROUP_CREATE':
		    //case 'GROUP_MODIFY':
		    //case 'GROUP_DELETE':

		    // Companies
		    //case 'COMPANY_CREATE':
		    //case 'COMPANY_MODIFY':
		    //case 'COMPANY_DELETE':

		    // Contacts
		    //case 'CONTACT_CREATE':
		    //case 'CONTACT_MODIFY':
		    //case 'CONTACT_DELETE':
		    //case 'CONTACT_ENABLEDISABLE':

		    // Products
		    //case 'PRODUCT_CREATE':
		    //case 'PRODUCT_MODIFY':
		    //case 'PRODUCT_DELETE':
		    //case 'PRODUCT_PRICE_MODIFY':
		    //case 'PRODUCT_SET_MULTILANGS':
		    //case 'PRODUCT_DEL_MULTILANGS':

		    //Stock mouvement
		    //case 'STOCK_MOVEMENT':

		    //MYECMDIR
		    //case 'MYECMDIR_CREATE':
		    //case 'MYECMDIR_MODIFY':
		    //case 'MYECMDIR_DELETE':

		    // Customer orders
		    //case 'ORDER_CREATE':
		    //case 'ORDER_MODIFY':
		    //case 'ORDER_VALIDATE':
		    //case 'ORDER_DELETE':
		    //case 'ORDER_CANCEL':
		    //case 'ORDER_SENTBYMAIL':
		    //case 'ORDER_CLASSIFY_BILLED':
		    //case 'ORDER_SETDRAFT':
		    //case 'LINEORDER_INSERT':
		    //case 'LINEORDER_UPDATE':
		    //case 'LINEORDER_DELETE':

		    // Supplier orders
		    //case 'ORDER_SUPPLIER_CREATE':
		    //case 'ORDER_SUPPLIER_MODIFY':
		    //case 'ORDER_SUPPLIER_VALIDATE':
		    //case 'ORDER_SUPPLIER_DELETE':
		    //case 'ORDER_SUPPLIER_APPROVE':
		    //case 'ORDER_SUPPLIER_REFUSE':
		    //case 'ORDER_SUPPLIER_CANCEL':
		    //case 'ORDER_SUPPLIER_SENTBYMAIL':
		    //case 'ORDER_SUPPLIER_DISPATCH':
		    //case 'LINEORDER_SUPPLIER_DISPATCH':
		    //case 'LINEORDER_SUPPLIER_CREATE':
		    //case 'LINEORDER_SUPPLIER_UPDATE':
		    //case 'LINEORDER_SUPPLIER_DELETE':

		    // Proposals
		    //case 'PROPAL_CREATE':
		    //case 'PROPAL_MODIFY':
		    //case 'PROPAL_VALIDATE':
		    //case 'PROPAL_SENTBYMAIL':
		    //case 'PROPAL_CLOSE_SIGNED':
		    //case 'PROPAL_CLOSE_REFUSED':
		    //case 'PROPAL_DELETE':
		    //case 'LINEPROPAL_INSERT':
		    //case 'LINEPROPAL_UPDATE':
		    //case 'LINEPROPAL_DELETE':

		    // SupplierProposal
		    //case 'SUPPLIER_PROPOSAL_CREATE':
		    //case 'SUPPLIER_PROPOSAL_MODIFY':
		    //case 'SUPPLIER_PROPOSAL_VALIDATE':
		    //case 'SUPPLIER_PROPOSAL_SENTBYMAIL':
		    //case 'SUPPLIER_PROPOSAL_CLOSE_SIGNED':
		    //case 'SUPPLIER_PROPOSAL_CLOSE_REFUSED':
		    //case 'SUPPLIER_PROPOSAL_DELETE':
		    //case 'LINESUPPLIER_PROPOSAL_INSERT':
		    //case 'LINESUPPLIER_PROPOSAL_UPDATE':
		    //case 'LINESUPPLIER_PROPOSAL_DELETE':

		    // Contracts
		    //case 'CONTRACT_CREATE':
		    //case 'CONTRACT_MODIFY':
		    //case 'CONTRACT_ACTIVATE':
		    //case 'CONTRACT_CANCEL':
		    //case 'CONTRACT_CLOSE':
		    //case 'CONTRACT_DELETE':
		    //case 'LINECONTRACT_INSERT':
		    //case 'LINECONTRACT_UPDATE':
		    //case 'LINECONTRACT_DELETE':

		    // Bills
		    //case 'BILL_CREATE':
		    //case 'BILL_MODIFY':
		    //case 'BILL_VALIDATE':
		    //case 'BILL_UNVALIDATE':
		    //case 'BILL_SENTBYMAIL':
		    //case 'BILL_CANCEL':
		    //case 'BILL_DELETE':
		    //case 'BILL_PAYED':
		    //case 'LINEBILL_INSERT':
		    //case 'LINEBILL_UPDATE':
		    //case 'LINEBILL_DELETE':

		    //Supplier Bill
		    //case 'BILL_SUPPLIER_CREATE':
		    //case 'BILL_SUPPLIER_UPDATE':
		    //case 'BILL_SUPPLIER_DELETE':
		    //case 'BILL_SUPPLIER_PAYED':
		    //case 'BILL_SUPPLIER_UNPAYED':
		    //case 'BILL_SUPPLIER_VALIDATE':
		    //case 'BILL_SUPPLIER_UNVALIDATE':
		    //case 'LINEBILL_SUPPLIER_CREATE':
		    //case 'LINEBILL_SUPPLIER_UPDATE':
		    //case 'LINEBILL_SUPPLIER_DELETE':

		    // Payments
		    //case 'PAYMENT_CUSTOMER_CREATE':
		    //case 'PAYMENT_SUPPLIER_CREATE':
		    //case 'PAYMENT_ADD_TO_BANK':
		    //case 'PAYMENT_DELETE':

		    // Online
		    //case 'PAYMENT_PAYBOX_OK':
		    //case 'PAYMENT_PAYPAL_OK':
		    //case 'PAYMENT_STRIPE_OK':

		    // Donation
		    //case 'DON_CREATE':
		    //case 'DON_UPDATE':
		    //case 'DON_DELETE':

		    // Interventions
		    //case 'FICHINTER_CREATE':
		    //case 'FICHINTER_MODIFY':
		    //case 'FICHINTER_VALIDATE':
		    //case 'FICHINTER_DELETE':
		    //case 'LINEFICHINTER_CREATE':
		    //case 'LINEFICHINTER_UPDATE':
		    //case 'LINEFICHINTER_DELETE':

		    // Members
		    //case 'MEMBER_CREATE':
		    //case 'MEMBER_VALIDATE':
		    //case 'MEMBER_SUBSCRIPTION':
		    //case 'MEMBER_MODIFY':
		    //case 'MEMBER_NEW_PASSWORD':
		    //case 'MEMBER_RESILIATE':
		    //case 'MEMBER_DELETE':

		    // Categories
		    //case 'CATEGORY_CREATE':
		    //case 'CATEGORY_MODIFY':
		    //case 'CATEGORY_DELETE':
		    //case 'CATEGORY_SET_MULTILANGS':

		    // Projects
		    //case 'PROJECT_CREATE':
		    //case 'PROJECT_MODIFY':
		    //case 'PROJECT_DELETE':

		    // Project tasks
		    //case 'TASK_CREATE':
		    //case 'TASK_MODIFY':
		    //case 'TASK_DELETE':

		    // Task time spent
		    //case 'TASK_TIMESPENT_CREATE':
		    //case 'TASK_TIMESPENT_MODIFY':
		    //case 'TASK_TIMESPENT_DELETE':

		    // Shipping
		    //case 'SHIPPING_CREATE':
		    //case 'SHIPPING_MODIFY':
		    //case 'SHIPPING_VALIDATE':
		    //case 'SHIPPING_SENTBYMAIL':
		    //case 'SHIPPING_BILLED':
		    //case 'SHIPPING_CLOSED':
		    //case 'SHIPPING_REOPEN':
			//case 'SHIPPING_DELETE':
			//	break;
		if($action == 'PRODUCT_CREATE'){
	    global $conf, $db, $mysoc;
		require_once DOL_DOCUMENT_ROOT.'/siclaprestashop/funcion.php';		
        if(!isset($_POST['attribute'])){
        $prod = new Product($db);
        $prod->fetch($object->id);       
		$sq1 = $db->query('SELECT c.label  FROM llx_categorie_product cp
		JOIN llx_categorie c ON cp.fk_categorie=c.rowid
		WHERE `fk_product` = '.$prod->id.'');
		$cat_label = $db->fetch_object($sq1)->label;
		$id_cat = getCategorie(trim($cat_label));

		$data = array(
		'price'=> $prod->multiprices[1],
		'name'=> $prod->label,
		'description'=>$prod->description,
		'reference'=> $prod->ref,
		'category_id'=> $cat_id,
		'id_category_default'=>$cat_id,
		'quantity'=>0
		);
			make_product($data); 
		   }
	      
        if(isset($_POST['attribute'])){
			 
		//creando combianciones 
/*         $vari = $db->query('SELECT * FROM `llx_product_attribute_value`');
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
	
		}  */
		//fin de crear variantes	
		
		//creando combinacion producto
/*         $bs2 = 'SELECT COUNT(pi.id) variantes,p.ref fk_parent,pi.id_img_hijo FROM llx__prestashop_img pi 
				JOIN llx_product p ON p.ref = pi.padre
				WHERE pi.hijo = "'.trim($object->ref).'"'; 
		for ($p = 1; $p <= $db->num_rows($hijo); $p++) {
        $com = $db->fetch_object($hijo);
		$padre = fk_parent;
		}*/

		$prod = new product($db);
		$prod->fetch($_POST['id']);
		$features = $_SESSION['addvariant_'.$prod->id];
		
		
		
	    
		foreach ($features as $feature) {
		$explode = explode(':', $feature);
		$fk_prod_attr = $explode[0];
		$fk_prod_attr_val = $explode[1];			
		}


		$com = $db->query('SELECT ps.presta_id,ps.valor FROM llx_prestashop_combination ps WHERE ps.sicla_id='.$fk_prod_attr_val.'');
		for ($s = 1; $s <= $db->num_rows($com); $s++) {
        $bjs = $db->fetch_object($com);
		$id_variante_val = $bjs->presta_id;
		$prodattrval = $bjs->valor;
		}
		
		$fk_parent = getProduct($prod->ref);
		$newproduct = $prod->ref;
		
		if (isset($conf->global->PRODUIT_ATTRIBUTES_SEPARATOR)) {
		$newproduct .= $conf->global->PRODUIT_ATTRIBUTES_SEPARATOR . $prod->ref;
		} else {
		$newproduct .= '_'.$prodattrval;
		}
		
		$data = array(
		'option_id'=>$id_variante_val,
		'id_product'=>$fk_parent,
		'price'=>'0',
		'quantity'=>'0',
		'id_default_image'=>'0',
		'reference'=>$newproduct
		);		
		$res = add_combination($data);

		   }		   

         }	

		
		if($action == 'PRODUCT_PRICE_MODIFY' || $action == 'PRODUCT_MODIFY' || $action == 'CATEGORY_MODIFY'){
		global $conf, $db, $mysoc;
		require_once DOL_DOCUMENT_ROOT.'/siclaprestashop/funcion.php';

        //obteniendo categorias 
		$sq1 = $db->query('SELECT c.label,c2.label as label2  FROM llx_categorie_product cp
		JOIN llx_categorie c ON cp.fk_categorie=c.rowid
        JOIN llx_categorie c2 ON cp.fk_categorie=c2.rowid=0 AND c2.fk_parent=0
		WHERE `fk_product` = '.$object->id.'');
		for ($p = 1; $p <= $db->num_rows($sq1); $p++) {
        $bje = $db->fetch_object($sq1);
		$cat_label = $bje->label;
		$bodega = $bje->label2;
		}

		//obteniendo categorias 
		$id_cat = getCategorie(trim($cat_label));
		
		
		$sq12 = $db->query('SELECT ps.reel FROM llx_product_stock ps
		JOIN llx_entrepot e ON ps.fk_entrepot=e.rowid
		WHERE fk_product = '.$object->id.' AND e.ref LIKE "%'.$bodega.'%"');

		for ($p2 = 1; $p2 <= $db->num_rows($sq12); $p2++) {
        $bje2 = $db->fetch_object($sq12);
		$stock = $bje2->reel;
		}
		// stock segun categoria padre y bodega
		
 
		$data = array(
		'price'=> $object->multiprices[1],
		'name'=> $object->label,
		'description'=>$object->description,
		'reference'=>$object->ref,
		'category_id'=> $id_cat,
		'id_category_default'=>$id_cat,
		'stock'=>$stock);
		
		$id = getProduct(trim($object->label));
		$stok_id = productUpdate($id,$data);
		set_product_quantity($stock, $id, $stok_id, 0);
		
		}
		
		if($action == 'PRODUCT_DELETE'){

		}
		
		
}


	
	
}
