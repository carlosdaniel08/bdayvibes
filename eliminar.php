<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Leer los datos del archivo JSON
    $archivo = 'datos.json';
    $datos = file_get_contents($archivo);
    $registros = json_decode($datos, true);
    
    // Verificar si el registro existe y eliminarlo
    $found = false;
    foreach ($registros as $key => $registro) {
        if ($registro['id_session'] == $id) {
            unset($registros[$key]);
            $found = true;
            break;
        }
    }

    if ($found) {
        // Guardar los registros actualizados en el archivo JSON
        file_put_contents($archivo, json_encode(array_values($registros), JSON_PRETTY_PRINT));
        header('Location: invitados.php'); // Redirigir de vuelta a la página principal
        exit;
    } else {
        echo "Registro no encontrado.";
    }
} else {
    echo "No se ha especificado un ID.";
}
