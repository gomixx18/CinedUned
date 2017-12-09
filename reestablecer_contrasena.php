<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

?>
<html>
    <head>
        <title>Reestablecer Contraseña</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery-2.1.1.js"></script>
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

</head>
<body class="gray-bg">
   




    <?php
    $userGet = $_GET['u'];
    $token = $_GET['e'];
    ?>
    <div class="passwordBox animated fadeInDown">
        
        <div class="middle-box text-center ">
            <div>
                <h1 class="logo-name">CINED</h1>
            </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Reestablecer Contraseña</h2>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="changePass" action="" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Contraseña Nueva</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="key" id="key" value="<?= $token ?>" />
                                        <input type="hidden" name="id" id="id" value="<?= $userGet ?>" />
                                        <input type="password" class="form-control" id="newp" name="newp" placeholder="" minlength="0" >
                                    </div>
                                </div>        
                                <button type="button" id="btnreset" name="resetPass" class="btn btn-primary center-block">Guardar</button>
                                <br>
                                <p id="result" align="center">
                                  
                                </p>
                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a data-toggle="collapse" href="login.php" class="text-primary">Ir a Página Principal</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
   
    <div class="footer">
        Universidad Nacional  &copy; 2015-2016
    </div>
    <script type="text/javascript">
    
    $(document).ready( function(){
        
        console.log("hola");
            $("button#btnreset").click(function (e) {
                e.preventDefault();
                var err = $("#result");
               

                err = err.hide();
                //$('*').css('cursor', 'progress');
                $.ajax({
                    url: "funcionalidad/reestablecerContrasena.php",
                    method: "POST",
                    data: $("#changePass").serialize(),
                    success: function (response) {
                        
                       var data = $.trim(response);
                        if (data === "success") {
                            err = err.text("Su contraseña ha sido reestablecida.").css('color', 'green');  
                            setTimeout(function redirectPage(){
                            window.location.href = "http://cined.uned.ac.cr/";
                            },3000);
                        } else if (data === 'error') {
                            err = err.text("Ha ocurrido un error.").css('color', 'red');
                        } else if (data === 'expirado') {
                            err = err.text("Ha alcanzado la fecha limite para reestablecer su contraseña. Por favor solicítela de nuevo.").css('color', 'red');
                        } else if (data === 'db_conn_error') {
                            err = err.text("No se puede establecer conexión con la base de datos. Comuníquese con el encargado.").css('color', 'red');
                        }
                       
                        err.fadeIn(1000);
                        
                        //$('*').css('cursor', 'default');
                        
                       
                    }
                });
                
            });
    });

    </script>

</body>
</html>
