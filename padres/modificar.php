<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_padre = $_POST['id_padre'];
if($operacion == 'MODIFICAR'){
    
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from padres where id_padre = $id_padre");
}
header('Location: index.php');