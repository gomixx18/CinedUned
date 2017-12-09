<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Registrar TFG</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
        <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
        <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
        <link href="css/plugins/select2/select2.min.css" rel="stylesheet">
        <link href="css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

        <?php
        require 'navegacion/nav-lateral.php';
        ?>

    </head>

    <body>

        <div id="wrapper">

            <div id="page-wrapper" class="gray-bg">        
                <?php require 'navegacion/nav-superior.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Administración TFG</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Registrar TFG</strong>
                            </li>
                            <li>
                                <a href="admin_TFG.php">Consultar TFG</a>
                            </li>

                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRightBig">   
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Registrar Nuevo Trabajo Final de Graduación</h5>
                                </div>
                                <div class="ibox-content">

                                    <form id="form" method="POST" action="funcionalidad/crearTFG.php" class="wizard-big">
                                        <h1>TFG</h1>
                                        <fieldset>
                                            <h2>Información del Trabajo</h2>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Título de TFG</label>
                                                        <input id="nomProyecto" name="tituloTFG" maxlength="250" type="text" class="form-control required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Línea de Investigación</label>
                                                        <select id="lineaInvest" name='lineaInvest' class=" select2_investigacion form-control required" tabindex="-1" aria-required='true'>
                                                            <option></option>

                                                            <?php
                                                            $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                            if (!$connection) {
                                                                exit("<label class='error'>Error de conexión</label>");
                                                            }

                                                            $query = mysqli_query($connection, "SELECT * FROM lineasinvestigacion");


                                                            while ($data = mysqli_fetch_assoc($query)) {

                                                                echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">                                              
                                                        <label>Carrera</label>
                                                        <select id="carrera" name='carrera' aria-required='true' class="select2_carrera form-control required" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                            if (!$connection) {
                                                                exit("<label class='error'>Error de conexión</label>");
                                                            }

                                                            $query = mysqli_query($connection, "SELECT * FROM carreras");
                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                            }
                                                            ?>
                                                        </select>           
                                                    </div> 
                                                    <div class="form-group">                                              
                                                        <label>Modalidad</label>
                                                        <select id="modalidad" name='modalidad' aria-required='true' class="select2_modalidad form-control required" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                            if (!$connection) {
                                                                exit("<label class='error'>Error de conexión</label>");
                                                            }

                                                            $query = mysqli_query($connection, "SELECT * FROM modalidades");
                                                            while ($data = mysqli_fetch_assoc($query)) {
                                                                echo "<option value=" . $data["codigo"] . ">" . $data["nombre"] . "</option>";
                                                            }
                                                            ?>
                                                        </select>       
                                                        </select>           
                                                    </div> 
                                                </div>

                                            </div>

                                        </fieldset>
                                        <h1>Estudiantes</h1>
                                        <fieldset>
                                            <h2>Asignar Estudiantes</h2>
                                            <div class="row">

                                                <div class="col-lg-4" id="estudiantes">
                                                    <div id="divEstud1" class="form-group">
                                                        <label for='btnAgregar'>Cédula Estudiante:</label>
                                                        <p id="primerEstudiante"></p>                               
                                                        <input id="idEstudiante1" name="nameEstudiante1" type="text" class="form-control input-sm m-b-xs required" placeholder='Cédula Estudiante'>
                                                        <button name="btnEstudiante1"  class="btn btn-primary btn-rounded" onclick='agregarEstudiantes(this)' type="button" placeholder='agregar'>Agregar Nuevo Estudiante</button>
                                                    </div>
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
                                                                                        echo "<td name='id'>" . $data["id"] . "</td>";
                                                                                        echo "<td name='nombre'>" . $data["nombre"] . "</td>";
                                                                                        echo "<td name='apellido1'>" . $data["apellido1"] . "</td>";
                                                                                        echo "<td name='apellido2'>" . $data["apellido2"] . "</td>";
                                                                                        echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radEstudiante" nombreaux = "' . $data["nombre"] . '" ap1aux = "' . $data["apellido1"] . '" ap2aux = "' . $data["apellido2"] . '"></div></td>';
                                                                                        echo "</tr>";
                                                                                    }
                                                                                    ?>


                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <th>Identificación</th>
                                                                                        <th>Nombre</th>                                                                                 
                                                                                        <th>Acción</th>
                                                                                        <th>Primer Apellido</th>
                                                                                        <th>Segundo Apellido</th>
                                                                                    </tr>
                                                                                </tfoot>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <button name="btnSelectEstu"  class="btn btn-primary btn-rounded" onclick='selectEstudiantes("Estudiante")' type="button" placeholder='agregar'>Asignar Estudiante</button>
                                                                    <a data-toggle="modal" class="btn btn-primary btn-rounded" href="#modal-form">Registrar Estudiante</a>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <!-- fin tabla estudiantes -->


                                                </div>


                                            </div>
                                            <div class="row">

                                            </div>
                                        </fieldset>

                                        <!-- encargado -->

                                        <h1>Encargado de TFG</h1>
                                        <fieldset>
                                            <h2>Asignar Encargado de TFG</h2>
                                            <h3>Encargado: </h3>
                                            <div class="form-group">

                                                <div class="ibox-content">
                                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Identificación</th>
                                                                <th>Nombre</th>
                                                                <th>Primer Apellido</th>
                                                                <th>Segundo Apellido</th>                            
                                                                <th>Seleccionado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

