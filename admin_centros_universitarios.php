<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración Centros Universitarios</title>

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
                <?php require 'navegacion/nav-superior.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Administración Centros universitarios</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta Centros universitarios</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Centro Universitario</a>
                            </li>

                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
				
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Registrar Centro Universitario</a>
                                        <a style="float: right;" data-toggle="modal" class="btn btn-primary" href="#mod-getCentros">Importar Centros Universitarios</a>
					<br/>
					<br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Centro universitario</h5>
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
                                                    <th>CU Código</th>
                                                    <th>Nombre</th>
                                                    <th>Acción</th>
                                                    <th>Eliminar</th>
					
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                
                                            <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM centrosuniversitarios");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["codigo"] . "</td>";
                                                    echo "<td>" . $data["nombre"] . "</td>";
                                                    echo "<td style='text-align: center;' >" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                       data-target='#mod-form' codigo = '" . $data["codigo"] . "' nombre = '" . $data["nombre"] . "' > Modificar</button></td> ";                                 
                                                    echo "<td align='center'>" . "<button type='button' class='btn btn-danger' id = '" . $data["codigo"] . "' nombre = '" . $data["nombre"] . "' data-toggle='modal' data-target='#mod-eliminar'>
                                                        <span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>";
                                                    echo "</tr>";
                                                }

                                                mysqli_close($connection);
                                                ?>    
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>CU Código</th>
                                                    <th>Nombre</th>
                                                    <th>Acción</th>
                                                    <th>Eliminar</th>
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
                
                $('.dataTables-example').DataTable({
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy',
                            exportOptions: {
                                columns: [0, 1]
                            }
                        },
                        {extend: 'csv',
                            exportOptions: {
                                columns: [0, 1]
                            }
                       },
                        {extend: 'excel', title: 'Asignaturas',
                            exportOptions: {
                                columns: [0, 1]
                            }
                       },
                        {extend: 'pdf', title: 'Asignaturas',
                            exportOptions: {
                                columns: [0, 1]
                            }
                       },
                        {extend: 'print',
                            customize: function (win) {
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');

                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                            },
                            exportOptions: {
                                columns: [0, 1]
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Centro Universitario</h3>
                                <form role="form" id="frm_agregar_cu"  method="POST" action="funcionalidad/agr_mod_cu.php">
                                    
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Código</label></i> <input required type="text" placeholder="Código" class="form-control" name="codigo"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre Centro Universitario</label></i> <input required type="text" placeholder="Nombre" class="form-control" name="nombre"></div>

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="agregarCU"><strong>Registrar</strong></button>
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Centro Universitario</h3>
                                <form role="form" id="frm_agregar_cu" method="POST" action="funcionalidad/agr_mod_cu.php">
                                  
                                    <div class="form-group"> <label>Código</label>
                                    <input required type="text" placeholder="Código" class="form-control" id="codigo" name="codigo" readonly></div>
                                    <div class="form-group"> 
                                        <label>Nombre</label> 
                                        <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>                                    
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="modificarCU"><strong>Guardar Cambios</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--//modal eliminar--> 
          <div id="mod-getCentros" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class=""><h3 class="m-t-none m-b">¿Seguro que desea importar los centros universitarios?</h3>
                                    <form role="form" id="frm_getCentros" name='frm_getCentros' method="POST" action="funcionalidad/getCentrosUniversitarios.php">
                                        <div class="text-center">
                                            <input type="text" value="" hidden name="frm_getCentros"/>
                                            <button class="btn btn-sm btn-primary" id="submitbtn" type="submit" ><strong>Sí</strong></button>
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
        
            <div id="mod-eliminar" class="modal fade" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class=""><h3 class="m-t-none m-b">¿Seguro que desea eliminar este centro universitario?</h3>
                                    <form role="form" id="frm_eliminar_centro" name='frm_getCentros' method="POST" action="funcionalidad/getCentrosUniversitarios.php">
                                        <div class="text-center">
                                            <input name="id" id="id" required type="hidden"  class="form-control">   
                                            <input name="nombreCentro" id="nombreCentro" required type="hidden"  class="form-control"> 
                                            <input type="text" value="" hidden name="frm_eliminar_centro"/>
                                            <button class="btn btn-sm btn-primary" id="submitbtnEli" type="submit" ><strong>Sí</strong></button>
                                            <button type="submit" data-dismiss="modal" id="closebtnEli" class="btn btn-sm btn-secundary" style="margin-left: 20px;" ><strong>Cancelar</strong></button>

                                            <h4 id="resultEli" style="padding-top: 15px;"></h4>
                                            <button class="btn btn-sm btn-primary" id="cerrarEli" type="submit" name="cerrar" data-dismiss="modal">Cerrar</button>

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
                var recipient = button.attr('codigo');
                modal.find('#codigo').val(recipient);
                var recipient = button.attr('nombre');
                modal.find('#nombre').val(recipient);
            });
            $('#mod-getCentros').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                    var b = modal.find('#cerrar');
                    b.hide();
                    var er = $("#result");
                    er = er.hide();
                    showBtns();
                });
                
            $('#mod-eliminar').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                    var id = button.attr('id');
                    modal.find('#id').val(id);
                    var nombre = button.attr('nombre');
                    modal.find('#nombreCentro').val(nombre);
                    var b = modal.find('#cerrarEli');
                    b.hide();
                    var er = $("#resultEli");
                    er = er.hide();
                    showBtnsEli();
                });

                $("button#submitbtn").click(function (e) {
                    e.preventDefault();
                    var b1 = $("#submitbtn");
                    var c1 = $("#cerrar");
                    var b2 = $("#closebtn");
                    var er = $("#result");

                    er = er.hide();
                    $.ajax({
                        url: "funcionalidad/getCentrosUniversitarios.php",
                        method: "POST",
                        data: $("#frm_getCentros").serialize(),
                        success: function (response) {
                            
                            if (response === 'error') {
                                er = er.text("No se agregó ningún centro universitario.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();

                            } else if (response ==='db_error') {
                                er = er.text("Error en la conexión. Comuníquese con el encargado.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();

                            } else{
                                er = er.text("Se agregaron "+response+" centros universitarios").css('color', 'green');
                                b1.hide();
                                b2.hide();
                                c1.show();
                                reloadPage();
                            }
                            er.fadeIn(1000);

                        }
                    });
                });
                
                $("button#submitbtnEli").click(function (e) {
                    e.preventDefault();
                    var b1 = $("#submitbtnEli");
                    var c1 = $("#cerrarEli");
                    var b2 = $("#closebtnEli");
                    var er = $("#resultEli");

                    er = er.hide();
                    $.ajax({
                        url: "funcionalidad/eliminarFuncionalidad.php",
                        method: "POST",
                        data: $("#frm_eliminar_centro").serialize(),
                        success: function (response) {
                            
                            console.log(response);
                            if (response === 'error') {
                                er = er.text("No se puede eliminar este centro universitario.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();

                            } else if (response === 'success') {
                                er = er.text("Centro universitario eliminado.").css('color', 'green');
                                b1.hide();
                                b2.hide();
                                c1.show();
                                reloadPageEli();

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
                function reloadPageEli() {
                    $("#cerrarEli").click(function (e) {
                        window.location.reload();
                    });
                }
                function showBtns() {
                    var b1 = $("#submitbtn");
                    b1.show();
                    var b2 = $("#closebtn");
                    b2.show();
                }
                
                function showBtnsEli() {
                    var b1 = $("#submitbtnEli");
                    b1.show();
                    var b2 = $("#closebtnEli");
                    b2.show();
                }
            
        </script>

    </body>

</html>