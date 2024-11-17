<?php include '../conexion.php';
$conexion = Conexion::conectar();
$datos = pg_fetch_all(pg_query($conexion, "select i.*, a.id_per, p.per_nombre, p.per_apellido, p.per_ci,"
    . " an.anho_descrip, tu.tur_descrip, cu.cur_descrip, se.sec_descrip "
    . " from inscripcion i, alumnos a, personas p, anhos an, turnos tu, cursos cu, secciones se "
    . " where p.id_per = a.id_per and a.id_alu = i.id_alu "
    . " and se.id_seccion = i.id_seccion "
    . " and cu.id_cur = i.id_cur "
    . " and tu.id_tur = i.id_tur "
    . " and an.id_anho = i.id_anho "
    . " order by an.anho_descrip, tu.tur_descrip, cu.cur_descrip, se.sec_descrip, p.per_nombre, p.per_apellido, p.per_ci"));
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

        /* Centramos el botón Volver */
        .btn-volver {
            display: flex;
            justify-content: center; 
            margin-top: 20px;
        }
        
        .border-success {
            border-color: #28a745 !important;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .text-success {
            color: #28a745 !important;
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
        <div class="text-white">
            <h5 class="display-2 fw-bold">Inscripciones
                <button type="button" class="btn btn-lg btn-logout text-white" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Año</th>
                            <th>Turno</th>
                            <th>Curso</th>
                            <th>Sección</th>
                            <th>C.I.</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $d){ ?>
                        <tr>
                            <td>
                                <button class="btn input-group-text text-primary" type="button" onclick="">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </td>
                            <td><?php echo $d['anho_descrip']; ?></td>
                            <td><?php echo $d['tur_descrip']; ?></td>
                            <td><?php echo $d['cur_descrip']; ?></td>
                            <td><?php echo $d['sec_descrip']; ?></td>
                            <td><?php echo $d['per_ci']; ?></td>
                            <td><?php echo $d['per_nombre']; ?></td>
                            <td><?php echo $d['per_apellido']; ?></td>
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
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar" aria-hidden="true">
        <form action="agregar.php" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Agregar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php 
                            $anhos = pg_fetch_all(pg_query($conexion, "select * from anhos order by anho_descrip"));
                            $turnos = pg_fetch_all(pg_query($conexion, "select * from turnos order by tur_descrip"));
                            $cursos = pg_fetch_all(pg_query($conexion, "select * from cursos order by cur_descrip"));
                            $secciones = pg_fetch_all(pg_query($conexion, "select * from secciones order by sec_descrip"));
                            $alumnos = pg_fetch_all(pg_query($conexion, "select a.*, p.per_nombre, p.per_apellido, p.per_ci from alumnos a, personas p where p.id_per = a.id_per order by p.per_nombre, p.per_apellido, p.per_ci"));
                        ?>
                        <label class="text-success">Año</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-address-book-o"></i>
                            </span>
                            <select class="form-control" name="id_anho">
                                <?php foreach($anhos as $a){ ?>
                                    <option value="<?php echo $a['id_anho']; ?>"><?php echo $a['anho_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Turno</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            <select class="form-control" name="id_tur">
                                <?php foreach($turnos as $t){ ?>
                                    <option value="<?php echo $t['id_tur']; ?>"><?php echo $t['tur_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Curso</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-book"></i>
                            </span>
                            <select class="form-control" name="id_cur">
                                <?php foreach($cursos as $c){ ?>
                                    <option value="<?php echo $c['id_cur']; ?>"><?php echo $c['cur_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Sección</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-bookmark"></i>
                            </span>
                            <select class="form-control" name="id_seccion">
                                <?php foreach($secciones as $s){ ?>
                                    <option value="<?php echo $s['id_seccion']; ?>"><?php echo $s['sec_descrip']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                        <label class="text-success">Alumno</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary">
                                <i class="fa fa-user"></i>
                            </span>
                            <select class="form-control" name="id_alu">
                                <?php foreach($alumnos as $al){ ?>
                                    <option value="<?php echo $al['id_alu']; ?>"><?php echo $al['per_ci']." - ".$al['per_nombre']." ".$al['per_apellido']; ?></option>
                                <?php } ?>
                            </select>
                        </div><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/sarad/estilo/js/bootstrap.bundle.min.js"></script>
</body>
</html>
