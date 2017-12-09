<?php

if(!isset($_POST["frm_getCentros"])){
   // header("Location: ../index.php");
    echo $_POST["frm_getCentros"];
    exit();
}

/*
 
 Los campos de las tablas que debe consultar son los siguientes:
 
Información general del estudiante: Tabla ESTARC
ESTCED: Cédula
ESTNOM: Nombre
ESTAP1: Apellido 1
ESTAP2: Apellido 2
 
Correos Electrónicos: Tabla CORAR1
CORCE1: Cédula
CORCUE: Correo.
 
Tabla para identificar la matricula por asignatura: MTRARC
MTRCED: Cédula
MTRASG:  Asignatura
 
 *  */

$centros = 0; 
$id = "USCTFGEDU";
$clave = "EDUTFG16";
$database = "SAEDATP";
$hostname =  's1030557';
$server = "Driver={Client Access ODBC Driver (32-bit)};System=$hostname;Uid=$id;Pwd=$clave;";
$conn = odbc_connect($server,$id,$clave);
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
//$conexion =   db2_connect($hostname,$id,$clave);
if(!$conn || !$connection ){
    echo 'db_error';
}


$result = odbc_exec($conn,"select * from SAEDATP.CUNARC");

if(!$result){
    echo 'error';   
}

while($data = odbc_fetch_array($result)){
    
    $query = "insert into centrosuniversitarios(codigo, nombre) values (".$data['CUNCOD'].", '".$data['CUNNOM']. "');" ;

    $resultado = mysqli_query($connection,  $query);
    if($resultado){
        $centros++; 
    }
    
}
    echo $centros;
    exit();
?>

