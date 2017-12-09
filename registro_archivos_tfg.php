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
                        <h2>Registro de Arhivos </h2>
                    
                    </div>
                </div>  

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <?php
                                            //@start_session();
                                            
                                            $codigo = $_POST['codigo'];
                                            $director = $_POST['director'];
                                            $etapa = $_POST['etapa'];
                                            $subetapa = ["avance #1", "avance #2","avance #3"];
                                            $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                            if (!$connection) {
                                                $_SESSION["error"] = "¡Hubo un error al cargar el registro de archivos! Conexión a base de datos";
                                                header("Location: ../navegacion/500.php");
                                            }
                                            
                                            //SQL para archivos Directores
                                            $query1 = mysqli_query($connection, "SELECT tfgarchivosdirectores.ruta, DATE_FORMAT(tfgarchivosdirectores.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, tfgarchivosdirectores.nom_archivo, tfgdirectores.nombre, tfgdirectores.apellido1, tfgarchivosdirectores.subetapa  FROM tfgarchivosdirectores, tfgdirectores where tfgarchivosdirectores.tfg ='"
                                                        .$codigo."' and tfgarchivosdirectores.etapa=".$etapa." and tfgarchivosdirectores.director = tfgdirectores.id order by tfgarchivosdirectores.fecha desc;");
                            
                                            //SQL para archivos Asesores
                                            $query2 = mysqli_query($connection, "SELECT tfgarchivosasesores.ruta, DATE_FORMAT(tfgarchivosasesores.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, tfgarchivosasesores.nom_archivo, tfgasesores.nombre, tfgasesores.apellido1, tfgarchivosasesores.subetapa FROM tfgarchivosasesores, tfgasesores where tfgarchivosasesores.tfg ='"
                                                        .$codigo."' and tfgarchivosasesores.etapa=".$etapa." and tfgarchivosasesores.asesor = tfgasesores.id order by tfgarchivosasesores.fecha desc;");
                                            
                                            //SQL para obtener TITULO tfg
                                            $query4 = mysqli_query($connection, "SELECT titulo FROM tfg where codigo ='".$codigo."'");
                                            
                                            //SQL para obtener archivos comision
                                            $query5 = mysqli_query($connection, "SELECT tfgarchivoscomision.ruta, DATE_FORMAT(tfgarchivoscomision.fecha, '%d/%m/%Y %H:%i:%s')  as fecha, tfgarchivoscomision.nom_archivo, tfgmiembroscomision.nombre, tfgmiembroscomision.apellido1, tfgarchivoscomision.subetapa  FROM tfgarchivoscomision, tfgmiembroscomision where tfgarchivoscomision.tfg ='"
                                                        .$codigo."' and tfgarchivoscomision.etapa=".$etapa." and tfgarchivoscomision.miembrocomision = tfgmiembroscomision.id order by tfgarchivoscomision.fecha desc;");
                                            
                                            $tfg = mysqli_fetch_assoc($query4);
                                           
                                    ?>
                                    <h3><b>Registro de Archivos: </b><?php echo  $tfg['titulo']. " (".$codigo. "). <b>Etapa: </b>" ;
                                                if( $etapa == 1){
                                                   echo " Envío Tema"; 
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
                                            <br><h3>Registro archivos Comisión</h3>
                                        </div>
                                        <div class="col-lg-12">
                                            <?php
                                            
                                            if( mysqli_num_rows($query5) > 0){
                                                while ($array = mysqli_fetch_array($query5)){
                                                    
                                                    echo " <div class='file-box' style='height:240px'>";
                                                    echo " <div class='file-box'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' style= 'word-wrap: break-word' >". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small><b>Subido: </b>" .$array['fecha']. "</small></br>";
                                                    echo "<small><b>Subido Por: </b> " .$array['nombre']." ".$array['apellido1'] . "</small><br>";
                                                    echo "<small><b>N. Avance: </b>" .$subetapa[$array['subetapa']-1]. "</small></br>";
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
                                            <br><h3>Registro archivos director TFG</h3>
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
                                           <br> <h3>Registro archivos asesores</h3>
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
                                                    echo "<small>Subido Por: " .$array['nombre']." ".$array['apellido1'] . "</small>";
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

