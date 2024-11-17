<?php
session_start();
include '../conexion.php';
$conexion = Conexion::conectar();
$tipo_usuarios = pg_fetch_all(pg_query($conexion,"SELECT * FROM tipo_usuarios ORDER BY id_tipo_usu"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SARAD</title>
    <link rel="stylesheet" href="/sarad/estilo/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sarad/estilo/iconos/css/font-awesome.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #4b79a1 25%, #283e51 75%);
            color: white;
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 95vh;
            overflow: hidden;
        }

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

        .input-group-text {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: #007BFF;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            transition: background 0.3s;
        }

        .form-control::placeholder {
            color: #cccccc;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 8px #007BFF;
            outline: none;
        }

        .btn-success {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            border: none;
            padding: 12px 35px;
            border-radius: 40px;
            transition: background 0.4s ease, transform 0.4s ease, box-shadow 0.4s ease;
            font-size: 1.1rem;
        }

        .btn-success:hover {
            background: #163755;
            transform: translateY(-6px); /* Eleva el botón al pasar el mouse */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .text-danger {
            margin-bottom: 15px;
            font-size: 1.1rem;
            animation: fadeIn 0.5s ease; /* Animación de entrada */
        }

        .btn-lg {
            margin-top: 25px;
            animation: pulse 1s infinite alternate; /* Pulsar animación */
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.05);
            }
        }

        a.btn-success {
            padding: 10px 30px;
            border-radius: 40px;
            transition: transform 0.3s;
        }

        a.btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

<main>
    <div class="container">
        <img class="d-block mx-auto" alt="Logo" src="/sarad/estilo/img/logo.png">
        <?php if(isset($_SESSION['mensaje']) && $_SESSION['mensaje'] != ''): ?>
            <div class="text-danger">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php $_SESSION['mensaje'] = ''; ?>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fa fa-list-alt"></i>
                </span>
                <select class="form-control" name="id_tipo_usu" required>
                    <?php foreach($tipo_usuarios as $t): ?>
                        <option value="<?php echo $t['id_tipo_usu']; ?>"><?php echo $t['tipo_usu_descrip']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fa fa-user-circle-o"></i>
                </span>
                <input type="text" class="form-control" name="usuario" required placeholder="Usuario">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fa fa-keyboard-o"></i>
                </span>
                <input type="password" class="form-control" name="contrasena" required placeholder="Contraseña">
            </div>
            <div class="col-12 mb-3">
                <button type="submit" class="btn btn-lg btn-success">Ingresar <i class="fa fa-user-circle-o"></i></button>
            </div>
        </form>
        <div class="col-12 text-end">
            <a href="/sarad" class="btn btn-lg btn-success"><i class="fa fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</main>

<script src="/sarad/estilo/js/bootstrap.min.js"></script>
</body>
</html>
