<?php 
include '../session.php';
include '../conexion.php';
$conexion = Conexion::conectar();
$id_tipo_usu = $_SESSION['id_tipo_usu'];
$menu = pg_fetch_all(pg_query($conexion, "select p.*, t.id_tipo_usu from tipo_usuarios_paginas t, paginas p where p.id_pag = t.id_pag and t.id_tipo_usu = $id_tipo_usu order by pag_descrip;"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SARAD</title>
    <link rel="shortcut icon" href="/sarad/estilo/img/logo.png">
    <link rel="stylesheet" href="/sarad/estilo/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sarad/estilo/iconos/css/font-awesome.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #4b79a1 25%, #283e51 75%); /* Degradado de azul */
            color: white; /* Color del texto en blanco */
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.7); /* Fondo semi-transparente para el contenido */
            border-radius: 20px; /* Bordes redondeados */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra del contenedor */
            margin: 20px; /* Margen alrededor del contenedor */
        }

        h5 {
            margin: 20px 0; /* Espaciado entre títulos */
            font-family: 'Verdana', sans-serif; /* Cambiar fuente */
            overflow-wrap: break-word; /* Evitar que el texto sobresalga */
            color: white; /* Color del título en blanco */
        }

        .btn-custom {
            background: linear-gradient(to bottom, #4b79a1, #283e51); /* Gradiente aplicado a los botones */
            color: white; /* Color del texto en blanco */
            border: 2px solid black; /* Borde negro */
            border-radius: 20px; /* Bordes más redondeados */
            transition: background-color 0.3s, transform 0.3s;
            padding: 10px 20px; /* Padding para el botón */
            margin: 10px 0; /* Margen vertical para centrar */
            text-decoration: none; /* Eliminar subrayado */
            display: flex; /* Usar flexbox para centrar íconos y texto */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
        }

        .btn-custom:hover {
            background-color: #2a2a4d; /* Azul más oscuro al pasar el mouse */
            transform: translateY(-3px); /* Efecto de elevación en el botón */
        }

        .btn-logout {
            background: linear-gradient(to bottom, #4b79a1, #283e51); /* Mismo color que los demás botones */
            color: white; /* Color del texto en blanco */
            border: 2px solid black; /* Borde negro */
            border-radius: 30px;
                padding: 15px 50px;
                font-size: 1.3rem;
            margin: 10px 0; /* Margen vertical para centrar */
            text-decoration: none; /* Eliminar subrayado */
            display: inline-flex; /* Usar flexbox para centrar íconos y texto */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
            font-size: 0.9rem; /* Tamaño de fuente ajustado para el botón */
        }

        .btn-logout:hover {
            background-color: #2a2a4d; /* Color más oscuro al pasar el mouse */
            transform: translateY(-3px); /* Efecto de elevación en el botón */
        }

        .input-group-text {
            background: transparent; /* Fondo transparente para el icono */
            border: none; /* Sin borde */
            color: white; /* Color del texto para icono */
            font-size: 1.5rem; /* Tamaño del icono */
            display: flex; /* Usar flexbox para alinear el icono y el texto */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
        }

        footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to bottom, #4b79a1, #283e51); /* Fondo del footer */
            color: white; /* Color blanco */
            border-radius: 15px; /* Bordes redondeados */
            border: 3px solid black; /* Borde negro */
            margin-top: auto; /* Mantener el pie de página al final */
        }
    </style>
</head>
<body>

<main>
    <div>
        <img class="d-block mx-auto mb-4" alt="" src="/sarad/estilo/img/logo.png" width="150vw">
        <h5 class="display-5 fw-bold">¿Qué desea ver?</h5>
        <div class="row">
            <?php foreach($menu as $m){ ?>
                <div class="col-12 col-md-4 mb-3"> <!-- Usar col-md-4 para 3 botones por fila en pantallas medianas y más grandes -->
                    <div class="p-1 m-1 input-group justify-content-center">
                        <span class="input-group-text text-primary col-2 col-lg-1">
                            <i class="fa <?php echo $m['pag_icono']; ?>"></i>
                        </span>
                        <a href="<?php echo $m['pag_ubicacion']; ?>" class="btn-custom col-10 col-lg-11">
                            <?php echo $m['pag_descrip']; ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="p-1 m-1 text-center">
            <a href="/sarad/login" class="btn-logout"><i class="fa fa-arrow-left"></i> Cerrar Sesión</a>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Aplicación de Registros Anecdóticos.</p>
</footer>

<script src="/sarad/estilo/js/bootstrap.min.js"></script>
</body>
</html>
