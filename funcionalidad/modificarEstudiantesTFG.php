<?php

session_start();

$c = "codigo";
$codigo = $_POST[$c];




$arrayDocentes = array();
for ($i = 1;
$i < 7;
$i++) {
$s = "nameEstudiante" . $i;
if (isset($_POST[$s])) {
array_push($arrayDocentes, $_POST[$s]);
}
}



$arrayDocentesOriginales = array();




$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if ($connection) {


$sqlDocentes = "select tfgestudiantes.id from tfg,tfgestudiantes, tfgrealizan where tfg.codigo = tfgrealizan.tfg and tfgrealizan.estudiante = tfgestudiantes.id and tfg.codigo ='" . $codigo . "'";
$resultadoDocentes = mysqli_query($connection, $sqlDocentes);

while ($data = mysqli_fetch_assoc($resultadoDocentes)){

array_push($arrayDocentesOriginales, $data["id"]);
}



foreach ($arrayDocentes as $docente){

if(in_array($docente, $arrayDocentesOriginales)){ // esta en los docentes originales


if($_POST["activo" . $docente] === "0"){ // se inactivo

$sentenciaSQL = "UPDATE tfgrealizan SET estado = 0 WHERE estudiante ='" . $docente . "' and tfg = '$codigo'";
$resultado = mysqli_query($connection, $sentenciaSQL);
}
if($_POST["activo" . $docente] === "1"){ // se inactivo

$sentenciaSQL = "UPDATE tfgrealizan SET estado = 1 WHERE estudiante ='" . $docente . "' and tfg = '$codigo'";
$resultado = mysqli_query($connection, $sentenciaSQL);
}

}else{ //es nuevo

if($_POST["activo" . $docente]=== "1"){ // hay q meterlo

$sqlDocentes = "INSERT INTO tfgrealizan (estudiante, tfg, estado) VALUES ('".$docente."', '".$codigo."', 1)";
$resultadoDocentes = mysqli_query($connection, $sqlDocentes);
}
}
}



mysqli_close($connection);
}




echo '<html>';

echo '<head>';
echo '<title></title>';
echo '<script src="js/bootstrap.min.js"></script>';
echo '<link href="css/bootstrap.min.css" rel="stylesheet">';

echo '</head>';

echo '<body onload="enviar()" hidden>';
echo '<script language="JavaScript">';
echo 'function enviar(){';
echo 'document.form.submit();';
echo '}';
echo '</script>';
echo '<form id="form" name="form" method="POST" action="../modificar_TFG.php" >';
echo '<input type="text" value="'. $codigo. '" name="codigo" />';
echo '<input type="text" value="Modificación de estudiantes" name="estudiantes" />';
echo '<input type="text" value="estudiante" name="tabSelect" />';
echo '</form>';






echo '</body>';
echo '</html>';



