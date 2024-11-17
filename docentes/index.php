<?php include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "select d.*, p.per_ci, p.per_nombre, p.per_apellido from docentes d, personas p where p.id_per = d.id_per order by d.id_doc")); 
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

        /* Estilos de la tabla */
        
        .table th, .table td {
            border: 1px solid blue; /* Borde de celdas en azul */
        }
        .border-success {
            border-color: blue !important; /* Borde del contenedor */
        }
        .btn-success {
            background-color: blue; /* Botones en azul */
        }
        .text-success {
            color: white !important; /* Texto de éxito en blanco */
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
    </style>
</head>
<body>
    <main>
        <div>
            <h5 class="display-2 fw-bold">Docentes 
                <button type="button" class="btn btn-lg btn-logout text-end" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nº</th>
                            <th>C.I.</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $d){ ?>
                        <tr>
                            <td>
                                <button class="btn input-group-text text-success" type="button" onclick="modificar('<?php echo $d['id_doc']; ?>', '<?php echo $d['consentimiento_docente']; ?>', '<?php echo $d['per_ci']; ?>', '<?php echo $d['per_nombre']; ?>', '<?php echo $d['per_apellido']; ?>');">
                                    <i class="fa fa-pencil" style="color: blue;"></i> <!-- Cambiado a azul -->
                                </button>
                            </td>
                            <td><?php echo $d['id_doc']; ?></td>
                            <td><?php echo $d['per_ci']; ?></td>
                            <td><?php echo $d['per_nombre']; ?></td>
                            <td><?php echo $d['per_apellido']; ?></td>
                            <td style="width: 5em; height: 5em;">
                                <?php if($d['consentimiento_docente'] == 'SI' ){ ?>
                                    <img class="img-fluid" src="<?php echo $d['doc_imagen']; ?>">
                                <?php }else{ ?>
                                    <label class="text-muted">Sin Consentimiento</label>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="p-1 m-1 text-end">
                <a href="/sarad/inicio" class="btn btn-lg btn-logout text-end"><i class="fa fa-arrow-left"></i> Volver</a>
            </div>
        </div>
        <input type="hidden" data-bs-toggle="modal" data-bs-target="#modal-modificar" id="btn-modal-modificar">
    </main>
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
        <form action="agregar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary">Agregar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-primary">Docente</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <?php 
                                $personas = pg_fetch_all(pg_query($conexion, "select * from personas where id_per not in (select id_per from docentes) order by per_nombre, per_apellido, per_ci"));
                            ?>
                            <select class="form-control" name="id_per">
                                <?php foreach($personas as $p){ ?>
                                    <option value="<?php echo $p['id_per']; ?>"><?php echo $p['per_nombre']." ".$p['per_apellido']." (".$p['per_ci'].")"; ?></option>
                                <?php } ?>
                            </select>
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
    <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-modificar" aria-hidden="true">
        <form action="modificar.php" method="POST" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary" >Actualizar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-primary">C.I.</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <input type="text" class="form-control text-end" id="modificar_per_ci" name="per_ci" required="" placeholder="C.I.">
                        </div>
                        <label class="text-primary">Nombres</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <input type="text" class="form-control text-end" id="modificar_per_nombre" name="per_nombre" required="" placeholder="Nombres">
                        </div>
                        <label class="text-primary">Apellidos</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <input type="text" class="form-control text-end" id="modificar_per_apellido" name="per_apellido" required="" placeholder="Apellidos">
                        </div>
                        <label class="text-primary">Imagen (opcional)</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-file-image-o"></i>
                            </span>
                            <input type="file" class="form-control text-end" name="doc_imagen" accept="image/png, image/jpeg">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modificar_docente" name="docente" value="SI">
                            <label class="form-check-label text-success" for="modificar_docente">
                                Consentimiento para uso de imagen
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="id_doc" id="modificar_id_doc">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
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
        function modificar(id_doc, consent, ci, nombre, apellido){
            document.getElementById('modificar_id_doc').value = id_doc;
            document.getElementById('modificar_per_ci').value = ci;
            document.getElementById('modificar_per_nombre').value = nombre;
            document.getElementById('modificar_per_apellido').value = apellido;
            document.getElementById('modificar_docente').checked = (consent === 'SI');
            const modal = new bootstrap.Modal(document.getElementById('modal-modificar'));
            modal.show();
        }
    </script>
</body>
</html>
