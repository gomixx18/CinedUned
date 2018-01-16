<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(-1);
session_start();

$usuario = $_POST["usuario"];
$json = $_POST["json"];
$tfg = $_POST['tfg'];

$fase = $_POST['fase'];
$etapa = $_POST['etapa'];

$decode= json_decode(json_encode($json), true);

echo json_encode($json);


$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

$fecha= date('Y-m-d H:i:s ');


if($decode['parent']!=""){
    $padre = $decode['parent'];
    $ingresar="INSERT INTO uned_db.comentarios_tfg(id_tfg, id_coment, contenido, padre, usuario, fecha, fase, etapa) VALUES ('". $tfg . "','". $decode['id'] ."','". $decode['content'] ."','". $padre ."','" . $usuario ."','". $fecha ."','".$fase ."','". $etapa ."') ";

}
else{
    $ingresar="INSERT INTO uned_db.comentarios_tfg(id_tfg, id_coment, contenido, usuario, fecha, fase, etapa) VALUES ('". $tfg . "','". $decode['id'] ."','". $decode['content'] ."','" . $usuario ."','". $fecha ."','".$fase ."','". $etapa ."') ";
}


if($connection1){
    
    mysqli_query($connection1, $ingresar);
    $senten="SELECT t.titulo,
    e.correo

from tfg t join tfgencargados e
    on t.encargadotfg=e.id
where t.codigo='" . $tfg . "';";
    $result1 = mysqli_query($connection1,$senten);
    if(!$result1){
        echo 'ready';
    }
    else{
        $array = array();
        $subject="Agregaron un comentario a un proyecto";
        $wordwrap="normal";
        while ($coment = mysqli_fetch_assoc($result1)) {
            $body="El usuario '" . $usuario ."' ha agregado un comentario al proyecto '" . $coment["titulo"] ."'";
            sendMail($coment["correo"], $subject, $body, $wordwrap);
        }
        mysqli_free_result($result1);
        
        mysqli_close($connection1);      
    }
}
 else {
    echo "Error de conexión";
}

?>