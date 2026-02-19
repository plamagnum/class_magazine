<?php
/**
 * Модель предмету
 */

require_once __DIR__ . '/../core/Model.php';

class Subject extends Model {
    protected $table = 'subjects';

    /**
     * Отримати всі предмети з інформацією про вчителя
     */
    public function getAllWithTeacher() {
        $sql = "SELECT s.*, u.name as teacher_name 
                FROM {$this->table} s 
                LEFT JOIN users u ON s.teacher_id = u.id 
                ORDER BY s.name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати предмети вчителя
     */
    public function getByTeacher($teacherId) {
        $sql = "SELECT * FROM {$this->table} WHERE teacher_id = ? ORDER BY name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll();
    }

    /**
     * Отримати предмет з інформацією про вчителя
     */
    public function getByIdWithTeacher($id) {
        $sql = "SELECT s.*, u.name as teacher_name 
                FROM {$this->table} s 
                LEFT JOIN users u ON s.teacher_id = u.id 
                WHERE s.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
