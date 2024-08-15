<?php
//CONECCIN DE ARCHIVO CONFIG
$listadatos = datosConexion();
foreach ($listadatos as $key => $value) {
    $host        = $value['server'];
    $user_db     = $value['user'];
    $password_db = $value['password'];
    $bd          = $value['database'];
}

$sql_details = array(
    'user' => $user_db,
    'pass' => $password_db,
    'db'   => $bd,
    'host' => $host,
);

// TABLA DE BASE DE DATOS
$table = <<<EOT
(
   SELECT `id`, `idcliente`, `lbl`, `requerido` FROM `clientes_formulario_tarea` WHERE idcliente=$clienteID
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id',        'dt' => 0 ),
    array( 'db' => 'idcliente', 'dt' => 1 ),
    array( 'db' => 'lbl',       'dt' => 2 ),
    array( 'db' => 'requerido', 'dt' => 3 ),
    array( 'db' => 'id',        'dt' => 4)
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);