<?php include '../conexion.php';
$conexion = Conexion::conectar();
$cursos = pg_fetch_all(pg_query($conexion, "select * from cursos order by id_cur")); 
?>
<!DOCTYPE html>
<html>
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
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
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
        <div class="container text-center">
            <h5 class="display-2 fw-bold text-white">Cursos</h5>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-logout" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    <i class="fa fa-plus-circle"></i> Agregar
                </button>
            </div>
            <?php foreach($cursos as $c){ ?>
                <div class="mb-2 input-group">
                    <span class="input-group-text">
                        <i class="fa fa-graduation-cap"></i>
                    </span>
                    <button onclick="modificar(<?php echo $c['id_cur']; ?>,'<?php echo $c['cur_descrip']; ?>')" class="btn btn-logout">
                        <?php echo $c['cur_descrip']; ?>
                    </button>
                </div>
            <?php } ?>
            <div class="text-end mb-3">
                <a href="/sarad/inicio" class="btn btn-logout">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        <input type="hidden" data-bs-toggle="modal" data-bs-target="#modal-modificar" id="btn-modal-modificar">
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
                        <label class="text-primary">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-graduation-cap"></i>
                            </span>
                            <input type="text" class="form-control text-white" name="cur_descrip" required="" placeholder="Descripción">
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
    <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
        <form action="modificar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Actualizar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-end">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-graduation-cap"></i>
                            </span>
                            <input type="text" class="form-control text-end" id="modificar_cur_descrip" name="cur_descrip" required="" placeholder="Descripción">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" id="modificar_id_cur" name="id_cur" value="">
                        <button type="submit" name="operacion" value="MODIFICAR" class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modificar</button>
                        <button type="submit" name="operacion" value="ELIMINAR" class="btn btn-dark"><i class="fa fa-minus-circle"></i> Eliminar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="/sarad/estilo/js/bootstrap.min.js"></script>
    <script src="/sarad/estilo/js/jquery-3.7.1.min.js"></script>
    <script>
        function modificar(id_cur, cur_descrip){
            $("#modificar_id_cur").val(id_cur);
            $("#modificar_cur_descrip").val(cur_descrip);
            $("#btn-modal-modificar").click();
        }
    </script>
</body>
</html>
