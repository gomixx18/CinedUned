<?php

require("../funcionalidad/email.php");
/* 
    Este Archivo no se utiliza dentro de la applicacion.
 */
    $id = "USCTFGEDU";
    $clave = "EDUTFG16";
    $database = "SAEDATP";
    $hostname =  's1030557';
    $server = "Driver={Client Access ODBC Driver (32-bit)};System=$hostname;Uid=$id;Pwd=$clave;";
    
    $exitoso = 0;
    $error = 0;
    $update = 0;
    $total = 0;
    
    
    
    
    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
    $conn = odbc_connect($server,$id,$clave);

 
    echo "CODIGO;CEDULA; APELLLIDO1; APELLIDO2; NOMBRE;CORREO;CU;<br>";

$query =    "select estudiante.ESTCED as cedula, estudiante.ESTNOM as nombre, estudiante.ESTAP1 as ap1, estudiante.ESTAP2 as ap2, estudiante.ESTCUN as cu, "
            . "correo.CORCUE as correo, matricula.CURASG as asignatura "
            . "from SAEDATP.ESTARC  estudiante "
            . "left outer join SAEDATP.CORAR1 correo on estudiante.ESTCED = correo.CORCE1 "
            . "inner join SAEDATP.CURARC matricula on estudiante.ESTCED = matricula.CURCED " 
            . "where matricula.CURASG in ('02177', '09727', '09751', '09748', '09752','02163','00340','00393','00360','02166','09722','00370','02171','02042','09726','02174','09744','09724') "
            . "and matricula.CURAOE = '2016' order by CURASG";

$result = odbc_exec($conn,$query);


 while($data = odbc_fetch_array($result)){
  
     $nombre = utf8_encode($data["NOMBRE"]);
     $apellido1 =  utf8_encode($data["AP1"]);
     $apellido2 =  utf8_encode($data["AP2"]);
     $correo = utf8_encode($data["CORREO"]);
     $pass = "a" . substr(md5(microtime()), 1, 7);
     
     echo  $data["ASIGNATURA"].";".$data["CEDULA"].";". $apellido1.";".$apellido2.";".$nombre.";".$correo.";".$data["CU"].";<br>";
     $sentenciaSQL = "INSERT INTO tfgestudiantes (id, nombre, apellido1, apellido2, password, correo, estado ,cu, codigo, telefono) VALUES ('". $data["CEDULA"] ."' , '". $nombre ."', '". $apellido1 ."', '". $apellido2 ."', '" .$pass ."', '". $correo ."', 1, ". $data["CU"] . ", ". $data["ASIGNATURA"] .", ' ' )";
     $resultado = mysqli_query($connection, $sentenciaSQL); 
     $sentenciaSQLexist = "SELECT * FROM usuarios where id= '". $data["CEDULA"] . "'";
     $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
     if(mysqli_num_rows($resultadoExist) == 0){
        $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('". $data["CEDULA"] ."' , '". $pass ."', true, false, false, false, false, false, false, false, false)";
        $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios); 
        $exitoso++;
        $total++;
            }else{
                $sentenciaSQL = "UPDATE tfgestudiantes SET nombre = '" . $nombre . "', apellido1 ='" . $apellido1 . "', apellido2 ='" . $apellido2 . "', correo ='" .$correo . "', estado =". 1 . ", cu ='" . $data["CU"] . "', codigo ='" . $data["ASIGNATURA"] ."' WHERE id ='" . $data["CEDULA"] . "'";
                $update++;
                $total++;
                $resultado = mysqli_query($connection, $sentenciaSQL);
               
            }

            
        
 }
 
 echo "Exitoso: ". $exitoso."<br>";
 echo "Actualizados: ".$update."<br>";
 echo "Total: ".$total."<br>"; 
 
 

