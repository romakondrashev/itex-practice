-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 26 2020 г., 12:27
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `online_queue`
--

-- --------------------------------------------------------

--
-- Структура таблицы `queues`
--

CREATE TABLE `queues` (
  `ID` int(11) NOT NULL,
  `author_FID` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `discipline` varchar(123) NOT NULL,
  `place` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `queues`
--

INSERT INTO `queues` (`ID`, `author_FID`, `title`, `description`, `discipline`, `place`, `date`, `is_active`) VALUES
(3, 2, 'Практические занятия', 'Сдача ИДЗ по 2-му модулю', 'ИПЗ', '37з', '2020-05-20 21:00:00', 1),
(5, 1, 'Лабораторные работы', 'Проведение Консультации', 'ITEX', '109i', '2020-05-30 21:00:00', 1),
(6, 1, 'Лабораторные работы', 'выфвфывфыв', 'КСХ', '109i', '2020-05-25 21:00:00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `queue_user`
--

CREATE TABLE `queue_user` (
  `ID` int(11) NOT NULL,
  `FID_queue` int(11) NOT NULL,
  `FID_user` int(11) NOT NULL,
  `queue_status` int(1) NOT NULL DEFAULT 1,
  `note` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `queue_user`
--

INSERT INTO `queue_user` (`ID`, `FID_queue`, `FID_user`, `queue_status`, `note`) VALUES
(33, 6, 1, 2, 'fdsfdsf'),
(76, 5, 1, 1, ''),
(77, 5, 6, 2, 'ывавыа'),
(79, 3, 1, 1, ''),
(81, 3, 6, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_hash` varchar(128) NOT NULL,
  `user_ip` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `curse` int(1) NOT NULL,
  `from_group` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `password`, `user_hash`, `user_ip`, `email`, `name`, `curse`, `from_group`) VALUES
(1, 'test', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '13d30d2b723a71e8d389e3114f19cbcd5c085078', '::1', 'test@gmail.com', 'Иващенко Г.С.', 0, ''),
(2, 'test2', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '0077bc2193a85d872308a463f0ddc9b35443bfad', '127.0.0.1', 'test2@gmail.com', 'Рожнова Т.Г.', 0, ''),
(3, 'test3', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '', '', 'test5@gmail.com', 'Ермак Д.О.', 3, 'КИУКИ-17-1'),
(6, 'admin', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '810c4bf1a4a38cc21c118a170de804c3ff0e9c43', '127.0.0.1', '', 'Донченко А.О.', 3, 'КИУКИ-17-1'),
(11, '', '', '0e0c53d955915fa74ceb66c6778319e9df971607', '127.0.0.1', 'roman.kondrashev@nure.ua', 'Кондрашев Р.', 0, ''),
(12, '', '', '8520cc2b387ca66ab00ba300b2d736d57663ad96', '127.0.0.1', 'romakondrashev@gmail.com', 'Lakost', 0, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `queues`
--
ALTER TABLE `queues`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `queue_user`
--
ALTER TABLE `queue_user`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `queues`
--
ALTER TABLE `queues`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `queue_user`
--
ALTER TABLE `queue_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
