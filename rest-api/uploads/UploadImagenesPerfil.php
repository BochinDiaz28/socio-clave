<?php
$patch = '../../public/img/perfil/';
$max_ancho = 1024;
$max_alto = 1024;

if (is_array($_FILES) && count($_FILES) > 0) {
    $aleatorio = rand(1, 999);
    if (in_array($_FILES["file"]["type"], array("image/pjpeg", "image/jpeg", "image/png", "image/gif"))) {
        $medidasimagen = getimagesize($_FILES['file']['tmp_name']);

        if ($medidasimagen[0] < 1024 && $_FILES['file']['size'] < 100000) {
            $guardo = moveAndReturnFileName($aleatorio, $_FILES['file'], $patch);
            echo $guardo;
        } else {
            $guardo = resizeAndReturnFileName($aleatorio, $_FILES['file'], $patch, $max_ancho, $max_alto);
            echo $guardo;
            
        }
    } else {
        echo 0; // 'Tipo de archivo no soportado';
    }
} else {
    echo 0; // 'Archivo no encontrado';
}

function moveAndReturnFileName($aleatorio, $file, $patch)
{
    $nombrearchivo = $file['name'];
    $slug = generateSlug($nombrearchivo);
    $targetFilePath = $patch . '/' . $aleatorio . '-' . $slug;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $aleatorio . "-" . $slug; // Solo se concatena el aleatorio y el slug
    } else {
        return 0; // 'Error al subir el archivo';
    }
}


function resizeAndReturnFileName($aleatorio, $file, $patch, $max_ancho, $max_alto)
{
    $nombrearchivo = $file['name'];
    $slug = generateSlug($nombrearchivo);

    $rtOriginal = $file['tmp_name'];
    list($ancho, $alto) = getimagesize($rtOriginal);
    $ratio = min($max_ancho / $ancho, $max_alto / $alto);

    $ancho_final = round($ancho * $ratio);
    $alto_final = round($alto * $ratio);

    $lienzo = imagecreatetruecolor($ancho_final, $alto_final);

    $original = loadImageByType($file['type'], $rtOriginal);
    imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

    $targetFilePath = $patch . "/" . $aleatorio . "-" . $slug;
    if (saveImageByType($file['type'], $lienzo, $targetFilePath)) {
        return $aleatorio . "-" . $slug;
    } else {
        return 0; // 'Error al guardar el archivo optimizado';
    }
}

function generateSlug($filename)
{
    $slug = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª', 'É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê', 'Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î', 'Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô', 'Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û', 'Ñ', 'ñ', 'Ç', 'ç'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'N', 'n', 'C', 'c'),
        $filename
    );
    $slug = strtolower($slug);
    $slug = str_replace(" ", "-", $slug);
    $slug = str_replace(",", "", $slug);
    return $slug;
}

function loadImageByType($type, $rtOriginal)
{
    switch ($type) {
        case 'image/jpeg':
            return imagecreatefromjpeg($rtOriginal);
        case 'image/png':
            return imagecreatefrompng($rtOriginal);
        case 'image/gif':
            return imagecreatefromgif($rtOriginal);
    }
}

function saveImageByType($type, $lienzo, $targetFilePath)
{
    switch ($type) {
        case 'image/jpeg':
            return imagejpeg($lienzo, $targetFilePath);
        case 'image/png':
            return imagepng($lienzo, $targetFilePath);
        case 'image/gif':
            return imagegif($lienzo, $targetFilePath);
    }
}
?>
