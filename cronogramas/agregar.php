<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_cro = $_POST['id_cro'];
$id_anho = $_POST['id_anho'];
$id_tur = $_POST['id_tur'];
$id_cur = $_POST['id_cur'];
$id_seccion = $_POST['id_seccion'];
$agregar = pg_query($conexion,"insert into cronogramas(id_cro, id_anho, id_tur, id_cur, id_seccion)values((select coalesce(max(id_cro),0) + 1 from cronogramas), $id_anho, $id_tur, $id_cur, $id_seccion)");
header('Location: index.php');