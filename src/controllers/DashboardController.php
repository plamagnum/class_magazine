<?php
/**
 * Контролер головної панелі
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Attendance.php';

class DashboardController extends Controller {
    /**
     * Головна сторінка
     */
    public function index() {
        $this->requireAuth();

        $studentModel = new Student();
        $subjectModel = new Subject();
        $gradeModel = new Grade();
        $attendanceModel = new Attendance();

        $stats = [
            'total_students' => $studentModel->count(),
            'total_subjects' => $subjectModel->count(),
            'total_grades' => $gradeModel->count(),
            'total_attendance' => $attendanceModel->count()
        ];

        // Останні оцінки
        $recentGrades = $gradeModel->getAllWithDetails();
        $recentGrades = array_slice($recentGrades, 0, 10);

        // Останні записи відвідуваності
        $recentAttendance = $attendanceModel->getAllWithDetails();
        $recentAttendance = array_slice($recentAttendance, 0, 10);

        $this->view('dashboard/index', [
            'title' => 'Головна панель',
            'stats' => $stats,
            'recent_grades' => $recentGrades,
            'recent_attendance' => $recentAttendance
        ]);
    }
}
