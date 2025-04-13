<?php
include_once '../includes/config.php';
include_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение play_id из URL и валидация
$play_id = isset($_GET['play_id']) ? intval($_GET['play_id']) : 0;

// SQL-запрос в зависимости от play_id
if ($play_id > 0) {
    // Фильтрация по конкретному спектаклю
    $sql = "SELECT 
            schedule.event_id, 
            schedule.date_time, 
            halls.name AS hall_name, 
            halls.capacity 
        FROM schedule 
        JOIN halls ON schedule.hall_id = halls.hall_id 
        WHERE schedule.play_id = $play_id 
            AND schedule.date_time > NOW() 
        ORDER BY schedule.date_time";
    
    // Получение названия спектакля
    $play_title_sql = "SELECT title FROM plays WHERE play_id = $play_id";
    $play_title_result = mysqli_query($conn, $play_title_sql);
    $play_title = mysqli_fetch_assoc($play_title_result)['title'];
} else {
    // Все спектакли
    $sql = "SELECT 
            schedule.event_id, 
            plays.title, 
            schedule.date_time, 
            halls.name AS hall_name 
        FROM schedule 
        JOIN plays ON schedule.play_id = plays.play_id 
        JOIN halls ON schedule.hall_id = halls.hall_id 
        WHERE schedule.date_time > NOW()";
}

$result = mysqli_query($conn, $sql);
?>

<section class="booking">
    <h2>Бронирование билетов</h2>

    <?php if ($play_id > 0): ?>
        <div class="selected-play">
            <h3>Спектакль: <?= htmlspecialchars($play_title) ?></h3>
        </div>
    <?php endif; ?>

    <!-- Шаг 1: Выбор спектакля (только если play_id не задан) -->
    <?php if ($play_id == 0): ?>
        <div class="step">
            <h3>Выберите спектакль</h3>
            <select id="playSelect" class="form-control">
                <option value="">-- Все спектакли --</option>
                <?php 
                $plays = mysqli_query($conn, "SELECT * FROM plays");
                while ($play = mysqli_fetch_assoc($plays)): 
                ?>
                    <option value="<?= $play['play_id'] ?>" 
                        <?= ($play['play_id'] == $play_id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($play['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    <?php endif; ?>

    <!-- Шаг 2: Выбор даты -->
    <div class="step" id="dateStep" style="display: <?= ($play_id > 0) ? 'block' : 'none' ?>;">
        <h3>Выберите дату</h3>
        <div id="dateList">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <button class="date-btn" data-event-id="<?= $row['event_id'] ?>">
                        <?= date('d.m.Y H:i', strtotime($row['date_time'])) ?> 
                        (<?= htmlspecialchars($row['hall_name']) ?>)
                    </button>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Нет доступных дат.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Шаг 3: Выбор места -->
    <div class="step" id="seatStep" style="display: none;">
        <h3>Выберите место</h3>
        <div id="seatMap"></div>
    </div>

    <!-- Кнопка добавления в корзину -->
    <button id="addToCart" class="btn" style="display: none; margin-bottom: 20px;">Добавить в корзину</button>
</section>

<script>
// Обработчик выбора спектакля (только если play_id не задан)
<?php if ($play_id == 0): ?>
    const playSelect = document.getElementById('playSelect');
    if (playSelect) {
        playSelect.addEventListener('change', function() {
            const playId = this.value;
            window.location.href = `booking.php?play_id=${playId}`;
        });
    }
<?php endif; ?>

// AJAX-запрос для загрузки дат (только если play_id не задан)
<?php if ($play_id == 0): ?>
    const playSelectForDates = document.getElementById('playSelect');
    if (playSelectForDates) {
        playSelectForDates.addEventListener('change', function() {
            const playId = this.value;
            fetch(`../ajax/get_dates.php?play_id=${playId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('dateStep').style.display = 'block';
                    document.getElementById('dateList').innerHTML = data;
                });
        });
    }
<?php endif; ?>

// AJAX-запрос для загрузки мест
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.date-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.date-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            const eventId = this.dataset.eventId;
            document.getElementById('seatMap').innerHTML = '<p>Загрузка мест...</p>';
            
            fetch(`../ajax/get_seats.php?event_id=${eventId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Ошибка сети');
                    return response.text();
                })
                .then(data => {
                    document.getElementById('seatMap').innerHTML = data;
                    document.getElementById('seatStep').style.display = 'block';
                    document.getElementById('addToCart').style.display = 'block';
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    document.getElementById('seatMap').innerHTML = '<p>Ошибка загрузки мест</p>';
                });
        });
    });
});

// Обработчик кнопки "Добавить в корзину"
document.addEventListener('DOMContentLoaded', function() {
    const addToCart = document.getElementById('addToCart');
    if (addToCart) {
        addToCart.addEventListener('click', function() {
            const seatNumber = document.querySelector('input[name="seat"]:checked').value;
            const eventId = document.querySelector('.date-btn.active').dataset.eventId;
            
            fetch(`../ajax/add_to_cart.php?event_id=${eventId}&seat=${seatNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Билет добавлен в корзину!');
                        window.location.href = 'cart.php';
                    } else {
                        alert('Ошибка: ' + data.error);
                    }
                });
        });
    }
});
</script>

<?php include_once '../includes/footer.php'; ?>