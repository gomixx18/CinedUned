<?php

session_start();
if (isset($_POST["agregarAsignatura"])) {
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "INSERT INTO asignaturas (codigo, nombre) VALUES (" . $codigo . ", '" . $nombre . "')";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_asignaturas.php");
    exit();
}

if (isset($_POST["modificarAsginatura"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["codigo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE asignaturas SET nombre = '" . $nombre . "', codigo ='" . $id . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_asignaturas.php");
    exit();
}

if (isset($_GET["codigo"])) {  
    $codigo = $_GET["codigo"];
    $id = "USCTFGEDU";
    $clave = "EDUTFG16";
    $database = "SAEDATP";
    $hostname =  's1030557';
    $server = "Driver={Client Access ODBC Driver (32-bit)};System=$hostname;Uid=$id;Pwd=$clave;";
    $conn = odbc_connect($server,$id,$clave);
  

    if(!$conn){
    echo 'db_error';
    exit();
    }
    $query = "select ASGDES from SAEDATP.ASGARC where ASGCOD = '".$codigo."'";
    $result = odbc_exec($conn,$query);
    if(!$result){
    echo 'error';
    exit();
    }
    $nombre = odbc_fetch_array($result);
    if($nombre["ASGDES"] == ''){
        echo "noEncontro";
    }else{
        echo $nombre["ASGDES"];
    }
}

//header("Location: ../index.php");