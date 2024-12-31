<?php
require_once 'conexion.php';
require_once 'valida.php';

session_start(); // Inicia la sesión

$conexion = new Conexion();
$invitados = new Invitados();

// ID de sesión a buscar

//$resultado = $conexion->islogged(session_id());
// Captura el parámetro 'name' de la URL
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Invitado';
$code = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : '200';
$isInvited=$invitados->buscarNombre(urldecode($name))
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript Bundle (incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        @font-face {
            font-family: 'Shlop';
            src: url('fonts/shlop_rg.otf') format('opentype'); /* Ruta relativa a tu archivo */
        }
        body {
            background: url('img/bg_desktop.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .content-top {
            width: 30%;
            position: absolute;
            top: 10%;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 10px;
        }

        .content-bottom {
            position: absolute;
            bottom: 20%;
            text-align: center;
            border-radius: 100px;
        }
        .texto{
            font-family: 'Shlop', sans-serif; /* Aplica la fuente a los <p> */
            color: #9ced60;
            -webkit-text-stroke: 0.3px black; /* Borde para el texto */
        }

        /* Laptop (Pantallas entre 1024px y 1366px de ancho) */
        @media (max-width: 1366px) and (min-width: 1024px) {
            .content-top {
                width: 50%; /* Ajusta el ancho para laptops */
            }
        }

        /* Tablet (Pantallas entre 768px y 1023px de ancho) */
        @media (max-width: 1023px) and (min-width: 768px) {
            .content-top {
                width: 70%; /* Ajusta el ancho para tablets */
            }
        }

        /* Celular (Pantallas menores a 768px de ancho) */
        @media (max-width: 767px) {
            .content-top {
                width: 90%; /* Ajusta el ancho para celulares */
            }
        }

        @media (max-width: 768px) {
        body {
            background: url('img/bg_mobile.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .content-bottom {
            bottom: 5%;
        }
    }
    </style>
</head>
<body>
<div class="content-top">
    <p class="texto" style="color: #FEE79B;font-size: 20px; margin-bottom: 0px;margin-top: 20px;">Invitacion para:</p>
    <p class="texto" style="font-size: 40px;">
        <?php 
        if ($isInvited):
            echo $name ;
        else:
            echo "¿Quien eres?";
        endif;
        
        ?>
    </p>
    <a href="https://maps.app.goo.gl/23dgegvuCFxyMStC9?g_st=ic" class="texto" target="_blank">
        Ubicación
    </a>

</div>
<?php if ($isInvited): ?>
<div class="content-bottom">
    <p class="texto" style="margin-bottom: -10px;">Click aquí</p>
    <img id="formulario"
        width="100px"
        height="100px"
        src="img/portal-rick-and-morty.gif" 
        alt="GIF clickeable"
        class="gif-clickable"
        data-bs-toggle="modal" 
        data-bs-target="#exampleModal">
</div>
<?php endif; ?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" ></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($code == '201'): ?>
                        <!-- MENSAJE DE QUE YA ESTA HIZO SU ELECCION -->
                        <h2 class="text-center text-dark">Gracias, <?php echo $name; ?>.</h2>
                        <p class="text-center text-success">Hemos guardado tu voto.</p>
                    <?php elseif ($code == '500' || $conexion->buscar('name',$name) != null): ?>
                        <!-- MENSAJE DE QUE YA ESTA HIZO SU ELECCION -->
                        <h2 class="text-center text-dark">Hola, <?php echo $name; ?>.</h2>
                        <p class="text-center text-warning">Hemos encontrado un registro asociado a este nombre o sesión.</p>
                    <?php elseif ($code == '200'): ?>
                        <p class="text-center" style="color: #000000; font-size: 18px;">
                        Estimad@ <strong><?php echo $name; ?></strong>,
                        El próximo 11 de Enero estaré celebrando mi cumpleaños y sería un placer contar con tu presencia.                    
                        Te agradecería mucho confirmar tu asistencia.
                        </p>
                        <p class="text-center" style="color: #000000; font-size: 15px;">
                            La fiesta estará amenizada por el Grupo & ORQ "Somos Selecta"
                        </p> 
                        <h2 class="text-center text-primary"></h2>
                        <!-- REGISTRAR NUEVO INVITADO -->
                        <form action="guardar.php" method="POST" class="mt-4">
                            <input value="<?php echo session_id(); ?>" name="id_session" type="hidden">
                            <div class="mb-3">
                                <input type="hidden" name="name" id="name" value="<?php echo $name; ?>" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-around mt-4">
                                <button type="submit" name="answer" value="SI" class="btn btn-success w-50">Llego (con regalo)</button>
                                <button type="submit" name="answer" value="NO" class="btn btn-secondary w-50" style="background-color: #7952B3;">Pal otro año será 💔</button>
                            </div>
                                
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php if ($code == '500' || $conexion->buscar('name',$name) != null): ?>

    <script>
        $(document).ready(function() {
            // Mostrar el modal al cargar la página
            $('#exampleModal').modal('show');
        });
    </script>
<?php endif; ?>

<!-- Elemento de audio oculto -->
<audio id="audio" loop>
    <source src="audio/tottus.mp3" type="audio/mp3">
    Tu navegador no soporta la etiqueta de audio.
</audio>
<script>
    
        // Cuando el usuario haga clic en el botón, se reproducirá el audio
        document.getElementById("formulario").onclick = function() {

            var audio = document.getElementById("audio");
            audio.play().catch(function(error) {
                // Si ocurre un error, muestra un mensaje
                console.log("No se pudo reproducir el audio: " + error);
            });
        };
    </script>
</body>
</html>
