<?php
// Leer los datos del archivo invitados.json
$archivo = 'invitados.json';
$datos = file_get_contents($archivo);
$invitados = json_decode($datos, true);
$code = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : '200';

// Verificar si el formulario ha sido enviado para agregar un invitado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nombre'])) {
    // Agregar el nuevo nombre a la lista
    $nuevoNombre = $_POST['nombre'];
    $invitados['personas'][] = $nuevoNombre;
    
    // Guardar los datos actualizados en el archivo JSON
    file_put_contents($archivo, json_encode($invitados, JSON_PRETTY_PRINT));
    
    // Redirigir a la misma página para evitar resubmit del formulario al refrescar
    header('Location: agregar.php?code=201');
    exit;
}

// Verificar si se ha enviado el código para eliminar un invitado
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar'];
    if (isset($invitados['personas'][$indice])) {
        // Eliminar el invitado seleccionado
        array_splice($invitados['personas'], $indice, 1);
        
        // Guardar los datos actualizados en el archivo JSON
        file_put_contents($archivo, json_encode($invitados, JSON_PRETTY_PRINT));
        
        // Redirigir a la misma página después de eliminar
        header('Location: agregar.php?code=200');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Invitados</title>
    <!-- Agregar Bootstrap desde el CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-4">
        <h1>Lista de Invitados</h1>
        
        <!-- Formulario para agregar un nuevo invitado -->
        <form method="POST" action="agregar.php">
            <div class="form-group">
                <label for="nombre">Nuevo Invitado:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>

        <?php if (isset($code) && $code == '201'): ?>
            <div class="alert alert-primary" role="alert">
                <strong>Correcto!</strong> Registro exitoso.
            </div>
        <?php elseif (isset($code) && $code == '200'): ?>
            <div class="alert alert-success" role="alert">
                <strong>Eliminado!</strong> Invitado eliminado exitosamente.
            </div>
        <?php endif; ?>

        <!-- Buscador -->
        <div class="mt-4 mb-4">
            <label for="search" class="form-label">Buscar Invitado:</label>
            <input type="text" id="search" class="form-control" onkeyup="filterList()" placeholder="Buscar por nombre...">
        </div>

        <!-- Mostrar la lista de invitados -->
        <h2>Lista de Personas</h2>
        <ul id="invitadosList" class="list-group">
            <?php foreach ($invitados['personas'] as $index => $invitado): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $index+1 . ".- ".htmlspecialchars($invitado); ?>
                    <a href="?eliminar=<?php echo $index; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy37hD1s4Vd7O+aK7yQ2Q4UoVoAqzSxwyNnt30ns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0w6Ivjj2ccGdfHjMn1ihChPavmrB76P8I3jDZPtqu9u9BfFf" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgBSpI9cHVjK5eS2D4/EXAMPLE" crossorigin="anonymous"></script>

    <!-- Script para filtrar la lista de invitados -->
    <script>
        function filterList() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            const items = document.querySelectorAll('.list-group-item');
            
            items.forEach(item => {
                const itemName = item.textContent.toLowerCase();
                if (itemName.includes(searchInput)) {
                    item.style.display = ''; // Mostrar el elemento si coincide
                } else {
                    item.style.display = 'none'; // Ocultar el elemento si no coincide
                }
            });
        }
    </script>
</body>
</html>
