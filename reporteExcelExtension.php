<?php



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';
require 'vendor/autoload.php';
@session_start();
date_default_timezone_set('America/Costa_Rica');

$usuarioSesion = $_SESSION["user"];
$usuarioPermisos = $_SESSION['permisos'];
$consulta = $_SESSION['pdfIE'];
$estadistica = $_SESSION['estadistica'];
unset($_SESSION['estadistica']);

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if(!isset($consulta)){
    header("Location: ../ReportesExtension.php");
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

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A5', 'Código del Proyecto');
$sheet->setCellValue('B5', 'Título del proyecto');
$sheet->setCellValue('C5', 'Carrera');
$sheet->setCellValue('D5', 'Estado General');
$sheet->setCellValue('E5', 'Estado de Etapas');
$sheet->setCellValue('F5', 'Coordinador');
$sheet->setCellValue('G5', 'Evaluador 1');
$sheet->setCellValue('H5', 'Evaluador 2');
$sheet->setCellValue('I5', 'Linea de investigación');
$sheet->getColumnDimension('A')->setWidth(35);
$sheet->getColumnDimension('B')->setWidth(35);
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

$sheet->setCellValue('D1', 'Reporte de Extensión');


obtenerLineasInvestigacion();
obtenerCarreras();
obtenerCatedras();
CrearEstados();


$fila=6;

$query = mysqli_query($connection, $consulta);
if(mysqli_num_rows($query) != 0){
global $fila;
global $sheet;
while ($data2 = mysqli_fetch_assoc($query)) {
    
    $consultaProyecto = "SELECT ieproyectos.titulo as titulo, ieproyectos.catedra as catedra, concat(iecoordinadoresinvestigacion.nombre,' ',  iecoordinadoresinvestigacion.apellido1, ' ', iecoordinadoresinvestigacion.apellido2) as coordinador ,carreras.nombre as carrera, ieproyectos.estado, lineasinvestigacion.nombre as linea
                        FROM ieproyectos, lineasinvestigacion, iecoordinadoresinvestigacion, carreras where ieproyectos.codigo = '".$data2['proyecto']."' and ieproyectos.coordinador = iecoordinadoresinvestigacion.id and ieproyectos.carrera = carreras.codigo and ieproyectos.lineainvestigacion = lineasinvestigacion.codigo;";
   
    $consultaEtapa = "SELECT ieetapas.estado as estado
                      FROM ieetapas where ieetapas.proyecto = '".$data2['proyecto']."';";
    
    $query2 = mysqli_query($connection, $consultaProyecto);
    $query3 = mysqli_query($connection, $consultaEtapa);
    $etapa1 = mysqli_fetch_assoc($query3);
    $etapa2 = mysqli_fetch_assoc($query3);
    $etapa3 = mysqli_fetch_assoc($query3);
    $proyecto = mysqli_fetch_assoc($query2);

    obtenerEvaluadores($data2['proyecto']);
    agregarEstadoGeneral($proyecto['estado']);
    agregarCarrera($proyecto['carrera']);
    agregarCatedra($proyecto['catedra']);
    agregarLineas($proyecto['linea']);
    
    if($estadistica == 'false'){
        
        $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('A' . $fila, $data2['proyecto']);
        $sheet->getStyle('A' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('B' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('B' . $fila, $proyecto['titulo']);
        $sheet->getStyle('B' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('C' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('C' . $fila, $proyecto['carrera']);
        $sheet->getStyle('C' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('D' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('D' . $fila, $proyecto['estado']);
        $sheet->getStyle('D' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('E' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('E' . $fila, 'Etapa #1: '.$etapa1['estado'].
                                          ' Etapa #2: '.$etapa2['estado'].
                                          ' Etapa #3: '.$etapa3['estado']);
        $sheet->getStyle('E' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('F' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('F' . $fila, $proyecto['coordinador']);
        $sheet->getStyle('F' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('G' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('G' . $fila, $evaluador1);
        $sheet->getStyle('G' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('H' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('H' . $fila, $evaluador2);
        $sheet->getStyle('H' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getStyle('I' . $fila)->getAlignment()->setWrapText(true);
        $sheet->setCellValue('I' . $fila, $proyecto['linea']);
        $sheet->getStyle('I' . $fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $fila=$fila+1;
    }
    unset($evaluador1);
    unset($evaluador2);
}
}else{
    echo 'no hay datos';
}

IngresarLineas();
IngresarCarreras();
IngresarCatedras();
IngresarEstados();

//$writer = new Xlsx($spreadsheet);

//$writer->save('Logs/ReporteInvestigacion.xlsx');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteExtension.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

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
            $sheet->setCellValue('A' . $fila, 'Carreras');
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
            $sheet->setCellValue('A' . $fila, 'Estado General');
            $titulo=$titulo+1;
        }   
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $estado[0].': '.$estado[1]);
    }
}

function IngresarCatedras(){
    $titulo=0;
    global $fila;
    global $sheet;
    foreach ($GLOBALS['catedras'] as $catedra) {
        
        if($titulo==0){
            
            $fila=$fila+2;
            $sheet->getStyle('A' . $fila)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('5882FA');
            $sheet->getStyle('A' . $fila)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->getStyle('A' . $fila)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('A' . $fila, 'Catedras');
            $titulo=$titulo+1;
        }   
            $fila=$fila+1;
            $sheet->setCellValue('A' . $fila, $catedra[0].': '.$catedra[1]);
    }
}
function obtenerEvaluadores($proyecto){
    
    global $evaluador1 ;
    global $evaluador2 ;
    $consultaAsesores = "SELECT concat(ieevaluadores.nombre,' ',  ieevaluadores.apellido1, ' ', ieevaluadores.apellido2) as evaluador 
                         FROM ieevaluadores, ieevaluan where ieevaluan.estado = 1 and ieevaluan.proyecto = '".$proyecto."' and ieevaluan.evaluador = ieevaluadores.id; ";
    
    $query4 = mysqli_query($GLOBALS['connection'], $consultaAsesores);
    $evaluador1data = mysqli_fetch_assoc($query4);
    $evaluador2data = mysqli_fetch_assoc($query4);
    if(!isset($evaluador1data)){
      $evaluador1 = "No definido";
    }else{
        $evaluador1 = $evaluador1data['evaluador'];
    }
    
    if(!isset($evaluador2data)){
      $evaluador2 = "No definido";
    }else{
        $evaluador2 = $evaluador2data['evaluador'];
    }
    
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

function obtenerCatedras(){
    global $catedras ;
    $catedras = array();
    
    $consultaCatedra = "SELECT nombre from catedras;";
    
    $query5 = mysqli_query($GLOBALS['connection'], $consultaCatedra);
    while ($data2 = mysqli_fetch_assoc($query5)) {
        array_push($catedras, array($data2['nombre'],0));
    }
    array_push($catedras,array ("Total",0));
}
function agregarCarrera($invCarrera){
    $carreras = $GLOBALS['carreras'];
    for ($i = 0; $i<count($carreras);$i++) {
         if($carreras[$i][0] == $invCarrera){
         $carreras[$i][1]++;
         $carreras[count($carreras)-1][1]++;
         }
    }
    $GLOBALS['carreras'] = $carreras;
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

function agregarEstadoGeneral($invEstado){
    $estados = $GLOBALS['estados'];
    for ($i = 0; $i<count($estados);$i++) {
         if($estados[$i][0] == $invEstado){
         $estados[$i][1]++;
         $estados[count($estados)-1][1]++;
         }
    }
    $GLOBALS['estados'] = $estados;
    
}

function agregarCatedra($invCatedra){
    $catedras = $GLOBALS['catedras'];
    for ($i = 0; $i<count($catedras);$i++) {
         if($catedras[$i][0] == $invCatedra){
         $catedras[$i][1]++;
         $catedras[count($catedras)-1][1]++;
         }
    }
    $GLOBALS['catedras'] = $catedras;
}