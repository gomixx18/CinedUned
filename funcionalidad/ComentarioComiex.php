<?php

session_start();

$id = $_REQUEST["id"];
$comentario = $_REQUEST["comentario"];
$ie = $_REQUEST["ie"];
$etapa = $_REQUEST["etapa"];
$fecha = date("Y-m-d H:i:s");

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $sentenciaSQL = "replace into iecomentarioscomiex set etapa ='.$etapa', proyecto ='$ie', comentario ='$comentario', miembrocmoiex ='".$id."', fecha_modificacion= '".$fecha."'";;
    $resultado = mysqli_query($connection, $sentenciaSQL);
    echo $id.$ie.$etapa.$comentario;
    mysqli_close($connection);
}

