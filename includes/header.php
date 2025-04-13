<?php
session_start(); // Запуск сессии для работы с авторизацией
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Театр имени А.П. Чехова</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/png">
</head>
<body>
    <header class="header">
        <!-- Логотип и название -->
        <div class="logo">
            <a href="../pages/index.php">
                <img src="../assets/images/logo.png" alt="Логотип театра">
                <span>Театр имени А.П. Чехова</span>
            </a>
        </div>

        <!-- Навигационное меню -->
        <nav class="nav">
            <ul class="nav-list">
                <li><a href="../pages/index.php">Главная</a></li>
                <li><a href="../pages/gallery.php">Галерея</a></li>
                <li><a href="../pages/plays.php">Спектакли</a></li>
                <li><a href="../pages/contacts.php">Контакты</a></li>
                
                <!-- Блок авторизации -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="../pages/cart.php">Корзина</a></li>
                    <li><a href="../pages/profile.php">Личный кабинет</a></li>
                    <li><a href="../includes/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="../pages/login.php">Войти</a></li>
                    <li><a href="../pages/register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Бургер-меню для мобильных -->
        <div class="burger-menu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>