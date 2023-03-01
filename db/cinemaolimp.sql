-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 01 2023 г., 08:44
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cinemaolimp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
  `id` int NOT NULL,
  `hall_name` varchar(50) NOT NULL,
  `hall_close` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `movie_title` varchar(100) NOT NULL,
  `movie_url` varchar(20) NOT NULL,
  `movie_restriction` varchar(10) NOT NULL,
  `movie_image` varchar(70) NOT NULL,
  `movie_genre` varchar(50) NOT NULL,
  `movie_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `movie_duration` time(6) NOT NULL,
  `movie_country` varchar(30) NOT NULL,
  `movie_trailer` varchar(255) NOT NULL,
  `movie_premier` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `movies`
--

INSERT INTO `movies` (`id`, `movie_title`, `movie_url`, `movie_restriction`, `movie_image`, `movie_genre`, `movie_description`, `movie_duration`, `movie_country`, `movie_trailer`, `movie_premier`) VALUES
(1, 'Аватар 2: Путь воды', 'avatar2', '12', 'avatar.jpg', 'боевик, приключения, фэнтези', 'После принятия образа аватара солдат Джейк Салли становится предводителем народа на\'ви и берет на себя миссию по защите новых друзей от корыстных бизнесменов с Земли', '03:12:00.000000', 'США', 'https://www.youtube.com/embed/yKrzARVuePw', 0),
(2, 'Чебурашка', 'cheburashka', '6', 'cheburashka.jpg', 'Семейный, приключения', 'Иногда, чтобы вернуть солнце и улыбки в мир взрослых, нужен один маленький ушастый герой. Мохнатого непоседливого зверька из далекой апельсиновой страны ждут удивительные приключения в тихом приморском городке, где ему предстоит найти себе имя, друзей и дом. Помогать — и мешать! — ему в этом будут нелюдимый старик-садовник, странная тетя-модница и ее капризная внучка, мальчик, который никак не начнет говорить, и его мама, которой приходится несладко, хотя она и варит самый вкусный на свете шоколад. И многие-многие другие, в чью жизнь вместе с ароматом апельсинов вот-вот ворвутся волшебство и приключения.\r\n', '02:07:00.000000', 'Россия', 'https://www.youtube.com/embed/ueExdWhHsJo', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `news_image` varchar(25) NOT NULL,
  `news_title` varchar(60) NOT NULL,
  `news_date` date NOT NULL,
  `news_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `date_buy` date NOT NULL,
  `id_seans` int NOT NULL,
  `id_seat` int NOT NULL,
  `id_user` int NOT NULL,
  `ticket_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seans`
--

CREATE TABLE `seans` (
  `id` int NOT NULL,
  `hall_id` int NOT NULL,
  `date_movie` date NOT NULL,
  `time_movie` time(6) NOT NULL,
  `movie_id` int NOT NULL,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `seans`
--

INSERT INTO `seans` (`id`, `hall_id`, `date_movie`, `time_movie`, `movie_id`, `price`) VALUES
(2, 1, '2023-02-27', '22:00:00.000000', 1, 400),
(3, 2, '2023-02-28', '16:35:00.000000', 2, 300),
(4, 1, '2023-02-28', '20:00:00.000000', 1, 400);

-- --------------------------------------------------------

--
-- Структура таблицы `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `hall_id` int NOT NULL,
  `row` int NOT NULL,
  `place` int NOT NULL,
  `booking` json NOT NULL,
  `seans_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `seats`
--

INSERT INTO `seats` (`id`, `hall_id`, `row`, `place`, `booking`, `seans_id`) VALUES
(1, 1, 1, 1, '0', 4),
(2, 1, 1, 2, '1', 4),
(3, 1, 1, 3, '0', 4),
(4, 1, 1, 4, '0', 4),
(5, 1, 1, 5, '0', 4),
(6, 1, 1, 6, '0', 4),
(7, 1, 1, 7, '0', 4),
(8, 1, 1, 8, '0', 4),
(9, 1, 1, 9, '0', 4),
(10, 1, 1, 10, '0', 4),
(11, 1, 1, 11, '0', 4),
(12, 1, 1, 12, '0', 4),
(13, 1, 1, 13, '0', 4),
(14, 1, 1, 14, '0', 4),
(15, 1, 1, 15, '0', 4),
(16, 1, 1, 16, '0', 4),
(17, 1, 1, 17, '0', 4),
(18, 1, 1, 18, '0', 4),
(19, 1, 2, 1, '0', 4),
(20, 1, 2, 2, '0', 4),
(21, 1, 2, 3, '0', 4),
(22, 1, 2, 4, '0', 4),
(23, 1, 2, 5, '0', 4),
(24, 1, 2, 6, '0', 4),
(25, 1, 2, 7, '0', 4),
(26, 1, 2, 8, '0', 4),
(27, 1, 2, 9, '0', 4),
(28, 1, 2, 10, '0', 4),
(29, 1, 2, 11, '0', 4),
(30, 1, 2, 12, '0', 4),
(31, 1, 2, 13, '0', 4),
(32, 1, 2, 14, '0', 4),
(33, 1, 2, 15, '0', 4),
(34, 1, 2, 16, '0', 4),
(35, 1, 2, 17, '0', 4),
(36, 1, 2, 18, '1', 4),
(37, 1, 3, 1, '0', 4),
(38, 1, 3, 2, '0', 4),
(39, 1, 3, 3, '0', 4),
(40, 1, 3, 4, '0', 4),
(41, 1, 3, 5, '0', 4),
(42, 1, 3, 6, '0', 4),
(43, 1, 3, 7, '0', 4),
(44, 1, 3, 8, '0', 4),
(45, 1, 3, 9, '0', 4),
(46, 1, 3, 10, '0', 4),
(47, 1, 3, 11, '0', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `title_movie_slider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `slider_image`, `title_movie_slider`) VALUES
(1, 'avatar.jpg', ''),
(2, 'cheburashka.jpg', 'Чебурашка'),
(3, 'avatar.jpg', '');

-- --------------------------------------------------------

--
-- Структура таблицы `soon`
--

CREATE TABLE `soon` (
  `id` int NOT NULL,
  `image_film_soon` varchar(50) NOT NULL,
  `date_film_soon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `salt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `role` varchar(20) NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `login`, `password`, `salt`, `role`, `email`) VALUES
(1, 'Слава', 'admin', '1', '198833919263dfc3c001fe79.99887382', 'admin', '12'),
(2, NULL, '123123', '123123', NULL, 'user', NULL),
(3, NULL, '33', '33', NULL, 'user', NULL),
(4, NULL, '1231231', '12312312', NULL, 'user', NULL),
(5, NULL, 'qweqwe', '123', NULL, 'user', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seans`
--
ALTER TABLE `seans`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `soon`
--
ALTER TABLE `soon`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `seans`
--
ALTER TABLE `seans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `soon`
--
ALTER TABLE `soon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
