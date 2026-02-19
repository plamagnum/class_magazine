<div class="page-header">
    <h1><i class="fas fa-edit"></i> Редагувати запис відвідуваності</h1>
    <a href="/attendance" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/attendance/edit/<?= $attendance['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="student_id">Учень *</label>
                    <select id="student_id" name="student_id" required>
                        <option value="">Виберіть учня</option>
                        <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= $attendance['student_id'] == $student['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['last_name'] . ' ' . $student['first_name'] . ' ' . ($student['patronymic'] ?? '')) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_id">Предмет *</label>
                    <select id="subject_id" name="subject_id" required>
                        <option value="">Виберіть предмет</option>
                        <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>" <?= $attendance['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subject['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Статус *</label>
                    <select id="status" name="status" required>
                        <option value="">Виберіть статус</option>
                        <option value="present" <?= $attendance['status'] == 'present' ? 'selected' : '' ?>>Присутній</option>
                        <option value="absent" <?= $attendance['status'] == 'absent' ? 'selected' : '' ?>>Відсутній</option>
                        <option value="late" <?= $attendance['status'] == 'late' ? 'selected' : '' ?>>Запізнився</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Дата *</label>
                    <input type="date" id="date" name="date" value="<?= htmlspecialchars($attendance['date']) ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Зберегти
            </button>
            <a href="/attendance" class="btn btn-secondary">
                <i class="fas fa-times"></i> Скасувати
            </a>
        </form>
    </div>
</div>
