<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración de Directores</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <?php
        require 'navegacion/nav-lateral.php';
        if(!$usuarioPermisos->getEncargadotfg() && !$usuarioPermisos->getCoordinadorinvestigacion()){?>
        <meta http-equiv="Refresh" content="0;url=index.php">
        <?php exit();}?>
        
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Administración de Directores de TFG</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta de Directores de TFG</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Director de TFG</a>
                            </li>

                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Registrar Director de TFG</a>
					<br/>
					<br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Directores de TFG</h5>

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
                                                    <th>Identificación</th>
                                                    <th>Primer Apellido</th>
                                                    <th>Segundo Apellido</th>
                                                    <th>Nombre</th>
                                                    <th>Teléfono</th>
                                                    <th>Título</th>
                                                    <th>Especialidad</th> 
                                                    <th>Correo</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM tfgdirectores");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["id"] . "</td>";
                                                    echo "<td>" . $data["apellido1"] . "</td>";
                                                    echo "<td>" . $data["apellido2"] . "</td>";
                                                    echo "<td>" . $data["nombre"] . "</td>";
                                                     echo "<td>" . $data["telefono"] . "</td>";
                                                    echo "<td>" . $data["titulo"] . "</td>";
                                                    echo "<td>" . $data["especialidad"] . "</td>";
                                                    echo "<td>" . $data["correo"] . "</td>";
                                                     if($data["estado"] == '1'){
                                                        echo "<td>Activo</td>";
                                                    }
                                                    else{
                                                        echo "<td>Inactivo</td>";
                                                    }
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                data-target='#mod-form' id = '" . $data["id"] . "' nombre = '" . $data["nombre"] . "' apellido1 = '" . $data["apellido1"] . "' titulo = '" . $data["titulo"].
                                                     "' especialidad = '" . $data["especialidad"]."' apellido2 = '" . $data["apellido2"] ."'activo = '" . $data["estado"]. "'telefono = '" . $data["telefono"]. "' correo = '" . $data["correo"] . "' > Modificar</button></td> ";
                                                    echo "</tr>";
                                                }

                                                mysqli_close($connection);
                                                ?>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Identificación</th>
                                                    <th>Primer Apellido</th>
                                                    <th>Segundo Apellido</th>
                                                    <th>Nombre</th>
                                                    <th>Teléfono</th>
                                                    <th>Título</th>
                                                    <th>Especialidad</th>
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

        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
        <script src="js/cleanString.js"></script>
        <script src="js/plugins/dataTables/datatables.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- Page-Level Scripts -->
        <script>
            $(document).ready(function () {
                
                 getInputs();//metodo para obtener los inputs y sus expresiones regulares 
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
                };

                $('.dataTables-example').DataTable({
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy', 
                            exportOptions: {
                               columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            },
                        },
                        {extend: 'csv',
                            title: 'Reporte de Directores '+ getFecha(),
                            exportOptions: {
                               columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            },
                        },
                        {extend: 'excel', title: 'Reporte de Directores '+ getFecha() ,
                            title: 'Reporte de Directores',
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                               columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            },
                        },
                        {extend: 'pdf',
                            title: 'Reporte de Directores '+ getFecha() ,
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            },
                        },
                        {extend: 'print',
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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

                /* Init DataTables */
                var oTable = $('#editable').DataTable();

                /* Apply the jEditable handlers to the table */
                oTable.$('td').editable('../example_ajax.php', {
                    "callback": function (sValue, y) {
                        var aPos = oTable.fnGetPosition(this);
                        oTable.fnUpdate(sValue, aPos[0], aPos[1]);
                    },
                    "submitdata": function (value, settings) {
                        return {
                            "row_id": this.parentNode.getAttribute('id'),
                            "column": oTable.fnGetPosition(this)[2]
                        };
                    },
                    "width": "90%",
                    "height": "100%"
                });


            });

            function fnClickAddRow() {
                $('#editable').dataTable().fnAddData([
                    "Custom row",
                    "New row",
                    "New row",
                    "New row",
                    "New row"]);

            }
        </script>
        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Director de TFG</h3>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/TFGagregar.php">
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input required type="text" placeholder="Identificacion" class="form-control" name="id"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input required type="text" placeholder="Nombre" class="form-control" name="nombre"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input required type="text" placeholder="Primer Apellido" class="form-control" name="apellido1"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input required type="text" placeholder="Segundo Apellido" class="form-control" name="apellido2"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Teléfono</label></i> <input required type="text" placeholder="Teléfono" class="form-control" name="telefono" id="telefono"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Título</label></i> <input required type="text" placeholder="Titulo" class="form-control" name="titulo"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Especialidad</label></i> <input required type="text" placeholder="Especialidad" class="form-control" name="especialidad"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input required type="email" placeholder="Correo" class="form-control" name="correo"></div>

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="TFGagregarDirector" ><strong>Registrar</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Director</h3>
                                 <h4 id="tituloEstado" style='color: red'>Usuario inactivo</h4>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/TFGModificar.php">
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input name="id" id="id" required type="text" placeholder="Identificacion" class="form-control" readonly></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input name="apellido1" id="apellido1" required type="text" placeholder="Primer Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input name="apellido2" id="apellido2" required type="text" placeholder="Segundo Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Teléfono</label></i> <input required type="text" placeholder="Teléfono" class="form-control" name="telefono" id="telefono"></div>          
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Título</label></i> <input name="titulo" id="titulo" required type="text" placeholder="Titulo" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Especialidad</label></i> <input name="especialidad" id="especialidad" required type="text" placeholder="Especialidad" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input name="correo" id="correo" required type="email" placeholder="Correo" class="form-control"></div>

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> <br>
                                        <button class="btn btn-sm btn-danger pull-left m-t-n-xs" type="button" id="desactivar" name="desactivarDirector"><i class="fa fa-warning"></i><strong> Desactivar</strong></button>
                                        <button class="btn btn-sm btn-info pull-left m-t-n-xs" type="button" id="activar" name="activarDirector"><i class="fa fa-check-circle"></i><strong> Activar</strong></button>
                                        <input name="estado" id="estado" type="text" hidden>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="TFGModificarDirector"><strong>Guardar Cambios</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#mod-form').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var recipient = button.attr('id');
                
                t = modal.find('#tituloEstado');
                
                btn1 = modal.find('#desactivar');
                btn2 = modal.find('#activar');
                estado = modal.find('#estado');
                
                modal.find('#id').val(recipient);
              
                recipient = button.attr('nombre');
                modal.find('#nombre').val(recipient);

                recipient = button.attr('apellido1');
                modal.find('#apellido1').val(recipient);

                recipient = button.attr('apellido2');
                modal.find('#apellido2').val(recipient);
                
                recipient = button.attr('telefono');
                modal.find('#telefono').val(recipient);


                recipient = button.attr('titulo');
                modal.find('#titulo').val(recipient);

                recipient = button.attr('especialidad');
                modal.find('#especialidad').val(recipient);

                recipient = button.attr('correo');
                modal.find('#correo').val(recipient);
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
        </script>

    </body>

</html>