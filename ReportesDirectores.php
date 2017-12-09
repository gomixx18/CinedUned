<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reportes de TFG</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        
        <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
        <?php
        require 'navegacion/nav-lateral.php';
        ?>
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">

                <?php require 'navegacion/nav-superior.php' ?>

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-12">
                        <h1>Reportes - TFG  - Directores</h1>

                    </div>

                </div>

                <div class="wrapper wrapper-content">

                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div id="ReporteTFG">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4>Filtrar por</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <form id="frm_reporte_director">
                                        <div class="col-md-2">
                                            <h4>Cédula Director</h4>
                                        </div>
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <input id="ced_director" name="ced_director" type="text" placeholder="Cédula Director" class="form-control">
                                               </div>
                                                <div class="col-lg-pull-1">
                                                <div class="form-group ">
                                                    <button class="btn btn-primary" id="btnBuscar" type="button" value=""><i class="fa fa-fw fa-search"></i>Buscar Director</button>
                                                    <span id="resultado" class="label label-danger" hidden></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                  
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h4>Fechas de inicio y finalización</h4>
                                            <?php
                                            $fecha_actual = date("d-m-Y");
                                            $nuevafecha = date('d-m-Y', strtotime('+1 month'))
                                            ?>
                                        </div>
                                        <div class="col-lg-4">
                                            <div id="" class="form-group">
                                                <input class="form-control" type="text" name="daterange" value="<?php echo $fecha_actual . " / " . $nuevafecha ?> " />

                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-2  col-lg-offset-2">
                                            <button id="report" type="" class="btn btn-primary">Generar Reporte</button>
                                          <div id="consulta">
                                           
                                          
                                        </div>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>
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
        <script src="js/plugins/fullcalendar/moment.min.js"></script>
        <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

        <!-- Date range picker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Custom and plugin javascript -->
        <script src="js/plugins/iCheck/icheck.min.js"></script>
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>



    </body>
    <script>
        
            $("#report").click(function (evento) {
                evento.preventDefault();
                var id = $("#ced_director").val();
                var error = $("#resultado");
               
                if (!id || id.length === 0 || !inifecha || !finfecha){
                    error.text("Debe seleccionar un rango de Fechas y una cédula");
                }else{
                     error.hide();
                    
                    $.ajax({
                        url: "funcionalidad/reportes_tfg_directores.php",
                        method: "POST",
                        data: {id: id, fechaInicial: inifecha, fechaFinal: finfecha},
                        //dataType: 'json',
                        success: function (response) {
                           alert(response);
                        }
                    });
                }
            });

        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            picker.startDate.format('DD-MM-YYYY');
            picker.endDate.format('DD-MM-YYYY');
            inifecha = (picker.startDate.format('DD-MM-YYYY'));
            finfecha = (picker.endDate.format('DD-MM-YYYY'));

        });
        var inifecha = "";
        var finfecha = "";
        $('input[name="daterange"]').daterangepicker({
            //locale: {
            format: 'DD-MM-YYYY',
            separator: " / ",
            startDate: moment().subtract('days', 29),
            endDate: moment()
                    //}
        }, function (start, end, label) {

            startDate = start;
            endDate = end;
        });
        
        $("#btnBuscar").click(function (evento){
            evento.preventDefault();
            var id = $("#ced_director").val();
            var error = $("#resultado");
           if (!id || id.length === 0){
                        error.text("Debe insertar una cédula");
            }else{
            $.ajax({
                        url: "funcionalidad/buscarUsuariosReportes.php",
                        method: "POST",
                        data: $("#frm_reporte_director").serialize(),
                        dataType:'json',
                        success: function (response) {
                            if(response.error){
                                error.removeClass("label-primary");
                                error.addClass("label-danger");
                                error.text("No hay coincidencias.")
                            }else{
                                error.removeClass("label-danger");
                                error.addClass("label-primary");
                                error.text(response.nombre);
                            }
                            error.show();
                        }
                        
                    });
            }
        });
     

       
    </script>

</html>


