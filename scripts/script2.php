﻿<?php
consulta seguimiento de pedidos
SELECT c.rowid,c.ref,ee.fk_target,f.facnumber factura,c.fk_comercial1,c.fk_comercial2,c.fk_comercial3, u1.login vendedor,u2.login telemercadista,u3.login ejecutivo FROM llx_commande c
JOIN llx_element_element ee ON ee.fk_source=c.rowid AND ee.sourcetype='commande' AND ee.targettype='facture'
LEFT JOIN llx_facture f ON ee.fk_target=f.rowid
LEFT JOIN llx_user u1 ON c.fk_comercial1=u1.rowid
LEFT JOIN llx_user u2 ON c.fk_comercial2=u2.rowid
LEFT JOIN llx_user u3 ON c.fk_comercial3=u3.rowid


actualizar campos desde un join
UPDATE llx_facture f 
JOIN llx_element_element ee ON
ee.fk_target=f.rowid AND ee.sourcetype='commande' AND ee.targettype='facture'
JOIN llx_commande c ON ee.fk_source=c.rowid
SET f.fk_comercial1=c.fk_comercial1, f.fk_comercial2=c.fk_comercial2,f.fk_comercial3=c.fk_comercial3,f.encomienda=c.encomienda







SELECT c.rowid,c.ref,ee.fk_target,f.facnumber factura,c.fk_comercial1,c.fk_comercial2,c.fk_comercial3, u1.login vendedor,u2.login telemercadista,u3.login ejecutivo,
(SELECT SUM(ff.total) FROM llx_facture ff WHERE ff.rowid=f.rowid ) venta
FROM llx_commande c
JOIN llx_element_element ee ON ee.fk_source=c.rowid AND ee.sourcetype="commande" AND ee.targettype="facture"
LEFT JOIN llx_facture f ON ee.fk_target=f.rowid
LEFT JOIN llx_user u1 ON c.fk_comercial1=u1.rowid
LEFT JOIN llx_user u2 ON c.fk_comercial2=u2.rowid
LEFT JOIN llx_user u3 ON c.fk_comercial3=u3.rowid 





actualizacion por categoria
UPDATE llx_product p JOIN llx_categorie_product c ON c.fk_product=p.rowid SET p.descuento=10 WHERE c.fk_categorie=24

seleccion de categoria
SELECT p.label,c.fk_categorie FROM llx_product p JOIN llx_categorie_product c ON c.fk_product=p.rowid WHERE c.fk_categorie=55


ALTER TABLE llx_facture  
ADD `encomienda` INT(5) NOT NULL, 
ADD `fk_comercial1` INT(5) NOT NULL, 
ADD `fk_comercial2` INT(5) NOT NULL, 
ADD `fk_comercial3` INT(5) NOT NULL, 
ADD `alistado` INT(5) NOT NULL;

ALTER TABLE llx_societe  
ADD `provincia` INT(2) NOT NULL, 
ADD `canton` INT(2) NOT NULL, 
ADD `distrito` INT(2) NOT NULL, 
ADD `barrio` INT(2) NOT NULL


 
ALTER TABLE llx_commande  
ADD `fk_statut2` smallint(6) NOT NULL DEFAULT '0',
ADD `alistado` int(11) NOT NULL DEFAULT '0',


DROP TABLE IF EXISTS `llx_zonas_clientes`;


