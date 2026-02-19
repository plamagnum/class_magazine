<div class="page-header">
    <h1><i class="fas fa-edit"></i> Редагувати клас</h1>
    <a href="/classes" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/classes/edit/<?= $class['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Назва *</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($class['name']) ?>" placeholder="наприклад: 10-А" required>
                </div>

                <div class="form-group">
                    <label for="year">Рік *</label>
                    <input type="number" id="year" name="year" min="2020" max="2100" value="<?= htmlspecialchars($class['year']) ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Зберегти
            </button>
            <a href="/classes" class="btn btn-secondary">
                <i class="fas fa-times"></i> Скасувати
            </a>
        </form>
    </div>
</div>
