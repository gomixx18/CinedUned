<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Objeto{
    public $id_tfg;
    public $id_coment;
    public $contenido;
    public $usuario;
    public $padre;
    public $fecha;
}

//error_reporting(E_ALL & ~E_WARNING);
session_start();
$usuarioNombre ="Bryan"; //$_SESSION['user']->getNombre(); 
$usuario = 1;// $_SESSION['user']->getId();
$tfg = $_GET["tfg"];
$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
$asesor1;
$asesor2;

ObtenerAsesores($tfg);

if($connection1){
    
    $Q="SELECT id_tfg,id_coment,contenido FROM comentarios_tfg";
    $senten="SELECT id_coment,contenido,id_tfg,usuario,padre,fecha FROM uned_db.comentarios_tfg WHERE id_tfg= '" . $tfg . "'";
    $result1 = mysqli_query($connection1,$senten);//"SELECT id_coment,contenido FROM uned_db.comentarios_tfg WHERE id_tfg=");
    
    
    
    
    if(!$result1){
        //echo 'No sirve';
    }
    else{
        $pila = array();
        //echo $a."/".$m."/".$d." ".$h.":".$min.":".$s; //->format('Y-m-d H:i:s');
        //$ingresar="INSERT INTO uned_db.comentarios_tfg(id_tfg, id_coment, contenido, usuario, fecha) VALUES ('TFG-5-2016-003-1-01', 'c4', 'Muy buenas tardes', 'Cristhian', '". $fecha ."') ";
        //mysqli_query($connection1, $ingresar);
        //echo 'Ya sirve';
        //echo json_encode($result1);
        
        
    }
    
        $array = array();
        while ($coment = mysqli_fetch_assoc($result1)) {
            $array[] = array(
                             'profile_picture_url' => 'https://viima-app.s3.amazonaws.com/media/user_profiles/user-icon.png',
                             'id'=>$coment["id_coment"],'parent'=>$coment['padre'],
                             'created'=>$coment["fecha"],'content'=>$coment['contenido'],
                             'fullname'=>obtenerUsuario($coment['usuario'], $tfg));
    }
        echo json_encode($array);
       
    mysqli_free_result($result1);
    //Cerras coneccion
    mysqli_close($connection1);
}
else{
    echo 'No se conecto';
}


function obtenerUsuario($id_usuario,$tfg){
    global $connection1;
    global $usuario;
    global $usuarioNombre;
    global $asesor1;
    global $asesor2;
    
    if($usuario == $id_usuario){
        return $usuarioNombre;
    }
    if($asesor1 == $id_usuario){
        return 'asesor 1';
    }
    
    if($asesor2 == $id_usuario){
        return 'asesor 2';
    }
    
    $senten="SELECT  directores.nombre FROM tfgdirectores directores, tfg proyecto 
            where directores.id = proyecto.directortfg and proyecto.directortfg = '".$id_usuario."' and proyecto.codigo = '".$tfg."'";
    $result1 = mysqli_query($connection1,$senten);
    if($result1){
        return 'Director TFG';
    }
}


function ObtenerAsesores($codigoTfg){
    global $connection1;
    global $asesor1;
    global $asesor2;
    
    $senten="select asesor from uned_db.tfgasesoran where tfg = '".$codigoTfg ."' order by asesor asc;";
    $result1 = mysqli_query($connection1,$senten);
    //echo $codigoTfg."     " . mysqli_num_rows($result1)."         ";
    if($result1){
        if(mysqli_num_rows($result1) == 1){
            
            $row = mysqli_fetch_row($result1);
            $asesor1 = $row[0];
            
        }else {
            
            $row = mysqli_fetch_row($result1);
            $asesor1 = $row[0];
            $row = mysqli_fetch_row($result1);
            $asesor2 = $row[0];
        }
    }
    
}
