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
   SELECT
    id,canal,cod_local,cadena,local,direccion,formato_local
    FROM retail WHERE idempresa=$empresaID
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt'             => 0 ),
    array( 'db' => 'canal', 'dt'          => 1 ),
    array( 'db' => 'cod_local', 'dt'      => 2 ),
    array( 'db' => 'cadena', 'dt'         => 3 ),
    array( 'db' => 'local', 'dt'          => 4 ),
    array( 'db' => 'direccion', 'dt'      => 5 ),
    array( 'db' => 'formato_local', 'dt'  => 6 ),
    array( 'db' => 'id', 'dt'             => 7 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);