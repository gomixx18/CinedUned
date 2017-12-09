<?php

session_start();
if (isset($_POST["INVModificarInvestigador"])) {
    $nombre = $_POST["nombre"];
    $isEstudiante = 0;
    if($_POST["isEstudiante"] === "on"){
        $isEstudiante = 1;
    }
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $catedra = $_POST["catedra"];
    $carrera = $_POST["carrera"];
    $estado = $_POST["estado"];
    
    $unidadAcademica = "";
    if($catedra != "Ninguna"){   
        $unidadAcademica .= $catedra . ",";
    }
    if($carrera != "Ninguna"){   
        $unidadAcademica .= $carrera. ",";
    }
    if(isset($_POST["cined"])){   
        $unidadAcademica .= "CINED". ",";
    }
    if(isset($_POST["otros"])){   
        $unidadAcademica .= "otros". ",";
    }
    
    $unidadAcademica = substr($unidadAcademica, 0, strlen($unidadAcademica)-1);
    

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {

        $sentenciaSQL = "UPDATE ieinvestigadores SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo ."', isEstudiante =" . $isEstudiante.", unidadAcademica = '".$unidadAcademica. "',estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_investigador.php");
}

if (isset($_POST["INVModificarCoordinador"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE iecoordinadoresinvestigacion SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "',estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_coordinadorInv.php");
}

if (isset($_POST["INVModificarEvaluador"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
  
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE ieevaluadores SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "', estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_evaluador.php");
}

if (isset($_POST["INVModificarMiembro"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE iemiembroscomiex SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "',estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_MiembroComiex.php");
}

if (isset($_POST["INVModificarLinea"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE lineasinvestigacion SET nombre = '" . $nombre . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_LineasInvestigacion.php");
}

if (isset($_POST["INVModificarCarrera"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE carreras SET nombre = '" . $nombre . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_Carreras.php");
}

if (isset($_POST["INVModificarCatedra"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "UPDATE catedras SET nombre = '" . $nombre . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_Catedras.php");
}

//Desactivacion de Usuarios
if (isset($_POST["desactivarMiembroComiex"])) {
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "UPDATE iemiembroscomiex SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_MiembroComiex.php");
}
if (isset($_POST["desactivarInvestigador"])) {
    
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE ieinvestigadores SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_investigador.php");
}
if (isset($_POST["desactivarEvaluador"])) {
    
    $id = $_POST["id"];
   
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE ieevaluadores SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_evaluador.php");
}
if (isset($_POST["desactivarCoordinadorInv"])) {
    
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE iecoordinadoresinvestigacion SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_coordinadorInv.php");
}
//Activar usuarios
if (isset($_POST["activarMiembroComiex"])) {
    
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE iemiembroscomiex SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_MiembroComiex.php");
}
if (isset($_POST["activarInvestigador"])) {
    
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE ieinvestigadores SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_investigador.php");
}
if (isset($_POST["activarEvaluador"])) {
    
    $id = $_POST["id"];
   
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE ieevaluadores SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_evaluador.php");
}
if (isset($_POST["activarCoordinadorInv"])) {
    
    $id = $_POST["id"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE iecoordinadoresinvestigacion SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_coordinadorInv.php");
}
