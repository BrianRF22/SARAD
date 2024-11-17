<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_cro = $_POST['id_cro'];
$id_asi = $_POST['id_asi'];
$id_dia = $_POST['id_dia'];
$id_doc = $_POST['id_doc'];
$hora_desde = $_POST['hora_desde'];
$hora_hasta = $_POST['hora_hasta'];
$agregar = pg_query($conexion,"insert into cronogramas_asignaturas_detalles(id_cro, id_asi, id_dia, id_doc, hora_desde, hora_hasta)values($id_cro, $id_asi, $id_dia, $id_doc, '$hora_desde', '$hora_hasta')");
header('Location: index.php?id_cro='.$id_cro.'&id_asi='.$id_asi);