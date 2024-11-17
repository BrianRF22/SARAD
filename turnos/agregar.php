<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$descripcion = $_POST['descripcion'];
$hora_entrada = $_POST['hora_entrada'];
$hora_salida = $_POST['hora_salida'];
$agregar = pg_query($conexion,"insert into turnos(id_tur, tur_descrip, hora_entrada, hora_salida)values((select coalesce(max(id_tur),0) + 1 from turnos), '$descripcion', '$hora_entrada', '$hora_salida')");
header('Location: index.php');