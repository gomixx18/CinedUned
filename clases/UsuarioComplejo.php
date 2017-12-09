<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EncargadoTFG
 *
 * @author JosePablo
 */
class UsuarioComplejo {

    #Atributos

    private $id;
    private $password;
    private $apellido1;
    private $apellido2;
    private $nombre;
    private $correo;
    private $titulo;
    private $especialiad;


    #Constructor

    function __construct($id, $password,$apellido1, $apellido2, $nombre, $correo, $titulo, $especialiad) {

        $this->id = $id;
        $this->passworod = $password;
        $this->apellido1 = $apellido1;
        $this->apellido2= $apellido2;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->titulo = $titulo;
        $this->especialiad = $especialiad;
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
    function getTitulo() {
        return $this->titulo;
    }

    function getEspecialiad() {
        return $this->especialiad;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setEspecialiad($especialiad) {
        $this->especialiad = $especialiad;
    }


}
