<?php 
include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "select a.*, p.per_ci, p.per_nombre, p.per_apellido, (pa1.per_nombre||' '||pa1.per_apellido||' ('||pa1.per_ci||')') padre from alumnos a, personas p, padres pa, personas pa1 where pa1.id_per = pa.id_per and pa.id_padre = a.id_padre and p.id_per = a.id_per order by a.id_alu")); 
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
            }

            main {
            flex: 1;
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.7); /* Fondo semi-transparente para el contenido */
            border-radius: 20px; /* Bordes redondeados */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra del contenedor */
            margin: 20px; /* Margen alrededor del contenedor */
            color: white;
        }

            .text-success {
                color: #28a745 !important;
            }

            .border-success {
                border-color: #28a745 !important;
            }

            .btn-success {
                background-color: #28a745; /* Botón de agregar */
                border-color: black; /* Borde negro para botones */
            }

            .btn-success:hover {
                background-color: #218838; /* Efecto hover más oscuro */
            }

            .modal-content {
                background: rgba(0, 0, 0, 0.8); /* Fondo más oscuro para modales */
                border: 2px solid black; /* Borde negro para el modal */
                color: white;
            }

            .modal-header, .modal-footer {
                border-bottom: 1px solid black; /* Borde inferior para el encabezado del modal */
            }

            .text-muted {
                color: #6c757d; /* Color de texto atenuado para mensajes */
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
            .table th, .table td {
                border: 1px solid blue; /* Borde de celdas en azul */
            }
            
        </style>
    </head>
    <body>
        <main>
            <div>
                <h5 class="display-2 fw-bold">Alumnos 
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
                                <th>Padre</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($datos as $d){ ?>
                            <tr>
                                <td>
                                    <button class="btn input-group-text text-primary" type="button" onclick="modificar('<?php echo $d['id_alu']; ?>', '<?php echo $d['id_padre']; ?>', '<?php echo $d['consentimiento_padre']; ?>', '<?php echo $d['per_ci']; ?>', '<?php echo $d['per_nombre']; ?>', '<?php echo $d['per_apellido']; ?>');">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </td>
                                <td><?php echo $d['id_alu']; ?></td>
                                <td><?php echo $d['per_ci']; ?></td>
                                <td><?php echo $d['per_nombre']; ?></td>
                                <td><?php echo $d['per_apellido']; ?></td>
                                <td><?php echo $d['padre']; ?></td>
                                <td style="width: 5em; height: 5em;">
                                    <?php if($d['consentimiento_padre'] == 'SI' ){ ?>
                                        <img class="img-fluid" src="<?php echo $d['alu_imagen']; ?>">
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
                      <h1 class="modal-title fs-5">Agregar</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Alumno</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-address-card-o"></i>
                            </span>
                            <?php 
                                $personas = pg_fetch_all(pg_query($conexion, "select * from personas where id_per not in (select id_per from alumnos) order by per_nombre, per_apellido, per_ci"));
                            ?>
                            <select class="form-control" name="id_per">
                                <?php foreach($personas as $p){ ?>
                                    <option value="<?php echo $p['id_per']; ?>"><?php echo $p['per_nombre']." ".$p['per_apellido']." (".$p['per_ci'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Padre</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-address-card-o"></i>
                            </span>
                            <?php 
                                $padres = pg_fetch_all(pg_query($conexion, "select pa.*, p.per_ci, p.per_nombre, p.per_apellido from personas p, padres pa where pa.id_per = p.id_per order by p.per_nombre, p.per_apellido, p.per_ci"));
                            ?>
                            <select class="form-control" name="id_padre">
                                <?php foreach($padres as $pa){ ?>
                                    <option value="<?php echo $pa['id_padre']; ?>"><?php echo $pa['per_nombre']." ".$pa['per_apellido']." (".$pa['per_ci'].")"; ?></option>
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
                      <h1 class="modal-title fs-5">Actualizar</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">C.I.</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-address-card-o"></i>
                            </span>
                            <input type="text" class="form-control text-success" id="modificar_per_ci" name="per_ci" readonly="" placeholder="Cédula Identidad">
                        </div><br>
                        <label class="text-success">Nombres</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user"></i>
                            </span>
                            <input type="text" class="form-control text-success" id="modificar_per_nombre" name="per_nombre" placeholder="Nombres">
                        </div><br>
                        <label class="text-success">Apellidos</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user"></i>
                            </span>
                            <input type="text" class="form-control text-success" id="modificar_per_apellido" name="per_apellido" placeholder="Apellidos">
                        </div><br>
                        <label class="text-success">Padre</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-address-card-o"></i>
                            </span>
                            <select class="form-control text-success" id="modificar_id_padre" name="id_padre">
                                <?php foreach($padres as $pa){ ?>
                                    <option value="<?php echo $pa['id_padre']; ?>"><?php echo $pa['per_nombre']." ".$pa['per_apellido']." (".$pa['per_ci'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Consentimiento Padre</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-check"></i>
                            </span>
                            <select class="form-control text-success" id="modificar_consentimiento_padre" name="consentimiento_padre">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div><br>
                        <label class="text-success">Foto</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-image"></i>
                            </span>
                            <input type="file" class="form-control text-success" id="modificar_alu_imagen" name="alu_imagen" accept="image/png, image/jpeg">
                        </div>
                    </div>
                    <input type="hidden" id="modificar_id_alu" name="id_alu">
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>
        <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
        <script>
            function modificar(id_alu, id_padre, consentimiento_padre, per_ci, per_nombre, per_apellido){
                document.getElementById("modificar_id_alu").value = id_alu;
                document.getElementById("modificar_id_padre").value = id_padre;
                document.getElementById("modificar_consentimiento_padre").value = consentimiento_padre;
                document.getElementById("modificar_per_ci").value = per_ci;
                document.getElementById("modificar_per_nombre").value = per_nombre;
                document.getElementById("modificar_per_apellido").value = per_apellido;
                document.getElementById("btn-modal-modificar").click();
            }
        </script>
    </body>
</html>
