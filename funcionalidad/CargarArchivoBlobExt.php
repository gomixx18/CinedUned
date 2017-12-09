<?php
include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';
require_once '..\WindowsAzure\WindowsAzure.php';
require 'email.php';
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

@session_start();
date_default_timezone_set('America/Costa_Rica');
$usuarioPermisos = $_SESSION['permisos'];
$usuario = $_SESSION['user']->getId();
$codigo = $_POST['codigoProyecto'];
$etapa = $_POST['etapa'];
$tipo = $_POST['tipo'];
$titulo = $_POST['titulo'];
$isInvestigacion = $_POST['isInvestigacion'];
$arrayCorreosIE = array();


if(isset($_FILES['archivo']['name'])){
  $nombre_archivo = $_FILES['archivo']['name'];
}

if(!$codigo  || !$etapa || !$tipo || !$isInvestigacion){
    $_SESSION["error"] = "¡Hubo un error al cargar el archivo! POST_VARS";
    header("Location: ../navegacion/500.php");
}
$ubicacionArchivo = $codigo.'/ETAPA '.$etapa.'/'.$tipo.'/'.$usuario.'/';



try{
$connectionString = 'DefaultEndpointsProtocol=https;AccountName=almacenamientocined;AccountKey=7EvXeLf3f7iU4OcS0RgzDBfmoUO6eSVO44KEQhuBtre6NDZXvzJDfWBa/C+dCtrYvDhlkVQOHZVxN/IjglEG6A==;BlobEndpoint=https://almacenamientocined.blob.core.windows.net/';
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
}
catch (RuntimeException $e){
    $_SESSION["error"] = "¡Hubo un error al cargar el archivo! Conexion Rechazada BD";
    header("Location: ../navegacion/500.php");
    exit();
}

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
if (!$connection) {
     $_SESSION["error"] = "¡Hubo un error al cargar el archivo! Conexión a base de datos";
    header("Location: ../navegacion/500.php");
    exit();
}

 if ($tipo == "archivoInvestigador") {      
        existeInvestigador($nombre_archivo, $codigo, $etapa, $usuario);
    }
    if($tipo == 'archivoEvaluador'){
        existeEvaluador($nombre_archivo, $codigo, $etapa, $usuario);
    }
    if($tipo == 'archivoComiex'){
        existeComision($nombre_archivo, $codigo, $etapa, $usuario);
    }


$archivo_bases = "https://almacenamientocined.blob.core.windows.net/investigacionyextension/".$ubicacionArchivo.$nombre_archivo;
$content = fopen($_FILES['archivo']["tmp_name"], "r");
if(!$content){
   $_SESSION["error"] = "¡Hubo un error al cargar el archivo! FOPEN";
   header("Location: ../navegacion/500.php");
   exit();
}
$blob_name = $ubicacionArchivo.$nombre_archivo;

