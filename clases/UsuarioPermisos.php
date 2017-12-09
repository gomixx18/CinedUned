<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioAplicacion
 *
 * @author JosePablo
 */
class UsuarioPermisos {
    #Atributos

    private $id;
    private $password;
    private $estudiante;
    private $encargadotfg;
    private $asesortfg;
    private $directortfg;
    private $miembrocomisiontfg;
    private $investigador;
    private $coordinadorinvestigacion;
    private $evaluador;
    private $miembrocomiex;

    #Constructor

    function __construct($id, $password,$estudiante, $encargadotfg, $asesortfg,
            $directortfg, $miembocomisiontfg, $investigador, $coordinadorinvestigacion, $evaluador, $miembrocomiex) {

        $this->id = $id;
        $this->password = $password;
        $this->estudiante = $estudiante;
        $this->encargadotfg = $encargadotfg;
        $this->asesortfg = $asesortfg;
        $this->directortfg = $directortfg;
        $this->miembrocomisiontfg = $miembocomisiontfg;
        $this->investigador = $investigador;
        $this->coordinadorinvestigacion = $coordinadorinvestigacion;
        $this->evaluador = $evaluador;
        $this->miembrocomiex = $miembrocomiex;
    }

    #Destructor

    function __destruct() {
        
    }

    #Get
    function getId() {
        return $this->id;
    }

    function getPassword() {
        return $this->password;
    }

    function getEstudiante() {
        return $this->estudiante;
    }

    function getEncargadotfg() {
        return $this->encargadotfg;
    }

    function getAsesortfg() {
        return $this->asesortfg;
    }

    function getDirectortfg() {
        return $this->directortfg;
    }

    function getMiembrocomisiontfg() {
        return $this->miembrocomisiontfg;
    }

    function getInvestigador() {
        return $this->investigador;
    }

    function getCoordinadorinvestigacion() {
        return $this->coordinadorinvestigacion;
    }

    function getEvaluador() {
        return $this->evaluador;
    }

    function getMiembrocomiex() {
        return $this->miembrocomiex;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEstudiante($estudiante) {
        $this->estudiante = $estudiante;
    }

    function setEncargadotfg($encargadotfg) {
        $this->encargadotfg = $encargadotfg;
    }

    function setAsesortfg($asesortfg) {
        $this->asesortfg = $asesortfg;
    }

    function setDirectortfg($directortfg) {
        $this->directortfg = $directortfg;
    }

    function setMiembocomisiontfg($miembocomisiontfg) {
        $this->miembrocomisiontfg = $miembocomisiontfg;
    }

    function setInvestigador($investigador) {
        $this->investigador = $investigador;
    }

    function setCoordinadorinvestigacion($coordinadorinvestigacion) {
        $this->coordinadorinvestigacion = $coordinadorinvestigacion;
    }

    function setEvaluador($evaluador) {
        $this->evaluador = $evaluador;
    }

    function setMiembrocomiex($miembrocomiex) {
        $this->miembrocomiex = $miembrocomiex;
    }


   
}
