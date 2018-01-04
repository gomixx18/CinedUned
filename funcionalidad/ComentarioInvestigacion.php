<?php
//error_reporting(E_ALL & ~E_WARNING);
session_start();
$usuarioNombre = $_POST["nomUsuario"];
$usuario = $_POST["usuario"];
$extension = $_POST["extension"];
$fase = $_POST["fase"];
$etapa = $_POST["etapa"];
$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
$asesor1;
$asesor2;

//ObtenerAsesores($tfg);

if($connection1){
    
    $senten="SELECT id_coment,contenido,id_extension,usuario,padre,fecha FROM uned_db.comentarios_extension WHERE id_extension= '" . $extension . "' and etapa =". $etapa .";";
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


function obtenerUsuario($id_usuario,$extension){
    global $connection1;
    global $usuario;
    global $usuarioNombre;
    global $asesor1;
    global $asesor2;
    $miembroComision = false ;

    $senten="SELECT * FROM tfgmiembroscomision comision
    where comision.id = '".$usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows) != 0){

        $miembroComision = true;
    }
    if($usuario == $id_usuario){
            return "Tú";
    }
    if($asesor1[0] == $id_usuario){
        if($miembroComision || $usuario == 'admin'){
            return "Asesor 1: ".$asesor1[1]." " .$asesor1[2];
        }else{
            return 'asesor 1';
        }
    }
    
    if($asesor2[0] == $id_usuario){
        if($miembroComision || $usuario == 'admin'){
            return "Asesor 2: ". $asesor2[1]." " .$asesor2[2] ;
        }else{
            return 'Asesor 2';            
        }
    }
    if($id_usuario == 'admin'){
        return 'Administrador';
    }

    $senten="SELECT concat(directores.nombre,' ',directores.apellido1,' ',directores.apellido2) FROM tfgdirectores directores, tfg proyecto 
    where directores.id = proyecto.directortfg and proyecto.directortfg = '".$id_usuario."' and proyecto.codigo = '".$tfg."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows)  != 0){
        return "Director TFG: ".$rows[0];
        //return "Director TFG";
    }

    $senten="SELECT * FROM tfgmiembroscomision comision
    where comision.id = '".$id_usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows) != 0){
        return "Miembro comisión TFG";
    }
}


function ObtenerAsesores($codigoTfg){
    global $connection1;
    global $asesor1;
    global $asesor2;
    
    $senten="select  tfgasesores.* from tfgasesoran, tfgasesores where tfgasesoran.tfg  = '".$codigoTfg."' and tfgasesores.id = tfgasesoran.asesor order by asesor asc;";
    $result1 = mysqli_query($connection1,$senten);
    if($result1){
        if(mysqli_num_rows($result1) == 1){ 
            $row = mysqli_fetch_row($result1);
            $asesor1 = array($row[0],$row[1],$row[2]);
        }else {
            $row = mysqli_fetch_row($result1);
            $asesor1 =array($row[0],$row[1],$row[2]);
            $row = mysqli_fetch_row($result1);
            $asesor2 = array($row[0],$row[1],$row[2]);
        }
    }
    
}
