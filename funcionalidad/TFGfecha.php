<?php

session_start();
if (isset($_REQUEST["fechaetapa"])) {
    $etapa = $_REQUEST["etapa"];
    $tfg = $_REQUEST["tfg"];
    $fecha = $_REQUEST["fecha"];
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $consulta = "UPDATE uned_db.tfgetapas SET fechaEntrega='$fecha' WHERE numero='$etapa' and tfg ='$tfg'";
        $query = mysqli_query($connection, $consulta);
        mysqli_close($connection);
    }
    
} else {
    
    $tfg = $_REQUEST["tfg"];
    $fecha = $_REQUEST["fecha"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $consulta = "update uned_db.tfg set fechaFinal ='$fecha' where codigo = '$tfg'";
        $query = mysqli_query($connection, $consulta);
        mysqli_close($connection);
    }
}