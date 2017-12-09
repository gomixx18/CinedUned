<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Página de Bienvenida</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <?php
        require 'navegacion/nav-lateral.php';
        ?>
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                
               <?php require 'navegacion/nav-superior.php'?>
                
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-4">
                        <h2>Página de Bienvenida</h2>
                        
                    </div>
                    
                </div>

                <div class="wrapper wrapper-content">
                    <div class="middle-box text-center animated fadeInRightBig">

                        <div class="error-desc">
                            Bienvenidos y bienvenidas  al sistema de información
                            del Centro de Investigaciones de la Escuela de Ciencias
                            de la Educación.
                            Nuestro centro se dedica al desarrollo de programas
                            y proyectos de investigación
                            en el campo educativo y a la formación en investigación 
                            tanto del estudiantado como del personal académico de la Escuela.
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="footer">

                    <div>
                        Universidad Nacional  &copy; 2015-2016
                    </div>
                </div>

            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>


    </body>

</html>
