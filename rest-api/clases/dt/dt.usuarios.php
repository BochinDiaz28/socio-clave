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
    username,
    nombre,
    email,
    rol,
    online
    FROM usuarios WHERE idempresa=$empresaID
) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';
$columns = array(
    array( 'db' => 'id', 'dt'       => 0 ),
    array( 'db' => 'username', 'dt' => 1 ),
    array( 'db' => 'nombre', 'dt'   => 2 ),
    array( 'db' => 'email', 'dt'    => 3 ),
    array( 'db' => 'rol', 'dt'      => 4 ),
    array( 'db' => 'online', 'dt'   => 5 ),
    array( 'db' => 'id', 'dt'       => 6 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);