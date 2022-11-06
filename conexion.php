<?php
const SERVER = 'localhost' ;
const USER = 'root';
const PASS = 'zefe07EL';
const BDGENERAL = 'podcalopers_general';
const BDADMIN = 'podcalopers_admin';

$conexionBdGeneral = new mysqli(SERVER, USER, PASS, BDGENERAL);
$conexionBdAdmin = new mysqli(SERVER, USER, PASS, BDADMIN);


const REDIRECT_ROUTE = 'http://localhost/admin/';
