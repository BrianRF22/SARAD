<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$descripcion = $_POST['descripcion'];
$agregar = pg_query($conexion,"insert into anhos(id_anho, anho_descrip)values((select coalesce(max(id_anho),0) + 1 from anhos), '$descripcion')");
header('Location: index.php');