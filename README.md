# 📚 Класний журнал - Система управління навчальним процесом

Повноцінний fullstack веб-додаток для управління оцінками, відвідуванням та предметами у навчальних закладах.

## 📋 Опис проєкту

**Класний журнал** - це система управління навчальним процесом, яка дозволяє:
- Керувати учнями, предметами та класами
- Виставляти та відслідковувати оцінки
- Вести облік відвідуваності
- Фільтрувати та шукати дані
- Переглядати статистику

## 🛠 Технологічний стек

- **Backend:** PHP 8.2+ (чистий PHP з MVC-архітектурою)
- **База даних:** MySQL 8.0
- **Адміністрування БД:** phpMyAdmin
- **Веб-сервер:** Nginx
- **Контейнеризація:** Docker + Docker Compose

## ✨ Основні можливості

### Ролі користувачів

1. **Адміністратор (admin)**
   - Повне управління всіма даними
   - CRUD операції для користувачів, предметів, учнів, оцінок, відвідуваності
   - Управління класами та групами
   - Доступ до всієї статистики

2. **Вчитель (teacher)**
   - CRUD операції для оцінок та відвідуваності своїх предметів
   - Перегляд списку учнів у своїх класах
   - Перегляд статистики по своїх предметах

### Функціональність

- ✅ Аутентифікація та авторизація (email + пароль)
- ✅ Хешування паролів (password_hash / password_verify)
- ✅ Захист від CSRF атак
- ✅ Захист від SQL ін'єкцій (підготовлені запити PDO)
- ✅ Захист від XSS (htmlspecialchars)
- ✅ CRUD операції для всіх сутностей
- ✅ Фільтрація та пошук даних
- ✅ Темна/Світла тема з перемикачем
- ✅ Адаптивний дизайн (mobile-first)
- ✅ Flash-повідомлення (успіх, помилка)
- ✅ Модальні підтвердження видалення

## 📦 Вимоги

- Docker (версія 20.10+)
- Docker Compose (версія 2.0+)
- Git

## 🚀 Встановлення та запуск

### 1. Клонування репозиторію

```bash
git clone https://github.com/plamagnum/class_magazine.git
cd class_magazine
```

### 2. Налаштування середовища

Скопіюйте файл `.env.example` в `.env`:

```bash
cp .env.example .env
```

Файл `.env` містить налаштування бази даних та додатку. За замовчуванням налаштування підходять для локального запуску.

### 3. Запуск Docker контейнерів

```bash
docker-compose up -d --build
```

Ця команда:
- Збере Docker образи
- Створить контейнери для Nginx, PHP-FPM, MySQL та phpMyAdmin
- Ініціалізує базу даних з тестовими даними
- Запустить всі сервіси

### 4. Перевірка роботи

Дочекайтеся завершення запуску контейнерів (близько 30-60 секунд) та відкрийте у браузері:

- **Додаток:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081

## 🔑 Тестові облікові записи

### Адміністратор
- **Email:** admin@school.com
- **Пароль:** password123

### Вчителі
- **Email:** ivanova@school.com | **Пароль:** password123
- **Email:** petrenko@school.com | **Пароль:** password123
- **Email:** kovalenko@school.com | **Пароль:** password123

## 📁 Структура проєкту

```
class_magazine/
├── docker/                      # Docker конфігурації
│   ├── nginx/
│   │   └── default.conf        # Конфігурація Nginx
│   ├── php/
│   │   └── Dockerfile          # Dockerfile для PHP-FPM
│   └── mysql/
│       └── init.sql            # SQL скрипт ініціалізації БД
├── src/                        # Вихідний код додатку
│   ├── config/
│   │   └── database.php        # Підключення до БД
│   ├── core/                   # Ядро MVC
│   │   ├── Auth.php           # Аутентифікація
│   │   ├── Controller.php     # Базовий контролер
│   │   ├── Model.php          # Базова модель
│   │   └── Router.php         # Маршрутизація
│   ├── controllers/            # Контролери
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── StudentController.php
│   │   ├── SubjectController.php
│   │   ├── GradeController.php
│   │   ├── AttendanceController.php
│   │   ├── ClassController.php
│   │   └── UserController.php
│   ├── models/                 # Моделі
│   │   ├── User.php
│   │   ├── Student.php
│   │   ├── Subject.php
│   │   ├── Grade.php
│   │   ├── Attendance.php
│   │   └── ClassModel.php
│   ├── views/                  # Представлення
│   │   ├── layouts/
│   │   │   └── main.php       # Основний layout
│   │   ├── auth/              # Аутентифікація
│   │   ├── dashboard/         # Головна панель
│   │   ├── students/          # Учні
│   │   ├── subjects/          # Предмети
│   │   ├── grades/            # Оцінки
│   │   ├── attendance/        # Відвідуваність
│   │   ├── classes/           # Класи
│   │   └── users/             # Користувачі
│   └── public/                 # Публічна директорія
│       ├── index.php          # Entry point
│       ├── css/
│       │   └── style.css      # Стилі (з темами)
│       └── js/
│           └── app.js         # JavaScript
├── docker-compose.yml          # Docker Compose конфігурація
├── .env.example               # Приклад конфігурації
├── .gitignore
└── README.md                  # Документація
```

