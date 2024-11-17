<?php include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "select * from asignaturas order by id_asi"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARAD - Asignaturas</title>
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
            padding: 15px 20px; /* Padding para el botón */
            margin: 10px; /* Margen entre botones */
            text-decoration: none; /* Eliminar subrayado */
            display: inline-flex; /* Usar inline-flex para centrar íconos y texto */
            align-items: center; /* Centrar verticalmente */
            justify-content: center; /* Centrar horizontalmente */
            font-size: 1rem; /* Tamaño de fuente */
            width: 200px; /* Ancho fijo para todos los botones */
        }

        .btn-custom:hover {
            background-color: #2a2a4d; /* Azul más oscuro al pasar el mouse */
            transform: translateY(-3px); /* Efecto de elevación en el botón */
        }

        .btn-volver {
            background: linear-gradient(to bottom, #4b79a1, #283e51); /* Gradiente para el botón volver */
            color: white; /* Color del texto en blanco */
            border: 2px solid black; /* Borde negro */
            border-radius: 20px; /* Bordes redondeados */
            transition: background-color 0.3s, transform 0.3s;
            padding: 15px 20px; /* Padding igual al resto de botones */
            margin: 10px; /* Margen entre botones */
            font-size: 1rem; /* Tamaño de fuente */
            width: 200px; /* Ancho fijo para el botón volver */
        }

        .btn-volver:hover {
            background-color: #2a2a4d; /* Azul más oscuro al pasar el mouse */
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
        .modal-content {
            background: rgba(0, 0, 0, 0.8); /* Fondo más oscuro para modales */
            border: 2px solid black; /* Borde negro para el modal */
        }
        .modal-header, .modal-footer {
            border-bottom: 1px solid black; /* Borde inferior para el encabezado del modal */
        }
        .text-muted {
            color: #6c757d; /* Color de texto atenuado para mensajes */
        }
    </style>
</head>
<body>
    <main>
        <h5 class="display-4 fw-bold">Asignaturas</h5>
        <div class="text-end mb-3">
            <button type="button" class="btn btn-lg btn-custom" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                <i class="fa fa-plus-circle"></i> Agregar
            </button>
        </div>
        <div class="row">
            <?php foreach($datos as $d) { ?>
                <div class="col-md-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text text-primary">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        <button onclick="modificar(<?php echo $d['id_asi']; ?>,'<?php echo $d['asi_descrip']; ?>')" class="btn btn-custom">
                            <?php echo $d['asi_descrip']; ?>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="text-center mb-3">
            <a href="/sarad/inicio" class="btn btn-volver"><i class="fa fa-arrow-left"></i> Volver</a>
        </div>
    </main>

    <!-- Modal Agregar -->
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
        <form action="agregar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Agregar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-pencil-square-o"></i>
                            </span>
                            <input type="text" class="form-control text-primary" name="descripcion" required placeholder="Descripción">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-custom"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Modificar -->
    <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-modificar" aria-hidden="true">
        <form action="modificar.php" method="GET">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Actualizar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-pencil-square-o"></i>
                            </span>
                            <input type="text" class="form-control text-success" id="modificar_descripcion" name="descripcion" required placeholder="Descripción">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" id="modificar_codigo" name="codigo" value="">
                        <button type="submit" name="operacion" value="MODIFICAR" class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modificar</button>
                        <button type="submit" name="operacion" value="ELIMINAR" class="btn btn-dark"><i class="fa fa-minus-circle"></i> Eliminar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <footer>
        &copy; 2024 Aplicación de Registros Anecdóticos
    </footer>
    <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
    <script>
        function modificar(codigo, descripcion) {
            document.getElementById('modificar_codigo').value = codigo;
            document.getElementById('modificar_descripcion').value = descripcion;
            const modal = new bootstrap.Modal(document.getElementById('modal-modificar'));
            modal.show();
        }
    </script>
</body>
</html>