try {
    //Upload blob
    $blobRestProxy->createBlockBlob("investigacionyextension",$blob_name, $content);
    $dt = new DateTime();
    $fecha = $dt->format('Y-m-d H:i:s');
    if ($tipo == "archivoEvaluador") {
        $consulta = "INSERT INTO iearchivosevaluadores (evaluador, etapa, proyecto, ruta, fecha, nom_archivo) VALUES ( " . $usuario . " , " . $etapa .
                " , '" . $codigo . "','" . $archivo_bases . "' ,'" . $fecha ."','".$nombre_archivo."');";
    }
    if($tipo == 'archivoInvestigador'){
     $consulta  = "INSERT INTO iearchivosinvestigadores (investigador, etapa, proyecto, ruta, fecha, nom_archivo) VALUES ( ".$usuario." , ".$etapa.
                 " ,'".$codigo."','".$archivo_bases."','".$fecha."','".$nombre_archivo."');";
    }
    if($tipo == 'archivoComiex'){
       $consulta  = "INSERT INTO iearchivoscomiex (miembrocomiex, etapa, proyecto, ruta, fecha, nom_archivo) VALUES ( ".$usuario." , ".$etapa.
                 " , '".$codigo."','".$archivo_bases."' ,'".$fecha."','".$nombre_archivo."');";
    }
  
    $resultado = mysqli_query($connection, $consulta);
    
    if($resultado){
        
         //investigadores
            $sentenciaInvestigadoresIE = "select ieinvestigadores.correo from ieproyectos, ieinvestigadores, ieinvestigan
                                    where ieproyectos.codigo = ieinvestigan.proyecto and ieinvestigadores.id = ieinvestigan.investigador and
                                    ieinvestigan.estado= 1 and ieproyectos.codigo = '". $codigo ."'";
            $resultadoInvestigadoresIE = mysqli_query($connection, $sentenciaInvestigadoresIE);
            while ($data2IE = mysqli_fetch_assoc($resultadoInvestigadoresIE)) {
                array_push($arrayCorreosIE, $data2IE["correo"]);
            }
            
            //coordinador
            $sentenciaCoordiandorIE = "select iecoordinadoresinvestigacion.correo from ieproyectos, iecoordinadoresinvestigacion 
                                    where ieproyectos.coordinador = iecoordinadoresinvestigacion.id and ieproyectos.codigo = '". $codigo ."'";
            $resultadoCoordiandorIE = mysqli_query($connection, $sentenciaCoordiandorIE);
            $data3IE = mysqli_fetch_assoc($resultadoCoordiandorIE);
            array_push($arrayCorreosIE, $data3IE["correo"]);
            
          
            
            //evaluadores
            $sentenciaAsesoresIE = "select ieevaluadores.correo from ieproyectos, ieevaluadores, ieevaluan
                                where ieproyectos.codigo = ieevaluan.proyecto and ieevaluadores.id = ieevaluan.evaluador and
                                ieevaluan.estado= 1 and ieproyectos.codigo = '". $codigo ."'";
            $resultadoAsesoresIE = mysqli_query($connection, $sentenciaAsesoresIE);
            while ($data5IE = mysqli_fetch_assoc($resultadoAsesoresIE)) {
                array_push($arrayCorreosIE, $data5IE["correo"]);
            }
            
            
            //comiex
            $sentenciaComiexIE = "select iemiembroscomiex.correo from ieproyectos, iemiembroscomiex, ierevisan
                                where ieproyectos.codigo = ierevisan.proyecto and iemiembroscomiex.id = ierevisan.miembrocomiex and
                                ierevisan.estado= 1 and ieproyectos.codigo = '". $codigo ."'";
            $resultadoComiexIE = mysqli_query($connection, $sentenciaComiexIE);
            while ($data6IE = mysqli_fetch_assoc($resultadoComiexIE)) {
                array_push($arrayCorreosIE, $data6IE["correo"]);
            }
            
            $info = array();
            array_push($info, $titulo, $etapa);
            alarmaArchivoIE($info, $arrayCorreosIE);
        
            
            
            
        
        
        
    if($isInvestigacion){
    echo '<html>';

    echo '<head>';
    echo '<title></title>';

    echo '</head>';

    echo '<body onload="enviar()" hidden>';
        echo '<script language="JavaScript">';
        echo 'function enviar(){';
        echo 'document.form.submit();';
        echo '}';
        echo '</script>';
        echo '<form id="form" name="form" method="POST" action="../consulta_Extension.php" >';
        echo '<input type="text" value="' . $codigo . '" name="codigo" />';
        echo '</form>';


        echo '</body>';

        echo '</html>';
        exit();
    }

    }else{
    $_SESSION["error"] = "¡Error al Cargar el archivo! Error Insert BD";
    header("Location: ../navegacion/500.php");
    exit();
    }
   
}
catch(ServiceException $e){
    $_SESSION["error"] = "¡Error al Cargar el archivo! conexion al servicio de Blobs";
    header("Location: ../navegacion/500.php");
    exit();

}

function existeInvestigador($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from iearchivosinvestigadores where nom_archivo = '".$nombreArchivo."' and investigador = '".$usuario."' "
            . "and etapa=".$etapa." and proyecto='".$codigo."';";
    
     $resultado = mysqli_query($connection, $consulta);
     if(mysqli_num_rows($resultado) != 0){ 
           existeInvestigador(annadirnum($nombreArchivo, $iteracion),$codigo, $etapa, $usuario);
     }
     else{
         
         $nombre_archivo = $nombreArchivo.'';
     }
     
     return $nombre_archivo;
}


function annadirnum($string,$iteracion){
    
    $stringFinal='';
    
    $array = explode(".", $string);
    $array[count($array)-2] = $array[count($array)-2].$iteracion;
    foreach ($array as $valor) {
        if($array[count($array)-1] != $valor)
        $stringFinal = $stringFinal.$valor.".";
        else{
            $stringFinal = $stringFinal.$valor;
        }
    }
    ;
    return $stringFinal;
}

function existeEvaluador($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from iearchivosevaluadores where nom_archivo = '".$nombreArchivo."' and evaluador = '".$usuario."' "
            . "and etapa=".$etapa." and proyecto='".$codigo."';";
    
     $resultado = mysqli_query($connection, $consulta);
     if(mysqli_num_rows($resultado) != 0){ 
           existeEvaluador(annadirnum($nombreArchivo, $iteracion),$codigo, $etapa, $usuario);
     }
     else{
         
         $nombre_archivo = $nombreArchivo.'';
     }
     
     return $nombre_archivo;
}

function existeComision($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from iearchivoscomiex where nom_archivo = '".$nombreArchivo."' and miembrocomiex = '".$usuario."' "
            . "and etapa=".$etapa." and proyecto='".$codigo."';";
    
     $resultado = mysqli_query($connection, $consulta);
     if(mysqli_num_rows($resultado) != 0){ 
           existeComision(annadirnum($nombreArchivo, $iteracion),$codigo, $etapa, $usuario);
     }
     else{
         
         $nombre_archivo = $nombreArchivo.'';
     }
     
     return $nombre_archivo;
}
?>
