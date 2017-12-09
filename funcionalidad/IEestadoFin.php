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

echo $ie . $estado;
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    $consulta = "update  uned_db.ieproyectos set estado = '$estado' where codigo = '$ie'";
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
    
    mysqli_close($connection);
}
