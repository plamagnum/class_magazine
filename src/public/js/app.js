/**
 * JavaScript для Class Magazine
 */

// Ініціалізація при завантаженні сторінки
document.addEventListener('DOMContentLoaded', function() {
    // Завантаження теми з localStorage
    loadTheme();
    
    // Ініціалізація обробників подій
    initThemeToggle();
    initBurgerMenu();
    initFlashMessages();
});

/**
 * Завантаження теми
 */
function loadTheme() {
    const theme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
    updateThemeIcon(theme);
}

/**
 * Перемикач теми
 */
function initThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }
}

/**
 * Оновлення іконки теми
 */
function updateThemeIcon(theme) {
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const icon = themeToggle.querySelector('i');
        if (icon) {
            icon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }
    }
}

/**
 * Бургер-меню
 */
function initBurgerMenu() {
    const burgerMenu = document.getElementById('burgerMenu');
    const sidebar = document.getElementById('sidebar');
    
    if (burgerMenu && sidebar) {
        burgerMenu.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Закриття меню при кліку поза ним
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !burgerMenu.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    }
}

/**
 * Flash повідомлення
 */
function initFlashMessages() {
    const flashMessage = document.getElementById('flashMessage');
    if (flashMessage) {
        // Автоматичне приховування через 5 секунд
        setTimeout(function() {
            flashMessage.style.opacity = '0';
            setTimeout(function() {
                flashMessage.remove();
            }, 300);
        }, 5000);
    }
}

/**
 * Підтвердження видалення
 */
function confirmDelete(message) {
    return confirm(message || 'Ви впевнені, що хочете видалити?');
}

/**
 * Валідація форми
 */
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(event) {
            const inputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            inputs.forEach(function(input) {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Будь ласка, заповніть всі обов\'язкові поля');
            }
        });
    }
}

/**
 * Фільтри - автоматична відправка форми
 */
document.querySelectorAll('.filter-select').forEach(function(select) {
    select.addEventListener('change', function() {
        const form = this.closest('form');
        if (form) {
            form.submit();
        }
    });
});

/**
 * Пошук з debounce
 */
function setupSearchDebounce(inputId, delay = 500) {
    const input = document.getElementById(inputId);
    if (input) {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                const form = input.closest('form');
                if (form) {
                    form.submit();
                }
            }, delay);
        });
    }
}

/**
 * Допоміжні функції
 */

// Форматування дати
function formatDate(date) {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}.${month}.${year}`;
}

// Показати/приховати елемент
function toggleElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = element.style.display === 'none' ? 'block' : 'none';
    }
}

// Додавання класу з анімацією
function animateElement(element, animationClass, duration = 1000) {
    element.classList.add(animationClass);
    setTimeout(function() {
        element.classList.remove(animationClass);
    }, duration);
}
