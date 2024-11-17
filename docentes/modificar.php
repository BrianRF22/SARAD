<?php
include '../conexion.php';
$conexion = Conexion::conectar();
$operacion = $_POST['operacion'];
$id_doc = $_POST['id_doc'];
$consentimiento_docente = $_POST['consentimiento_docente'];
if($operacion == 'MODIFICAR'){
    $modificar = pg_query($conexion,"update docentes set consentimiento_docente = '$consentimiento_docente' where id_doc = $id_doc");
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
        $archivo_nuevo = $_POST['id_doc'].$extension;
        if (move_uploaded_file($temp, '../../sarad/estilo/img/docentes/'.$archivo_nuevo)) {
            chmod('../../sarad/estilo/img/docentes/'.$archivo_nuevo, 0777);
        }
        $modificar = pg_query($conexion,"update docentes set doc_imagen = '/sarad/estilo/img/docentes/$archivo_nuevo' where id_doc = $id_doc");
    }
}
if($operacion == 'ELIMINAR'){
    $eliminar = pg_query($conexion,"delete from docentes where id_doc = $id_doc");
}
header('Location: index.php');