<?php
/**
 * Контролер користувачів
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    /**
     * Список користувачів
     */
    public function index() {
        $this->requireAuth();
        $this->requireRole('admin');

        $users = $this->model->getAll('name', 'ASC');

        $this->view('users/index', [
            'title' => 'Користувачі',
            'users' => $users
        ]);
    }

    /**
     * Створення користувача
     */
    public function create() {
        $this->requireAuth();
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'teacher';

            if (empty($name) || empty($email) || empty($password)) {
                $this->setFlash('error', 'Всі поля обов\'язкові');
            } elseif (strlen($password) < 6) {
                $this->setFlash('error', 'Пароль повинен містити мінімум 6 символів');
            } else {
                $this->model->createUser($name, $email, $password, $role);
                $this->setFlash('success', 'Користувача успішно створено');
                $this->redirect('/users');
            }
        }

        $this->view('users/create', [
            'title' => 'Додати користувача',
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування користувача
     */
    public function edit($id) {
        $this->requireAuth();
        $this->requireRole('admin');

        $user = $this->model->getById($id);
        if (!$user) {
            $this->setFlash('error', 'Користувача не знайдено');
            $this->redirect('/users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'role' => $_POST['role'] ?? 'teacher'
            ];

            if (empty($data['name']) || empty($data['email'])) {
                $this->setFlash('error', 'Ім\'я та email обов\'язкові');
            } else {
                $this->model->update($id, $data);
                
                // Оновлення пароля, якщо вказано
                if (!empty($_POST['password'])) {
                    $this->model->updatePassword($id, $_POST['password']);
                }
                
                $this->setFlash('success', 'Користувача успішно оновлено');
                $this->redirect('/users');
            }
        }

        $this->view('users/edit', [
            'title' => 'Редагувати користувача',
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення користувача
     */
    public function delete($id) {
        $this->requireAuth();
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            // Не можна видалити себе
            if ($id == Auth::id()) {
                $this->setFlash('error', 'Ви не можете видалити себе');
            } else {
                $this->model->delete($id);
                $this->setFlash('success', 'Користувача успішно видалено');
            }
        }

        $this->redirect('/users');
    }
}
