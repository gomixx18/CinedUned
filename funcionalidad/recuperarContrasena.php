<?php

//Enviar correo a un usuario que olvido la contrasena.
//En ese correo va un url unico para reestablecer contrasena.
require("email.php");

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
$id = $_POST['cedula'];
$pass = "a" . substr(md5(microtime()), 1, 7);

if ($connection) {
    //verificar que existe

    $sentencia = $connection->prepare('SELECT id FROM usuarios WHERE id = ?');
    $sentencia->bind_param('s', $id);
    $sentencia->execute();
    $sentencia->store_result();
    

    if ($sentencia->num_rows == 0) {
        $response_array['status'] = 'error';
    } else {
        $s2 = "SELECT * FROM usuarios where id= ". $id;
        $result2 = mysqli_query($connection, $s2);
        $usuario = mysqli_fetch_assoc($result2);
        if ($usuario['encargadotfg']) {
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM tfgencargados where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $sentencia->close();
            $response_array['status'] = 'success';
            sendPassReset($id, $correo,  $connection);
            echo json_encode($response_array);
        }
        if ($usuario['asesortfg']) {
            
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM tfgasesores where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $sentencia->close();
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
            
            
        }
        if ($usuario['directortfg']) {

            $sentenciaSQLespecifica = "SELECT nombre, correo FROM tfgdirectores where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
           
           
        }
        if ($usuario['estudiante']) {
            
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM tfgestudiantes where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];  
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
           
         
           
          
        }
        if ($usuario['miembrocomisiontfg']) {
            
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM tfgmiembroscomision where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
            
            
        }
        if ($usuario['investigador']) {
            
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM ieinvestigadores where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
            
           
        }
        if ($usuario['coordinadorinvestigacion']) {
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM iecoordinadoresinvestigacion where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $connection );
            echo json_encode($response_array);
            
            
        }
        if ($usuario['evaluador']) {
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM ieevaluadores where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
            
            
        }
        if ($usuario['miembrocomiex']) {
            $sentenciaSQLespecifica = "SELECT nombre, correo FROM iemiembroscomiex where id= " . $id;
            $resultadoEspecifico = mysqli_query($connection, $sentenciaSQLespecifica);
            $row = mysqli_fetch_assoc($resultadoEspecifico);
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $response_array['status'] = 'success';
            sendPassReset($id, $correo, $nombre,  $connection);
            echo json_encode($response_array);
            
        }

        
    }
    $sentencia->close();
    
    exit();

} else {
    $response_array['status'] = 'db_conn_error';
    echo json_encode($response_array);
}


