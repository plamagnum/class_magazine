<div class="page-header">
    <h1><i class="fas fa-user-graduate"></i> Учні</h1>
    <a href="/students/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Додати учня
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/students" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" placeholder="Пошук за ім'ям..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Пошук
                </button>
                <?php if ($search): ?>
                <a href="/students" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($students)): ?>
            <p class="no-data">Учнів не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ПІБ</th>
                            <th>Клас</th>
                            <th>Дата народження</th>
                            <th>Email</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student['id'] ?></td>
                            <td>
                                <?= htmlspecialchars($student['last_name'] . ' ' . $student['first_name'] . ' ' . ($student['patronymic'] ?? '')) ?>
                            </td>
                            <td><?= htmlspecialchars($student['class_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($student['date_of_birth'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($student['email'] ?? '-') ?></td>
                            <td class="actions">
                                <a href="/students/edit/<?= $student['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <form method="POST" action="/students/delete/<?= $student['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цього учня?')">
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
