<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';
require 'vendor/autoload.php';


date_default_timezone_set('America/Costa_Rica');
@session_start();

$usuarioSesion = $_SESSION["user"];
$usuarioPermisos = $_SESSION['permisos'];
$consulta = $_SESSION['pdfTFG'];
$estadistica = $_SESSION['estadistica'];
unset($_SESSION['estadistica']);



$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if(!isset($consulta)){
    header("Location: ../reportesTFG.php");
    exit();
}

if(!isset($usuarioSesion) ||!isset($usuarioPermisos)){
    $_SESSION["error"] = "¡Hubo un error al crear el archivo! NO _SESSION";
    header("Location: ../navegacion/500.php");
    exit();
}

if (!$connection) {
    $_SESSION["error"] = "¡Hubo un error al crear el reporte! Conexión a base de datos";
    header("Location: ../navegacion/500.php");
    exit();
}



$fecha = date('d-m-Y g:i:s a');
//$nombre = 'Creado por: '.$usuarioSesion->getNombre() . " " . $usuarioSesion->getApellido1() . " " . $usuarioSesion->getApellido2(). "\n" ."Fecha de Creación: " .$fecha; 


$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A5', 'Código del TFG');
$sheet->setCellValue('B5', 'Nombre del TFG');
$sheet->setCellValue('C5', 'Carrera');
$sheet->setCellValue('D5', 'Estado General');
$sheet->setCellValue('E5', 'Estado de Etapas');
$sheet->setCellValue('F5', 'Director');
$sheet->setCellValue('G5', 'Asesor 1');
$sheet->setCellValue('H5', 'Asesor 2');
$sheet->setCellValue('I5', 'Linea de investigación');
$sheet->getColumnDimension('A')->setWidth(17);
$sheet->getColumnDimension('B')->setWidth(17);
$sheet->getColumnDimension('C')->setWidth(17);
$sheet->getColumnDimension('D')->setWidth(17);
$sheet->getColumnDimension('E')->setWidth(17);
$sheet->getColumnDimension('F')->setWidth(17);
$sheet->getColumnDimension('G')->setWidth(17);
$sheet->getColumnDimension('H')->setWidth(17);
$sheet->getColumnDimension('I')->setWidth(22);
$sheet->getStyle('A5:I5')->getFill()
->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
->getStartColor()->setARGB('5882FA');
/*$sheet->getStyle('A5')
->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);*/
$sheet->getStyle('A5:I5')
->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$sheet->getHeaderFooter()->setOddHeader('&C&HPlease treat this document as confidential!');
$sheet->getStyle('A5:I5')->getAlignment()->setWrapText(true);
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
$drawing->setName('Logo');
$drawing->setPath('./img/logo_uned_pdf.png');
$drawing->setHeight(36);
$drawing->setCoordinates('A1');



$sheet->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
$sheet->setCellValue('D1', 'Reporte Trabajos Finales de Graduación (TFG)');





obtenerModalidades();
obtenerLineasInvestigacion();
obtenerCarreras();
CrearEstados();
$fila=6;

