<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_per = $_POST['id_per'];
$id_padre = $_POST['id_padre'];
$agregar = pg_query($conexion,"insert into alumnos(id_alu, id_per, id_padre)values((select coalesce(max(id_alu),0) + 1 from alumnos), $id_per, $id_padre)");
header('Location: index.php');