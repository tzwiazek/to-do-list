-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Kwi 2018, 20:22
-- Wersja serwera: 10.1.29-MariaDB
-- Wersja PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `to_do_list`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `to_do_list`
--

CREATE TABLE `to_do_list` (
  `ID` int(11) NOT NULL,
  `Title` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Text` varchar(250) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Status` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `to_do_list`
--

INSERT INTO `to_do_list` (`ID`, `Title`, `Text`, `Status`) VALUES
(6, 'test', 'test', 'IN PROGRESS'),
(14, 'Test', 'test', 'NEEDS REVIEW'),
(15, 'test', 'test2', 'IN PROGRESS');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `to_do_list`
--
ALTER TABLE `to_do_list`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `to_do_list`
--
ALTER TABLE `to_do_list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
