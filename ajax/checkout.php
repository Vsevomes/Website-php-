<?php
include_once '../includes/config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Требуется авторизация']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Начало транзакции для атомарности
mysqli_begin_transaction($conn);

try {
    // Получаем все забронированные билеты пользователя
    $sql = "SELECT ticket_id FROM tickets 
            WHERE user_id = $user_id 
            AND status = 'booked' 
            FOR UPDATE";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) === 0) {
        throw new Exception('Нет билетов для оформления');
    }

    // Обновляем статус билетов на "sold"
    $update_sql = "UPDATE tickets 
                   SET status = 'sold' 
                   WHERE user_id = $user_id 
                   AND status = 'booked'";
    
    mysqli_query($conn, $update_sql);

    // Фиксация транзакции
    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Заказ оформлен! Билеты подтверждены.'
    ]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>