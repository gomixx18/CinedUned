<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(-1);
require("email.php");
session_start();

$usuario = $_POST["usuario"];
$json = $_POST["json"];
$proyecto = $_POST['proyecto'];

$contenidoCorreo="";
$etapa = $_POST['etapa'];

$decode= json_decode(json_encode($json), true);

echo json_encode($json);


$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");





$fecha= date('Y-m-d H:i:s ');


if($decode['parent']!=""){
    $padre = $decode['parent'];
    $ingresar="INSERT INTO uned_db.comentarios_ext_inv(id_proyecto, id_coment, contenido, padre, usuario, fecha, etapa) VALUES ('". $proyecto . "','". $decode['id'] ."','". $decode['content'] ."','". $padre ."','" . $usuario ."','". $fecha ."','". $etapa ."') ";

}
else{
    $ingresar="INSERT INTO uned_db.comentarios_ext_inv(id_proyecto, id_coment, contenido, usuario, fecha, etapa) VALUES ('". $proyecto . "','". $decode['id'] ."','". $decode['content'] ."','" . $usuario ."','". $fecha ."','". $etapa ."') ";
}


if($connection1){
    
    mysqli_query($connection1, $ingresar);
    $senten="SELECT i.nombre,
    i.apellido1,
    i.apellido2,
    i.correo,
    p.titulo
    
    from ieinvestigadores i join ieinvestigan inv
    on i.id=inv.investigador
    join ieproyectos p 
    on p.codigo=inv.proyecto
    where p.codigo='" . $proyecto . "';";
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