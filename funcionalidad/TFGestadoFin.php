<?php

require("email.php");
session_start();

$tfg = $_REQUEST["tfg"];
$estado = $_REQUEST["estado"];
$etapa = $_REQUEST["etapa"];

$titulo = $_REQUEST["titulo"];
$estCorreos = json_decode($_REQUEST["estCorreos"], true);
$director = $_REQUEST["director"];
$asesores = json_decode($_REQUEST["asesores"], true);
$type = 2;

echo $tfg . $estado;
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $consulta = "update  uned_db.tfg set estado = '$estado' where codigo = '$tfg'";
    $query = mysqli_query($connection, $consulta);
    mysqli_close($connection);

    if ($estado == 'Aprobado para defensa') {
        $destinatarios = array();

        for ($index = 0; $index < count($asesores); $index++) {
            array_push($destinatarios, $asesores[$index]);
        }
        for ($index = 0; $index < count($estCorreos); $index++) {
            array_push($destinatarios, $estCorreos[$index]);
        }
        array_push($destinatarios, $director);
        
        emailEtapa($titulo, $destinatarios, $etapa, $estado, $type);
    }
}
