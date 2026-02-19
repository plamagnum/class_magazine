<?php
/**
 * Контролер учнів
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/ClassModel.php';

class StudentController extends Controller {
    private $model;
    private $classModel;

    public function __construct() {
        $this->model = new Student();
        $this->classModel = new ClassModel();
    }

    /**
     * Список учнів
     */
    public function index() {
        $this->requireAuth();

        $search = $_GET['search'] ?? '';
        
        if ($search) {
            $students = $this->model->search($search);
        } else {
            $students = $this->model->getAllWithClass();
        }

        $this->view('students/index', [
            'title' => 'Учні',
            'students' => $students,
            'search' => $search
        ]);
    }

    /**
     * Створення учня
     */
    public function create() {
        $this->requireAuth();

        $classes = $this->classModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'patronymic' => $_POST['patronymic'] ?? '',
                'class_id' => $_POST['class_id'] ?? null,
                'date_of_birth' => $_POST['date_of_birth'] ?? null,
                'email' => $_POST['email'] ?? ''
            ];

            if (empty($data['first_name']) || empty($data['last_name'])) {
                $this->setFlash('error', 'Ім\'я та прізвище обов\'язкові');
            } else {
                $this->model->create($data);
                $this->setFlash('success', 'Учня успішно створено');
                $this->redirect('/students');
            }
        }

        $this->view('students/create', [
            'title' => 'Додати учня',
            'classes' => $classes,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування учня
     */
    public function edit($id) {
        $this->requireAuth();

        $student = $this->model->getById($id);
        if (!$student) {
            $this->setFlash('error', 'Учня не знайдено');
            $this->redirect('/students');
        }

        $classes = $this->classModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'patronymic' => $_POST['patronymic'] ?? '',
                'class_id' => $_POST['class_id'] ?? null,
                'date_of_birth' => $_POST['date_of_birth'] ?? null,
                'email' => $_POST['email'] ?? ''
            ];

            if (empty($data['first_name']) || empty($data['last_name'])) {
                $this->setFlash('error', 'Ім\'я та прізвище обов\'язкові');
            } else {
                $this->model->update($id, $data);
                $this->setFlash('success', 'Учня успішно оновлено');
                $this->redirect('/students');
            }
        }

        $this->view('students/edit', [
            'title' => 'Редагувати учня',
            'student' => $student,
            'classes' => $classes,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення учня
     */
    public function delete($id) {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $this->model->delete($id);
            $this->setFlash('success', 'Учня успішно видалено');
        }

        $this->redirect('/students');
    }
}
