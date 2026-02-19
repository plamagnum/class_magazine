<div class="page-header">
    <h1><i class="fas fa-edit"></i> Редагувати предмет</h1>
    <a href="/subjects" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/subjects/edit/<?= $subject['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="name">Назва *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($subject['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Опис</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($subject['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="teacher_id">Викладач</label>
                <select id="teacher_id" name="teacher_id">
                    <option value="">Виберіть викладача</option>
                    <?php foreach ($teachers as $teacher): ?>
                    <option value="<?= $teacher['id'] ?>" <?= $subject['teacher_id'] == $teacher['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($teacher['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Зберегти
            </button>
            <a href="/subjects" class="btn btn-secondary">
                <i class="fas fa-times"></i> Скасувати
            </a>
        </form>
    </div>
</div>
