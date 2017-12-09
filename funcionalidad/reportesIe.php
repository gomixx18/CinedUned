<?php

session_start();

$Eie = json_decode($_REQUEST["Eie"], true);
$Eie1 = json_decode($_REQUEST["Eie1"], true);
$Eie2 = json_decode($_REQUEST["Eie2"], true);
$Eie3 = json_decode($_REQUEST["Eie3"], true);

$catedra = json_decode($_REQUEST["catedra"], true);
$linea = json_decode($_REQUEST["linea"], true);
$carrera = json_decode($_REQUEST["carrera"], true);
$fechainicio = $_REQUEST["fechainicio"];
$fechafin = $_REQUEST["fechafin"];
$estadistica = $_REQUEST["estadistica"];
$extension = $_REQUEST["extension"];

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
if ($connection) {
    $bandera = true;
    $primera = true;

    
    $q1 = "";
    //-----------------------estado del ie------------------------
    if (count($Eie) > 0) {
        $primera = false;
        $q1 = $q1 . "( ";
        for ($i = 0; $i < count($Eie); $i++) {
            $q1 = $q1 . " D.estado = '$Eie[$i]' ";
            if ($i != count($Eie) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------estado etapa 1------------------------
    if (count($Eie1) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;
        $q1 = $q1 . "(( ";
        for ($i = 0; $i < count($Eie1); $i++) {
            $q1 = $q1 . " A.estado = '$Eie1[$i]' ";
            if ($i != count($Eie1) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Eie1) - 1) {
                $q1 = $q1 . ") and A.numero = 1";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------estado etapa 2------------------------
    if (count($Eie2) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;
        $q1 = $q1 . "(( ";
        for ($i = 0; $i < count($Eie2); $i++) {
            $q1 = $q1 . " B.estado = '$Eie2[$i]' ";
            if ($i != count($Eie2) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Eie2) - 1) {
                $q1 = $q1 . ") and B.numero = 2";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------estado etapa 3------------------------
    if (count($Eie3) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;
        $q1 = $q1 . "(( ";

        for ($i = 0; $i < count($Eie3); $i++) {
            $q1 = $q1 . " C.estado = '$Eie3[$i]' ";
            if ($i != count($Eie3) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Eie3) - 1) {
                $q1 = $q1 . ") and C.numero = 3";
            }
        }
        $q1 = $q1 . ") ";
    }
    //----------------------fecha-----------------------
    if ($fechainicio != "") {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        
        $q1 = $q1 . "(D.fechaInicio between '$fechainicio' and '$fechafin')";
    }
    //-----------------------carrera------------------------
    if (count($carrera) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "( ";
        for ($i = 0; $i < count($carrera); $i++) {

            $q1 = $q1 . " D.carrera ='" . $carrera[$i] . "'";

            if ($i != count($carrera) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------catedra------------------------
    if (count($catedra) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "( ";
        for ($i = 0; $i < count($catedra); $i++) {

            $q1 = $q1 . " D.catedra ='" . $catedra[$i] . "'";

            if ($i != count($catedra) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------linea------------------------
    if (count($linea) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "( ";
        for ($i = 0; $i < count($linea); $i++) {

            $q1 = $q1 . " D.lineainvestigacion ='" . $linea[$i] . "'";

            if ($i != count($linea) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ") ";
    }
    //-----------------------IoE------------------------
    if (!$primera) {
            $q1 = $q1 . " and ";
             $primera = false;
        }
        $q1 = $q1 . " D.isExtension = '$extension'";
    
    if (!$primera) {
        $q1 = "select D.codigo as proyecto from ieproyectos, (select proyecto,estado,numero from ieetapas) A,(select proyecto,estado,numero from ieetapas) B,(select proyecto,estado,numero from ieetapas) C,
            (select * from ieproyectos ) D where " . $q1 . "and ieproyectos.codigo = C.proyecto and A.proyecto = B.proyecto and B.proyecto = C.proyecto and D.codigo = ieproyectos.codigo group by D.codigo;";
       
    } else {
       $q1 = "select D.codigo as proyecto from ieproyectos, (select proyecto,estado,numero from ieetapas) A,(select proyecto,estado,numero from ieetapas) B,(select proyecto,estado,numero from ieetapas) C,
            (select * from ieproyectos ) D where" . $q1 . " and ieproyectos.codigo = C.proyecto and A.proyecto = B.proyecto and B.proyecto = C.proyecto and D.codigo = ieproyectos.codigo group by D.codigo;";
        
    }

    $_SESSION['pdfIE'] = $q1;
	$_SESSION['estadistica'] = $estadistica;
	$_SESSION['extension'] = $extension;
    //echo $q1;
    //$result = mysqli_query($connection, $q1);

    /* $data = array();
      while ($data = mysqli_fetch_assoc($query)) {

      $data[] = $row;
      } */
    //echo json_encode($data);
} else {
    
}


