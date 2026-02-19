<?php
/**
 * Контролер предметів
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Subject.php';
require_once __DIR__ . '/../models/User.php';

class SubjectController extends Controller {
    private $model;
    private $userModel;

    public function __construct() {
        $this->model = new Subject();
        $this->userModel = new User();
    }

    /**
     * Список предметів
     */
    public function index() {
        $this->requireAuth();

        if (Auth::isAdmin()) {
            $subjects = $this->model->getAllWithTeacher();
        } else {
            $subjects = $this->model->getByTeacher(Auth::id());
        }

        $this->view('subjects/index', [
            'title' => 'Предмети',
            'subjects' => $subjects
        ]);
    }

    /**
     * Створення предмету
     */
    public function create() {
        $this->requireAuth();

        $teachers = $this->userModel->getTeachers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'teacher_id' => $_POST['teacher_id'] ?? null
            ];

            if (empty($data['name'])) {
                $this->setFlash('error', 'Назва предмету обов\'язкова');
            } else {
                $this->model->create($data);
                $this->setFlash('success', 'Предмет успішно створено');
                $this->redirect('/subjects');
            }
        }

        $this->view('subjects/create', [
            'title' => 'Додати предмет',
            'teachers' => $teachers,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування предмету
     */
    public function edit($id) {
        $this->requireAuth();

        $subject = $this->model->getById($id);
        if (!$subject) {
            $this->setFlash('error', 'Предмет не знайдено');
            $this->redirect('/subjects');
        }

        // Вчитель може редагувати лише свої предмети
        if (!Auth::isAdmin() && $subject['teacher_id'] != Auth::id()) {
            $this->setFlash('error', 'Немає доступу');
            $this->redirect('/subjects');
        }

        $teachers = $this->userModel->getTeachers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'teacher_id' => $_POST['teacher_id'] ?? null
            ];

            if (empty($data['name'])) {
                $this->setFlash('error', 'Назва предмету обов\'язкова');
            } else {
                $this->model->update($id, $data);
                $this->setFlash('success', 'Предмет успішно оновлено');
                $this->redirect('/subjects');
            }
        }

        $this->view('subjects/edit', [
            'title' => 'Редагувати предмет',
            'subject' => $subject,
            'teachers' => $teachers,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення предмету
     */
    public function delete($id) {
        $this->requireAuth();
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            $this->model->delete($id);
            $this->setFlash('success', 'Предмет успішно видалено');
        }

        $this->redirect('/subjects');
    }
}
