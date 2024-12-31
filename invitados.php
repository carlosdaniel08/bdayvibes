<?php
require 'conexion.php';

$conexion = new Conexion();
$data = $conexion->leerDatos();

// Ordenar los registros por la respuesta
usort($data, function($a, $b) {
    return strcmp($a['answer'], $b['answer']); // Orden ascendente
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Registros</title>
    <!-- Agregar Bootstrap desde el CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div class="container mt-4">
        <h1>Lista de Registros</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Respuesta</th>
                    <th>ID Sesión</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $registro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registro['name']); ?></td>
                            <td><?php echo htmlspecialchars($registro['answer']); ?></td>
                            <td>
                                <a href="eliminar.php?id=<?php echo urlencode($registro['id_session']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy37hD1s4Vd7O+aK7yQ2Q4UoVoAqzSxwyNnt30ns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0w6Ivjj2ccGdfHjMn1ihChPavmrB76P8I3jDZPtqu9u9BfFf" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgBSpI9cHVjK5eS2D4/EXAMPLE" crossorigin="anonymous"></script>
</body>
</html>
