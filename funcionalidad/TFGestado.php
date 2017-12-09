<?php



require("email.php");
session_start();

$tfg = $_REQUEST["tfg"];
$estado = $_REQUEST["estado"];
$numero = $_REQUEST["etapa"];
$fecha_actual = date("y/m/d");

$titulo = $_REQUEST["titulo"];
$etapa = $_REQUEST["etapa"];
$estCorreos = json_decode($_REQUEST["estCorreos"], true);
$director = $_REQUEST["director"];
$asesores = json_decode($_REQUEST["asesores"], true);
$type = 1;



$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    
    $consulta = "update tfgetapas set estado = \"$estado\", fechaAprobacion ='$fecha_actual'  where numero = $numero and tfg = '$tfg'";
    $query = mysqli_query($connection, $consulta);
       

        $destinatarios = array();
        for ($index = 0; $index < count($asesores); $index++) {
            array_push($destinatarios, $asesores[$index]);
        }
        for ($index = 0; $index < count($estCorreos); $index++) {
            array_push($destinatarios, $estCorreos[$index]);
        }
        array_push($destinatarios, $director);

        emailEtapa($titulo, $destinatarios, $etapa, $estado, $type);
        
        
        echo $estado;
         mysqli_close($connection);
        exit();
    
    //Enviar correo al cambiar estado de la etapa

    
    

    mysqli_close($connection);
}
else{
    exit();
}

