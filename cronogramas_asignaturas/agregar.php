<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_cro = $_POST['id_cro'];
$id_asi = $_POST['id_asi'];
$carga_horaria = $_POST['carga_horaria'];
$agregar = pg_query($conexion,"insert into cronogramas_asignaturas(id_cro, id_asi, carga_horaria)values($id_cro, $id_asi, '$carga_horaria')");
header('Location: index.php?id_cro='.$id_cro);