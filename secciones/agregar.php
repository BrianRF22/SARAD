<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$descripcion = $_POST['descripcion'];
$agregar = pg_query($conexion,"insert into secciones(id_seccion, sec_descrip)values((select coalesce(max(id_seccion),0) + 1 from secciones), '$descripcion')");
header('Location: index.php');