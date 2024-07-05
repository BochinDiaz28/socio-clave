<?php
// Datos de la solicitud
$data = json_encode(array(
    "Usuario" => "sociocc@gmail.com",
    "Password" => "123456"
));

// URL de destino
$url = 'https://tareas.sistemaonline.com.ar/rest-api/Auth.php';

// Inicializar una sesión cURL
$ch = curl_init($url);

// Configurar las opciones de cURL
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Realizar la solicitud cURL
$response = curl_exec($ch);

// Comprobar si hubo errores en la solicitud
if (curl_errno($ch)) {
    echo 'Error en la solicitud cURL: ' . curl_error($ch);
}

// Cerrar la sesión cURL
curl_close($ch);

// Mostrar la respuesta
echo $response;
?>
