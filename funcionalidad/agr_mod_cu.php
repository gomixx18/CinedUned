<?php


if (isset($_POST["agregarCU"])) {
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if ($connection) {
        $sentenciaSQL = "INSERT INTO centrosuniversitarios (codigo, nombre) VALUES (" . $codigo . ", '" . $nombre . "')";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_centros_universitarios.php");
    exit();
}

if (isset($_POST["modificarCU"])) {
    $nombre = $_POST["nombre"];
    $id = $_POST["codigo"];
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

    if ($connection) {
        $sentenciaSQL = "UPDATE centrosuniversitarios SET nombre = '" . $nombre . "', codigo ='" . $id . "' WHERE codigo ='" . $id . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL);
        mysqli_close($connection);
    }
    header("Location: ../admin_centros_universitarios.php");
    exit();
}


header("Location: ../index.php");