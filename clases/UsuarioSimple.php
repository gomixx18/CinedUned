<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estudiante
 *
 * @author JosePablo
 */
class UsuarioSimple {
    #Atributos

    private $id;
    private $password;
    private $apellido1;
    private $apellido2;
    private $nombre;
    private $correo;


    #Constructor

    function __construct($id, $password,$apellido1, $apellido2, $nombre,$correo) {

        $this->id = $id;
        $this->passworod = $password;
        $this->apellido1 = $apellido1;
        $this->apellido2= $apellido2;
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    #Destructor

    function __destruct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getPassword() {
        return $this->password;
    }

    function getApellido1() {
        return $this->apellido1;
    }

    function getApellido2() {
        return $this->apellido2;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCorreo() {
        return $this->correo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }

    function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }



   
}

