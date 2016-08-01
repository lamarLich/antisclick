-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 24 2016 г., 12:45
-- Версия сервера: 5.5.43
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `landofbrand`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

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
  `time_in` int(12) NOT NULL,
  `time_out` int(12) DEFAULT NULL,
  `id_Site` int(11) NOT NULL,
  `utm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `click_fk0` (`id_IP`),
  KEY `click_fk1` (`id_Site`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(16) NOT NULL,
  `isBad` tinyint(1) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `history` varchar(555) DEFAULT NULL,
  `hostname` varchar(500),
  `provider` varchar(500),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=692 ;

-- --------------------------------------------------------

--
-- Структура таблицы `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `id_User` int(11) NOT NULL,
  `K_min` int(11) NOT NULL DEFAULT '2',
  `N_sec` int(11) NOT NULL DEFAULT '20',
  PRIMARY KEY (`id`),
  KEY `site_fk0` (`id_User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Структура таблицы `site_city`
--

CREATE TABLE IF NOT EXISTS `site_city` (
  `id_Site` int(11) NOT NULL,
  `id_City` int(11) NOT NULL,
  UNIQUE KEY `id_Site` (`id_Site`,`id_City`),
  KEY `site_city_fk1` (`id_City`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1078 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `click`
--
ALTER TABLE `click`
  ADD CONSTRAINT `click_fk1` FOREIGN KEY (`id_Site`) REFERENCES `site` (`id`),
  ADD CONSTRAINT `click_fk0` FOREIGN KEY (`id_IP`) REFERENCES `ip` (`id`);

--
-- Ограничения внешнего ключа таблицы `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `site_fk0` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `site_city`
--
ALTER TABLE `site_city`
  ADD CONSTRAINT `site_city_fk0` FOREIGN KEY (`id_Site`) REFERENCES `site` (`id`),
  ADD CONSTRAINT `site_city_fk1` FOREIGN KEY (`id_City`) REFERENCES `city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
