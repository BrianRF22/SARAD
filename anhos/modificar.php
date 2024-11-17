<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update anhos set anho_descrip = '$descripcion' where id_anho = $codigo");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from anhos where id_anho = $codigo");
}
header('Location: index.php');