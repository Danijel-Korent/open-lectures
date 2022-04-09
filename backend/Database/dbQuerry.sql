-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2022 at 07:16 PM
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
(1, 'Biologija', 'biologija.jpg'),
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
(4, 9, 4),
(5, 13, 5),
(6, 14, 6),
(7, 15, 7),
(8, 16, 8),
(9, 17, 8),
(10, 18, 9),
(11, 18, 10),
(12, 19, 11),
(13, 20, 12);

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
(12, 'Dennis', 'Freeman', 'dfreeman.jpg'),
(13, 'Bruce', 'Land', NULL),
(14, 'Shelly', 'Kagan', NULL),
(15, 'Richard', 'A. Muller', NULL),
(16, 'Catherine', 'Drennan', NULL),
(17, 'Elizabeth', 'Vogel Taylor', NULL),
(18, 'Richard', 'Delaware', NULL),
(19, 'Sanjoy', 'Mahajan', NULL),
(20, 'Kathleen', 'Bawn', NULL);

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
  `link_2` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `predavanja`
--

INSERT INTO `predavanja` (`idPredavanja`, `naziv_predavanja`, `jezik`, `godina`, `broj_predavanja`, `ukupno_trajanje`, `oznaka`, `opis_kolegija`, `link_1`, `link_2`, `image`) VALUES
(1, 'Human Behavirol Biology', 'Engleski', '2010.', 25, 36, 'BIO150', 'This course focuses on how to approach complex normal and abnormal behaviors through biology and how to integrate disciplines including sociobiology, ethology, neuroscience, and endocrinology to examine behaviors such as aggression, sexual behavior, language use, and mental illness.', 'https://www.youtube.com/playlist?list=PL848F2368C90DDC3D', 'http://www.infocobuild.com/education/audio-video-c', 'https://img.youtube.com/vi/Y0Oa4Lp5fLE/0.jpg'),
(2, 'Fundamentals of Biology', 'Engleski', '2011.', 39, 12, 'MIT7.01SC', 'Fundamentals of Biology focuses on the basic principles of biochemistry, molecular biology, genetics, and recombinant DNA. These principles are necessary to understanding the basic mechanisms of life and anchor the biological knowledge that is required to understand many of the challenges in everyday life, from human health and disease to loss of biodiversity and environmental quality.', 'https://www.youtube.com/playlist?list=PLF83B8D8C87426E44', 'https://ocw.mit.edu/courses/biology/7-01sc-fundame', 'https://img.youtube.com/vi/1eGsdK1fPLM/0.jpg'),
(3, 'Virology', 'Engleski', '2021.', 25, 29, 'Biology4310', 'The course will emphasize the common reactions that must be completed by all viruses for successful reproduction within a host cell and survival and spread within a host population. The molecular basis of alternative reproductive cycles, the interactions of viruses with host organisms, and how these lead to disease are presented with examples drawn from a set of representative animal and human viruses, although selected bacterial viruses will be discussed.', 'https://www.youtube.com/playlist?list=PLGhmZX2NKiNm0vqVhoYB_xZP6E6tGT6rU', 'https://www.virology.ws/course/', 'https://img.youtube.com/vi/jX3MhWWi6n4/0.jpg'),
(4, 'Principles of Microeconomics', 'Engleski', '2018.', 26, 21, 'MIT14.01', 'This introductory undergraduate course covers the fundamentals of microeconomics. Topics include supply and demand, market equilibrium, consumer theory, production and the behavior of firms, monopoly, oligopoly, welfare economics, public goods, and externalities.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP62oJSoqb4Rf-vZMGUBe59G-', 'https://ocw.mit.edu/courses/economics/14-01-princi', 'https://img.youtube.com/vi/BNy84DCRxzo/0.jpg'),
(5, 'AVR microcontroller lectures', 'Engleski', '2012.', 34, 29, 'ECE 4760', '	MIcrocontroller design course. ECE 4760 deals with microcontrollers as components in electronic design and embedded control.', 'https://www.youtube.com/playlist?list=PLD7F7ED1F3505D8D5', 'http://people.ece.cornell.edu/land/courses/ece4760/', 'https://img.youtube.com/vi/uEAQCBJhhHI/0.jpg'),
(6, 'Death', 'Engleski', '2007.', 26, 21, 'PHIL 176', 'There is one thing I can be sure of: I am going to die. But what am I to make of that fact? This course will examine a number of issues that arise once we begin to reflect on our mortality. The possibility that death may not actually be the end is considered. Are we, in some sense, immortal? Would immortality be desirable? Also a clearer notion of what it is to die is examined. What does it mean to say that a person has died? What kind of fact is that? And, finally, different attitudes to death are evaluated. Is death an evil? How? Why? Is suicide morally permissible? Is it rational? How should the knowledge that I am going to die affect the way I live my life?', 'https://www.youtube.com/playlist?list=PLEA18FAF1AD9047B0', 'https://oyc.yale.edu/death/phil-176', 'https://img.youtube.com/vi/p2J7wSuFRl8/0.jpg'),
(7, 'Physics for Future Presidents', 'Engleski', '2006.', 26, 29, 'PHYS 10', 'Yes, the title of the colloquium is serious. Energy, global warming, terrorism and counter-terrorism, nukes, internet, satellites, remote sensing, ICBMs and ABMs, DVDs and HDTVs -- economic and political issues increasingly have a strong high tech content. Misjudge the science, make a wrong decision. Yet many of our leaders never studied physics, and do not understand science and technology. Physics is the liberal arts of high tech. Is science too hard for world leaders to learn? No. Think of an analogous example: Charlemagne was only half literate. He could read but not write. Writing was a skill considered too tough even for world leaders, just as physics is today. And yet now most of the world is literate.', 'https://www.youtube.com/playlist?list=PLaLOVNqqD-2Ep5N9os9jWMSkxK_TLki9h', 'https://physics.berkeley.edu/physics-for-future-presidents', 'https://img.youtube.com/vi/PCdDFplPfMQ/0.jpg'),
(8, 'Principles of Chemical Science', 'Engleski', '2008.', 36, 27, 'MIT 5.111', 'This course provides an introduction to the chemistry of biological, inorganic, and organic molecules. The emphasis is on basic principles of atomic and molecular electronic structure, thermodynamics, acid-base and redox equilibria, chemical kinetics, and catalysis.', 'https://www.youtube.com/playlist?list=PL2902385153144A26', 'https://ocw.mit.edu/courses/chemistry/5-111-principles-of-chemical-science-fall-2008/', 'https://img.youtube.com/vi/l-BNoAPe6qo/0.jpg'),
(9, 'College Algebra', 'Engleski', '1998.', 40, 43, 'Math 110', '	College Algebra Lectures with UMKC\'s Professor Richard Delaware, in association with UMKC\'s Video Based Supplemental Instruction Program.', 'https://www.youtube.com/playlist?list=PLDE28CF08BD313B2A', 'http://d.web.umkc.edu/delawarer/VSI/RDvsi.htm', 'https://img.youtube.com/vi/SQI97IAUqo8/0.jpg'),
(10, 'Calculus I', 'Engleski', '2005.', 36, 30, '	Math 210', 'Calculus 1/ Calc 1 with UMKC\'s Professor Richard Delaware, in association with UMKC\'s Video Based Supplemental Instruction Program', 'https://www.youtube.com/playlist?list=PLF5E22224459D23D9', 'http://d.web.umkc.edu/delawarer/VSI/RDvsiCalc.htm', 'https://img.youtube.com/vi/CtRAHmeWSC0/0.jpg'),
(11, 'Teaching College-Level Science and Engineering', 'Engleski', '2009.', 11, 15, 'MIT 5.95J', 'This participatory seminar focuses on the knowledge and skills necessary for teaching science and engineering in higher education. This course is designed for graduate students interested in an academic career, and anyone else interested in teaching. Readings and discussions include: teaching equations for understanding, designing exam and homework questions, incorporating histories of science, creating absorbing lectures, teaching for transfer, the evils of PowerPoint, and planning a course. The subject is appropriate for both novices and those with teaching experience.', 'https://www.youtube.com/playlist?list=PLB1304385546D6F86', 'https://ocw.mit.edu/courses/chemistry/5-95j-teaching-college-level-science-and-engineering-spring-2009/', 'https://img.youtube.com/vi/wy-LqFDwMuM/0.jpg'),
(12, 'Political Science 30: Politics and Strategy', 'Engleski', '2008.', 19, 21, 'POL SCI 30', 'Taught by UCLA\'s Professor Kathleen Bawn, this courses is an introduction to study of strategic interaction in political applications. Use of game theory and other formal modeling strategies to understand politics are also studied in order to gain a better understanding of politics at large.', 'https://www.youtube.com/playlist?list=PLF420ADB3E328425A', NULL, 'https://img.youtube.com/vi/eoHSEacM7Fo/0.jpg');

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
(4, 4, 9),
(5, 5, 10),
(6, 6, 11),
(7, 7, 3),
(8, 8, 2),
(9, 9, 5),
(10, 10, 5),
(11, 11, 12),
(12, 12, 13);

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
(3, 'Massachusetts Institute of Technology', 'USA', 'Cambridge', 'mit.jpg'),
(4, 'Cornell University', 'USA', 'New York City', NULL),
(5, 'Yale University', 'USA', 'New Haven', NULL),
(6, 'University of California, Berkeley', 'USA', 'Berkeley ', NULL),
(7, '	University of Missouri–Kansas City', 'USA', 'Kansas City', NULL),
(8, 'University of California, Los Angeles', 'USA', 'Los Angeles', NULL);

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
(7, 3, 12),
(8, 4, 13),
(9, 5, 14),
(10, 6, 15),
(11, 3, 16),
(12, 3, 17),
(13, 7, 18),
(14, 3, 19),
(15, 8, 20);

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
  MODIFY `idLekcije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `predavaci`
--
ALTER TABLE `predavaci`
  MODIFY `idPredavac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `predavanja`
--
ALTER TABLE `predavanja`
  MODIFY `idPredavanja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pripadnost_kategoriji`
--
ALTER TABLE `pripadnost_kategoriji`
  MODIFY `idPripadnost_kategoriji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ustanove`
--
ALTER TABLE `ustanove`
  MODIFY `idUstanove` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zaposlenje`
--
ALTER TABLE `zaposlenje`
  MODIFY `idZaposlenje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
