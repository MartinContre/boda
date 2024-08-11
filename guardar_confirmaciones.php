<?php
// Obtener el contenido de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);
$confirmaciones = $data['confirmaciones'];
$mesa = $data['mesa'];

// Cargar las confirmaciones existentes, si existen
$archivo = 'confirmaciones.json';
$confirmacionesExistentes = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Agregar las nuevas confirmaciones
foreach ($confirmaciones as $confirmacion) {
    $familia = $confirmacion['familia'];
    $nombre = $confirmacion['nombre'];
    $encontrado = false;

    foreach ($confirmacionesExistentes as &$existente) {
        if ($existente['familia'] === $familia && $existente['nombre'] === $nombre) {
            $existente = $confirmacion;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $confirmacionesExistentes[] = $confirmacion;
    }
}

// Guardar las confirmaciones actualizadas en el archivo
file_put_contents($archivo, json_encode($confirmacionesExistentes, JSON_PRETTY_PRINT));

echo "Confirmaciones guardadas correctamente.";
?>
