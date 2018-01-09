<?php
//error_reporting(E_ALL & ~E_WARNING);
session_start();
$usuarioNombre = $_POST["nomUsuario"];
$usuario = $_POST["usuario"];
$proyecto = $_POST["proyecto"];

$etapa = $_POST["etapa"];
$connection1 = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
$asesor1;
$asesor2;

ObtenerEvaluadores($proyecto);

if($connection1){
    
    $senten="SELECT id_coment,contenido,id_proyecto,usuario,padre,fecha FROM uned_db.comentarios_ext_inv WHERE id_proyecto= '" . $proyecto . "' and etapa =". $etapa .";";
    $result1 = mysqli_query($connection1,$senten);
    if(!$result1){
        echo 'ready';
    }
        $array = array();
        while ($coment = mysqli_fetch_assoc($result1)) {
            $array[] = array(
                             'profile_picture_url' => 'img/user-icon.png',
                             'id'=>$coment["id_coment"],'parent'=>$coment['padre'],
                             'created'=>$coment["fecha"],'content'=>$coment['contenido'],
                             'fullname'=>obtenerUsuario($coment['usuario'], $proyecto));
    }
    echo json_encode($array);
       
    mysqli_free_result($result1);
    
    mysqli_close($connection1);
}
else{
    echo 'No se conecto';
}


function obtenerUsuario($id_usuario,$proyecto){
    global $connection1;
    global $usuario;
    global $usuarioNombre;
    global $Evaluador1;
    global $Evaluador2;
    $miembroComision = false ;

    $senten="SELECT * FROM iemiembroscomiex comision
    where comision.id = '".$usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows) != 0){

        $miembroComision = true;
    }
    if($usuario == $id_usuario){
            return "Tú";
    }
    if($Evaluador1[0] == $id_usuario){
        if($miembroComision || $usuario == 'admin'){
            return "Evaluador 1: ".$Evaluador1[1]." " .$Evaluador1[2];
        }else{
            return 'Evaluador 1';
        }
    }
    
    if($Evaluador2[0] == $id_usuario){
        if($miembroComision || $usuario == 'admin'){
            return "Evaluador 2: ". $Evaluador2[1]." " .$Evaluador2[2] ;
        }else{
            return 'Evaluador 2';            
        }
    }
    if($id_usuario == 'admin'){
        return 'Administrador';
    }
    
    $senten="select concat(inv.nombre,' ',inv.apellido1) as Nombre from ieinvestigan i join ieinvestigadores inv on i.investigador=inv.id 
    where i.proyecto='".$proyecto."' and inv.id='".$id_usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows)  != 0){
        return "Investigador: ".$rows[0];
        
    }

    $senten="SELECT * FROM iemiembroscomiex comision
    where comision.id = '".$id_usuario."'";
    $result1 = mysqli_query($connection1,$senten);
    $rows = mysqli_fetch_array($result1);
    if(count($rows) != 0){
        return "Miembro comisión";
    }
}


function ObtenerEvaluadores($proyecto){
    global $connection1;
    global $Evaluador1;
    global $Evaluador2;
    
    $senten="select  ieevaluadores.* from ieevaluan, ieevaluadores where ieevaluan.proyecto  = '".$proyecto."' and ieevaluadores.id = ieevaluan.evaluador order by evaluador asc;";
    $result1 = mysqli_query($connection1,$senten);
    if($result1){
        if(mysqli_num_rows($result1) == 1){ 
            $row = mysqli_fetch_row($result1);
            $Evaluador1 = array($row[0],$row[1],$row[2]);
        }else {
            $row = mysqli_fetch_row($result1);
            $Evaluador1 =array($row[0],$row[1],$row[2]);
            $row = mysqli_fetch_row($result1);
            $Evaluador2 = array($row[0],$row[1],$row[2]);
        }
    }
    
}
