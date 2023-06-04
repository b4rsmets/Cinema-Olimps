-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2023 at 08:30 PM
-- Server version: 8.0.24
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinemaolimp`
--

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int NOT NULL,
  `hall_name` varchar(50) NOT NULL,
  `hall_close` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `hall_name`, `hall_close`) VALUES
(1, 'Западный', 0);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `movie_title` varchar(100) NOT NULL,
  `movie_url` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `movie_restriction` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `movie_image` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `movie_genre` varchar(50) NOT NULL,
  `movie_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `movie_duration` int DEFAULT NULL,
  `movie_country` varchar(30) NOT NULL,
  `movie_trailer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `movie_premier` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `movie_title`, `movie_url`, `movie_restriction`, `movie_image`, `movie_genre`, `movie_description`, `movie_duration`, `movie_country`, `movie_trailer`, `movie_premier`) VALUES
(59, 'Большой Лебовски', '555', '18', '555.jpg', 'комедия', 'Лос-Анджелес, 1991 год, война в Персидском заливе. Главный герой по прозвищу Чувак считает себя совершенно счастливым человеком. Его жизнь составляют игра в боулинг и выпивка. Но внезапно его счастье нарушается, гангстеры по ошибке принимают его за миллионера-однофамильца, требуют деньги, о которых он ничего не подозревает, и, ко всему прочему, похищают жену миллионера, будучи уверенными, что «муж» выплатит за нее любую сумму.', 117, 'США', 'https://www.youtube.com/embed/cd-go0oBF4Y', 555),
(60, 'Вызов', '4448519', '12', '4448519.jpg', 'драма', 'Торакальный хирург Женя за месяц должна подготовиться к космическому полету, чтобы отправиться на МКС и спасти заболевшего космонавта. Ей придётся преодолеть неуверенность и страхи, а также провести сложнейшую операцию в условиях невесомости, от которой зависят шансы космонавта вернуться на Землю живым.', 164, 'Россия', '1', 4448519),
(62, 'Аватар: Путь воды', '505898', '12', '505898.jpg', 'фантастика', 'После принятия образа аватара солдат Джейк Салли становится предводителем народа на\'ви и берет на себя миссию по защите новых друзей от корыстных бизнесменов с Земли. Теперь ему есть за кого бороться — с Джейком его прекрасная возлюбленная Нейтири. Когда на Пандору возвращаются до зубов вооруженные земляне, Джейк готов дать им отпор.', 192, 'США', 'https://www.youtube.com/watch?v=Zw1yQ1uuq7Y', 505898);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `news_image` varchar(25) NOT NULL,
  `news_title` varchar(60) NOT NULL,
  `news_date` date NOT NULL,
  `news_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `news_image`, `news_title`, `news_date`, `news_description`) VALUES
(1, '123.jpg', 'Открытие кинотеатра', '2023-05-21', 'Кинотеатр открывается  и ждет всех желающих отдохнуть и посмореть новинки кино'),
(2, '321.jpg', 'Глас Народа. Собираем рецензию на фильм \"Форсаж 10\"', '2023-05-21', 'Фильм \"Форсаж 10\" опять раздвигает границы дозволенного и разумного, умудряясь при этом сохранять достаточно самоиронии, чтобы не отпугнуть массового зрителя. Феноменальная по многим причинам франшиза продолжается, и миллионы зрителей по всему миру спешат вновь увидеть команду Торетто в действии.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `date_buy` date NOT NULL,
  `id_seans` int NOT NULL,
  `id_seat` int NOT NULL,
  `id_user` int NOT NULL,
  `ticket_number` varchar(20) NOT NULL,
  `qr` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seans`
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
-- Dumping data for table `seans`
--

INSERT INTO `seans` (`id`, `hall_id`, `date_movie`, `time_movie`, `movie_id`, `price`) VALUES
(3, 1, '2023-06-05', '23:00:00.000000', 60, 300),
(4, 1, '2023-06-06', '23:25:00.000000', 62, 400);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `hall_id` int NOT NULL,
  `row` int NOT NULL,
  `place` int NOT NULL,
  `seans_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `hall_id`, `row`, `place`, `seans_id`) VALUES
