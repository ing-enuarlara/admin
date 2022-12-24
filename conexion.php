<?php
const SERVER = 'localhost' ;#SERVIDOR
const USER = 'root';#USUARIO
const PASS = 'zefe07EL';#CONTRASEÑA
const BDADMIN = 'adminzefe_admin';#BASE DE DATOS ADMINISTRATIVA
const BDGENERAL = 'adminzefe_general';#BASE DE DATOS GENERAL
const BDMODADMINISTRATIVO= 'adminzefe_modulo_administrativo';#BASE DE DATOS MODULOS ADMINISTRATIVO
const BDMODCOMERCIAL= 'adminzefe_modulo_comercial';#BASE DE DATOS MODULO COMERCIAL
const BDMODMICUENTA= 'adminzefe_modulo_micuenta';#BASE DE DATOS MODULO MI CUENTA
const BDMODSISTEMA= 'adminzefe_modulo_sistema';#BASE DE DATOS MODULO DEL SISTEMA

$conexionBdAdmin = new mysqli(SERVER, USER, PASS, BDADMIN);#CONEXION BD ADMINISTRATIVA
$conexionBdGeneral = new mysqli(SERVER, USER, PASS, BDGENERAL);#CONEXION BD GENERAL
$conexionBdAdministrativo = new mysqli(SERVER, USER, PASS, BDMODADMINISTRATIVO);#CONEXION BD ADMINISTRATIVO
$conexionBdComercial = new mysqli(SERVER, USER, PASS, BDMODCOMERCIAL);#CONEXION BD COMERCIAL
$conexionBdMicuenta = new mysqli(SERVER, USER, PASS, BDMODMICUENTA);#CONEXION BD MI CUENTA
$conexionBdSistema = new mysqli(SERVER, USER, PASS, BDMODSISTEMA);#CONEXION BD SISTEMA

//RUTA DEL PROYECTO
const REDIRECT_ROUTE = 'http://localhost/ing-enuarlara.co/admin/';
