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
                    <div class="col-sm-4">
                        <h1>Reportes - TFG</h1>

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
                                        <div class="col-md-2 col-lg-offset-1">

                                            <label>
                                                Estado del TFG <input type="checkbox" id="ETFG0" name="ETFG0" value="" class="i-checks">
                                            </label>
                                        </div>
                                        <div class="col-md-4" id="divETFG0">

                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4>Filtrar por etapa(s)</h4>
                                        </div>
                                        </br>
                                    </div>
                                    <div class="row">


                                        <div class="col-md-2 col-lg-offset-1">

                                            <label>
                                                Etapa #1 <input type="checkbox" id="ETFG1" name="ETFG1" value="" class="i-checks">
                                            </label>

                                        </div>
                                        <div class="col-md-4" id="divETFG1">

                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2 col-lg-offset-1">

                                            <label>
                                                Etapa #2 <input type="checkbox" id="ETFG2" name="ETFG2" value="" class="i-checks">
                                            </label>

                                        </div>
                                        <div class="col-md-4" id="divETFG2">

                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2 col-lg-offset-1">

                                            <label>
                                                Etapa #3 <input type="checkbox" id="ETFG3" name="ETFG3" value="" class="i-checks">
                                            </label>

                                        </div>
                                        <div class="col-md-4" id="divETFG3">

                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2">

                                          
                                            <h4>Fechas de inicio y finalización</h4>
                                            
                                            <?php
                                            $fecha_actual = date("Y-m-d");
                                            $nuevafecha = date('Y-m-d', strtotime('+1 month'))
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="" class="form-group">
                                                <input class="form-control" type="text" name="daterange" value="<?php echo $fecha_actual . " - " . $nuevafecha ?> " />

                                            </div>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2">

                                            <h4>
                                                Carrera
                                            </h4>

                                        </div>
                                        <div class="col-md-4">
                                            <select multiple name="carrera" id="carrera" class="form-control">

                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }
                                                $query = mysqli_query($connection, "SELECT * FROM carreras");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                }

                                                mysqli_close($connection);
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2">


                                            <h4>
                                                Línea de Investigación
                                            </h4>


                                        </div>
                                        <div class="col-md-4">
                                            <select multiple name="lineaInvest" id="linea" class="form-control">

                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }
                                                $query = mysqli_query($connection, "SELECT * FROM lineasinvestigacion");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                }

                                                mysqli_close($connection);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2">

                                            <h4>
                                                Modalidad
                                            </h4>


                                        </div>
                                        <div class="col-md-4">
                                            <select multiple name="modalidad" id="modalidad" class="form-control">

                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }
                                                $query = mysqli_query($connection, "SELECT * FROM modalidades");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                }

                                                mysqli_close($connection);
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <h4>
                                                Solo estadística: 
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="checkbox" id="estadistica" name="" value="" class="i-checks" onchange="">
                                        </div>
                                    </div>
                                    </br>

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
        reporte();
        var estadoTFG = [];
        var estadosE1 = [];
        var estadosE2 = [];
        var estadosE3 = [];
        function reporte() {
            $("#report").click(function (evento) {
                evento.preventDefault();
                parametros();
                var carrera = $("#carrera").val();
                var linea = $("#linea").val();
                var modalidad = $("#modalidad").val();
                var estadistica = $('#estadistica').is(':checked');
                
                var car = {};
                car = JSON.stringify(carrera);
                var mod = {};
                mod = JSON.stringify(modalidad);
                var lin = {};
                lin = JSON.stringify(linea);
                var Etfg = {};
                Etfg = JSON.stringify(estadoTFG);
                var Etfg1 = {};
                Etfg1 = JSON.stringify(estadosE1);
                var Etfg2 = {};
                Etfg2 = JSON.stringify(estadosE2);
                var Etfg3 = {};
                Etfg3 = JSON.stringify(estadosE3);

                $.get("funcionalidad/reportesTFG.php", {Etfg: Etfg, Etfg1: Etfg1, Etfg2: Etfg2, Etfg3: Etfg3, carrera: car, linea: lin, modalidad: mod, fechainicio: inifecha, fechafin: finfecha, estadistica: estadistica}, function (data) {
                    $("#consulta").html(data);
                    window.open('funcionalidad/pdfParserTFG.php', '_blank');
                }).fail(function () {

                });

                estadoTFG = [];
                estadosE1 = [];
                estadosE2 = [];
                estadosE3 = [];
                //alert("ksjadsa");

            });
        }



        function parametros() {
            if (ischeck("ETFG0")) {
                est();
            }
            for (var i = 1; i < 4; i++) {
                if (ischeck("ETFG" + i)) {
                    esteta(i);
                }

            }

        }

        function esteta(n) {
            for (var i = 1; i < 5; i++) {
                if (ischeck("ETFG" + n + i)) {

                    var x = $("#ETFG" + n + i).prop("value");

                    eval("estadosE" + n + "[estadosE" + n + ".length]=\"" + x + "\";");
                    //alert(eval("estadosE" + n));
                }
            }
        }

        function est() {
            for (var i = 1; i < 5; i++) {
                if (ischeck("ETFG0" + i)) {
                    var x = $("#ETFG0" + i).prop("value");
                    eval("estadoTFG[estadoTFG.length]=\"" + x + "\";");
                    // alert(eval("estadoTFG" + ".ETFG0" + i));

                }
            }
        }
        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            picker.startDate.format('YYYY-MM-DD');
            picker.endDate.format('YYYY-MM-DD');
            inifecha = (picker.startDate.format('YYYY-MM-DD'));
            finfecha = (picker.endDate.format('YYYY-MM-DD'));

        });
        var inifecha = "";
        var finfecha = "";
        $('input[name="daterange"]').daterangepicker({
            //locale: {
            format: 'YYYY-MM-DD',
            separator: " / ",
            startDate: moment().subtract('days', 29),
            endDate: moment()
                    //}
        }, function (start, end, label) {

            //startDate = start;
            //endDate = end;
        });
        /*
         $(function () {
         $("form#reporte").submit(function () {
         
         
         $('*').css('cursor', 'progress');
         $.ajax({
         url: "funcionalidad/reportesTFG.php",
         type: "POST",
         data: "",
         dataType: "json",
         success: function (data) {
         for (var i in data)
         {
         var row = data[i];
         
         var id = row[0];
         var vname = row[1];
         alert(id);
         }
         
         
         $('*').css('cursor', 'default');
         }
         });
         return false;
         });
         });
         */

        function estado(checkbox) {

            if (ischeck(checkbox)) {
                $("#div" + checkbox).append("<input type='checkbox' id='" + checkbox + "1' name='" + checkbox + "1' value='Activo' class='i-checks'><label>Activo</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "2' name='" + checkbox + "2' value='Inactivo' class='i-checks'><label>Inactivo</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "3' name='" + checkbox + "3' value='Aprobado para defensa' class='i-checks'><label>Aprobado para defensa</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "4' name='" + checkbox + "4' value='Finalizado' class='i-checks'><label>Finalizado</label><br><br>")
                        .iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green'
                        });
            } else {
                $("#div" + checkbox).empty();
            }
        }
        function estadoEtapa(checkbox) {

            if (ischeck(checkbox)) {
                $("#div" + checkbox).append("<input type='checkbox' id='" + checkbox + "1' name='" + checkbox + "1' value='Aprobada' class='i-checks'><label>Aprobada</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "2' name='" + checkbox + "2' value='Aprobada con Observaciones' class='i-checks'><label>Aprobada con Observaciones</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "3' name='" + checkbox + "3' value='No Aprobada' class='i-checks'><label>No Aprobada</label><br><br>"
                        + "<input type='checkbox' id='" + checkbox + "4' name='" + checkbox + "4' value='En ejecución'  class='i-checks'><label>En ejecución</label><br><br>")
                        .iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green'
                        });
            } else {
                $("#div" + checkbox).empty();
            }
        }
        function ischeck(checkbox) {
            return $("#" + checkbox).is(':checked');
        }

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('#ETFG0').on('ifChanged', function (event) {
            estado("ETFG0");
        });
        $('#ETFG1').on('ifChanged', function (event) {
            estadoEtapa("ETFG1");
        });
        $('#ETFG2').on('ifChanged', function (event) {
            estadoEtapa("ETFG2");
        });
        $('#ETFG3').on('ifChanged', function (event) {
            estadoEtapa("ETFG3");
        });




    </script>

</html>


