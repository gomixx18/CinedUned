<?php

require ('email.php');
session_start();

$titulo = $_POST["tituloTFG"];
$lineaInvestigacion = $_POST["lineaInvest"];
$carrera = $_POST["carrera"];
$modalidad = $_POST["modalidad"];
$encargado = $_POST["radEncargado"];
$director = $_POST["radCoord"];
$asesor1 = $_POST["radAsesor1"];
$asesor2 = $_POST["radAsesor2"]; //este puede ser ninguno
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

    $sqlCodigo = "SELECT * FROM consecutivos where tipo = 'TFG'";
    $resultadoCodigo = mysqli_query($connection, $sqlCodigo);
    $annoActual = date("Y");

    $data = mysqli_fetch_assoc($resultadoCodigo);
    if ($data["anno"] == $annoActual) {
        $numeroCambio = (int) $data["numero"] + 1;
        $sqlcambioConsecutivo = "UPDATE consecutivos SET numero= " . $numeroCambio . " WHERE tipo='TFG'";
        $codigo = "TFG-" . $data["numero"] . "-" . $data["anno"] . "-" . $carrera . "-" . $modalidad . "-" . $lineaInvestigacion;
    } else {
        $annoCambio = (int) $annoActual;
        $sqlcambioConsecutivo = "UPDATE consecutivos SET numero= 1, anno = " . $annoCambio . " WHERE tipo='TFG'";
        $codigo = "TFG-1-" . $data["anno"] . "-" . $carrera . "-" . $modalidad . "-" . $lineaInvestigacion;
    }
    $resultadoCambioConsecutivo = mysqli_query($connection, $sqlcambioConsecutivo);

    $sqExtension = "INSERT INTO tfg (codigo, titulo, directortfg, encargadotfg, lineainvestigacion, carrera, estado, modalidad, fechaInicio, fechaFinal) VALUES ('" . $codigo . "', '" . $titulo . "', '" . $director . "', '" . $encargado . "', '" . $lineaInvestigacion . "', '" . $carrera . "', 'Activo', '" . $modalidad . "', '" . $fechaInicio . "', '" . $fechaFinal . "')";
    $resultadoTFG = mysqli_query($connection, $sqExtension); // ingresar TFG
    // insertar estudiantes

    foreach ($arrayDocentes as $docente) {
        $sqlDocentes = "INSERT INTO tfgrealizan (estudiante, tfg,estado) VALUES ('" . $docente . "', '" . $codigo . "',1)";
        $resultadoDocentes = mysqli_query($connection, $sqlDocentes);
    }


    //ligar miembros
    $sqlMiembros = "SELECT * FROM tfgmiembroscomision WHERE estado = 1";
    $resultadoMiembros = mysqli_query($connection, $sqlMiembros); // aca estan los miebros de la comision activos

    while ($data = mysqli_fetch_assoc($resultadoMiembros)) {
        $sqlMiembrosAsoc = "INSERT INTO tfgevaluan (miembrocomisiontfg, tfg,estado) VALUES ('" . $data["id"] . "', '" . $codigo . "',1)";
        $resultadoMiembrosAsoc = mysqli_query($connection, $sqlMiembrosAsoc);
    }

    // ligar asesores
    $sqlEvaluador1 = "INSERT INTO tfgasesoran (asesor, tfg,estado) VALUES ('" . $asesor1 . "', '" . $codigo . "',1)";
    $resultadoAsesor1 = mysqli_query($connection, $sqlEvaluador1);

    if ($asesor2 != "ninguno" && $asesor1 != $asesor2) {
        $sqlAsesor2 = "INSERT INTO tfgasesoran (asesor, tfg,estado) VALUES ('" . $asesor2 . "', '" . $codigo . "',1)";
        $resultadoAsesor2 = mysqli_query($connection, $sqlAsesor2);
    }

    //crear etapas probar                       
    $nuevafecha= strtotime ( '+5 week' , strtotime ( $fechaInicio) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas1 = "INSERT INTO tfgetapas (numero, estado, tfg, fechaEntrega) VALUES (1, 'En ejecución', '" . $codigo . "', '". $nuevafecha ."')";
    $resultadoEtapas1 = mysqli_query($connection, $sqlEtapas1);
    $nuevafecha= strtotime ( '+14 week' , strtotime ( $nuevafecha) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas2 = "INSERT INTO tfgetapas (numero, estado, tfg, fechaEntrega) VALUES (2, 'Inactiva', '" . $codigo . "', '". $nuevafecha ."')";
    $resultadoEtapas2 = mysqli_query($connection, $sqlEtapas2);
    $nuevafecha= strtotime ( '+20 week' , strtotime ( $nuevafecha) ) ;
    $nuevafecha= date ( 'Y-m-d' , $nuevafecha );
    $sqlEtapas3 = "INSERT INTO tfgetapas (numero, estado, tfg, fechaEntrega) VALUES (3, 'Inactiva', '" . $codigo . "', '". $nuevafecha ."')";
    $resultadoEtapas3 = mysqli_query($connection, $sqlEtapas3);
	
	
    //enviar correo a usuarios asociados
    $infoTFG = array();
    array_push($infoTFG, $titulo);
    

    
    $sqlC = "SELECT nombre FROM carreras where codigo = " . $carrera;
    $resultadoC = mysqli_query($connection, $sqlC);
    $rowC = $resultadoC->fetch_assoc();
    array_push($infoTFG, $rowC["nombre"]);
    
    $sqlMod = "SELECT nombre FROM modalidades where codigo = " . $modalidad;
    $resultadoMod = mysqli_query($connection, $sqlMod);
    $rowM = $resultadoMod->fetch_assoc();
    array_push($infoTFG, $rowM["nombre"]);

    $sqlL = "SELECT nombre FROM lineasinvestigacion where codigo = " . $lineaInvestigacion;
    $resultadoL = mysqli_query($connection, $sqlL);
    $rowL = $resultadoL->fetch_assoc();
    array_push($infoTFG, $rowL["nombre"]);
    
    array_push($infoTFG, $fechaInicio);
    
    $correos = array();
    
    $sqlEn = "SELECT correo FROM tfgencargados where id = '" . $encargado."'" ;
    $resultadoEn = mysqli_query($connection, $sqlEn);
    $rowE = $resultadoEn->fetch_assoc();
    array_push($correos, $rowE["correo"]);
    
    $sqlDir = "SELECT correo FROM tfgdirectores where id = '" . $director. "'";
    $resultadoDir = mysqli_query($connection, $sqlDir);
    $row1 = $resultadoDir->fetch_assoc();
    array_push($correos, $row1["correo"]);

    $sqlA1 = "SELECT correo FROM tfgasesores where id = '" . $asesor1. "'";
    $resultadoA1 = mysqli_query($connection, $sqlA1);
    $row2 = $resultadoA1->fetch_assoc();
    array_push($correos, $row2["correo"]);

    if ($asesor2 != 'ninguno') {
        $sqlA2 = "SELECT correo FROM tfgasesores where id = '" . $asesor2. "'";
        $resultadoA2 = mysqli_query($connection, $sqlA2);
        $row3 = $resultadoA2->fetch_assoc();
        array_push($correos, $row3["correo"]);
    }

    
    $select = "SELECT correo FROM tfgestudiantes WHERE id IN ('" . implode("','", $arrayDocentes) . "')";
    $r2 = mysqli_query($connection, $select);
    while ($row4 = $r2->fetch_assoc()) {
        array_push($correos, $row4["correo"]);
    }

    emailRegistroProyecto($infoTFG, $correos , 1);

    mysqli_close($connection);
}



header("Location: ../admin_TFG.php");




