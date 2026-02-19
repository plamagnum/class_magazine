<div class="page-header">
    <h1><i class="fas fa-book"></i> Предмети</h1>
    <a href="/subjects/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Додати предмет
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/subjects" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" placeholder="Пошук за назвою..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Пошук
                </button>
                <?php if (!empty($search)): ?>
                <a href="/subjects" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($subjects)): ?>
            <p class="no-data">Предметів не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Опис</th>
                            <th>Викладач</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?= $subject['id'] ?></td>
                            <td><?= htmlspecialchars($subject['name']) ?></td>
                            <td><?= htmlspecialchars($subject['description'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($subject['teacher_name'] ?? '-') ?></td>
                            <td class="actions">
                                <a href="/subjects/edit/<?= $subject['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <form method="POST" action="/subjects/delete/<?= $subject['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цей предмет?')">
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
