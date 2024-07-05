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
    SELECT a.id,c.canal,c.cod_local,c.local 
    FROM clientes_retails a, clientes b, retail c 
    WHERE a.idempresa=$empresaID
    AND a.idcliente=$clienteID
    AND a.idcliente=b.id
    AND a.idretail=c.id
) temp
EOT;

$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt'             => 0 ),
    array( 'db' => 'canal', 'dt'          => 1 ),
    array( 'db' => 'cod_local', 'dt'      => 2 ),
    array( 'db' => 'local', 'dt'          => 3 ),
    array( 'db' => 'id', 'dt'             => 4 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);