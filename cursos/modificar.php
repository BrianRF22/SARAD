<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_cur = $_POST['id_cur'];
$cur_descrip = $_POST['cur_descrip'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update cursos set cur_descrip = '$cur_descrip' where id_cur = $id_cur");
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from cursos where id_cur = $id_cur");
}
header('Location: index.php');