<?php
/**
 * Контролер відвідуваності
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Subject.php';

class AttendanceController extends Controller {
    private $model;
    private $studentModel;
    private $subjectModel;

    public function __construct() {
        $this->model = new Attendance();
        $this->studentModel = new Student();
        $this->subjectModel = new Subject();
    }

    /**
     * Список відвідуваності
     */
    public function index() {
        $this->requireAuth();

        $filters = [
            'student_id' => $_GET['student_id'] ?? '',
            'subject_id' => $_GET['subject_id'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];

        $attendance = $this->model->filter($filters);

        $students = $this->studentModel->getAll();
        if (Auth::isAdmin()) {
            $subjects = $this->subjectModel->getAll();
        } else {
            $subjects = $this->subjectModel->getByTeacher(Auth::id());
        }

        $this->view('attendance/index', [
            'title' => 'Відвідуваність',
            'attendance' => $attendance,
            'students' => $students,
            'subjects' => $subjects,
            'filters' => $filters
        ]);
    }

    /**
     * Створення запису відвідуваності
     */
    public function create() {
        $this->requireAuth();

        $students = $this->studentModel->getAll();
        if (Auth::isAdmin()) {
            $subjects = $this->subjectModel->getAll();
        } else {
            $subjects = $this->subjectModel->getByTeacher(Auth::id());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'student_id' => $_POST['student_id'] ?? '',
                'subject_id' => $_POST['subject_id'] ?? '',
                'status' => $_POST['status'] ?? 'present',
                'date' => $_POST['date'] ?? date('Y-m-d')
            ];

            if (empty($data['student_id']) || empty($data['subject_id'])) {
                $this->setFlash('error', 'Всі обов\'язкові поля повинні бути заповнені');
            } else {
                $this->model->create($data);
                $this->setFlash('success', 'Запис відвідуваності успішно додано');
                $this->redirect('/attendance');
            }
        }

        $this->view('attendance/create', [
            'title' => 'Додати відвідуваність',
            'students' => $students,
            'subjects' => $subjects,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування запису відвідуваності
     */
    public function edit($id) {
        $this->requireAuth();

        $attendance = $this->model->getById($id);
        if (!$attendance) {
            $this->setFlash('error', 'Запис не знайдено');
            $this->redirect('/attendance');
        }

        $students = $this->studentModel->getAll();
        if (Auth::isAdmin()) {
            $subjects = $this->subjectModel->getAll();
        } else {
            $subjects = $this->subjectModel->getByTeacher(Auth::id());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'student_id' => $_POST['student_id'] ?? '',
                'subject_id' => $_POST['subject_id'] ?? '',
                'status' => $_POST['status'] ?? 'present',
                'date' => $_POST['date'] ?? date('Y-m-d')
            ];

            if (empty($data['student_id']) || empty($data['subject_id'])) {
                $this->setFlash('error', 'Всі обов\'язкові поля повинні бути заповнені');
            } else {
                $this->model->update($id, $data);
                $this->setFlash('success', 'Запис відвідуваності успішно оновлено');
                $this->redirect('/attendance');
            }
        }

        $this->view('attendance/edit', [
            'title' => 'Редагувати відвідуваність',
            'attendance' => $attendance,
            'students' => $students,
            'subjects' => $subjects,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення запису відвідуваності
     */
    public function delete($id) {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $this->model->delete($id);
            $this->setFlash('success', 'Запис відвідуваності успішно видалено');
        }

        $this->redirect('/attendance');
    }
}
