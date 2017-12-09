
<?php

session_start();

$c = "codigo";
$codigo = $_POST[$c];
$nuevoDirector = $_POST["radEstudiante"];



$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if ($connection) {


$sqlDocentes = "UPDATE tfg SET directortfg = '".$nuevoDirector."' WHERE codigo = '" .$codigo."'";
$resultadoDocentes = mysqli_query($connection, $sqlDocentes);



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
echo '<input type="text" value="Modificación de Director de TFG" name="estudiantes" />';
echo '<input type="text" value="director" name="tabSelect" />';
echo '</form>';






echo '</body>';
echo '</html>';





