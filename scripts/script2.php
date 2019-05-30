<?php
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




INSERT INTO ps_image_shop (id_product, id_image,id_shop,cover) 
SELECT ps.id_product,pi.id_img_padre,'1','1' FROM llx__prestashop_img pi
JOIN ps_product ps ON pi.padre like ps.reference



consulta para un isert de una tabla a otra
INSERT INTO llx_facture_extrafields (fk_object,vendedor) 
SELECT rowid,fk_user_author  FROM llx_facture

actualizar de una tabla a otra
UPDATE `llx_product_stock` SET `reel` = '0' WHERE `llx_product_stock`.`fk_entrepot` =9

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