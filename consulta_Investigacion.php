<!DOCTYPE html>

<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Consulta Específica Investigación</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
        <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/plugins/summernote/summernote.css" rel="stylesheet">
        <link href="css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

        <?php
        if (!isset($_POST['codigo'])) {
            header("Location: admin_Investigacion.php");
        }
        require 'navegacion/nav-lateral.php';
        ?>
    </head>
    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Consulta Específica Investigación</h2>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title panel-heading panel" id="panelEstadoFinal">
                                    <h5>Consulta Específica Investigación</h5>
                                    <a class="collapse-link">
                                        <div class="ibox-tools">
                                            <i class="fa fa-chevron-up"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $codigo = $_POST["codigo"];
                                    $arrayInvestigadores = array();
                                    $arrayInvestigadoresnom = array();
                                    $arrayInvestigadorestime = array();
                                    $arrayInvestigadorescorreo = array();
                                    $consulta = "select ieproyectos.titulo,
                                      concat(iecoordinadoresinvestigacion.nombre,' ',iecoordinadoresinvestigacion.apellido1,' ',iecoordinadoresinvestigacion.apellido2)as coordinador, iecoordinadoresinvestigacion.correo as correoCoordinador,
                                      lineasinvestigacion.nombre as lineainvestigacion,
                                      carreras.nombre as carrera,
                                      catedras.nombre as catedra,
                                      ieproyectos.estado, ieproyectos.fechaFinal, ieproyectos.coordinador as coorId
                                      from iecoordinadoresinvestigacion, ieproyectos, lineasinvestigacion,carreras,catedras
                                      where iecoordinadoresinvestigacion.id = coordinador and
                                      lineasinvestigacion.codigo = lineainvestigacion and carreras.codigo = carrera and catedras.codigo = catedra
                                      and ieproyectos.codigo = '$codigo'";

                                    $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                    if (!$connection) {
                                        exit("<label class='error'>Error de conexión</label>");
                                    }

                                    $query = mysqli_query($connection, $consulta);
                                    $data = mysqli_fetch_assoc($query);
                                    $titulo = $data["titulo"];
                                    etapas($codigo, $connection);
                                    //echo $data["estado"];
                                    ?>

                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-1">

                                            <form role="form" >


                                                <div class='form-group'>
                                                    <label>Título</label>
                                                    <input class = 'form-control' name = 'titulo' id = 'titulo' value ='<?php echo $data["titulo"] ?>' disabled>
                                                </div>

                                                <div class='form-group'>
                                                    <label>Carrera</label>
                                                    <input class = 'form-control' name = 'carrera' id = 'carrera' value ='<?php echo $data["carrera"] ?>' disabled>
                                                </div>

                                                <div class='form-group'>
                                                    <label>Cátedra</label>
                                                    <input class = 'form-control' name = 'modalidad' id = 'modalidad' value ='<?php echo $data["catedra"] ?>' disabled>
                                                </div>
                                            </form>

                                        </div>

                                        <div class="col-lg-4 col-lg-offset-1">

                                            <form role="form">
                                                <div class='form-group'>
                                                    <label>Coordinador de Investigación</label>
                                                    <input class = 'form-control' name = 'director' id = 'director' value ='<?php echo $data["coordinador"] ?>' disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Línea de Investigación</label>
                                                    <input class="form-control" placeholder="" name="linea" id="linea" value='<?php echo $data["lineainvestigacion"] ?>' disabled>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <!--fin primera informacion -->

                                    <!-- investigadores -->
                                    <div class="row">

                                        <div class="col-lg-9 col-lg-offset-1">
                                            <div class="panel panel-default">
                                                <div class="panel-body">

                                                    <label>Investigadores</label>
                                                    <br/>
                                                    <br/>
                                                    <?php
                                                    $consulta2 = "select ieinvestigadores.id, concat(ieinvestigadores.nombre,' ',  ieinvestigadores.apellido1, ' ', ieinvestigadores.apellido2) as nombre, ieinvestigadores.correo as correo, ieinvestigan.tiempoacademico "
                                                            . "from ieproyectos,ieinvestigadores, ieinvestigan where ieproyectos.codigo = ieinvestigan.proyecto and ieinvestigan.investigador = ieinvestigadores.id and ieinvestigan.estado = 1 and ieproyectos.codigo ='$codigo'";
                                                    $query2 = mysqli_query($connection, $consulta2);

                                                    while ($data2 = mysqli_fetch_assoc($query2)) {
                                                        echo "<div class='row'>";
                                                        echo "<div class='col-lg-6 col-lg-offset-1'>";
                                                        echo "<label>Nombre: " . $data2["nombre"] . "</label>";
                                                        echo "</div>";
                                                        array_push($arrayInvestigadores, $data2['id']);
                                                        array_push($arrayInvestigadoresnom, $data2['nombre']);
                                                        array_push($arrayInvestigadorestime, $data2['tiempoacademico']);
                                                        array_push($arrayInvestigadorescorreo, $data2['correo']);
                                                        echo "<div class='col-lg-5'>";
                                                        echo "<label>Cedula: " . $data2["id"] . "</label>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin investigadores -->

                                    <?php
                                    cantidadEvaluadores($codigo, $connection);

                                    evaluadores($codigo, $connection);
                                    ?>

                                    <!-- etapa 1 -->
                                    <div  class="wrapper wrapper-content animated fadeIn">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div  class="ibox collapsed">
                                                    <div id="panelEstado1" class="ibox-title panel">
                                                        <h5>Etapa #1. Evaluación</h5>
                                                        <a class="collapse-link">
                                                            <div class="ibox-tools">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </div>
                                                        </a>
                                                        <div id="etapa1" class="ibox-content">
                                                            <!-- etapa 1 -->
                                                            <!-- archivos -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Archivos</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">
                                                                            <form action="funcionalidad/CargarArchivoBlobInv.php" method="post" enctype="multipart/form-data" id="directorForm">
                                                                                <div class="row">

                                                                                    <div class="col-lg-12 ">

                                                                                    </div>

                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">COMIEX</label><br>


                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivoscomiex where proyecto = '" . $codigo . "' and etapa = 1 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                                                                <i class='fa fa-file'></i>
                                                                                                </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>
                                                                                            <?php if ($usuarioPermisos->getMiembrocomiex() && !getInvestigador($usuarioSesion->getId()) && $usuarioSesion->getId() != $data["coorId"] && !verificarEvaluador($usuarioSesion->getId())) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='1' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoComiex' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                    <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress" class="progress progress-striped active">
                                                                                                        <div  id="progressBar"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status"></h3>
                                                                                                    <p id="loaded_n_total"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">Investigadores</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosinvestigadores where proyecto ='" . $codigo . "' and etapa = 1 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                                                                    <i class='fa fa-file'></i>
                                                                                                    </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if (getInvestigador($usuarioSesion->getId()) && !verificarEvaluador($usuarioSesion->getId())) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='1' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoInvestigador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' id = 'isInvestigacion' value= '1' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress" class="progress progress-striped active">
                                                                                                        <div  id="progressBar"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status"></h3>
                                                                                                    <p id="loaded_n_total"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">

                                                                                            <label class="control-label">Evaluador 1</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador1 . "' and etapa = 1 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                                                                    <i class='fa fa-file'></i>
                                                                                                    </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if ($usuarioSesion->getId() == $evaluador1) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='1' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress" class="progress progress-striped active">
                                                                                                        <div  id="progressBar"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status"></h3>
                                                                                                    <p id="loaded_n_total"></p>
                                                                                                </div>
                                                                                            <?php } ?>


                                                                                        </div>
                                                                                        <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                            <div class="col-lg-5 col-lg-offset-1">


                                                                                                <label class="control-label">Evaluador 2</label><br>
                                                                                                <?php
                                                                                                $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador2 . "' and etapa = 1 order by fecha desc limit 1;";
                                                                                                $query3 = mysqli_query($connection, $consulta3);
                                                                                                if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                    echo " <div class=' file-box'>";
                                                                                                    echo " <div class='file'>";
                                                                                                    echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                    echo "  <span class='corner'></span> ";
                                                                                                    echo " <div class='icon'>
                                                                                                        <i class='fa fa-file'></i>
                                                                                                        </div>";
                                                                                                    echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                    echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                    echo "</div>";
                                                                                                    echo "</a>";
                                                                                                    echo "</div>";
                                                                                                    echo "</div>";
                                                                                                } else {
                                                                                                    echo "<span class='label label-warning '>No existen archivos recientes.</span><br>";
                                                                                                }
                                                                                                ?>

                                                                                                <?php if ($usuarioSesion->getId() == $evaluador2) { ?>
                                                                                                    <div class="form-group">
                                                                                                        <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                        <input class = 'form-control' name = 'etapa' id = 'etapa' value ='1' type="hidden">
                                                                                                        <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                        <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                         <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                        <label>Adjuntar Documento:</label>
                                                                                                        <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                        <div hidden id="divProgress" class="progress progress-striped active">
                                                                                                            <div  id="progressBar"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <h3 id="status"></h3>
                                                                                                        <p id="loaded_n_total"></p>
                                                                                                    </div>
                                                                                                <?php } ?>

                                                                                            </div>
                                                                                        <?php }
                                                                                        ?>

                                                                                    </div>
                                                                                    <div class="col-lg-offset-10">
                                                                                        <div class="form-group">
                                                                                            <input id="guardarArchivo1" type="submit" class="btn btn-primary btn-outline disabled" value="Guardar Archivo"disabled >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <div class="col-lg-offset-10">
                                                                                <form method="post" action='registro_archivos_investigacion.php'>
                                                                                    <div class="form-group" >
                                                                                        <input type="hidden" name='codigo' value='<?php echo $codigo ?>'>
                                                                                        <input type='hidden' name='etapa' value='1'>
                                                                                        <input id="input-1" type="submit"  class="btn btn-primary" value="Registro de Archivos">
                                                                                    </div>
                                                                                </form>
                                                                            </div>                     
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                            <!-- fin archivos -->
                                                            <?php ?>
                                                            <!-- comentarios -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Comentarios</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">
                                                                            <div class="row">

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Investigadores</h5>

                                                                                            <?php if (getInvestigador($usuarioSesion->getId())) { ?>
                                                                                                <button class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit1('CI11')" type="button">Editar</button>
                                                                                                <button id="BI11" etapa="1" comentario="CI11" class="btn btn-primary  btn-xs permiso" onclick="save1('CI11')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">
                                                                                            <div id="CI11" class="click1edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioInvestigador($codigo, 1, $connection);
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Miembro de Comiex</h5>

                                                                                            <?php if (($usuarioPermisos->getMiembrocomiex())) { ?>
                                                                                                <button class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit4('CM11')" type="button">Editar</button>
                                                                                                <button id="BM11" etapa="1" comentario="CM11" class="btn btn-primary  btn-xs permiso" onclick="save4('CM11')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">
                                                                                            <div id="CM11" class="click4edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioMiembroComiex($codigo, 1, $connection);
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Evaluador 1</h5>
                                                                                            <?php if ($usuarioPermisos->getId() == $evaluador1) { ?>
                                                                                                <button class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit2('CE11')" type="button">Editar</button>
                                                                                                <button id="BE11" etapa="1" comentario="CE11" class="btn btn-primary  btn-xs permiso" onclick="save2('CE11')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CE11" class="click2edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioEvaluador($codigo, 1, $evaluador1, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                    <div class="col-lg-6">
                                                                                        <div class="ibox float-e-margins">
                                                                                            <div class="ibox-title">
                                                                                                <h5>Evaluador 2</h5>
                                                                                                <?php
                                                                                                if ($usuarioPermisos->getId() == $evaluador2) {
                                                                                                    ?>
                                                                                                    <button class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit3('CE21')" type="button">Editar</button>
                                                                                                    <button id="BE21" etapa="1" comentario="CE21" class="btn btn-primary  btn-xs permiso" onclick="save3('CE21')" type="button">Guardar</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                                <div class="ibox-tools">
                                                                                                    <a class="collapse-link">
                                                                                                        <i class="fa fa-chevron-up"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="ibox-content no-padding">

                                                                                                <div id="CE21" class="click3edit wrapper p-md">
                                                                                                    <?php
                                                                                                    comentarioEvaluador($codigo, 1, $evaluador2, $connection);
                                                                                                    ?>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- fin comentarios -->

                                                            <!-- Estado  -->
                                                            <div class="row">
                                                                <div class="col-lg-5 col-lg-offset-1">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Estado de Etapa:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="form-group">


                                                                        <select id="estado1" class="form-control m-b permiso" name="account" onchange="pintandoPanels()"<?php
                                                                        if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                                            echo "disabled"
                                                                            ?> <?php } ?>>
                                                                            <option value="Aprobada">Aprobada</option>
                                                                            <option value="Aprobada con Observaciones">Aprobada con Observaciones</option>
                                                                            <option value="No Aprobada">No Aprobada</option>
                                                                            <option value="En ejecución">En ejecución</option>
                                                                            <option value="Inactiva">Inactiva</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                           
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?> 
                                                                            <input id="BE1" estado="estado1" etapa="1" type="button" class="btn btn-primary permiso" value="Guardar Estado">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                    </div>
                                                                <div class="col-lg-5 col-lg-offset-1">
                                                                    
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Fecha de finalización:</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="form-group" id="">
                                                                                <div class="input-group date">
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php
                                                                                    if (!$usuarioPermisos->getEncargadotfg()) {
                                                                                        echo "disabled"
                                                                                        ?> <?php } ?>
                                                                                        type="text" id="FIE1" class="form-control" value="<?php echo substr($fecha1, 0, 11) ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($usuarioPermisos->getEncargadotfg()) { ?>
                                                                            <div class="col-lg-4 col-lg-offset-1">
                                                                                <div class="form-group">
                                                                                    <input id="BFIE1" estado="FIE1" etapa="1" type="button" class="btn btn-primary" value="Guardar Fecha">
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- fin estado -->
                                                            <!-- fin etapa 1 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- fin etapa 1 -->

                                    <!-- etapa 2 -->
                                    <div class="wrapper wrapper-content animated fadeIn">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox collapsed">
                                                    <div id="panelEstado2" class="ibox-title panel ">
                                                        <h5>Etapa #2. Ante Proyecto o Propuesta</h5>
                                                        <a class="collapse-link">
                                                            <div class="ibox-tools">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </div>
                                                        </a>

                                                        <div class="ibox-content">
                                                            <!-- archivos Etapa 2 -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Archivos</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">
                                                                            <form action="funcionalidad/CargarArchivoBlobInv.php" method="post" enctype="multipart/form-data" id="directorForm">
                                                                                <div class="row">

                                                                                    <div class="col-lg-12 ">


                                                                                    </div>

                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">COMIEX</label><br>


                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivoscomiex where proyecto = '" . $codigo . "' and etapa = 2 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'><i class='fa fa-file'></i></div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>
                                                                                            <?php if ($usuarioPermisos->getMiembrocomiex() && !getInvestigador($usuarioSesion->getId()) && $usuarioSesion->getId() != $data["coorId"] && !verificarEvaluador($usuarioSesion->getId())) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='2' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoComiex' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo2" onchange="uploadFile2()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress2" class="progress progress-striped active">
                                                                                                        <div  id="progressBar2"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status2"></h3>
                                                                                                    <p id="loaded_n_total2"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">Investigadores</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosinvestigadores where proyecto ='" . $codigo . "' and etapa = 2 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'><i class='fa fa-file'></i></div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if (getInvestigador($usuarioSesion->getId()) && $usuarioSesion->getId() != $evaluador1 && $usuarioSesion->getId() != $evaluador2) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='2' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoInvestigador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' id = 'isInvestigacion' value= '2' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo2" onchange="uploadFile2()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress2" class="progress progress-striped active">
                                                                                                        <div  id="progressBar2"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status2"></h3>
                                                                                                    <p id="loaded_n_total2"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">

                                                                                            <label class="control-label">Evaluador 1</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador1 . "' and etapa = 2 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'><i class='fa fa-file'></i></div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if ($usuarioSesion->getId() == $evaluador1) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='2' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo2" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress2" class="progress progress-striped active">
                                                                                                        <div  id="progressBar2"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status2"></h3>
                                                                                                    <p id="loaded_n_total2"></p>
                                                                                                </div>
                                                                                            <?php } ?>


                                                                                        </div>
                                                                                        <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                            <div class="col-lg-5 col-lg-offset-1">


                                                                                                <label class="control-label">Evaluador 2</label><br>
                                                                                                <?php
                                                                                                $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador2 . "' and etapa = 2 order by fecha desc limit 1;";
                                                                                                $query3 = mysqli_query($connection, $consulta3);
                                                                                                if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                    echo " <div class=' file-box'>";
                                                                                                    echo " <div class='file'>";
                                                                                                    echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                    echo "  <span class='corner'></span> ";
                                                                                                    echo " <div class='icon'><i class='fa fa-file'></i></div>";
                                                                                                    echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                    echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                    echo "</div>";
                                                                                                    echo "</a>";
                                                                                                    echo "</div>";
                                                                                                    echo "</div>";
                                                                                                } else {
                                                                                                    echo "<span class='label label-warning '>No existen archivos recientes.</span><br>";
                                                                                                }
                                                                                                ?>

                                                                                                <?php if ($usuarioSesion->getId() == $evaluador2) { ?>
                                                                                                    <div class="form-group">
                                                                                                        <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                        <input class = 'form-control' name = 'etapa' id = 'etapa' value ='2' type="hidden">
                                                                                                        <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                        <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                        <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                        <label>Adjuntar Documento:</label>
                                                                                                        <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo" onchange="uploadFile()" class ="btn btn-primary btn-outline permiso">
                                                                                                        <div hidden id="divProgress" class="progress progress-striped active">
                                                                                                            <div  id="progressBar"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <h3 id="status"></h3>
                                                                                                        <p id="loaded_n_total"></p>
                                                                                                    </div>
                                                                                                <?php } ?>

                                                                                            </div>
                                                                                        <?php }
                                                                                        ?>

                                                                                    </div>
                                                                                    <div class="col-lg-offset-10">
                                                                                        <div class="form-group">
                                                                                            <input id="guardarArchivo2" type="submit" class="btn btn-primary btn-outline disabled" value="Guardar Archivo"disabled >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <div class="col-lg-offset-10">
                                                                                <form method="post" action='registro_archivos_investigacion.php'>
                                                                                    <div class="form-group" >
                                                                                        <input type="hidden" name='codigo' value='<?php echo $codigo ?>'>
                                                                                        <input type='hidden' name='etapa' value='2'>
                                                                                        <input id="input-1" type="submit"  class="btn btn-primary" value="Registro de Archivos">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- fin archivos -->

                                                            <!-- comentarios -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Comentarios</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">
                                                                            <div class="row">

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Investigador</h5>
                                                                                            <?php if (getInvestigador($usuarioSesion->getId())) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit1('CI12')" type="button">Editar</button>
                                                                                                <button id="BI12" etapa="2" comentario="CI12" class="btn btn-primary  btn-xs permiso" onclick="save1('CI12')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CI12" class="click1edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioInvestigador($codigo, 2, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Miembro Comiex</h5>
                                                                                            <?php if (($usuarioPermisos->getMiembrocomiex())) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit4('CM12')" type="button">Editar</button>
                                                                                                <button id="BM12" etapa="2" comentario="CM12" class="btn btn-primary  btn-xs permiso" onclick="save4('CM12')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CM12" class="click4edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioMiembroComiex($codigo, 2, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Evaluador 1</h5>
                                                                                            <?php if ($usuarioPermisos->getId() == $evaluador1) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit2('CE12')" type="button">Editar</button>
                                                                                                <button id="BE12" etapa="2" comentario="CE12" class="btn btn-primary  btn-xs permiso" onclick="save2('CE12')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CE12" class="click2edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioEvaluador($codigo, 2, $evaluador1, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="ibox float-e-margins">
                                                                                            <div class="ibox-title">
                                                                                                <h5>Evaluador 2</h5>
                                                                                                <?php
                                                                                                if ($usuarioPermisos->getId() == $evaluador2) {
                                                                                                    ?>
                                                                                                    <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit3('CE22')" type="button">Editar</button>
                                                                                                    <button id="BE22" etapa="2" comentario="CE22" class="btn btn-primary  btn-xs permiso" onclick="save3('CE22')" type="button">Guardar</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                                <div class="ibox-tools">
                                                                                                    <a class="collapse-link">
                                                                                                        <i class="fa fa-chevron-up"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="ibox-content no-padding">

                                                                                                <div id="CE22" class="click3edit wrapper p-md">
                                                                                                    <?php
                                                                                                    comentarioEvaluador($codigo, 2, $evaluador2, $connection);
                                                                                                    ?>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <!-- fin comentarios -->
                                                            <!-- Estado  -->
                                                            <div class="row">

                                                                <div class="col-lg-5 col-lg-offset-1">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Estado de Etapa:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="form-group">


                                                                        <select id="estado2" class="form-control m-b permiso" name="account" onchange="pintandoPanels()"<?php
                                                                        if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                                            echo "disabled"
                                                                            ?> <?php } ?>>
                                                                            <option value="Aprobada">Aprobada</option>
                                                                            <option value="Aprobada con Observaciones">Aprobada con Observaciones</option>
                                                                            <option value="No Aprobada">No Aprobada</option>
                                                                            <option value="En ejecución">En ejecución</option>
                                                                            <option value="Inactiva">Inactiva</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">

                                                                        <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?> 
                                                                            <input id="BE2" estado="estado2" etapa="2" type="button" class="btn btn-primary permiso" value="Guardar Estado">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                    </div>
                                                                 <div class="col-lg-5 col-lg-offset-1">
                                                                    
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Fecha de finalizacion:</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group" id="">
                                                                                <div class="input-group date">
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php
                                                                                    if (!$usuarioPermisos->getEncargadotfg()) {
                                                                                        echo "disabled"
                                                                                        ?> <?php } ?>
                                                                                        type="text" id="FIE2" class="form-control" value="<?php echo substr($fecha2, 0, 11) ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($usuarioPermisos->getEncargadotfg()) { ?>
                                                                            <div class="col-lg-4 col-lg-offset-1">
                                                                                <div class="form-group">
                                                                                    <input id="BFIE2" estado="FIE2" etapa="2" type="button" class="btn btn-primary" value="Guardar Fecha">
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- fin estado -->

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- fin etapa 2 -->

                                    <!-- etapa 3 -->
                                    <div class="wrapper wrapper-content animated fadeIn">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox collapsed">
                                                    <div id="panelEstado3" class="ibox-title panel ">
                                                        <h5>Etapa #3. Entrega Final</h5>
                                                        <a class="collapse-link">
                                                            <div class="ibox-tools">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </div>
                                                        </a>

                                                        <div class="ibox-content">

                                                            <!-- archivos -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Archivos</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">
                                                                            <form action="funcionalidad/CargarArchivoBlobInv.php" method="post" enctype="multipart/form-data" id="directorForm">
                                                                                <div class="row">

                                                                                    <div class="col-lg-12 ">


                                                                                    </div>

                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">COMIEX</label><br>


                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivoscomiex where proyecto = '" . $codigo . "' and etapa = 3 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                              <i class='fa fa-file'></i>
                                                              </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>
                                                                                            <?php if ($usuarioPermisos->getMiembrocomiex() && !getInvestigador($usuarioSesion->getId()) && $usuarioSesion->getId() != $data["coorId"] && !verificarEvaluador($usuarioSesion->getId())) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='3' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoComiex' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                     <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo3" onchange="uploadFile3()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress3" class="progress progress-striped active">
                                                                                                        <div  id="progressBar3"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status3"></h3>
                                                                                                    <p id="loaded_n_total3"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                        <div class="col-lg-5 col-lg-offset-1">
                                                                                            <label class="form-label">Investigadores</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosinvestigadores where proyecto ='" . $codigo . "' and etapa = 3 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                              <i class='fa fa-file'></i>
                                                              </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if (getInvestigador($usuarioSesion->getId()) && $usuarioSesion->getId() != $evaluador1 && $usuarioSesion->getId() != $evaluador2) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='3' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoInvestigador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' id = 'isInvestigacion' value= '2' type="hidden">
                                                                                                    <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo3" onchange="uploadFile3()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress3" class="progress progress-striped active">
                                                                                                        <div  id="progressBar3"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status3"></h3>
                                                                                                    <p id="loaded_n_total3"></p>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="col-lg-12 ">
                                                                                        <div class="col-lg-5 col-lg-offset-1">

                                                                                            <label class="control-label">Evaluador 1</label><br>
                                                                                            <?php
                                                                                            $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador1 . "' and etapa = 3 order by fecha desc limit 1;";
                                                                                            $query3 = mysqli_query($connection, $consulta3);
                                                                                            if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                echo " <div class=' file-box'>";
                                                                                                echo " <div class='file'>";
                                                                                                echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                echo "  <span class='corner'></span> ";
                                                                                                echo " <div class='icon'>
                                                              <i class='fa fa-file'></i>
                                                              </div>";
                                                                                                echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                echo "</div>";
                                                                                                echo "</a>";
                                                                                                echo "</div>";
                                                                                                echo "</div>";
                                                                                            } else {
                                                                                                echo "<span class='label label-warning big'>No existen archivos recientes.</span><br>";
                                                                                            }
                                                                                            ?>

                                                                                            <?php if ($usuarioSesion->getId() == $evaluador1) { ?>
                                                                                                <div class="form-group">
                                                                                                    <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                    <input class = 'form-control' name = 'etapa' id = 'etapa' value ='3' type="hidden">
                                                                                                    <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                    <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                    <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                    <label>Adjuntar Documento:</label>
                                                                                                    <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo3" onchange="uploadFile3()" class ="btn btn-primary btn-outline permiso">
                                                                                                    <div hidden id="divProgress3" class="progress progress-striped active">
                                                                                                        <div  id="progressBar3"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <h3 id="status3"></h3>
                                                                                                    <p id="loaded_n_total3"></p>
                                                                                                </div>
                                                                                            <?php } ?>


                                                                                        </div>
                                                                                        <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                            <div class="col-lg-5 col-lg-offset-1">


                                                                                                <label class="control-label">Evaluador 2</label><br>
                                                                                                <?php
                                                                                                $consulta3 = "SELECT * FROM iearchivosevaluadores where proyecto = '" . $codigo . "' and evaluador = '" . $evaluador2 . "' and etapa = 3 order by fecha desc limit 1;";
                                                                                                $query3 = mysqli_query($connection, $consulta3);
                                                                                                if ($data3 = mysqli_fetch_assoc($query3)) {
                                                                                                    echo " <div class=' file-box'>";
                                                                                                    echo " <div class='file'>";
                                                                                                    echo " <a href='" . $data3['ruta'] . "'>";
                                                                                                    echo "  <span class='corner'></span> ";
                                                                                                    echo " <div class='icon'>
                                                              <i class='fa fa-file'></i>
                                                              </div>";
                                                                                                    echo " <div class='file-name'style= 'word-wrap: break-word;'> " . $data3['nom_archivo'] . "<br>";

                                                                                                    echo "<small>Agregado: " . $data3['fecha'] . "</small>";
                                                                                                    echo "</div>";
                                                                                                    echo "</a>";
                                                                                                    echo "</div>";
                                                                                                    echo "</div>";
                                                                                                } else {
                                                                                                    echo "<span class='label label-warning '>No existen archivos recientes.</span><br>";
                                                                                                }
                                                                                                ?>

                                                                                                <?php if ($usuarioSesion->getId() == $evaluador2) { ?>
                                                                                                    <div class="form-group">
                                                                                                        <input class = 'form-control' name = 'codigoProyecto' id='codigoProyecto' type="hidden" value='<?php echo $codigo ?>'>
                                                                                                        <input class = 'form-control' name = 'etapa' id = 'etapa' value ='3' type="hidden">
                                                                                                        <input class = 'form-control' name = 'tipo' id = 'tipo' value ='archivoEvaluador' type="hidden">
                                                                                                        <input class = 'form-control' name = 'isInvestigacion' value= '1' type="hidden">
                                                                                                        <input class = 'form-control' name = 'titulo' id='titulo' type="hidden" value='<?php echo $titulo ?>'>
                                                                                       
                                                                                                        <label>Adjuntar Documento:</label>
                                                                                                        <input accept=".docx,.doc,.pdf" type="file" name="archivo" id="archivo3" onchange="uploadFile3()" class ="btn btn-primary btn-outline permiso">
                                                                                                        <div hidden id="divProgress3" class="progress progress-striped active">
                                                                                                            <div  id="progressBar3"   aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-danger ">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <h3 id="status3"></h3>
                                                                                                        <p id="loaded_n_total3"></p>
                                                                                                    </div>
                                                                                                <?php } ?>

                                                                                            </div>
                                                                                        <?php }
                                                                                        ?>

                                                                                    </div>
                                                                                    <div class="col-lg-offset-10">
                                                                                        <div class="form-group">
                                                                                            <input id="guardarArchivo3" type="submit" class="btn btn-primary btn-outline disabled" value="Guardar Archivo"disabled >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <div class="col-lg-offset-10">
                                                                                <form method="post" action='registro_archivos_investigacion.php'>
                                                                                    <div class="form-group" >
                                                                                        <input type="hidden" name='codigo' value='<?php echo $codigo ?>'>
                                                                                        <input type='hidden' name='etapa' value='3'>
                                                                                        <input id="input-1" type="submit"  class="btn btn-primary" value="Registro de Archivos">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>        
                                                            </div>
                                                            <!-- fin archivos -->
                                                            <!-- comentarios -->
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed">
                                                                    <div class="ibox-title panel panel-success">
                                                                        <h5>Comentarios</h5>
                                                                        <a class="collapse-link">
                                                                            <div class="ibox-tools">
                                                                                <i class="fa fa-chevron-up"></i>
                                                                            </div>
                                                                        </a>
                                                                        <div class="ibox-content" style="display: block;">

                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Investigador</h5>
                                                                                            <?php if (getInvestigador($usuarioSesion->getId())) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit1('CI13')" type="button">Editar</button>
                                                                                                <button id="BI13" etapa="3" comentario="CI13" class="btn btn-primary  btn-xs permiso" onclick="save1('CI13')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CI13" class="click1edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioInvestigador($codigo, 3, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Miembro Comiex</h5>
                                                                                            <?php if ($usuarioPermisos->getMiembrocomiex()) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit4('CM13')" type="button">Editar</button>
                                                                                                <button id="BM13" etapa="3" comentario="CM13" class="btn btn-primary  btn-xs permiso" onclick="save4('CM13')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>

                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CM13" class="click4edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioMiembroComiex($codigo, 3, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="ibox float-e-margins">
                                                                                        <div class="ibox-title">
                                                                                            <h5>Evaluador 1</h5>
                                                                                            <?php if ($usuarioPermisos->getId() == $evaluador1) { ?>
                                                                                                <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit2('CE13')" type="button">Editar</button>
                                                                                                <button id="BE13" etapa="3" comentario="CE13" class="btn btn-primary  btn-xs permiso" onclick="save2('CE13')" type="button">Guardar</button>
                                                                                            <?php } ?>
                                                                                            <div class="ibox-tools">
                                                                                                <a class="collapse-link">
                                                                                                    <i class="fa fa-chevron-up"></i>
                                                                                                </a>

                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="ibox-content no-padding">

                                                                                            <div id="CE13" class="click2edit wrapper p-md">
                                                                                                <?php
                                                                                                comentarioEvaluador($codigo, 3, $evaluador1, $connection);
                                                                                                ?>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <?php if ($GLOBALS['cantEvaluador'] == 2) { ?>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="ibox float-e-margins">
                                                                                            <div class="ibox-title">
                                                                                                <h5>Evaluador 2</h5>
                                                                                                <?php
                                                                                                if ($usuarioPermisos->getId() == $evaluador2) {
                                                                                                    ?>
                                                                                                    <button  class="btn btn-primary btn-xs m-l-sm permiso" onclick="edit3('CE23')" type="button">Editar</button>
                                                                                                    <button id="BE23" etapa="3" comentario="CE23" class="btn btn-primary  btn-xs permiso" onclick="save3('CE23')" type="button">Guardar</button>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                                <div class="ibox-tools">
                                                                                                    <a class="collapse-link">
                                                                                                        <i class="fa fa-chevron-up"></i>
                                                                                                    </a>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="ibox-content no-padding">

                                                                                                <div id="CE23" class="click3edit wrapper p-md">
                                                                                                    <?php
                                                                                                    comentarioEvaluador($codigo, 3, $evaluador2, $connection);
                                                                                                    ?>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>         
                                                                </div>
                                                            </div>
                                                            <!-- fin comentarios -->
                                                            <!-- Estado  -->
                                                            <div class="row">
                                                                <div class="col-lg-5 col-lg-offset-1">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Estado de Etapa:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="form-group">


                                                                        <select id="estado3" class="form-control m-b permiso" name="account" onchange="pintandoPanels()" <?php
                                                                        if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                                            echo "disabled"
                                                                            ?> <?php } ?>>

                                                                            <option value="Aprobada">Aprobada</option>
                                                                            <option value="Aprobada con Observaciones">Aprobada con Observaciones</option>
                                                                            <option value="No Aprobada">No Aprobada</option>
                                                                            <option value="En ejecución">En ejecución</option>
                                                                            <option value="Inactiva">Inactiva</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?> 
                                                                            <input id="BE3" estado="estado3" etapa="3" type="button" class="btn btn-primary permiso" value="Guardar Estado">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                    </div>
                                                                <div class="col-lg-5 col-lg-offset-1">
                                                                    
                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Fecha de finalización:</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group" id="">
                                                                                <div class="input-group date">
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php
                                                                                    if (!$usuarioPermisos->getEncargadotfg()) {
                                                                                        echo "disabled"
                                                                                        ?> <?php } ?>
                                                                                        type="text" id="FIE3" class="form-control" value="<?php echo substr($fecha3, 0, 11) ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($usuarioPermisos->getEncargadotfg()) { ?>
                                                                            <div class="col-lg-4 col-lg-offset-1">
                                                                                <div class="form-group">
                                                                                    <input id="BFIE3" estado="FIE3" etapa="3" type="button" class="btn btn-primary" value="Guardar Fecha">
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- fin estado -->

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin etapa 3 -->

                                    <!-- tiempos academicos -->
                                    <div class="wrapper wrapper-content animated fadeIn">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox collapsed">
                                                    <div id="panelEstado4" class="ibox-title panel ">
                                                        <h5>Tiempos académicos</h5>
                                                        <a class="collapse-link">
                                                            <div class="ibox-tools">
                                                                <i class="fa fa-chevron-up"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <label>Investigadores</label>                                                        
                                                        <?php
                                                        for ($i = 0; $i < count($arrayInvestigadores); $i++) {
                                                            echo "</br>";
                                                            echo "</br>";
                                                            echo "<div class='row'>";

                                                            echo "<div class='col-lg-3 col-lg-offset-1'>";
                                                            echo "<label>Nombre: " . $arrayInvestigadoresnom[$i] . "</label>";
                                                            echo "</div>";

                                                            echo "<div class='col-lg-3'>";
                                                            echo "<label class='control-label'>Cedula: " . $arrayInvestigadores[$i] . "</label>";
                                                            echo "</div>";

                                                            echo "<div class='col-lg-4'>";
                                                            echo "<label class='control-label'>Tiempo academico:</label>";
                                                            
                                                            echo "<select id='$arrayInvestigadores[$i]' class='form-control' name='account' onchange='sumar()'" ;
                                                            if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                                echo "disabled";
                                                            }
                                                            echo ">";
                                                            echo "<option value='0.0625'>1/16</option>";
                                                            echo "<option value='0.125'>1/8</option>";
                                                            echo "<option value='0.25'>1/4</option>";
                                                            echo "<option value='0.5'>1/2</option>";
                                                            echo "<option value='0.75'>3/4</option>";
                                                            echo "<option value='1'>1</option>";
                                                            echo "<option value='0'>0</option>";
                                                            echo "</select>";
                                                            echo "</div>";

                                                            echo "</div>";
                                                        }
                                                        ?>
                                                        <br>
                                                        <br>
                                                        <div class="row">
                                                            <div class='col-lg-12'>
                                                                <div class='col-lg-4 col-lg-offset-3'>
                                                                    <label>Tiempo académico total:</label>
                                                                </div>
                                                                <div class='col-lg-3'>
                                                                    <input id="totalAcademico" name="" type="text" value="" class="form-control" disabled> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="row">
                                                            <div class='col-lg-12'>
                                                                <div class='col-lg-2 col-lg-offset-7'>
                                                                    <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?>
                                                                    <input id="tiempo" type="button" class="btn btn-primary" value="Guardar Cambios">
                                                                    <?php } ?>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- fin tiempos academicos -->


                                    <!-- estado final -->
                                    <div class="row">
                                        <div class="col-lg-5 col-lg-offset-1">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Estado de la Investigación:</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <select id="estadoie" class="form-control m-b" name="estadoie" <?php
                                                    if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                        echo "disabled"
                                                        ?> <?php } ?>>
                                                        <option>Activo</option>
                                                        <option>Aprobada para defensa</option>
                                                        <option>Inactivo</option>
                                                        <option>Finalizado</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?>
                                                        <input id="BIE" estado="estadoie" type="button" class="btn btn-primary" value="Guardar Estado">
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-5 col-lg-offset-1">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Fecha de finalización:</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="fecha" class="form-control" value="<?php echo substr($data['fechaFinal'], 0, 11) ?>" <?php
                                                        if (!$usuarioPermisos->getCoordinadorinvestigacion()) {
                                                            echo "disabled"
                                                            ?> <?php } ?>>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-lg-offset-2">
                                                <div class="form-group">
                                                    <?php if ($usuarioPermisos->getCoordinadorinvestigacion()) { ?>
                                                        <input id="FIE" estado="fechatfg" type="button" class="btn btn-primary" value="Guardar Fecha">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin estado final -->

                                    <!--fin adentro panel mas grande -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer">
                        Universidad Nacional  &copy; 2015-2016
                    </div>

                </div>
            </div>


            <script src="js/jquery-2.1.1.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
            <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

            <script src="js/plugins/dataTables/datatables.min.js"></script>
            <script src="js/plugins/metisMenu/jquery.metisMenu.js" type="text/javascript"></script>
            <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
            <!-- Custom and plugin javascript -->
            <script src="js/fraction.js" type="text/javascript"></script>
            <script src="js/inspinia.js"></script>
            <script src="js/plugins/pace/pace.min.js"></script>
            <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
            <!-- SUMMERNOTE -->
            <script src="js/plugins/summernote/summernote.min.js"></script>
            <script src="js/fileUpload.js" type="text/javascript"></script>
            <!-- Page-Level Scripts -->
            <?php

            function comentarioInvestigador($cod, $eta, $conn) {
                $consulta = "select comentario from iecomentariosinvestigador where etapa = $eta and proyecto ='$cod'";
                $query = mysqli_query($conn, $consulta);
                $data = mysqli_fetch_assoc($query);
                echo " " . $data["comentario"] . " ";
            }

            function comentarioMiembroComiex($cod, $eta, $conn) {
                $consulta = "select comentario from iecomentarioscomiex where etapa = $eta and proyecto ='$cod'";
                $query = mysqli_query($conn, $consulta);
                $data = mysqli_fetch_assoc($query);
                echo " " . $data["comentario"] . " ";
            }

            function comentarioEvaluador($cod, $eta, $ide, $conn) {
                $consulta = "select comentario from iecomentariosevaluadores where etapa = $eta and proyecto ='$cod' and evaluador = '$ide'";
                $query = mysqli_query($conn, $consulta);
                $data = mysqli_fetch_assoc($query);
                echo " " . $data["comentario"] . " ";
            }

            function etapas($cod, $conn) {
                $consulta = "select numero,estado,fechaEntrega from ieetapas where proyecto ='$cod'";
                $query = mysqli_query($conn, $consulta);
                while ($data = mysqli_fetch_assoc($query)) {
                    $etapas = "etapa" . $data["numero"];
                    $fechas = "fecha" . $data["numero"];
                    global $$etapas;
                    global $$fechas;
                    $$etapas = $data['estado'];
                    $$fechas = $data['fechaEntrega'];
                }
            }

            function cantidadEvaluadores($cod, $conn) {

                $cantEval = "select count(*) as evaluadores from ieproyectos,ieevaluadores,ieevaluan
                            where ieproyectos.codigo = ieevaluan.proyecto and ieevaluan.evaluador =  ieevaluadores.id and ieproyectos.codigo ='$cod' and ieevaluan.estado = 1";
                $query = mysqli_query($conn, $cantEval);
                $data = mysqli_fetch_assoc($query);
                global $cantEvaluador;
                $cantEvaluador = $data['evaluadores'];
            }

            function evaluadores($cod, $conn) {
                global $evaluadoresCorreos;
                $evaluadoresCorreos = array();
                $consulta = "select ieevaluadores.id, ieevaluadores.correo from ieproyectos,ieevaluadores,ieevaluan
                            where ieproyectos.codigo = ieevaluan.proyecto and ieevaluan.evaluador =  ieevaluadores.id and ieproyectos.codigo ='$cod' and ieevaluan.estado = 1";

                $query = mysqli_query($conn, $consulta);
                $cont = 1;
                while ($data = mysqli_fetch_assoc($query)) {
                    $evaluadores = "evaluador$cont";
                    global $$evaluadores;
                    $$evaluadores = $data["id"];
                    $cont++;
                    array_push($evaluadoresCorreos, $data["correo"]);
                }
            }

            function getInvestigador($investigadorId) {

                global $arrayInvestigadores;
                for ($i = 0; $i < count($arrayInvestigadores); $i++) {
                    if ($arrayInvestigadores[$i] == $investigadorId) {
                        return true;
                    }
                }
                return false;
            }

            function verificarEvaluador($usuarioId) {//verifica si es evaluador o no
                global $evaluador1;
                global $evaluador2;
                if (isset($evaluador1)) {
                    if ($usuarioId == $evaluador1) {
                        return true;
                    }
                }
                if (isset($evaluador2)) {
                    if ($usuarioId == $evaluador2) {
                        return true;
                    }
                }
                return false;
            }
            ?>
            <div id="mod-info" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="text-center"><h3 id="titulo-modal" class="m-t-none m-b"></h3>
                                    <div class="text-center">
                                        <label id="texto-modal"></label>
                                        <br>
                                        <button class="btn btn-sm btn-primary" id="cerrar" type="button" name="cerrar" data-dismiss="modal">Cerrar</button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                                                                        String.prototype.trim = function () {
                                                                            return this.replace(/^\s+|\s+$/g, "");
                                                                        };
                                                                        $(document).ready(function () {
                                                                            $('.summernote').summernote();
                                                                        });
                                                                        $('#fecha').datepicker({
                                                                            format: 'yyyy-mm-dd',
                                                                            todayBtn: "linked",
                                                                            keyboardNavigation: false,
                                                                            forceParse: false,
                                                                            calendarWeeks: true,
                                                                            autoclose: true
                                                                        });
                                                                        $('#FIE1').datepicker({
                                                                            format: 'yyyy-mm-dd',
                                                                            todayBtn: "linked",
                                                                            keyboardNavigation: false,
                                                                            forceParse: false,
                                                                            calendarWeeks: true,
                                                                            autoclose: true
                                                                        });
                                                                        $('#FIE2').datepicker({
                                                                            format: 'yyyy-mm-dd',
                                                                            todayBtn: "linked",
                                                                            keyboardNavigation: false,
                                                                            forceParse: false,
                                                                            calendarWeeks: true,
                                                                            autoclose: true
                                                                        });
                                                                        $('#FIE3').datepicker({
                                                                            format: 'yyyy-mm-dd',
                                                                            todayBtn: "linked",
                                                                            keyboardNavigation: false,
                                                                            forceParse: false,
                                                                            calendarWeeks: true,
                                                                            autoclose: true
                                                                        });
                                                                        var edit1 = function (comen) {
                                                                            $('#' + comen + '.click1edit').summernote({focus: true});
                                                                        };
                                                                        var save1 = function (comen) {
                                                                            var aHTML = $('#' + comen + '.click1edit').code(); //save HTML If you need(aHTML: array).
                                                                            $('#' + comen + '.click1edit').destroy();
                                                                        };
                                                                        var edit2 = function (comen) {
                                                                            $('#' + comen + '.click2edit').summernote({focus: true});
                                                                        };
                                                                        var save2 = function (comen) {
                                                                            var aHTML = $('#' + comen + '.click2edit').code(); //save HTML If you need(aHTML: array).
                                                                            $('#' + comen + '.click2edit').destroy();
                                                                        };
                                                                        var edit3 = function (comen) {
                                                                            $('#' + comen + '.click3edit').summernote({focus: true});
                                                                        };
                                                                        var save3 = function (comen) {
                                                                            var aHTML = $('#' + comen + '.click3edit').code(); //save HTML If you need(aHTML: array).
                                                                            $('#' + comen + '.click3edit').destroy();
                                                                        };
                                                                        var edit4 = function (comen) {
                                                                            $('#' + comen + '.click4edit').summernote({focus: true});
                                                                        };
                                                                        var save4 = function (comen) {
                                                                            var aHTML = $('#' + comen + '.click4edit').code(); //save HTML If you need(aHTML: array).
                                                                            $('#' + comen + '.click4edit').destroy();
                                                                        };

                                                                        $(document).ready(function () {
                                                                            //init de botones


                                                                            guardarComentarioEvaluador("BE11");
                                                                            guardarComentarioEvaluador("BE21");
                                                                            guardarComentarioEvaluador("BE12");
                                                                            guardarComentarioEvaluador("BE13");
                                                                            guardarComentarioEvaluador("BE22");
                                                                            guardarComentarioEvaluador("BE23");

                                                                            guardarComentarioComiex("BM11");
                                                                            guardarComentarioComiex("BM12");
                                                                            guardarComentarioComiex("BM13");

                                                                            guardarComentarioInvestigador("BI11");
                                                                            guardarComentarioInvestigador("BI12");
                                                                            guardarComentarioInvestigador("BI13");
                                                                            guardarFechaEstado("BFIE1");
                                                                            guardarFechaEstado("BFIE2");
                                                                            guardarFechaEstado("BFIE3");
                                                                            guardarEstadoIE("BE1");
                                                                            guardarEstadoIE("BE2");
                                                                            guardarEstadoIE("BE3");
                                                                            guardarEstadoFinIE("BIE");
                                                                            guardarFecha();
                                                                            guardarTiempos();
                                                                            //init de panels y otras cosas

                                                                            initSelects();
                                                                            pintandoPanels();
                                                                            init();
                                                                            sumar();
                                                                            inac(1);
                                                                            inac(2);
                                                                            inac(3);
                                                                            permiso = "<?php echo $usuarioPermisos->getCoordinadorinvestigacion() ?>";
                                                                            etapa(1);
                                                                            etapa(2);
                                                                        });
                                                                        //sets de informacion a la base de datos
                                                                        function  guardarComentarioEvaluador(btn) { // btn boton del save para eVALUADORES
                                                                            $("#" + btn).click(function (evento) {
                                                                                evento.preventDefault();
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var ide = "<?php echo $usuarioSesion->getId() ?>";
                                                                                var eta = $("#" + btn).attr("etapa");
                                                                                var coment = $("#" + btn).attr("comentario");
                                                                                var com = $("#" + coment).text();
                                                                                com = com.trim();
                                                                                $.get("funcionalidad/ComentarioEvaluador.php", {comentario: com, ie: cod, etapa: eta, id: ide}, function (data) {
                                                                                    modal(" Se guardo el comentario con exito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }

                                                                        function guardarComentarioComiex(btn) {
                                                                            $("#" + btn).click(function (evento) {
                                                                                evento.preventDefault();
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var ide = "<?php echo $usuarioSesion->getId() ?>";
                                                                                var eta = $("#" + btn).attr("etapa");
                                                                                var coment = $("#" + btn).attr("comentario");
                                                                                var com = $("#" + coment).text();
                                                                                com = com.trim();
                                                                                $.get("funcionalidad/ComentarioComiex.php", {comentario: com, ie: cod, etapa: eta, id: ide}, function (data) {
                                                                                    modal(" Se guardo el comentario con exito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }

                                                                        function guardarComentarioInvestigador(btn) {
                                                                            $("#" + btn).click(function (evento) {
                                                                                evento.preventDefault();
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var ide = "<?php echo $usuarioSesion->getId() ?>";
                                                                                var eta = $("#" + btn).attr("etapa");
                                                                                var coment = $("#" + btn).attr("comentario");
                                                                                var com = $("#" + coment).text();
                                                                                com = com.trim();
                                                                                $.get("funcionalidad/ComentarioInvestigador.php", {comentario: com, ie: cod, etapa: eta, id: ide}, function (data) {
                                                                                    modal(" Se guardo el comentario con exito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }

                                                                        function guardarEstadoIE(btn) { // btn boton de guardar la etapa 
                                                                            $("#" + btn).click(function (evento) {
                                                                               var est = $("#" + btn).attr("estado");
                                                                               var estad = $("#" + est).val();
                                                                            if(confirm("¿esta seguro de cambiar el estado de la etapa? a: "+estad)){
                                                                                evento.preventDefault();
                                                                                etapa(1);
                                                                                etapa(2);
                                                                                var type = 3;
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var titulo = "<?php echo $data['titulo'] ?>";
                                                                                var coor = "<?php echo $data['correoCoordinador'] ?>";
                                                                                var eta = $("#" + btn).attr("etapa");
                                                                                
                                                                                var investigadoresC = <?php echo '["' . implode('", "', $arrayInvestigadorescorreo) . '"]' ?>;
                                                                                var evaluadoresC = <?php echo '["' . implode('", "', $evaluadoresCorreos) . '"]' ?>;
                                                                                

                                                                                var investigadores = {};
                                                                                investigadores = JSON.stringify(investigadoresC);

                                                                                var evaluadores = {};
                                                                                evaluadores = JSON.stringify(evaluadoresC);

                                                                                $.get("funcionalidad/IEestado.php", {titulo: titulo, estado: estad, ie: cod, etapa: eta, coordinador: coor, investigadores: investigadores, evaluadores: evaluadores, type: type}, function (data) {
                                                                                 $("#"+est).val(data);
                                                                                            
                                                                                            if(estad === data ){
                                                                                                modal(" Se guardó el estado de la etapa con éxito.");
                                                                                                pintandoPanels();
                                                                                               
                                                                                            }else{
                                                                                                modal(" NO se puede cambiar el estado de aprobado a otro estado.");
                                                                                                pintandoPanels();
                                                                                            }
                                                                                            
                                                                                        }).fail(function (data) {
                                                                                            modal("Ocurrió algún problema." , data);
                                                                                        });
                                                                                      }
                                                                                    });
                                                                                  
                                                                                }
                                                                    

                                                                        function guardarEstadoFinIE(btn) { // btn boton del guardar estado final
                                                                            $("#" + btn).click(function (evento) {
                                                                                evento.preventDefault();
                                                                                var type = 4;
                                                                                var titulo = "<?php echo $data['titulo'] ?>";
                                                                                var coor = "<?php echo $data['correoCoordinador'] ?>";
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var investigadoresC = <?php echo '["' . implode('", "', $arrayInvestigadorescorreo) . '"]' ?>;
                                                                                var evaluadoresC = <?php echo '["' . implode('", "', $evaluadoresCorreos) . '"]' ?>;
                                                                                var est = $("#" + btn).attr("estado");
                                                                                var estad = $("#" + est).val();
                                                                                var etapa = "Final";
                                                                                var investigadores = {};
                                                                                investigadores = JSON.stringify(investigadoresC);

                                                                                var evaluadores = {};
                                                                                evaluadores = JSON.stringify(evaluadoresC);
                                                                                $.get("funcionalidad/IEestadoFin.php", {titulo: titulo, estado: estad, ie: cod, etapa: etapa, coordinador: coor, investigadores: investigadores, evaluadores: evaluadores, type: type}, function (data) {
                                                                                    modal(" Se guardó el estado final con éxito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }

                                                                        function guardarFecha() {
                                                                            $("#FIE").click(function (evento) {
                                                                                evento.preventDefault();
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var fecha = $("#fecha").val();
                                                                                $.get("funcionalidad/IEfecha.php", {fecha: fecha, ie: cod}, function (data) {
                                                                                    modal(" Se guardo la fecha con exito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }
                                                                        function guardarFechaEstado(btn) {
                                                                                $("#"+btn).click(function (evento) {
                                                                                    evento.preventDefault();
                                                                                    var cod = "<?php echo $codigo ?>";
                                                                                    var fech = $("#"+btn).attr("estado");
                                                                                    var fecha = $("#"+fech).val();
                                                                                    var eta = $("#" + btn).attr("etapa");
                                                                                    $.get("funcionalidad/IEfecha.php", {fecha: fecha, ie: cod,etapa:eta,fechaetapa:1}, function (data) {
                                                                                        modal(" Se guardó la fecha con exito", data);
                                                                                    }).fail(function (data) {
                                                                                        modal("Ocurrió algún problema", data);
                                                                                    });
                                                                                });
                                                                            }

                                                                        function guardarTiempos() {
                                                                            $("#tiempo").click(function (evento) {
                                                                                evento.preventDefault();
                                                                                
                                                                                var cod = "<?php echo $codigo ?>";
                                                                                var tiempos = [];
                                                                                var investigadores = <?php echo '["' . implode('", "', $arrayInvestigadores) . '"]' ?>;
                                                                                for (var i = 0; i < investigadores.length; i++) {
                                                                                    tiempos[tiempos.length] = parseFloat($("#" + investigadores[i]).val());
                                                                                }
                                                                                var invs = {};
                                                                                invs = JSON.stringify(investigadores);
                                                                                var tiemp = {};
                                                                                tiemp = JSON.stringify(tiempos);

                                                                                $.get("funcionalidad/IEtiempo.php", {investigadores: invs, tiempos: tiemp, ie: cod}, function (data) {
                                                                                    modal(" Se guardaron los tiempos academicos con exito", data);
                                                                                }).fail(function (data) {
                                                                                    modal("Ocurrio algun problema", data);
                                                                                });
                                                                            });
                                                                        }



                                                                        function init() {
                                                                            var investigadores = <?php echo '["' . implode('", "', $arrayInvestigadores) . '"]' ?>;
                                                                            var tiempos = <?php echo '["' . implode('", "', $arrayInvestigadorestime) . '"]' ?>;
                                                                            for (var i = 0; i < investigadores.length; i++) {
                                                                                //alert($("#" + investigadores[i]).val());
                                                                                $("#" + investigadores[i]).val(tiempos[i]);
                                                                            }

                                                                        }
                                                                        function sumar() {
                                                                            var total = 0;
                                                                            var investigadores = <?php echo '["' . implode('", "', $arrayInvestigadores) . '"]' ?>;

                                                                            for (var i = 0; i < investigadores.length; i++) {
                                                                                //alert($("#" + investigadores[i]).val());
                                                                                total += parseFloat($("#" + investigadores[i]).val());

                                                                            }
                                                                            var f = new Fraction(total);

                                                                            $("#totalAcademico").val(f.numerator + '/' + f.denominator);
                                                                        }
                                                                        function modal(titulo, msj) {
                                                                            $('#mod-info').modal('show');
                                                                            $("#titulo-modal").text(titulo);
                                                                            $("#texto-modal").text(msj);

                                                                        }

                                                                        //pintar panels
                                                                        var estados = {Aprobada: "panel-primary", AprobadaconObservaciones: "panel-warning",
                                                                            NoAprobada: "panel-danger", Enejecución: "panel-success", Inactiva: "panel", Activo: "panel-success",
                                                                            Aprobadaparadefensa: "panel-primary", Inactivo: "panel-danger", Finalizado: "panel-primary"};
                                                                        var estadosant = {ant1: "<?php echo $etapa1 ?>", ant2: "<?php echo $etapa2 ?>", ant3: "<?php echo $etapa3 ?>", ant4: "<?php echo $data["estado"] ?>"};
                                                                        function pintando(estado, panel, estadoan, n) {
                                                                            estado = estado.replace(/\s/g, "");
                                                                            estadoan = estado.replace(/\s/g, "");
                                                                            $("#" + panel).removeClass(estados[estadosant["ant" + n]] + "").addClass(estados[estado]);
                                                                            //elimino el color anterior y inserto la clase del nuevo
                                                                            estadosant["ant" + n] = estado;
                                                                        }
                                                                        function pintandoPanels() {

                                                                            pintando($("#estado1").val(), "panelEstado1", estadosant["ant1"], 1);
                                                                            pintando($("#estado2").val(), "panelEstado2", estadosant["ant2"], 2);
                                                                            pintando($("#estado3").val(), "panelEstado3", estadosant["ant3"], 3);
                                                                            pintando($("#estadoie").val(), "panelEstadoFinal", estadosant["ant4"], 4);
                                                                        }
                                                                        function initSelects() {

                                                                            // alert("<?php echo $etapa1 ?>");
                                                                            $("#estado1").val("<?php echo $etapa1 ?>");
                                                                            $("#estado2").val("<?php echo $etapa2 ?>");
                                                                            $("#estado3").val("<?php echo $etapa3 ?>");
                                                                            $("#estadoie").val("<?php echo $data["estado"] ?>");

                                                                        }
                                                                        //metodo para que el usuario no pueda marcar la opcion de inactivo en una etapa
                                                                        function inac(etapa) {
                                                                            //alert(etapa);
                                                                            $("#estado" + etapa).focus(function () {
                                                                                $("#estado" + etapa + " option[value='Inactiva']").remove();
                                                                            });
                                                                            $("#estado" + etapa).focus();
                                                                            $("#estado" + etapa).focusout(function () {
                                                                                $("#estado" + etapa).append("<option value='Inactiva'>Inactiva</option>");

                                                                            });
                                                                        }

                                                                        //metodo para habilitar/deshabilitar la siguiente etapa 
                                                                        var permiso;
                                                                        function etapa(etapa) {

                                                                            var estado = $("#estado" + etapa).val();
                                                                            var etapasig = etapa + 1;

                                                                            if (estado === "Aprobada" || estado === "Aprobada con Observaciones") {
                                                                                if (permiso === "1") {
                                                                                    $("#estado" + etapasig).prop('disabled', false);
                                                                                    $("#BE" + etapasig).prop('disabled', false);
                                                                                }
                                                                                $("#panelEstado" + etapasig + " .permiso").prop('disabled', false);

                                                                            } else {
                                                                                if (permiso === "1") {
                                                                                    $("#estado" + etapasig).prop('disabled', true);
                                                                                    $("#BE" + etapasig).prop('disabled', true);
                                                                                }
                                                                                $("#panelEstado" + etapasig + " .permiso").prop('disabled', true);
                                                                            }
                                                                        }




            </script>    


    </body>
</html>
