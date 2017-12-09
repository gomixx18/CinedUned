<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Administración de Asignaturas</title>

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
                        <h2>Administración de Asignaturas</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta de Asignaturas</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Asignaturas</a>
                            </li>

                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
				
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Registrar Asignatura</a>
					<br/>
					<br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Asignaturas</h5>
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

                                                $query = mysqli_query($connection, "SELECT * FROM asignaturas");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["codigo"] . "</td>";
                                                    echo "<td>" . $data["nombre"] . "</td>";
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
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
        <script src="js/cleanString.js" type="text/javascript"></script>
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Asignatura</h3>
                                <form role="form" id="frm_agregar_asignatura"  method="POST" action="funcionalidad/agr_mod_asig.php">
                                    
                                    <div class="form-group"> 
                                        <i class="fa fa-exclamation-circle" > <label>Código</label></i> 
                                        <input maxlength="5" id="codigoAsig" required type="text" placeholder="Código" class="form-control" name="codigo"><br>
                                        <input type="button" id="btnImpAsig" value="Importar nombre de asignatura" class="btn-primary btn" onclick="importarAsignatura()">
                                        <label id="error" class="label label-danger"></label>
                                    </div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label></i> <input id="nombreAsig" maxlength="100" required type="text" placeholder="Nombre" class="form-control" name="nombre"></div>

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="agregarAsignatura"><strong>Registrar</strong></button>
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Modalidad</h3>
                                <form role="form" id="frm_agregar_modalidad" method="POST" action="funcionalidad/agr_mod_asig.php">
                                  
                                    <div class="form-group"> <label>Código</label>
                                    <input required type="text" placeholder="Código" class="form-control" id="codigo" name="codigo" readonly></div>
                                    <div class="form-group"> 
                                        <label>Nombre</label> 
                                        <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>                                    
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="modificarAsginatura"><strong>Guardar Cambios</strong></button>
                                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secundary pull-right m-t-n-xs" style="margin-right: 20px;" ><strong>Cancelar</strong></button>


                                </form>
                            </div>
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
                                <div class=""><h3 class="m-t-none m-b">¿Seguro que desea eliminar esta asignatura?</h3>
                                    <form role="form" id="frm_eliminar_asignatura" method="POST" action="funcionalidad/eliminarFuncionalidad.php">
                                        <input name="id" id="id" required type="hidden"  class="form-control">   
                                        <input name="nombreAsignatura" id="nombre" required type="hidden"  class="form-control">                                 
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-primary" id="submitbtn" type="submit" name="eliminarAsignatura"><strong>Sí</strong></button>
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
                var recipient = button.attr('codigo');
                modal.find('#codigo').val(recipient);
                var recipient = button.attr('nombre');
                modal.find('#nombre').val(recipient);
            });
            $('#mod-eliminar').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);
                    var id = button.attr('id');
                    modal.find('#id').val(id);
                    var nombre = button.attr('nombre');
                    modal.find('#nombre').val(nombre);
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
                        data: $("#frm_eliminar_asignatura").serialize(),
                        success: function (response) {
                          
                            if (response === 'error') {
                                er = er.text("No se puede eliminar esta asignatura.").css('color', 'red');
                                b1.hide();
                                b2.hide();
                                c1.show();

                            } else if (response === 'success') {
                                er = er.text("Asignatura eliminada.").css('color', 'green');
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
                
                function importarAsignatura(){
                    var codigo =$('#codigoAsig').val();
                    var error = $("#error");
                    var nombre = $("#nombreAsig");
                    if (!codigo || codigo.length === 0){
                        //console.log("entro");
                        error.text("Debe inserta un Código");
                    }else{
                        error.addClass("hidden");
                        codigo = agregarCero(codigo);
                        $.ajax({
                            url:"funcionalidad/agr_mod_asig.php?codigo="+codigo,
                            type: 'get',
                            async: "false",
                            success: function (response) {
                                            
                                if(response === 'noEncontro'){
                                 error.removeClass('label-primary');
                                 error.addClass('label-danger');
                                error.text("No se encontro el nombre de la asignatura con ese Código"); 
                                }
                                else 
                                    if(response === 'db_error'){
                                        error.removeClass('label-primary');
                                        error.addClass('label-danger');
                                        error.text("Hubo un error con la conexión"); 
                                    }else{
                                        error.removeClass('label-danger');
                                        error.addClass('label-primary');
                                        error.text('Se importo Correctamente');
                                        nombre.val(response);
                                    }
                                
                               
                            }
                        });
                        error.removeClass("hidden");
                    }
                }

        </script>

    </body>

</html>