$query = mysqli_query($connection, $consulta);
if(mysqli_num_rows($query) != 0){
global $fila;
global $sheet;
while ($data2 = mysqli_fetch_assoc($query)) {
    
    $consultaProyecto = "SELECT modalidades.nombre as modalidad, tfg.titulo,concat(tfgdirectores.nombre,' ',  tfgdirectores.apellido1, ' ', tfgdirectores.apellido2) as director ,carreras.nombre as carrera, tfg.estado, lineasinvestigacion.nombre as linea
                         FROM tfg, lineasinvestigacion, modalidades, tfgdirectores, carreras where tfg.codigo = '".$data2['tfg']."' and tfg.directortfg = tfgdirectores.id and tfg.carrera = carreras.codigo and tfg.lineainvestigacion = lineasinvestigacion.codigo and tfg.modalidad = modalidades.codigo;";
    $consultaEtapa = "SELECT tfgetapas.estado as estado
                      FROM tfgetapas where tfgetapas.tfg = '".$data2['tfg']."';";
    
    $query2 = mysqli_query($connection, $consultaProyecto);
    $query3 = mysqli_query($connection, $consultaEtapa);
    $etapa1 = mysqli_fetch_assoc($query3);
    $etapa2 = mysqli_fetch_assoc($query3);
    $etapa3 = mysqli_fetch_assoc($query3);
    $proyecto = mysqli_fetch_assoc($query2);
    obtenerAsesores($data2['tfg']);
    agregarModalidad($proyecto['modalidad']);
    agregarLineas($proyecto['linea']);
    agregarCarrera($proyecto['carrera']);
    agregarEstadoGeneral($proyecto['estado']);

    
    
    if($estadistica == 'false'){
        
        $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('A' . $fila, $data2['tfg']);
        
        $sheet->getStyle('B' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('B' . $fila, $proyecto['titulo']);
        $sheet->getStyle('C' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('C' . $fila, $proyecto['carrera']);
        $sheet->getStyle('D' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('D' . $fila, $proyecto['estado']);
        $sheet->getStyle('E' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('E' . $fila, 'Etapa #1: '.$etapa1['estado'].
                                          ' Etapa #2: '.$etapa2['estado'].
                                          ' Etapa #3: '.$etapa3['estado']);
        $sheet->getStyle('F' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('F' . $fila, $proyecto['director']);
        $sheet->getStyle('G' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('G' . $fila, $asesor1);
        $sheet->getStyle('H' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('H' . $fila, $asesor2);
        $sheet->getStyle('I' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('I' . $fila, $proyecto['linea']);
        $sheet->getStyle('A' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('B' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('C' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('D' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('E' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('F' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('G' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('H' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('I' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $fila=$fila+1;
    }
    unset($asesor1);
    unset($asesor2);
}
}else{
    echo 'no hay datos';
    
}
IngresarModalidades();
IngresarCarreras();
IngresarLineas();
IngresarEstados();
//$writer = new Xlsx($spreadsheet);
//echo "llego aqui 5";
//$writer->save('Logs/ReporteTFG'. $fecha .'.xlsx');
//echo "llego aqui 6";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteTFG.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

function IngresarModalidades(){
    $titulo=0;
    global $fila;
    global $sheet;
    foreach ($GLOBALS['modalidades'] as $modalidad) {
        
        if($titulo==0){
            
            $fila=$fila+2;
            $sheet->getStyle('A' . $fila)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('5882FA');
            $sheet->getStyle('A' . $fila)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('A' . $fila, 'Modalidades');
            $titulo=$titulo+1;
        }
        
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $modalidad[0].': '.$modalidad[1]);
    }
    
}


function IngresarLineas(){
    
    $titulo=0;
    global $fila;
    global $sheet;
    foreach ($GLOBALS['lineas'] as $linea) {
        
        if($titulo==0){
            
            $fila=$fila+2;
            $sheet->getStyle('A' . $fila)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('5882FA');
            $sheet->getStyle('A' . $fila)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('A' . $fila, 'Líneas de Investigación');
            $titulo=$titulo+1;
        }
        
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $linea[0].': '.$linea[1]);
    }
}

function IngresarCarreras(){
    $titulo=0;
    global $fila;
    global $sheet;
    foreach ($GLOBALS['carreras'] as $carrera) {
        
        if($titulo==0){
            
            $fila=$fila+2;
            $sheet->getStyle('A' . $fila)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('5882FA');
            $sheet->getStyle('A' . $fila)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('A' . $fila, 'Modalidades');
            $titulo=$titulo+1;
        }
        
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $carrera[0].': '.$carrera[1]);
    }
}

function IngresarEstados(){
    $titulo=0;
    global $fila;
    global $sheet;
    foreach ($GLOBALS['estados'] as $estado) {
        
        if($titulo==0){
            
            $fila=$fila+2;
            $sheet->getStyle('A' . $fila)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('5882FA');
            $sheet->getStyle('A' . $fila)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('A' . $fila, 'Modalidades');
            $titulo=$titulo+1;
        }
        
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $estado[0].': '.$estado[1]);
    }
}

function obtenerAsesores($tfg){
    
    global $asesor1 ;
    global $asesor2 ;
    $consultaAsesores = "SELECT concat(tfgasesores.nombre,' ',  tfgasesores.apellido1, ' ', tfgasesores.apellido2) as asesor 
                         FROM tfgasesores, tfgasesoran where tfgasesoran.estado = 1 and tfgasesoran.tfg = '".$tfg."' and tfgasesoran.asesor = tfgasesores.id; ";
    
    $query4 = mysqli_query($GLOBALS['connection'], $consultaAsesores);
    $asesor1data = mysqli_fetch_assoc($query4);
    $asesor2data = mysqli_fetch_assoc($query4);
    if(!isset($asesor1data)){
      $asesor1 = "No definido";
    }else{
        $asesor1 = $asesor1data['asesor'];
    }
    
    if(!isset($asesor2data)){
      $asesor2 = "No definido";
    }else{
        $asesor2 = $asesor2data['asesor'];
    }
    
}

function obtenerModalidades(){
    global $modalidades ;
    $modalidades = array();
    
    $consultaModalidades = "SELECT nombre from modalidades;";
    
    $query5 = mysqli_query($GLOBALS['connection'], $consultaModalidades);
    while ($data2 = mysqli_fetch_assoc($query5)) {
        array_push($modalidades, array($data2['nombre'],0));
    }
    array_push($modalidades,array ("Total",0));
}

function CrearEstados(){
    global $estados ;
    $estados = array();
    
    array_push($estados, array("Activo",0));
    array_push($estados, array("Inactivo",0));
    array_push($estados, array("Aprobado para defensa",0));
    array_push($estados, array("Finalizado",0));
    array_push($estados,array ("Total",0));
}

function obtenerLineasInvestigacion(){
    global $lineas ;
    $lineas = array();
    
    $consultaLineas = "SELECT nombre from lineasinvestigacion;";
    
    $query5 = mysqli_query($GLOBALS['connection'], $consultaLineas);
    while ($data2 = mysqli_fetch_assoc($query5)) {
        array_push($lineas, array($data2['nombre'],0));
    }
    array_push($lineas,array ("Total",0));
}

function obtenerCarreras(){
    global $carreras ;
    $carreras = array();
    
    $consultaCarrera = "SELECT nombre from carreras;";
    
    $query5 = mysqli_query($GLOBALS['connection'], $consultaCarrera);
    while ($data2 = mysqli_fetch_assoc($query5)) {
        array_push($carreras, array($data2['nombre'],0));
    }
    array_push($carreras,array ("Total",0));
}

function agregarModalidad($tfgModalidad){
    $modalidades = $GLOBALS['modalidades'];
    for ($i = 0; $i<count($modalidades);$i++) {
         if($modalidades[$i][0] == $tfgModalidad){
         $modalidades[$i][1]++;
         $modalidades[count($modalidades)-1][1]++;
         }
    }
    $GLOBALS['modalidades'] = $modalidades;
    
}

function agregarLineas($tfgLinea){
    $lineas = $GLOBALS['lineas'];
    for ($i = 0; $i<count($lineas);$i++) {
         if($lineas[$i][0] == $tfgLinea){
         $lineas[$i][1]++;
         $lineas[count($lineas)-1][1]++;
         }
    }
    $GLOBALS['lineas'] = $lineas;
    
}

function agregarCarrera($tfgCarrera){
    $carreras = $GLOBALS['carreras'];
    for ($i = 0; $i<count($carreras);$i++) {
         if($carreras[$i][0] == $tfgCarrera){
         $carreras[$i][1]++;
         $carreras[count($carreras)-1][1]++;
         }
    }
    $GLOBALS['carreras'] = $carreras;
}

function agregarEstadoGeneral($tfgEstado){
    $estados = $GLOBALS['estados'];
    for ($i = 0; $i<count($estados);$i++) {
         if($estados[$i][0] == $tfgEstado){
         $estados[$i][1]++;
         $estados[count($estados)-1][1]++;
         }
    }
    $GLOBALS['estados'] = $estados;
    
}
