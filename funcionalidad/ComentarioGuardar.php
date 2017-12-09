<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(-1);
session_start();

$usuarioSesion = "Ramirez"; //$_SESSION['user']->getNombre(); 
$usuario = 1;//$_SESSION['user']->getId();
$tfg="TFG-3-2016-003-1-01";
$etapa=1;
$fase=1;



$json=$_POST["json"];

//$code=  json_encode($json);

$decode= json_decode(json_encode($json), true);
//echo $decode[0]['administrador'];
echo json_encode($json);


$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


//$date2= $decode['created'];

//new DateTime('2000-01-01');
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
    echo "Guardado";
}
 else {
    echo "Error de conexión";
}

?>