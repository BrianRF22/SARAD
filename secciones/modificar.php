<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_GET['operacion'];
$codigo = $_GET['codigo'];
$descripcion = $_GET['descripcion'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update secciones set sec_descrip = '$descripcion' where id_seccion = $codigo");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from secciones where id_seccion = $codigo");
}
header('Location: index.php');