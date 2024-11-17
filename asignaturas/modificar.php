<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_GET['operacion'];
$codigo = $_GET['codigo'];
$descripcion = $_GET['descripcion'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update asignaturas set asi_descrip = '$descripcion' where id_asi = $codigo");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from asignaturas where id_asi = $codigo");
}
header('Location: index.php');