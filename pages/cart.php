<?php
include_once '../includes/config.php';
include_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получение забронированных билетов
$sql = "SELECT tickets.*, plays.title, schedule.date_time, halls.name AS hall_name 
        FROM tickets 
        JOIN schedule ON tickets.event_id = schedule.event_id 
        JOIN plays ON schedule.play_id = plays.play_id 
        JOIN halls ON schedule.hall_id = halls.hall_id 
        WHERE tickets.user_id = $user_id AND tickets.status = 'booked'";
$result = mysqli_query($conn, $sql);
?>

<section class="cart">
    <h2>Корзина</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="cart-items">
            <?php while ($ticket = mysqli_fetch_assoc($result)): ?>
                <div class="cart-item">
                    <h3><?= htmlspecialchars($ticket['title']) ?></h3>
                    <p>Дата: <?= date('d.m.Y H:i', strtotime($ticket['date_time'])) ?></p>
                    <p>Зал: <?= htmlspecialchars($ticket['hall_name']) ?></p>
                    <p>Место: <?= htmlspecialchars($ticket['seat_number']) ?></p>
                    <p>Цена: <?= $ticket['price'] ?> руб.</p>
                    <p>Статус: 
                        <span class="ticket-status status-<?= $ticket['status'] ?>">
                            <?= $ticket['status'] === 'booked' ? 'Забронировано' : 'Оплачено' ?>
                        </span>
                    </p>
                    <?php if ($ticket['order_id']): ?>
                        <p>Номер заказа: <?= $ticket['order_id'] ?></p>
                    <?php endif; ?>
                    
                    <?php if ($ticket['status'] === 'booked'): ?>
                        <button class="btn cancel-booking" data-ticket-id="<?= $ticket['ticket_id'] ?>">
                            Отменить бронь
                        </button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
        <button class="btn checkout" style="margin-bottom: 20px;">Оформить заказ</button>
    <?php else: ?>
        <p>Ваша корзина пуста.</p>
    <?php endif; ?>
</section>

<script>
// Отмена бронирования
document.querySelectorAll('.cancel-booking').forEach(button => {
    button.addEventListener('click', function() {
        const ticketId = this.dataset.ticketId;
        if (!confirm('Вы уверены, что хотите отменить бронь?')) return;
        
        fetch(`../ajax/cancel_booking.php?ticket_id=${ticketId}`)
            .then(response => {
                if (!response.ok) throw new Error('Ошибка сети');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.closest('.cart-item').remove();
                    alert('Бронь успешно отменена!');
                } else {
                    alert('Ошибка: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Не удалось отменить бронь');
            });
    });
});

// Оформление заказа
document.querySelector('.checkout').addEventListener('click', function() {
    fetch(`../ajax/checkout.php?user_id=<?= $user_id ?>`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Заказ оформлен! Номер заказа: ' + data.order_id);
                window.location.reload();
            } else {
                alert('Ошибка: ' + data.error);
            }
        });
});
</script>

<?php include_once '../includes/footer.php'; ?>