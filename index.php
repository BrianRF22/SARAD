<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SARAD</title>
        <link rel="shortcut icon" href="/sarad/estilo/img/logo.png">
        <link rel="stylesheet" href="/sarad/estilo/css/bootstrap.min.css">
        <link rel="stylesheet" href="/sarad/estilo/iconos/css/font-awesome.min.css">
        <style>
            /* Ajuste para el fondo */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom, #4b79a1 25%, #283e51 75%); /* Degradado de fondo */
            color: #e0e0e0; /* Color de texto más claro */
            font-family: 'Arial', sans-serif;
        }

            /* Contenedor con fondo semitransparente */
        main {
            flex-grow: 1;
            width: 90%;
            max-width: 1700px; /* Ajusta el ancho máximo del contenedor */
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            border: 5px solid #001f3f; /* Borde azul marino ancho */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1s ease; /* Animación de entrada */
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .container {
            text-align: center;
            width: 100%;
        }

        .container img {
            width: 160px; /* Cambié el tamaño de la imagen */
            margin-bottom: 25px;
            transition: transform 0.3s;
        }

        .container img:hover {
            transform: scale(1.15); /* Aumenta el tamaño al pasar el mouse */
        }


            /* Estilo del logo */
        img {
            width: 160px;
            margin-bottom: 35px;
        }

            /* Texto del mensaje de bienvenida */
        h1, h2 {
            color: #ffffff; /* Color de texto más claro */
            text-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 30px;
        }

        h2 {
            font-size: 2.2rem;
            margin-bottom: 50px;
            }

            /* Botones estilizados, con el mismo degradado */
        .btn-custom {
            background: linear-gradient(to right, #1e3c72, #2a5298); /* Degradado azul oscuro para los botones */
            border: 2px solid #001c2a;
            border-radius: 30px;
            padding: 15px 50px;
            font-size: 1.3rem;
            color: white;
            transition: background-color 0.3s, transform 0.3s;
            margin: 15px 0;
            width: 100%;
            max-width: 250px; /* Tamaño de ancho ajustado */
            text-align: center;
        }

        .btn-custom:hover {
            background-color: #001719; /* Azul más oscuro al pasar el mouse */
            transform: translateY(-5px);
        }

            /* Centrar los botones en el contenedor */
        .button-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

            /* Movimiento flotante */
        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
            100% {
                transform: translateY(0);
            }
        }
        </style>
    </head>
    <body>
        <main>
            <div class="container">
                <!-- Logo -->
                <img src="/sarad/estilo/img/logo.png" alt="Logo SARAD">
                
                <!-- Texto de bienvenida -->
                <h1>¡Bienvenido a SARAD!</h1>
                <h2>Tu herramienta de gestión educativa.</h2>
                
                <div class="button-container">
                    <!-- Botones estilizados con degradado y tamaño igualado -->
                    <a href="/sarad/login" class="btn btn-custom">Ingresar <span class="fa fa-user-circle-o"></span></a>
                    <a href="/sarad/index.html" class="btn btn-custom">Página Web <span class="fa fa-globe"></span></a>
                </div>
            </div>
        </main>
        <script src="/sarad/estilo/js/bootstrap.min.js"></script>
    </body>
</html>
