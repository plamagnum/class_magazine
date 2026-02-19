<div class="page-header">
    <h1><i class="fas fa-school"></i> Класи</h1>
    <a href="/classes/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Додати клас
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/classes" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" placeholder="Пошук за назвою..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Пошук
                </button>
                <?php if (!empty($search)): ?>
                <a href="/classes" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($classes)): ?>
            <p class="no-data">Класів не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Рік</th>
                            <th>Кількість учнів</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classes as $class): ?>
                        <tr>
                            <td><?= $class['id'] ?></td>
                            <td><?= htmlspecialchars($class['name']) ?></td>
                            <td><?= htmlspecialchars($class['year']) ?></td>
                            <td><?= $class['student_count'] ?></td>
                            <td class="actions">
                                <a href="/classes/edit/<?= $class['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <form method="POST" action="/classes/delete/<?= $class['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цей клас?')">
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