<?php
$query = mysqli_query($connection, "SELECT * FROM tfgencargados where estado =1");


while ($data = mysqli_fetch_assoc($query)) {
    echo "<tr>";
    echo "<td>" . $data["id"] . "</td>";
    echo "<td>" . $data["nombre"] . "</td>";
    echo "<td>" . $data["apellido1"] . "</td>";
    echo "<td>" . $data["apellido2"] . "</td>";
    echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radEncargado" required></div></td>';
    echo "</tr>";
}
?>


                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>


                                        <h1>Director TFG</h1>
                                        <fieldset>
                                            <h2>Agregar Director</h2>
                                            <h3>Director: </h3>
                                            <div class="form-group">

                                                <div class="ibox-content">

                                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Identificación</th>
                                                                <th>Nombre</th>
                                                                <th>Primer Apellido</th>
                                                                <th>Segundo Apellido</th>
                                                                <th>Título</th>
                                                                <th>Especialidad</th>                        
                                                                <th>Seleccionado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

<?php
$query = mysqli_query($connection, "SELECT * FROM tfgdirectores where estado = 1");


while ($data = mysqli_fetch_assoc($query)) {
    echo "<tr>";
    echo "<td>" . $data["id"] . "</td>";
    echo "<td>" . $data["nombre"] . "</td>";
    echo "<td>" . $data["apellido1"] . "</td>";
    echo "<td>" . $data["apellido2"] . "</td>";
    echo "<td>" . $data["titulo"] . "</td>";
    echo "<td>" . $data["especialidad"] . "</td>";
    echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radCoord" required></div></td>';
    echo "</tr>";
}
?>


                                                    </table>
                                                </div>
                                            </div>



                                        </fieldset>

                                        <h1>Asesores del Trabajo</h1>
                                        <fieldset>
                                            <h2>Agregar Asesores</h2>
                                            <h3>Agregar Asesor 1: *</h3>
                                            <div class="form-group">

                                                <div class="ibox-content">

                                                  <table class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Identificación</th>
                                                                <th>Nombre</th>
                                                                <th>Primer Apellido</th>
                                                                <th>Segundo Apellido</th>
                                                                <th>Título</th>
                                                                <th>Especialidad</th>                        
                                                                <th>Seleccionado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
$query = mysqli_query($connection, "SELECT * FROM tfgasesores where estado =1");


while ($data = mysqli_fetch_assoc($query)) {
    echo "<tr>";
    echo "<td>" . $data["id"] . "</td>";
    echo "<td>" . $data["nombre"] . "</td>";
    echo "<td>" . $data["apellido1"] . "</td>";
    echo "<td>" . $data["apellido2"] . "</td>";
    echo "<td>" . $data["titulo"] . "</td>";
    echo "<td>" . $data["especialidad"] . "</td>";
    echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radAsesor1" required></div></td>';
    echo "</tr>";
}
?>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <h3>Agregar Asesor 2: </h3>
                                                <div class="ibox-content">
                                                    <input type="text" class="form-control input-sm m-b-xs" id="filter2" placeholder="Buscar Asesor">
                                                    <div class="i-checks"><br><label for="b">Ninguno: &nbsp;</label><input type="radio" value="ninguno" name="radAsesor2" checked>  </div>
                                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Identificación</th>
                                                                <th>Nombre</th>
                                                                <th>Primer Apellido</th>
                                                                <th>Segundo Apellido</th>
                                                                <th>Título</th>
                                                                <th>Especialidad</th>                        
                                                                <th>Seleccionado</th>
                                                            </tr>
                                                        </thead>
<?php
$query = mysqli_query($connection, "SELECT * FROM tfgasesores where estado = 1");


while ($data = mysqli_fetch_assoc($query)) {
    echo "<tr>";
    echo "<td>" . $data["id"] . "</td>";
    echo "<td>" . $data["nombre"] . "</td>";
    echo "<td>" . $data["apellido1"] . "</td>";
    echo "<td>" . $data["apellido2"] . "</td>";
    echo "<td>" . $data["titulo"] . "</td>";
    echo "<td>" . $data["especialidad"] . "</td>";
    echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radAsesor2" required></div></td>';
    echo "</tr>";
}


