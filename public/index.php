<?php

require_once __DIR__ . '/../vendor/autoload.php';

use thirthfamous\App\Router;
use thirthfamous\Config\Database;
use thirthfamous\Controller\HomeController;
use thirthfamous\Controller\UserController;

Database::getConnection('prod');

// Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

// User Controller
Router::add('GET', '/users/register', UserController::class, 'register', []);
Router::add('POST', '/users/register', UserController::class, 'postRegister', []);
Router::add('GET', '/users/login', UserController::class, 'login', []);
Router::add('POST', '/users/login', UserController::class, 'postLogin', []);


Router::run();