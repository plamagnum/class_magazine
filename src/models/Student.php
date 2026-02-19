<?php
/**
 * Модель учня
 */

require_once __DIR__ . '/../core/Model.php';

class Student extends Model {
    protected $table = 'students';

    /**
     * Отримати всіх учнів з інформацією про клас
     */
    public function getAllWithClass() {
        $sql = "SELECT s.*, c.name as class_name, c.year as class_year 
                FROM {$this->table} s 
                LEFT JOIN classes c ON s.class_id = c.id 
                ORDER BY s.last_name, s.first_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати учнів за класом
     */
    public function getByClass($classId) {
        $sql = "SELECT * FROM {$this->table} WHERE class_id = ? ORDER BY last_name, first_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$classId]);
        return $stmt->fetchAll();
    }

    /**
     * Пошук учнів
     */
    public function search($query) {
        $sql = "SELECT s.*, c.name as class_name 
                FROM {$this->table} s 
                LEFT JOIN classes c ON s.class_id = c.id 
                WHERE s.first_name LIKE ? OR s.last_name LIKE ? OR s.patronymic LIKE ? 
                ORDER BY s.last_name, s.first_name";
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$query}%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    /**
     * Отримати учня з інформацією про клас
     */
    public function getByIdWithClass($id) {
        $sql = "SELECT s.*, c.name as class_name, c.year as class_year 
                FROM {$this->table} s 
                LEFT JOIN classes c ON s.class_id = c.id 
                WHERE s.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
