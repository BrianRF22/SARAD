<?php
session_start();
$id_per = $_SESSION['id_per'];
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_reg = $_POST['id_reg'];
$reg_coordinador = $_POST['reg_coordinador'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion, "update registros set id_er = 2, id_per_cor = $id_per, reg_coordinador = '$reg_coordinador' where id_reg = $id_reg and (id_er = 1 or id_er = 2 and id_per_cor = $id_per)");
}
header('Location: index.php');