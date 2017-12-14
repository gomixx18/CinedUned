<?php
//error_reporting(E_ALL & ~E_WARNING);
session_start();
$usuarioNombre = $_POST["nomUsuario"];
$usuario = $_POST["usuario"];
$tfg = $_POST["tfg"];
$fase = $_POST["fase"];
$etapa = $_POST["etapa"];
$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
$asesor1;
$asesor2;

ObtenerAsesores($tfg);

if($connection1){
    
    $senten="SELECT id_coment,contenido,id_tfg,usuario,padre,fecha FROM uned_db.comentarios_tfg WHERE id_tfg= '" . $tfg . "' and etapa =". $etapa ." and fase =" . $fase . ";";
    $result1 = mysqli_query($connection1,$senten);//"SELECT id_coment,contenido FROM uned_db.comentarios_tfg WHERE id_tfg=");
    if(!$result1){
        echo 'ready';
    }
        $array = array();
        while ($coment = mysqli_fetch_assoc($result1)) {
            $array[] = array(
                             'profile_picture_url' => 'img/user-icon.png',
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
    if($id_usuario == 'admin'){
        return 'Administrador';
    }


    $senten="SELECT * FROM tfgmiembroscomision comision
    where comision.id = '".$id_usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    if($result1){
        return "Comisión TFG";
    }

    $senten="SELECT concat(directores.nombre,' ',directores.apellido1,' ',directores.apellido2) FROM tfgdirectores directores, tfg proyecto 
            where directores.id = proyecto.directortfg and proyecto.directortfg = '".$id_usuario."' and proyecto.codigo = '".$tfg."'";
    $result1 = mysqli_query($connection1,$senten);
    if($result1){
        //return $result1["nombre"];
        return "Director";
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
