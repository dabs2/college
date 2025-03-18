<?php
require_once 'route/session.php';
require __DIR__ . '/vendor/autoload.php';

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'view/home.php',
    '/login' => 'login.php',
    '/attendance' => 'view/attendanceview.php',
    '/register' => 'view/register.php',
    '/leavestats' => 'view/leavestats.php',
    '/leavesection' => 'view/leavesection.php',
    '/managefaculty' => 'view/managefaculty.php',
    '/holidayview' => 'view/holidayview.php',
    '/resignationview' => 'view/resignationview.php',
    '/halfday' => 'view/halfday.php',
    '/settings' => 'view/settings.php',
    '/temp' => 'temp.php'
];

$router = new \College\Ddcollege\Route\route();

//var_dump($url);
$router->RouteToController($url, $routes);