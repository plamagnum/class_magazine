<?php
/**
 * Модель оцінки
 */

require_once __DIR__ . '/../core/Model.php';

class Grade extends Model {
    protected $table = 'grades';

    /**
     * Отримати всі оцінки з інформацією про учня та предмет
     */
    public function getAllWithDetails() {
        $sql = "SELECT g.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       sub.name as subject_name,
                       c.name as class_name
                FROM {$this->table} g 
                LEFT JOIN students s ON g.student_id = s.id 
                LEFT JOIN subjects sub ON g.subject_id = sub.id
                LEFT JOIN classes c ON s.class_id = c.id
                ORDER BY g.date DESC, s.last_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати оцінки учня
     */
    public function getByStudent($studentId) {
        $sql = "SELECT g.*, sub.name as subject_name 
                FROM {$this->table} g 
                LEFT JOIN subjects sub ON g.subject_id = sub.id 
                WHERE g.student_id = ? 
                ORDER BY g.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    /**
     * Отримати оцінки за предметом
     */
    public function getBySubject($subjectId) {
        $sql = "SELECT g.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       c.name as class_name
                FROM {$this->table} g 
                LEFT JOIN students s ON g.student_id = s.id 
                LEFT JOIN classes c ON s.class_id = c.id
                WHERE g.subject_id = ? 
                ORDER BY g.date DESC, s.last_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll();
    }

    /**
     * Фільтрація оцінок
     */
    public function filter($filters = []) {
        $sql = "SELECT g.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       sub.name as subject_name,
                       c.name as class_name
                FROM {$this->table} g 
                LEFT JOIN students s ON g.student_id = s.id 
                LEFT JOIN subjects sub ON g.subject_id = sub.id
                LEFT JOIN classes c ON s.class_id = c.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['student_id'])) {
            $sql .= " AND g.student_id = ?";
            $params[] = $filters['student_id'];
        }
        
        if (!empty($filters['subject_id'])) {
            $sql .= " AND g.subject_id = ?";
            $params[] = $filters['subject_id'];
        }
        
        if (!empty($filters['type'])) {
            $sql .= " AND g.type = ?";
            $params[] = $filters['type'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND g.date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND g.date <= ?";
            $params[] = $filters['date_to'];
        }
        
        $sql .= " ORDER BY g.date DESC, s.last_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Отримати середній бал учня
     */
    public function getAverageByStudent($studentId) {
        $sql = "SELECT AVG(grade) as average FROM {$this->table} WHERE student_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId]);
        $result = $stmt->fetch();
        return round($result['average'], 2);
    }

    /**
     * Отримати середній бал за предметом
     */
    public function getAverageBySubject($subjectId) {
        $sql = "SELECT AVG(grade) as average FROM {$this->table} WHERE subject_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$subjectId]);
        $result = $stmt->fetch();
        return round($result['average'], 2);
    }
}
