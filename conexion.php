<?php
const SERVER = 'localhost' ;
const USER = 'root';
const PASS = 'zefe07EL';
const BDADMIN = 'adminzefe_admin';
const BDGENERAL = 'adminzefe_general';
const BDMODADMINISTRATIVO= 'adminzefe_modulo_administrativo';
const BDMODCOMERCIAL= 'adminzefe_modulo_comercial';
const BDMODMICUENTA= 'adminzefe_modulo_micuenta';
const BDMODSISTEMA= 'adminzefe_modulo_sistema';

$conexionBdAdmin = new mysqli(SERVER, USER, PASS, BDADMIN);
$conexionBdGeneral = new mysqli(SERVER, USER, PASS, BDGENERAL);
$conexionBdAdministrativo = new mysqli(SERVER, USER, PASS, BDMODADMINISTRATIVO);
$conexionBdComercial = new mysqli(SERVER, USER, PASS, BDMODCOMERCIAL);
$conexionBdMicuenta = new mysqli(SERVER, USER, PASS, BDMODMICUENTA);
$conexionBdSistema = new mysqli(SERVER, USER, PASS, BDMODSISTEMA);


const REDIRECT_ROUTE = 'http://localhost/admin/';
