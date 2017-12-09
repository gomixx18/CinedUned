<?php
require("../funcionalidad/email.php");


session_start();
if (isset($_POST["asignaturas"])) {
    
    $asignaturas = $_POST["asignaturas"];
    $id = "USCTFGEDU";
    $clave = "EDUTFG16";
    $database = "SAEDATP";
    $hostname =  's1030557';
    $server = "Driver={Client Access ODBC Driver (32-bit)};System=$hostname;Uid=$id;Pwd=$clave;";
    $conn = odbc_connect($server,$id,$clave);
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    if(!$conn || !$connection){
        echo "db_error";
        exit();
    }
    
    $exitoso = 0;
    $error = 0;
    $update = 0;
    $total = 0;
    $fecha = date("d-m-Y h-i-sa");
    $nombre_archivo =  "registroEstudiantes".$fecha.".csv"; 
    $myfile = fopen("../logs/".$nombre_archivo,'w');
    fwrite($myfile, "Registro Estudiantes;\n");
    fwrite($myfile, 'Generado:'.$fecha.";\n");
    fwrite($myfile,"Codigos de Asignaturas Importadas:;\n");
    foreach ($asignaturas as $codigo){
        fwrite($myfile,$codigo.";\n");
    }
    fwrite($myfile,"CODIGO;CEDULA; APELLLIDO1; APELLIDO2; NOMBRE;CORREO;CU;\n");
  
    
foreach ($asignaturas as $codigo){
        $query = "select  estudiante.ESTCED as cedula, estudiante.ESTNOM as nombre, estudiante.ESTAP1 as ap1, estudiante.ESTAP2 as ap2, estudiante.ESTCUN as cu, "
                ."correo.CORCUE as correo, matricula.MTRASG as asignatura "
                ."from SAEDATP.ESTARC  estudiante "
                ."left outer join SAEDATP.CORAR1 correo on estudiante.ESTCED = correo.CORCE1 "
                ."inner join SAEDATP.MTRARC matricula on estudiante.ESTCED = matricula.MTRCED "
                ."where matricula.MTRASG = '".$codigo."' order by estudiante.ESTAP1";
        
        
        $result = odbc_exec($conn, $query);
        
while($data = odbc_fetch_array($result)){
    
     $nombre = utf8_encode($data["NOMBRE"]);
     $apellido1 =  utf8_encode($data["AP1"]);
     $apellido2 =  utf8_encode($data["AP2"]);
     $correo = utf8_encode($data["CORREO"]);
     $pass = "a" . substr(md5(microtime()), 1, 7);
     fwrite($myfile, $data["ASIGNATURA"].";".$data["CEDULA"].";". $apellido1.";".$apellido2.";".$nombre.";".$correo.";".$data["CU"]."; \n");
     $sentenciaSQL = "INSERT INTO tfgestudiantes (id, nombre, apellido1, apellido2, password, correo, estado ,cu, codigo, telefono) VALUES ('". $data["CEDULA"] ."' , '". $nombre ."', '". $apellido1 ."', '". $apellido2."', '" .$pass ."', '". $correo ."', 1, ". $data["CU"] . ", ". $data["ASIGNATURA"] .", ' ' )";
     $resultado = mysqli_query($connection, $sentenciaSQL); 
     $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $data["CEDULA"] . "'";
     $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
     if(mysqli_num_rows($resultadoExist) == 0){
        $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $data["CEDULA"] ."' , '". $pass ."', true, false, false, false, false, false, false, false, false)";
        $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        $exitoso++;
        $total++;
     }else{
        $sentenciaSQL = "UPDATE tfgestudiantes SET nombre = '" . $nombre . "', apellido1 ='" . $apellido1 . "', apellido2 ='" .$apellido2 . "', correo ='" . $correo . "', estado =". 1 . ", cu ='" . $data["CU"] . "', codigo ='" . $data["ASIGNATURA"] ."' WHERE id ='" . $data["CEDULA"] . "'";
        $resultado = mysqli_query($connection, $sentenciaSQL); 
        $update++;
        $total++;   
     }

}
}
fwrite($myfile,"Agregados: $exitoso;\nError: $error;\nActualizados: $update;\n");
fclose($myfile);
$response_array= array('nombre_archivo'=> $nombre_archivo,'agregados'=>$exitoso, 'error' => $error, 'update'=>$update);
echo json_encode($response_array);
}else{
    header("Location: ../index.php");
}


