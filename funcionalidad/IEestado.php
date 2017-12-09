<?php
require("email.php");
session_start();

$ie = $_REQUEST["ie"];
$estado = $_REQUEST["estado"];
$numero = $_REQUEST["etapa"];
$titulo = $_REQUEST["titulo"];
$coordinador = $_REQUEST["coordinador"];
$evaluadores = json_decode($_REQUEST["evaluadores"], true);
$investigadores = json_decode($_REQUEST["investigadores"], true);
$type = $_REQUEST["type"];
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    
    
    $consulta = "select estado from ieetapas where numero = $numero and proyecto = '$ie'";
    $query = mysqli_query($connection, $consulta);
    $data = mysqli_fetch_assoc($query);
    if($data['estado'] != "Aprobada" && $data['estado'] != "Aprobada con Observaciones"){
    $consulta = "update ieetapas set estado = \"$estado\" where numero = $numero and proyecto = '$ie'";
    $query = mysqli_query($connection, $consulta);

    $destinatarios = array();
        for ($index = 0; $index < count($investigadores); $index++) {
            array_push($destinatarios, $investigadores[$index]);
        }
        for ($index = 0; $index < count($evaluadores); $index++) {
            array_push($destinatarios, $evaluadores[$index]);
        }
        array_push($destinatarios, $coordinador);

        emailEtapa($titulo, $destinatarios, $numero, $estado, $type);
        echo $estado;
    }else{
        echo $data['estado'];
         mysqli_close($connection);
        exit();
    }
    mysqli_close($connection);
}


