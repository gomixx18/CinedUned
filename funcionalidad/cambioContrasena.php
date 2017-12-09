<?php
// Al crear un nuevo usuario, el ingresa a esta pagina y escribe la clave que le fue enviada y escribe su clave nueva.

session_start();
$oldPass = $_POST["oldP"];
$newPass = $_POST["newP"];
$userID = $_POST["userGet"];
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {
    //verificar si es la misma contrasena
    $passwordQuery = $connection->prepare('SELECT password FROM usuarios WHERE id= ?');
    $passwordQuery->bind_param('s', $userID);
    $passwordQuery->execute();
    $passwordQuery->store_result();
    $passwordQuery->bind_result($password);
    $passwordQuery->fetch();
    
    $p = trim($oldPass);
    $aux = strcasecmp((string) $p, (string) $password);
    $passwordQuery->close();
    if ($aux == 0) {
        $sentencia = $connection->prepare('UPDATE usuarios SET password = ? WHERE id = ? AND password = ?');
        $sentencia->bind_param('sss', $newPass, $userID, $oldPass);
        if ($sentencia->execute()) {
            $sentencia->store_result();
            mysqli_close($connection);
            $response_array['status'] = 'success';
            $sentencia->close();
            echo json_encode($response_array);
        }
        else{
            mysqli_close($connection);
            $response_array['status'] = 'error2';
            $sentencia->close();
            echo json_encode($response_array);
        }
    } else {

        mysqli_close($connection);
        $response_array['status'] = 'error';
        echo json_encode($response_array);
    }
    //cambiar en otras tablas
} else {
    $response_array['status'] = 'db_conn_error';
    echo json_encode($response_array);
}
?>