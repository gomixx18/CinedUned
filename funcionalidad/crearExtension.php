<?php
require("email.php");
session_start();

$titulo = $_POST["titulo"];
$lineaInvestigacion = $_POST["lineaInvest"];
$carrera = $_POST["carrera"];
$catedra = $_POST["catedra"];
$coordinador = $_POST["radCoordinador"];
$evaluador1 = $_POST["radEva1"];
$evaluador2 = $_POST["radEva2"]; //este puede ser ninguno
$fecha = $_POST["daterange"];


$fechaArray = explode('-', $fecha);
$fechaArrayInicio = explode('/', trim($fechaArray[0]));
$fechaInicio = $fechaArrayInicio[2] . "-" . $fechaArrayInicio[0] . "-" . $fechaArrayInicio[1];
$fechaArrayFinal = explode('/', trim($fechaArray[1]));
$fechaFinal = $fechaArrayFinal[2] . "-" . $fechaArrayFinal[0] . "-" . $fechaArrayFinal[1];

$arrayDocentes = array();
for ($i = 1; $i < 7; $i++) {
    if (isset($_POST["nameEstudiante" . $i])) {
        array_push($arrayDocentes, $_POST["nameEstudiante" . $i]);
    }
}
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if ($connection) {

    $sqlCodigo = "SELECT * FROM consecutivos where tipo = 'IE'";
    $resultadoCodigo = mysqli_query($connection, $sqlCodigo);
    $annoActual = date("Y");
    
    $data = mysqli_fetch_assoc($resultadoCodigo);
    if ($data["anno"] == $annoActual) {
        $numeroCambio = (int)$data["numero"] + 1;
        $sqlcambioConsecutivo = "UPDATE consecutivos SET numero= " . $numeroCambio . " WHERE tipo='IE'";
        $codigo = "EXT-" . $data["numero"] ."-". $data["anno"] ."-". $carrera ."-". $catedra ."-". $lineaInvestigacion ;
    } else {
        $annoCambio = (int)$annoActual;
        $sqlcambioConsecutivo = "UPDATE consecutivos SET numero= 1, anno = " . $annoCambio . " WHERE tipo='IE'";
        $codigo = "EXT-1-". $data["anno"] ."-". $carrera ."-". $catedra ."-". $lineaInvestigacion ;
    }
    $resultadoCambioConsecutivo = mysqli_query($connection, $sqlcambioConsecutivo); 

    $sqExtension = "INSERT INTO ieproyectos (codigo, titulo, coordinador, estado, lineainvestigacion, isExtension, carrera, catedra, fechaInicio, fechaFinal) VALUES ('".$codigo."', '".$titulo."', '".$coordinador."', 'Activo', '".$lineaInvestigacion."', true, '".$carrera."', '".$catedra."', '".$fechaInicio."', '".$fechaFinal."')";
    $resultadoExtension= mysqli_query($connection, $sqExtension); // ingresar Extension


    

    // insertar Docentes
    
    foreach ($arrayDocentes as $docente){
        $sqlDocentes= "INSERT INTO ieinvestigan (investigador, proyecto, estado) VALUES ('".$docente."', '".$codigo."', 1)";
        $resultadoDocentes = mysqli_query($connection, $sqlDocentes);
    }

    
    //ligar miembros
    $sqlMiembros = "SELECT * FROM iemiembroscomiex WHERE estado = 1";
    $resultadoMiembros = mysqli_query($connection, $sqlMiembros); // aca estan los miebros de la comision activos
    
     while ($data = mysqli_fetch_assoc($resultadoMiembros)){
        $sqlMiembrosAsoc= "INSERT INTO ierevisan (miembrocomiex, proyecto, estado) VALUES ('".$data["id"]."', '".$codigo."',1)";
        $resultadoMiembrosAsoc = mysqli_query($connection, $sqlMiembrosAsoc);
     }
     
    // ligar evaluadores
    $sqlEvaluador1 = "INSERT INTO ieevaluan (evaluador, proyecto, estado) VALUES ('".$evaluador1."', '".$codigo."',1)";
    $resultadoEvaluador1 = mysqli_query($connection, $sqlEvaluador1);
    
    if($evaluador2 != "ninguno" && $evaluador1 != $evaluador2){
        $sqlEvaluador2 = "INSERT INTO ieevaluan (evaluador, proyecto, estado) VALUES ('".$evaluador2."', '".$codigo."',1)";
        $resultadoEvaluador2 = mysqli_query($connection, $sqlEvaluador2);
    }
    
    //crear etapas probar                       
    $nuevafecha= strtotime ( '+5 week' , strtotime ( $fechaInicio) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas1 = "INSERT INTO ieetapas (numero, estado, proyecto, fechaEntrega) VALUES (1, 'En ejecución', '".$codigo. "', '". $nuevafecha ."')";
    $resultadoEtapas1 = mysqli_query($connection, $sqlEtapas1);
    $nuevafecha= strtotime ( '+14 week' , strtotime ( $nuevafecha) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas2 = "INSERT INTO ieetapas (numero, estado, proyecto, fechaEntrega) VALUES (2, 'Inactiva', '".$codigo. "', '". $nuevafecha ."')";
    $resultadoEtapas2 = mysqli_query($connection, $sqlEtapas2);
    $nuevafecha= strtotime ( '+20 week' , strtotime ( $nuevafecha) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas3 = "INSERT INTO ieetapas (numero, estado, proyecto, fechaEntrega) VALUES (3, 'Inactiva', '".$codigo. "', '". $nuevafecha ."')";
    $resultadoEtapas3 = mysqli_query($connection, $sqlEtapas3);
    
    $infoExt = array();
    array_push($infoExt, $titulo);
    
    $sqlC = "SELECT nombre FROM carreras where codigo = " . $carrera;
    $resultadoC = mysqli_query($connection, $sqlC);
    $rowC = $resultadoC->fetch_assoc();
    array_push($infoExt, $rowC["nombre"]);
    
    $sqlCat = "SELECT nombre FROM catedras where codigo = " . $catedra;
    $resultadoCat = mysqli_query($connection, $sqlCat);
    $rowCat = $resultadoCat->fetch_assoc();
    array_push($infoExt, $rowCat["nombre"]);
    
    $sqlL = "SELECT nombre FROM lineasinvestigacion where codigo = " . $lineaInvestigacion;
    $resultadoL = mysqli_query($connection, $sqlL);
    $rowL = $resultadoL->fetch_assoc();
    array_push($infoExt, $rowL["nombre"]);
    
    array_push($infoExt, $fechaInicio);
    $correos = array();
    $sqlCI = "SELECT correo FROM iecoordinadoresinvestigacion where id = '" . $coordinador ."'";
    $resultadoCI = mysqli_query($connection, $sqlCI);
    $rowCI = $resultadoCI->fetch_assoc();
    array_push($correos, $rowCI["correo"]);
    
    $sqlE1 = "SELECT correo FROM ieevaluadores where id = '" . $evaluador1 . "'";
    $resultadoE1 = mysqli_query($connection, $sqlE1);
    $row2 = $resultadoE1->fetch_assoc();
    array_push($correos, $row2["correo"]);
    
    if ($evaluador2 != 'ninguno') {
        $sqlE2 = "SELECT correo FROM ieevaluadores where id = '" . $evaluador2 ."'";
        $resultadoE2 = mysqli_query($connection, $sqlE2);
        $row3 = $resultadoE2->fetch_assoc();
        array_push($correos, $row3["correo"]);
    }
    
    $select = "SELECT correo FROM ieinvestigadores WHERE id IN ('" . implode("','", $arrayDocentes) . "')";
    $r2 = mysqli_query($connection, $select);
    while ($row4 = $r2->fetch_assoc()) {
        array_push($correos, $row4["correo"]);
    }
    
    emailRegistroProyecto($infoExt, $correos , 3);
    

    mysqli_close($connection);
}



header("Location: ../admin_Extension.php");




