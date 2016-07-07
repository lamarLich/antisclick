-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 07 2016 г., 08:05
-- Версия сервера: 5.6.14
-- Версия PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `db_anticlick`
--

-- --------------------------------------------------------

--
-- Структура таблицы `click`
--

CREATE TABLE IF NOT EXISTS `click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_IP` int(11) NOT NULL,
  `userAgent` varchar(255) NOT NULL,
  `width_screen` int(11) NOT NULL,
  `height_screen` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_Site` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Click_fk0` (`id_IP`),
  KEY `Click_fk1` (`id_Site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(16) NOT NULL,
  `isBad` tinyint(1) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `id_User` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Site_fk0` (`id_User`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `K_min` int(11) NOT NULL,
  `N_sec` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_region`
--

CREATE TABLE IF NOT EXISTS `user_region` (
  `id_User` int(11) NOT NULL,
  `id_Region` int(11) NOT NULL,
  KEY `User_Region_fk0` (`id_User`),
  KEY `User_Region_fk1` (`id_Region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `click`
--
ALTER TABLE `click`
  ADD CONSTRAINT `Click_fk1` FOREIGN KEY (`id_Site`) REFERENCES `site` (`id`),
  ADD CONSTRAINT `Click_fk0` FOREIGN KEY (`id_IP`) REFERENCES `ip` (`id`);

--
-- Ограничения внешнего ключа таблицы `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `Site_fk0` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_region`
--
ALTER TABLE `user_region`
  ADD CONSTRAINT `User_Region_fk1` FOREIGN KEY (`id_Region`) REFERENCES `region` (`id`),
  ADD CONSTRAINT `User_Region_fk0` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
