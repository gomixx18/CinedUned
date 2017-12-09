<?php
session_start();

if(isset($_POST["ced_director"])){
    $id = $_POST["ced_director"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "select * from tfgdirectores where id = '$id';";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        if(mysqli_num_rows($resultado) != 0){
            $data = mysqli_fetch_array($resultado);
            $nombre = $data["nombre"]." ".$data["apellido1"]." ".$data["apellido2"];
            echo json_encode(array('nombre' => $nombre, 'cedula' => $data['id']));
        }else{
            echo json_encode(array('error'=>'error'));
        }
        mysqli_close($connection);
    }
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

