<?php
require_once("constantes.php");

$conexionBdAdmin = new mysqli(SERVER, USER, PASS, BDADMIN);#CONEXION BD ADMINISTRATIVA
$conexionBdGeneral = new mysqli(SERVER, USER, PASS, BDGENERAL);#CONEXION BD GENERAL
$conexionBdAdministrativo = new mysqli(SERVER, USER, PASS, BDMODADMINISTRATIVO);#CONEXION BD ADMINISTRATIVO
$conexionBdComercial = new mysqli(SERVER, USER, PASS, BDMODCOMERCIAL);#CONEXION BD COMERCIAL
$conexionBdMicuenta = new mysqli(SERVER, USER, PASS, BDMODMICUENTA);#CONEXION BD MI CUENTA
$conexionBdSistema = new mysqli(SERVER, USER, PASS, BDMODSISTEMA);#CONEXION BD SISTEMA
$conexionBdPaginaWeb = new mysqli(SERVER, USER, PASS, BDMODPAGINAWEB);#CONEXION BD PAGINA WEB