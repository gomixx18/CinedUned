<!DOCTYPE html>


<?php 
session_start();

if(isset($_SESSION['permisos'])){
    session_destroy();  
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CINED | Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">CINED</h1>

            </div>
            <h3>Inicio de Sesión</h3>
            <p>
                
            </p>
            
            <form class="m-t" role="form" action="funcionalidad/loginFuncionalidad.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Cédula de Identidad" name="id" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Iniciar Sesión</button>

                <a href="olvido_contrasena.php"><small>¿Olvidó su contraseña?</small></a>
                
            </form>
            <p class="m-t"> <small>Escuela de Informática, Universidad Nacional  &copy; 2015-2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>


