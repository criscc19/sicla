<?php 
require '../main.inc.php';

$arrayofcss=array(
'/css/main.css',
'plugins/css/bootstrap.css'
);
$arrayofjs=array(
'/pos/frontend/plugins/js/bootstrap.js'
);

llxHeader('',$langs->trans("Nuevo pack"),'','',0,0,$arrayofjs,$arrayofcss);

 
llxFooter();

$db->close();
?>