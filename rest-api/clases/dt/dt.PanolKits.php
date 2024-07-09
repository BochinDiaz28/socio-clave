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
    SELECT a.id,b.codigo,b.producto, a.cantidad
    FROM panol_kits a, panol b
    WHERE a.productoID =b.id
    AND a.panolID=$panolID 
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt'       => 0 ),
    array( 'db' => 'codigo',   'dt' => 1 ),
    array( 'db' => 'producto', 'dt' => 2 ),
    array( 'db' => 'cantidad', 'dt' => 3 ),
    array( 'db' => 'id', 'dt'       => 4 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);