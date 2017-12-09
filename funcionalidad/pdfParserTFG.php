<?php

// Include the main TCPDF library (search for installation path).

require_once('../tcpdf/tcpdf.php');
include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';
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

// extend TCPF with custom functions
class MYPDF extends TCPDF {

}



// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha = date('d-m-Y g:i:s a');
$nombre = 'Creado por: '.$usuarioSesion->getNombre() . " " . $usuarioSesion->getApellido1() . " " . $usuarioSesion->getApellido2(). "\n" ."Fecha de Creación: " .$fecha; 
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($nombre);
$pdf->SetTitle("Reporte Trabajos Finales de Graduación (TFG)");
$pdf->SetSubject('Reporte Trabajos Finales de Graduación (TFG)');



 
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
   border: 1px solid #black;
   font-weight: bold;
}

h3{
    font-size: small;
}
h4{
    font-size: xx-small;
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

.block{
    height: 50px;
}
</style>

<table align="center">';


if($estadistica == 'false'){
$html = $html.'<thead>
<tr bgcolor="#00519E" color="white">
  <th>Código del TFG</th>
  <th>Nombre del TFG</th>   
  <th>Carrera</th>
  <th>Estado General</th>
  <th>Estado de Etapas</th>
  <th>Director</th>
  <th>Asesor 1</th>
  <th>Asesor 2</th>
  <th>Línea de Investigación</th>
</tr>
</thead> ';
}
obtenerModalidades();
obtenerLineasInvestigacion();
obtenerCarreras();
CrearEstados();
$query = mysqli_query($connection, $consulta);
if(mysqli_num_rows($query) != 0){
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
    $html = $html."<tbody>";
    $html = $html."<tr>";
    $html = $html."<td>".$data2['tfg']."</td>";
    $html = $html."<td>".$proyecto['titulo']."</td>";
    $html = $html."<td>".$proyecto['carrera']."</td>";
    $html = $html."<td>".$proyecto['estado']."</td>";
    $html = $html."<td>".
            "Etapa #1: ".$etapa1['estado'].
            "<br>Etapa #2: ".$etapa2['estado'].
            "<br>Etapa #3: ".$etapa3['estado'].
            "</td>";
    $html = $html."<td>".$proyecto['director']."</td>";
    $html = $html."<td>".$asesor1."</td>";
    $html = $html."<td>".$asesor2."</td>";
    $html = $html."<td>".$proyecto['linea']."</td>";
    $html = $html."</tr>";
    $html = $html."</tbody>";
    }
    unset($asesor1);
    unset($asesor2);
}
}else{
    $html = $html.'<tr> <td align="center" colspan="9" bgcolor="#ed5565"><p>NO existen Registros</p></td> </tr>';
}


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 15, PDF_HEADER_TITLE,  $nombre);

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

// column titles
//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)',);

// data loading
//$data = $pdf->LoadData('data/table_data_demo.txt');
//$pdf->SetFillColor(26, 179, 148);
$html = $html.'</table> <div>'.  innerModalidades(). innerLineas().  innerCarreras().  innerEstados().'</div>';
//echo $html;
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', false);

// print colored table
//$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('Reporte TFG', 'I');


exit();

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

function innerModalidades(){
    
    $html = '<div class="block"> <h3>Modalidades</h3><p> <ol>';
    foreach ($GLOBALS['modalidades'] as $modalidad) {
        $html = $html."<li>".$modalidad[0].": ".$modalidad[1]."</li>";
    }
    return $html."</p></ol>";
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