<div class="page-header">
    <h1><i class="fas fa-clipboard-check"></i> Відвідуваність</h1>
    <a href="/attendance/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Додати запис
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/attendance" class="search-form">
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
                    <label for="status">Статус</label>
                    <select id="status" name="status">
                        <option value="">Всі статуси</option>
                        <option value="present" <?= ($filters['status'] ?? '') == 'present' ? 'selected' : '' ?>>Присутній</option>
                        <option value="absent" <?= ($filters['status'] ?? '') == 'absent' ? 'selected' : '' ?>>Відсутній</option>
                        <option value="late" <?= ($filters['status'] ?? '') == 'late' ? 'selected' : '' ?>>Запізнився</option>
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
                <a href="/attendance" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
            </div>
        </form>

        <?php if (empty($attendance)): ?>
            <p class="no-data">Записів відвідуваності не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Учень</th>
                            <th>Предмет</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance as $att): ?>
                        <tr>
                            <td><?= $att['id'] ?></td>
                            <td><?= htmlspecialchars($att['student_name']) ?></td>
                            <td><?= htmlspecialchars($att['subject_name']) ?></td>
                            <td>
                                <span class="status-badge status-<?= $att['status'] ?>">
                                    <?php
                                    $statuses = [
                                        'present' => 'Присутній',
                                        'absent' => 'Відсутній',
                                        'late' => 'Запізнився'
                                    ];
                                    echo $statuses[$att['status']] ?? $att['status'];
                                    ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($att['date']) ?></td>
                            <td class="actions">
                                <a href="/attendance/edit/<?= $att['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <form method="POST" action="/attendance/delete/<?= $att['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?')">
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
