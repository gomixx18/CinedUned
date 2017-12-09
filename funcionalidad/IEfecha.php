<?php

session_start();

if (isset($_REQUEST["fechaetapa"])) {
    $etapa = $_REQUEST["etapa"];
    $ie = $_REQUEST["ie"];
    $fecha = $_REQUEST["fecha"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $consulta = "UPDATE uned_db.ieetapas SET fechaEntrega='$fecha' WHERE numero='$etapa' and proyecto ='$ie'";
        $query = mysqli_query($connection, $consulta);
        mysqli_close($connection);
    }
    
} else {
    $ie = $_REQUEST["ie"];
    $fecha = $_REQUEST["fecha"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $consulta = "update uned_db.ieproyectos set fechaFinal ='$fecha' where codigo = '$ie'";
        $query = mysqli_query($connection, $consulta);
        mysqli_close($connection);
    }
}