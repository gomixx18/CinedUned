<?php

session_start();

$c = "codigo";
$codigo = $_POST[$c];




$arrayDocentes = array();
for ($i = 1; $i < 7; $i++) {
    $s = "nameAsesor" . $i;
    if (isset($_POST[$s])) {
        array_push($arrayDocentes, $_POST[$s]);
    }
}



$arrayDocentesOriginales = array();




$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if ($connection) {


    $sqlDocentes = "select ieevaluadores.id from ieproyectos,ieevaluadores, ieevaluan where ieproyectos.codigo = ieevaluan.proyecto and ieevaluan.evaluador = ieevaluadores.id and ieproyectos.codigo ='" . $codigo . "'";
    $resultadoDocentes = mysqli_query($connection, $sqlDocentes);

    while ($data = mysqli_fetch_assoc($resultadoDocentes)) {

        array_push($arrayDocentesOriginales, $data["id"]);
    }



    foreach ($arrayDocentes as $docente) {

        if (in_array($docente, $arrayDocentesOriginales)) { // esta en los docentes originales
            if ($_POST["activoAsesor" . $docente] === "0") { // se inactivo
                $sentenciaSQL = "UPDATE ieevaluan SET estado = 0 WHERE evaluador ='" . $docente . "' and proyecto = '$codigo'";
                $resultado = mysqli_query($connection, $sentenciaSQL);
            }
            if ($_POST["activoAsesor" . $docente] === "1") { // se activo
                $sentenciaSQL = "UPDATE ieevaluan SET estado = 1 WHERE evaluador ='" . $docente . "' and proyecto = '$codigo'";
                $resultado = mysqli_query($connection, $sentenciaSQL);
            }
        } else { //es nuevo
            if ($_POST["activoAsesor" . $docente] === "1") { // hay q meterlo
                $sqlDocentes = "INSERT INTO ieevaluan (evaluador, proyecto, estado) VALUES ('" . $docente . "', '" . $codigo . "', 1)";
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
echo '<form id="form" name="form" method="POST" action="../modificar_Extension.php" >';
echo '<input type="text" value="' . $codigo . '" name="codigo" />';
echo '<input type="text" value="Modificación de Evaluadores" name="estudiantes" />';
echo '<input type="text" value="evaluador" name="tabSelect" />';
echo '</form>';






echo '</body>';
echo '</html>';


