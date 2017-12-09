<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración de Carreras</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <?php
        require 'navegacion/nav-lateral.php';
        if(!$usuarioPermisos->getEncargadotfg() && !$usuarioPermisos->getCoordinadorinvestigacion()){;?>
        <meta http-equiv="Refresh" content="0;url=index.php">
        <?php exit();}?>
    </head>

    <body class="">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <?php require 'navegacion/nav-superior.php'; 
                
                
                ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Administración de Carreras</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta de Carreras</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Carrera</a>
                            </li>

                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
				
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Registrar Carrera</a>
					<br/>
					<br/>
                    <div class="row ">
                        <div class="col-lg-12 col-xs-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Carreras</h5>
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
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Acción</th>
													<th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM carreras");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["codigo"] . "</td>";
                                                    echo "<td>" . $data["nombre"] . "</td>";
                                                    echo "<td align='center'>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                data-target='#mod-form' id = '" . $data["codigo"] . "' nombre = '" . $data["nombre"] . "' > Modificar</button></td> ";
                                                    echo "<td align='center'>" . "<button type='button' class='btn btn-danger' id = '" . $data["codigo"] . "' nombre = '" . $data["nombre"] . "' data-toggle='modal' data-target='#mod-eliminar'>
                                                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>";
                                                    echo "</tr>";
                                                }

                                                mysqli_close($connection);
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Acción</th>
													<th></th>
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

        <script src="js/plugins/dataTables/datatables.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- Page-Level Scripts -->
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
                    return $dia + "-" + meses[$mes] + '-' + $anno + ' ' + $hora + ':' + $minutos + ':' + $segundos;
                }
                ;

                $('.dataTables-example').DataTable({
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy'},
                        {extend: 'csv',
                            title: 'Reporte Carreras'+ getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                        },
                        {extend: 'excel', title: 'Reporte Carreras'+ getFecha() ,
                            title: 'Reporte Carreras',
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                        },
                        {extend: 'pdf',
                            title: 'Reporte Carreras',
                            message: 'Reporte Generado el: ' + getFecha(),
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                        },
                        {extend: 'print',
                            
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
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
                    "New row"
                ]);
            }
        </script>
        <div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Carrera</h3>
                                <form role="form" id="frm_agregar_extension" method="POST" action="funcionalidad/INVAgregar.php">
                                    <i class="fa fa-exclamation-circle"> <label>Codigo</label> </i> <input name="id" id="id" required type="text" placeholder="Codigo" class="form-control"></div>   
                                    <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>                                    

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="INVAgregarCarrera"><strong>Registrar</strong></button>
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Carrera</h3>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/INVModificar.php">
                                    <div class="form-group"> 
                                        <i class="fa fa-exclamation-circle"> <label>Codigo</label> </i> <input name="id" id="id" required type="text" placeholder="Codigo" class="form-control" readonly></div>   
                                    <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>                                    

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="INVModificarCarrera"><strong>Guardar Cambios</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--//modal eliminar--> 
            <div id="mod-eliminar" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class=""><h3 class="m-t-none m-b">¿Seguro que desea eliminar esta carrera?</h3>
                                    <form role="form" id="frm_eliminar_carrera" method="POST" action="funcionalidad/eliminarFuncionalidad.php">
                                        <input name="id" id="id" required type="hidden"  class="form-control">   
                                        <input name="nombreCarrera" id="nombreCarrera" required type="hidden"  class="form-control">                                 
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-primary" id="submitbtn" type="submit" name="eliminarCarrera"><strong>Sí</strong></button>
                                            <button type="submit" data-dismiss="modal" id="closebtn" class="btn btn-sm btn-secundary" style="margin-left: 20px;" ><strong>Cancelar</strong></button>

                                            <h4 id="result" style="padding-top: 15px;"></h4>

                                            <button class="btn btn-sm btn-primary" id="cerrar" type="submit" name="cerrar" data-dismiss="modal">Cerrar</button>

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
                    modal.find('#id').val(recipient);
                    var recipient = button.attr('nombre');
                    modal.find('#nombre').val(recipient);
                });
                $('#mod-eliminar').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                    var id = button.attr('id');
                    modal.find('#id').val(id);
                    var nombre = button.attr('nombre');
                    modal.find('#nombreCarrera').val(nombre);
                    var b = modal.find('#cerrar');
                    b.hide();
                    var er = $("#result");
                    er = er.hide();
                    showBtns();
                });


                $("button#submitbtn").click(function (e) {
                    e.preventDefault();
                    var b1 = $("#submitbtn");
                    var c1 = $("#cerrar");
                    var b2 = $("#closebtn");
                    var er = $("#result");

                    er = er.hide();
                    $.ajax({
                        url: "funcionalidad/eliminarFuncionalidad.php",
                        method: "POST",
                        data: $("#frm_eliminar_carrera").serialize(),
                        success: function (response) {

                            if (response === 'error') {
                                er = er.text("No se puede eliminar esta carrera.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();

                            } else if (response === 'success') {
                                er = er.text("Carrera eliminada.").css('color', 'green');
                                b1.hide();
                                b2.hide();
                                c1.show();
                                reloadPage();

                            } else if (response === 'db_error') {
                                er = er.text("Error en la conexión. Comuníquese con el encargado.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();
                            }
                            er.fadeIn(1000);
                            
                        }
                    });
                });
                function reloadPage() {
                    $("#cerrar").click(function (e) {
                        window.location.reload();
                    });
                }
                function showBtns() {
                    var b1 = $("#submitbtn");
                    b1.show();
                    var b2 = $("#closebtn");
                    b2.show();

                }
            </script>


    </body>

</html>