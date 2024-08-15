<?php
//CONECCIN DE ARCHIVO CONFIG
$listadatos = datosConexion();
foreach ($listadatos as $key => $value) {
    $host = $value['server'];
    $user_db = $value['user'];
    $password_db = $value['password'];
    $bd = $value['database'];
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
    id,  
    nombre,
    direccion,
    celular,
    cuit, panol, informe, formulario
    FROM clientes WHERE idempresa=$empresaID
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt'         => 0 ),
    array( 'db' => 'nombre', 'dt'     => 1 ),
    array( 'db' => 'direccion', 'dt'  => 2 ),
    array( 'db' => 'celular', 'dt'    => 3 ),
    array( 'db' => 'cuit', 'dt'       => 4 ),
    array( 'db' => 'panol', 'dt'      => 5 ),
    array( 'db' => 'informe', 'dt'    => 6 ),
    array( 'db' => 'formulario', 'dt' => 7 ),
    array( 'db' => 'id', 'dt'         => 8 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);