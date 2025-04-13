<?php
header('Content-Type: application/json');
require_once '../includes/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Разрешаем CORS (для теста)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Валидация данных из $_POST
$name = trim($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$message = trim($_POST['message'] ?? '');

// Проверка полей
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Все поля обязательны для заполнения']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Неверный формат email']);
    exit();
}

// Сохранение в базу данных
try {
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    // Отправка email через PHPMailer
    require_once '../vendor/autoload.php';
    $mail = new PHPMailer(true);
    
    // Настройки SMTP
    $mail->isSMTP();
    $mail->Host = 'st.guap.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'user37462@st.guap.ru'; // Заполните данные
    $mail->Password = 'N234ntXO'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    
    $mail->setFrom('user37462@st.guap.ru', 'Театр');
    $mail->addAddress('jhonykattvil@yandex.ru');
    $mail->Subject = 'Новое сообщение с сайта';
    $mail->Body = "Имя: $name\nEmail: $email\nСообщение:\n$message";
    
    $mail->send();
    echo json_encode([
        'success' => true,
        'redirect' => '../pages/contacts.php?success=1'
    ]);
    
} catch (Exception $e) {
    error_log('Ошибка: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Ошибка сервера']);
}