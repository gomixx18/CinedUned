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
$codigo = $_POST['codigoTFG'];
$etapa = $_POST['etapa'];
$tipo = $_POST['tipo'];
$titulo = $_POST['titulo'];
$subetapa = $_POST['subetapa'];
$arrayCorreos = array();

if(isset($_FILES['archivo']['name'])){
  $nombre_archivo = $_FILES['archivo']['name'];
}

if(isset($_FILES['archivo2']['name'])){
   $nombre_archivo = $_FILES['archivo2']['name'];
}
if(isset($_FILES['archivo3']['name'])){
   $nombre_archivo = $_FILES['archivo3']['name'];
}

    

if(!$codigo  || !$etapa || !$tipo){
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

 if ($tipo == "archivoDirector") {      
        existeDirector($nombre_archivo, $codigo, $etapa, $usuario);
    }
    if($tipo == 'archivoAsesor'){
        existeAsesores($nombre_archivo, $codigo, $etapa, $usuario);
    }
    if($tipo == 'archivoMiembroComision'){
        existeComision($nombre_archivo, $codigo, $etapa, $usuario);
    }
$archivo_bases = "https://almacenamientocined.blob.core.windows.net/tfg/".$ubicacionArchivo.$nombre_archivo;
$content = fopen($_FILES['archivo']["tmp_name"], "r");
if(!$content){
   $_SESSION["error"] = "¡Hubo un error al cargar el archivo! FOPEN";
   header("Location: ../navegacion/500.php");
   exit();
}
$blob_name = $ubicacionArchivo.$nombre_archivo;

try {
    //Upload blob
    $blobRestProxy->createBlockBlob("tfg",$blob_name, $content);
    $fecha = date('Y-m-d H:i:s');
    
    if ($tipo == "archivoDirector") {
        
        existeDirector($nombre_archivo, $codigo, $etapa, $usuario);
        $consulta = "INSERT INTO tfgarchivosdirectores (director, etapa, tfg, ruta, fecha, nom_archivo, subetapa) VALUES ( '" . $usuario . "' , " . $etapa .
                " , '" . $codigo . "','" . $archivo_bases . "' ,'" . $fecha ."','".$nombre_archivo."', ".$subetapa . ");";
    }
    if($tipo == 'archivoAsesor'){
     $consulta  = "INSERT INTO tfgarchivosasesores (asesor, etapa, tfg, ruta, fecha, nom_archivo, subetapa) VALUES ( '".$usuario."' , ".$etapa.
                 " ,'".$codigo."','".$archivo_bases."','".$fecha."','".$nombre_archivo."', ".$subetapa . ");";
    }
    if($tipo == 'archivoMiembroComision'){
       $consulta  = "INSERT INTO tfgarchivoscomision (miembrocomision, etapa, tfg, ruta, fecha, nom_archivo, subetapa) VALUES ( '".$usuario."' , ".$etapa.
                 " , '".$codigo."','".$archivo_bases."' ,'".$fecha."','".$nombre_archivo."', ".$subetapa . ");";
    }
    
    
    
    
    $resultado = mysqli_query($connection, $consulta);
    
    if($resultado){
        
        
        //SELECT DE LOS CORREOS TODOS LOS CORREOS SE GUARDAN EN ARRAYCORREOS
        //estudiantes
            $sentenciaEstudiantes = "select tfgestudiantes.correo from tfg, tfgestudiantes, tfgrealizan
                                    where tfg.codigo = tfgrealizan.tfg and tfgestudiantes.id = tfgrealizan.estudiante and
                                    tfgrealizan.estado= 1 and tfg.codigo = '". $codigo ."'";
            $resultadoEstudiantes = mysqli_query($connection, $sentenciaEstudiantes);
            while ($data2 = mysqli_fetch_assoc($resultadoEstudiantes)) {
                array_push($arrayCorreos, $data2["correo"]);
            }
            
            //director
            $sentenciaDirector = "select tfgdirectores.correo from tfg, tfgdirectores 
                                    where tfg.directortfg = tfgdirectores.id and tfg.codigo = '". $codigo ."'";
            $resultadoDirector = mysqli_query($connection, $sentenciaDirector);
            $data3 = mysqli_fetch_assoc($resultadoDirector);
            array_push($arrayCorreos, $data3["correo"]);
            
            //encargado
            $sentenciaEncargado = "select tfgencargados.correo from tfg, tfgencargados 
                                    where tfg.encargadotfg = tfgencargados.id and tfg.codigo = '". $codigo ."'";
            $resultadoEncargado = mysqli_query($connection, $sentenciaEncargado);
            $data4 = mysqli_fetch_assoc($resultadoEncargado);
            array_push($arrayCorreos, $data4["correo"]);
            
            //asesores
            if($etapa != 1){
            $sentenciaAsesores = "select tfgasesores.correo from tfg, tfgasesores, tfgasesoran
                                where tfg.codigo = tfgasesoran.tfg and tfgasesores.id = tfgasesoran.asesor and
                                tfgasesoran.estado= 1 and tfg.codigo = '". $codigo ."'";
            $resultadoAsesores = mysqli_query($connection, $sentenciaAsesores);
            while ($data5 = mysqli_fetch_assoc($resultadoAsesores)) {
                array_push($arrayCorreos, $data5["correo"]);
            }
            }
            // miembros
            $sentenciaMiembros = "select tfgmiembroscomision.correo from tfg, tfgmiembroscomision, tfgevaluan
                                where tfg.codigo = tfgevaluan.tfg and tfgmiembroscomision.id = tfgevaluan.miembrocomisiontfg and
                                tfgevaluan.estado= 1 and tfg.codigo = '". $codigo ."'";
            $resultadoMiembros= mysqli_query($connection, $sentenciaMiembros);
            while ($data6 = mysqli_fetch_assoc($resultadoMiembros)) {
                array_push($arrayCorreos, $data6["correo"]);
            }
           
            
            $info = array();
            array_push($info, $titulo, $etapa);
            alarmaArchivoTFG($info, $arrayCorreos);
            
        
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
        echo '<form id="form" name="form" method="POST" action="../consulta_TFG.php" >';
        echo '<input type="text" value="' . $codigo . '" name="codigo" />';
        echo '<input type="text" value="1" name="exito"';
        echo '</form>';
        echo '</body>';
        echo '</html>';
      //  exit();
        
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



function existeDirector($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    global $subetapa;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from tfgarchivosdirectores where nom_archivo = '".$nombreArchivo."' and director = '".$usuario."' "
            . "and etapa=".$etapa." and tfg='".$codigo."' and subetapa= ".$subetapa. ";";
    
     $resultado = mysqli_query($connection, $consulta);
     if(mysqli_num_rows($resultado) != 0){ 
           existeDirector(annadirnum($nombreArchivo, $iteracion),$codigo, $etapa, $usuario);
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
    
    return $stringFinal;
}

function existeAsesores($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    global $subetapa;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from tfgarchivosasesores where nom_archivo = '".$nombreArchivo."' and asesor = '".$usuario."' "
            . "and etapa=".$etapa." and tfg='".$codigo."'and subetapa=".$subetapa . ";";
    
     $resultado = mysqli_query($connection, $consulta);
     if(mysqli_num_rows($resultado) != 0){ 
           existeAsesores(annadirnum($nombreArchivo, $iteracion),$codigo, $etapa, $usuario);
     }
     else{
         
         $nombre_archivo = $nombreArchivo.'';
     }
     
     return $nombre_archivo;
}

function existeComision($nombreArchivo,$codigo, $etapa, $usuario){
    
    global $connection;
    global $nombre_archivo;
    global $subetapa;
    $iteracion = '(1)';
    $consulta = "select nom_archivo from tfgarchivoscomision where nom_archivo = '".$nombreArchivo."' and miembrocomision = '".$usuario."' "
            . "and etapa=".$etapa." and tfg='".$codigo."' and subetapa=".$subetapa . ";";
    
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
