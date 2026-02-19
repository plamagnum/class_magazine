<div class="page-header">
    <h1><i class="fas fa-home"></i> Головна панель</h1>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['total_students'] ?></h3>
            <p>Учнів</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['total_subjects'] ?></h3>
            <p>Предметів</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['total_grades'] ?></h3>
            <p>Оцінок</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-content">
            <h3><?= $stats['total_attendance'] ?></h3>
            <p>Записів відвідуваності</p>
        </div>
    </div>
</div>

<div class="dashboard-content">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-star"></i> Останні оцінки</h3>
        </div>
        <div class="card-body">
            <?php if (empty($recent_grades)): ?>
                <p class="no-data">Немає оцінок</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Учень</th>
                                <th>Предмет</th>
                                <th>Оцінка</th>
                                <th>Тип</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_grades as $grade): ?>
                            <tr>
                                <td><?= htmlspecialchars($grade['student_name']) ?></td>
                                <td><?= htmlspecialchars($grade['subject_name']) ?></td>
                                <td>
                                    <span class="grade-badge grade-<?= $grade['grade'] ?>">
                                        <?= $grade['grade'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($grade['type']) ?></td>
                                <td><?= htmlspecialchars($grade['date']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-clipboard-check"></i> Остання відвідуваність</h3>
        </div>
        <div class="card-body">
            <?php if (empty($recent_attendance)): ?>
                <p class="no-data">Немає записів відвідуваності</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Учень</th>
                                <th>Предмет</th>
                                <th>Статус</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_attendance as $att): ?>
                            <tr>
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
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
