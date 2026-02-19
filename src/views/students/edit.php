<div class="page-header">
    <h1><i class="fas fa-edit"></i> Редагувати учня</h1>
    <a href="/students" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/students/edit/<?= $student['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="last_name">Прізвище *</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="first_name">Ім'я *</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="patronymic">По батькові</label>
                <input type="text" id="patronymic" name="patronymic" value="<?= htmlspecialchars($student['patronymic'] ?? '') ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="class_id">Клас</label>
                    <select id="class_id" name="class_id">
                        <option value="">Виберіть клас</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= $student['class_id'] == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['name']) ?> (<?= $class['year'] ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Дата народження</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($student['date_of_birth'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($student['email'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Зберегти
            </button>
            <a href="/students" class="btn btn-secondary">
                <i class="fas fa-times"></i> Скасувати
            </a>
        </form>
    </div>
</div>
