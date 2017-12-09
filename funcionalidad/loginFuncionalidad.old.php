7<?php

include '../clases/UsuarioSimple.php';
include '../clases/UsuarioComplejo.php';
include '../clases/UsuarioPermisos.php';
include '../clases/UsuarioInvestigadorSimple.php';
include '../clases/UsuarioInvestigadorComplejo.php';

session_start();

$id = $_POST["id"];
$pass = $_POST["password"];


$connection = mysqli_connect("localhost", "root", "cined123", "uned_db");

if ($connection) {
    $sentenciaSQLexist = "SELECT * FROM usuarios where id= '" . $id . "' AND password= '" . $pass . "'";
    $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
    if (mysqli_num_rows($resultadoExist)== 0) {
        mysqli_close($connection);
        header("Location: ../login.php");
    } else {
        //llenar objeto usuario aplicacion
        $usuario = mysqli_fetch_assoc($resultadoExist);
        $usuarioPermisos = new UsuarioPermisos($id, $pass, $usuario['estudiante'], $usuario['encargadotfg'], $usuario['asesortfg'], $usuario['directortfg'], $usuario['miembrocomisiontfg'], $usuario['investigador'], $usuario['coordinadorinvestigacion'], $usuario['evaluador'], $usuario['miembrocomiex']);
        $_SESSION["permisos"] = $usuarioPermisos;

        //inicio asesores
        if($id == "admin"){
            $usuarioSesion = new UsuarioSimple($id, $pass, "", "", "", "");
            $_SESSION["user"] = $usuarioSesion;
        }
        else{
        if ($usuario['asesortfg']) {

            $sentenciaSQLespecifica = "SELECT * FROM tfgasesores where id= '" . $id . "'";
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $usuarioEspecifico = mysqli_fetch_assoc($resultadoEspecifico);
            
            if(! $usuarioEspecifico['estado']){
                mysqli_close($connection);
                header("Location: ../login.php");
                exit();
            }
            
            if ($usuario['investigador']) {

                $usuarioSesion = new UsuarioInvestigadorComplejo($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], $usuarioEspecifico['titulo'], $usuarioEspecifico['especialidad'], false);
                $_SESSION["user"] = $usuarioSesion;
            } else {
                $usuarioSesion = new UsuarioComplejo($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], $usuarioEspecifico['titulo'], $usuarioEspecifico['especialidad']);
                $_SESSION["user"] = $usuarioSesion;
            }
        } // fin asesores
        else {
            //inicio directores
            if ($usuario['directortfg']) {

                $sentenciaSQLespecifica = "SELECT * FROM tfgdirectores where id= '" . $id . "'";
                $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
                $usuarioEspecifico = mysqli_fetch_assoc($resultadoEspecifico);
                if(! $usuarioEspecifico['estado']){
                    mysqli_close($connection);
                    header("Location: ../login.php");
                    exit();
                }
                if ($usuario['investigador']) {
                    $usuarioSesion = new UsuarioInvestigadorComplejo($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], $usuarioEspecifico['titulo'], $usuarioEspecifico['especialidad'], false);
                    $_SESSION["user"] = $usuarioSesion;
                } else {
                    $usuarioSesion = new UsuarioComplejo($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], $usuarioEspecifico['titulo'], $usuarioEspecifico['especialidad']);
                    $_SESSION["user"] = $usuarioSesion;
                }
            } // fin directores
            else {
                $sentenciaSQLespecifica = ""; 
                if ($usuario['estudiante']) {
                    $sentenciaSQLespecifica = "SELECT * FROM tfgestudiantes where id= '" . $id . "'";
                } 
                if ($usuario['encargadotfg']) {
                    $sentenciaSQLespecifica = "SELECT * FROM tfgencargados where id= '" . $id . "'";
                }
                if ($usuario['miembrocomisiontfg']) {
                    $sentenciaSQLespecifica = "SELECT * FROM tfgmiembroscomision where id= '" . $id . "'";
                } 
                if ($usuario['investigador']) {
                    $sentenciaSQLespecifica = "SELECT * FROM ieinvestigadores where id= '" . $id . "'";
                } 
                if ($usuario['coordinadorinvestigacion']) {
                    $sentenciaSQLespecifica = "SELECT * FROM iecoordinadoresinvestigacion where id= '" . $id . "'";
                } 
                if ($usuario['evaluador']) {
                    $sentenciaSQLespecifica = "SELECT * FROM ieevaluadores where id= '" . $id . "'";
                } 
                if ($usuario['miembrocomiex']) {
                    $sentenciaSQLespecifica = "SELECT * FROM iemiembroscomiex where id= '" . $id . "'";
                } 


                $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
                $usuarioEspecifico = mysqli_fetch_assoc($resultadoEspecifico);
                if(! $usuarioEspecifico['estado']){
                    mysqli_close($connection);
                    header("Location: ../login.php");
                    exit();
                }
                if ($usuario['investigador']) {
                    if ($usuario['estudiante']) {
                        $usuarioSesion = new UsuarioInvestigadorSimple($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], true);
                    } else {
                        $usuarioSesion = new UsuarioInvestigadorSimple($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo'], false);
                    }
                    $_SESSION["user"] = $usuarioSesion;
                } else {
                    $usuarioSesion = new UsuarioSimple($id, $pass, $usuarioEspecifico['apellido1'], $usuarioEspecifico['apellido2'], $usuarioEspecifico['nombre'], $usuarioEspecifico['correo']);
                    $_SESSION["user"] = $usuarioSesion;
                }
            }
        }
        }

        mysqli_close($connection);
        header("Location: ../index.php");
    }
}






