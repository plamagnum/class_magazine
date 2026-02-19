<?php
/**
 * Базовий клас контролера
 */

class Controller {
    /**
     * Відобразити view
     */
    protected function view($viewPath, $data = []) {
        extract($data);
        
        ob_start();
        require __DIR__ . '/../views/' . $viewPath . '.php';
        $content = ob_get_clean();
        
        // Використовуємо layout
        require __DIR__ . '/../views/layouts/main.php';
    }

    /**
     * Редірект
     */
    protected function redirect($path) {
        header("Location: " . $path);
        exit;
    }

    /**
     * JSON відповідь
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Встановити flash повідомлення
     */
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Отримати flash повідомлення
     */
    protected function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Генерація CSRF токену
     */
    protected function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Валідація CSRF токену
     */
    protected function validateCsrfToken() {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
            $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }
    }

    /**
     * Перевірка авторизації
     */
    protected function requireAuth() {
        if (!Auth::check()) {
            $this->redirect('/auth/login');
        }
    }

    /**
     * Перевірка ролі
     */
    protected function requireRole($role) {
        $this->requireAuth();
        if (!Auth::hasRole($role)) {
            $this->setFlash('error', 'У вас немає доступу до цієї сторінки');
            $this->redirect('/dashboard');
        }
    }
}
