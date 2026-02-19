<?php
/**
 * Контролер оцінок
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Subject.php';

class GradeController extends Controller {
    private $model;
    private $studentModel;
    private $subjectModel;

    public function __construct() {
        $this->model = new Grade();
        $this->studentModel = new Student();
        $this->subjectModel = new Subject();
    }

    /**
     * Список оцінок
     */
    public function index() {
        $this->requireAuth();

        $filters = [
            'student_id' => $_GET['student_id'] ?? '',
            'subject_id' => $_GET['subject_id'] ?? '',
            'type' => $_GET['type'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];

        $grades = $this->model->filter($filters);

        $students = $this->studentModel->getAll();
        if (Auth::isAdmin()) {
            $subjects = $this->subjectModel->getAll();
        } else {
            $subjects = $this->subjectModel->getByTeacher(Auth::id());
        }

        $this->view('grades/index', [
            'title' => 'Оцінки',
            'grades' => $grades,
            'students' => $students,
            'subjects' => $subjects,
            'filters' => $filters
        ]);
    }

    /**
     * Створення оцінки
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
            $data = [
                'student_id' => $_POST['student_id'] ?? '',
                'subject_id' => $_POST['subject_id'] ?? '',
                'grade' => $_POST['grade'] ?? '',
                'type' => $_POST['type'] ?? 'classwork',
                'comment' => $_POST['comment'] ?? '',
                'date' => $_POST['date'] ?? date('Y-m-d')
            ];

            // Валідація
            if (empty($data['student_id']) || empty($data['subject_id']) || empty($data['grade'])) {
                $this->setFlash('error', 'Всі обов\'язкові поля повинні бути заповнені');
            } elseif ($data['grade'] < 1 || $data['grade'] > 12) {
                $this->setFlash('error', 'Оцінка має бути від 1 до 12');
            } else {
                $this->model->create($data);
                $this->setFlash('success', 'Оцінку успішно додано');
                $this->redirect('/grades');
            }
        }

        $this->view('grades/create', [
            'title' => 'Додати оцінку',
            'students' => $students,
            'subjects' => $subjects,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування оцінки
     */
    public function edit($id) {
        $this->requireAuth();

        $grade = $this->model->getById($id);
        if (!$grade) {
            $this->setFlash('error', 'Оцінку не знайдено');
            $this->redirect('/grades');
        }

        $students = $this->studentModel->getAll();
        if (Auth::isAdmin()) {
            $subjects = $this->subjectModel->getAll();
        } else {
            $subjects = $this->subjectModel->getByTeacher(Auth::id());
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id' => $_POST['student_id'] ?? '',
                'subject_id' => $_POST['subject_id'] ?? '',
                'grade' => $_POST['grade'] ?? '',
                'type' => $_POST['type'] ?? 'classwork',
                'comment' => $_POST['comment'] ?? '',
                'date' => $_POST['date'] ?? date('Y-m-d')
            ];

            if (empty($data['student_id']) || empty($data['subject_id']) || empty($data['grade'])) {
                $this->setFlash('error', 'Всі обов\'язкові поля повинні бути заповнені');
            } elseif ($data['grade'] < 1 || $data['grade'] > 12) {
                $this->setFlash('error', 'Оцінка має бути від 1 до 12');
            } else {
                $this->model->update($id, $data);
                $this->setFlash('success', 'Оцінку успішно оновлено');
                $this->redirect('/grades');
            }
        }

        $this->view('grades/edit', [
            'title' => 'Редагувати оцінку',
            'grade' => $grade,
            'students' => $students,
            'subjects' => $subjects,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення оцінки
     */
    public function delete($id) {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
            $this->setFlash('success', 'Оцінку успішно видалено');
        }

        $this->redirect('/grades');
    }
}
