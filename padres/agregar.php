<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_per = $_POST['id_per'];
$agregar = pg_query($conexion,"insert into padres(id_padre, id_per)values((select coalesce(max(id_padre),0) + 1 from padres), $id_per)");
header('Location: index.php');