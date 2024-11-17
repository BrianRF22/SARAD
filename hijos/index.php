<?php
    session_start();
    $id_usu = $_SESSION['id_usu'];
    include '../conexion.php';
    $conexion = Conexion::conectar();
    $datos = pg_fetch_all(pg_query($conexion, "select a.*, p.per_ci, p.per_nombre, p.per_apellido from usuarios u, padres pa, alumnos a, personas p where p.id_per = a.id_per and a.id_padre = pa.id_padre and pa.id_per = u.id_per and u.id_usu = $id_usu;")); 
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
            .table th, .table td {
            border: 1px solid blue;
        }
        </style>
    </head>
    <body>
        <main>
            <div class="text-white">
                <h5 class="display-2 fw-bold">
                    Alumnos 
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
                                    <button class="btn input-group-text text-success" type="button" onclick="modificar('<?php echo $d['id_alu']; ?>', '<?php echo $d['consentimiento_padre']; ?>', '<?php echo $d['per_ci']; ?>', '<?php echo $d['per_nombre']; ?>', '<?php echo $d['per_apellido']; ?>');">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </td>
                                <td><?php echo $d['id_alu']; ?></td>
                                <td><?php echo $d['per_ci']; ?></td>
                                <td><?php echo $d['per_nombre']; ?></td>
                                <td><?php echo $d['per_apellido']; ?></td>
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
                                    <i class="fa fa-address-card-o"></i>
                                </span>
                                <input type="text" class="form-control text-success" id="modificar_per_nombre" name="per_nombre" readonly="" placeholder="Nombres">
                            </div><br>
                            <label class="text-success">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text text-success">
                                    <i class="fa fa-address-card-o"></i>
                                </span>
                                <input type="text" class="form-control text-success" id="modificar_per_apellido" name="per_apellido" readonly="" placeholder="Apellidos">
                            </div><br>
                            <label class="text-success">Consentimiento</label>
                            <div class="input-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="modificar_consentimiento_padre" value="SI" name="consentimiento_padre">
                                    <label class="form-check-label" for="modificar_consentimiento_padre">Consentimiento del Padre</label>
                                </div>
                            </div><br>
                            <label class="text-success">Adjuntar</label>
                            <div>
                                <input class="form-control" type="file" accept="image/png, image/jpeg, image/jpg" name="archivo_imagen">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" id="modificar_id_alu" name="id_alu" value="">
                            <button type="submit" name="operacion" value="MODIFICAR" class="btn btn-warning text-white"><i class="fa fa-edit"></i> Modificar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="/sarad/estilo/js/bootstrap.min.js"></script>
        <script src="/sarad/estilo/js/jquery-3.7.1.min.js"></script>
        <script>
            function modificar(id_alu, consentimiento_padre, per_ci, per_nombre, per_apellido){
                $("#modificar_id_alu").val(id_alu);
                $("#modificar_per_ci").val(per_ci);
                $("#modificar_per_nombre").val(per_nombre);
                $("#modificar_per_apellido").val(per_apellido);
                if(consentimiento_padre == "SI"){
                    $("#modificar_consentimiento_padre").prop("checked", true);
                }else{
                    $("#modificar_consentimiento_padre").prop("checked", false);
                }
                $("#btn-modal-modificar").click();
            }
        </script>
        <footer>
            <p>&copy; 2024 Aplicación de Registros Anecdóticos</p>
        </footer>
    </body>
</html>
