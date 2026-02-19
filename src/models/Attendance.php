<?php
/**
 * Модель відвідуваності
 */

require_once __DIR__ . '/../core/Model.php';

class Attendance extends Model {
    protected $table = 'attendance';

    /**
     * Отримати всі записи відвідуваності з деталями
     */
    public function getAllWithDetails() {
        $sql = "SELECT a.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       sub.name as subject_name,
                       c.name as class_name
                FROM {$this->table} a 
                LEFT JOIN students s ON a.student_id = s.id 
                LEFT JOIN subjects sub ON a.subject_id = sub.id
                LEFT JOIN classes c ON s.class_id = c.id
                ORDER BY a.date DESC, s.last_name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати відвідуваність учня
     */
    public function getByStudent($studentId) {
        $sql = "SELECT a.*, sub.name as subject_name 
                FROM {$this->table} a 
                LEFT JOIN subjects sub ON a.subject_id = sub.id 
                WHERE a.student_id = ? 
                ORDER BY a.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    /**
     * Отримати відвідуваність за предметом
     */
    public function getBySubject($subjectId) {
        $sql = "SELECT a.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       c.name as class_name
                FROM {$this->table} a 
                LEFT JOIN students s ON a.student_id = s.id 
                LEFT JOIN classes c ON s.class_id = c.id
                WHERE a.subject_id = ? 
                ORDER BY a.date DESC, s.last_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll();
    }

    /**
     * Фільтрація відвідуваності
     */
    public function filter($filters = []) {
        $sql = "SELECT a.*, 
                       CONCAT(s.last_name, ' ', s.first_name) as student_name,
                       sub.name as subject_name,
                       c.name as class_name
                FROM {$this->table} a 
                LEFT JOIN students s ON a.student_id = s.id 
                LEFT JOIN subjects sub ON a.subject_id = sub.id
                LEFT JOIN classes c ON s.class_id = c.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['student_id'])) {
            $sql .= " AND a.student_id = ?";
            $params[] = $filters['student_id'];
        }
        
        if (!empty($filters['subject_id'])) {
            $sql .= " AND a.subject_id = ?";
            $params[] = $filters['subject_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND a.date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND a.date <= ?";
            $params[] = $filters['date_to'];
        }
        
        $sql .= " ORDER BY a.date DESC, s.last_name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Статистика відвідуваності учня
     */
    public function getStatsByStudent($studentId) {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
                FROM {$this->table} 
                WHERE student_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId]);
        return $stmt->fetch();
    }

    /**
     * Перевірка чи є запис відвідуваності
     */
    public function exists($studentId, $subjectId, $date) {
        $sql = "SELECT id FROM {$this->table} WHERE student_id = ? AND subject_id = ? AND date = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$studentId, $subjectId, $date]);
        return $stmt->fetch() !== false;
    }
}
