<?php
include_once '../includes/config.php';
include_once '../includes/header.php';
?>

<main class="main-content">
    <!-- Блок "О театре" -->
    <section class="about-theatre">
        <h1>Добро пожаловать в Театр имени А.П. Чехова</h1>
        <div class="about-content">
            <div class="image-container">
                <img src="../assets/images/main.gif" alt="Здание театра" class="center-image">
            </div>
            <div class="description">
                <p>Основанный в 1898 году, Театр имени А.П. Чехова является одним из старейших культурных учреждений страны. 
                Мы сохраняем традиции классического искусства, сочетая их с современными интерпретациями. 
                В нашем репертуаре — легендарные постановки по произведениям Шекспира, Чехова, Гоголя и других великих авторов.</p>
                
                <p>Ежегодно мы представляем более 20 спектаклей разных жанров: от трагедий до мюзиклов. 
                Наши залы оборудованы по последнему слову техники, а актерская труппа удостоена множества наград.</p>
            </div>
        </div>
    </section>

    <!-- Блок "Ближайшие спектакли" -->
    <section class="upcoming-performances">
        <h2>Ближайшие спектакли</h2>
        <div class="performances-grid">
            <?php
            $sql = "SELECT 
                    schedule.event_id,
                    schedule.play_id,
                    plays.title,
                    schedule.date_time,
                    halls.name AS hall_name,
                    halls.capacity,
                    genres.name AS genre
                FROM schedule
                JOIN plays ON schedule.play_id = plays.play_id
                JOIN halls ON schedule.hall_id = halls.hall_id
                JOIN genres ON plays.genre_id = genres.genre_id
                WHERE schedule.date_time >= NOW()
                ORDER BY schedule.date_time ASC
                LIMIT 4";

            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="performance-card">';
                    echo '<h3>'.htmlspecialchars($row['title']).'</h3>';
                    echo '<p class="genre">'.htmlspecialchars($row['genre']).'</p>';
                    echo '<p class="date">'.date('d.m.Y H:i', strtotime($row['date_time'])).'</p>';
                    echo '<p class="hall">Зал: '.htmlspecialchars($row['hall_name']).'</p>';
                    echo '<a href="booking.php?play_id='.$row['play_id'].'" class="btn">Купить билет</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>На данный момент спектаклей не запланировано</p>';
            }
            ?>
        </div>
    </section>

    <!-- Блок "Последние новости" -->
    <section class="latest-news">
        <h2>Новости театра</h2>
        <div class="news-grid">
            <?php
            $news_sql = "SELECT * FROM news ORDER BY date DESC LIMIT 3";
            $news_result = mysqli_query($conn, $news_sql);
            
            if (mysqli_num_rows($news_result) > 0) {
                while($news = mysqli_fetch_assoc($news_result)) {
                    echo '<article class="news-item">';
                    echo '<h3>'.htmlspecialchars($news['title']).'</h3>';
                    echo '<time>'.date('d.m.Y', strtotime($news['date'])).'</time>';
                    echo '<p>'.substr(htmlspecialchars($news['content']), 0, 150).'...</p>';
                    echo '</article>';
                }
            } else {
                echo '<p>Новостей пока нет</p>';
            }
            ?>
        </div>
    </section>
</main>

<?php
include_once '../includes/footer.php';
?>