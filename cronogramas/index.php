<?php include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "SELECT c.*, a.anho_descrip, t.tur_descrip, cu.cur_descrip, s.sec_descrip 
                                           FROM cronogramas c, anhos a, turnos t, cursos cu, secciones s 
                                           WHERE s.id_seccion = c.id_seccion 
                                           AND cu.id_cur = c.id_cur 
                                           AND t.id_tur = c.id_tur 
                                           AND a.id_anho = c.id_anho 
                                           ORDER BY c.id_anho, c.id_tur, c.id_cur, c.id_seccion"));
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
                border: 3px solid navy; /* Borde azul marino */
            }

            h5 {
                margin: 20px 0;
                font-family: 'Verdana', sans-serif; 
                color: white;
            }

            .btn-logout:hover {
                background-color: #1a1a4d; 
                transform: translateY(-3px); 
            }

            .input-group-text {
                background: transparent;
                border: 2px solid navy; /* Borde azul marino para los inputs */
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
                border: 3px solid navy; /* Borde azul marino en el footer */
                margin-top: auto;
            }

            /* Centramos el botón Volver */
            .btn-volver {
                display: flex;
                justify-content: center; /* Centrado horizontal */
                margin-top: 20px;
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
                <h5 class="display-2 fw-bold">Cronogramas
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
                                <th>Año</th>
                                <th>Turno</th>
                                <th>Curso</th>
                                <th>Sección</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($datos as $d){ ?>
                            <tr>
                                <td>
                                    <form action="../cronogramas_asignaturas/index.php" method="GET">
                                        <button class="btn input-group-text text-success" type="submit" name="id_cro" value="<?php echo $d['id_cro']; ?>">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                    </form>
                                </td>
                                <td><?php echo $d['id_cro']; ?></td>
                                <td><?php echo $d['anho_descrip']; ?></td>
                                <td><?php echo $d['tur_descrip']; ?></td>
                                <td><?php echo $d['cur_descrip']; ?></td>
                                <td><?php echo $d['sec_descrip']; ?></td>
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
                        <?php 
                            $anhos = pg_fetch_all(pg_query($conexion, "SELECT * FROM anhos ORDER BY anho_descrip"));
                            $turnos = pg_fetch_all(pg_query($conexion, "SELECT * FROM turnos ORDER BY tur_descrip"));
                            $cursos = pg_fetch_all(pg_query($conexion, "SELECT * FROM cursos ORDER BY cur_descrip"));
                            $secciones = pg_fetch_all(pg_query($conexion, "SELECT * FROM secciones ORDER BY sec_descrip"));
                        ?>
                        <label class="text-success">Año</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <select class="form-control" name="id_anho">
                                <?php foreach($anhos as $a){ ?>
                                    <option value="<?php echo $a['id_anho']; ?>"><?php echo $a['anho_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Turno</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <select class="form-control" name="id_tur">
                                <?php foreach($turnos as $t){ ?>
                                    <option value="<?php echo $t['id_tur']; ?>"><?php echo $t['tur_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Curso</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <select class="form-control" name="id_cur">
                                <?php foreach($cursos as $c){ ?>
                                    <option value="<?php echo $c['id_cur']; ?>"><?php echo $c['cur_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Sección</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <select class="form-control" name="id_seccion">
                                <?php foreach($secciones as $s){ ?>
                                    <option value="<?php echo $s['id_seccion']; ?>"><?php echo $s['sec_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-custom"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>
        <footer>
            <div class="container">
                <p class="text-white">&copy; 2024 Aplicación de Registros Anecdóticos</p>
            </div>
        </footer>
        <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
