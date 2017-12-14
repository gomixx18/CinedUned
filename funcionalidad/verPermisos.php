<?php

@session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$id = $_POST["id"];

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


$usuarioSesion = $_SESSION["user"];
$usuarioPermisos = $_SESSION['permisos'];



if($connection){
    $consulta ="Select * from uned_db.tfgasesoran where where asesor = '' and tfg = '' and estado = 1; ";
    mysqli_query($connection, $consulta);
}

echo $id;