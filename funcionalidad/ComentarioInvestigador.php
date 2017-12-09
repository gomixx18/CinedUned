<?php

session_start();

$id = $_REQUEST["id"];
$comentario = $_REQUEST["comentario"];
$ie = $_REQUEST["ie"];
$etapa = $_REQUEST["etapa"];

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $sentenciaSQL = "replace into iecomentariosinvestigador set etapa ='$etapa', proyecto ='$ie', comentario ='$comentario', investigador ='$id'";
    $resultado = mysqli_query($connection, $sentenciaSQL);
    echo $id.$ie.$etapa.$comentario;
    mysqli_close($connection);
}