(1, 1, 1, 1, 4),
(2, 1, 1, 2, 4),
(3, 1, 1, 3, 4),
(4, 1, 1, 4, 4),
(5, 1, 1, 5, 4),
(6, 1, 1, 6, 4),
(7, 1, 1, 7, 4),
(8, 1, 1, 8, 4),
(9, 1, 1, 9, 4),
(10, 1, 1, 10, 4),
(11, 1, 1, 11, 4),
(12, 1, 1, 12, 4),
(13, 1, 1, 13, 4),
(14, 1, 1, 14, 4),
(15, 1, 1, 15, 4),
(16, 1, 1, 16, 4),
(17, 1, 1, 17, 4),
(18, 1, 1, 18, 4),
(19, 1, 2, 1, 4),
(20, 1, 2, 2, 4),
(21, 1, 2, 3, 4),
(22, 1, 2, 4, 4),
(23, 1, 2, 5, 4),
(24, 1, 2, 6, 4),
(25, 1, 2, 7, 4),
(26, 1, 2, 8, 4),
(27, 1, 2, 9, 4),
(28, 1, 2, 10, 4),
(29, 1, 2, 11, 4),
(30, 1, 2, 12, 4),
(31, 1, 2, 13, 4),
(32, 1, 2, 14, 4),
(33, 1, 2, 15, 4),
(34, 1, 2, 16, 4),
(35, 1, 2, 17, 4),
(36, 1, 2, 18, 4),
(37, 1, 3, 1, 4),
(38, 1, 3, 2, 4),
(39, 1, 3, 3, 4),
(40, 1, 3, 4, 4),
(41, 1, 3, 5, 4),
(42, 1, 3, 6, 4),
(43, 1, 3, 7, 4),
(44, 1, 3, 8, 4),
(45, 1, 3, 9, 4),
(46, 1, 3, 10, 4),
(47, 1, 3, 11, 4),
(48, 1, 3, 12, 4),
(49, 1, 3, 13, 4),
(50, 1, 3, 14, 4),
(51, 1, 3, 15, 4),
(52, 1, 3, 16, 4),
(53, 1, 3, 17, 4),
(54, 1, 3, 18, 4),
(55, 1, 4, 1, 4),
(56, 1, 4, 2, 4),
(57, 1, 4, 3, 4),
(58, 1, 4, 4, 4),
(59, 1, 4, 5, 4),
(60, 1, 4, 6, 4),
(61, 1, 4, 7, 4),
(62, 1, 4, 8, 4),
(63, 1, 4, 9, 4),
(64, 1, 4, 10, 4),
(65, 1, 4, 11, 4);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `title_movie_slider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `slider_image`, `title_movie_slider`) VALUES
(1, 'avatar.jpg', ''),
(2, 'cheburashka.jpg', 'Чебурашка'),
(3, 'avatar.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `soon`
--

CREATE TABLE `soon` (
  `id` int NOT NULL,
  `image_film_soon` varchar(50) NOT NULL,
  `date_film_soon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `salt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `role` varchar(20) NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `login`, `password`, `salt`, `role`, `email`, `phone`) VALUES
(8, 'Слава', 'qqqqqq', '11231231', NULL, 'user', 'slavunq@mail.ru', 23123),
(9, 'Слава', 'admin33333333', '11232131', NULL, 'admin', 'wablonlife@mail.ru', 89021406130),
(10, 'Слава', 'admin', '1', NULL, 'admin', 'wablonlife@mail.ru', 79627906083);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seans`
--
ALTER TABLE `seans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soon`
--
ALTER TABLE `soon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `seans`
--
ALTER TABLE `seans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `soon`
--
ALTER TABLE `soon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
