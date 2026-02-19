<?php
/**
 * Контролер класів
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/ClassModel.php';

class ClassController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new ClassModel();
    }

    /**
     * Список класів
     */
    public function index() {
        $this->requireAuth();

        $classes = $this->model->getAllWithStudentCount();

        $this->view('classes/index', [
            'title' => 'Класи',
            'classes' => $classes
        ]);
    }

    /**
     * Створення класу
     */
    public function create() {
        $this->requireAuth();
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'year' => $_POST['year'] ?? date('Y')
            ];

            if (empty($data['name'])) {
                $this->setFlash('error', 'Назва класу обов\'язкова');
            } else {
                $this->model->create($data);
                $this->setFlash('success', 'Клас успішно створено');
                $this->redirect('/classes');
            }
        }

        $this->view('classes/create', [
            'title' => 'Додати клас',
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Редагування класу
     */
    public function edit($id) {
        $this->requireAuth();
        $this->requireRole('admin');

        $class = $this->model->getById($id);
        if (!$class) {
            $this->setFlash('error', 'Клас не знайдено');
            $this->redirect('/classes');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'year' => $_POST['year'] ?? date('Y')
            ];

            if (empty($data['name'])) {
                $this->setFlash('error', 'Назва класу обов\'язкова');
            } else {
                $this->model->update($id, $data);
                $this->setFlash('success', 'Клас успішно оновлено');
                $this->redirect('/classes');
            }
        }

        $this->view('classes/edit', [
            'title' => 'Редагувати клас',
            'class' => $class,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    /**
     * Видалення класу
     */
    public function delete($id) {
        $this->requireAuth();
        $this->requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
            $this->setFlash('success', 'Клас успішно видалено');
        }

        $this->redirect('/classes');
    }
}
