<div class="page-header">
    <h1><i class="fas fa-user-plus"></i> Додати користувача</h1>
    <a href="/users" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/users/create">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="name">Ім'я *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль *</label>
                <input type="password" id="password" name="password" required minlength="6">
                <small>Мінімум 6 символів</small>
            </div>

            <div class="form-group">
                <label for="password_confirm">Підтвердження пароля *</label>
                <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
            </div>

            <div class="form-group">
                <label for="role">Роль *</label>
                <select id="role" name="role" required>
                    <option value="">Виберіть роль</option>
                    <option value="admin">Адміністратор</option>
                    <option value="teacher">Викладач</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Зберегти
            </button>
            <a href="/users" class="btn btn-secondary">
                <i class="fas fa-times"></i> Скасувати
            </a>
        </form>
    </div>
</div>
