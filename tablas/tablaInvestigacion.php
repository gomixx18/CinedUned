<?php


$docente = $_POST["docente"];



?>
<table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Título</th>
                                                    <th>Carrera</th>
                                                    <th>Línea de Investigación</th>
                                                    <th>Catedra</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            
                                            <row>
                                                <div class="form-group">
                                                    Busqueda por identificación de docente
                                                    <input id="docente" name="docente" type="text" value="<?php echo $docente ?>" >
                                                    <input id="btndocente" name="btndocente" type="button" value="Buscar" >
                                                </div>
                                            </row>
                                            <tbody>
                                                
                                                <?php
                                                $connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");
                                                if (!$connection) {
                                                    exit("<label class='error'>Error de conexión</label>");
                                                }

                                                $query = mysqli_query($connection, "SELECT ieproyectos.codigo, ieproyectos.titulo, ieproyectos.estado, 
                                                                                    lineasinvestigacion.nombre as lineainvestigacion, 
                                                                                    carreras.nombre as carrera, catedras.nombre as catedra, ieproyectos.isExtension
                                                                                    FROM ieproyectos, lineasinvestigacion, carreras, catedras, ieinvestigan, ieinvestigadores
                                                                                    where ieproyectos.lineainvestigacion = lineasinvestigacion.codigo and
                                                                                    ieproyectos.carrera = carreras.codigo and ieproyectos.catedra = catedras.codigo and
                                                                                    ieproyectos.codigo = ieinvestigan.proyecto and ieinvestigadores.id = ieinvestigan.investigador
                                                                                    and ieproyectos.isExtension = 0 and ieinvestigadores.id = '". $docente . "'");

                                                if($query){
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $data["codigo"] . "</td>";
                                                    echo "<td>" . $data["titulo"] . "</td>";
                                                    echo "<td>" . $data["carrera"] . "</td>";
                                                    echo "<td>" . $data["lineainvestigacion"] . "</td>";
                                                    echo "<td>" . $data["catedra"] . "</td>";
                                                    echo "<td>" . $data["estado"] . "</td>";
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                 id = '" . $data["codigo"] . "' > Modificar</button></td> ";


                                                    echo "<form method= 'GET' action = 'consulta_TFG.php'>";
                                                    echo "<input type='hidden' name='codigo' value= '" . $data["codigo"] . "'/> ";
                                                    echo "<td>" . "<button type='submit' data-toggle='modal' class='btn btn-primary'
                                                                 id = '" . $data["codigo"] . "' > Consultar</button></td> ";
                                                    echo "</tr>";
                                                    echo "</form>";
                                                }
                                                }

                                                mysqli_close($connection);
                                                ?>   

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Título</th>
                                                    <th>Carrera</th>
                                                    <th>Línea de Investigación</th>
                                                    <th>Catedra</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </tfoot>
                                        </table>



<script>
            $(document).ready(function () {
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
                    "New row"
                ]);

            }
        </script>
        
        </script>
	<script >


            $(document).ready(function () {

                $("#btndocente").click(function (evento) {
                    evento.preventDefault();
                    var val = $("#docente").val();
                    $("#divTabla").load("tablas/tablaInvestigacion.php", {docente: val}, function () {

                        
                    });
                });
            });
        </script>
        <script >


            $(document).ready(function () {
             
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
                
            });
        </script>