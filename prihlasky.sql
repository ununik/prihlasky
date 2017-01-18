-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Stř 18. led 2017, 17:33
-- Verze serveru: 5.5.50-0ubuntu0.14.04.1
-- Verze PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `prihlasky`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `slug-name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `udalost_timestamp` int(20) NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `prezentace_gps_N` float NOT NULL,
  `prezentace_gps_E` float NOT NULL,
  `start_gps_N` float NOT NULL,
  `start_gps_E` float NOT NULL,
  `cil_gps_N` float NOT NULL,
  `cil_gps_E` float NOT NULL,
  `prihlasky` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `events`
--

INSERT INTO `events` (`id`, `title`, `slug-name`, `deleted`, `udalost_timestamp`, `email`, `prezentace_gps_N`, `prezentace_gps_E`, `start_gps_N`, `start_gps_E`, `cil_gps_N`, `cil_gps_E`, `prihlasky`) VALUES
(1, 'BÄ›h na Chlum', 'beh-na-chlum', 0, 1487113200, 'ununik@gmail.com', 50.7708, 14.212, 42.7708, 19.212, 50.0708, 14.012, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `admin_path` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `homepage` tinyint(1) NOT NULL DEFAULT '0',
  `admin_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `page404` tinyint(1) NOT NULL DEFAULT '0',
  `admin_log` tinyint(1) NOT NULL DEFAULT '1',
  `navigation` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=14 ;

--
-- Vypisuji data pro tabulku `pages`
--

INSERT INTO `pages` (`id`, `path`, `admin_path`, `title`, `homepage`, `admin_homepage`, `page404`, `admin_log`, `navigation`, `deleted`) VALUES
(1, '', '', '', 1, 0, 0, 0, 2, 0),
(2, '', '', 'Admin', 0, 1, 0, 1, 1, 0),
(3, '', '', '404', 0, 0, 1, 1, 2, 0),
(4, '', 'login', 'Login', 0, 0, 0, 0, 2, 0),
(5, '', 'odhlasit', 'Odhlasit', 0, 0, 0, 1, 0, 0),
(6, '', 'uzivatel', 'Uzivatel', 0, 0, 0, 1, 1, 0),
(7, '', 'smazat-uzivatele', 'Smazat uzivatele', 0, 0, 0, 1, 1, 0),
(8, '', 'nastaveni', 'Nastaveni', 0, 0, 0, 1, 1, 0),
(9, '', 'udalosti', 'Udalosti', 0, 0, 0, 1, 1, 0),
(10, '', 'nova-udalost', 'Nova udalost', 0, 0, 0, 1, 1, 0),
(11, '', 'udalost', 'Udalost', 0, 0, 0, 1, 1, 0),
(12, 'udalost', '', 'Udalost', 0, 0, 0, 0, 2, 0),
(13, 'udalosti', '', 'Udalosti', 0, 0, 0, 0, 2, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `page_controllers`
--

CREATE TABLE IF NOT EXISTS `page_controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL,
  `relative_path` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `page` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `page_controllers`
--

INSERT INTO `page_controllers` (`id`, `sort`, `relative_path`, `page`, `deleted`) VALUES
(1, 1, '/Resources/Controllers/Page/loginForm.php', 4, 0),
(2, 1, '/Resources/Controllers/Page/logout.php', 5, 0),
(3, 1, '/Resources/Controllers/Page/uzivatel.php', 6, 0),
(4, 1, '/Resources/Controllers/Page/smazatUzivatele.php', 7, 0),
(5, 1, '/Resources/Controllers/Page/nastaveni.php', 8, 0),
(6, 1, '/Resources/Controllers/Page/udalost.php', 10, 0),
(7, 1, '/Resources/Controllers/Page/udalost.php', 11, 0),
(8, 1, '/Resources/Controllers/Page/prihlaskyList.php', 9, 0),
(9, 1, '/Resources/Controllers/Page/FE/udalost.php', 12, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `page_navigation`
--

CREATE TABLE IF NOT EXISTS `page_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `navigation` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `page_navigation`
--

INSERT INTO `page_navigation` (`id`, `title`, `pid`, `url`, `navigation`, `sort`, `parent`, `deleted`) VALUES
(1, 'Odhlasit', 5, '', 1, 10, 0, 0),
(6, 'Uzivatel', 6, '', 1, 9, 0, 0),
(7, 'Nastaveni', 8, '', 1, 8, 0, 0),
(8, 'Udalosti', 9, '', 1, 7, 0, 0),
(9, 'Nova udalost', 10, '', 1, 1, 8, 0),
(10, 'Udalosti', 13, '', 2, 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `page_views`
--

CREATE TABLE IF NOT EXISTS `page_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL,
  `relative_path` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `page` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `page_views`
--

INSERT INTO `page_views` (`id`, `sort`, `relative_path`, `page`, `deleted`) VALUES
(1, 1, '/Resources/Templates/Page/loginForm.php', 4, 0),
(2, 1, '/Resources/Templates/Page/uzivatel.php', 6, 0),
(3, 1, '/Resources/Templates/Page/nastaveni.php', 8, 0),
(4, 1, '/Resources/Templates/Page/FE/homepage.php', 1, 0),
(5, 1, '/Resources/Templates/Page/udalost.php', 10, 0),
(6, 1, '/Resources/Templates/Page/udalost.php', 11, 0),
(7, 1, '/Resources/Templates/Page/prihlaskyList.php', 9, 0),
(8, 1, '/Resources/Templates/Page/FE/udalost.php', 12, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `pravomoc_delete_users` tinyint(1) NOT NULL DEFAULT '0',
  `pravomoc_create_users` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `email`, `deleted`, `pravomoc_delete_users`, `pravomoc_create_users`) VALUES
(1, 'ununik', '79d9a0bc799b3121ed83c6cba82c8708', 'Martin PÅ™ibyl', 'ununik@gmail.com', 0, 1, 1),
(2, 'konkord', '154c9b70be39ac333b796930b10f2be6', '', '', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
