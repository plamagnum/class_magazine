<div class="auth-container">
    <div class="auth-card">
        <h2>Вхід до системи</h2>
        <form method="POST" action="/auth/login">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Пароль
                </label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt"></i> Увійти
            </button>
        </form>

        <p class="auth-link">
            Ще не маєте облікового запису? 
            <a href="/auth/register">Зареєструватися</a>
        </p>

        <div class="test-accounts">
            <p><strong>Тестові облікові записи:</strong></p>
            <p>Адміністратор: admin@school.com / password123</p>
            <p>Вчитель: ivanova@school.com / password123</p>
        </div>
    </div>
</div>
