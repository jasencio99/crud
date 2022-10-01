<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Alumnos_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['/'] = 'welcome/index';



$route['inicio'] = 'Inicio_Controller/inicio';
$route['login'] = 'LoginController/login';
$route['validar'] = 'LoginController/validar';
$route['existe'] = 'LoginController/existe';
