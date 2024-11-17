<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_anho = $_POST['id_anho'];
$id_tur = $_POST['id_tur'];
$id_cur = $_POST['id_cur'];
$id_seccion = $_POST['id_seccion'];
$id_alu = $_POST['id_alu'];
$agregar = pg_query($conexion,"insert into inscripcion(id_anho, id_tur, id_cur, id_seccion, id_alu)values($id_anho, $id_tur, $id_cur, $id_seccion, $id_alu)");
header('Location: index.php');