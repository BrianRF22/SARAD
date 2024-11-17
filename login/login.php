<?php
session_start();
if(isset($_POST['usuario']) && isset($_POST['contrasena']) && isset($_POST['id_tipo_usu'])){
    include '../conexion.php';
    $conexion = Conexion::conectar();
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $id_tipo_usu = $_POST['id_tipo_usu'];
    $resultado = pg_fetch_all(pg_query("select * from usuarios where usu_nombre = trim('$usuario') and id_tipo_usu = $id_tipo_usu;"));
    if(empty($resultado)){
        $_SESSION['mensaje'] = "VERIFIQUE LOS DATOS INGRESADOS";
        header('Location: /sarad/login');
    }else{
        if($resultado[0]['usu_contrasenha'] == $contrasena){
            $_SESSION['id_tipo_usu'] = $resultado[0]['id_tipo_usu'];
            $_SESSION['id_usu'] = $resultado[0]['id_usu'];
            $_SESSION['id_per'] = $resultado[0]['id_per'];
            header('Location: /sarad/inicio');
        }else{
            $_SESSION['mensaje'] = "VERIFIQUE LOS DATOS INGRESADOS";
            header('Location: /sarad/login');
        }
    }
}else{
    $_SESSION['mensaje'] = "VERIFIQUE LOS DATOS INGRESADOS";
    $_SESSION['tipo_mensaje'] = "error";
    header('Location: /sarad/login');
}