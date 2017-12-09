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
        <title>Cambio de Contraseña</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery-2.1.1.js"></script>
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body class="gray-bg">
        <?php
        $userGet = $_GET['usuario'];
        
        ?>
        <script type="text/javascript">
            $(function () {

                $("form#changePass").submit(function () {
                    var oldP = $("#oldP").val();
                    var newP = $("#newP").val();
                    var err = $("#result");
                    var userGet = $("#userGet").val();
                    
                    err = err.hide();
                    $('*').css('cursor', 'progress');
                    $.ajax({
                        url: "funcionalidad/cambioContrasena.php",
                        type: "POST",
                        data: {
                            oldP: oldP,
                            newP: newP,
                            userGet: userGet
                        },
                        dataType: "json",
                        success: function (data) {

                            if (data.status === 'success') {
                                err = err.text("Su contraseña ha sido cambiada.").css('color', 'green');
                            } else if (data.status === 'error') {
                                err = err.text("La contraseña que ha ingresado es incorrecta. Inténtelo de nuevo.").css('color', 'red');
                            }
                            else if (data.status === 'error2') {
                                err = err.text("Error consulta de BD.").css('color', 'red');
                            }else if (data.status === 'db_conn_error') {
                                err = err.text("No se puede establecer conexión con la base de datos. Comuníquese con el encargado.");
                            }
                            err.fadeIn(1000);
                            $('*').css('cursor', 'default');
                        }
                    });
                    return false;
                });
            });
        </script>


        <div class="passwordBox animated fadeInDown">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox-content">

                        <h2 class="font-bold">Cambiar Contraseña</h2>

                        <div class="row">
                            <div class="col-lg-14">
                                <form id="changePass" action="funcionalidad/cambioContrasena.php" class="form-horizontal">

                                    <input type="hidden" id="userGet" name="userGet" value="<?= $userGet ?>" >

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Contraseña Anterior</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="oldP" name="oldP" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Contraseña Nueva</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="newP" name="newP" placeholder="">
                                        </div>
                                         
                                    </div>
                                    <button type="submit" name="modifyPass" class="btn btn-primary center-block">Guardar</button>
                                    <br>
                                    <p id="result" align="center">

                                    </p>
                                </form>
                            </div>
                        </div>
                         
                    </div>
                   <a href="http://cined.uned.ac.cr/" style="float: right;">Regresar a Página Principal</a>
                </div>
            </div>





    </body>
</html>