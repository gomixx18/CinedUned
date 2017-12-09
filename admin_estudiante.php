<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración de Estudiantes</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

        <link href="css/plugins/chosen/chosen.min.css" rel="stylesheet"/>
       
        
        <?php
        require 'navegacion/nav-lateral.php';
        if(!$usuarioPermisos->getEncargadotfg() && !$usuarioPermisos->getCoordinadorinvestigacion()){;?>
        <meta http-equiv="Refresh" content="0;url=index.php">
        <?php exit();}?>
        
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php' ?>

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Administración de Estudiantes</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta de Estudiantes</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Estudiante</a>
                            </li>

                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
				
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Registrar Estudiante</a>
                                        <a data-toggle="modal" style="float: right;" class="btn btn-primary" href="#modal-imp">Importar Estudiantes</a>
					<br/>
					<br/>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Estudiantes</h5>

                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>


                                                <tr>
                                                    <th name="cu">CU</th>
                                                    <th name="id">Identificación</th>
                                                    <th name="apellido2">Apellido1</th>
                                                    <th name="apellido1">Apellido2</th>
                                                    <th name="nombre">Nombre</th>
                                                    <th name="codigo">Codigo</th>
                                                    <th name="correo">Correo</th>
                                                    <th name='estado'>Estado</th>
                                                    <th name="accion">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM tfgestudiantes");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    
                                                    echo "<td name='cu'>" . $data["cu"] . "</td>";
                                                    echo "<td name='id'>" . $data["id"] . "</td>";
                                                    echo "<td name='apellido1'>" . $data["apellido1"] . "</td>";
                                                    echo "<td name='apellido2'>" . $data["apellido2"] . "</td>";
                                                    echo "<td name='nombre'>" . $data["nombre"] . "</td>";
                                                    echo "<td name='codigo'>" . $data["codigo"] . "</td>";
                                                    echo "<td name= 'correo'>" . $data["correo"] . "</td>";
                                                    if ($data["estado"] == '1') {
                                                        echo "<td>Activo</td>";
                                                    } else {
                                                        echo "<td>Inactivo</td>";
                                                    }
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                data-target='#mod-form' id = '" . $data["id"] . "' nombre = '" . $data["nombre"] . "' apellido1 = '" . $data["apellido1"] .
                                                    "' apellido2 = '" . $data["apellido2"] . "'activo = '" . $data["estado"] . "' correo = '" . $data["correo"] . 
                                                            "' cu = '" . $data["cu"]."' asignatura = '" . $data["codigo"]. "' telefono = '" . $data["telefono"]  ."' > Modificar</button></td> ";
                                                    echo "</tr>";
                                                }

                                               // mysqli_close($connection);
                                                ?>


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>CU</th>
                                                    <th>Identificación</th>
                                                    <th>Apellido1</th>
                                                    <th>Apellido2</th>
                                                    <th>Nombre</th>
                                                    <th>Codigo</th>
                                                    <th>Correo</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

    

                </div>

                <div class="footer">
                    Universidad Nacional  &copy; 2015-2016
                </div>

            </div>
        </div>

        <script src="js/cleanString.js"></script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
        <script src="js/plugins/dataTables/datatables.min.js"></script>
        <script src="js/cambiarEstadoUsuario.js" type="text/javascript"></script>
        <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <script src="js/plugins/iCheck/icheck.min.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <script src="js/plugins/chosen/chosen.jquery.js"></script>
        <!-- Page-Level Scripts -->
        <script>
            
    $(window).load(function(){  
     
            
    $(".chosen-select").chosen({no_results_text: "No se encontró",allow_select_all:"Select All",width:'100%', allow_deselect_all:true});
         
    $('#btnTodo').click(function(){
        $('option').prop('selected', true);
        $('select').trigger('chosen:updated');
    });
$('#btnNada').click(function(){
    $('option').prop('selected', false);
    $('select').trigger('chosen:updated');
}); 
    });
    $(document).ready(function () {
                
         $('#btnAll').click(function(){
            $('#selectAsignaturas').prop('selected', true); // Selects all options
        });
            getInputs();
    
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

                function getFecha() {

                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $fecha = new Date();
                    $dia = $fecha.getDate();
                    $mes = $fecha.getMonth();
                    $anno = $fecha.getFullYear();
                    $hora = $fecha.getHours();
                    $minutos = $fecha.getMinutes();
                    $segundos = $fecha.getSeconds();
                    return $dia + " " + meses[$mes] + ' ' + $anno + ' ' + $hora + ':' + $minutos + ':' + $segundos;
                }
                ;

                $('.dataTables-example').DataTable({
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {extend: 'csv',
                            title: 'Estudiantes Reporte '+ getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {extend: 'excel', 
                            title: 'Reporte de Estudiantes '+ getFecha() ,
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {extend: 'pdf',
                            title: 'Reporte de Estudiantes '+ getFecha(), 
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {extend: 'print',
                            message: 'Reporte generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            customize: function (win) {
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');

                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                            }
                        }

                    ]
                });
            });

        </script>
        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Estudiante</h3>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/TFGagregar.php">
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input required type="text" placeholder="Identificacion" class="form-control" name="id"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input required type="text" placeholder="Nombre" class="form-control" name="nombre"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input required type="text" placeholder="Primer Apellido" class="form-control" name="apellido1"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input required type="text" placeholder="Segundo Apellido" class="form-control" name="apellido2"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Teléfono</label></i> <input required type="text" placeholder="Telefono" class="form-control" name="telefono"></div>
                                   
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input required type="email" placeholder="Correo" class="form-control" name="correo"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Centro Universitario</label></i>
                                    <select id="cu" name='cu' required aria-required='true' class="select2_carrera form-control required" tabindex="-1">
                                        <option></option>
                                        <?php
                                            if (!$connection) {
                                             exit("<label class='error'>Error de conexión</label>");
                                            }

                                            $query = mysqli_query($connection, "SELECT * FROM centrosuniversitarios");
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                echo "<option value=" . $data["codigo"] . ">" .$data['codigo'] ." ". $data["nombre"] . "</option>";
                                            }
                                            ?>
                                            </select>  
                                    
                                    </div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Asignatura</label></i> 
                                    <select id="asignatura" name='asignatura' required aria-required='true' class="select2_carrera form-control required" tabindex="-1">
                                        <option></option>
                                        <?php
                                            if (!$connection) {
                                             exit("<label class='error'>Error de conexión</label>");
                                            }

                                            $query = mysqli_query($connection, "SELECT * FROM asignaturas");
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                echo "<option value=" . $data["codigo"] . ">" .$data['codigo'] ." ". $data["nombre"] . "</option>";
                                            }
                                            ?>
                                            </select> 
                                    </div>
                                    


                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="TFGagregarEstudiante"><strong>Registrar</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modal-imp" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Importar Estudiantes</h3>
                                <form role="form" id="frm_importar" method="POST" action="funcionalidad/importarEstudiantes.php">
                                    <div class="form-group"> 
                                        <i class="fa fa-exclamation-circle"> <label>Seleccione las Asignaturas para importar los estudiantes:</label></i>
                                        <div class="row">
                                        <div class="col-md-11 col-lg-offset-0"><br>
                                            <select id="selectAsignatura" name="asignaturas[]" required data-placeholder="Asignaturas a importar" class="required chosen-select" multiple style="width:350px;">
                                              
                                            <?php 
                                                if (!$connection) {
                                                   exit("<label class='error'>Error de conexión</label>");
                                                }else{
                                                    $query = mysqli_query($connection, "SELECT * FROM asignaturas");
                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                        echo "<option value='".$data["codigo"]."'>".$data["nombre"]." (" .$data["codigo"].")</option>";
                                                    }
                                                    
                                                }
                                            ?>
                                           </select>
                                        </div>
                                    <div class="col-md-12"><br>
                                        <button class="btn btn-sm btn-primary pull-left m-t-n-xs" type="button" id="btnTodo"><strong>Seleccionar todo</strong></button>
                                        <button class="btn btn-sm btn-warning pull-left m-t-n-xs" type="button" id="btnNada" style="margin-left: 10px;"><strong>Deseleccionar todo</strong></button>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="TFGagregarEstudiante" id="submitbtn"><strong>Importar</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>
                                    </div>
                                        </div>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
        <div id="mod-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Estudiante</h3>
                                <h4 id="tituloEstado" style='color: red'>Usuario inactivo</h4>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/TFGModificar.php">
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input name="id" id="id" required type="text" placeholder="Identificacion" class="form-control" readonly></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input name="apellido1" id="apellido1" required type="text" placeholder="Primer Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input name="apellido2" id="apellido2" required type="text" placeholder="Segundo Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input name="correo" id="correo" required type="email" placeholder="Correo" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Teléfono</label></i> <input name="telefono" id="telefono" required type="text" placeholder="telefono" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Centro universitario</label></i>
                                    <select id="cu" name='cu' required aria-required='true' class="select2_carrera form-control required" tabindex="-1">
                                        <option></option>
                                        <?php
                                            if (!$connection) {
                                             exit("<label class='error'>Error de conexión</label>");
                                            }

                                            $query = mysqli_query($connection, "SELECT * FROM centrosuniversitarios");
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                echo "<option value=" . $data["codigo"] . ">" .$data['codigo'] ." ". $data["nombre"] . "</option>";
                                            }
                                            ?>
                                            </select>  
                                    
                                    </div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Asignatura</label></i> 
                                    <select id="asignatura" name='asignatura' required aria-required='true' class="select2_carrera form-control required" tabindex="-1">
                                        <option></option>
                                        <?php
                                            if (!$connection) {
                                             exit("<label class='error'>Error de conexión</label>");
                                            }

                                            $query = mysqli_query($connection, "SELECT * FROM asignaturas");
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                echo "<option value=" . $data["codigo"] . ">" .$data['codigo'] ." ". $data["nombre"] . "</option>";
                                            }
                                            ?>
                                            </select> 
                                    </div>
                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> <br>
                                        <button class="btn btn-sm btn-danger pull-left m-t-n-xs" type="button" cod="" id="desactivar" name="desactivarEstudiante"><i class="fa fa-warning"></i><strong> Desactivar</strong></button>
                                        <button class="btn btn-sm btn-info pull-left m-t-n-xs" type="button" cod="" id="activar" name="activarEstudiante"  ><i class="fa fa-check-circle"></i><strong> Activar</strong></button>
                                        <input name="estado" id="estado" type="text" hidden>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="TFGModificarEstudiante"><strong>Guardar Cambios</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
               <div id="modal-res" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class=""><h3 class="m-t-none m-b">Se Registraron nuevos estudiantes</h3>
                                        <div class="text-center">
                                            <a id="url_archivo" href="../logs/funcionalidad/archivo.php?id="><h3>Click Aquí para descargar el registro</h3></a>
                                            <h4 id="result" style="padding-top: 15px;"></h4>
                                            <h4 id="resultados"></h4>
                                            <button class="btn btn-sm btn-primary" id="cerrar-res" type="button" name="cerrar" data-dismiss="modal">Cerrar</button>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        <script>
            //guardarEstadoUsuario("desactivar");
            //guardarEstadoUsuario("activar");
      

            $('#mod-form').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                btn1 = modal.find('#desactivar');
                btn2 = modal.find('#activar');
                estado = modal.find('#estado');
                t = modal.find('#tituloEstado');

                var recipient = button.attr('id');
                modal.find('#id').val(recipient);

                recipient = button.attr('nombre');
                modal.find('#nombre').val(recipient);

                recipient = button.attr('apellido1');
                modal.find('#apellido1').val(recipient);

                recipient = button.attr('apellido2');
                modal.find('#apellido2').val(recipient);

                recipient = button.attr('correo');
                modal.find('#correo').val(recipient);
                
                recipient = button.attr('telefono');
                modal.find('#telefono').val(recipient);
                
                recipient = button.attr('cu');
                modal.find('#cu').val(recipient);
                
                recipient = button.attr('asignatura');
                modal.find('#asignatura').val(recipient);

                recipient = button.attr('activo');

                if (recipient === '1') {
                    t.hide();
                    btn1.show();
                    btn2.hide();
                    estado.val('1');
                } else {
                    t.show();
                    btn1.hide();
                    btn2.show();
                    estado.val('0');
                }
                btn1.click(function (evento) {
                    t.show();
                    btn1.hide();
                    btn2.show();
                    estado.val('0');
                });
                btn2.click(function (evento) {
                    t.hide();
                    btn1.show();
                    btn2.hide();
                    estado.val('1');
                });

            });
            
             $('#mod-res').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                   
                });
            
            $("button#submitbtn").click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "funcionalidad/importarEstudiantes.php",
                        method: "POST",
                        data: $("#frm_importar").serialize(),
                        dataType: 'json',
                        success: function (response) {
                            
                            var resultados = $('#resultados');
                            
                            resultados.text("Nuevos agregados: "+response.agregados+" Actualizados: "+response.update+" Errores: "+response.error);
                            $('#modal-imp').modal('hide');
                            $('#url_archivo').attr('href',"funcionalidad/archivo.php?id="+response.nombre_archivo);
                            $('#modal-res').modal('show');
                            
                            
                            
                           

                        }
                    });
                });


        </script>

    </body>

</html>