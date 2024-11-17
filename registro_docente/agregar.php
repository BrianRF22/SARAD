<?php
session_start();
$id_per = $_SESSION['id_per'];
include '../conexion.php';
$conexion = Conexion::conectar();
$id_tr = $_POST['id_tr'];
$inscripcion = explode("_", $_POST['inscripcion']);
$id_anho = $inscripcion[0];
$id_tur = $inscripcion[1];
$id_cur = $inscripcion[2];
$id_seccion = $inscripcion[3];
$id_alu = $inscripcion[4];
$reg_docente = $_POST['reg_docente'];
$agregar = pg_query($conexion,"insert into registros(id_reg, id_tr, id_doc, id_alu, id_anho, id_tur, id_cur, id_seccion, reg_docente, id_er)
values((select coalesce(max(id_reg), 0) + 1 from registros), $id_tr, (select id_doc from docentes d where d.id_per = $id_per), $id_alu, $id_anho, $id_tur, $id_cur, $id_seccion, '$reg_docente', 1);");
header('Location: index.php');