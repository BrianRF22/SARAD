<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_GET['operacion'];
$id_per = $_GET['id_per'];
$per_ci = $_GET['per_ci'];
$per_nombre = $_GET['per_nombre'];
$per_apellido = $_GET['per_apellido'];
$fecha_nacimiento = $_GET['fecha_nacimiento'];
$celular = $_GET['celular'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update personas set per_ci = '$per_ci', per_nombre = '$per_nombre', per_apellido = '$per_apellido', fecha_nacimiento = '$fecha_nacimiento', celular = '$celular' where id_per = $id_per");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from personas where id_per = $id_per");
}
header('Location: index.php');