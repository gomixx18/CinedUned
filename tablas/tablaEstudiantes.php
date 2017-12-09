<?php

require("../funcionalidad/email.php");


$nombre = $_POST["nombre"];
$id = $_POST["id"];
$ap1 = $_POST["apellido1"];
$ap2 = $_POST["apellido2"];
$correo = $_POST["correo"];

$pass = "a" . substr(md5(microtime()), 1, 7);
$connection = mysqli_connect("proyectos.uned.ac.cr", "usr_cined", "cined123", "uned_db");


if ($connection) {
    $sentenciaSQL = "INSERT INTO tfgestudiantes (id, nombre, apellido1, apellido2, password, correo, estado) VALUES ('" . $id . "', '" . $nombre . "', '" . $ap1 . "', '" . $ap2 . "', '" . $pass . "', '" . $correo . "', 1)";
    $resultado = mysqli_query($connection, $sentenciaSQL);
    $sentenciaSQLexist = "SELECT * FROM usuarios where id= '" . $id . "'";
    $resultadoExist = mysqli_query($connection, $sentenciaSQLexist);
    if (mysqli_num_rows($resultadoExist) == 0) {
        $sentenciaSQLusarios = "INSERT INTO usuarios (id, password, estudiante, encargadotfg, asesortfg, directortfg, miembrocomisiontfg, investigador, coordinadorinvestigacion, evaluador, miembrocomiex) VALUES ('" . $id . "', '" . $pass . "', true, false, false, false, false, false, false, false, false)";
        $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios);
    } else {
        $sentenciaSQLusarios = "UPDATE usuarios SET estudiante = true WHERE id= '" . $id . "'";
        $resultadoUsuarios = mysqli_query($connection, $sentenciaSQLusarios);
    }

}
    //*** -- validar mas adelante -- ***
    newUserMail($id, $pass, $nombre, "estudiante", $correo);
?>


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
    echo "<td name='id'>" . $data["id"]  . "</td>";
    echo "<td name='nombre'>" . $data["nombre"] . "</td>";
    echo "<td name='apellido1'>" . $data["apellido1"] . "</td>";
    echo "<td name='apellido2'>" . $data["apellido2"] . "</td>";
    echo '<td class="center"><div class="i-checks"><input type="radio" value="' . $data["id"] . '" name="radEstudiante" nombreaux = "'. $data["nombre"] .'" ap1aux = "'. $data["apellido1"] .'" ap2aux = "'. $data["apellido2"] .'"></div></td>';
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

                $('.dataTables-example').DataTable({
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

 <script >


            $(document).ready(function () {

                $("#btnAgregarEstudianteModal").click(function (evento) {
                    evento.preventDefault();
                    var idaux = $("#idRegistroEstudiante").val();
                    var nomaux = $("#nombreRegistroEstudiante").val();
                    var ape1aux = $("#apellido1RegistroEstudiante").val();
                    var ape2aux = $("#apellido2RegistroEstudiante").val();
                    var correoaux = $("#correoRegistroEstudiante").val();
                    $("#tablaEstudiantes").load("tablas/tablaEstudiantes.php", {id: idaux, nombre: nomaux, apellido1: ape1aux, apellido2: ape2aux, correo: correoaux}, function () {

                        
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