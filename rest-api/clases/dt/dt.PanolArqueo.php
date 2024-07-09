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
    SELECT a.id, a.origen, b.producto,a.fecha, a.detalle, a.cantidad, c.nombre
    FROM panol_arqueo a, panol b, usuarios c
    WHERE a.productoID=b.id
    AND a.idusuario=c.id 
    AND a.productoID=$productoID 
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt'            => 0 ),
    array( 'db' => 'origen', 'dt'        => 1 ),
    array( 'db' => 'producto', 'dt'      => 2 ),
    array( 'db' => 'fecha', 'dt'         => 3 ),
    array( 'db' => 'detalle', 'dt'       => 4 ),
    array( 'db' => 'cantidad', 'dt'      => 5 ),
    array( 'db' => 'nombre', 'dt'        => 6 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);