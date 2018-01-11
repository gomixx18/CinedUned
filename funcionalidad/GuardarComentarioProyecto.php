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
$proyecto = $_POST['proyecto'];


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
}
 else {
    echo "Error de conexión";
}

?>