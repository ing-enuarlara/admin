<?php
require_once("constantes.php");

$conexionBdAdmin = new mysqli(SERVER, USER, PASS, BDADMIN);#CONEXION BD ADMINISTRATIVA
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdAdmin, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdAdmin));
    exit();
}

$conexionBdGeneral = new mysqli(SERVER, USER, PASS, BDGENERAL);#CONEXION BD GENERAL
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdGeneral, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdGeneral));
    exit();
}

$conexionBdAdministrativo = new mysqli(SERVER, USER, PASS, BDMODADMINISTRATIVO);#CONEXION BD ADMINISTRATIVO
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdAdministrativo, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdAdministrativo));
    exit();
}

$conexionBdComercial = new mysqli(SERVER, USER, PASS, BDMODCOMERCIAL);#CONEXION BD COMERCIAL
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdComercial, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdComercial));
    exit();
}

$conexionBdMicuenta = new mysqli(SERVER, USER, PASS, BDMODMICUENTA);#CONEXION BD MI CUENTA
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdMicuenta, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdMicuenta));
    exit();
}

$conexionBdSistema = new mysqli(SERVER, USER, PASS, BDMODSISTEMA);#CONEXION BD SISTEMA
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdSistema, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdSistema));
    exit();
}

$conexionBdPaginaWeb = new mysqli(SERVER, USER, PASS, BDMODPAGINAWEB);#CONEXION BD PAGINA WEB
// Validar el conjunto de caracteres
if (!mysqli_set_charset($conexionBdPaginaWeb, "utf8mb4")) {
    printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", mysqli_error($conexionBdPaginaWeb));
    exit();
}