<?php
/**
 * Модель користувача
 */

require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    protected $table = 'users';

    /**
     * Отримати користувача за email
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Отримати всіх вчителів
     */
    public function getTeachers() {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'teacher' ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати всіх адміністраторів
     */
    public function getAdmins() {
        $sql = "SELECT * FROM {$this->table} WHERE role = 'admin' ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Створити користувача з хешуванням пароля
     */
    public function createUser($name, $email, $password, $role = 'teacher') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ];
        return $this->create($data);
    }

    /**
     * Оновити пароль користувача
     */
    public function updatePassword($id, $newPassword) {
        $data = [
            'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];
        return $this->update($id, $data);
    }
}
