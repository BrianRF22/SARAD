<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_alu = $_POST['id_alu'];
$consentimiento_padre = $_POST['consentimiento_padre'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update alumnos set consentimiento_padre = '$consentimiento_padre' where id_alu = $id_alu");
    $archivo = $_FILES['archivo_imagen']['name'];
    if (isset($archivo) && $archivo != "") {
        $tipo = $_FILES['archivo_imagen']['type'];
        if(strpos($tipo, "jpeg")){
            $extension = '.jpeg';
        }
        if(strpos($tipo, "jpg")){
            $extension = '.jpg';
        }
        if(strpos($tipo, "png")){
            $extension = '.png';
        }
        $temp = $_FILES['archivo_imagen']['tmp_name'];
        $archivo_nuevo = $_POST['id_alu'].$extension;
        if (move_uploaded_file($temp, '../../sarad/estilo/img/alumnos/'.$archivo_nuevo)) {
            chmod('../../sarad/estilo/img/alumnos/'.$archivo_nuevo, 0777);
        }
        $modificar = pg_query($conexion,"update alumnos set alu_imagen = '/sarad/estilo/img/alumnos/$archivo_nuevo' where id_alu = $id_alu");
    }
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from alumnos where id_alu = $id_alu");
}
header('Location: index.php');