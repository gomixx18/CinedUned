<!DOCTYPE html>

<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Modificar TFG</title>

        
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
            header("Location: admin_TFG.php");
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
                        <h2>Modificar TFG </h2>
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
                                <li id="liEstudiante" class=""><a data-toggle="tab" href="#tab-2">Estudiantes</a></li>
                                <li id="liDirector" class=""><a data-toggle="tab" href="#tab-3">Directores</a></li>
                                <li id="liAsesor" class=""><a data-toggle="tab" href="#tab-4">Asesores</a></li>

                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <h4>Modificar Título</h4>
                                        <?php
                                        $consulta = "SELECT tfg.titulo FROM tfg where tfg.codigo = '$codigo'";
                                        $query = mysqli_query($connection, $consulta);
                                        $data = mysqli_fetch_assoc($query);
                                        $titulo = $data["titulo"];
                                        ?>
                                        <div class="col-lg-6 col-lg-offset-1">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Titulo del tfg:</label>
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
                                        <h4>Modificar Estudiantes</h4>
                                        <form method="POST" action="funcionalidad/modificarEstudiantesTFG.php" onsubmit="return validarGuardar('estudiante')">
                                            <input name="codigo" type="hidden"  value="<?php echo $codigo  ?>" />
                                        <div class="col-lg-4">    
                                        <div id="estudiantes">
                                            <?php
                                            $consulta = "select tfgestudiantes.id, concat(tfgestudiantes.nombre,' ',  tfgestudiantes.apellido1, ' ', tfgestudiantes.apellido2) as nombre 
                                                                  from tfg,tfgestudiantes, tfgrealizan where tfgrealizan.estado= 1 and tfg.codigo = tfgrealizan.tfg and tfgrealizan.estudiante = tfgestudiantes.id and tfg.codigo ='" . $codigo . "'";
                                            $query2 = mysqli_query($connection, $consulta);
                                            $contador = 1;
                                            while ($data2 = mysqli_fetch_assoc($query2)) {
                                                echo "<div id='divEstud" . $contador . "'>";

                                                echo "<label>Estudiante:</label>";
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
                                                            <h5>Consulta de Estudiantes</h5>
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
                                                                            $query = mysqli_query($connection, "SELECT * FROM tfgestudiantes where estado = 1");


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
                                                            <button name="btnSelectEstu"  class="btn btn-primary btn-rounded" onclick='selectEstudiantes2("Estudiante")' type="button" placeholder='agregar'>Asignar Estudiante</button>
                                                            <button class="btn btn-primary btn-rounded" type="submit" name="modificarEstudiantesTFG.php">Guardar Cambios</button>
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
                                        <h4>Modificar Director TFG</h4>
                                        <form method="POST" action="funcionalidad/modificarDirectoresTFG.php">
                                            <input name="codigo" type="hidden"  value="<?php echo $codigo  ?>" />
                                        <div class="col-lg-4">    
                                        <div id="estudiantes2">
                                            <?php
                                            $consulta = "select tfgdirectores.id, concat(tfgdirectores.nombre,' ',  tfgdirectores.apellido1, ' ', tfgdirectores.apellido2) as nombre 
                                                                  from tfg,tfgdirectores where tfg.directortfg = tfgdirectores.id and tfg.codigo ='" . $codigo . "'";
                                            $query2 = mysqli_query($connection, $consulta);
                                            $contador = 1;
                                            while ($data2 = mysqli_fetch_assoc($query2)) {
                                                echo "<div id='divEstud" . $contador . "'>";

                                                echo "<label>Director:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class='col-lg-12'>";
                                                echo "<input id='' name='' type='text' value='" . $data2['nombre'] . "' class='form-control' disabled>";
                                                echo "</div>";
                                                echo "</div>";

                                                echo "<label>Cedula:</label>";
                                                echo "<div class='row'>";
                                                echo "<div class = 'col-lg-5'>";
                                                echo "<input id = 'idEstudiante" . $contador . "' type = 'text' value = " . $data2['id'] . " class = 'form-control' disabled >";
                                                echo "<input name = 'nameDirector" . $contador . "' type = 'hidden' value = " . $data2['id'] . " class = 'form-control'>";

                                                echo "</div>";

                                                
                                                echo "</div></br>";
                                                echo "</div>";
                                         


                                                $contador++;
                                            }
                                            ?> 

                                        </div>
                                            <p id='errorDirector' > </p>
                                        </div>
                                        
                                       

                                        <div class="col-lg-8" id="estudiantesTabla2">

                                            <!-- inicio tabla estudiantes -->
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="ibox float-e-margins">

                                                        <div class="ibox-title">
                                                            <h5>Consulta de Directores TFG</h5>
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
                                                                                <th name="apellido1">Especialidad</th>
                                                                                <th name="apellido2">Titulo</th>
                                                                                <th name="accion">Acción</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $query = mysqli_query($connection, "SELECT * FROM tfgdirectores where estado = 1");


                                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                                echo "<tr>";
                                                                                echo "<td name = 'id'>" . $data["id"] . "</td>";
                                                                                echo "<td name = 'nombre'>" . $data["nombre"] . "</td>";
                                                                                echo "<td name = 'apellido1'>" . $data["apellido1"] . "</td>";
                                                                                echo "<td name = 'apellido2'>" . $data["apellido2"] . "</td>";
                                                                                echo "<td name = 'especialidad'>" . $data["especialidad"] . "</td>";
                                                                                echo "<td name = 'titulo'>" . $data["titulo"] . "</td>";
                                                                                echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '"  name="radEstudiante" tituloaux = "' . $data["titulo"] . '" especialidadaux = "' . $data["especialidad"] . '" nombreaux = "' . $data["nombre"] . '" ap1aux = "' . $data["apellido1"] . '" ap2aux = "' . $data["apellido2"] . '"></div></td>';
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
                                                                                <th>Titulo</th>
                                                                                <th>Acción</th>
                                                                                <th>Acción</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
                                                            <button class="btn btn-primary btn-rounded" type="submit" name="modificarDirectoresTFG">Guardar Cambios</button>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <!--fin tabla estudiantes -->

                                        </div>
                                     </form>
                                    </div>
                                </div>
                                    <div id = "tab-4" class = "tab-pane">
                                    <div class="panel-body">
                                        <h4>Modificar Asesores</h4>
                                        <form method="POST" action="funcionalidad/modificarAsesoresTFG.php" onsubmit="return validarGuardar('asesor')">
                                            <input name="codigo" type="hidden"  value="<?php echo $codigo  ?>" />
                                        <div class="col-lg-4">    
                                        <div id="estudiantes3">
                                            <?php
                                            $consulta = "select tfgasesores.id, concat(tfgasesores.nombre,' ',  tfgasesores.apellido1, ' ', tfgasesores.apellido2) as nombre 
                                                                  from tfg,tfgasesores, tfgasesoran where tfgasesoran.estado= 1 and tfg.codigo = tfgasesoran.tfg and tfgasesoran.asesor = tfgasesores.id and tfg.codigo ='" . $codigo . "'";
                                            $query2 = mysqli_query($connection, $consulta);
                                            $contador = 1;
                                            while ($data2 = mysqli_fetch_assoc($query2)) {
                                                echo "<div id='divEstud" . $contador . "'>";

                                                echo "<label>Asesor:</label>";
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
                                                            <h5>Consulta de Asesores</h5>
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
                                                                                <th name="especialidad">Especialidad</th>
                                                                                <th name="titulo">Título</th>
                                                                                <th name="accion">Acción</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $query = mysqli_query($connection, "SELECT * FROM tfgasesores where estado = 1");


                                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                                echo "<tr>";
                                                                                echo "<td name = 'id'>" . $data["id"] . "</td>";
                                                                                echo "<td name = 'nombre'>" . $data["nombre"] . "</td>";
                                                                                echo "<td name = 'apellido1'>" . $data["apellido1"] . "</td>";
                                                                                echo "<td name = 'apellido2'>" . $data["apellido2"] . "</td>";
                                                                                echo "<td name = 'especialidad'>" . $data["especialidad"] . "</td>";
                                                                                echo "<td name = 'titulo'>" . $data["titulo"] . "</td>";
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
                                                                                <th>Especialidad</th>
                                                                                <th>Titulo</th>
                                                                                <th>Acción</th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <button name="btnSelectEstu"  class="btn btn-primary btn-rounded" onclick='selectEstudiantes2("Asesor")' type="button" placeholder='agregar'>Asignar Asesor</button>
                                                            <button class="btn btn-primary btn-rounded" type="submit" name="modificarAsesoresTFG">Guardar Cambios</button>
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

                                                                        $.get("funcionalidad/TFGTitulo.php", {titulo: titulo, tfg: cod}, function (data) {
                                                                            
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
                getInputs();
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
        
            if(selectedTab === "estudiante"){
                $('#liEstudiante').addClass("active");
                $('#tab-1').removeClass("active");
                $('#tab-2').addClass("active");
                $('#tab-3').removeClass("active");
                $('#tab-4').removeClass("active");
            }
            if(selectedTab === "asesor"){
                $('#liAsesor').addClass("active");
                $('#tab-1').removeClass("active");
                $('#tab-2').removeClass("active");
                $('#tab-3').removeClass("active");
                $('#tab-4').addClass("active");
            }
            if(selectedTab === "director"){
                $('#liDirector').addClass("active");
                $('#tab-1').removeClass("active");
                $('#tab-2').removeClass("active");
                $('#tab-3').addClass("active");
                $('#tab-4').removeClass("active");
                
            }
            if(selectedTab === "titulo"){
                
                $('#lititulo').addClass("active");
                $('#tab-1').addClass("active");
                $('#tab-2').removeClass("active");
                $('#tab-3').removeClass("active");
                $('#tab-4').removeClass("active");
                
            }
            });
        </script>


    </body>
</html>
