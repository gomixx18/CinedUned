<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración de Estudiantes</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <?php
        require 'navegacion/nav-lateral.php';
        ?>
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php' ?>

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Registro de archivos proyectos de investigación </h2>
                    
                    </div>
                </div>  

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <?php
                                           
                                            if(!isset($_POST['codigo']) || !isset($_POST['etapa'])){
                                                @session_start();
                                                
                                                exit();
                                               
                                            }
                                            $codigo = $_POST['codigo'];
                                            $etapa = $_POST['etapa'];
                                           
                                            $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                            if (!$connection) {
                                                $_SESSION["error"] = "¡Hubo un error al cargar el registro de archivos! Conexión a base de datos";
                                                header("Location: ../navegacion/500.php");
                                            }
                                            
                                            //SQL para archivos Docentes
                                            $query1 = mysqli_query($connection, "SELECT iearchivosinvestigadores.ruta, DATE_FORMAT(iearchivosinvestigadores.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, iearchivosinvestigadores.nom_archivo, ieinvestigadores.nombre, ieinvestigadores.apellido1  FROM iearchivosinvestigadores, ieinvestigadores where iearchivosinvestigadores.proyecto ='"
                                                        .$codigo."' and iearchivosinvestigadores.etapa=".$etapa." and iearchivosinvestigadores.investigador = ieinvestigadores.id order by iearchivosinvestigadores.fecha desc;");
                            
                                            //SQL para archivos Evaluadores
                                            $query2 = mysqli_query($connection, "SELECT iearchivosevaluadores.ruta, DATE_FORMAT(iearchivosevaluadores.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, iearchivosevaluadores.nom_archivo, ieevaluadores.nombre, ieevaluadores.apellido1 FROM iearchivosevaluadores, ieevaluadores where iearchivosevaluadores.proyecto ='"
                                                        .$codigo."' and iearchivosevaluadores.etapa=".$etapa." and iearchivosevaluadores.evaluador = ieevaluadores.id order by iearchivosevaluadores.fecha desc;");
                                            
                                            //SQL para obtener TITULO Proyecto
                                            $query4 = mysqli_query($connection, "SELECT titulo FROM ieproyectos where codigo ='".$codigo."'");
                                            
                                            //SQL para obtener archivos COMIEX
                                            $query5 = mysqli_query($connection, "SELECT iearchivoscomiex.ruta, DATE_FORMAT(iearchivoscomiex.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, iearchivoscomiex.nom_archivo, iemiembroscomiex.nombre, iemiembroscomiex.apellido1  FROM iearchivoscomiex, iemiembroscomiex where iearchivoscomiex.proyecto =
					'".$codigo."' and iearchivoscomiex.etapa=".$etapa." and iearchivoscomiex.miembrocomiex = iemiembroscomiex.id order by iearchivoscomiex.fecha desc;");
                                            
                                            $proyecto = mysqli_fetch_assoc($query4);
                                           
                                    ?>
                                    <h3><b>Registro de archivos: </b><?php echo  $proyecto['titulo']. " (".$codigo. "). <b>Etapa: </b>" ;
                                                if( $etapa == 1){
                                                   echo "Evaluación"; 
                                                }
                                                else{
                                                    if( $etapa == 2 ){
                                                    echo " Anteproyecto o Propuesta";
                                                }else{
                                                    echo "Entrega Final";
                                                }
                                                }
                                            ?></h3>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <br><h3>Registro archivos COMIEX</h3>
                                        </div>
                                        <div class="col-lg-12">
                                            <?php
                                            
                                            if( mysqli_num_rows($query5) > 0){
                                                while ($array = mysqli_fetch_array($query5)){
                                                    
                                                    echo " <div class='file-box' style='height:200px'>";
                                                    echo " <div class='file-box'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' style= 'word-wrap: break-word' >". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Subido:" .$array['fecha']. "</small></br>";
                                                     echo "<small>Subido Por: " .$array['nombre']." ".$array['apellido1'] . "</small>";
                                                    echo "</div>";
                                                    echo "</a>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                            }else{
                                                echo "<br><span class='label label-warning '>No existen archivos asociados a la etapa.</span><br>";
                                            }
            
                                            ?>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <br><h3>Registro archivos Docentes</h3>
                                        </div>
                                        <div class="col-lg-12">
                                            <?php
                                            
                                            if( mysqli_num_rows($query1) > 0){
                                                while ($array = mysqli_fetch_array($query1)){
                                                    
                                                    echo " <div class='file-box' style='height:200px'>";
                                                    echo " <div class='file-box'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' style= 'word-wrap: break-word' >". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Subido: " .$array['fecha']. "</small></br>";
                                                    echo "<small>Subido Por: " .$array['nombre']." ".$array['apellido1'] . "</small>";
                                                    echo "</div>";
                                                    echo "</a>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                            }else{
                                                echo "<br><span class='label label-warning '>No existen archivos asociados a la etapa.</span><br>";
                                            }
            
                                            ?>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                           <br> <h3>Registro archivos Evaluadores</h3>
                                        </div>
                                        <div class="col-lg-12">
                                            <?php
                                            
                                            if( mysqli_num_rows($query2) > 0){
                                                while ($array = mysqli_fetch_array($query2)){
                                                    
                                                    echo " <div class='file-box' style='height:200px'>";
                                                    echo " <div class='file-box'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' style= 'word-wrap: break-word' >". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Subido: " .$array['fecha']. "</small><br>";
                                                    $usuarioPermisos = $_SESSION['permisos'];
                                                    if($usuarioPermisos->getCoordinadorinvestigacion()){
                                                    echo "<small>Subido Por: " .$array['nombre']." ".$array['apellido1'] . "</small>";
                                                    }
                                                    echo "</div>";
                                                    echo "</a>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                            }else{
                                                echo "<br> <span class='label label-warning '>No existen archivos asociados a la etapa.</span> <br>";
                                            }
            
                                            ?>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="footer">
                        Universidad Nacional  &copy; 2015-2016
                    </div>


            </div>

            <script src="js/jquery-2.1.1.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
            <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
            <script src="js/plugins/dataTables/datatables.min.js"></script>

            <!-- Custom and plugin javascript -->
            <script src="js/inspinia.js"></script>
            <script src="js/plugins/pace/pace.min.js"></script>

            <!-- Page-Level Scripts -->
            <script>
                $(document).ready(function () {
                    $('.file-box').each(function () {
                        animationHover(this, 'pulse');
                    });
                });
            </script>



    </body>

</html>

