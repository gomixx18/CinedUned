<?php

session_start();
if (isset($_POST["TFGModificarEstudiante"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
    $telefono = $_POST["telefono"];
    $asignatura = $_POST['asignatura'];
    $cu = $_POST['cu'];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE tfgestudiantes SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "', estado =". $estado . ", cu ='" . $cu . "', codigo ='" . $asignatura."', telefono ='" . $telefono."' WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
       // echo $sentenciaSQL;
        mysqli_close($connection);
    }
    header("Location: ../admin_estudiante.php");
}

if (isset($_POST["TFGModificarDirector"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $titulo = $_POST["titulo"];
    $telefono = $_POST["telefono"];
    $especialidad = $_POST["especialidad"];
    $estado = $_POST["estado"];
    $correo = $_POST["correo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgdirectores SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', titulo ='" . $titulo .  "', especialidad ='" . $especialidad .   "', correo ='" . $correo . "', telefono='". $telefono . "',estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_directores.php");
}

if (isset($_POST["TFGModificarEncargado"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $estado = $_POST["estado"];
    $correo = $_POST["correo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE tfgencargados SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "', estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_encargados.php");
}

if (isset($_POST["TFGModificarAsesor"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $titulo = $_POST["titulo"];
    $telefono = $_POST["telefono"];
    $especialidad = $_POST["especialidad"];
    $estado = $_POST["estado"];
    $correo = $_POST["correo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE tfgasesores SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', titulo ='" . $titulo .  "', especialidad ='" . $especialidad .   "' , correo ='" . $correo . "', telefono='".$telefono."',estado = $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_asesores.php");
}

if (isset($_POST["TFGModificarMiembroComision"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $estado = $_POST["estado"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE tfgmiembroscomision SET nombre = '" . $nombre . "', apellido1 ='" . $ap1 . "', apellido2 ='" . $ap2 . "', correo ='" . $correo . "',estado= $estado WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_comisionTFG.php");
}

if (isset($_POST["TFGModificarModalidad"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["codigo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE modalidades SET nombre = '" . $nombre . "', codigo ='" . $id . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_Modalidad.php");
}
// Desactivacion de usuarios
if (isset($_POST["desactivarAsesor"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgasesores SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_asesores.php");
}
if (isset($_POST["desactivarComisionTFG"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgmiembroscomision SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_comisionTFG.php");
}
if (isset($_POST["desactivarDirector"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgdirectores SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
}
if (isset($_POST["desactivarEncargado"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgencargados SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_encargados.php");
}
if (isset($_POST["desactivarEstudiante"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "UPDATE tfgestudiantes SET estado = 0 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    echo "pene :D";
    //header("Location: ../admin_estudiante.php");
}
//Activacion de usuarios
if (isset($_POST["activarAsesor"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgasesores SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_asesores.php");
}
if (isset($_POST["activarMiembroComision"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgmiembroscomision SET estado = 1 WHERE id =" . $id;
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_comisionTFG.php");
}
if (isset($_POST["activarDirector"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgdirectores SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_directores.php");
}
if (isset($_POST["activarEncargado"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgencargados SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_encargados.php");
}
if (isset($_POST["activarEstudiante"])) {
    
    $id = $_POST["cod"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {

        $sentenciaSQL = "UPDATE tfgestudiantes SET estado = 1 WHERE id ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_estudiante.php");
}

