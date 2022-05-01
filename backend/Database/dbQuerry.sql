-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2022 at 10:38 PM
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
(14, NULL, NULL),
(15, 'Nekategorizirano', NULL);

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
(9, 0, 0),
(10, 18, 9),
(11, 18, 10),
(12, 19, 11),
(13, 20, 12),
(14, 21, 13),
(15, 22, 14),
(16, 23, 15),
(17, 24, 16),
(18, 25, 17),
(19, 26, 18),
(20, 27, 19),
(21, 28, 20),
(22, 29, 21),
(23, 30, 22),
(24, 31, 23),
(25, 8, 24),
(26, 32, 25),
(27, 33, 26),
(28, 34, 27),
(29, 35, 28),
(30, 36, 29),
(31, 36, 30),
(32, 37, 31),
(33, 37, 32),
(34, 38, 33),
(35, 39, 34),
(36, 40, 35),
(37, 41, 36),
(38, 42, 37),
(39, 43, 38),
(40, 44, 39),
(41, 45, 40),
(42, 46, 41),
(43, 47, 42),
(44, 48, 43),
(45, 49, 44),
(46, 50, 45),
(47, 51, 46),
(48, 52, 47),
(49, 53, 48),
(50, 53, 49),
(51, 54, 50),
(52, 55, 51),
(53, 56, 52),
(54, 57, 53),
(55, 58, 54),
(56, 59, 55),
(57, 60, 56),
(58, 61, 57),
(59, 62, 58),
(60, 63, 59),
(61, 64, 60),
(62, 65, 61),
(63, 66, 62),
(64, 27, 63),
(65, 67, 64),
(66, 67, 65),
(67, 26, 66),
(68, 68, 67),
(69, 69, 68),
(70, 70, 69),
(71, 71, 70),
(72, 72, 71),
(73, 73, 72),
(74, 74, 73),
(75, 75, 74),
(76, 13, 75),
(77, 77, 76),
(78, 78, 77),
(79, 79, 78),
(80, 80, 79),
(81, 81, 80),
(82, 82, 81),
(83, 83, 82),
(84, 84, 83),
(85, 85, 84),
(86, 86, 85),
(87, 87, 86),
(88, 88, 88),
(89, 88, 89),
(90, 89, 90),
(91, 89, 91),
(92, 89, 92),
(93, 90, 93),
(94, 91, 94),
(95, 92, 95),
(96, 93, 96),
(97, 94, 97),
(98, 95, 98),
(99, 96, 99),
(100, 97, 100),
(101, 98, 101),
(102, 99, 102);

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
(20, 'Kathleen', 'Bawn', NULL),
(21, 'Donald', 'Kagan', NULL),
(22, 'John', 'Gabrieli', NULL),
(23, 'David', 'J. Malan', NULL),
(24, 'Amir', 'H. Ashouri', NULL),
(25, 'Alexander', 'Amini', NULL),
(26, 'David', 'Churchill', NULL),
(27, 'Onur', 'Mutlu', NULL),
(28, 'Robert', 'Wyman', NULL),
(29, 'Rachel', 'Glennerster', NULL),
(30, 'Jeffrey', 'Hoffman', NULL),
(31, 'Barbara', 'Imperiali', NULL),
(32, 'Stephen', 'C. Stearns', NULL),
(33, 'Mark', 'Saltzman', NULL),
(34, 'Denis', 'Auroux', NULL),
(35, 'Arthur', 'Mattuck', NULL),
(36, 'Gilbert', 'Strang', NULL),
(37, 'Klaus-Jürgen', 'Bathe', NULL),
(38, 'Michael', 'C. Cranston', NULL),
(39, 'Elizabeth', 'Baue', NULL),
(40, 'Brad', 'Osgood', NULL),
(41, 'Esther', 'Duflo', NULL),
(42, 'John', 'Geanakoplos', NULL),
(43, 'Andrew', 'Lo', NULL),
(44, 'Robert', 'Shiller', NULL),
(45, 'Ben', 'Polak', NULL),
(46, 'Nirupama', 'Rao', NULL),
(47, 'Brian', 'Subirana', NULL),
(48, 'Earll', 'Murman', NULL),
(49, 'Paul', 'Bloom', NULL),
(50, '	Ceasar', 'McDowell', NULL),
(51, 'Benjamin', 'Karney', NULL),
(52, '	Kelly', 'D. Brownell', NULL),
(53, 'Michael', 'J. McBride', NULL),
(54, 'Robert', 'Field', NULL),
(55, 'Donald', 'Sadoway', NULL),
(56, 'Keith', 'A. Nelson', NULL),
(57, 'James', 'Paradis', NULL),
(58, 'Tamar', 'Gendler', NULL),
(59, 'Malcom', 'Ryan', NULL),
(60, 'Erik', 'Demaine', NULL),
(61, 'Charles', 'Leiserson', NULL),
(62, 'Saman', 'Amarasinghe', NULL),
(63, 'Mehran', 'Sahami', NULL),
(64, 'Julie', 'Zelenski', NULL),
(65, 'Jerry', 'Cain', NULL),
(66, 'Geoffrey', 'Challen', NULL),
(67, 'Andrew', 'Ng', NULL),
(68, 'Steven', 'B. Smith', NULL),
(69, 'Ian', 'Shapiro', NULL),
(70, 'John', 'Wargo', NULL),
(71, 'Douglas', 'W. Rae', NULL),
(72, 'Anant', 'Agarwal', NULL),
(73, 'Nonie', 'Politi', NULL),
(74, 'Dennis', 'Freeman', NULL),
(75, 'James', 'Roberge', NULL),
(77, 'Diana', 'E. E. Kleiner', NULL),
(78, 'Paul', 'Freedman', NULL),
(79, 'Keith', 'E. Wrightson', NULL),
(80, 'John', 'Merriman', NULL),
(81, 'Frank', 'Snowden', NULL),
(82, 'Joanne', 'Freeman', NULL),
(83, 'David', 'W. Blight', NULL),
(84, 'John', 'Merriman', NULL),
(85, 'Jonathan', 'Holloway', NULL),
(86, 'Daniel', 'Walkowitz', NULL),
(87, 'Daniel', 'Fleming', NULL),
(88, 'Ramamurti', 'Shankar', NULL),
(89, 'Walter', 'Lewin	', NULL),
(90, 'Allan', 'Adams', NULL),
(91, 'Barton', 'Zwiebach', NULL),
(92, 'James', 'Binney', NULL),
(93, 'Charles', 'Bailyn', NULL),
(94, 'Iván', 'Szelényi', NULL),
(95, 'David', 'Hardt', NULL),
(96, 'Gerbrand', 'Ceder', NULL),
(97, 'Leo', 'Anthony Celi', NULL),
(98, 'Michael', 'Short', NULL),
(99, 'Andrew', 'Kadak', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `predavanja`
--

CREATE TABLE `predavanja` (
  `idPredavanja` int(11) NOT NULL,
  `naziv_predavanja` varchar(60) DEFAULT NULL,
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
(12, 'Political Science 30: Politics and Strategy', 'Engleski', '2008.', 19, 21, 'POL SCI 30', 'Taught by UCLA\'s Professor Kathleen Bawn, this courses is an introduction to study of strategic interaction in political applications. Use of game theory and other formal modeling strategies to understand politics are also studied in order to gain a better understanding of politics at large.', 'https://www.youtube.com/playlist?list=PLF420ADB3E328425A', NULL, 'https://img.youtube.com/vi/eoHSEacM7Fo/0.jpg'),
(13, 'Introduction to Ancient Greek History', 'Engleski', '2007.', 24, 28, 'CLCV 205', 'This is an introductory course in Greek history tracing the development of Greek civilization as manifested in political, intellectual, and creative achievements from the Bronze Age to the end of the classical period. Students read original sources in translation as well as the works of modern scholars.', 'https://www.youtube.com/playlist?list=PL023BCE5134243987', 'https://oyc.yale.edu/classics/clcv-205', 'https://img.youtube.com/vi/BB-i7hZadLc/0.jpg'),
(14, 'Introduction to Psychology', 'Engleski', '2011.', 24, 23, 'MIT 9.00SC', 'Introduction to Psychology is a survey of the scientific study of human nature, including how the mind works, and how the brain supports the mind. Topics include the mental and neural bases of perception, emotion, learning, memory, cognition, child development, personality, psychopathology, and social interaction.', 'https://www.youtube.com/playlist?list=PL44ABC9278E2EE706', NULL, 'https://img.youtube.com/vi/2fbrl6WoIyo/0.jpg'),
(15, 'Introduction to Computer Science I', 'Engleski', '2020.', 13, 27, 'CS50', 'CS50 is Harvard University\'s introduction to the intellectual enterprises of computer science and the art of programming.', 'https://www.youtube.com/playlist?list=PLhQjrBD2T382_R182iC2gNZI9HzWFMC_8', 'https://cs50.harvard.edu/', 'https://img.youtube.com/vi/zYierUhIFNQ/0.jpg'),
(16, 'Introduction to Machine Learning', 'Engleski', '2019.', 38, 28, 'ECE421/ECE1513', 'An Introduction to the basic theory, the fundamental algorithms, and the computational toolboxes of machine learning.', 'https://www.youtube.com/playlist?list=PL-Mfq5QS-s8iS9XqKuApPE1TSlnZblFHF', 'https://engineering.calendar.utoronto.ca/course/ece421h1', 'https://img.youtube.com/vi/FvAibtlARQ8/0.jpg'),
(17, 'Introduction to Deep Learning', 'Engleski', '2021.', 43, 29, '6.S191', 'MIT\'s introductory course on deep learning methods with applications to computer vision, natural language processing, biology, and more! Students will gain foundational knowledge of deep learning algorithms and get practical experience in building neural networks in TensorFlow. Course concludes with a project proposal competition with feedback from staff and panel of industry sponsors. Prerequisites assume calculus (i.e. taking derivatives) and linear algebra (i.e. matrix multiplication), we\'ll try to explain everything else along the way! Experience in Python is helpful but not necessary. This class is taught during MIT\'s IAP term by current MIT PhD researchers.', 'https://www.youtube.com/playlist?list=PLtBw6njQRU-rwp5__7C0oIVt26ZgjG9NI', 'http://introtodeeplearning.com/', 'https://img.youtube.com/vi/uapdILWYTzE/0.jpg'),
(18, 'Intro to Game Programming', 'Engleski', '2021.', 22, 27, '	COMP 4300', '	This is an introductory course for students interested in learning the fundamentals of game programming. Topics include vector math for games, fundamentals of rendering, introduction to animation and artificial intelligence, collision detection, game physics and user-interfaces.', 'https://www.youtube.com/playlist?list=PL_xRyXins848jkwC9Coy7B4N5XTOnQZzz', 'http://www.cs.mun.ca/~dchurchill/teaching.shtml', 'https://img.youtube.com/vi/LpEdZbUdDe4/0.jpg'),
(19, 'Digital Design and Computer Architecture', 'Engleski', '2020.', 38, 44, NULL, '	The class provides a first introduction to the design of digital circuits and computer architecture. It covers technical foundations of how a computing platform is designed from the bottom up. It introduces various execution paradigms, hardware description languages, and principles in digital design and computer architecture. The focus is on fundamental techniques employed in the design of modern microprocessors and their hardware/software interface.', 'https://www.youtube.com/playlist?list=PL5PHm2jkkXmhs4EACiFKvTPAQkdYMZKGu', 'https://safari.ethz.ch/digitaltechnik/spring2020/doku.php?id=schedule', 'https://img.youtube.com/vi/AJBmIaUneB0/0.jpg'),
(20, 'Global Problems of Population Growth', 'Engleski', '2009.', 24, 27, '	MCDB 150', 'This survey course introduces students to the important and basic material on human fertility, population growth, the demographic transition and population policy. Topics include: the human and environmental dimensions of population pressure, demographic history, economic and cultural causes of demographic change, environmental carrying capacity and sustainability. Political, religious and ethical issues surrounding fertility are also addressed. The lectures and readings attempt to balance theoretical and demographic scale analyzes with studies of individual humans and communities. The perspective is global with both developed and developing countries included.', 'https://www.youtube.com/playlist?list=PLE60A08636F41C128', 'https://oyc.yale.edu/molecular-cellular-and-developmental-biology/mcdb-150', 'https://img.youtube.com/vi/mzdqyXtPbbE/0.jpg'),
(21, 'Evaluating Social Programs', 'Engleski', '2009.', 8, 12, 'RES.14-001', 'This five-day program on evaluating social programs will provide a thorough understanding of randomized evaluations and pragmatic step-by-step training for conducting one\'s own evaluation. While the course focuses on randomized evaluations, many of the topics, such as measuring outcomes and dealing with threats to the validity of an evaluation, are relevant for other methodologies.', 'https://www.youtube.com/playlist?list=PLFDDC7E64FF1EE996', 'https://ocw.mit.edu/resources/res-14-001-abdul-latif-jameel-poverty-action-lab-executive-training-evaluating-social-programs-2009-spring-2009/', 'https://img.youtube.com/vi/Hz1S82W8F04/0.jpg'),
(22, 'Aircraft Systems Engineering (study of Space Shuttle)', 'Engleski', '2005.', 23, 40, '16.885J / ESD.35J', '16.885J offers a holistic view of the aircraft as a system, covering: basic systems engineering; cost and weight estimation; basic aircraft performance; safety and reliability; lifecycle topics; aircraft subsystems; risk analysis and management; and system realization. Small student teams retrospectively analyze an existing aircraft covering: key design drivers and decisions; aircraft attributes and subsystems; and operational experience. Oral and written versions of the case study are delivered. For the Fall 2005 term, the class focuses on a systems engineering analysis of the Space Shuttle. It offers study of both design and operations of the shuttle, with frequent lectures by outside experts. Students choose specific shuttle systems for detailed analysis and develop new subsystem designs using state of the art technology.', 'https://www.youtube.com/playlist?list=PL35721A60B7B57386', 'https://ocw.mit.edu/courses/aeronautics-and-astronautics/16-885j-aircraft-systems-engineering-fall-2005/', 'https://img.youtube.com/vi/iiYhQtGpRhc/0.jpg'),
(23, 'Introductory Biology', 'Engleski', '2018.', 35, 28, 'MIT 7.016', 'Introductory Biology provides an introduction to fundamental principles of biochemistry, molecular biology and genetics for understanding the functions of living systems. Taught for the first time in Fall 2013, this course covers examples of the use of chemical biology and twenty-first-century molecular genetics in understanding human health and therapeutic intervention.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP63LmSVIVzy584-ZbjbJ-Y63', 'https://ocw.mit.edu/courses/biology/7-016-introductory-biology-fall-2018/', 'https://img.youtube.com/vi/KlVHqq38KJU/0.jpg'),
(24, 'Virology', 'Engleski', '2011.', 26, 30, 'Biology W3310', 'The course will emphasize the common reactions that must be completed by all viruses for successful reproduction within a host cell and survival and spread within a host population. The molecular basis of alternative reproductive cycles, the interactions of viruses with host organisms, and how these lead to disease are presented with examples drawn from a set of representative animal and human viruses, although selected bacterial viruses will be discussed.', 'https://www.youtube.com/playlist?list=PLF03C29905EF9A6CA', NULL, 'https://img.youtube.com/vi/E0rpsjyo3C0/0.jpg'),
(25, 'Principles of Evolution, Ecology and Behavior', 'Engleski', '2009.', 36, 27, 'EEB 122', 'This course presents the principles of evolution, ecology, and behavior for students beginning their study of biology and of the environment. It discusses major ideas and results in a manner accessible to all Yale College undergraduates. Recent advances have energized these fields with results that have implications well beyond their boundaries: ideas, mechanisms, and processes that should form part of the toolkit of all biologists and educated citizens.', 'https://www.youtube.com/playlist?list=PL6299F3195349CCDA', 'http://oyc.yale.edu/ecology-and-evolutionary-biology/eeb-122', 'https://img.youtube.com/vi/WJayMGhZxO0/0.jpg'),
(26, 'Frontiers of Biomedical Engineering', 'Engleski', '2008.', 25, 20, 'BENG 100', 'The course covers basic concepts of biomedical engineering and their connection with the spectrum of human activity. It serves as an introduction to the fundamental science and engineering on which biomedical engineering is based. Case studies of drugs and medical products illustrate the product development-product testing cycle, patent protection, and FDA approval. It is designed for science and non-science majors.', 'https://www.youtube.com/playlist?list=PL27E877E8206F196B', 'http://oyc.yale.edu/biomedical-engineering/beng-100', 'https://img.youtube.com/vi/Sn0bOX5Hau4/0.jpg'),
(27, 'Multivariable Calculus', 'Engleski', '2007.', 35, 28, '18.02', '	This course covers vector and multi-variable calculus. It is the second semester in the freshman calculus sequence. Topics include vectors and matrices, partial derivatives, double and triple integrals, and vector calculus in 2 and 3-space.', 'https://www.youtube.com/playlist?list=PL4C4C8A7D06566F38', 'https://ocw.mit.edu/courses/mathematics/18-02-multivariable-calculus-fall-2007/', 'https://img.youtube.com/vi/PxCxlsl_YwY/0.jpg'),
(28, 'Differential Equations', 'Engleski', '2011.', 32, 31, '18.03SC', 'Differential equations are the language in which the laws of nature are expressed. Understanding properties of solutions of differential equations is fundamental to much of contemporary science and engineering. Ordinary differential equations (ODE\'s) deal with functions of one variable, which can often be thought of as time.', 'https://www.youtube.com/playlist?list=PL64BDFBDA2AF24F7E', 'https://ocw.mit.edu/courses/mathematics/18-03sc-differential-equations-fall-2011/', 'https://img.youtube.com/vi/jOBBwI4CYjM/0.jpg'),
(29, 'Mathematical Methods for Engineers I / Computational Science', 'Engleski', '2008.', 50, 42, '18.085', 'This course provides a review of linear algebra, including applications to networks, structures, and estimation, Lagrange multipliers. Also covered are: differential equations of equilibrium; Laplace\'s equation and potential flow; boundary-value problems; minimum principles and calculus of variations; Fourier series; discrete Fourier transform; convolution; and applications.\r\nNote: This course was previously called \"Mathematical Methods for Engineers I.', 'https://www.youtube.com/playlist?list=PLF706B428FB7BD52C', 'https://ocw.mit.edu/courses/mathematics/18-085-computational-science-and-engineering-i-fall-2008/', 'https://img.youtube.com/vi/0BAMQmT-tf0/0.jpg'),
(30, 'Mathematical Methods for Engineers II', 'Engleski', '2006.', 29, 25, '18.086', 'This graduate-level course is a continuation of Mathematical Methods for Engineers I (18.085). Topics include numerical methods; initial-value problems; network flows; and optimization.', 'https://www.youtube.com/playlist?list=PL3A13781649466805', 'https://ocw.mit.edu/courses/mathematics/18-086-mathematical-methods-for-engineers-ii-spring-2006/', 'https://img.youtube.com/vi/zha1744fTRs/0.jpg'),
(31, 'Linear Finite Element Analysis', 'Engleski', '1982.', 12, 11, 'RES.2-002', 'This video series is a comprehensive course of study that presents effective finite element procedures for the linear analysis of solids and structures. The finite element method is the ideal tool for solving static and dynamic problems in engineering and the sciences. Linear analysis assumes linear elastic behavior and infinitesimally small displacements and strains. To establish appropriate models for analysis, it is necessary to become familiar with the finite element methods available.', 'https://www.youtube.com/playlist?list=PLD4017FC423EC3EB5', 'https://ocw.mit.edu/resources/res-2-002-finite-element-procedures-for-solids-and-structures-spring-2010/', 'https://img.youtube.com/vi/oNqSzzycRhw/0.jpg'),
(32, 'Nonlinear Finite Element Analysis', 'Engleski', '1986.', 22, 19, 'RES.2-002', 'In these videos, Professor K. J. Bathe, a researcher of world renown in the field of finite element analysis, builds upon the concepts developed in his previous video course on Linear Analysis. General nonlinear analysis techniques are presented by emphasizing physical concepts. The mathematical foundation of nonlinear finite element techniques is given in light of these physical requirements. A wide range of questions in engineering and the sciences can be addressed with these methods. Upon completion of the course, participants will be able to simulate and analyze problems such as: Large displacement collapse or buckling of structures, Progressive damage of structural components under high-temperature conditions, Stresses and strains of structures under severe earthquake loads, Accident conditions due to sudden overloads, Construction and repair of structures, Stability of underground openings', 'https://www.youtube.com/playlist?list=PL75C727EA9F6A0E8B', 'https://ocw.mit.edu/resources/res-2-002-finite-element-procedures-for-solids-and-structures-spring-2010/nonlinear/', 'https://img.youtube.com/vi/iOilZsS_cnM/0.jpg'),
(33, 'Introduction to Probability and Statistics', 'Engleski', '2013.', 16, 25, '131A', '	Introductory course covering basic principles of probability and statistical inference. Axiomatic definition of probability, random variables, probability distributions, expectation.', 'https://www.youtube.com/playlist?list=PLqOZ6FD_RQ7l-ML8sMNFHx0CY7jyudZq2', 'https://ocw.uci.edu/courses/math_131a_introduction_to_probability_and_statistics.html', 'https://img.youtube.com/vi/BV7xnuJNkSQ/0.jpg'),
(34, 'Statistics for the Behavioral Sciences', 'Engleski', NULL, 23, 24, 'PSYCH-UA 10', 'This applied math course provides students with the basic tools for evaluating data from studies in the behavioral sciences, particularly psychology. Students will gain familiarity with data description, variance and variability, significance tests, confident intervals, correlation and linear regression, analysis of variance, and other related topics. The goal is to learn the application of statistical reasoning to decision making. Current events are often used to illustrate these issues.', 'https://www.youtube.com/playlist?list=PL65EEC7C0F625F8DF', 'https://as.nyu.edu/content/nyu-as/as/departments/psychology/courses/statistics-for-the-behavioral-sciences.html', 'https://img.youtube.com/vi/CE1s5uydSiI/0.jpg'),
(35, 'The Fourier Transforms and Its Applications', 'Engleski', '2007.', 30, 26, 'EE 261', 'The Fourier transform is a tool for solving physical problems. In this course the emphasis is on relating the theoretical principles to solving practical engineering and science problems.', 'https://www.youtube.com/playlist?list=PLB24BC7956EE040CD', 'https://see.stanford.edu/course/ee261', 'https://img.youtube.com/vi/zKEh9CxFpsM/0.jpg'),
(36, 'The Challenge of World Poverty', 'Engleski', '2011.', 22, 25, '14.73', 'This is a course for those who are interested in the challenge posed by massive and persistent world poverty, and are hopeful that economists might have something useful to say about this challenge.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP620R91K4KP_fO4l3eeK5lDn', 'https://ocw.mit.edu/courses/economics/14-73-the-challenge-of-world-poverty-spring-2011/', 'https://img.youtube.com/vi/K2LvCx8H0OU/0.jpg'),
(37, 'Financial Theory', 'Engleski', '2009.', 26, 26, 'ECON 251', 'This course attempts to explain the role and the importance of the financial system in the global economy. Rather than separating off the financial world from the rest of the economy, financial equilibrium is studied as an extension of economic equilibrium. The course also gives a picture of the kind of thinking and analysis done by hedge funds.', 'https://www.youtube.com/playlist?list=PLEDC55106E0BA18FC', 'https://oyc.yale.edu/economics/econ-251', 'https://img.youtube.com/vi/vTs2IQ8OefQ/0.jpg'),
(38, 'Finance Theory I', 'Engleski', '2008.', 20, 25, '15.401', 'This course provides a rigorous introduction to the fundamentals of modern financial analysis and applications to business challenges in valuation, risk analysis, corporate investment decisions, and basic security analysis and investment management. The four major sections of the course are: (A) an introduction to the financial system, the financial challenges firms and households face, and the principles of modern finance in tackling these challenges; (B) valuation of stocks, bonds, forwards, futures, and options; (C) methods for incorporating risk analysis into valuation models, including portfolio theory, mean-variance optimization, and the Capital Asset Pricing Model; and (D) applications to corporate financial decisions, including capital budgeting and real options.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP63B2lDhyKOsImI7FjCf6eDW', 'https://ocw.mit.edu/courses/sloan-school-of-management/15-401-finance-theory-i-fall-2008/', 'https://img.youtube.com/vi/ZWKnK9LIETA/0.jpg'),
(39, 'Financial Markets', 'Engleski', '2011.', 23, 28, 'ECON 252', 'An overview of the ideas, methods, and institutions that permit human society to manage risks and foster enterprise. Description of practices today and analysis of prospects for the future. Introduction to risk management and behavioral finance principles to understand the functioning of securities, insurance, and banking industries.', 'https://www.youtube.com/playlist?list=PL8FB14A2200B87185', 'https://oyc.yale.edu/economics/econ-252', 'https://img.youtube.com/vi/WQui_3Hpmmc/0.jpg'),
(40, 'Game Theory', 'Engleski', '2007.', 24, 29, 'ECON 159', 'This course is an introduction to game theory and strategic thinking. Ideas such as dominance, backward induction, Nash equilibrium, evolutionary stability, commitment, credibility, asymmetric information, adverse selection, and signaling are discussed and applied to games played in class and to examples drawn from economics, politics, the movies, and elsewhere.', 'https://www.youtube.com/playlist?list=PL6EF60E1027E1A10B', 'https://oyc.yale.edu/economics/econ-159', 'https://img.youtube.com/vi/nM3rTU927io/0.jpg'),
(41, 'Public Economics and Finance', 'Engleski', NULL, 13, 21, NULL, 'Public finance (also known as public economics) analyzes the impact of public policy on the allocation of resources and the distribution of income in the economy. In this course, you will learn how to use the tools of microeconomics and empirical analysis to analyze the economic effects of public expenditures and taxation.', 'https://www.youtube.com/playlist?list=PLPClF5HvrYnl5SiVFEdC07HvJY4ut_ZTc', 'https://www.openculture.com/public-economics-and-finance-a-free-online-course-from-nyu', 'https://img.youtube.com/vi/rto4Me9gSfk/0.jpg'),
(42, 'Special Topics in Supply Chain Management', 'Engleski', '2005.', 16, 12, 'ESD.290', '	This subject presents a range of advanced topics in integrated logistics and supply chain management. The course was conducted in a lecture-discussion format, with participation of corporate executives as guest lecturers. Students prepare industry assessment analyses and make formal classroom presentations. Specific topics alternate from year to year, but basic content includes procurement strategies and strategic sourcing, dynamic pricing and revenue management tactics, mitigation of supply chain risk through supply contracts, strategic outsourcing of supply chain functions and operations, management and operation of third party logistics providers, and management of supply chain security.', 'https://www.youtube.com/playlist?list=PLF9071540F59BA1F0', 'https://ocw.mit.edu/courses/engineering-systems-division/esd-290-special-topics-in-supply-chain-management-spring-2005/', 'https://img.youtube.com/vi/IqmrNUoiy7g/0.jpg'),
(43, 'Introduction to Lean Six Sigma Methods', 'Engleski', '2008.', 14, 9, '16.660', 'This course introduces the fundamental Lean Six Sigma principles that underlay modern continuous improvement approaches for industry, government and other organizations. Lean emerged from the Japanese automotive industry, particularly Toyota, and is focused on the creation of value through the relentless elimination of waste. Six Sigma is a quality system developed at Motorola which focuses on elimination of variation from all processes. The basic principles have been applied to a wide range of organizations and sectors to improve quality, productivity, customer satisfaction, employee satisfaction, time-to-market and financial performance.', 'https://www.youtube.com/playlist?list=PL8C6BE63DA137DD01', 'https://dspace.mit.edu/handle/1721.1/86011', 'https://img.youtube.com/vi/Swo3Lvw7ivg/0.jpg'),
(44, 'Introduction to Psychology', 'Engleski', '2007.', 20, 18, '	PSYC 110', 'What do your dreams mean? Do men and women differ in the nature and intensity of their sexual desires? Can apes learn sign language? Why cant we tickle ourselves? This course tries to answer these questions and many others, providing a comprehensive overview of the scientific study of thought and behavior. It explores topics such as perception, communication, learning, memory, decision-making, religion, persuasion, love, lust, hunger, art, fiction, and dreams. We will look at how these aspects of the mind develop in children, how they differ across people, how they are wired-up in the brain, and how they break down due to illness and injury.', 'https://www.youtube.com/playlist?list=PL6A08EB4EEFF3E91F', 'https://oyc.yale.edu/introduction-psychology/psyc-110', 'https://img.youtube.com/vi/7emS3ye3cVU/0.jpg'),
(45, 'Reflective Practice: An Approach for Expanding Your Learning', 'Engleski', '2007.', 10, 24, NULL, '	The course is an introduction to the approach of Reflective Practice developed by Donald Schön. It is an approach that enables professionals to understand how they use their knowledge in practical situations and how they can combine practice and learning in a more effective way. Through greater awareness of how they deploy their knowledge in practical situations, professionals can increase their capacities of learning in a more timely way. Understanding how they frame situations and ideas helps professionals to achieve greater flexibility and increase their capacity of conceptual innovation.', 'https://www.youtube.com/playlist?list=PL773D0AF1A86E4E58', 'https://ocw.mit.edu/courses/urban-studies-and-planning/11-965-reflective-practice-an-approach-for-expanding-your-learning-frontiers-january-iap-2007/', 'https://img.youtube.com/vi/yffHXdEQO08/0.jpg'),
(46, 'Families and Couples: Psychology', 'Engleski', '2009.', 18, 20, 'M176', 'Professor Benjamin Karney lectures on families and couples. This course examines relationships and their connection to individual psychopathology, marital discord, and family disruption.', 'https://www.youtube.com/playlist?list=PLA1DA9D11E15C116D', NULL, 'https://img.youtube.com/vi/2OUocz6SdtQ/0.jpg'),
(47, 'The Psychology, Biology and Politics of Food', 'Engleski', '2008.', 20, 20, 'PSYC 123', 'This course encompasses the study of eating as it affects the health and well-being of every human. Topics include taste preferences, food aversions, the regulation of hunger and satiety, food as comfort and friendship, eating as social ritual, and social norms of blame for food problems. The politics of food discusses issues such as sustainable agriculture, organic farming, genetically modified foods, nutrition policy, and the influence of food and agriculture industries. Also examined are problems such as malnutrition, eating disorders, and the global obesity epidemic; the impact of food advertising aimed at children; poverty and food; and how each individual’s eating is affected by the modern environment.', 'https://oyc.yale.edu/psychology/psyc-123', 'https://oyc.yale.edu/psychology/psyc-123/lecture-1', 'https://oyc.yale.edu/sites/default/files/brownell_4.jpg'),
(48, 'Freshman Organic Chemistry I', 'Engleski', '2008.', 37, 30, 'CHEM 125a', 'This is the first semester in a two-semester introductory course focused on current theories of structure and mechanism in organic chemistry, their historical development, and their basis in experimental observation. The course is open to freshmen with excellent preparation in chemistry and physics, and it aims to develop both taste for original science and intellectual skills necessary for creative research.', 'https://www.youtube.com/playlist?list=PL3F629F73640F831D', 'https://oyc.yale.edu/chemistry/chem-125a', 'https://img.youtube.com/vi/mxMjroKqz_Y/0.jpg'),
(49, 'Freshman Organic Chemistry II', 'Engleski', '2011.', 38, 31, 'CHEM 125b', 'This is a continuation of Freshman Organic Chemistry I (CHEM 125a), the introductory course on current theories of structure and mechanism in organic chemistry for students with excellent preparation in chemistry and physics. This semester treats simple and complex reaction mechanisms, spectroscopy, organic synthesis, and some molecules of nature.', 'https://www.youtube.com/playlist?list=PLB572BA3ED0F700F1', 'https://oyc.yale.edu/chemistry/chem-125b', 'https://img.youtube.com/vi/5sLb4DS0LM8/0.jpg'),
(50, 'Small-Molecule Spectroscopy and Dynamics', 'Engleski', '2008.', 38, 34, '5.80', '	The goal of this course is to illustrate the spectroscopy of small molecules in the gas phase: quantum mechanical effective Hamiltonian models for rotational, vibrational, and electronic structure; transition selection rules and relative intensities; diagnostic patterns and experimental methods for the assignment of non-textbook spectra; breakdown of the Born-Oppenheimer approximation (spectroscopic perturbations); the stationary phase approximation; nondegenerate and quasidegenerate perturbation theory (van Vleck transformation); qualitative molecular orbital theory (Walsh diagrams); the notation of atomic and molecular spectroscopy.', 'https://www.youtube.com/playlist?list=PL683876BE6097A1C2', 'https://ocw.mit.edu/courses/chemistry/5-80-small-molecule-spectroscopy-and-dynamics-fall-2008/', 'https://img.youtube.com/vi/PjpLw1iqr4E/0.jpg'),
(51, 'Introduction to Solid State Chemistry', 'Engleski', '2010.', 61, 35, '3.091SC', 'Introduction to Solid State Chemistry is a first-year single-semester college course on the principles of chemistry. This unique and popular course satisfies MIT\'s general chemistry degree requirement, with an emphasis on solid-state materials and their application to engineering systems.', 'https://www.youtube.com/playlist?list=PL36EC6A6180271B0F', 'https://ocw.mit.edu/courses/materials-science-and-engineering/3-091sc-introduction-to-solid-state-chemistry-fall-2010/', 'https://img.youtube.com/vi/fFg4uXMpnV0/0.jpg'),
(52, 'Thermodynamics & Kinetics in Chemistry', 'Engleski', '2008.', 36, 30, '	5.60', 'This subject deals primarily with equilibrium properties of macroscopic systems, basic thermodynamics, chemical equilibrium of reactions in gas and solution phase, and rates of chemical reactions.', 'https://www.youtube.com/playlist?list=PLA62087102CC93765', 'https://ocw.mit.edu/courses/chemistry/5-60-thermodynamics-kinetics-spring-2008/', 'https://img.youtube.com/vi/kLqduWF6GXE/0.jpg'),
(53, 'Darwin and Design', 'Engleski', '2010.', 21, 19, '21L.448J', 'Humans are social animals; social demands, both cooperative and competitive, structure our development, our brain and our mind. This course covers social development, social behaviour, social cognition and social neuroscience, in both human and non-human social animals. Topics include altruism, empathy, communication, theory of mind, aggression, power, groups, mating, and morality. Methods include evolutionary biology, neuroscience, cognitive science, social psychology and anthropology.', 'https://www.youtube.com/playlist?list=PLF7D7F81CD5E07497', 'https://ocw.mit.edu/courses/literature/21l-448j-darwin-and-design-fall-2010/', 'https://img.youtube.com/vi/fW4JKL0AFxA/0.jpg'),
(54, 'Philosophy and the Science of Human Nature', 'Engleski', '2011.', 26, 20, 'PHIL 181', 'Philosophy and the Science of Human Nature pairs central texts from Western philosophical tradition (including works by Plato, Aristotle, Epictetus, Hobbes, Kant, Mill, Rawls, and Nozick) with recent findings in cognitive science and related fields. The course is structured around three intertwined sets of topics: Happiness and Flourishing; Morality and Justice; and Political Legitimacy and Social Structures.', 'https://www.youtube.com/playlist?list=PL3F6BC200B2930084', 'https://oyc.yale.edu/philosophy/phil-181', 'https://img.youtube.com/vi/lIlRWR9vNtE/0.jpg'),
(55, 'Programming for Designers', 'Engleski', '2011.', 18, 15, 'COMP1400-T2', 'An introduction to the concepts and techniques of object oriented programming with a focus on the construction of interactive multimedia applications. Delivery is through lectures and computer lab classes. Assessment will be via a number of in-class exercises and staged assignments.', 'https://www.youtube.com/playlist?list=PL33A90F8537C8B1FB', 'https://thebox.unsw.edu.au/4D508202-840C-11DF-8BFC0050568336DC/LAYOUT/grid/mediaType/unswVideo', 'https://img.youtube.com/vi/8wHvAq06Y-o/0.jpg'),
(56, 'Introduction to Algorithms', 'Engleski', '2011.', 47, 42, '6.006', '	This course provides an introduction to mathematical modeling of computational problems. It covers the common algorithms, algorithmic paradigms, and data structures used to solve these problems. The course emphasizes the relationship between algorithms and programming, and introduces basic performance measures and analysis techniques for these problems.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP61Oq3tWYp6V_F-5jb5L2iHb', 'https://ocw.mit.edu/courses/electrical-engineering-and-computer-science/6-006-introduction-to-algorithms-fall-2011/', 'https://img.youtube.com/vi/HtSuA80QTyo/0.jpg'),
(57, 'Performance Engineering of Software Systems', 'Engleski', '2018.', 23, 30, '6.172', '6.172 provides a hands-on, project-based introduction to building scalable and high-performance software systems. Topics include performance analysis, algorithmic techniques for high performance, instruction-level optimizations, caching optimizations, parallel programming, and building scalable systems. The course programming language is C.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP63VIBQVWguXxZZi0566y7Wf', 'https://ocw.mit.edu/courses/electrical-engineering-and-computer-science/6-172-performance-engineering-of-software-systems-fall-2018/', 'https://img.youtube.com/vi/o7h_sYMk_oc/0.jpg'),
(58, 'Performance Engineering of Software Systems', 'Engleski', '2010.', 24, 29, '6.172', 'This class is a hands-on, project-based introduction to building scalable and high-performance software systems. Topics include performance analysis, algorithmic techniques for high performance, instruction-level optimizations, cache and memory hierarchy optimization, parallel programming, and building scalable distributed systems.', 'https://www.youtube.com/playlist?list=PLD2AE32F507F10481', 'https://dspace.mit.edu/handle/1721.1/122680', 'https://img.youtube.com/vi/JzpkXLH9zLQ/0.jpg'),
(59, 'Programming Methodology', 'Engleski', '2007.', 28, 22, 'CS106A', 'An introduction to the engineering of computer applications emphasizing modern software engineering principles: object-oriented design, decomposition, encapsulation, abstraction, and testing. Uses the Java programming language. Emphasis is on good programming style and the built-in facilities of the Java language. . The course is explicitly designed to appeal to humanists and social scientists as well as hard-core techies. In fact, most Programming Methodology graduates end up majoring outside of the School of Engineering.', 'https://www.youtube.com/playlist?list=PL84A56BC7F4A1F852', 'https://see.stanford.edu/course/cs106a', 'https://img.youtube.com/vi/C5HeRliZ0Ns/0.jpg'),
(60, 'Programming Abstractions', 'Engleski', '2008.', 27, 21, '	CS106B', 'This course (CS 106B) is the successor to CS 106A and covers more advanced programming topics such as recursion, algorithmic analysis, and data abstraction. It is taught using the C++ programming language, which is similar to both C and Java. In the past when both CS 106A and CS106B were taught in C/C++, the coupling between the two classes was very tight and it was unheard for students to take CS106B without having completed our CS 106A (we recommended CS 106X instead). Nowadays, some students do go straight into CS106B, this is typically appropriate for a student who done well in an intro programming course and has sufficient familiarity with good programming style and software engineering issues (at the level of CS 106A) to use this understanding as a foundation on which to tackle advanced topics. Topics: Abstraction and its relation to programming. Software engineering principles of data abstraction and modularity. Object-oriented programming, fundamental data structures (such as stacks, queues, sets) and data-directed design. Recursion and recursive data structures (linked lists, trees, graphs). Introduction to time and space complexity analysis.', 'https://www.youtube.com/playlist?list=PLFE6E58F856038C69', 'https://see.stanford.edu/Course/CS106B', 'https://img.youtube.com/vi/K8DjFXkMRbY/0.jpg'),
(61, 'Programming Paradigms', 'Engleski', '2008.', 27, 22, 'CS107', 'Programming Paradigms (CS107) introduces several programming languages, including C, Assembly, C++, Concurrent Programming, Scheme, and Python. The class aims to teach students how to write code for each of these individual languages and to understand the programming paradigms behind these languages. Advanced memory management features of C and C++; the differences between imperative and object-oriented paradigms. The functional paradigm (using LISP) and concurrent programming (using C and C++). Brief survey of other modern languages such as Python, Objective C, and C#. Prerequisites: You should be comfortable with arrays, pointers, references, classes, methods, dynamic memory allocation, recursion, linked lists, binary search trees, hashing, iterators, and function pointers. You should be able to write well-decomposed, easy-to-understand code, and understand the value that comes with good variable names, short function and method implementations, and thoughtful, articulate comments.', 'https://www.youtube.com/playlist?list=PL9D558D49CA734A02', 'https://see.stanford.edu/course/cs107', 'https://img.youtube.com/vi/H4MQXBF6FN4/0.jpg'),
(62, 'Introduction to operating systems', 'Engleski', '2017.', 37, 28, 'CSE 421/521', 'This course is an introduction to operating system design and implementation. We study operating systems because they are examples of mature and elegant solutions to a difficult design problem: how to safely and efficiently share system resources and provide abstractions useful to applications.', 'https://www.youtube.com/playlist?list=PLE6LEE8y2Jp_z8pkiuvHo7Vz-eQEKsk-I', 'https://ops-class.org/courses/buffalo/CSE421_Spring2017/', 'https://img.youtube.com/vi/TdYWlQUmLEY/0.jpg'),
(63, 'Parallel Computer Architecture', 'Engleski', '2012.', 24, 35, '18-742', NULL, 'https://www.youtube.com/playlist?list=PL5PHm2jkkXmh4cDkC3s1VBB7-njlgiG5d', 'https://course.ece.cmu.edu/~ece742/f12/doku.php', 'https://img.youtube.com/vi/YnqpW-mCYX8/0.jpg'),
(64, 'Machine Learning', 'Engleski', '2018.', 20, 27, 'CS229', 'This course provides a broad introduction to machine learning and statistical pattern recognition. Topics include: supervised learning (generative/discriminative learning, parametric/non-parametric learning, neural networks, support vector machines); unsupervised learning (clustering, dimensionality reduction, kernel methods); learning theory (bias/variance tradeoffs, practical advice); reinforcement learning and adaptive control. The course will also discuss recent applications of machine learning, such as to robotic control, data mining, autonomous navigation, bioinformatics, speech recognition, and text and web data processing.', 'https://www.youtube.com/playlist?list=PLoROMvodv4rMiGQp3WXShtMGgzqpfVfbU', 'https://cs229.stanford.edu/syllabus-autumn2018.html', 'https://img.youtube.com/vi/jGwO_UgTS7I/0.jpg'),
(65, 'Machine Learning', 'Engleski', '2008.', 20, 25, 'CS229', '	This course provides a broad introduction to machine learning and statistical pattern recognition. Topics include: supervised learning (generative/discriminative learning, parametric/non-parametric learning, neural networks, support vector machines); unsupervised learning (clustering, dimensionality reduction, kernel methods); learning theory (bias/variance tradeoffs; VC theory; large margins); reinforcement learning and adaptive control. The course will also discuss recent applications of machine learning, such as to robotic control, data mining, autonomous navigation, bioinformatics, speech recognition, and text and web data processing.', 'https://www.youtube.com/playlist?list=PLA89DCFA6ADACE599', 'https://see.stanford.edu/Course/CS229', 'https://img.youtube.com/vi/UzxYlbK2c7E/0.jpg'),
(66, 'AI for Video Games', 'Engleski', '2022.', 20, 22, 'COMP 4303', 'This course provides an introduction to specific state-of-the-art algorithmic techniques and data structures that are used to efficiently implement humanlike abilities (e.g., awareness, memory, rational decision-making (under uncertainty), movement, co-operation in groups) in computer game agents.', 'https://www.youtube.com/playlist?list=PL_xRyXins84_gIuIZmdOUOoYQR95I9k95', 'http://www.cs.mun.ca/~dchurchill/teaching.shtml', 'https://img.youtube.com/vi/cCmnpbB4Gik/0.jpg'),
(67, 'Introduction to Political Philosophy', 'Engleski', '2006.', 24, 17, 'PLSC 114', 'This course is intended as an introduction to political philosophy as seen through an examination of some of the major texts and thinkers of the Western political tradition. Three broad themes that are central to understanding political life are focused upon: the polis experience (Plato, Aristotle), the sovereign state (Machiavelli, Hobbes), constitutional government (Locke), and democracy (Rousseau, Tocqueville). The way in which different political philosophies have given expression to various forms of political institutions and our ways of life are examined throughout the course.', 'https://www.youtube.com/playlist?list=PL8D95DEA9B7DFE825', 'https://oyc.yale.edu/political-science/plsc-114', 'https://img.youtube.com/vi/xhm55mIdSuk/0.jpg'),
(68, 'The Moral Foundations of Politics', 'Engleski', '2010.', 25, 20, 'PLSC 118', 'This course explores main answers to the question \"when do governments deserve our allegiance?\" It starts with a survey of major political theories of the Enlightenment—Utilitarianism, Marxism, and the social contract tradition—through classical formulations, historical context, and contemporary debates relating to politics today. It then turns to the rejection of Enlightenment political thinking. Lastly, it deals with the nature of, and justifications for, democratic politics, and their relations to Enlightenment and Anti-Enlightenment political thinking. Practical implications of these arguments are covered through discussion of a variety of concrete problems.', 'https://www.youtube.com/playlist?list=PL2FD48CE33DFBEA7E', 'https://oyc.yale.edu/political-science/plsc-118/lecture-1', 'https://img.youtube.com/vi/s6MOA_Y3MKE/0.jpg'),
(69, 'Environmental Politics and Law', 'Engleski', '2010.', 24, 19, 'EVST 255', 'Can law change human behavior to be less environmentally damaging? Law will be examined through case histories including: environmental effects of national security, pesticides, air pollution, consumer products, plastics, parks and protected area management, land use, urban growth and sprawl, public/private transit, drinking water standards, food safety, and hazardous site restoration. In each case we will review the structure of law and evaluate its strengths and weaknesses.', 'https://www.youtube.com/playlist?list=PL84DCD72C5B5DC403', 'https://oyc.yale.edu/environmental-studies/evst-255', 'https://img.youtube.com/vi/zKS3Ul-kuaw/0.jpg'),
(70, 'Capitalism: Success, Crisis, and Reform', 'Engleski', '2009.', 23, 18, 'PLSC 270', 'In this course, we will seek to interpret capitalism using ideas from biological evolution: firms pursuing varied strategies and facing extinction when those strategies fail are analogous to organisms struggling for survival in nature. For this reason, it is less concerned with ultimate judgment of capitalism than with the ways it can be shaped to fit our more specific objectives–for the natural environment, public health, alleviation of poverty, and development of human potential in every child. Each book we read will be explicitly or implicitly an argument about good and bad consequences of capitalism.', 'https://www.youtube.com/playlist?list=PL2497FD1251EED4DD', 'https://oyc.yale.edu/political-science/plsc-270', 'https://img.youtube.com/vi/gw3xeGfM2Rk/0.jpg'),
(71, 'Circuits and Electronics', 'Engleski', '2007.', 26, 21, '6.002', '6.002 is designed to serve as a first course in an undergraduate electrical engineering (EE), or electrical engineering and computer science (EECS) curriculum', 'https://www.youtube.com/playlist?list=PL9F74AFA03AA06A11', 'https://ocw.mit.edu/courses/electrical-engineering-and-computer-science/6-002-circuits-and-electronics-spring-2007/', 'https://img.youtube.com/vi/4TCnYYpZxEc/0.jpg');
INSERT INTO `predavanja` (`idPredavanja`, `naziv_predavanja`, `jezik`, `godina`, `broj_predavanja`, `ukupno_trajanje`, `oznaka`, `opis_kolegija`, `link_1`, `link_2`, `image`) VALUES
(72, 'Digital Circuit Design', 'Engleski', '2011.', 32, 23, 'ELEC2141', 'Introduction to modern digital logic design, combinational logic, switch logic and basic gates, Boolean algebra, two-level logic, regular logic structures, multi-level networks and transformations, programmable logic devices, time response. Sequential logic, networks with feedback, basic latches and flip-flops, timing methodologies, registers and counters, programmable logic devices. Finite state machine design, concepts of FSMs, basic design approach, specification methods, state minimization, state encoding, FSM partitioning, implementation of FSMs, programmable logic devices. Elements of computers, arithmetic circuits, arithmetic and logic units, register and bus structures, controllers/ sequencers, microprogramming. Experience with computer-aided design tools for logic design, schematic entry, state diagram entry, hardware description language entry, compilation to logic networks, simulation, mapping to programmable logic devices. Practical topics, non-gate logic, asynchronous inputs and metastability, memories: RAM and ROM, Implementation technologies and mapping problems expressed in words to digital abstractions.', 'https://www.youtube.com/playlist?list=PLB52B8F4E464CEEF7', 'https://www.handbook.unsw.edu.au/undergraduate/courses/2019/ELEC2141', 'https://img.youtube.com/vi/esAE1WLAubM/0.jpg'),
(73, 'Signals and Systems', 'Engleski', '2011.', 25, 20, '6.003', 'The analysis of signals and systems forms a key part of many modern technologies, including communications and feedback & control. These lectures give a conceptual and mathematical introduction to the topic, covering both analog and digital systems.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP61kdPAOC7CzFjJZ8f1eMUxs', 'https://ocw.mit.edu/courses/electrical-engineering-and-computer-science/6-003-signals-and-systems-fall-2011/', 'https://img.youtube.com/vi/gxgV_oOG7Zc/0.jpg'),
(74, 'Electronic Feedback Systems', 'Engleski', '1985.', 20, 17, NULL, 'Feedback control is an important technique that is used in many modern electronic and electromechanical systems. The successful inclusion of this technique improves performance, reliability, and cost effectiveness of many designs. In this series of lectures we introduce the analytical concepts that underlie classical feedback system design. The application of these concepts is illustrated by a variety of experiments and demonstration systems. The diversity of the demonstration systems reinforces the value of the analytic methods.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP62in17jH_DiJMkCGNM6Xni-', 'https://ocw.mit.edu/resources/res-6-010-electronic-feedback-systems-spring-2013/', 'https://img.youtube.com/vi/CWlJLpAE4BI/0.jpg'),
(75, 'Biomedical Electronics', 'Engleski', '2013.', 21, 24, 'ECE5030', 'Covers the theory and practical aspects of recording and analyzing electronic data collected from biological systems. Topics may include electrode and amplifier design, tissue impedance and effects on waveforms, sensors, statistical and signal processing algorithms, noise reduction, and safety considerations.', 'https://www.youtube.com/playlist?list=PLKcjQ_UFkrd7zbPHRkDpB7i113wDG_Rb3', 'http://people.ece.cornell.edu/land/courses/ece5030/', 'https://img.youtube.com/vi/thCFMeB8pHM/0.jpg'),
(76, 'Roman Architecture', 'Engleski', '2009.', 24, 28, 'HSAR 252', 'This course is an introduction to the great buildings and engineering marvels of Rome and its empire, with an emphasis on urban planning and individual monuments and their decoration, including mural painting. While architectural developments in Rome, Pompeii, and Central Italy are highlighted, the course also provides a survey of sites and structures in what are now North Italy, Sicily, France, Spain, Germany, Greece, Turkey, Croatia, Jordan, Lebanon, Libya, and North Africa. The lectures are illustrated with over 1,500 images, many from Professor Kleiner\'s personal collection.', 'https://www.youtube.com/playlist?list=PLBCB3059E45654BCE', 'https://oyc.yale.edu/NODE/176', 'https://img.youtube.com/vi/8aJO3EfVjyk/0.jpg'),
(77, 'The Early Middle Ages, 284–1000', 'Engleski', '2011.', 22, 17, 'HIST 210', 'Major developments in the political, social, and religious history of Western Europe from the accession of Diocletian to the feudal transformation. Topics include the conversion of Europe to Christianity, the fall of the Roman Empire, the rise of Islam and the Arabs, the \"Dark Ages,\" Charlemagne and the Carolingian renaissance, and the Viking and Hungarian invasions.', 'https://www.youtube.com/playlist?list=PL77A337915A76F660', 'https://oyc.yale.edu/history/hist-210', 'https://img.youtube.com/vi/tcIuAJ-jaSg/0.jpg'),
(78, 'Early Modern England: Politics, Religion, and Society under ', 'Engleski', '2009.', 25, 19, 'HIST 251', 'This course is intended to provide an up-to-date introduction to the development of English society between the late fifteenth and the early eighteenth centuries. Particular issues addressed in the lectures will include: the changing social structure; households; local communities; gender roles; economic development; urbanization; religious change from the Reformation to the Act of Toleration; the Tudor and Stuart monarchies; rebellion, popular protest and civil war; witchcraft; education, literacy and print culture; crime and the law; poverty and social welfare; the changing structures and dynamics of political participation and the emergence of parliamentary government.', 'https://www.youtube.com/playlist?list=PL18B9F132DFD967A3', 'https://oyc.yale.edu/history/hist-251', 'https://img.youtube.com/vi/e3uBi2TZdUY/0.jpg'),
(79, 'European Civilization, 1648-1945', 'Engleski', '2008.', 24, 18, '	HIST 202', 'This course offers a broad survey of modern European history, from the end of the Thirty Years\' War to the aftermath of World War II. Along with the consideration of major events and figures such as the French Revolution and Napoleon, attention will be paid to the experience of ordinary people in times of upheaval and transition. The period will thus be viewed neither in terms of historical inevitability nor as a procession of great men, but rather through the lens of the complex interrelations between demographic change, political revolution, and cultural development. Textbook accounts will be accompanied by the study of exemplary works of art, literature, and cinema.', 'https://www.youtube.com/playlist?list=PL3A8E6CE294860A24', 'https://oyc.yale.edu/history/hist-202', 'https://img.youtube.com/vi/eGFilsLo6OI/0.jpg'),
(80, 'Epidemics in Western Society Since 1600', 'Engleski', '2010.', 26, 20, 'HIST 234', 'This course consists of an international analysis of the impact of epidemic diseases on western society and culture from the bubonic plague to HIV/AIDS and the recent experience of SARS and swine flu. Leading themes include: infectious disease and its impact on society; the development of public health measures; the role of medical ethics; the genre of plague literature; the social reactions of mass hysteria and violence; the rise of the germ theory of disease; the development of tropical medicine; a comparison of the social, cultural, and historical impact of major infectious diseases; and the issue of emerging and re-emerging diseases.', 'https://www.youtube.com/playlist?list=PL3AE7B3B6917DE8E6', 'https://oyc.yale.edu/history/hist-234', 'https://img.youtube.com/vi/o7xL3LuQkVo/0.jpg'),
(81, 'The American Revolution', 'Engleski', '2010.', 25, 18, 'HIST 116', 'The American Revolution entailed some remarkable transformations--converting British colonists into American revolutionaries, and a cluster of colonies into a confederation of states with a common cause -- but it was far more complex and enduring then the fighting of a war. As John Adams put it, \"The Revolution was in the Minds of the people... before a drop of blood was drawn at Lexington\"--and it continued long past America\'s victory at Yorktown. This course will examine the Revolution from this broad perspective, tracing the participants\' shifting sense of themselves as British subjects, colonial settlers, revolutionaries, and Americans.', 'https://www.youtube.com/playlist?list=PLDA2BC5E785D495AB', 'https://oyc.yale.edu/history/hist-116', 'https://img.youtube.com/vi/8_ltTMQ6Gsg/0.jpg'),
(82, 'The Civil War and Reconstruction Era, 1845-1877', 'Engleski', '2008.', 27, 22, '	HIST 119', 'This course explores the causes, course, and consequences of the American Civil War, from the 1840s to 1877. The primary goal of the course is to understand the multiple meanings of a transforming event in American history. Those meanings may be defined in many ways: national, sectional, racial, constitutional, individual, social, intellectual, or moral. Four broad themes are closely examined: the crisis of union and disunion in an expanding republic; slavery, race, and emancipation as national problem, personal experience, and social process; the experience of modern, total war for individuals and society; and the political and social challenges of Reconstruction.', 'https://www.youtube.com/playlist?list=PL5DD220D6A1282057', 'https://oyc.yale.edu/history/hist-119', 'https://img.youtube.com/vi/yesO9SnEQ6Y/0.jpg'),
(83, 'France Since 1871', 'Engleski', '2007.', 24, 18, 'HIST 276', 'This course covers the emergence of modern France. Topics include the social, economic, and political transformation of France; the impact of France\'s revolutionary heritage, of industrialization, and of the dislocation wrought by two world wars; and the political response of the Left and the Right to changing French society.', 'https://www.youtube.com/playlist?list=PLE653BF062C136B62', 'https://oyc.yale.edu/history/hist-276', 'https://img.youtube.com/vi/tZyo7koBa04/0.jpg'),
(84, 'African American History: From Emancipation to the Present', 'Engleski', '2010.', 25, 20, 'AFAM 162', 'The purpose of this course is to examine the African American experience in the United States from 1863 to the present. Prominent themes include the end of the Civil War and the beginning of Reconstruction; African Americans’ urbanization experiences; the development of the modern civil rights movement and its aftermath; and the thought and leadership of Booker T. Washington, Ida B. Wells-Barnett, W.E.B. Du Bois, Marcus Garvey, Martin Luther King Jr., and Malcolm X.', 'https://oyc.yale.edu/african-american-studies/afam-162/lecture-1', 'https://oyc.yale.edu/african-american-studies/afam-162', 'https://oyc.yale.edu/sites/default/files/holloway_1_2.jpg'),
(85, 'New York City: A Social History', 'Engleski', '2010.', 26, 29, NULL, '	New York City, growing from the small Dutch commercial settlement of New Amsterdam early in the seventeenth century into a bustling multi-cultural city of more than 7 million and metropolis of more than 15 million by the twentieth century, is a place with many stories. A semester of 14 weeks can only touch on some of them. This course will focus on the social history of the city – the peoples who have built the city and competing efforts by different numbers to authorize their dreams for the city. As arguably the capital for global capitalism today, one focus of this course will seek to plot its development and legacy for the shaping of the city. A more particular and related local story will be studied as well, however: the political and cultural interests, ideologies and players who shape and reshape the city as Manhattan, as New York and as the Metropolis.', 'https://www.youtube.com/playlist?list=PL78E65F2E6C63CD76', NULL, 'https://img.youtube.com/vi/dHSUBtfQfmU/0.jpg'),
(86, 'Ancient Israel', 'Engleski', '2010.', 27, 29, NULL, '	This course is designed to make the acquaintance from scratch. My ancient Israel is strange, sometimes shocking, diverse, and mostly hidden. It can be approached from archaeology and non-biblical writing as well as from the Bible as its most famous artifact. I am a biblical scholar and student of ancient literature, so this class will lean toward what is written, embracing the Bible as a source. In a broadly chronological framework, we will ask what I hope to be unfamiliar questions, trying to get you to see things you had not considered before. The course assumes no prior knowledge, and all knowledge is built from the ground up based on “primary evidence,” the actual material from the ancient world – including the Bible. Every full-class meeting will involve conversation in response to some piece of primary evidence, with expectation that students have as much right as any scholar to figure out who these people are for themselves.', 'https://www.youtube.com/playlist?list=PL49208CAE353159FA', NULL, 'https://img.youtube.com/vi/0bBx4_Ax7rI/0.jpg'),
(88, 'Fundamentals of Physics', 'Engleski', '2006.', 24, 29, 'PHYS 200', 'This course provides a thorough introduction to the principles and methods of physics for students who have good preparation in physics and mathematics. Emphasis is placed on problem solving and quantitative reasoning. This course covers Newtonian mechanics, special relativity, gravitation, thermodynamics, and waves.', 'https://www.youtube.com/playlist?list=PLFE3074A4CB751B2B', 'https://oyc.yale.edu/physics/phys-200', 'https://img.youtube.com/vi/abF2zesdlVk/0.jpg'),
(89, 'Fundamentals of Physics II', 'Engleski', '2010.', 25, 30, '	PHYS 201', 'This is a continuation of Fundamentals of Physics, I (PHYS 200), the introductory course on the principles and methods of physics for students who have good preparation in physics and mathematics. This course covers electricity, magnetism, optics and quantum mechanics.', 'https://www.youtube.com/playlist?list=PLD07B2225BB40E582', 'https://oyc.yale.edu/physics/phys-201', 'https://img.youtube.com/vi/NK-BxowMIfg/0.jpg'),
(90, 'Physics I: Classical Mechanics', 'Engleski', '1999.', 40, 30, '8.01x', 'Physics I is a first-year physics course which introduces students to classical mechanics', 'https://www.youtube.com/playlist?list=PLyQSN7X0ro203puVhQsmCj9qhlFQ-As8e', 'https://ocw.mit.edu/courses/physics/8-01x-physics-i-classical-mechanics-with-an-experimental-focus-fall-2002/', 'https://img.youtube.com/vi/wWnfJ0-xXRE/0.jpg'),
(91, 'Physics II: Electricity and Magnetism', 'Engleski', '2002.', 40, 32, '8.02x', 'This course is an introduction to electromagnetism and electrostatics.', 'https://www.youtube.com/playlist?list=PLyQSN7X0ro2314mKyUiOILaOC2hk6Pc3j', 'https://ocw.mit.edu/courses/physics/8-02x-physics-ii-electricity-magnetism-with-an-experimental-focus-spring-2005/', 'https://img.youtube.com/vi/1xFRtdN5IJA/0.jpg'),
(92, 'Physics III: Vibrations and Waves', 'Engleski', '2004.', 24, 30, '8.03', '	Vibrations and waves are everywhere. If you take any system and disturb it from a stable equilibrium, the resultant motion will be waves and vibrations. Think of a guitar string—pluck the string, and it vibrates. The sound waves generated make their way to our ears, and we hear the string’s sound. Our eyes see what’s happening because they receive the electromagnetic waves of the light reflected from the guitar string, so that we can recognize the beautiful sinusoidal waves on the string. In fact, without vibrations and waves, we could not recognize the universe around us at all!', 'https://www.youtube.com/playlist?list=PLyQSN7X0ro22WeXM2QCKJm2NP_xHpGV89', 'https://ocw.mit.edu/courses/physics/8-03sc-physics-iii-vibrations-and-waves-fall-2016/', 'https://img.youtube.com/vi/VuX_UExHa0M/0.jpg'),
(93, 'Quantum Physics I', 'Engleski', '2013.', 25, 33, '	8.04', 'This course covers the experimental basis of quantum physics. It introduces wave mechanics, Schrödinger\'s equation in a single dimension, and Schrödinger\'s equation in three dimensions.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP61-9PEhRognw5vryrSEVLPr', 'https://ocw.mit.edu/courses/physics/8-04-quantum-physics-i-spring-2013/', 'https://img.youtube.com/vi/lZ3bPUKo5zc/0.jpg'),
(94, 'Quantum Physics II', 'Engleski', '2013.', 26, 36, '8.05', 'Together, this course and 8.06 Quantum Physics III cover quantum physics with applications drawn from modern physics. Topics covered in this course include the general formalism of quantum mechanics, harmonic oscillator, quantum mechanics in three-dimensions, angular momentum, spin, and addition of angular momentum.', 'https://www.youtube.com/playlist?list=PLyQSN7X0ro21y1VjcdTi5jbpH26O-Tk68', 'https://ocw.mit.edu/courses/physics/8-05-quantum-physics-ii-fall-2013/', 'https://img.youtube.com/vi/QI13S04w8dM/0.jpg'),
(95, 'Quantum Mechanics', 'Engleski', '2009.', 27, 22, NULL, 'In this series of physics lectures, Professor J.J. Binney explains how probabilities are obtained from quantum amplitudes, why they give rise to quantum interference, the concept of a complete set of amplitudes and how this defines a \"quantum state\".', 'https://www.youtube.com/playlist?list=PLaLOVNqqD-2F6oe_-BUniUBz_5pmp1tyk', 'https://podcasts.ox.ac.uk/series/quantum-mechanics', 'https://img.youtube.com/vi/EPRelaoQeCU/0.jpg'),
(96, 'Frontiers/Controversies in Astrophysics', 'Engleski', '2007.', 24, 19, 'ASTR 160', 'This course focuses on three particularly interesting areas of astronomy that are advancing very rapidly: Extra-Solar Planets, Black Holes, and Dark Energy. Particular attention is paid to current projects that promise to improve our understanding significantly over the next few years. The course explores not just what is known, but what is currently not known, and how astronomers are going about trying to find out.', 'https://www.youtube.com/playlist?list=PLD1515420F4E601A4', 'https://oyc.yale.edu/astronomy/astr-160', 'https://img.youtube.com/vi/40OQdPbeM0c/0.jpg'),
(97, 'Foundations of Modern Social Theory', 'Engleski', '2009.', 25, 20, 'SOCY 151', 'This course provides an overview of major works of social thought from the beginning of the modern era through the 1920s. Attention is paid to social and intellectual contexts, conceptual frameworks and methods, and contributions to contemporary social analysis. Writers include Hobbes, Locke, Rousseau, Montesquieu, Adam Smith, Marx, Weber, and Durkheim.', 'https://www.youtube.com/playlist?list=PLDF7B08FF8564D1FE', 'https://oyc.yale.edu/sociology/socy-151', 'https://img.youtube.com/vi/ISmzEqx_9RU/0.jpg'),
(98, 'Control of Manufacturing Processes', 'Engleski', '2008.', 22, 30, '	2.830J / 6.780J / ESD.63J', 'This course explores statistical modeling and control in manufacturing processes. Topics include the use of experimental design and response surface modeling to understand manufacturing process physics, as well as defect and parametric yield modeling and optimization. Various forms of process control, including statistical process control, run by run and adaptive control, and real-time feedback control, are covered. Application contexts include semiconductor manufacturing, conventional metal and polymer processing, and emerging micro-nano manufacturing processes.', 'https://www.youtube.com/playlist?list=PL7CF97E01FDE7C51A', 'https://ocw.mit.edu/courses/mechanical-engineering/2-830j-control-of-manufacturing-processes-sma-6303-spring-2008/', 'https://img.youtube.com/vi/kC2SEiGaqoA/0.jpg'),
(99, 'Atomistic Computer Modeling of Materials', 'Engleski', '2005.', 19, 25, '3.320', 'This course uses the theory and application of atomistic computer simulations to model, understand, and predict the properties of real materials. Specific topics include: energy models from classical potentials to first-principles approaches; density functional theory and the total-energy pseudopotential method; errors and accuracy of quantitative predictions: thermodynamic ensembles, Monte Carlo sampling and molecular dynamics simulations; free energy and phase transitions; fluctuations and transport properties; and coarse-graining approaches and mesoscale models. The course employs case studies from industrial applications of advanced materials to nanotechnology. Several laboratories will give students direct experience with simulations of classical force fields, electronic-structure approaches, molecular dynamics, and Monte Carlo.', 'https://www.youtube.com/playlist?list=PL13CB8C2EDA4453ED', 'https://ocw.mit.edu/courses/materials-science-and-engineering/3-320-atomistic-computer-modeling-of-materials-sma-5107-spring-2005/', 'https://img.youtube.com/vi/HcQ7bdBGbEs/0.jpg'),
(100, 'Health Information Systems', 'Engleski', '2012.', 12, 12, '	HST.S14', 'The goal of this course is the development of innovations in information systems for developing countries that will (1) translate into improvement in health outcomes, (2) strengthen the existing organizational infrastructure, and (3) create a collaborative ecosystem to maximize the value of these innovations. The course will be taught by guest speakers who are internationally recognized experts in the field and who, with their operational experiences, will outline the challenges they faced and detail how these were addressed.', 'https://www.youtube.com/playlist?list=PLUl4u3cNGP62lAvsV9K1PMR_J-Ag5vVOm', 'https://ocw.mit.edu/courses/health-sciences-and-technology/hst-s14-health-information-systems-to-improve-quality-of-care-in-resource-poor-settings-spring-2012/', 'https://img.youtube.com/vi/vQY3NziSZ2w/0.jpg'),
(101, 'Nuclear Systems Design Project', 'Engleski', '2011.', 10, 8, '22.033 / 22.33', 'In this capstone design project course, students design a nuclear reactor that generates electricity, hydrogen and biofuels. Lectures introduce each major subsystem and explore design methods, and are followed by mid-term and final student presentations.', 'https://www.youtube.com/playlist?list=PL3C69700955EB813B', 'https://ocw.mit.edu/courses/nuclear-engineering/22-033-nuclear-systems-design-project-fall-2011/', 'https://img.youtube.com/vi/-AHhHlk8AbI/0.jpg'),
(102, 'Nuclear Reactor Safety', 'Engleski', '2008.', 6, 7, '22.091 / 22.903', 'Problems in nuclear engineering often involve applying knowledge from many disciplines simultaneously in achieving satisfactory solutions. The course will focus on understanding the complete nuclear reactor system including the balance of plant, support systems and resulting interdependencies affecting the overall safety of the plant and regulatory oversight. Both the Seabrook and Pilgrim nuclear plant simulators will be used as part of the educational experience to provide as realistic as possible understanding of nuclear power systems short of being at the reactor.', 'https://www.youtube.com/playlist?list=PL9F849721A3694121', 'https://ocw.mit.edu/courses/nuclear-engineering/22-091-nuclear-reactor-safety-spring-2008/', 'https://img.youtube.com/vi/v_NcOpoHBsk/0.jpg');

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
(12, 12, 13),
(13, 13, 6),
(14, 14, 7),
(15, 15, 8),
(16, 16, 8),
(17, 17, 8),
(18, 18, 8),
(19, 0, 0),
(20, 20, 15),
(21, 21, 15),
(22, 22, 15),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 5),
(28, 28, 5),
(29, 29, 5),
(30, 30, 5),
(31, 31, 5),
(32, 32, 5),
(33, 33, 5),
(34, 34, 5),
(35, 34, 7),
(36, 35, 5),
(37, 36, 9),
(38, 37, 9),
(39, 38, 9),
(40, 39, 9),
(41, 40, 9),
(42, 41, 9),
(43, 42, 9),
(44, 43, 9),
(45, 44, 7),
(46, 45, 7),
(47, 46, 7),
(48, 47, 7),
(49, 48, 2),
(50, 49, 2),
(51, 50, 2),
(52, 51, 2),
(53, 52, 2),
(54, 53, 11),
(55, 54, 11),
(56, 55, 8),
(57, 56, 8),
(58, 57, 8),
(59, 58, 8),
(60, 59, 8),
(61, 60, 8),
(62, 61, 8),
(63, 62, 8),
(64, 63, 8),
(65, 64, 8),
(66, 65, 8),
(67, 66, 8),
(68, 19, 10),
(69, 19, 8),
(70, 67, 13),
(71, 68, 13),
(72, 69, 13),
(73, 70, 13),
(74, 70, 9),
(75, 71, 10),
(76, 72, 10),
(77, 73, 10),
(78, 74, 10),
(79, 75, 10),
(80, 76, 6),
(81, 77, 6),
(82, 78, 6),
(83, 79, 6),
(84, 80, 6),
(85, 81, 6),
(86, 82, 6),
(87, 83, 6),
(88, 84, 6),
(89, 85, 6),
(90, 86, 6),
(91, 88, 3),
(92, 89, 3),
(93, 90, 3),
(94, 91, 3),
(95, 92, 3),
(96, 93, 3),
(97, 94, 3),
(98, 95, 3),
(99, 96, 3),
(100, 97, 15),
(101, 98, 15),
(102, 99, 15),
(103, 100, 15),
(104, 101, 15),
(105, 102, 15);

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
(8, 'University of California, Los Angeles', 'USA', 'Los Angeles', NULL),
(9, 'Harvard University', 'USA', 'Cambridge', NULL),
(10, 'University of Toronto', 'Canada', 'Toronto', NULL),
(11, 'Memorial University of Newfoundland', 'Canada', 'St. John\'s', NULL),
(12, 'ETH Zürich', 'Switzerland', 'Zürich', NULL),
(13, 'University of California, Irvine', 'USA', 'Irvine', NULL),
(14, 'New York University', 'USA', 'New York City', NULL),
(15, 'UNSW Sydney', 'Australia', 'Sydney', NULL),
(16, 'University at Buffalo', 'USA', 'Buffalo', NULL),
(17, 'University of Oxford', 'United Kingdom', 'Oxford', NULL);

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
(15, 8, 20),
(16, 5, 21),
(17, 3, 22),
(18, 9, 23),
(19, 10, 24),
(20, 3, 25),
(21, 11, 26),
(22, 12, 27),
(23, 5, 28),
(24, 3, 29),
(25, 3, 30),
(26, 3, 31),
(27, 5, 32),
(28, 5, 33),
(29, 3, 34),
(30, 3, 35),
(31, 3, 36),
(32, 3, 37),
(33, 13, 38),
(34, 14, 39),
(35, 2, 40),
(36, 3, 41),
(37, 5, 42),
(38, 3, 43),
(39, 5, 44),
(40, 5, 45),
(41, 14, 46),
(42, 3, 47),
(43, 3, 48),
(44, 5, 49),
(45, 3, 50),
(46, 8, 51),
(47, 5, 52),
(48, 5, 53),
(49, 3, 54),
(50, 3, 55),
(51, 3, 56),
(52, 3, 57),
(53, 5, 58),
(54, 15, 59),
(55, 3, 60),
(56, 3, 61),
(57, 3, 62),
(58, 2, 63),
(59, 2, 64),
(60, 2, 65),
(61, 16, 66),
(62, 2, 67),
(63, 5, 68),
(64, 5, 69),
(65, 5, 70),
(66, 5, 71),
(67, 3, 72),
(68, 15, 73),
(69, 3, 74),
(70, 3, 75),
(72, 5, 77),
(73, 5, 78),
(74, 5, 79),
(75, 5, 80),
(76, 5, 81),
(77, 5, 82),
(78, 5, 83),
(79, 5, 84),
(80, 5, 85),
(81, 14, 86),
(82, 14, 87),
(83, 5, 88),
(84, 3, 89),
(85, 3, 90),
(86, 3, 91),
(87, 17, 92),
(88, 5, 93),
(89, 5, 94),
(90, 3, 95),
(91, 3, 96),
(92, 3, 97),
(93, 3, 98),
(94, 3, 99);

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
  MODIFY `idKategorije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lekcije`
--
ALTER TABLE `lekcije`
  MODIFY `idLekcije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `predavaci`
--
ALTER TABLE `predavaci`
  MODIFY `idPredavac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `predavanja`
--
ALTER TABLE `predavanja`
  MODIFY `idPredavanja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `pripadnost_kategoriji`
--
ALTER TABLE `pripadnost_kategoriji`
  MODIFY `idPripadnost_kategoriji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `ustanove`
--
ALTER TABLE `ustanove`
  MODIFY `idUstanove` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `zaposlenje`
--
ALTER TABLE `zaposlenje`
  MODIFY `idZaposlenje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
