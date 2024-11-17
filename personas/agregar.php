<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$per_ci = $_POST['per_ci'];
$per_nombre = $_POST['per_nombre'];
$per_apellido = $_POST['per_apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$celular = $_POST['celular'];
$agregar = pg_query($conexion,"insert into personas(id_per, per_ci, per_nombre, per_apellido, fecha_nacimiento, celular)values((select coalesce(max(id_per),0) + 1 from personas), '$per_ci', '$per_nombre', '$per_apellido', '$fecha_nacimiento', '$celular')");
header('Location: index.php');