<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CINED | 500 Error</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeIn">
        <h1>500</h1>
        <h3 class="font-bold">Error Interno del Servidor</h3>

        <div class="error-desc">
            Paso algo inesperado en el servidor no podemos completar su accion. Disculpe las molestias.<br/>
           
             <div class="panel panel-danger animated tada">
                <div class="panel-heading">
                    AVISO
                </div>
                <div class="panel-body">
                    <p>
                        <?php
                            @session_start();
                            
                            if(!isset($_SESSION["error"])){
                                header("Location: ../index.php");
                                exit();
                            }
                            echo $_SESSION["error"];
                           
                            unset($_SESSION['error']);
                        ?>
                    </p>
                </div>
                    <div class="panel-footer">
                        
                    </div>
            </div>
                                
            Puede derigirse a la pagina principal <br/><a href="../index.php" class="btn btn-primary m-t">Inicio</a>
        </div>
        
        
    </div>

    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>
