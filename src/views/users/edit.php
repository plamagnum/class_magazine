<div class="page-header">
    <h1><i class="fas fa-edit"></i> Редагувати користувача</h1>
    <a href="/users" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/users/edit/<?= $user['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="name">Ім'я *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Новий пароль</label>
                <input type="password" id="password" name="password" minlength="6">
                <small>Залиште порожнім, якщо не хочете змінювати пароль. Мінімум 6 символів</small>
            </div>

            <div class="form-group">
                <label for="password_confirm">Підтвердження нового пароля</label>
                <input type="password" id="password_confirm" name="password_confirm" minlength="6">
            </div>

            <div class="form-group">
                <label for="role">Роль *</label>
                <select id="role" name="role" required>
                    <option value="">Виберіть роль</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Адміністратор</option>
                    <option value="teacher" <?= $user['role'] == 'teacher' ? 'selected' : '' ?>>Викладач</option>
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
