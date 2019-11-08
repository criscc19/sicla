<?php
//ejemplo obteniedo producto
$curl = curl_init();
$httpheader = ['DOLAPIKEY: sg2nxwm3'];
$url = 'https://revo.erp.cr/api/index.php/products/1094';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($curl,CURLOPT_HTTPHEADER,$httpheader);
curl_setopt($curl, CURLOPT_GSSAPI_DELEGATION, CURLGSSAPI_DELEGATION_FLAG);    

$result = curl_exec($curl);
curl_close($curl);
var_dump(json_decode($result));exit;
?>


<?php
	
//ejemplo creando producto


$curl = curl_init();
$httpheader = ['DOLAPIKEY: sg2nxwm3'];
$url = 'https://revo.erp.cr/api/index.php/products';
$data = array();
$data['ref'] = 'test';
$data['label'] = 'prueba';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($curl,CURLOPT_HTTPHEADER,$httpheader);
curl_setopt($curl, CURLOPT_GSSAPI_DELEGATION, CURLGSSAPI_DELEGATION_FLAG);
curl_setopt($curl, CURLOPT_POST,1); 
curl_setopt($curl, CURLOPT_POSTFIELDS,$data); 
$result = curl_exec($curl);
curl_close($curl);
var_dump(json_decode($result));exit;
?>