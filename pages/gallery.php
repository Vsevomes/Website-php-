<?php
include_once '../includes/config.php';
include_once '../includes/header.php';
?>

<section class="gallery">
    <h2>Галерея</h2>
    
    <!-- Галерея спектаклей -->
    <div class="gallery-section">
        <h3>Спектакли</h3>
        <div class="gallery-grid">
            <?php
            $plays_sql = "SELECT play_id, title, poster_url FROM plays";
            $plays_result = mysqli_query($conn, $plays_sql);
            while ($play = mysqli_fetch_assoc($plays_result)) {
                echo '<div class="gallery-item">';
                echo '<img src="../assets/images/' . htmlspecialchars($play['poster_url']) . '" alt="' . htmlspecialchars($play['title']) . '">';
                echo '<p>' . htmlspecialchars($play['title']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Галерея актеров -->
    <div class="gallery-section">
        <h3>Актеры</h3>
        <div class="gallery-grid">
            <?php
            $actors_sql = "SELECT actor_id, full_name, photo_url FROM actors";
            $actors_result = mysqli_query($conn, $actors_sql);
            while ($actor = mysqli_fetch_assoc($actors_result)) {
                echo '<div class="gallery-item">';
                echo '<img src="../assets/images/' . htmlspecialchars($actor['photo_url']) . '" alt="' . htmlspecialchars($actor['full_name']) . '">';
                echo '<p>' . htmlspecialchars($actor['full_name']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include_once '../includes/footer.php'; ?>