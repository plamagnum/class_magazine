<div class="page-header">
    <h1><i class="fas fa-star"></i> Оцінки</h1>
    <a href="/grades/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Додати оцінку
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/grades" class="search-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="student_id">Учень</label>
                    <select id="student_id" name="student_id">
                        <option value="">Всі учні</option>
                        <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= ($filters['student_id'] ?? '') == $student['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['last_name'] . ' ' . $student['first_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_id">Предмет</label>
                    <select id="subject_id" name="subject_id">
                        <option value="">Всі предмети</option>
                        <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>" <?= ($filters['subject_id'] ?? '') == $subject['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subject['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Тип</label>
                    <select id="type" name="type">
                        <option value="">Всі типи</option>
                        <option value="homework" <?= ($filters['type'] ?? '') == 'homework' ? 'selected' : '' ?>>Домашнє завдання</option>
                        <option value="classwork" <?= ($filters['type'] ?? '') == 'classwork' ? 'selected' : '' ?>>Класна робота</option>
                        <option value="test" <?= ($filters['type'] ?? '') == 'test' ? 'selected' : '' ?>>Тест</option>
                        <option value="exam" <?= ($filters['type'] ?? '') == 'exam' ? 'selected' : '' ?>>Екзамен</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date_from">Дата від</label>
                    <input type="date" id="date_from" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="date_to">Дата до</label>
                    <input type="date" id="date_to" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
                </div>
            </div>

            <div class="search-input-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Фільтрувати
                </button>
                <a href="/grades" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
            </div>
        </form>

        <?php if (empty($grades)): ?>
            <p class="no-data">Оцінок не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Учень</th>
                            <th>Предмет</th>
                            <th>Оцінка</th>
                            <th>Тип</th>
                            <th>Коментар</th>
                            <th>Дата</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?= $grade['id'] ?></td>
                            <td><?= htmlspecialchars($grade['student_name']) ?></td>
                            <td><?= htmlspecialchars($grade['subject_name']) ?></td>
                            <td>
                                <span class="grade-badge grade-<?= $grade['grade'] ?>">
                                    <?= $grade['grade'] ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($grade['type']) ?></td>
                            <td><?= htmlspecialchars($grade['comment'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($grade['date']) ?></td>
                            <td class="actions">
                                <a href="/grades/edit/<?= $grade['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <form method="POST" action="/grades/delete/<?= $grade['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цю оцінку?')">
                                    <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Видалити
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
