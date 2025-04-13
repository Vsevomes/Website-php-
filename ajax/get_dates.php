<?php
include_once '../includes/config.php';
$playId = $_GET['play_id'];

$sql = "SELECT schedule.event_id, schedule.date_time, halls.name 
        FROM schedule 
        JOIN halls ON schedule.hall_id = halls.hall_id 
        WHERE play_id = $playId 
        AND date_time > NOW()";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo '<button class="date-btn" data-event-id="'.$row['event_id'].'">';
    echo date('d.m.Y H:i', strtotime($row['date_time'])).' ('.$row['name'].')';
    echo '</button>';
}
?>