mysqli_close($connection);
?>
                                                    </table>
                                                </div>
                                            </div>            

                                        </fieldset>


<?php
	$fecha_actual=date("m/d/Y");
                            
    $nuevafecha = date('m/d/Y', strtotime('+1 month'));
?>

                                        <h1>Fechas de inicio y finalización</h1>
                                        <fieldset>
                                            <h2>Fechas de inicio y finalización</h2>
                                            <div class="row">

                                                <div class="col-lg-6" >
                                                    <div id="divEstud1" class="form-group">
                                                        <label>Fecha de inicio:</label>
                                                        <input required class="form-control required" type="text" name="daterange" value="<?php echo $fecha_actual . " - " . $nuevafecha ?> " />

                                                    </div>
                                                </div>


                                            </div>
											<label>NOTA. Formato de fecha: mes/dia/año</label>
                                        </fieldset>
                                        <div class="spiner-example">
                                            <div class="sk-spinner sk-spinner-three-bounce" id="spinner" style="display:none">
                                                <div class="sk-bounce1"></div>
                                                <div class="sk-bounce2"></div>
                                                <div class="sk-bounce3"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="footer">

                    <div>
                        <strong>Universidad Nacional</strong> 2015-2016
                    </div>
                </div>

            </div>
        </div>



        <!-- Mainly scripts -->
        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

        <script src="js/plugins/dataTables/datatables.min.js"></script>


        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>

        <!-- Steps -->
        <script src="js/plugins/staps/jquery.steps.min.js"></script>

        <!-- Jquery Validate -->
        <script src="js/plugins/validate/jquery.validate.min.js"></script>

        <script src="js/plugins/select2/select2.full.min.js"></script>

        <!-- FooTable -->
        <script src="js/plugins/footable/footable.all.min.js"></script>

        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js"></script>

        <!-- JSKnob -->
        <script src="js/plugins/jsKnob/jquery.knob.js"></script>

        <!-- Input Mask-->
        <script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

        <!-- Data picker -->
        <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

      

        <!-- Switchery -->
        <script src="js/plugins/switchery/switchery.js"></script>

        <!-- IonRangeSlider -->
        <script src="js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>

        <!-- MENU -->
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- Color picker -->
        <script src="js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

        <!-- Clock picker -->
        <script src="js/plugins/clockpicker/clockpicker.js"></script>

        <!-- Image cropper -->
        <script src="js/plugins/cropper/cropper.min.js"></script>

        <!-- Date range use moment.js same as full calendar plugin -->
        <script src="js/plugins/fullcalendar/moment.min.js"></script>

        <!-- Date range picker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js"></script>

        <!-- Select2 -->
        <script src="js/plugins/select2/select2.full.min.js"></script>

        <!-- TouchSpin -->
        <script src="js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

        <script src="js/funciones.js"></script>


        <script>
                                                                        
																		
	
																		$("#form").submit(function () {
                                                                            $("#spinner").show();
                                                                        });

                                                                        bandera = false;
                                                                        $(window).load(function () {
                                                                            $("#spinner").hide();
                                                                            
                                                                            $("#wizard").steps();
                                                                            $("#form").steps({
                                                                                labels: {
                                                                                    current: "Paso actual:",
                                                                                    pagination: "Paginacion",
                                                                                    finish: "Finalizar",
                                                                                    next: "Siguiente",
                                                                                    previous: "Anterior",
                                                                                    loading: "Cargando...",
                                                                                    cancel: "Cancelar"
                                                                                },
                                                                                bodyTag: "fieldset",
                                                                                onStepChanging: function (event, currentIndex, newIndex)
                                                                                {
                                                                                    // Always allow going backward even if the current step contains invalid fields!
                                                                                    if (currentIndex > newIndex)
                                                                                    {
                                                                                        return true;
                                                                                    }


                                                                                    var form = $(this);

                                                                                    // Clean up if user went backward before
                                                                                    if (currentIndex < newIndex)
                                                                                    {
                                                                                        // To remove error styles
                                                                                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                                                                                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                                                                                    }

                                                                                    // Disable validation on fields that are disabled or hidden.
                                                                                    //  form.validate().settings.ignore = ":disabled,:hidden";

                                                                                    // Start validation; Prevent going forward if false
                                                                                    return form.valid();
                                                                                },
                                                                                onStepChanged: function (event, currentIndex, priorIndex)
                                                                                {
                                                                                    // Suppress (skip) "Warning" step if the user is old enough.

                                                                                    if (currentIndex === 5) {
                                                                                        bandera = true;
                                                                                    }



                                                                                },
                                                                                onFinishing: function (event, currentIndex)
                                                                                {
                                                                                    var form = $(this);

                                                                                    // Disable validation on fields that are disabled.
                                                                                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                                                                                    //  form.validate().settings.ignore = ":disabled";

                                                                                    // Start validation; Prevent form submission if false
                                                                                    return form.valid();
                                                                                },
                                                                                onFinished: function (event, currentIndex)
                                                                                {
                                                                                    var form = $(this);

                                                                                    // Submit form input
                                                                                    if (bandera) {
                                                                                        form.submit();
                                                                                    }
                                                                                }
                                                                            }).validate({
                                                                                errorPlacement: function (error, element)
                                                                                {
                                                                                    element.before(error);
                                                                                }
                                                                            });

                                                                            $(".select2_carrera").select2({
                                                                                placeholder: "Seleccione Una Carrera",
                                                                                allowClear: true
                                                                            });

                                                                            $(".select2_investigacion").select2({
                                                                                placeholder: "Seleccione Una Línea de Investigación",
                                                                                allowClear: true
                                                                            });

                                                                            $(".select2_modalidad").select2({
                                                                                placeholder: "Seleccione una Modalidad",
                                                                                allowClear: true
                                                                            });

                                                                            $('.footable').footable();
                                                                            $('.footable2').footable();

                                                                            $('.i-checks').iCheck({
                                                                                checkboxClass: 'icheckbox_square-green',
                                                                                radioClass: 'iradio_square-green',
                                                                            });
                                                                        });
		
        </script>
        <script>
            $(document).ready(function () {
                
                getInputs();
                $('input[name="daterange"]').daterangepicker();

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
                            title: 'Reporte',
                            message: 'Reporte Generado el: ' + getFecha()
                           /* exportOptions: {
                                columns: [0, 1, 2, 3]
                            },*/
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


        <script >


            $(document).ready(function () {

                $("#btnAgregarEstudianteModal").click(function (evento) {
                    evento.preventDefault();
                    var idaux = $("#idRegistroEstudiante").val();
                    var nomaux = $("#nombreRegistroEstudiante").val();
                    var ape1aux = $("#apellido1RegistroEstudiante").val();
                    var ape2aux = $("#apellido2RegistroEstudiante").val();
                    var correoaux = $("#correoRegistroEstudiante").val();
                    table.destroy();
                    $("#tablaEstudiantes").load("tablas/tablaEstudiantes.php", {id: idaux, nombre: nomaux, apellido1: ape1aux, apellido2: ape2aux, correo: correoaux}, function () {


                    });
                });
            });
        </script>
        
        <script>
            $(document).ready(function (){
                
               var saveComment = function(data) {
					
                                        comentario += JSON.stringify(data);
                                        console.log(data);
                                        return data;
				};
                                var comentario; 
				$('#comments-container').comments({
					profilePictureURL: 'https://viima-app.s3.amazonaws.com/media/user_profiles/user-icon.png',
					currentUserId: 1,
					roundProfilePictures: true,
					textareaRows: 1,
					enableAttachments: false,
					enableHashtags: false,
					enablePinging: false,
                                        enableEditing: false,
                                        enableUpvoting: false,
                                        enableDeleting: false,
                                        enableDeletingCommentWithReplies: false,
					getComments: function(success, error) {
                                           // var tfg = " echo $codigo ?>";
                                            var commentsArray = 
                                            $.ajax({
                                                type: 'get',
                                                url: 'funcionalidad/ComentarioObtener.php',
                                                //dataType: 'json',
                                                data:  {tfg: 'TFG-5-2016-003-1-01'},
                                                success: function(response) {
                                                  
                                                 var content = JSON.parse(response);
                                                  
						    //alert('successful');
                                                    console.log(content);
                                                    
                                      
                                                     
                                                }
						,
                                                error: error
                                        });
                                              //success(commentsArray);
					},
                                        postComment: function(data,success,error) {
                                           $.ajax({
                                                type: 'post',
                                                url: 'ComentarioGuardar.php',
                                                //dataType: 'json',
                                                data:  {json: data,},
                                                success: function(response) {
                                                  
                                                    console.log(response);
                                                    success(saveComment(data));
                                                },
                                                error: error
                                        });
                                    }
                                }); 
            });
        </script>


        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Estudiante</h3>

                                <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input required type="text" placeholder="Identificacion" class="form-control" id="idRegistroEstudiante"></div>
                                <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input required type="text" placeholder="Nombre" class="form-control" id="nombreRegistroEstudiante"></div>
                                <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input required type="text" placeholder="Primer Apellido" class="form-control" id="apellido1RegistroEstudiante"></div>
                                <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input required type="text" placeholder="Segundo Apellido" class="form-control" id="apellido2RegistroEstudiante"></div>
                                <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input required type="email" placeholder="Correo" class="form-control" id="correoRegistroEstudiante"></div>

                                <div>
                                    <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button" id="btnAgregarEstudianteModal" data-dismiss="modal"><strong>Registrar</strong></button>
                                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>

</html>
