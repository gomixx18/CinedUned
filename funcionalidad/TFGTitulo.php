<?php
session_start();

$tfg = $_REQUEST["tfg"];
$titulo = $_REQUEST["titulo"];

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $consulta = "update uned_db.tfg set titulo = '$titulo' where codigo = '$tfg'";
    $query = mysqli_query($connection, $consulta);
    mysqli_close($connection);
}

echo 'Modificación del Título';