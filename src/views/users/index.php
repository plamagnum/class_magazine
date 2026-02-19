<div class="page-header">
    <h1><i class="fas fa-users"></i> Користувачі</h1>
    <a href="/users/create" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Додати користувача
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/users" class="search-form">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="search" placeholder="Пошук за ім'ям або email..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="form-group">
                    <select name="role">
                        <option value="">Всі ролі</option>
                        <option value="admin" <?= ($filters['role'] ?? '') == 'admin' ? 'selected' : '' ?>>Адміністратор</option>
                        <option value="teacher" <?= ($filters['role'] ?? '') == 'teacher' ? 'selected' : '' ?>>Викладач</option>
                    </select>
                </div>
            </div>
            <div class="search-input-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Пошук
                </button>
                <?php if (!empty($search) || !empty($filters['role'])): ?>
                <a href="/users" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Скинути
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($users)): ?>
            <p class="no-data">Користувачів не знайдено</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ім'я</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Створено</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="role-badge role-<?= $user['role'] ?>">
                                    <?php
                                    $roles = [
                                        'admin' => 'Адміністратор',
                                        'teacher' => 'Викладач'
                                    ];
                                    echo $roles[$user['role']] ?? $user['role'];
                                    ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td class="actions">
                                <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-edit"></i> Редагувати
                                </a>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <form method="POST" action="/users/delete/<?= $user['id'] ?>" style="display:inline;" 
                                      onsubmit="return confirm('Ви впевнені, що хочете видалити цього користувача?')">
                                    <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Видалити
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
