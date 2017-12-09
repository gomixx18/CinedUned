@@ -0,0 +1,260 @@
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
                                            $asesor1 = $_POST['asesor1'];
                                            $asesor2 = $_POST['asesor2'];
                           
                                            $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                            if (!$connection) {
                                                $_SESSION["error"] = "¡Hubo un error al cargar el registro de archivos! Conexión a base de datos";
                                                header("Location: ../navegacion/500.php");
                                            }
                                            //asesores($codigo, $connection);
                                         
                                            $query1 = mysqli_query($connection, "SELECT ruta, DATE_FORMAT(fecha, '%d/%m/%Y %H:%m:%s')  as fecha, nom_archivo FROM tfgarchivosdirectores where tfg ='"
                                                        .$codigo."' and director='".$director."' and etapa=".$etapa.";");
                            
                                            
                                            $query2 = mysqli_query($connection, "SELECT ruta, DATE_FORMAT(fecha, '%d/%m/%Y %H:%m:%s')  as fecha, nom_archivo FROM tfgarchivosasesores where tfg ='"
                                                        .$codigo."' and asesor='".$asesor1."' and etapa=".$etapa.";");
                                            
                                            $query3 = mysqli_query($connection, "SELECT ruta, DATE_FORMAT(fecha, '%d/%m/%Y %H:%m:%s')  as fecha, nom_archivo FROM tfgarchivosasesores where tfg ='"
                                                        .$codigo."' and asesor='".$asesor2."' and etapa=".$etapa.";");
                                            
                                            
                                            $query4 = mysqli_query($connection, "SELECT titulo FROM tfg where codigo ='".$codigo."'");
                                            
                                            $query5 = mysqli_query($connection, "SELECT ruta, DATE_FORMAT(fecha, '%d/%m/%Y %H:%m:%s')  as fecha, nom_archivo FROM tfgarchivoscomision where tfg ='"
                                                        .$codigo."' and etapa=".$etapa.";");
                                            
                                            $tfg = mysqli_fetch_assoc($query4);
                                           
                                    ?>
                                    <h2>Registro de Archivos: <?php echo  $tfg['titulo']. " (".$codigo. ") " ?></h2>
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
                                                    
                                                    echo " <div class='file-box' style='height:200px'>";
                                                    echo " <div class='file-box'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' word-wrap: break-word;>". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Agregado:" .$array['fecha']. "</small>";
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
                                                    echo " <div class='file-name' word-wrap: break-word;>". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Agregado:" .$array['fecha']. "</small>";
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
                                           <br> <h3>Registro archivos Asesor 1</h3>
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
                                                    echo " <div class='file-name' word-wrap: break-word;>". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Agregado:" .$array['fecha']. "</small>";
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
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <br><h3>Registro archivos Asesor 2</h3>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <?php
                                            
                                            if( mysqli_num_rows($query3) > 0){
                                                while ($array = mysqli_fetch_array($query3)){
                                                 
                                                    
                                                    echo " <div class='file-box' style='height:200px'>";
                                                    echo " <div class='file'>";
                                                    echo " <a href='". $array['ruta']. "'>";
                                                    echo "  <span class='corner'></span> ";
                                                    echo " <div class='icon'>
                                                            <i class='fa fa-file'></i>
                                                        </div>";
                                                    echo " <div class='file-name' word-wrap: break-word;>". $array['nom_archivo'] ."<br>";
                                                 
                                                    echo "<small>Agregado:" .$array['fecha']. "</small>";
                                                    echo "</div>";
                                                    echo "</a>";
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
