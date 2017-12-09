<?php

require('email.php');

//session_start();

$arrayCorreos = array();
$arrayCorreosIE = array();

$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");

if ($connection) {

    //para TFG
    $sentenciaSQL = "select tfg.titulo, tfg.fechaFinal, A.tfg, A.numero, (select fechaEntrega from tfgetapas  where numero = A.numero and tfg = A.tfg) as fecha
                        from (
                        select tfg, MAX(numero) as numero, fechaEntrega from tfgetapas
                        where estado = 'Aprobada' || estado = 'Aprobada con Observaciones'
                        group by tfg) A, tfg 
                        where tfg.codigo= A.tfg and tfg.estado = 'Activo'; 
                    ";
    $resultado = mysqli_query($connection, $sentenciaSQL);


    while ($data = mysqli_fetch_assoc($resultado)) {
        
          echo "Encontro para TFG "." numero ". $data['numero'] ." codigo: ".$data['tfg'] . "<br>";

        $sentenciaFechaSQL = "select fechaEntrega from tfgetapas where numero = " . ($data["numero"] + 1) . " and tfg = '" . $data["tfg"] . "'";
        $resultadoFecha = mysqli_query($connection, $sentenciaFechaSQL);
        $dataFecha = mysqli_fetch_assoc($resultadoFecha);
        echo "fecha final ". $data["fechaFinal"] . "<br/>";
        if (($data["numero"] + 1) < 4) {
            $nuevafecha = strtotime('-7 day', strtotime($dataFecha["fechaEntrega"]));
            $nuevafecha = date('Y/m/d', $nuevafecha);
            echo "fecha final - 7 dias ". $nuevafecha . "<br/>";
            $fecha_actual = date("Y/m/d");
            if ($fecha_actual === $nuevafecha) { // una semana antes de la entrega
                //conseguir todos los correos
                echo "este tfg tiene q mandar correos: " . $data['tfg'] . "<br/>";

                //estudiantes
                $sentenciaEstudiantes = "select tfgestudiantes.correo from tfg, tfgestudiantes, tfgrealizan
                                    where tfg.codigo = tfgrealizan.tfg and tfgestudiantes.id = tfgrealizan.estudiante and
                                    tfgrealizan.estado= 1 and tfg.codigo = '" . $data['tfg'] . "'";
                $resultadoEstudiantes = mysqli_query($connection, $sentenciaEstudiantes);
                while ($data2 = mysqli_fetch_assoc($resultadoEstudiantes)) {
                    array_push($arrayCorreos, $data2["correo"]);
                }

                //director
                $sentenciaDirector = "select tfgdirectores.correo from tfg, tfgdirectores 
                                    where tfg.directortfg = tfgdirectores.id and tfg.codigo = '" . $data['tfg'] . "'";
                $resultadoDirector = mysqli_query($connection, $sentenciaDirector);
                $data3 = mysqli_fetch_assoc($resultadoDirector);
                array_push($arrayCorreos, $data3["correo"]);

                //encargado
                $sentenciaEncargado = "select tfgencargados.correo from tfg, tfgencargados 
                                    where tfg.encargadotfg = tfgencargados.id and tfg.codigo = '" . $data['tfg'] . "'";
                $resultadoEncargado = mysqli_query($connection, $sentenciaEncargado);
                $data4 = mysqli_fetch_assoc($resultadoEncargado);
                array_push($arrayCorreos, $data4["correo"]);

                //asesores
                $sentenciaAsesores = "select tfgasesores.correo from tfg, tfgasesores, tfgasesoran
                                where tfg.codigo = tfgasesoran.tfg and tfgasesores.id = tfgasesoran.asesor and
                                tfgasesoran.estado= 1 and tfg.codigo = '" . $data['tfg'] . "'";
                $resultadoAsesores = mysqli_query($connection, $sentenciaAsesores);
                while ($data5 = mysqli_fetch_assoc($resultadoAsesores)) {
                    array_push($arrayCorreos, $data5["correo"]);
                }

                // miembros
                $sentenciaMiembros = "select tfgmiembroscomision.correo from tfg, tfgmiembroscomision, tfgevaluan
                                where tfg.codigo = tfgevaluan.tfg and tfgmiembroscomision.id = tfgevaluan.miembrocomisiontfg and
                                tfgevaluan.estado= 1 and tfg.codigo = '" . $data['tfg'] . "'";
                $resultadoMiembros = mysqli_query($connection, $sentenciaMiembros);
                while ($data6 = mysqli_fetch_assoc($resultadoMiembros)) {
                    array_push($arrayCorreos, $data6["correo"]);
                }

                foreach ($arrayCorreos as $correo) {
                    echo $correo . "<br/>";
                }

                $info = array();
                array_push($info, $data['titulo'], $data['numero'] + 1, $nuevafecha);
                alarmaTFG($info, $arrayCorreos);
            }
        }
    }
  


    //termina TFG

    $sentenciaSQLIE = "select ieproyectos.titulo, ieproyectos.fechaFinal, A.proyecto,
                        A.numero, (select fechaEntrega from ieetapas  where numero = A.numero and proyecto = A.proyecto) as fecha
                        from (
                        select proyecto, MAX(numero) as numero, fechaEntrega from ieetapas
                        where estado = 'Aprobada' || estado = 'Aprobada con Observaciones'
                        group by proyecto) A, ieproyectos 
                        where ieproyectos.codigo= A.proyecto and ieproyectos.estado = 'Activo'; 
                       ";
    $resultadoIE = mysqli_query($connection, $sentenciaSQLIE);


    while ($dataIE = mysqli_fetch_assoc($resultadoIE)) {
       
        $sentenciaFechaSQL = "select fechaEntrega from ieetapas where numero = " . ($dataIE["numero"] + 1) . " and proyecto = '" . $dataIE["proyecto"] . "'";
        $resultadoFecha = mysqli_query($connection, $sentenciaFechaSQL);
        $dataFecha = mysqli_fetch_assoc($resultadoFecha);

        if (($dataIE["numero"] + 1) < 4) {
            echo 'nombre Proyecto: '.$dataIE["proyecto"]. "<br/>";
            echo 'fecha de entrega: '.$dataFecha['fechaEntrega']."<br/>";
            $nuevafechaIE = strtotime('-7 day', strtotime($dataFecha["fechaEntrega"]));
            $nuevafechaIE = date('Y/m/d', $nuevafechaIE);
            echo "fecha final - 7 dias ". $nuevafechaIE . "<br/><br/>";
            $fecha_actualIE = date("Y/m/d");
          
            if ($fecha_actualIE === $nuevafechaIE) { // una semana antes de la entrega
                //conseguir todos los correos
                echo "este proyecto tiene q mandar correos: " . $dataIE['proyecto'] . "<br/>";

                //investigadores
                $sentenciaInvestigadoresIE = "select ieinvestigadores.correo from ieproyectos, ieinvestigadores, ieinvestigan
                                    where ieproyectos.codigo = ieinvestigan.proyecto and ieinvestigadores.id = ieinvestigan.investigador and
                                    ieinvestigan.estado= 1 and ieproyectos.codigo = '" . $dataIE['proyecto'] . "'";
                $resultadoInvestigadoresIE = mysqli_query($connection, $sentenciaInvestigadoresIE);
                while ($data2IE = mysqli_fetch_assoc($resultadoInvestigadoresIE)) {
                    array_push($arrayCorreosIE, $data2IE["correo"]);
                }

                //coordinador
                $sentenciaCoordiandorIE = "select iecoordinadoresinvestigacion.correo from ieproyectos, iecoordinadoresinvestigacion 
                                    where ieproyectos.coordinador = iecoordinadoresinvestigacion.id and ieproyectos.codigo = '" . $dataIE['proyecto'] . "'";
                $resultadoCoordiandorIE = mysqli_query($connection, $sentenciaCoordiandorIE);
                $data3IE = mysqli_fetch_assoc($resultadoCoordiandorIE);
                array_push($arrayCorreosIE, $data3IE["correo"]);



                //evaluadores
                $sentenciaAsesoresIE = "select ieevaluadores.correo from ieproyectos, ieevaluadores, ieevaluan
                                where ieproyectos.codigo = ieevaluan.proyecto and ieevaluadores.id = ieevaluan.evaluador and
                                ieevaluan.estado= 1 and ieproyectos.codigo = '" . $dataIE['proyecto'] . "'";
                $resultadoAsesoresIE = mysqli_query($connection, $sentenciaAsesoresIE);
                while ($data5IE = mysqli_fetch_assoc($resultadoAsesoresIE)) {
                    array_push($arrayCorreosIE, $data5IE["correo"]);
                }


                //comiex
                $sentenciaComiexIE = "select iemiembroscomiex.correo from ieproyectos, iemiembroscomiex, ierevisan
                                where ieproyectos.codigo = ierevisan.proyecto and iemiembroscomiex.id = ierevisan.miembrocomiex and
                                ierevisan.estado= 1 and ieproyectos.codigo = '" . $dataIE['proyecto'] . "'";
                $resultadoComiexIE = mysqli_query($connection, $sentenciaComiexIE);
                while ($data6IE = mysqli_fetch_assoc($resultadoComiexIE)) {
                    array_push($arrayCorreosIE, $data6IE["correo"]);
                }


                //falta mandar correos todos estan en la variable $arrayCorreosIE y en $data['numero']+1 esat el numero de la etapa

                foreach ($arrayCorreosIE as $correo) {
                    echo $correo . "<br/>";
                }

                $infoIE = array();
                array_push($infoIE, $dataIE['titulo'], ($dataIE['numero']+1), $nuevafechaIE);
                alarmaIE($infoIE, $arrayCorreosIE);
            }
        }
    }
    


    mysqli_close($connection);
    
    exit();
}

