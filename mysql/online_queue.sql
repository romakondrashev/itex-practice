-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 23 2020 г., 04:36
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
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `queues`
--

INSERT INTO `queues` (`ID`, `author_FID`, `title`, `description`, `discipline`, `place`, `date`) VALUES
(3, 2, 'Практические занятия', 'Сдача ИДЗ по 2-му модулю', 'ИПЗ', '37з', '2020-05-20 21:00:00'),
(5, 1, 'Лабораторные работы', 'Проведение Консультации', 'ITEX', '108i', '2020-05-30 21:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `queue_user`
--

CREATE TABLE `queue_user` (
  `ID` int(11) NOT NULL,
  `FID_queue` int(11) NOT NULL,
  `FID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `queue_user`
--

INSERT INTO `queue_user` (`ID`, `FID_queue`, `FID_user`) VALUES
(14, 3, 4),
(23, 3, 1);

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
(1, 'test', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '98818439c4a406637852e9fcd0ffb462ca6fbb09', '::1', 'test@gmail.com', 'Иващенко Г.С.', 0, ''),
(2, 'test2', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '', '', 'test2@gmail.com', 'Рожнова Т.Г.', 0, ''),
(3, 'test3', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '', '', 'test5@gmail.com', 'Ермак Д.О.', 3, 'КИУКИ-17-1'),
(4, 'romakondrashev', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '', '', 'roman.kondrashev@nure.ua', 'Кондрашев Р.А.', 3, 'КИУКИ-17-1'),
(6, 'admin', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', 'dc3d3d2e229f02b8450e401cff6b35fc8e1af44d', '::1', '', 'Кондрашёв Р.А.', 3, 'КИУКИ-17-1');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `queue_user`
--
ALTER TABLE `queue_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
