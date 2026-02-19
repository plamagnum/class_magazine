<div class="auth-container">
    <div class="auth-card">
        <h2>Реєстрація</h2>
        <form method="POST" action="/auth/register">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="name">
                    <i class="fas fa-user"></i> Ім'я
                </label>
                <input type="text" id="name" name="name" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Пароль
                </label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">
                    <i class="fas fa-lock"></i> Підтвердження пароля
                </label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-user-plus"></i> Зареєструватися
            </button>
        </form>

        <p class="auth-link">
            Вже маєте обліковий запис? 
            <a href="/auth/login">Увійти</a>
        </p>
    </div>
</div>
