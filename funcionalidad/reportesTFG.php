<?php

session_start();

$Etfg = json_decode($_REQUEST["Etfg"], true);
$Etfg1 = json_decode($_REQUEST["Etfg1"], true);
$Etfg2 = json_decode($_REQUEST["Etfg2"], true);
$Etfg3 = json_decode($_REQUEST["Etfg3"], true);

$carrera = json_decode($_REQUEST["carrera"], true);
$linea = json_decode($_REQUEST["linea"], true);
$modalidad = json_decode($_REQUEST["modalidad"], true);
$fechainicio = $_REQUEST["fechainicio"];
$fechafin = $_REQUEST["fechafin"];
$estadistica = $_REQUEST["estadistica"];
//echo $carrera.$linea.$modalidad.$fechainicio.$fechafin;

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
if ($connection) {
    
    $bandera = true;
    $primera = true;


    $q1 = "";
    //-----------------------estado del tfg------------------------
    if (count($Etfg) > 0) {
        $primera = false;
         $q1 = $q1 . "(";
        for ($i = 0; $i < count($Etfg); $i++) {
            $q1 = $q1 . " D.estado = '$Etfg[$i]' ";
            if ($i != count($Etfg) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ")";
    }
    //-----------------------estado de etapa 1------------------------
    if (count($Etfg1) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;
        $q1 = $q1 . "((";
        for ($i = 0; $i < count($Etfg1); $i++) {
            $q1 = $q1 . " A.estado = '$Etfg1[$i]' ";
            if ($i != count($Etfg1) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Etfg1) - 1) {
                $q1 = $q1 . ") and A.numero = 1";
            }
        }
         $q1 = $q1 . ")";
    }
    //-----------------------estado de etapa 2------------------------
    if (count($Etfg2) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;
        $q1 = $q1 . "((";
        for ($i = 0; $i < count($Etfg2); $i++) {
            $q1 = $q1 . " B.estado = '$Etfg2[$i]' ";
            if ($i != count($Etfg2) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Etfg2) - 1) {
                $q1 = $q1 . ") and B.numero = 2";
            }
        }
         $q1 = $q1 . ")";
    }
    //-----------------------estado de etapa 3------------------------
    if (count($Etfg3) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $bandera = false;

        $q1 = $q1 . "((";
        for ($i = 0; $i < count($Etfg3); $i++) {
            $q1 = $q1 . " C.estado = '$Etfg3[$i]' ";
            if ($i != count($Etfg3) - 1) {
                $q1 = $q1 . " or ";
            }
            if ($i == count($Etfg3) - 1) {
                $q1 = $q1 . ") and C.numero = 3";
            }
        }
        $q1 = $q1 . ")";
    }
    //-----------------------fechas------------------------
    if ($fechainicio != "") {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        
        $q1 = $q1 . "(D.fechaInicio between '$fechainicio' and '$fechafin')";
    }
    //-----------------------carreras------------------------
    if (count($carrera) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "(";
        for ($i = 0; $i < count($carrera); $i++) {

            $q1 = $q1 . "D.carrera ='" . $carrera[$i] . "'";

            if ($i != count($carrera) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ")";
    }
    //-----------------------modalidad------------------------
    if (count($modalidad) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "(";
        for ($i = 0; $i < count($modalidad); $i++) {

            $q1 = $q1 . "D.modalidad ='" . $modalidad[$i] . "'";

            if ($i != count($modalidad) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ")";
    }
    //-----------------------linea------------------------
    if (count($linea) > 0) {
        if (!$primera) {
            $q1 = $q1 . " and ";
        }
        $primera = false;
        $q1 = $q1 . "(";
        
        for ($i = 0; $i < count($linea); $i++) {

            $q1 = $q1 . "D.lineainvestigacion ='" . $linea[$i] . "'";

            if ($i != count($linea) - 1) {
                $q1 = $q1 . " or ";
            }
        }
        $q1 = $q1 . ")";
    }
    //-----------------------armado------------------------
    
    if(!$primera){
        $q1 = "select  D.codigo as tfg from tfg, (select tfg,estado,numero from tfgetapas) A, (select tfg,estado,numero from tfgetapas) B,(select tfg,estado,numero from tfgetapas) C,
        (select * from tfg ) D where " . $q1 . " and tfg.codigo = C.tfg and A.tfg = B.tfg and B.tfg = C.tfg and D.codigo = tfg.codigo group by D.codigo;";
    }else{
        $q1 = "select  D.codigo as tfg from tfg, (select tfg,estado,numero from tfgetapas) A, (select tfg,estado,numero from tfgetapas) B,(select tfg,estado,numero from tfgetapas) C,
        (select * from tfg ) D where " . $q1 . " tfg.codigo = C.tfg and A.tfg = B.tfg and B.tfg = C.tfg and D.codigo = tfg.codigo group by D.codigo;";
    }

   // echo $q1;
    @session_start();
    $_SESSION['pdfTFG'] = $q1;
    $_SESSION['estadistica'] = $estadistica;
   // echo $estadistica;
    /* header("Location: pdfParserTFG.php");
    $result = mysqli_query($connection, $q1);

     $data = array();
      while ($data = mysqli_fetch_assoc($query)) {

      $data[] = $row;
      } */
    //echo json_encode($data);
} else {
    
}


