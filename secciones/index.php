<?php 
include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "SELECT * FROM secciones ORDER BY id_seccion")); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SARAD - Secciones</title>
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
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra del contenedor */
            margin: 20px;
        }

        h5 {
            margin: 20px 0;
            font-family: 'Verdana', sans-serif; 
            color: white;
        }

        .btn-logout:hover {
            background-color: #2a2a4d; 
            transform: translateY(-3px); 
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to bottom, #4b79a1, #283e51); 
            color: white; 
            border-radius: 15px;
            border: 3px solid black;
            margin-top: auto;
        }

        /* Centramos el botón Volver */
        .btn-volver {
            display: flex;
            justify-content: center; /* Centrado horizontal */
            margin-top: 20px;
        }
        .modal-content {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid black;
        }

        .modal-header, .modal-footer {
            border-bottom: 1px solid black;
        }

        .text-muted {
            color: #6c757d;
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
    </style>
</head>
<body>
    <main>
        <div>
            <h5 class="display-2 fw-bold">Secciones 
                <button type="button" class="btn btn-lg btn-logout text-end" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </h5>

            <?php foreach($datos as $d){ ?>
                <div class="p-1 m-1 input-group">
                    <span class="input-group-text text-primary">
                        <i class="fa fa-database"></i>
                    </span>
                    <button onclick="modificar(<?php echo $d['id_seccion']; ?>, '<?php echo $d['sec_descrip']; ?>')" class="btn btn-group btn-lg btn-logout">
                        <?php echo $d['sec_descrip']; ?>
                    </button>
                </div>
            <?php } ?>
            <div class="btn-volver">
                <a href="/sarad/inicio" class="btn btn-logout text-end"><i class="fa fa-arrow-left"></i> Volver</a>
            </div>
        </div>
    </main>

    <!-- Modal para agregar sección -->
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
        <form action="agregar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Agregar Sección</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-database"></i>
                            </span>
                            <input type="text" class="form-control" name="descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal para modificar sección -->
    <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-modificar" aria-hidden="true">
        <form action="modificar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Modificar Sección</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="mod_id" name="id">
                        <label class="text-success">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-database"></i>
                            </span>
                            <input type="text" class="form-control" id="mod_descripcion" name="descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Aplicación de Registros Anecdóticos</p>
    </footer>

    <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
    <script>
        function modificar(id, descripcion) {
            document.getElementById('mod_id').value = id;
            document.getElementById('mod_descripcion').value = descripcion;
            var myModal = new bootstrap.Modal(document.getElementById('modal-modificar'));
            myModal.show();
        }
    </script>
</body>
</html>