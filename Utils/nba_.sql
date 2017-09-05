-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 12, 2017 at 01:29 
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nba_`
--

-- --------------------------------------------------------

--
-- Table structure for table `Equipos`
--

CREATE TABLE `Equipos` (
  `team_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `team_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `abbreviation` varchar(5) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(4) NOT NULL,
  `conference` varchar(15) NOT NULL,
  `division` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Equipos`
--

INSERT INTO `Equipos` (`team_id`, `active`, `team_name`, `first_name`, `last_name`, `abbreviation`, `city`, `state`, `conference`, `division`) VALUES
(1, 1, 'Atlanta Hawks', 'Atlanta', 'Hawks', 'ATL', 'Atlanta', 'Geor', 'East', 'Southeast'),
(2, 1, 'Boston Celtics', 'Boston', 'Celtics', 'BOS', 'Boston', 'Mass', 'East', 'Atlantic'),
(3, 1, 'Brooklyn Nets', 'Brooklyn', 'Nets', 'BKN', 'Brooklyn', 'New ', 'East', 'Atlantic'),
(4, 1, 'Charlotte Hornets', 'Charlotte', 'Hornets', 'CHA', 'Charlotte', 'Nort', 'East', 'Southeast'),
(5, 1, 'Chicago Bulls', 'Chicago', 'Bulls', 'CHI', 'Chicago', 'Illi', 'East', 'Central'),
(6, 1, 'Cleveland Cavaliers', 'Cleveland', 'Cavaliers', 'CLE', 'Cleveland', 'Ohio', 'East', 'Central'),
(7, 1, 'Dallas Mavericks', 'Dallas', 'Mavericks', 'DAL', 'Dallas', 'Texa', 'West', 'Southwest'),
(8, 1, 'Denver Nuggets', 'Denver', 'Nuggets', 'DEN', 'Denver', 'Colo', 'West', 'Northwest'),
(9, 1, 'Detroit Pistons', 'Detroit', 'Pistons', 'DET', 'Auburn Hills', 'Mich', 'East', 'Central'),
(10, 1, 'Golden State Warriors', 'Golden State', 'Warriors', 'GS', 'Oakland', 'Cali', 'West', 'Pacific'),
(11, 1, 'Houston Rockets', 'Houston', 'Rockets', 'HOU', 'Houston', 'Texa', 'West', 'Southwest'),
(12, 1, 'Indiana Pacers', 'Indiana', 'Pacers', 'IND', 'Indianapolis', 'Indi', 'East', 'Central'),
(13, 1, 'Los Angeles Clippers', 'Los Angeles', 'Clippers', 'LAC', 'Los Angeles', 'Cali', 'West', 'Pacific'),
(14, 1, 'Los Angeles Lakers', 'Los Angeles', 'Lakers', 'LAL', 'Los Angeles', 'Cali', 'West', 'Pacific'),
(15, 1, 'Memphis Grizzlies', 'Memphis', 'Grizzlies', 'MEM', 'Memphis', 'Tenn', 'West', 'Southwest'),
(16, 1, 'Miami Heat', 'Miami', 'Heat', 'MIA', 'Miami', 'Flor', 'East', 'Southeast'),
(17, 1, 'Milwaukee Bucks', 'Milwaukee', 'Bucks', 'MIL', 'Milwaukee', 'Wisc', 'East', 'Central'),
(18, 1, 'Minnesota Timberwolves', 'Minnesota', 'Timberwolves', 'MIN', 'Minneapolis', 'Minn', 'West', 'Northwest'),
(19, 1, 'New Orleans Pelicans', 'New Orleans', 'Pelicans', 'NO', 'New Orleans', 'Loui', 'West', 'Southwest'),
(20, 1, 'New York Knicks', 'New York', 'Knicks', 'NY', 'New York', 'New ', 'East', 'Atlantic'),
(21, 1, 'Oklahoma City Thunder', 'Oklahoma City', 'Thunder', 'OKC', 'Oklahoma City', 'Okla', 'West', 'Northwest'),
(22, 1, 'Orlando Magic', 'Orlando', 'Magic', 'ORL', 'Orlando', 'Flor', 'East', 'Southeast'),
(23, 1, 'Philadelphia 76ers', 'Philadelphia', '76ers', 'PHI', 'Philadelphia', 'Penn', 'East', 'Atlantic'),
(24, 1, 'Phoenix Suns', 'Phoenix', 'Suns', 'PHO', 'Phoenix', 'Ariz', 'West', 'Pacific'),
(25, 1, 'Portland Trail Blazers', 'Portland', 'Trail Blazers', 'POR', 'Portland', 'Oreg', 'West', 'Northwest'),
(26, 1, 'Sacramento Kings', 'Sacramento', 'Kings', 'SAC', 'Sacramento', 'Cali', 'West', 'Pacific'),
(27, 1, 'San Antonio Spurs', 'San Antonio', 'Spurs', 'SA', 'San Antonio', 'Texa', 'West', 'Southwest'),
(28, 1, 'Toronto Raptors', 'Toronto', 'Raptors', 'TOR', 'Toronto', 'Onta', 'East', 'Atlantic'),
(29, 1, 'Utah Jazz', 'Utah', 'Jazz', 'UTA', 'Salt Lake City', 'Utah', 'West', 'Northwest'),
(30, 1, 'Washington Wizards', 'Washington', 'Wizards', 'WAS', 'Washington', 'Dist', 'East', 'Southeast');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `pass`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Equipos`
--
ALTER TABLE `Equipos`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Equipos`
--
ALTER TABLE `Equipos`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
