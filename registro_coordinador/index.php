<?php 
session_start();
$id_per = $_SESSION['id_per'];
include '../conexion.php';
    $conexion = Conexion::conectar();
    $datos = pg_fetch_all(pg_query($conexion, "select p4.per_nombre ||' '|| p4.per_apellido||':' directivo, p3.per_nombre ||' '|| p3.per_apellido||':' coordinador,  p2.per_nombre ||' '|| p2.per_apellido||':' docente, 
        r.*, tr.tr_descrip, p.per_nombre ||' '|| p.per_apellido alumno, a2.anho_descrip, t.tur_descrip, c.cur_descrip, s.sec_descrip, er.er_descrip from registros r 
join docentes d on d.id_doc = r.id_doc
join tipo_registros tr on tr.id_tr = r.id_tr
join alumnos a on a.id_alu = r.id_alu
join personas p on p.id_per = a.id_per
join anhos a2 on a2.id_anho = r.id_anho
join turnos t on t.id_tur = r.id_tur
join cursos c on c.id_cur = r.id_cur
join secciones s on s.id_seccion = r.id_seccion
join estado_registros er on er.id_er = r.id_er
join personas p2 on p2.id_per = d.id_per
left join personas p3 on p3.id_per = r.id_per_cor
left join personas p4 on p4.id_per = r.id_per_dir
order by id_reg; "));
    
?>
<!DOCTYPE html>
<html>
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

    .btn-custom {
        background: linear-gradient(to bottom, #4b79a1, #283e51); /* Gradiente en los botones */
        color: white;
        border: 2px solid black;
        border-radius: 10px; /* Menos redondeado */
        transition: background-color 0.3s, transform 0.3s;
        padding: 8px 16px; /* Botón más pequeño */
        margin: 10px 0;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-custom:hover {
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

    /* Diseño aplicado al modal */
    .modal-content {
        background: rgba(0, 0, 0, 0.8); /* Fondo oscuro con opacidad */
        border: 2px solid black; /* Borde negro */
    }

    .modal-header, .modal-footer {
        border-bottom: 1px solid black; /* Línea en la parte inferior del encabezado */
    }

    .modal-title {
        font-size: 1.5rem; /* Tamaño de fuente del título */
    }

    .modal-header {
        background-color: #4b79a1; /* Fondo azul para el encabezado */
        color: white; /* Texto blanco */
    }

    .modal-footer {
        background-color: #f1f1f1; /* Fondo gris claro para el pie del modal */
    }

    .btn-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
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
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SARAD</title>
        <link rel="stylesheet" href="/sarad/estilo/css/bootstrap.min.css">
        <link rel="stylesheet" href="/sarad/estilo/iconos/css/font-awesome.min.css">
    </head>
    <body>
        <main>
            <div class="text-white">
                <h5 class="display-2 fw-bold">Registros Anecdóticos</h5>
                <div class="table-responsive">
                    <table class="table">
                        <theader>
                            <tr>
                                <th></th>
                                <th>Nº</th>
                                <th>Tipo</th>
                                <th>Año</th>
                                <th>Curso</th>
                                <th>Turno</th>
                                <th>Sección</th>
                                <th>Alumno</th>
                                <th>Obs. Doc.</th>
                                <th>Obs. Coord.</th>
                                <th>Obs. Dir.</th>
                                <th>Estado</th>
                            </tr>
                        </theader>
                        <tbody>
                            <?php foreach($datos as $d){ ?>
                            <tr>
                                <td>
                                    <button class="btn input-group-text text-success" type="button" onclick="modificar('<?php echo $d['id_reg']; ?>');">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </td>
                                <td><?php echo $d['id_reg']; ?></td>
                                <td><?php echo $d['tr_descrip']; ?></td>
                                <td><?php echo $d['anho_descrip']; ?></td>
                                <td><?php echo $d['cur_descrip']; ?></td>
                                <td><?php echo $d['tur_descrip']; ?></td>
                                <td><?php echo $d['sec_descrip']; ?></td>
                                <td><?php echo $d['alumno']; ?></td>
                                <td><?php echo "<b>".$d['docente']."</b> ".$d['reg_docente']; ?></td>
                                <td><?php echo "<b>".$d['coordinador']."</b> ".$d['reg_coordinador']; ?><input id="modificar_reg_coordinador_<?php echo $d['id_reg']; ?>" value="<?php echo $d['reg_coordinador']; ?>" type="hidden"></td>
                                <td><?php echo "<b>".$d['directivo']."</b> ".$d['reg_directivo']; ?></td>
                                <td><?php echo $d['er_descrip']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-1 m-1 text-end">
                    <a href="/sarad/inicio" class="btn btn-lg btn-logout text-white"><i class="fa fa-arrow-left"></i> Volver</a>
                </div>
            </div>
            <input type="hidden" data-bs-toggle="modal" data-bs-target="#modal-modificar" id="btn-modal-modificar">
        </main>
        <div class="modal fade" id="modal-modificar" tabindex="-1" aria-labelledby="modal-modificar" aria-hidden="true">
            <form action="modificar.php" method="POST">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5">Actualizar</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-success">Observación</label>
                        <div class="input-group">
                            <span class="input-group-text text-success">
                                <i class="fa fa-user-circle-o"></i>
                            </span>
                            <textarea id="modificar_reg_coordinador" class="form-control" required="" name="reg_coordinador"></textarea>
                        </div>
                        <input type="hidden" class="form-control text-success" id="modificar_id_reg" name="id_reg">
                    </div>
                    <div class="modal-footer justify-content-between">
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
            function modificar(id_reg){
                $("#modificar_id_reg").val(id_reg);
                $("#modificar_reg_coordinador").val($("#modificar_reg_coordinador_"+ id_reg).val());
                $("#btn-modal-modificar").click();
            }
        </script>
    </body>
</html>
