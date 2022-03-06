-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2022 at 01:14 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test2`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--

CREATE TABLE `kategorije` (
  `idKategorije` int(11) NOT NULL,
  `naziv_kategorije` varchar(50) DEFAULT NULL,
  `slika_kategorije` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`idKategorije`, `naziv_kategorije`, `slika_kategorije`) VALUES
(1, 'Biologijia', 'biologija.jpg'),
(2, 'Kemija', 'kemija.jpg'),
(3, 'Fizika', 'fizika.jpg'),
(5, 'Matematika', 'matematika.jpg'),
(6, 'Povijest', 'povijest.jpg'),
(7, 'Psihologija', 'psihologija.jpg'),
(8, 'Računarstvo', 'racunarstvo.jpg'),
(9, 'Ekonomija', 'ekonomija.jpg'),
(10, 'Elektrotehnika', 'elektrotehnika.jpg'),
(11, 'Filozofija', 'filozofija.jpg'),
(12, 'Pedagogija', 'pedagogija.jpg'),
(13, 'Politologija', 'politologija.jpg'),
(14, 'Računarstvo', 'racunarstvo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lekcije`
--

CREATE TABLE `lekcije` (
  `idLekcije` int(11) NOT NULL,
  `predavac` int(11) NOT NULL,
  `predavanja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lekcije`
--

INSERT INTO `lekcije` (`idLekcije`, `predavac`, `predavanja`) VALUES
(1, 1, 1),
(2, 7, 2),
(3, 8, 3),
(4, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `predavaci`
--

CREATE TABLE `predavaci` (
  `idPredavac` int(11) NOT NULL,
  `ime` varchar(50) DEFAULT NULL,
  `prezime` varchar(50) DEFAULT NULL,
  `slika_predavaca` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `predavaci`
--

INSERT INTO `predavaci` (`idPredavac`, `ime`, `prezime`, `slika_predavaca`) VALUES
(1, 'Robert', 'Sapolsky', 'rsapolsky.jpg'),
(7, 'Eric', 'Lander', 'elander.jpg'),
(8, 'Vincent', 'Racaniello', 'vracaniello.jpg'),
(9, 'Jonathan', 'Gruber', 'jgruber.jpg'),
(10, 'Anant', 'Agarwal', 'aagarwal.jpg'),
(11, 'Walter', 'Lewin', 'wlewin.jpg'),
(12, 'Dennis', 'Freeman', 'dfreeman.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `predavanja`
--

CREATE TABLE `predavanja` (
  `idPredavanja` int(11) NOT NULL,
  `naziv_predavanja` varchar(50) DEFAULT NULL,
  `jezik` varchar(50) DEFAULT NULL,
  `godina` varchar(50) DEFAULT NULL,
  `broj_predavanja` int(11) DEFAULT NULL,
  `ukupno_trajanje` int(11) DEFAULT NULL,
  `oznaka` varchar(50) DEFAULT NULL,
  `opis_kolegija` text DEFAULT NULL,
  `link_1` varchar(200) DEFAULT NULL,
  `link_2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `predavanja`
--

INSERT INTO `predavanja` (`idPredavanja`, `naziv_predavanja`, `jezik`, `godina`, `broj_predavanja`, `ukupno_trajanje`, `oznaka`, `opis_kolegija`, `link_1`, `link_2`) VALUES
(1, 'Human Behavirol Biology', 'Engleski', '2010.', 25, 36, 'BIO150', 'This course focuses on how to approach complex normal and abnormal behaviors through biology and how to integrate disciplines including sociobiology, ethology, neuroscience, and endocrinology to examine behaviors such as aggression, sexual behavior, language use, and mental illness.', 'https://www.youtube.com/playlist?list=PL848F2368C9', 'http://www.infocobuild.com/education/audio-video-c'),
(2, 'Fundamentals of Biology', 'Engleski', '2011.', 39, 12, 'MIT7.01SC', 'Fundamentals of Biology focuses on the basic principles of biochemistry, molecular biology, genetics, and recombinant DNA. These principles are necessary to understanding the basic mechanisms of life and anchor the biological knowledge that is required to understand many of the challenges in everyday life, from human health and disease to loss of biodiversity and environmental quality.', 'https://www.youtube.com/playlist?list=PLF83B8D8C87', 'https://ocw.mit.edu/courses/biology/7-01sc-fundame'),
(3, 'Virology', 'Engleski', '2021.', 25, 29, 'Biology4310', 'The course will emphasize the common reactions that must be completed by all viruses for successful reproduction within a host cell and survival and spread within a host population. The molecular basis of alternative reproductive cycles, the interactions of viruses with host organisms, and how these lead to disease are presented with examples drawn from a set of representative animal and human viruses, although selected bacterial viruses will be discussed.', 'https://www.youtube.com/playlist?list=PLGhmZX2NKiN', 'https://www.virology.ws/course/'),
(4, 'Principles of Microeconomics', 'Engleski', '2018.', 26, 21, 'MIT14.01', 'This introductory undergraduate course covers the fundamentals of microeconomics. Topics include supply and demand, market equilibrium, consumer theory, production and the behavior of firms, monopoly, oligopoly, welfare economics, public goods, and externalities.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP6', 'https://ocw.mit.edu/courses/economics/14-01-princi');

-- --------------------------------------------------------

--
-- Table structure for table `pripadnost_kategoriji`
--

CREATE TABLE `pripadnost_kategoriji` (
  `idPripadnost_kategoriji` int(11) NOT NULL,
  `predavanje` int(11) NOT NULL,
  `kategorije` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pripadnost_kategoriji`
--

INSERT INTO `pripadnost_kategoriji` (`idPripadnost_kategoriji`, `predavanje`, `kategorije`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `ustanove`
--

CREATE TABLE `ustanove` (
  `idUstanove` int(11) NOT NULL,
  `naziv_ustanove` varchar(50) DEFAULT NULL,
  `drzava` varchar(50) DEFAULT NULL,
  `mjesto` varchar(50) DEFAULT NULL,
  `slika_ustanove` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ustanove`
--

INSERT INTO `ustanove` (`idUstanove`, `naziv_ustanove`, `drzava`, `mjesto`, `slika_ustanove`) VALUES
(1, 'Columbia University', 'USA', 'New York City', 'cu.jpg'),
(2, 'Stanford University', 'USA', 'Palo Alto', 'su.jpg'),
(3, 'Massachusetts Institute of Technology', 'USA', 'Cambridge', 'mit.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `zaposlenje`
--

CREATE TABLE `zaposlenje` (
  `idZaposlenje` int(11) NOT NULL,
  `ustanova` int(11) NOT NULL,
  `predavac` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zaposlenje`
--

INSERT INTO `zaposlenje` (`idZaposlenje`, `ustanova`, `predavac`) VALUES
(1, 2, 1),
(2, 3, 7),
(3, 1, 8),
(4, 3, 9),
(5, 3, 10),
(6, 3, 11),
(7, 3, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`idKategorije`);

--
-- Indexes for table `lekcije`
--
ALTER TABLE `lekcije`
  ADD PRIMARY KEY (`idLekcije`);

--
-- Indexes for table `predavaci`
--
ALTER TABLE `predavaci`
  ADD PRIMARY KEY (`idPredavac`);

--
-- Indexes for table `predavanja`
--
ALTER TABLE `predavanja`
  ADD PRIMARY KEY (`idPredavanja`);

--
-- Indexes for table `pripadnost_kategoriji`
--
ALTER TABLE `pripadnost_kategoriji`
  ADD PRIMARY KEY (`idPripadnost_kategoriji`);

--
-- Indexes for table `ustanove`
--
ALTER TABLE `ustanove`
  ADD PRIMARY KEY (`idUstanove`);

--
-- Indexes for table `zaposlenje`
--
ALTER TABLE `zaposlenje`
  ADD PRIMARY KEY (`idZaposlenje`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `idKategorije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lekcije`
--
ALTER TABLE `lekcije`
  MODIFY `idLekcije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `predavaci`
--
ALTER TABLE `predavaci`
  MODIFY `idPredavac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `predavanja`
--
ALTER TABLE `predavanja`
  MODIFY `idPredavanja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pripadnost_kategoriji`
--
ALTER TABLE `pripadnost_kategoriji`
  MODIFY `idPripadnost_kategoriji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ustanove`
--
ALTER TABLE `ustanove`
  MODIFY `idUstanove` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zaposlenje`
--
ALTER TABLE `zaposlenje`
  MODIFY `idZaposlenje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
