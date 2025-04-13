<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html');
include_once '../includes/config.php';

$event_id = intval($_GET['event_id']);
$sql = "SELECT * FROM tickets 
        WHERE event_id = $event_id 
        AND status = 'available'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Ошибка запроса: " . mysqli_error($conn));
}

echo '<div class="seat-grid">';
if (mysqli_num_rows($result) > 0) {
    while ($ticket = mysqli_fetch_assoc($result)) {
        echo '<label class="seat">';
        echo '<input type="radio" name="seat" value="' . htmlspecialchars($ticket['seat_number']) . '">';
        echo htmlspecialchars($ticket['seat_number']) . ' (' . $ticket['price'] . ' руб.)';
        echo '</label>';
    }
} else {
    echo '<p class="no-seats">На этот спектакль пока нет доступных билетов.</p>';
}
echo '</div>';