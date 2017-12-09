<?php

session_start();

$id = $_REQUEST["id"];
$comentario = $_REQUEST["comentario"];
$tfg = $_REQUEST["tfg"];
$etapa = $_REQUEST["etapa"];

$fecha = date("Y-m-d H:i:s");

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $sentenciaSQL = "replace into tfgcomentariosasesores set etapa = ".$etapa.",tfg =  '".$tfg."',"
            ." comentario ='".$comentario."', asesor ='".$id."', fecha_modificacion= '". $fecha."'";
    $resultado = mysqli_query($connection, $sentenciaSQL);
    echo $id.$tfg.$etapa.$comentario;
    mysqli_close($connection);
}


