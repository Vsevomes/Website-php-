<?php
include_once '../includes/config.php';
session_start();

header('Content-Type: application/json');

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Требуется авторизация']);
    exit();
}

// Получение данных из запроса
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : null;
$seat = isset($_GET['seat']) ? mysqli_real_escape_string($conn, $_GET['seat']) : null;

// Валидация данных
if (!$event_id || !$seat) {
    echo json_encode(['success' => false, 'error' => 'Неверные параметры']);
    exit();
}

// Проверка доступности места
$sql = "SELECT ticket_id, status FROM tickets 
        WHERE event_id = $event_id 
        AND seat_number = '$seat'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo json_encode(['success' => false, 'error' => 'Место не найдено']);
    exit();
}

$ticket = mysqli_fetch_assoc($result);

if ($ticket['status'] !== 'available') {
    echo json_encode(['success' => false, 'error' => 'Место уже занято']);
    exit();
}

// Резервирование места (обновление статуса и привязка к пользователю)
$user_id = $_SESSION['user_id'];
$update_sql = "UPDATE tickets 
               SET status = 'booked', user_id = $user_id 
               WHERE ticket_id = {$ticket['ticket_id']}";

if (mysqli_query($conn, $update_sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Ошибка базы данных']);
}
?>