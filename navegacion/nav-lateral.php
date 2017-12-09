
<?php
include 'clases/UsuarioSimple.php';
include 'clases/UsuarioComplejo.php';
include 'clases/UsuarioPermisos.php';
include 'clases/UsuarioInvestigadorSimple.php';
include 'clases/UsuarioInvestigadorComplejo.php';
@session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
$usuarioSesion = $_SESSION["user"];
$usuarioPermisos = $_SESSION['permisos'];
?>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <script src="js/cleanString.js"></script>
    <script src="js/jquery-2.1.1.js"></script>
</head>
<nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element"> <span>
                                    <A HREF="index.php"><img alt="image" class="center-block" src="img/uned_logo.png" style="height: 75px; width: 75px"></A>
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> 
                                        <span class="block m-t-xs"> <strong class="font-bold">
                                            <?php
                                                echo $usuarioSesion->getNombre() . " " . $usuarioSesion->getApellido1();
                                            ?>
                                            </strong>
                                        </span> <span class="text-muted text-xs block">Usuario <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="">Perfil</a></li>
                                    
                                    <li class="divider"></li>
                                    <li><a href="login.php">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <a href="index.php">CINED</a>
                            </div>
                        </li>
                        <li>
                              <?php if($usuarioPermisos->getEncargadotfg() || $usuarioPermisos->getCoordinadorinvestigacion() || $usuarioPermisos->getEstudiante()||
                                             $usuarioPermisos->getDirectortfg()|| $usuarioPermisos->getAsesortfg() || $usuarioPermisos->getMiembrocomisiontfg()){ ?>
                            <a href="index.php"><i class="fa fa-fw fa-book"></i> <span class="nav-label">TFG</span> <span class="fa arrow"></span></a>
                            <ul id="tfg_principal" class="nav nav-second-level collapse">
                                 <?php if($usuarioPermisos->getEncargadotfg() || $usuarioPermisos->getCoordinadorinvestigacion()){?>
                                <li>
                                  
                                    <a href="javascript:;" data-toggle="collapse" data-target="#tfg_admin"><i class="fa fa-users"></i> Administración de Usuarios<i class="fa fa-fw fa-caret-down"></i></a>                                  
                                    <ul id="tfg_admin" class="nav nav-third-level collapse">
                                        <li>
                                            <a href="admin_estudiante.php"><i class="fa fa-user"></i> Estudiantes</a>
                                        </li>
                                        <li>
                                            <a href="admin_directores.php"><i class="fa fa-user"></i> Directores de TFG</a>
                                        </li>
                                        <li>
                                            <a href="admin_encargados.php"><i class="fa fa-user"></i> Encargados de TFG</a>
                                        </li>
                                        <li>
                                            <a href="admin_asesores.php"> <i class="fa fa-user"></i>Asesores</a>
                                        </li>
                                        <li>
                                            <a href="admin_comisionTFG.php"><i class="fa fa-user"></i> Miembros de Comisión de TFG</a>
                                        </li>
                                    </ul>
                                            
                                </li>
                                 <?php }?>
                               
                                <?php if($usuarioPermisos->getEncargadotfg() || $usuarioPermisos->getCoordinadorinvestigacion() || $usuarioPermisos->getEstudiante() ||
                                        $usuarioPermisos->getAsesortfg()|| $usuarioPermisos->getDirectortfg()||$usuarioPermisos->getMiembrocomisiontfg()){ ?>     
                                <li>
                                    <a href="admin_TFG.php"><i class="fa fa-folder"></i> Administración de TFG</a>
                                </li>
                                <?php } ?>
                                <?php if($usuarioPermisos->getEncargadotfg() || $usuarioPermisos->getCoordinadorinvestigacion()) {?>
                                <li>
                                    <a href="admin_Modalidad.php" ><i class="fa fa-th-list"></i>  Modalidades </a>

                                </li>
                                <?php }?>
                            </ul>
                            </li>
                             
                            <?php } ?>
                        <li>
                            <?php if($usuarioPermisos->getCoordinadorinvestigacion() || $usuarioPermisos->getInvestigador()||
                                             $usuarioPermisos->getEvaluador()|| $usuarioPermisos->getMiembrocomiex()){ ?>
                            <a href="index.php"><i class="fa fa-fw fa-book"></i> <span class="nav-label">Proyectos de Investigación</span> <span class="fa arrow"></span></a>
                            <ul id="inv_principal" class="nav nav-second-level collapse">
                                <li>
                                    <?php if($usuarioPermisos->getCoordinadorinvestigacion()){ ?>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#inv_admin"><i class="fa fa-users"></i> Administración de Usuarios<i class="fa fa-fw fa-caret-down"></i></a>                                  
                                    <ul id="inv_admin" class="nav nav-third-level collapse">
                                        <li>
                                            <a href="admin_investigador.php"><i class="fa fa-user"></i> Investigadores</a>
                                        </li>
                                        <li>
                                            <a href="admin_coordinadorInv.php"><i class="fa fa-user"></i> Coordinador de Investigación</a>
                                        </li>

                                        <li>
                                            <a href="admin_evaluador.php"><i class="fa fa-user"></i> Evaluadores</a>
                                        </li>
                                        <li>
                                            <a href="admin_MiembroComiex.php"><i class="fa fa-user"></i> Miembros de COMIEX</a>
                                        </li>

                                    </ul>
                                    <?php } ?>
                                </li>
                                
                                <li>
                                    <a href="admin_Investigacion.php"><i class="fa fa-folder"></i> Administración de Proyectos de Investigación</a>
                                </li>

                            </ul>
                            <?php }?>
                        </li>
                        <li>
                               <?php if($usuarioPermisos->getCoordinadorinvestigacion() || $usuarioPermisos->getInvestigador()||
                                             $usuarioPermisos->getEvaluador()|| $usuarioPermisos->getMiembrocomiex()){ ?>
                            <a href="index.html"><i class="fa fa-fw fa-book"></i> <span class="nav-label">Proyectos de Extensión</span> <span class="fa arrow"></span></a>
                            <ul id="ext_principal" class="nav nav-second-level collapse">
                                <li>
                                     <?php if($usuarioPermisos->getCoordinadorinvestigacion()){ ?>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#ext_admin"><i class="fa fa-users"></i> Administración de Usuarios<i class="fa fa-fw fa-caret-down"></i></a>                                  
                                    <ul id="ext_admin" class="nav nav-third-level collapse">
                                        <li>
                                            <a href="admin_investigador.php"><i class="fa fa-user"></i> Docentes</a>
                                        </li>
                                        <li>
                                            <a href="admin_coordinadorInv.php"><i class="fa fa-user"></i> Coordinador de Investigación</a>
                                        </li>

                                        <li>
                                            <a href="admin_evaluador.php"><i class="fa fa-user"></i> Evaluadores</a>
                                        </li>
                                        <li>
                                            <a href="admin_MiembroComiex.php"><i class="fa fa-user"></i> Miembros de COMIEX</a>
                                        </li>

                                    </ul>
                                     <?php }?>
                                </li>
                                <li>
                                    <a href="admin_Extension.php"><i class="fa fa-folder"></i> Administración de Proyectos de Extensión</a>
                                </li>
                            </ul>
                             <?php } ?>
                        </li>
                        <li>
                            <?php if($usuarioPermisos->getCoordinadorinvestigacion()){ ?>
                            <a href="index.html"><i class="fa fa-fw fa-list"></i> <span class="nav-label">Administración General</span> <span class="fa arrow"></span></a>
                            <ul id="ext_principal" class="nav nav-second-level collapse">
                                <li>
                                    <a href="admin_centros_universitarios.php"><i class="fa fa-institution"></i>Centros Universitarios</a>
                                </li>
                                <li>
                                    <a href="admin_Catedras.php"><i class="fa fa-th-list"></i> Cátedras</a>
                                </li>
                                <li>
                                  
                                    <a href="admin_Carreras.php"><i class="fa fa-th-list"></i> Carreras </a>
                                </li>
                                <li>
                                    <a href="admin_asignaturas.php"><i class="fa fa-th-list"></i>Asignaturas</a>
                                </li>
                                <li>
                                    <a href="admin_LineasInvestigacion.php"><i class="fa fa-th-list"></i>Líneas de Investigación </a>
                                </li>
                                
                                
                            </ul>
                            <?php } ?>
                        </li>
                        <li>
                           <?php if($usuarioPermisos->getEncargadotfg() || $usuarioPermisos->getCoordinadorinvestigacion() || $usuarioPermisos->getMiembrocomiex()||
                               $usuarioPermisos->getDirectortfg() || $usuarioPermisos->getMiembrocomisiontfg()) {?>
                            <a href="index.php"><i class="fa fa-fw fa-list-alt"></i> <span class="nav-label">Reportes</span> <span class="fa arrow"></span></a>
                           <ul id="reportes" class="nav nav-second-level collapse">
                               <li>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#reportes_tfg"><i class="fa fa-users"></i> Reportes TFG<i class="fa fa-fw fa-caret-down"></i></a>                                  
                                    <ul id="reportes_tfg" class="nav nav-third-level collapse">
                                         <li>
                                            <a href="ReportesTFG.php"><i class="fa fa-fw fa-list-alt"></i>Reportes TFG</a>
                                         </li>
                                         <li>
                                            <a href="ReportesDirectores.php"><i class="fa fa-fw fa-list-alt"></i>Reportes Directores TFG</a>
                                         </li>
                                         <li>
                                            <a href="ReportesAsesores.php"><i class="fa fa-fw fa-list-alt"></i>Reportes Asesores TFG</a>
                                         </li>
                                         <li>
                                            <a href="ReportesEstudiantes.php"><i class="fa fa-fw fa-list-alt"></i>Reportes Estudiantes TFGs</a>
                                         </li>
                                         <li>
                                            <a href="ReportesCU.php"><i class="fa fa-fw fa-list-alt"></i>Reportes Centros Universitarios TFGs</a>
                                        </li>
                                    </ul> 
                                </li>
                                <li>
                                    <a href="ReportesInvestigacion.php"><i class="fa fa-fw fa-list-alt"></i>Proyectos de Investigación</a>
                                </li>
                                <li>
                                    <a href="ReportesExtension.php"><i class="fa fa-fw fa-list-alt"></i>Proyectos de Extensión</a>
                                </li>
                            </ul>
                            <?php } ?>
                        </li>
      
                        </ul>
                        </div>
                        </nav>

