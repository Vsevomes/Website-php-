-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2025 г., 17:50
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `theatre`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actors`
--

CREATE TABLE `actors` (
  `actor_id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default-photo.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `actors`
--

INSERT INTO `actors` (`actor_id`, `full_name`, `birth_date`, `photo_url`) VALUES
(1, 'Иван Петров', '1985-03-15', 'man1.jpg'),
(2, 'Мария Сидорова', '1990-07-22', 'woman1.jpg'),
(3, 'Алексей Иванов', '1988-11-05', 'man2.jpg'),
(4, 'Анна Кузнецова', '1995-02-14', 'woman2.jpg'),
(5, 'Ольга Смирнова', '1993-04-10', 'woman3.jpg'),
(6, 'Дмитрий Волков', '1987-09-18', 'man3.jpg'),
(7, 'Екатерина Новикова', '1998-12-05', 'woman4.jpg'),
(8, 'Павел Лебедев', '1980-06-25', 'man4.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`genre_id`, `name`) VALUES
(1, 'Драма'),
(2, 'Комедия'),
(4, 'Мюзикл'),
(3, 'Трагедия');

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
  `hall_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `halls`
--

INSERT INTO `halls` (`hall_id`, `name`, `capacity`) VALUES
(1, 'Большой зал', 300),
(2, 'Малый зал', 100),
(3, 'Экспериментальная', 50),
(4, 'Детский зал', 80);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Всеволод', 'jhonykattvil@gmail.com', 'dafsdf', '2025-04-05 22:56:42'),
(2, 'Всеволод', 'jhonykattvil@gmail.com', 'привет', '2025-04-05 23:04:41'),
(3, 'Всеволод', 'jhonykattvil@gmail.com', 'привет', '2025-04-05 23:05:30'),
(4, 'Всеволод', 'jhonykattvil@gmail.com', 'привет', '2025-04-05 23:09:01'),
(5, 'Всеволод', 'jhonykattvil@gmail.com', 'adfmsdkfmdsv', '2025-04-05 23:09:12'),
(6, 'Всеволод', 'jhonykattvil@gmail.com', 'asdf', '2025-04-05 23:22:19'),
(7, 'Павел', 'jopa@mail.ru', 'дарова', '2025-04-06 16:24:50'),
(8, 'Павел', 'jopa@mail.ru', 'дарова', '2025-04-06 16:24:51'),
(9, 'Всеволод', 'example@mail.ru', 'wemvosfvd', '2025-04-07 15:32:06'),
(10, 'Всеволод', 'example@mail.ru', 'wemvosfvd', '2025-04-07 15:32:08');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`news_id`, `title`, `content`, `date`) VALUES
(1, 'Новый сезон открыт!', 'Спешим сообщить, что 15 сентября стартует 125-й театральный сезон...', '2025-03-31 23:55:42'),
(2, 'Гастроли в Париже', 'Наша труппа успешно выступила на сцене театра Гранд-Опера...', '2025-03-31 23:55:42');

-- --------------------------------------------------------

--
-- Структура таблицы `plays`
--

CREATE TABLE `plays` (
  `play_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `premiere_year` year(4) DEFAULT NULL,
  `poster_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default-poster.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `plays`
--

INSERT INTO `plays` (`play_id`, `title`, `genre_id`, `duration`, `premiere_year`, `poster_url`) VALUES
(1, 'Гамлет', 3, 180, 2020, 'gamlet.jpg'),
(2, 'Ревизор', 2, 150, 2021, 'revizor.jpg'),
(3, 'Ромео и Джульетта', 1, 170, 2022, 'rom_an_jule.jpg'),
(4, 'Собака на сене', 2, 140, 2023, 'sobaka_na_sene.jpg'),
(5, 'Щелкунчик', 4, 120, 2023, 'shelkun.jpg'),
(6, 'Король Лир', 3, 190, 2024, 'korol.jpg'),
(7, 'Вишнёвый сад', 1, 160, 2023, 'vishnya.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `play_actors`
--

CREATE TABLE `play_actors` (
  `play_actor_id` int(11) NOT NULL,
  `play_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `play_actors`
--

INSERT INTO `play_actors` (`play_actor_id`, `play_id`, `actor_id`, `role`) VALUES
(1, 1, 1, 'Гамлет'),
(2, 1, 2, 'Офелия'),
(3, 1, 3, 'Король Клавдий'),
(4, 2, 4, 'Хлестаков'),
(5, 5, 5, 'Мари'),
(6, 5, 6, 'Щелкунчик'),
(7, 6, 7, 'Король Лир'),
(8, 6, 8, 'Гонерилья'),
(9, 7, 1, 'Раневская'),
(10, 7, 2, 'Аня');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `event_id` int(11) NOT NULL,
  `play_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`event_id`, `play_id`, `hall_id`, `date_time`) VALUES
(1, 1, 1, '2025-12-20 19:00:00'),
(2, 2, 2, '2025-12-21 18:30:00'),
(3, 3, 1, '2025-12-22 20:00:00'),
(4, 4, 3, '2025-12-23 17:00:00'),
(5, 5, 4, '2025-06-15 16:00:00'),
(6, 6, 1, '2025-02-20 19:30:00'),
(7, 7, 2, '2025-03-10 18:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `seat_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','booked','sold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `seat_number`, `price`, `status`, `user_id`) VALUES
(1, 1, 'A1', '1500.00', 'sold', 3),
(2, 1, 'A2', '1500.00', 'sold', 3),
(3, 2, 'B3', '1000.00', 'booked', NULL),
(5, 5, 'A1', '800.00', 'available', NULL),
(6, 5, 'A2', '800.00', 'sold', 3),
(7, 6, 'B5', '2000.00', 'available', NULL),
(8, 7, 'C3', '1200.00', 'available', NULL),
(9, 1, 'A1', '1500.00', 'available', NULL),
(10, 1, 'A2', '1500.00', 'available', NULL),
(11, 1, 'B1', '1500.00', 'sold', 4),
(12, 1, 'B2', '1500.00', 'available', NULL),
(13, 1, 'C1', '1500.00', 'sold', 3),
(14, 2, 'A1', '1200.00', 'sold', 4),
(15, 2, 'A2', '1200.00', 'sold', 3),
(16, 2, 'B1', '1200.00', 'sold', 3),
(17, 2, 'B2', '1200.00', 'sold', 3),
(18, 1, 'A1', '1500.00', 'available', NULL),
(19, 1, 'A2', '1500.00', 'available', NULL),
(20, 1, 'B1', '1500.00', 'available', NULL),
(21, 1, 'B2', '1500.00', 'available', NULL),
(22, 1, 'C1', '1500.00', 'available', NULL),
(23, 2, 'A1', '1200.00', 'available', NULL),
(24, 2, 'A2', '1200.00', 'available', NULL),
(25, 2, 'B1', '1200.00', 'available', NULL),
(26, 2, 'B2', '1200.00', 'available', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'user1', 'user1@example.com', 'hash1', '2025-03-31 19:52:31'),
(2, 'user2', 'user2@example.com', 'hash2', '2025-03-31 19:52:31'),
(3, 'test', 'test@mail.ru', '$2y$10$MoCr2.ZiwZkZQUkT1kYwhOtDhplnSqViMETad/pQ7TeqOk6lUbH7G', '2025-04-01 00:15:22'),
(4, 'user', 'example@mail.ru', '$2y$10$Fl2UY8bj9DPP3klrEkENIeIwYXrdp3LY0Vm0MXUrd31Fh2WJZtVR.', '2025-04-07 17:31:52');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actor_id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`hall_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Индексы таблицы `plays`
--
ALTER TABLE `plays`
  ADD PRIMARY KEY (`play_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `play_actors`
--
ALTER TABLE `play_actors`
  ADD PRIMARY KEY (`play_actor_id`),
  ADD UNIQUE KEY `play_id` (`play_id`,`actor_id`,`role`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `play_id` (`play_id`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `idx_date_time` (`date_time`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actors`
--
ALTER TABLE `actors`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
  MODIFY `hall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `plays`
--
ALTER TABLE `plays`
  MODIFY `play_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `play_actors`
--
ALTER TABLE `play_actors`
  MODIFY `play_actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`);

--
-- Ограничения внешнего ключа таблицы `plays`
--
ALTER TABLE `plays`
  ADD CONSTRAINT `plays_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);

--
-- Ограничения внешнего ключа таблицы `play_actors`
--
ALTER TABLE `play_actors`
  ADD CONSTRAINT `play_actors_ibfk_1` FOREIGN KEY (`play_id`) REFERENCES `plays` (`play_id`),
  ADD CONSTRAINT `play_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`);

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`play_id`) REFERENCES `plays` (`play_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`hall_id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `schedule` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
