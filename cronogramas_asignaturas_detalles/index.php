<?php include '../conexion.php';
$id_cro = $_GET['id_cro'];
$id_asi = $_GET['id_asi'];
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "select c.*, a.anho_descrip, t.tur_descrip, cu.cur_descrip, s.sec_descrip, ca.id_asi, ca.carga_horaria, to_char(ca.carga_horaria, 'HH24:MI') carga_horaria_formato, asi.asi_descrip from cronogramas c, anhos a, turnos t, cursos cu, secciones s, cronogramas_asignaturas ca, asignaturas asi where asi.id_asi = ca.id_asi and ca.id_cro = c.id_cro and s.id_seccion = c.id_seccion and cu.id_cur = c.id_cur and t.id_tur = c.id_tur and a.id_anho = c.id_anho and ca.id_cro = $id_cro and ca.id_asi = $id_asi order by c.id_anho, c.id_tur, c.id_cur, c.id_seccion"));
$cronogramas_asignaturas_detalles = pg_fetch_all(pg_query($conexion, "select c.*, to_char(c.hora_desde, 'HH24:MI') hora_desde, to_char(c.hora_hasta, 'HH24:MI') hora_hasta, di.dia_descrip, d.id_per, (p.per_nombre||' '||p.per_apellido||' ('||p.per_ci||')') docente from cronogramas_asignaturas_detalles c, dias di, docentes d, personas p where p.id_per = d.id_per and d.id_doc = c.id_doc and di.id_dia = c.id_dia and id_cro = $id_cro and id_asi = $id_asi order by c.id_dia, c.hora_desde"));
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
    </head>
    <body>
        <main>
            <div>
                <h5 class="display-2 fw-bold">Cronogramas - Asignaturas - Detalles
                    <button type="button" class="btn btn-lg btn-logout text-end" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Año</th>
                                <th>Turno</th>
                                <th>Curso</th>
                                <th>Sección</th>
                                <th>Asignatura</th>
                                <th>Carga Horaria</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($datos as $d){ ?>
                            <tr>
                                <td><?php echo $d['id_cro']; ?></td>
                                <td><?php echo $d['anho_descrip']; ?></td>
                                <td><?php echo $d['tur_descrip']; ?></td>
                                <td><?php echo $d['cur_descrip']; ?></td>
                                <td><?php echo $d['sec_descrip']; ?></td>
                                <td><?php echo $d['asi_descrip']; ?></td>
                                <td><?php echo $d['carga_horaria_formato']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Día</th>
                                <th>Docente</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cronogramas_asignaturas_detalles as $d){ ?>
                            <tr>
                                <td>
                                    <button class="btn input-group-text text-primary" type="button">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </td>
                                <td><?php echo $d['dia_descrip']; ?></td>
                                <td><?php echo $d['docente']; ?></td>
                                <td><?php echo $d['hora_desde']; ?></td>
                                <td><?php echo $d['hora_hasta']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-1 m-1 text-end">
                    <a href="/sarad/cronogramas_asignaturas/index.php?id_cro=<?php echo $id_cro?>" class="btn btn-lg btn-logout text-end"><i class="fa fa-arrow-left"></i> Volver</a>
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
                        <input type="hidden" name="id_cro" value="<?php echo $id_cro; ?>">
                        <input type="hidden" name="id_asi" value="<?php echo $id_asi; ?>">
                        <?php 
                            $dias = pg_fetch_all(pg_query($conexion, "select * from dias d order by d.id_dia"));
                            $docentes = pg_fetch_all(pg_query($conexion, "select d.*, (p.per_nombre||' '||p.per_apellido||' ('||p.per_ci||')') docente from docentes d, personas p where p.id_per = d.id_per order by p.per_nombre, p.per_apellido, p.per_ci"));
                        ?>
                        <div class="mb-3">
                            <label for="id_dia" class="form-label text-primary">Día</label>
                            <select class="form-select" name="id_dia" id="id_dia" required>
                                <option value="">Seleccione</option>
                                <?php foreach($dias as $d){ ?>
                                    <option value="<?php echo $d['id_dia']; ?>"><?php echo $d['dia_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_doc" class="form-label text-primary">Docente</label>
                            <select class="form-select" name="id_doc" id="id_doc" required>
                                <option value="">Seleccione</option>
                                <?php foreach($docentes as $d){ ?>
                                    <option value="<?php echo $d['id_doc']; ?>"><?php echo $d['docente']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hora_desde" class="form-label text-primary">Hora Desde</label>
                            <input type="time" name="hora_desde" id="hora_desde" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_hasta" class="form-label text-primary">Hora Hasta</label>
                            <input type="time" name="hora_hasta" id="hora_hasta" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>
        <footer>
            <p>&copy; 2024 Aplicación de Registros Anecdóticos</p>
        </footer>
        <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
