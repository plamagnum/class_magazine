<?php
/**
 * Модель класу
 */

require_once __DIR__ . '/../core/Model.php';

class ClassModel extends Model {
    protected $table = 'classes';

    /**
     * Отримати всі класи з кількістю учнів
     */
    public function getAllWithStudentCount() {
        $sql = "SELECT c.*, COUNT(s.id) as student_count 
                FROM {$this->table} c 
                LEFT JOIN students s ON c.id = s.class_id 
                GROUP BY c.id 
                ORDER BY c.year DESC, c.name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Отримати клас з учнями
     */
    public function getWithStudents($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $class = $stmt->fetch();

        if ($class) {
            $sql = "SELECT * FROM students WHERE class_id = ? ORDER BY last_name, first_name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $class['students'] = $stmt->fetchAll();
        }

        return $class;
    }
}