## 🗄️ Структура бази даних

### Таблиці

1. **users** - Користувачі системи (адміністратори та вчителі)
2. **classes** - Класи/групи учнів
3. **subjects** - Навчальні предмети
4. **students** - Учні/студенти
5. **grades** - Оцінки учнів (1-12 бальна система)
6. **attendance** - Відвідуваність учнів

### Діаграма зв'язків

```
users (1) ----< (*) subjects
classes (1) ----< (*) students
students (1) ----< (*) grades
subjects (1) ----< (*) grades
students (1) ----< (*) attendance
subjects (1) ----< (*) attendance
```

## 🎨 UI/UX Features

### Темна/Світла тема
- Перемикач у навігаційній панелі
- Збереження вибору в localStorage
- Плавна анімація переходу між темами

### Адаптивний дизайн
- **Mobile** (<768px): Бургер-меню, стековий layout
- **Tablet** (768-1024px): Оптимізований вигляд таблиць
- **Desktop** (>1024px): Повна функціональність з sidebar

### Доступність
- Мінімальний розмір інтерактивних елементів 44px
- Підтримка клавіатурної навігації
- Високий контраст тексту
- Font Awesome іконки для візуальних підказок

## 🛡️ Безпека

- **Хешування паролів:** password_hash() з bcrypt
- **CSRF захист:** Токени у формах
- **SQL ін'єкції:** PDO підготовлені запити
- **XSS захист:** htmlspecialchars() на виводі
- **Сесії:** PHP sessions з HttpOnly cookies
- **Валідація:** Перевірка всіх вхідних даних

## 🔧 Управління контейнерами

### Зупинка контейнерів
```bash
docker-compose stop
```

### Запуск існуючих контейнерів
```bash
docker-compose start
```

### Перегляд логів
```bash
docker-compose logs -f
```

### Видалення контейнерів та даних
```bash
docker-compose down -v
```

### Перезбудова після змін
```bash
docker-compose down
docker-compose up -d --build
```

## 📊 Маршрути (Routes)

### Аутентифікація
- `GET/POST /auth/login` - Вхід в систему
- `GET/POST /auth/register` - Реєстрація
- `GET /auth/logout` - Вихід

### Головна панель
- `GET /` або `/dashboard` - Головна сторінка зі статистикою

### Учні
- `GET /students` - Список учнів
- `GET/POST /students/create` - Створення учня
- `GET/POST /students/edit/{id}` - Редагування учня
- `POST /students/delete/{id}` - Видалення учня

### Предмети
- `GET /subjects` - Список предметів
- `GET/POST /subjects/create` - Створення предмету
- `GET/POST /subjects/edit/{id}` - Редагування предмету
- `POST /subjects/delete/{id}` - Видалення предмету

### Оцінки
- `GET /grades` - Список оцінок з фільтрами
- `GET/POST /grades/create` - Додавання оцінки
- `GET/POST /grades/edit/{id}` - Редагування оцінки
- `POST /grades/delete/{id}` - Видалення оцінки

### Відвідуваність
- `GET /attendance` - Список відвідуваності з фільтрами
- `GET/POST /attendance/create` - Додавання запису
- `GET/POST /attendance/edit/{id}` - Редагування запису
- `POST /attendance/delete/{id}` - Видалення запису

### Класи
- `GET /classes` - Список класів
- `GET/POST /classes/create` - Створення класу (тільки admin)
- `GET/POST /classes/edit/{id}` - Редагування класу (тільки admin)
- `POST /classes/delete/{id}` - Видалення класу (тільки admin)

### Користувачі (тільки admin)
- `GET /users` - Список користувачів
- `GET/POST /users/create` - Створення користувача
- `GET/POST /users/edit/{id}` - Редагування користувача
- `POST /users/delete/{id}` - Видалення користувача

## 🐛 Відомі обмеження

- Пагінація не реалізована (всі записи на одній сторінці)
- Експорт даних (PDF, Excel) не реалізований
- Email повідомлення не налаштовані
- API для мобільного додатку відсутній

## 🤝 Внесок у розробку

Якщо ви хочете зробити внесок у проєкт:

1. Fork проєкту
2. Створіть feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit зміни (`git commit -m 'Add some AmazingFeature'`)
4. Push до branch (`git push origin feature/AmazingFeature`)
5. Відкрийте Pull Request

## 📝 Ліцензія

Цей проєкт розповсюджується під ліцензією MIT.

## 📧 Контакти

Plamagnum - [@plamagnum](https://github.com/plamagnum)

Project Link: [https://github.com/plamagnum/class_magazine](https://github.com/plamagnum/class_magazine)

---

**Примітка:** Цей проєкт створено виключно в навчальних цілях як демонстрація fullstack веб-розробки з використанням PHP, MySQL, Docker та чистої MVC архітектури без фреймворків.
