<?php
/**
 * Клас для роботи з аутентифікацією
 */

class Auth {
    /**
     * Авторизація користувача
     */
    public static function login($email, $password) {
        $db = getDB();
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }

        return false;
    }

    /**
     * Реєстрація користувача
     */
    public static function register($name, $email, $password, $role = 'teacher') {
        $db = getDB();
        
        // Перевірка чи email вже існує
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            return false;
        }

        // Створення користувача
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$name, $email, $passwordHash, $role]);
    }

    /**
     * Вихід користувача
     */
    public static function logout() {
        session_destroy();
    }

    /**
     * Перевірка чи користувач авторизований
     */
    public static function check() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Отримати ID поточного користувача
     */
    public static function id() {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Отримати дані поточного користувача
     */
    public static function user() {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];
    }

    /**
     * Перевірка ролі користувача
     */
    public static function hasRole($role) {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
    }

    /**
     * Перевірка чи користувач є адміністратором
     */
    public static function isAdmin() {
        return self::hasRole('admin');
    }

    /**
     * Перевірка чи користувач є вчителем
     */
    public static function isTeacher() {
        return self::hasRole('teacher');
    }
}
