<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Класний журнал') ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php if (Auth::check()): ?>
    <!-- Навігація -->
    <nav class="navbar">
        <div class="nav-container">
            <button class="burger-menu" id="burgerMenu">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="nav-brand">📚 Класний журнал</h1>
            <div class="nav-right">
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <span class="user-name"><?= htmlspecialchars(Auth::user()['name']) ?></span>
                <a href="/auth/logout" class="btn btn-logout">Вихід</a>
            </div>
        </div>
    </nav>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <ul class="sidebar-menu">
                <li>
                    <a href="/dashboard" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') === 0 || $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">
                        <i class="fas fa-home"></i>
                        <span>Головна</span>
                    </a>
                </li>
                <li>
                    <a href="/students" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/students') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-user-graduate"></i>
                        <span>Учні</span>
                    </a>
                </li>
                <li>
                    <a href="/subjects" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/subjects') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-book"></i>
                        <span>Предмети</span>
                    </a>
                </li>
                <li>
                    <a href="/grades" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/grades') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-star"></i>
                        <span>Оцінки</span>
                    </a>
                </li>
                <li>
                    <a href="/attendance" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/attendance') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Відвідуваність</span>
                    </a>
                </li>
                <li>
                    <a href="/classes" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/classes') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-school"></i>
                        <span>Класи</span>
                    </a>
                </li>
                <?php if (Auth::isAdmin()): ?>
                <li>
                    <a href="/users" class="menu-item <?= strpos($_SERVER['REQUEST_URI'], '/users') === 0 ? 'active' : '' ?>">
                        <i class="fas fa-users"></i>
                        <span>Користувачі</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </aside>

        <!-- Main content -->
        <main class="main-content">
            <?php 
            $flash = $this->getFlash();
            if ($flash): 
            ?>
            <div class="alert alert-<?= $flash['type'] ?>" id="flashMessage">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>
    <?php else: ?>
    <!-- Для неавторизованих користувачів -->
    <div class="auth-layout">
        <?php 
        $flash = $this->getFlash();
        if ($flash): 
        ?>
        <div class="alert alert-<?= $flash['type'] ?>" id="flashMessage">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
        <?php endif; ?>
        
        <?= $content ?>
    </div>
    <?php endif; ?>

    <script src="/js/app.js"></script>
</body>
</html>
