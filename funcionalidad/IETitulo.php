<?php
session_start();

$proyecto = $_REQUEST["proyecto"];
$titulo = $_REQUEST["titulo"];

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $consulta = "update ieproyectos set titulo = '$titulo' where codigo = '$proyecto'";
    $query = mysqli_query($connection, $consulta);
    mysqli_close($connection);
}

echo 'Modificación del Título';