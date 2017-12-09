<!DOCTYPE html>

<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Modificar Proyecto de Investigación</title>

        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
        <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/plugins/summernote/summernote.css" rel="stylesheet">
        <link href="css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <script src="js/funciones.js" type="text/javascript"></script>
        <?php
        if (isset($_POST["codigo"])===false) {
            header("Location: admin_Investigacion.php");
        }
        
        if (isset($_POST["tabSelect"])) {
            $tabselect = $_POST["tabSelect"];
        }else{
        $tabselect = "titulo";
        }
        require 'navegacion/nav-lateral.php';
        ?>
    </head>
    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Modificar Proyecto de Investigación </h2>
                        <?php
                        $mensaje = "Sin cambios";
                        $banderaEstudiantes = false;
                        if (isset($_POST["estudiantes"])) {
                            $banderaEstudiantes = true;
                            $mensaje = $_POST["estudiantes"];
                        }
                        
                        $codigo = $_POST["codigo"];
                        $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                        if (!$connection) {
                            exit("<label class='error'>Error de conexión</label>");
                        }
                        ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li id="lititulo" class=""><a data-toggle="tab" href="#tab-1"> Título</a></li>
                                <li id="liInvestigador" class=""><a data-toggle="tab" href="#tab-2">Investigadores</a></li>
                                <li id="liEvaluador" class=""><a data-toggle="tab" href="#tab-3">Evaluadores</a></li>
        

                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <h4>Modificar Título</h4>
                                        <?php
                                        $consulta = "SELECT ieproyectos.titulo FROM ieproyectos where ieproyectos.codigo = '$codigo'";
                                        $query = mysqli_query($connection, $consulta);
                                        $data = mysqli_fetch_assoc($query);
                                        $titulo = $data["titulo"];
                                        ?>
                                        <div class="col-lg-6 col-lg-offset-1">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Titulo del Proyecto de Investigación:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group" id="">
                                                    <input id="nomProyecto" name="tituloTFG" type="text" value="<?php echo $titulo ?>" class="form-control required"> 
                                                </div>

                                            </div>

                                            <div class="col-lg-3 col-lg-offset-6">
                                                <div class="form-group">
                                                    <input id="guardarTitulo" type="button" class="btn btn-primary" value="Guardar Título">
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <h4>Modificar Investigadores</h4>
                                        <form method="POST" action="funcionalidad/modificarInvestigadoresIE.php" onsubmit="return validarGuardar('estudiante')">
                                            <input name="codigo" type="hidden"  value="<?php echo $codigo  ?>" />
                                        <div class="col-lg-4">    
                                        <div id="estudiantes">
                                            <?php
                                            $consulta = "select ieinvestigadores.id, concat(ieinvestigadores.nombre,' ',  ieinvestigadores.apellido1, ' ', ieinvestigadores.apellido2) as nombre 
                                                                  from ieproyectos,ieinvestigadores, ieinvestigan where ieinvestigan.estado= 1 and ieproyectos.codigo = ieinvestigan.proyecto and ieinvestigan.investigador = ieinvestigadores.id and ieproyectos.codigo ='" . $codigo . "'";
                                            $query2 = mysqli_query($connection, $consulta);
                                            $contador = 1;
                                            while ($data2 = mysqli_fetch_assoc($query2)) {
                                                echo "<div id='divEstud" . $contador . "'>";

                                                echo "<label>Investigador:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-12'>";
                                                echo "<input id='' name='' type='text' value='" . $data2['nombre'] . "' class='form-control' disabled>";
                                                echo "</div>";
                                                echo "</div>";

                                                echo "<label>Cedula:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class = 'col-lg-5'>";
                                                echo "<input id = 'idEstudiante" . $contador . "' type = 'text' value = " . $data2['id'] . " class = 'form-control' disabled >";
                                                echo "<input name = 'nameEstudiante" . $contador . "' type = 'hidden' value = " . $data2['id'] . " class = 'form-control'>";

                                                echo "</div>";

                                                echo "<div class = 'col-lg-3'>";
                                                echo "Activo";
                                                echo "<input type='radio' value='1' class='i-checks' name='activo" . $data2['id'] . "' checked='checked'>";
                                                echo "</div>";
                                                echo "<div class = 'col-lg-3'>";
                                                echo "Inactivo";
                                                echo "<input type='radio' value='0' class='ni-checks' name='activo" . $data2['id'] . "' >";
                                                echo "</div>";
                                                echo "</div></br>";
                                                echo "</div>";
                                         


                                                $contador++;
                                            }
                                            ?> 

                                        </div>
                                            <p id='errorEstudiante' > </p>
                                        </div>
                                        
                                       

                                        <div class="col-lg-8" id="estudiantesTabla">

                                            <!-- inicio tabla estudiantes -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="ibox float-e-margins">

                                                        <div class="ibox-title">
                                                            <h5>Consulta de Investigadores</h5>
                                                        </div>
                                                        <div class="ibox-content">

                                                            <div class="table-responsive">
                                                                <div id="tablaEstudiantes">
                                                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th name="id">Identificación</th>
                                                                                <th name="nombre">Nombre</th>
                                                                                <th name="apellido1">Primer Apellido</th>
                                                                                <th name="apellido2">Segundo Apellido</th>
                                                                                <th name="accion">Acción</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $query = mysqli_query($connection, "SELECT * FROM ieinvestigadores where estado = 1");


                                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                                echo "<tr>";
                                                                                echo "<td name = 'id'>" . $data["id"] . "</td>";
                                                                                echo "<td name = 'nombre'>" . $data["nombre"] . "</td>";
                                                                                echo "<td name = 'apellido1'>" . $data["apellido1"] . "</td>";
                                                                                echo "<td name = 'apellido2'>" . $data["apellido2"] . "</td>";
                                                                                echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radEstudiante" nombreaux = "' . $data["nombre"] . '" ap1aux = "' . $data["apellido1"] . '" ap2aux = "' . $data["apellido2"] . '"></div></td>';
                                                                                echo "</tr>";
                                                                            }
                                                                            ?>


                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>Identificación</th>
                                                                                <th>Nombre</th>
                                                                                <th>Primer Apellido</th>
                                                                                <th>Segundo Apellido</th>
                                                                                <th>Acción</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <button name="btnSelectEstu"  class="btn btn-primary btn-rounded" onclick='selectEstudiantes2("Investigador")' type="button" placeholder='agregar'>Asignar Investigador</button>
                                                            <button class="btn btn-primary btn-rounded" type="submit" name="modificarInvestigadoresIE">Guardar Cambios</button>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <!--fin tabla estudiantes -->

                                        </div>
                                     </form>
                                    </div>
                                </div>
                   
                                    <div id = "tab-3" class = "tab-pane">
                                    <div class="panel-body">
                                        <h4>Modificar Evaluadores</h4>
                                        <form method="POST" action="funcionalidad/modificarEvaluadoresIE.php" onsubmit="return validarGuardar('asesor')">
                                            <input name="codigo" type="hidden"  value="<?php echo $codigo  ?>" />
                                        <div class="col-lg-4">    
                                        <div id="estudiantes3">
                                            <?php
                                            $consulta = "select ieevaluadores.id, concat(ieevaluadores.nombre,' ',  ieevaluadores.apellido1, ' ', ieevaluadores.apellido2) as nombre 
                                                                  from ieproyectos,ieevaluadores, ieevaluan where ieevaluan.estado= 1 and ieproyectos.codigo = ieevaluan.proyecto and ieevaluan.evaluador = ieevaluadores.id and ieproyectos.codigo ='" . $codigo . "'";
                                            $query2 = mysqli_query($connection, $consulta);
                                            $contador = 1;
                                            while ($data2 = mysqli_fetch_assoc($query2)) {
                                                echo "<div id='divEstud" . $contador . "'>";

                                                echo "<label>Evaluador:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-12'>";
                                                echo "<input id='' name='' type='text' value='" . $data2['nombre'] . "' class='form-control' disabled>";
                                                echo "</div>";
                                                echo "</div>";

                                                echo "<label>Cedula:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class = 'col-lg-5'>";
                                                echo "<input id = 'idEstudiante" . $contador . "' type = 'text' value = " . $data2['id'] . " class = 'form-control' disabled >";
                                                echo "<input name = 'nameAsesor" . $contador . "' type = 'hidden' value = " . $data2['id'] . " class = 'form-control'>";

                                                echo "</div>";

                                                echo "<div class = 'col-lg-3'>";
                                                echo "Activo";
                                                echo "<input type='radio' value='1' class='i-checks' name='activoAsesor" . $data2['id'] . "' checked='checked'>";
                                                echo "</div>";
                                                echo "<div class = 'col-lg-3'>";
                                                echo "Inactivo";
                                                echo "<input type='radio' value='0' class='ni-checks' name='activoAsesor" . $data2['id'] . "' >";
                                                echo "</div>";
                                                echo "</div></br>";
                                                echo "</div>";
                                         


                                                $contador++;
                                            }
                                            ?> 

                                        </div>
                                            <p id='errorAsesor' > </p>
                                        </div>
                                        
                                       

                                        <div class="col-lg-8" id="estudiantesTabla3">

                                            <!-- inicio tabla estudiantes -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="ibox float-e-margins">

                                                        <div class="ibox-title">
                                                            <h5>Consulta de Evaluadores</h5>
                                                        </div>
                                                        <div class="ibox-content">

                                                            <div class="table-responsive">
                                                                <div id="tablaEstudiantes">
                                                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th name="id">Identificación</th>
                                                                                <th name="nombre">Nombre</th>
                                                                                <th name="apellido1">Primer Apellido</th>
                                                                                <th name="apellido2">Segundo Apellido</th>
                                                                    
                                                                                <th name="accion">Acción</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $query = mysqli_query($connection, "SELECT * FROM ieevaluadores where estado = 1");


                                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                                echo "<tr>";
                                                                                echo "<td name = 'id'>" . $data["id"] . "</td>";
                                                                                echo "<td name = 'nombre'>" . $data["nombre"] . "</td>";
                                                                                echo "<td name = 'apellido1'>" . $data["apellido1"] . "</td>";
                                                                                echo "<td name = 'apellido2'>" . $data["apellido2"] . "</td>";
                                                   
                                                                                echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radEstudiante" nombreaux = "' . $data["nombre"] . '" ap1aux = "' . $data["apellido1"] . '" ap2aux = "' . $data["apellido2"] . '"></div></td>';
                                                                                echo "</tr>";
                                                                            }
                                                                            ?>


                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th>Identificación</th>
                                                                                <th>Nombre</th>
                                                                                <th>Primer Apellido</th>
                                                                                <th>Segundo Apellido</th>
                                                                                <th>Acción</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <button name="btnSelectEstu"  class="btn btn-primary btn-rounded" onclick='selectEstudiantes2("Evaluador")' type="button" placeholder='agregar'>Asignar Evaluador</button>
                                                            <button class="btn btn-primary btn-rounded" type="submit" name="modificarEvaluadoresIE">Guardar Cambios</button>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <!--fin tabla estudiantes -->

                                        </div>
                                     </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>



                <div class = "footer">
                    Universidad Nacional &copy;
                    2015-2016
                </div>

            </div>
        </div>

        <script src = "js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

        <script src="js/plugins/dataTables/datatables.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js" type="text/javascript"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js"></script>
        <!-- Color picker -->
        <script src="js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- Page-Level Scripts -->

        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"><p id="menjmodal"> <?php echo $mensaje?></p></h3>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sus cambios han sido guardados exitósamente.</p>
                                <div>    
                                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Aceptar</strong></button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>

                                                                $(document).ready(function () {
                                                                    guardarTitulo();
                                                                });


                                                                function guardarTitulo() {

                                                                    $("#guardarTitulo").click(function (evento) {
                                                                        evento.preventDefault();
                                                                        var cod = "<?php echo $codigo ?>";
                                                                        var titulo = $("#nomProyecto").val();

                                                                        $.get("funcionalidad/IETitulo.php", {titulo: titulo, proyecto: cod}, function (data) {
                                                                            
                                                                            $("#menjmodal").text(data);
                                                                            $('#modal-form').modal('show');
                                                                        });
                                                                    });
                                                                }

                                                                $(document).ready(function () {
                                                                    $('.i-checks').iCheck({
                                                                        checkboxClass: 'icheckbox_square-green',
                                                                        radioClass: 'iradio_square-green',
                                                                    });
                                                                });
                                                                $('.ni-checks').iCheck({
                                                                    checkboxClass: 'icheckbox_square-red',
                                                                    radioClass: 'iradio_square-red'
                                                                });
                                                                
                                                                

        </script>
        <script>
            $(document).ready(function () {

                function getFecha() {

                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fecha = new Date();
                    $dia = $fecha.getDate();
                    $mes = $fecha.getMonth();
                    $anno = $fecha.getFullYear();
                    $hora = $fecha.getHours();
                    $minutos = $fecha.getMinutes();
                    $segundos = $fecha.getSeconds();
                    return $dia + "/" + meses[$mes] + '/' + $anno + ' ' + $hora + ':' + $minutos + ':' + $segundos;
                }
                ;


                table = $('.dataTables-example').DataTable({
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy'},
                        {extend: 'csv'},
                        {extend: 'excel', title: 'Reporte de Estudiantes'},
                        {extend: 'pdf',
                            title: 'Estudiantes Reporte',
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                        },
                        {extend: 'print',
                            customize: function (win) {
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');

                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                            }
                        },
                    ]
                });


                

            });

            


        </script>
        <script>
            $(document).ready(function(){
            if(<?php echo $banderaEstudiantes  ?>){
                $('#modal-form').modal('show');
            }
            });
        </script>
        <script>
            $(document).ready(function(){
                
            var selectedTab = "<?php echo $tabselect  ?>" ;
        
            if(selectedTab === "investigador"){
                $('#liInvestigador').addClass("active");
                $('#tab-1').removeClass("active");
                $('#tab-2').addClass("active");
                $('#tab-3').removeClass("active");

            }
            if(selectedTab === "evaluador"){
                $('#liEvaluador').addClass("active");
                $('#tab-1').removeClass("active");
                $('#tab-2').removeClass("active");
                $('#tab-3').addClass("active");
            }
            
            if(selectedTab === "titulo"){
                
                $('#lititulo').addClass("active");
                $('#tab-1').addClass("active");
                $('#tab-2').removeClass("active");
                $('#tab-3').removeClass("active");
           
                
            }
            });
        </script>


    </body>
</html>
