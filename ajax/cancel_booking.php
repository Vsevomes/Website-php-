<?php
include_once '../includes/config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Требуется авторизация']);
    exit();
}

$ticket_id = intval($_GET['ticket_id']);
$user_id = $_SESSION['user_id'];

// Обновляем статус билета
$sql = "UPDATE tickets 
        SET status = 'available', user_id = NULL 
        WHERE ticket_id = $ticket_id 
        AND user_id = $user_id 
        AND status = 'booked'";

if (mysqli_query($conn, $sql)) {
    if (mysqli_affected_rows($conn) > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Билет не найден или уже отменен']);
    }
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>