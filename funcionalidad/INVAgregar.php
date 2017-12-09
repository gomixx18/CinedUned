<?php
require("../funcionalidad/email.php");
session_start();
if (isset($_POST["INVAgregarInvestigador"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $isEstudiante = 0;
    if($_POST["isEstudiante"] === "on"){
        $isEstudiante = 1;
    }
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $tipo = "Investigador";
    $pass = "a" . substr(md5(microtime()), 1, 7);
    $catedra = $_POST["catedra"];
    $carrera = $_POST["carrera"];

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
        $sentenciaSQL = "INSERT INTO ieinvestigadores (id, nombre, apellido1, apellido2, password, correo, isEstudiante, estado, unidadAcademica) VALUES ('" . $id . "', '" . $nombre . "', '" . $ap1 . "', '" . $ap2 . "', '" . $pass . "', '" . $correo . "',$isEstudiante , 1, '$unidadAcademica')";
        $resultado = mysqli_query($connection, $sentenciaSQL);

        $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $id . "'";
        $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
        if(mysqli_num_rows($resultadoExist) == 0){
            $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $id ."', '". $pass ."', false, false, false, false, false, true, false, false, false)";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }
        else{
            $sentenciaSQLusarios = "UPDATE usuarios SET investigador = true WHERE id= '". $id . "'";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }

        newUserMail($id, $pass, $nombre,$tipo, $correo);
        mysqli_close($connection);
    }   
   

    header("Location: ../admin_investigador.php");
}

if (isset($_POST["INVAgregarCoordinador"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $tipo = "Coordinador de Investigación";
    $pass = "a" . substr(md5(microtime()), 1, 7);

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "INSERT INTO iecoordinadoresinvestigacion (id, nombre, apellido1, apellido2, password, correo, estado) VALUES ('" . $id . "', '" . $nombre . "', '" . $ap1 . "', '" . $ap2 . "', '" . $pass . "', '" . $correo . "', 1)";
        $resultado = mysqli_query($connection, $sentenciaSQL);

        $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $id . "'";
        $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
        if(mysqli_num_rows($resultadoExist) == 0){
            $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $id ."', '". $pass ."', false, false, false, false, false, false, true, false, false)";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }
        else{
            $sentenciaSQLusarios = "UPDATE usuarios SET coordinadorinvestigacion = true WHERE id= '". $id."'";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }

       newUserMail($id, $pass, $nombre,$tipo, $correo);
        mysqli_close($connection);
    }
    


    header("Location: ../admin_coordinadorInv.php");
}

if (isset($_POST["INVAgregarEvaluador"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $tipo = "Evaluador";
    $pass = "a" . substr(md5(microtime()), 1, 7);
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "INSERT INTO ieevaluadores (id, nombre, apellido1, apellido2, password, correo, estado) VALUES ('" . $id . "', '" . $nombre . "', '" . $ap1 . "', '" . $ap2 . "', '" . $pass . "', '" . $correo . "', 1)";
        $resultado = mysqli_query($connection, $sentenciaSQL);

        $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $id . "'";
        $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
        if(mysqli_num_rows($resultadoExist) == 0){
            $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $id ."', '". $pass ."', false, false, false, false, false, false, false, true, false)";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }
        else{
            $sentenciaSQLusarios = "UPDATE usuarios SET evaluador = true WHERE id= '". $id."'";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }

        newUserMail($id, $pass, $nombre,$tipo, $correo);
        mysqli_close($connection);
    }
    
    header("Location: ../admin_evaluador.php");
}

if (isset($_POST["INVAgregarMiembro"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];
    $ap1 = $_POST["apellido1"];
    $ap2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $tipo = "Miembro de COMIEX";
    $pass = "a" . substr(md5(microtime()), 1, 7);
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "INSERT INTO iemiembroscomiex (id, nombre, apellido1, apellido2, correo, estado) VALUES ('" . $id . "', '" . $nombre . "', '" . $ap1 . "', '" . $ap2  . "', '" . $correo . "', 1)";
        $resultado = mysqli_query($connection, $sentenciaSQL);

        $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $id . "'";
        $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
        if(mysqli_num_rows($resultadoExist) == 0){
            $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $id ."', '". $pass ."', false, false, false, false, false, false, false, false, true)";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }
        else{
            $sentenciaSQLusarios = "UPDATE usuarios SET miembrocomiex = true WHERE id= '". $id."'";
            $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        }

        newUserMail($id, $pass, $nombre,$tipo, $correo);
        mysqli_close($connection);
    }
    header("Location: ../admin_MiembroComiex.php");
}

if (isset($_POST["INVAgregarLinea"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "INSERT INTO lineasinvestigacion (codigo, nombre) VALUES ('" . $id . "', '" . $nombre . "')";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }

    header("Location: ../admin_LineasInvestigacion.php");
}

if (isset($_POST["INVAgregarCarrera"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];

    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "INSERT INTO carreras (codigo, nombre) VALUES ('" . $id . "', '" . $nombre . "')";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }



    header("Location: ../admin_Carreras.php");
}

if (isset($_POST["INVAgregarCatedra"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["id"];


    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


    if ($connection) {
        $sentenciaSQL = "INSERT INTO catedras (codigo, nombre) VALUES ('" . $id . "', '" . $nombre . "')";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }



    header("Location: ../admin_Catedras.php");
}