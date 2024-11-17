<?php
session_start();
$id_per = $_SESSION['id_per'];
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_reg = $_POST['id_reg'];
$reg_directivo = $_POST['reg_directivo'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion, "update registros set id_er = 3, id_per_dir = $id_per, reg_directivo = '$reg_directivo' where id_reg = $id_reg and (id_er = 2 or id_er = 3 and id_per_dir = $id_per)");
}
header('Location: index.php');