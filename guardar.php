<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $answer = $_POST['answer'];
    $id_session = $_POST['id_session'] ?? null;

    $nuevoRegistro = [
        'name' => $name,
        'answer' => $answer,
        'id_session' => $id_session,
    ];

    $conexion = new Conexion();
    $registro = $conexion->buscar('name',$name);
    if($registro == null):
        /** Guardar voto si no lo ha hecho */
        $data = $conexion->leerDatos();
        $data[] = $nuevoRegistro; // Agregar el nuevo registro
        $conexion->guardarDatos($data);
        header("Location: index.php?code=201&name=" . htmlspecialchars($_POST['name']));
    else:
        /** Retornar con mensaje de error */
        header("Location: index.php?code=500&name=". $registro['name']);
    endif;
    //header('Location: invitados.php'); // Redirigir a la lista después de guardar
    exit();
}else{
    header("Location: index.php");
}

?>
