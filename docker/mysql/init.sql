-- Створення бази даних
CREATE DATABASE IF NOT EXISTS class_magazine CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE class_magazine;

-- Таблиця користувачів
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher') DEFAULT 'teacher',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Таблиця класів
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблиця предметів
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Таблиця учнів
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    patronymic VARCHAR(100),
    class_id INT,
    date_of_birth DATE,
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);

-- Таблиця оцінок
CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade INT NOT NULL CHECK (grade BETWEEN 1 AND 12),
    type ENUM('control', 'homework', 'classwork', 'exam') DEFAULT 'classwork',
    comment TEXT,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Таблиця відвідуваності
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('present', 'absent', 'late') DEFAULT 'present',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Вставка тестових даних

-- Користувачі (пароль для всіх: password123)
INSERT INTO users (name, email, password_hash, role) VALUES
('Адміністратор Системи', 'admin@school.com', '$2y$10$Vwtu5kl72xPr94RWOR/FTuZvc0DoLQGyfrWcNTg4.1MgI0.jVLGiW', 'admin'),
('Іванова Олена Петрівна', 'ivanova@school.com', '$2y$10$Vwtu5kl72xPr94RWOR/FTuZvc0DoLQGyfrWcNTg4.1MgI0.jVLGiW', 'teacher'),
('Петренко Андрій Васильович', 'petrenko@school.com', '$2y$10$Vwtu5kl72xPr94RWOR/FTuZvc0DoLQGyfrWcNTg4.1MgI0.jVLGiW', 'teacher'),
('Коваленко Марія Іванівна', 'kovalenko@school.com', '$2y$10$Vwtu5kl72xPr94RWOR/FTuZvc0DoLQGyfrWcNTg4.1MgI0.jVLGiW', 'teacher');

-- Класи
INSERT INTO classes (name, year) VALUES
('10-А', 2024),
('10-Б', 2024),
('11-А', 2024),
('11-Б', 2024);

-- Предмети
INSERT INTO subjects (name, description, teacher_id) VALUES
('Математика', 'Алгебра та геометрія', 2),
('Українська мова', 'Мова та література', 3),
('Англійська мова', 'Іноземна мова', 4),
('Фізика', 'Загальна фізика', 2),
('Інформатика', 'Програмування та алгоритми', 3);

-- Учні
INSERT INTO students (first_name, last_name, patronymic, class_id, date_of_birth, email) VALUES
('Іван', 'Шевченко', 'Олександрович', 1, '2007-05-15', 'ivan.shevchenko@example.com'),
('Марія', 'Коваль', 'Петрівна', 1, '2007-08-20', 'maria.koval@example.com'),
('Олександр', 'Мельник', 'Іванович', 1, '2007-03-10', 'oleksandr.melnyk@example.com'),
('Анна', 'Бондар', 'Василівна', 1, '2007-11-25', 'anna.bondar@example.com'),
('Дмитро', 'Ковальчук', 'Сергійович', 2, '2007-02-14', 'dmytro.kovalchuk@example.com'),
('Олена', 'Савченко', 'Миколаївна', 2, '2007-09-30', 'olena.savchenko@example.com'),
('Максим', 'Гриценко', 'Андрійович', 2, '2007-06-18', 'maksym.hrytsenko@example.com'),
('Катерина', 'Литвин', 'Олегівна', 2, '2007-12-05', 'kateryna.lytvyn@example.com'),
('Артем', 'Кравченко', 'Віталійович', 3, '2006-04-22', 'artem.kravchenko@example.com'),
('Софія', 'Павленко', 'Ігорівна', 3, '2006-07-17', 'sofia.pavlenko@example.com');

-- Оцінки
INSERT INTO grades (student_id, subject_id, grade, type, comment, date) VALUES
(1, 1, 11, 'classwork', 'Відмінна робота на уроці', '2024-09-15'),
(1, 1, 10, 'homework', 'Домашнє завдання виконано якісно', '2024-09-18'),
(1, 2, 12, 'control', 'Контрольна робота - відмінно', '2024-09-20'),
(2, 1, 9, 'classwork', 'Добре', '2024-09-15'),
(2, 2, 10, 'homework', 'Якісна робота', '2024-09-18'),
(3, 1, 8, 'classwork', 'Задовільно', '2024-09-15'),
(3, 3, 11, 'exam', 'Іспит складено на відмінно', '2024-09-25'),
(4, 1, 12, 'control', 'Відмінний результат', '2024-09-20'),
(5, 2, 10, 'classwork', 'Дуже добре', '2024-09-15'),
(6, 3, 9, 'homework', 'Добре виконано', '2024-09-18');

-- Відвідуваність
INSERT INTO attendance (student_id, subject_id, date, status) VALUES
(1, 1, '2024-09-15', 'present'),
(1, 1, '2024-09-16', 'present'),
(1, 2, '2024-09-15', 'present'),
(2, 1, '2024-09-15', 'present'),
(2, 2, '2024-09-15', 'late'),
(3, 1, '2024-09-15', 'absent'),
(3, 3, '2024-09-15', 'present'),
(4, 1, '2024-09-15', 'present'),
(5, 2, '2024-09-15', 'present'),
(6, 3, '2024-09-15', 'late'),
(7, 1, '2024-09-15', 'present'),
(8, 2, '2024-09-15', 'present'),
(9, 1, '2024-09-15', 'present'),
(10, 2, '2024-09-15', 'present');
