<?php
include_once '../includes/config.php';
include_once '../includes/header.php';

// Получение параметров фильтрации
$genre_id = isset($_GET['genre']) ? intval($_GET['genre']) : 0;
$duration_max = isset($_GET['duration']) ? intval($_GET['duration']) : 0;
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

// SQL-запрос с фильтрами
$sql = "SELECT * FROM plays 
        JOIN genres ON plays.genre_id = genres.genre_id 
        WHERE 1=1";

if ($genre_id > 0) {
    $sql .= " AND plays.genre_id = $genre_id";
}
if ($duration_max > 0) {
    $sql .= " AND plays.duration <= $duration_max";
}
if ($year > 0) {
    $sql .= " AND plays.premiere_year = $year";
}

$result = mysqli_query($conn, $sql);
?>

<section class="plays">
    <h2>Спектакли</h2>

    <!-- Форма фильтрации -->
    <div class="filters">
        <form method="GET" action="plays.php">
            <div class="form-group">
                <label>Жанр:</label>
                <select name="genre">
                    <option value="0">Все</option>
                    <?php
                    $genres = mysqli_query($conn, "SELECT * FROM genres");
                    while ($genre = mysqli_fetch_assoc($genres)) {
                        $selected = ($genre['genre_id'] == $genre_id) ? 'selected' : '';
                        echo "<option value='{$genre['genre_id']}' $selected>{$genre['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Макс. длительность (мин):</label>
                <input type="number" name="duration" value="<?= $duration_max ?>">
            </div>

            <div class="form-group">
                <label>Год премьеры:</label>
                <input type="number" name="year" value="<?= $year ?>">
            </div>

            <button type="submit" class="btn">Применить фильтры</button>
        </form>
    </div>

    <!-- Список спектаклей -->
    <div class="plays-list">
        <?php while ($play = mysqli_fetch_assoc($result)): ?>
            <div class="play-card">
                <h3><?= htmlspecialchars($play['title']) ?></h3>
                <p><strong>Жанр:</strong> <?= htmlspecialchars($play['name']) ?></p>
                <p><strong>Длительность:</strong> <?= $play['duration'] ?> мин</p>
                <p><strong>Премьера:</strong> <?= $play['premiere_year'] ?></p>
                <a href="booking.php?play_id=<?= $play['play_id'] ?>" class="btn">Купить билет</a>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>