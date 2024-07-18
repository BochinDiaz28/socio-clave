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
        a.id, a.idempresa, a.idcliente, b.nombre AS nombreC, a.idreail, 
        a.tarea, a.sucursal, (d.nombre) AS Agente, a.fecha_alta, 
        a.fecha_sol, a.hora_inicio, a.hora_final, a.estado, a.idagente, 
        a.checkin, a.checkout, a.cerradaAgente, a.cerradaAdmin
    FROM 
        tareas a
    JOIN 
        clientes b ON a.idcliente=b.id
    JOIN 
        retail c ON a.idreail=c.id
    JOIN 
        agentes d ON a.idagente=d.id
    WHERE 
        a.idempresa = $empresaID
        AND a.estado = 5

) temp
EOT;
// TABLA primary key id>1 AND
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id',            'dt' => 0 ),
    array( 'db' => 'nombreC',       'dt' => 1 ),
    array( 'db' => 'tarea',         'dt' => 2 ),
    array( 'db' => 'sucursal',      'dt' => 3 ),
    array( 'db' => 'Agente',        'dt' => 4 ),
    array( 'db' => 'fecha_sol',     'dt' => 5 ),
    array( 'db' => 'checkin',       'dt' => 6 ),
    array( 'db' => 'checkout',      'dt' => 7 ),
    array( 'db' => 'cerradaAgente', 'dt' => 8 ),
    array( 'db' => 'cerradaAdmin',  'dt' => 9 ),    
    array( 'db' => 'id',            'dt' => 10 )
);
 
 
require( 'serverside/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);