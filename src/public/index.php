<?php
/**
 * Front Controller - точка входу додатку
 */

// Початок сесії
session_start();

// Підключення конфігурації
require_once __DIR__ . '/../config/database.php';

// Підключення базових класів
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Auth.php';

// Створення роутера
$router = new Router();

// Маршрути аутентифікації
$router->get('/auth/login', 'AuthController', 'login');
$router->post('/auth/login', 'AuthController', 'login');
$router->get('/auth/register', 'AuthController', 'register');
$router->post('/auth/register', 'AuthController', 'register');
$router->get('/auth/logout', 'AuthController', 'logout');

// Головна панель
$router->get('/', 'DashboardController', 'index');
$router->get('/dashboard', 'DashboardController', 'index');

// Учні
$router->get('/students', 'StudentController', 'index');
$router->get('/students/create', 'StudentController', 'create');
$router->post('/students/create', 'StudentController', 'create');
$router->get('/students/edit/{id}', 'StudentController', 'edit');
$router->post('/students/edit/{id}', 'StudentController', 'edit');
$router->post('/students/delete/{id}', 'StudentController', 'delete');

// Предмети
$router->get('/subjects', 'SubjectController', 'index');
$router->get('/subjects/create', 'SubjectController', 'create');
$router->post('/subjects/create', 'SubjectController', 'create');
$router->get('/subjects/edit/{id}', 'SubjectController', 'edit');
$router->post('/subjects/edit/{id}', 'SubjectController', 'edit');
$router->post('/subjects/delete/{id}', 'SubjectController', 'delete');

// Оцінки
$router->get('/grades', 'GradeController', 'index');
$router->get('/grades/create', 'GradeController', 'create');
$router->post('/grades/create', 'GradeController', 'create');
$router->get('/grades/edit/{id}', 'GradeController', 'edit');
$router->post('/grades/edit/{id}', 'GradeController', 'edit');
$router->post('/grades/delete/{id}', 'GradeController', 'delete');

// Відвідуваність
$router->get('/attendance', 'AttendanceController', 'index');
$router->get('/attendance/create', 'AttendanceController', 'create');
$router->post('/attendance/create', 'AttendanceController', 'create');
$router->get('/attendance/edit/{id}', 'AttendanceController', 'edit');
$router->post('/attendance/edit/{id}', 'AttendanceController', 'edit');
$router->post('/attendance/delete/{id}', 'AttendanceController', 'delete');

// Класи
$router->get('/classes', 'ClassController', 'index');
$router->get('/classes/create', 'ClassController', 'create');
$router->post('/classes/create', 'ClassController', 'create');
$router->get('/classes/edit/{id}', 'ClassController', 'edit');
$router->post('/classes/edit/{id}', 'ClassController', 'edit');
$router->post('/classes/delete/{id}', 'ClassController', 'delete');

// Користувачі
$router->get('/users', 'UserController', 'index');
$router->get('/users/create', 'UserController', 'create');
$router->post('/users/create', 'UserController', 'create');
$router->get('/users/edit/{id}', 'UserController', 'edit');
$router->post('/users/edit/{id}', 'UserController', 'edit');
$router->post('/users/delete/{id}', 'UserController', 'delete');

// Обробка маршруту
$router->dispatch();
