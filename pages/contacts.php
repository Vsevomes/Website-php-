<?php
include_once '../includes/config.php';
include_once '../includes/header.php';
?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert success">
        Сообщение успешно отправлено! Мы свяжемся с вами в ближайшее время.
    </div>
<?php endif; ?>

<section class="contacts">
    <h2>Контакты</h2>
    
    <div class="contacts-content">
        <!-- Карта -->
        <div class="map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.372951435726!2d37.617734315930716!3d55.75581998055315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a5a738fa419%3A0x7c347d506f52711!2z0JzQvtGB0LrQvtCy0YHQutC40Lkg0YbQtdC90YLRgA!5e0!3m2!1sru!2sru!4v1620000000000!5m2!1sru!2sru" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

        <!-- Форма обратной связи -->
        <div class="contact-form">
            <h3>Напишите нам</h3>
            <form action="../ajax/send_message.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Ваше имя" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Ваш email" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Сообщение" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Отправить</button>
            </form>
        </div>
    </div>
</section>

<script>

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../ajax/send_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Перенаправление с параметром успеха
            window.location.href = 'contacts.php?success=1';
        } else {
            alert('Ошибка: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
});

</script>

<?php include_once '../includes/footer.php'; ?>