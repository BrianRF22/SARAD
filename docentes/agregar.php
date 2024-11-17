<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$id_per = $_POST['id_per'];
$agregar = pg_query($conexion,"insert into docentes(id_doc, id_per)values((select coalesce(max(id_doc),0) + 1 from docentes), $id_per)");
header('Location: index.php');