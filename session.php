<?php
session_start();
if(isset($_SESSION['id_usu'])){

}else{
    header('Location: /sarad/login');
}