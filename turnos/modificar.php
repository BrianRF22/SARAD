<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_GET['operacion'];
$codigo = $_GET['codigo'];
$descripcion = $_GET['descripcion'];
$hora_entrada = $_GET['hora_entrada'];
$hora_salida = $_GET['hora_salida'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update turnos set tur_descrip = '$descripcion', hora_entrada = '$hora_entrada', hora_salida = '$hora_salida' where id_tur = $codigo");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from turnos where id_tur = $codigo");
}
header('Location: index.php');