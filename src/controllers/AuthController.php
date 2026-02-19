<?php
/**
 * Контролер аутентифікації
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';

class AuthController extends Controller {
    /**
     * Сторінка входу
     */
    public function login() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (Auth::login($email, $password)) {
                $this->setFlash('success', 'Ви успішно увійшли в систему');
                $this->redirect('/dashboard');
            } else {
                $this->setFlash('error', 'Невірний email або пароль');
            }
        }

        $this->view('auth/login', [
            'title' => 'Вхід',
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Сторінка реєстрації
     */
    public function register() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            // Валідація
            if (empty($name) || empty($email) || empty($password)) {
                $this->setFlash('error', 'Всі поля обов\'язкові для заповнення');
            } elseif ($password !== $passwordConfirm) {
                $this->setFlash('error', 'Паролі не співпадають');
            } elseif (strlen($password) < 6) {
                $this->setFlash('error', 'Пароль повинен містити мінімум 6 символів');
            } elseif (Auth::register($name, $email, $password)) {
                $this->setFlash('success', 'Реєстрація успішна. Тепер ви можете увійти');
                $this->redirect('/auth/login');
            } else {
                $this->setFlash('error', 'Користувач з таким email вже існує');
            }
        }

        $this->view('auth/register', [
            'title' => 'Реєстрація',
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Вихід
     */
    public function logout() {
        Auth::logout();
        $this->redirect('/auth/login');
    }
}