ENCOTRAR HIJOS DE UN TR
$(this).parents("tr").find(".total_ttc_s").text(numeral(total_ttc).format("0,0.00"));
$(this).parents("tr").find(".total_ttc_s");
$form->select_date(
//sumando total precio iva
$(".total_ttc").each(function(){
	preciottc_sum+=parseFloat($(this).val()) || 0;
});

CERRAR VENTANA DIALOG Y ABRIR VENTANA DIALOG
$( "#info").dialog("open");

//CORRECCION DE STOCK
	        $origin_element = '';
			$origin_id = null;	

                $object = new Product($db);
				$result=$object->fetch($id);

		        $result=$object->correct_stock(
		    		$user,
		    		GETPOST("id_entrepot"),
		    		GETPOST("nbpiece"),
		    		GETPOST("mouvement"),
		    		GETPOST("label"),
		    		$priceunit,
					GETPOST('inventorycode'),
					$origin_element,
					$origin_id
				);	
				
TRANSFERENCIA DE STOCK
else
			{
				if (! $error)
				{
    			    // Remove stock
    				$result1=$object->correct_stock(
    					$user,
    					GETPOST("id_entrepot"),
    					GETPOST("nbpiece"),
    					1,
    					GETPOST("label"),
    					$pricesrc,
    					GETPOST('inventorycode')
    				);
    				if ($result1 < 0) $error++;
				}
				if (! $error)
				{
    				// Add stock
    				$result2=$object->correct_stock(
    					$user,
    					GETPOST("id_entrepot_destination"),
    					GETPOST("nbpiece"),
    					0,
    					GETPOST("label"),
    					$pricedest,
    					GETPOST('inventorycode')
    				);
    				if ($result2 < 0) $error++;
	
				}
	
dol_print_date($db->jdate($obn->datef);
dol_print_date($db->jdate($obj->df),'day');	
dol_print_date($db->jdate($obn->datef), 'day', 'tzuser')	



$arrayofjs=array('/includes/jquery/plugins/jquerytreeview/jquery.treeview.js', '/includes/jquery/plugins/jquerytreeview/lib/jquery.cookie.js');
$arrayofcss=array('/includes/jquery/plugins/jquerytreeview/jquery.treeview.css');

llxHeader('',$title,'','',0,0,$arrayofjs,$arrayofcss);

consulta para mostrar registros repetidos
SELECT * FROM llx_product_extrafields WHERE fk_object IN (SELECT fk_object FROM llx_product_extrafields GROUP BY fk_object HAVING count(fk_object) > 1) ORDER BY fk_object

consulta para un isert de una tabla a otra
INSERT INTO `erp_cajas2018`.`llx_product_fournisseur_price`(`rowid`, `entity`) 
SELECT `rowid`, `entity` FROM `erp_cuniverso17`.`llx_product_fournisseur_price`


/**
 * comnsulta para hacer un insert update de una tabla a otra
 */
INSERT INTO llx_societe_extrafields (provincia,canton,distrito,barrio) 
SELECT provincia,canton,distrito,barrio FROM llx_societe ON DUPLICATE KEY UPDATE
llx_societe_extrafields.provincia = llx_societe.provincia,
llx_societe_extrafields.canton = llx_societe.canton,
llx_societe_extrafields.distrito = llx_societe.distrito,
llx_societe_extrafields.barrio = llx_societe.barrio
/**
 * comnsulta para hacer un insert update de una tabla a otra
 */




INSERT INTO ps_image_shop (id_product, id_image,id_shop,cover) 
SELECT ps.id_product,pi.id_img_padre,'1','1' FROM llx__prestashop_img pi
JOIN ps_product ps ON pi.padre like ps.reference

consulta para un isert de una tabla a otra
INSERT INTO llx_facture_extrafields (fk_object,vendedor) 
SELECT rowid,fk_user_author  FROM llx_facture

actualizar de una tabla a otra
UPDATE `llx_product_stock` SET `reel` = '0' WHERE `llx_product_stock`.`fk_entrepot` =9

/**
actualizar desde un join

*/
UPDATE llx_product_stock ps
JOIN llx_product p ON ps.fk_product=p.rowid AND ps.fk_entrepot=1
LEFT JOIN llx_nginventory_line nl ON nl.fk_product=p.rowid
SET ps.reel = 0
WHERE nl.qty IS NULL
/**
fin actualizar desde un join

*/


5061	Persona Jurídica
5062	Persona Física		
5063	DIMEX	
5064	NITE

SELECT * FROM `llx_c_forme_juridique` WHERE `fk_pays` = 75;

INSERT INTO `llx_c_forme_juridique` (`rowid`, `code`, `fk_pays`, `libelle`, `isvatexempted`, `active`, `module`, `position`) VALUES
(238, 5061, 75, 'Persona Jurídica', 0, 1, NULL, 0),
(239, 5062, 75, 'Persona Física', 0, 1, NULL, 0),
(240, 5063, 75, 'DIMEX', 0, 1, NULL, 0),
(241, 5064, 75, 'NITE', 0, 1, NULL, 0);

LTER TABLE `llx_commande_fournisseurdet` ADD `accountancy_code_sell` VARCHAR(50) NULL AFTER `valor_consumo`;


UPDATE `llx_societe` SET `fk_forme_juridique` = '5061' WHERE `llx_societe`.`fk_forme_juridique` = 2221;
UPDATE `llx_societe` SET `fk_forme_juridique` = '5062' WHERE `llx_societe`.`fk_forme_juridique` = 2224;
UPDATE `llx_societe` SET `fk_forme_juridique` = '5063' WHERE `llx_societe`.`fk_forme_juridique` = 2225;
UPDATE `llx_societe` SET `fk_forme_juridique` = '5064' WHERE `llx_societe`.`fk_forme_juridique` = 2223;

ALTER TABLE llx_productos_adicionales
ADD `tipo_material` INT(5) NOT NULL, 


$('#multicurrency_code').val('USD').trigger('change');

$ret = $object->printObjectLines($action, $societe, $mysoc, $lineid, 1);


utilidad de dos cantidades
1 - cantidad mayor - cantidad menor
2 - resultado / cantidad menor
3 - resultado * 100

// Date invoice
$('#row-14292').append('<td>probando</td>');
$('.liste_titre').append('<td>probando</td>');
$('#tablelines').find(".oddeven");

$('.liste_titre').append('<td>probando</td>');
$('#tablelines').find(".oddeven").each(function(){
idtr = $(this).attr('id');
$(idtr).append("<td><input type="checkbox" value="+idtr.split('-')[1]+"><td>")	
console.log(idtr.split('-')[1]);
})


//funciones para eliminar lineas multiples
Prepare tableDnd for #tablelines
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
alert(getUrlParameter('facid'));

cadena1.split('_')[1];


$('.liste_titre').append('<td>probando</td>');
$('#tablelines').find(".oddeven").each(function(){
idtr = $(this).attr('id');
id = idtr.split('-')[1];
$("#"+idtr).append('<td><input type="checkbox" value='+id+'></td>')	
})



$("#idwarehouse").select2().val("1").trigger("change");
$("#modelmailselected").val("3").change()

SELECT f.rowid,f.facnumber,f.datef,s.nom, SUM(fd.total_ht) subtotal,(fd.total_ht * p.comision / 100) total_comision,COUNT(fd.rowid)lineas,SUM(p.comision) total_comision,(SUM(p.comision) / COUNT(fd.rowid)) promedio,p.comision,p.comision_extra,f.datef,DATEDIFF(f.datef, '2018-10-16') dias,u.firstname,u.lastname FROM llx_facturedet fd
JOIN llx_facture f ON fd.fk_facture=f.rowid
JOIN llx_user u ON f.fk_comercial1=u.rowid
JOIN llx_product p ON fd.fk_product = p.rowid
JOIN llx_societe s ON f.fk_soc=s.rowid
WHERE s.rowid=677 AND u.rowid=28
GROUP BY f.rowid



SELECT f.rowid,f.facnumber,f.datef,s.nom, SUM(fd.total_ht) subtotal,(fd.total_ht * p.comision / 100) total_comision,COUNT(fd.rowid)lineas,SUM(p.comision) total_comision,(SUM(p.comision) / COUNT(fd.rowid)) promedio,p.comision,p.comision_extra,f.datef,DATEDIFF( '2018-09-01', '2018-09-30') dias,u.firstname,u.lastname FROM llx_facturedet fd
JOIN llx_facture f ON fd.fk_facture=f.rowid
JOIN llx_user u ON f.fk_comercial1=u.rowid
JOIN llx_product p ON fd.fk_product = p.rowid
JOIN llx_societe s ON f.fk_soc=s.rowid
WHERE u.rowid=27 AND f.paye=1
GROUP BY f.rowid

<img src="'.DOL_MAIN_URL_ROOT.'/viewimage.php?modulepart=mycompany&file=thumbs/'.$mysoc->logo_small.'" alt="test alt attribute" width="30" height="30" border="0" />
ALTER TABLE `llx_c_type_fees` CHANGE `code` `code` VARCHAR(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

$listofcurrenciesbefore=array('USD','GBP','AUD','MXN');


ALTER TABLE llx_expensereport_det
ADD `fk_soc` INT(11) NULL
// Loop on each lines


//consulta para pasar vendedor de facturas
SELECT f.rowid,f.facnumber,f.total_ttc,f.fk_comercial1,f.fk_comercial2,f.fk_comercial3,sr.fk_facture,ff.facnumber,ff.total_ttc,ff.fk_comercial1,ff.fk_comercial2,ff.fk_comercial3 FROM llx_facture f
JOIN llx_societe_remise_except sr ON f.rowid=sr.fk_facture_source
JOIN llx_facture ff ON sr.fk_facture=ff.rowid
WHERE f.type=2
 ORDER BY f.rowid DESC
 
//consulta para pasar vendedor de facturas 
 UPDATE llx_facture f
JOIN llx_societe_remise_except sr ON f.rowid=sr.fk_facture_source
JOIN llx_facture ff ON sr.fk_facture=ff.rowid
SET ff.fk_comercial1=f.fk_comercial1, ff.fk_comercial2=f.fk_comercial2,ff.fk_comercial3=f.fk_comercial3,ff.encomienda=f.encomienda
WHERE f.type=2

//agregar cliente al los gastos 
ALTER TABLE llx_expensereport_det ADD fk_soc INT(11) NOT NULL 

//agregar cliente al los gastos 
ALTER TABLE llx_societe 
ADD `provincia` int(2) NOT NULL,
ADD  `canton` int(2) NOT NULL,
ADD  `distrito` int(2) NOT NULL,
ADD  `barrio` int(2) NOT NULL


//ACTUALIZAR FECHA DE CANCELACION DE FACTURAS
UPDATE llx_facture_extrafields e
JOIN llx_facture f ON e.fk_object=f.rowid
LEFT JOIN (SELECT pf.fk_facture, MAX(datep) datep FROM llx_paiement_facture pf JOIN llx_paiement p ON pf.fk_paiement=p.rowid  GROUP BY pf.fk_facture) fe ON fe.fk_facture=f.rowid
LEFT JOIN (SELECT rs.fk_facture,MAX(rs.datec) datec FROM llx_societe_remise_except rs GROUP BY rs.fk_facture) fen ON fen.fk_facture=f.rowid
SET e.cancelacion = IF(fe.datep IS NOT NULL AND fe.datep > fen.datec OR fen.datec IS
NULL, fe.datep, fen.datec)
WHERE fk_statut > 0 AND paye=1
	       
//ACTUALIZAR FECHA DE CANCELACION DE FACTURAS
SELECT pr.rowid pr_id,pr.ref,pr.datep,pr.fin_validite,pr.date_cloture,c_p.code,c_p.label,pr.note_private,pr.note_private,pr.total_ht,pr.total,pr.tva,pr.remise_percent,u.rowid u_id,u.login,u.firstname,u.lastname,s.rowid s_id,s.nom,s.name_alias,pr.multicurrency_code,pr.multicurrency_total_ht,pr.multicurrency_total_ttc,pr.multicurrency_tx,pr.multicurrency_total_tva,
(SELECT COUNT(ee.fk_source) FROM llx_element_element ee WHERE ee.sourcetype="propal" AND ee.targettype="facture" AND ee.fk_source=pr.rowid) facturas
FROM llx_propal pr
JOIN llx_c_propalst c_p ON pr.fk_statut=c_p.id
JOIN llx_user u ON u.rowid = pr.fk_user_author
JOIN llx_societe s ON s.rowid=pr.fk_soc  
WHERE pr.fk_statut > 0
//debe existir una llave unica	       
	       
	       

//agrear campos dolares
ALTER TABLE `llx_payment_expensereport`
ADD `multicurrency_code` varchar(255) DEFAULT NULL,
ADD  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
ADD  `multicurrency_amount` double(24,8) DEFAULT '0.00000000'

//BANCO NACIONAL
https://bncrappsmobappprod.azurewebsites.net/api/ConsultaTipoCambios?pCanal=IBP

//bcr
https://www.bancobcr.com/js/tipoCambio/BUS/actual_formato.asp?i=ES

//genberal
http://indicadoreseconomicos.bccr.fi.cr/IndicadoresEconomicos/Cuadros/frmConsultaTCVentanilla.aspx

//comprobar si existe objeto
$existe = Cotizaciones::isExistingObject('product', '', $ref, '');

//forma juridica
INSERT INTO `llx_c_forme_juridique` (`rowid`, `code`, `fk_pays`, `libelle`, `isvatexempted`, `active`, `module`, `position`) VALUES
(238, 5061, 75, 'Persona Jurídica', 0, 1, NULL, 0),
(239, 5062, 75, 'Persona Física', 0, 1, NULL, 0),
(240, 5063, 75, 'DIMEX', 0, 1, NULL, 0),
(241, 5064, 75, 'NITE', 0, 1, NULL, 0);


?display=full&filter[id_product_attribute]=[0]&filter[id_product]=[58]


public function init($options='')
	{
	global $db, $conf;
		$result=$this->_load_tables('/depositos/sql/');
		if ($result < 0) return -1; // Do not activate module if not allowed errors found on module SQL queries (the _load_table run sql with run_sql with error allowed parameter to 'default')

		// Create extrafields
		include_once DOL_DOCUMENT_ROOT.'/core/class/extrafields.class.php';
		$extrafields = new ExtraFields($this->db);
		//campo extra familias 
            $attrname = "familia";
            $label="Familia"; 
            $type="sellist"; 
            $pos=1; 
            $size=''; 
            $elementtype="societe";
            $unique=0; 
            $required=0; 
            $default_value=''; 
            $param=array('options'=>array('familias:apellidos:rowid::rowid'=>NULL)); 
            $alwayseditable=1; 
            $perms=''; 
            $list=3; 
            $ishidden=0; 
            $computed=''; 
            $entity=$conf->entity; 
            $langfile=''; 
            $enabled='1';   
            $extrafields->addExtraField($attrname, $label, $type, $pos, $size, $elementtype, $unique, $required, $default_value, $param, $alwayseditable, $perms, $list, $ishidden, $computed, $entity, $langfile, $enabled);
		//fin campo extra familias
		
		//campo extra grupos 
            $attrname = "grupo";
            $label="Grupo"; 
            $type="sellist"; 
            $pos=1; 
            $size=''; 
            $elementtype="societe";
            $unique=0; 
            $required=0; 
            $default_value=''; 
            $param=array('options'=>array('grupos:nombre:rowid::rowid'=>NULL)); 
            $alwayseditable=1; 
            $perms=''; 
            $list=3; 
            $ishidden=0; 
            $computed=''; 
            $entity=$conf->entity; 
            $langfile=''; 
            $enabled='1';   
            $extrafields->addExtraField($attrname, $label, $type, $pos, $size, $elementtype, $unique, $required, $default_value, $param, $alwayseditable, $perms, $list, $ishidden, $computed, $entity, $langfile, $enabled);
		//fin campo extra grupos	
		
		//campo extra actividad 
            $attrname = "actividad";
            $label="Actividad"; 
            $type="sellist"; 
            $pos=1; 
            $size=''; 
            $elementtype="societe";
            $unique=0; 
            $required=0; 
            $default_value=''; 
            $param=array('options'=>array('actividades:nombre:rowid::rowid'=>NULL)); 
            $alwayseditable=1; 
            $perms=''; 
            $list=3; 
            $ishidden=0; 
            $computed=''; 
            $entity=$conf->entity; 
            $langfile=''; 
            $enabled='1';   
            $extrafields->addExtraField($attrname, $label, $type, $pos, $size, $elementtype, $unique, $required, $default_value, $param, $alwayseditable, $perms, $list, $ishidden, $computed, $entity, $langfile, $enabled);
		//fin campo extra actividad		
		
		//$result1=$extrafields->addExtraField('myattr1', "New Attr 1 label", 'boolean', 1,  3, 'thirdparty',   0, 0, '', '', 1, '', 0, 0, '', '', 'depositos@depositos', '$conf->depositos->enabled');
		//$result2=$extrafields->addExtraField('myattr2', "New Attr 2 label", 'varchar', 1, 10, 'project',      0, 0, '', '', 1, '', 0, 0, '', '', 'depositos@depositos', '$conf->depositos->enabled');
		//$result3=$extrafields->addExtraField('myattr3', "New Attr 3 label", 'varchar', 1, 10, 'bank_account', 0, 0, '', '', 1, '', 0, 0, '', '', 'depositos@depositos', '$conf->depositos->enabled');
		//$result4=$extrafields->addExtraField('myattr4', "New Attr 4 label", 'select',  1,  3, 'thirdparty',   0, 1, '', array('options'=>array('code1'=>'Val1','code2'=>'Val2','code3'=>'Val3')), 1 '', 0, 0, '', '', 'depositos@depositos', '$conf->depositos->enabled');
		//$result5=$extrafields->addExtraField('myattr5', "New Attr 5 label", 'text',    1, 10, 'user',         0, 0, '', '', 1, '', 0, 0, '', '', 'depositos@depositos', '$conf->depositos->enabled');

		$sql = array();

		return $this->_init($sql, $options);
	}
	       
UPDATE ps_product SET reference = REPLACE(reference, '_', '')
