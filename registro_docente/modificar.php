<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_reg = $_POST['id_reg'];
$reg_docente = $_POST['reg_docente'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion, "update registros set reg_docente = '$reg_docente' where id_reg = $id_reg and id_er = 1");
}
header('Location: index.php');