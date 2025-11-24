<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Controllers\HomeController;
use App\Controllers\AppointmentController;
use App\Controllers\AuthController;
use App\Controllers\PatientAuthController;
use App\Controllers\Admin\DashboardController;
use App\Utils\Router;

$router = new Router('/DENTISTE');

// Routes front office
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/services', function() {
    $controller = new HomeController();
    $controller->services();
});

$router->get('/about', function() {
    $controller = new HomeController();
    $controller->about();
});

$router->get('/news', function() {
    $controller = new HomeController();
    $controller->news();
});

$router->get('/news/{id}', function($id) {
    $controller = new HomeController();
    $controller->newsDetail((int) $id);
});

$router->get('/booking', function() {
    $controller = new AppointmentController();
    $controller->book();
});

$router->post('/booking', function() {
    $controller = new AppointmentController();
    $controller->book();
});

$router->get('/api/available-slots', function() {
    $controller = new AppointmentController();
    $controller->getAvailableSlots();
});

// Routes authentification patient
$router->get('/login', function() {
    $controller = new PatientAuthController();
    $controller->showLogin();
});

$router->post('/login', function() {
    $controller = new PatientAuthController();
    $controller->login();
});

$router->get('/register', function() {
    $controller = new PatientAuthController();
    $controller->showRegister();
});

$router->post('/register', function() {
    $controller = new PatientAuthController();
    $controller->register();
});

$router->get('/account', function() {
    $controller = new PatientAuthController();
    $controller->showAccount();
});

$router->get('/logout', function() {
    $controller = new PatientAuthController();
    $controller->logout();
});

// Routes authentification admin
$router->get('/admin/login', function() {
    $controller = new AuthController();
    $controller->showLoginForm();
});

$router->post('/admin/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->get('/admin/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// Routes admin
$router->get('/admin/dashboard', function() {
    $controller = new DashboardController();
    $controller->index();
});

$router->get('/admin/appointments', function() {
    $controller = new DashboardController();
    $controller->appointments();
});

$router->post('/admin/appointments/update-status', function() {
    $controller = new DashboardController();
    $controller->updateAppointmentStatus();
});

$router->get('/admin/patients', function() {
    $controller = new DashboardController();
    $controller->patients();
});

$router->get('/admin/services', function() {
    $controller = new DashboardController();
    $controller->services();
});

$router->post('/admin/services/create', function() {
    $controller = new DashboardController();
    $controller->createService();
});

$router->get('/admin/news', function() {
    $controller = new DashboardController();
    $controller->news();
});

$router->post('/admin/news/create', function() {
    $controller = new DashboardController();
    $controller->createNews();
});

$router->dispatch();
