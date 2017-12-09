<?php
session_start();
if(isset($_POST["id"])){
    $id = $_POST["id"];
    $fechaInicio = $_POST['fechaInicial'];
    $fechaFinal = $_POST['fechaFinal'];
    
     $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
     
      $sentenciaSQL = "select tfg.codigo,tfg.titulo,
(select group_concat(concat_ws(' ',id, nombre, apellido1, apellido2) separator ', ') from uned_db.tfgdirectores where id = tfg.directortfg) as director,  
(select group_concat(concat_ws(' ',id,nombre,apellido1,apellido2) separator ', ') from uned_db.tfgestudiantes, uned_db.tfgrealizan as estudiante where id = estudiante.estudiante and estudiante.tfg = tfg.codigo) as estudiantes,
(select group_concat(concat('etapa ',numero),concat(': ',estado)separator ', ') as etapas from uned_db.tfgetapas where tfg = tfg.codigo ) as etapas,
(select group_concat(concat_ws(' ',id,nombre,apellido1,apellido2)separator ', ') from uned_db.tfgasesores, uned_db.tfgasesoran as asesor where id = asesor.asesor and asesor.tfg = tfg.codigo) as asesores
from uned_db.tfg as tfg
where tfg.fechainicio between STR_TO_DATE('$fechaInicio','%d-%m-%Y') and STR_TO_DATE('$fechaFinal','%d-%m-%Y') and tfg.directortfg = '$id';";
      
      $resultado = mysqli_query($connection, $sentenciaSQL);
      if(mysqli_num_rows($resultado)== 0){
          echo 'no_found';
      }else{
           $fecha = date("d-m-Y h-i-sa");
           $nombre_archivo =  "reporte_directores".$fecha.".csv"; 
           $myfile = fopen("../logs/".$nombre_archivo,'w');
           fwrite($myfile, "Registro Estudiantes;\n");
           fwrite($myfile, 'Generado:'.$fecha.";\n");
           fwrite($myfile,"CODIGO; TITULO TFG; DIRECTOR; ESTUDIANTES; ETAPAS; ASESORES; \n ");
           
           while($data = mysqli_fetch_array($resultado)){
               $fila = $data['codigo'].';'.$data['titulo'].';'.$data['director'].';'.$data['estudiantes'].';'.
                       $data['etapas'].';'.$data['asesores']."; \n ";
               fwrite($myfile,$fila);
           }
      }
   
    
    
    echo 'entro'; //json_encode(array('info'=>'nose'));  
    
}


