DELETE FROM `llx_product_price` WHERE 1;
ALTER TABLE `llx_product` auto_increment = 1;
DELETE FROM `llx_product_stock` WHERE 1;
ALTER TABLE `llx_product_stock` auto_increment = 1;
DELETE FROM `llx_product_attribute_value` WHERE 1;
ALTER TABLE `llx_product_attribute_value` auto_increment = 1;
DELETE FROM `llx_categorie_product` WHERE 1;
ALTER TABLE `llx_categorie_product` auto_increment = 1;
DELETE FROM `llx_stock_mouvement` WHERE 1;
ALTER TABLE `llx_stock_mouvement` auto_increment = 1;
DELETE FROM `llx_product` WHERE 1;
ALTER TABLE `llx_product` auto_increment = 1;
DELETE FROM llx_product_attribute_combination2val WHERE 1;
ALTER TABLE llx_product_attribute_combination2val auto_increment = 1;
DELETE FROM `llx_product_attribute_combination` WHERE 1;
ALTER TABLE llx_product_attribute_combination auto_increment = 1;





DELETE FROM `ps_attribute_shop`
ALTER TABLE `ps_attribute_shop` auto_increment = 1;
DELETE FROM `ps_product_attribute`;
ALTER TABLE `ps_product_attribute` auto_increment = 1;
DELETE FROM `ps_image`;
DELETE FROM `ps_image_lang;
DELETE FROM `ps_image_shop;
