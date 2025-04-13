<?php
include_once '../includes/config.php';
include_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Получение данных пользователя
$sql = "SELECT username, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Получение билетов пользователя
$tickets_sql = "SELECT tickets.*, plays.title, schedule.date_time 
                FROM tickets 
                JOIN schedule ON tickets.event_id = schedule.event_id 
                JOIN plays ON schedule.play_id = plays.play_id 
                WHERE tickets.user_id = ?";
$tickets_stmt = $conn->prepare($tickets_sql);
$tickets_stmt->bind_param("i", $user_id);
$tickets_stmt->execute();
$tickets_result = $tickets_stmt->get_result();

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $current_password = trim($_POST['current_password']);

    // Проверка текущего пароля
    $sql_check = "SELECT password_hash FROM users WHERE user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $user_data = $result_check->fetch_assoc();

    if (!password_verify($current_password, $user_data['password_hash'])) {
        $error = 'Неверный текущий пароль';
    } else {
        // Обновление данных
        $sql_update = "UPDATE users SET username = ?, email = ?";
        $params = array($username, $email);
        $types = "ss";

        if (!empty($new_password)) {
            $sql_update .= ", password_hash = ?";
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $params[] = $hashed_password;
            $types .= "s";
        }

        $sql_update .= " WHERE user_id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param($types, ...$params);

        if ($stmt_update->execute()) {
            $success = 'Данные успешно обновлены!';
            $_SESSION['username'] = $username;
            // Обновляем данные пользователя после изменения
            $user['username'] = $username;
            $user['email'] = $email;
        } else {
            $error = 'Ошибка при обновлении данных';
        }
    }
}
?>

<section class="profile">
    <h2>Личный кабинет</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert success"><?= $success ?></div>
    <?php endif; ?>

    <!-- Статичное отображение данных -->
    <div class="user-info">
        <p><strong>Логин:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <button id="editProfileBtn" class="btn">Редактировать данные</button>
    </div>

    <!-- Форма редактирования (изначально скрыта) -->
    <form method="POST" class="edit-form" style="display: none;">
        <div class="form-group">
            <label>Логин:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Новый пароль:</label>
            <input type="password" name="new_password">
        </div>

        <div class="form-group">
            <label>Текущий пароль:</label>
            <input type="password" name="current_password" required>
        </div>

        <button type="submit" class="btn">Сохранить</button>
        <button type="button" id="cancelEditBtn" class="btn">Отмена</button>
    </form>

    <!-- История билетов -->
    <h3>Ваши билеты</h3>
    <div class="tickets-list">
        <?php if ($tickets_result && mysqli_num_rows($tickets_result) > 0): ?>
            <?php while ($ticket = mysqli_fetch_assoc($tickets_result)): ?>
                <div class="ticket-card">
                    <p><strong>Спектакль:</strong> <?= htmlspecialchars($ticket['title']) ?></p>
                    <p><strong>Дата:</strong> <?= date('d.m.Y H:i', strtotime($ticket['date_time'])) ?></p>
                    <p><strong>Место:</strong> <?= htmlspecialchars($ticket['seat_number']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>У вас пока нет билетов.</p>
        <?php endif; ?>
    </div>
</section>

<script>
// Показать/скрыть форму редактирования
document.getElementById('editProfileBtn').addEventListener('click', function() {
    document.querySelector('.edit-form').style.display = 'block';
    this.style.display = 'none';
});

document.getElementById('cancelEditBtn').addEventListener('click', function() {
    document.querySelector('.edit-form').style.display = 'none';
    document.getElementById('editProfileBtn').style.display = 'block';
});
</script>

<?php include_once '../includes/footer.php'; ?>