<?php

// Include the main TCPDF library (search for installation path).

require_once('../tcpdf/tcpdf.php');
include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';
@session_start();
date_default_timezone_set('America/Costa_Rica');

$usuarioSesion = $_SESSION["user"];
$usuarioPermisos = $_SESSION['permisos'];
$consulta = $_SESSION['pdfIE'];
$estadistica = $_SESSION['estadistica'];
unset($_SESSION['estadistica']);

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if(!isset($consulta)){
    header("Location: ../ReportesInvestigacion.php.php");
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

// extend TCPF with custom functions
class MYPDF extends TCPDF {


}



// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$nombre = 'Creado por: '.$usuarioSesion->getNombre() . " " . $usuarioSesion->getApellido1() . " " . $usuarioSesion->getApellido2(); 
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($nombre);
$pdf->SetTitle("Reporte Investigación");
$pdf->SetSubject('Reportes de Investigación');
$fecha = date('d-m-Y g:i:s a');


 
$html = '<style>   
tr, td {
   
    border: 1px solid #00519E;
    font-size: xx-small;
    color: black;
    text-align: justify;
    text-justify: inter-word;
    
}

th{
   text-align: center;
   font-weight: bold;
}

h4{
    font-size: normal;
}
h3{
    font-size: small;
}

h4,h3{
    color: #00519E;
}
p{
    color: #00519E;
}

table {
    border-collapse: collapse;
    width: 100%;   
}
</style> 

<p>fecha de creación: '.$fecha.'</p>
        
<table align="center">';
if($estadistica == 'false'){
$html = $html.'<thead>
<tr bgcolor="#00519E" color="white">
  <th>Código del Proyecto</th>
  <th>Título del proyecto</th>   
  <th>Carrera</th>
  <th>Estado General</th>
  <th>Estado de Etapas</th>
  <th>Coordinador</th>
  <th>Evaluador 1</th>
  <th>Evaluador 2</th>
  <th>Línea de Investigación</th>
</tr>
</thead> ';
}

obtenerLineasInvestigacion();
obtenerCarreras();
obtenerCatedras();
CrearEstados();
$query = mysqli_query($connection, $consulta);
if(mysqli_num_rows($query) != 0){
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
    $html = $html."<tbody>";
    $html = $html."<tr>";
    $html = $html."<td>".$data2['proyecto']."</td>";
    $html = $html."<td>".$proyecto['titulo']."</td>";
    $html = $html."<td>".$proyecto['carrera']."</td>";
    $html = $html."<td>".$proyecto['estado']."</td>";
    $html = $html."<td>".
            "Etapa #1: ".$etapa1['estado'].
            "<br>Etapa #2: ".$etapa2['estado'].
            "<br>Etapa #3: ".$etapa3['estado'].
            "</td>";
    $html = $html."<td>".$proyecto['coordinador']."</td>";
    $html = $html."<td>".$evaluador1."</td>";
    $html = $html."<td>".$evaluador2."</td>";
    $html = $html."<td>".$proyecto['linea']."</td>";
    $html = $html."<td>".$proyecto['catedra']."</td>";
    $html = $html."</tr>";
    $html = $html."</tbody>";
    }
    unset($evaluador1);
    unset($evaluador2);
}
}else{
   $html = $html.'<tr> <td align="center" colspan="9" bgcolor="#ed5565"><p>NO existen Registros</p></td> </tr>';
}


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 15, 'Reportes de Investigación',  $nombre);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

$pdf->Ln(5);

// data loading
$html = $html.'</table> <div>'.  innerLineas().  innerCarreras().  innerCatedras().  innerEstados()."</div>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', false);


// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('Reporte Investigacion', 'I');

exit();

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


function innerLineas(){
    $html = '<h3>Líneas de Investigación</h3><p> <ol>';
    foreach ($GLOBALS['lineas'] as $linea) {
        $html = $html."<li>".$linea[0].": ".$linea[1]."</li>";
    }
    return $html."</p></ol>";
}

function innerCarreras(){
    $html = '<h3>Carreras</h3><p> <ol>';
    foreach ($GLOBALS['carreras'] as $carrera) {
        $html = $html."<li>".$carrera[0].": ".$carrera[1]."</li>";
    }
    return $html."</p></ol>";
}

function innerEstados(){
    $html = '<h3>Estado General</h3><p> <ol>';
    foreach ($GLOBALS['estados'] as $estado) {
        $html = $html."<li>".$estado[0].": ".$estado[1]."</li>";
    }
    return $html."</p></ol></div>";
}

function innerCatedras(){
    $html = '<h3>Catedras</h3><p> <ol>';
    foreach ($GLOBALS['catedras'] as $catedra) {
        $html = $html."<li>".$catedra[0].": ".$catedra[1]."</li>";
    }
    return $html."</p></ol>";
}


