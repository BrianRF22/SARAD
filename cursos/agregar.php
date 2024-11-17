<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$cur_descrip = $_POST['cur_descrip'];
$agregar = pg_query($conexion,"insert into cursos(id_cur, cur_descrip)values((select coalesce(max(id_cur),0) + 1 from cursos), '$cur_descrip')");
header('Location: index.php');