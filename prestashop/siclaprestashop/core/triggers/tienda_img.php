<?php
set_time_limit(-1);
ini_set('memory_limit', '-1');
require '../main.inc.php';
$sq = 'SELECT * FROM llx__prestashop_img';
$db->query($sq);
for ($e = 1; $e <= $db->num_rows($sql); $e++) {
$obc = $db->fetch_object($sql);
$colores[$obc->padre][]= array('ref'=>$obc->hijo,'valor'=>$obc->valor,'codigo'=>$obc->codigo);
} 

print '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
$e=1;
foreach($colores as $k=>$v){
    echo $e.' - '.$v['valor'].' :<input type="text" value="" name='.$v['valor'].'"><br><br>';
	$e++;
}

print '<center><input type="submit" value="Guardar"></center>';
print '</form>';


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