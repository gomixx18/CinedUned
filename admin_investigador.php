﻿<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Página de Bienvenida</title>

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
                        <h2>Administración de Investigadores</h2>
                        <ol class="breadcrumb">

                            <li class="active">
                                <strong>Consulta de Investigadores</strong>
                            </li>
                            <li>
                                <a data-toggle="modal" href="#modal-form">Registrar Investigador</a>
                            </li>

                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
				
					<a data-toggle="modal" class="btn btn-primary" href="#modal-form" >Registrar Investigador</a>
					<br/>
					<br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">

                                <div class="ibox-title">
                                    <h5>Consulta de Investigador</h5>
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
                                                    <th>Correo</th>
                                                    <th>Estudiante</th>
                                                    <th>Unidad Académica</th>
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

                                                $query = mysqli_query($connection, "SELECT * FROM ieinvestigadores");


                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["id"] . "</td>";
                                                    echo "<td>" . $data["apellido1"] . "</td>";
                                                    echo "<td>" . $data["apellido2"] . "</td>";
                                                    echo "<td>" . $data["nombre"] . "</td>";
                                                    echo "<td>" . $data["correo"] . "</td>";
                                                    if($data["isEstudiante"]){
                                                        echo "<td>Si</td>";
                                                    }
                                                    else{
                                                        echo "<td>No</td>";
                                                    }
                                                    echo "<td>" . $data["unidadAcademica"] . "</td>";
                                                    if ($data["estado"] == '1') {
                                                        echo "<td>Activo</td>";
                                                    } else {
                                                        echo "<td>Inactivo</td>";
                                                    }
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                data-target='#mod-form' id = '" . $data["id"] . "' nombre = '" . $data["nombre"] . "' apellido1 = '" . $data["apellido1"] .
                                                    "' apellido2 = '" . $data["apellido2"] . "'activo = '" . $data["estado"] . "' correo = '" . $data["correo"] . "' isEstudiante = '" . $data["isEstudiante"] . "' uAcademica =  '" . $data["unidadAcademica"] . "' > Modificar</button></td> ";
                                                    echo "</tr>";
                                                }

                                         
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Identificación</th>
                                                    <th>Primer Apellido</th>
                                                    <th>Segundo Apellido</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Estudiante</th>
                                                    <th>Unidad Académica</th>
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
        <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
        <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <script src="js/plugins/iCheck/icheck.min.js"></script>
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
                        {extend: 'copy'},
                        {extend: 'csv'},
                        {extend: 'excel', title: 'ExampleFile'},
                        {extend: 'pdf', title: 'ExampleFile'},
                        {extend: 'print',
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Agregar Investigador</h3>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/INVAgregar.php">
                                    <div class="checkbox checkbox-success checkbox-circle">
                                        <input type="checkbox" id="isEstudiante" name="isEstudiante">
                                        <label for="checkbox8" >
                                            ¿Es estudiante?
                                        </label>
                                    </div>

                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input required type="text" placeholder="Identificacion" class="form-control" name="id"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input required type="text" placeholder="Nombre" class="form-control" name="nombre"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input required type="text" placeholder="Primer Apellido" class="form-control" name="apellido1"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input required type="text" placeholder="Segundo Apellido" class="form-control" name="apellido2"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input required type="email" placeholder="Correo" class="form-control" name="correo"></div>
                                    <label>Unidad Académica</label>
                                    <div class="row">
                                        <div class="col-lg-3">
                                        <div class="form-group">                                              
                                            <label>Catedra</label>
                                            <select name='catedra' aria-required='true' class="select2_catedra form-control " tabindex="-1">
                                                <option value="Ninguna">Ninguna</option>
                                                <?php
                                        
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM catedras");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["nombre"] . ">" . $data["nombre"] . "</option>";
                                                }
                                                ?>
                                            </select>       
                                            </div> 
                                        </div> 
                                        <div class="form-group">  
                                             <div class="col-lg-3">
                                            <label>Carrera</label>
                                            <select name='carrera' aria-required='true' class="form-control " tabindex="-1">
                                                <option value="Ninguna">Ninguna</option>
                                                <?php
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM carreras");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["nombre"] . ">" . $data["nombre"] . "</option>";
                                                }
                                                
                                                ?>
                                            </select>     
                                            </div>  
                                        </div>  
                                        
                                        <div class="col-lg-3">
                                            <label>CINED</label>
                                            <div class="i-checks" ><input name="cined" type="checkbox" value="CINED"> </div>
                                        </div>  
                                        <div class="col-lg-3">
                                            <label>Otros</label>
                                            <div class="i-checks"><input name="otros" type="checkbox" value="CINED"> </div>
                                        </div>  
                                       
                                    </div>  

                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> 
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="INVAgregarInvestigador"><strong>Registrar</strong></button>
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
                            <div class=""><h3 class="m-t-none m-b"> <i class="fa fa-plus-square-o"></i> Modificar Investigador</h3>
                                <h4 id="tituloEstado" style='color: red'>Usuario inactivo</h4>
                                <form role="form" id="frm_agregar_estudiante" method="POST" action="funcionalidad/INVModificar.php">
                                    <div class="checkbox checkbox-success checkbox-circle">
                                        <input type="checkbox" id="isEstudiante" name="isEstudiante">
                                        <label for="checkbox8">
                                            ¿Es estudiante?
                                        </label>
                                    </div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Identificación</label></i> <input name="id" id="id" required type="text" placeholder="Identificacion" class="form-control" readonly></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Nombre</label> </i> <input name="nombre" id="nombre" required type="text" placeholder="Nombre" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Primer Apellido</label></i> <input name="apellido1" id="apellido1" required type="text" placeholder="Primer Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Segundo Apellido</label></i> <input name="apellido2" id="apellido2" required type="text" placeholder="Segundo Apellido" class="form-control"></div>
                                    <div class="form-group"> <i class="fa fa-exclamation-circle"> <label>Correo</label></i> <input name="correo" id="correo" required type="email" placeholder="Correo" class="form-control"></div>
                                    <label>Unidad Académica</label>
                                    <div class="row">
                                        <div class="col-lg-3">
                                        <div class="form-group">                                              
                                            <label>Catedra</label>
                                            <select id="catedra" name='catedra' aria-required='true' class="select2_catedra form-control " tabindex="-1">
                                                <option value="Ninguna" selected="">Ninguna</option>
                                                <?php
                                        
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM catedras");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["nombre"] . ">" . $data["nombre"] . "</option>";
                                                }
                                                ?>
                                            </select>       
                                            </div> 
                                        </div> 
                                        <div class="form-group">  
                                             <div class="col-lg-3">
                                            <label>Carrera</label>
                                            <select id="carrera" name='carrera' aria-required='true' class="form-control " tabindex="-1">
                                                <option value="Ninguna" selected="">Ninguna</option>
                                                <?php
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT * FROM carreras");
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=" . $data["nombre"] . ">" . $data["nombre"] . "</option>";
                                                }
                                                mysqli_close($connection);
                    
                                                ?>
                                            </select>     
                                            </div>  
                                        </div>  
                                        
                                        <div class="col-lg-3">
                                            <label>CINED</label>
                                            <div class="i-checks" id="cined"><input  name="cined" type="checkbox" value="CINED"> </div>
                                            
                                        </div>  
                                        <div class="col-lg-3">
                                            <label>Otros</label>
                                            <div class="i-checks" id="otros"><input name="otros" type="checkbox" value="CINED"> </div>
                                        </div> 
                                       
                                    </div> 
                                    <div>
                                        <label class=""> <i class="fa fa-exclamation-circle"> Rellene los datos obligatorios.</i></label><br> <br>
                                        <button class="btn btn-sm btn-danger pull-left m-t-n-xs" type="button" id="desactivar" name="desactivarInvestigador"><i class="fa fa-warning"></i><strong> Desactivar</strong></button>
                                        <button class="btn btn-sm btn-info pull-left m-t-n-xs" type="button" name="activarInvestigador" id="activar" ><i class="fa fa-check-circle"></i><strong> Activar</strong></button>
                                        <input name="estado" id="estado" type="text" hidden>    
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="INVModificarInvestigador"><strong>Guardar Cambios</strong></button>
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
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('#mod-form').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var recipient = button.attr('id');
                btn1 = modal.find('#desactivar');
                btn2 = modal.find('#activar');
                estado = modal.find('#estado');
                t = modal.find('#tituloEstado');
                
                var check = modal.find('#isEstudiante');
                
                modal.find('#id').val(recipient);

                recipient = button.attr('nombre');
                modal.find('#nombre').val(recipient);

                recipient = button.attr('apellido1');
                modal.find('#apellido1').val(recipient);

                recipient = button.attr('apellido2');
                modal.find('#apellido2').val(recipient);

                recipient = button.attr('correo');
                modal.find('#correo').val(recipient);
                
                recipient = button.attr('uAcademica');
                var auxUnidad = recipient.split(",");
                
                modal.find('#carrera').val("Ninguna");
                modal.find('#catedra').val("Ninguna");
                for(var i=0; i < $('#carrera option').size(); i++){
                    for(var j=0; j<auxUnidad.length; j++){
  
                        if($('#carrera option').eq(i).val() === auxUnidad[j]){
                             modal.find('#carrera').val(auxUnidad[j]);
              
                        }
                    }
                }
                for(var i=0; i < $('#catedra option').size(); i++){
                    for(var j=0; j<auxUnidad.length; j++){              
                        if($('#catedra option').eq(i).val() === auxUnidad[j]){
                             modal.find('#catedra').val(auxUnidad[j]);
                           
                        }
                    }
                }
                
                
                $("#cined").find(".icheckbox_square-green").removeClass("checked");
     
                for(var j=0; j<auxUnidad.length; j++){
                    if(auxUnidad[j] === 'CINED'){
                        
                        $("#cined").find(".icheckbox_square-green").addClass("checked");
                      
                    }
                }
                
          
                $("#otros").find(".icheckbox_square-green").removeClass("checked");
                for(var j=0; j<auxUnidad.length; j++){
                 
                    if(auxUnidad[j] === "otros"){
                       
                       $("#otros").find(".icheckbox_square-green").addClass("checked");
                    }
                }
                
                
    

                recipient = button.attr('isEstudiante');

                if (recipient == '1') {
                    check.prop('checked', true);
                } else {
                    check.prop('checked', false);
                }

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
