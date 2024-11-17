<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$descripcion = $_POST['descripcion'];
$agregar = pg_query($conexion,"insert into asignaturas(id_asi, asi_descrip)values((select coalesce(max(id_asi),0) + 1 from asignaturas), '$descripcion')");
header('Location: index.php');