-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 07:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmpcs_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `award_type`
--

CREATE TABLE `award_type` (
  `awardTypeID` varchar(3) NOT NULL,
  `awardType` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `award_type`
--

INSERT INTO `award_type` (`awardTypeID`, `awardType`) VALUES
('CL', 'Cum Laude'),
('CS', 'College Scholar'),
('MCL', 'Magna cum Laude'),
('SCL', 'Summa cum Laude'),
('US', 'University Scholar');

-- --------------------------------------------------------

--
-- Table structure for table `college_degree`
--

CREATE TABLE `college_degree` (
  `degID` varchar(9) NOT NULL,
  `yearLevel` int(1) DEFAULT NULL,
  `degprogID` varchar(4) DEFAULT NULL,
  `timeID` varchar(4) DEFAULT NULL,
  `count` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `college_degree`
--

INSERT INTO `college_degree` (`degID`, `yearLevel`, `degprogID`, `timeID`, `count`) VALUES
('1BSAM23-1', 1, 'BSAM', '23-1', 20),
('1BSAM23-2', 1, 'BSAM', '23-2', 19),
('1BSCS23-1', 1, 'BSCS', '23-1', 45),
('1BSCS23-2', 1, 'BSCS', '23-2', 42),
('1BSDS23-1', 1, 'BSDS', '23-1', 37),
('1BSDS23-2', 1, 'BSDS', '23-2', 34),
('2BSAM23-1', 2, 'BSAM', '23-1', 17),
('2BSAM23-2', 2, 'BSAM', '23-2', 18),
('2BSCS23-1', 2, 'BSCS', '23-1', 19),
('2BSCS23-2', 2, 'BSCS', '23-2', 19),
('3BSAM23-1', 3, 'BSAM', '23-1', 25),
('3BSAM23-2', 3, 'BSAM', '23-2', 25),
('3BSCS23-1', 3, 'BSCS', '23-1', 27),
('3BSCS23-2', 3, 'BSCS', '23-2', 25),
('4BSAM23-1', 4, 'BSAM', '23-1', 15),
('4BSAM23-2', 4, 'BSAM', '23-2', 13),
('4BSCS23-1', 4, 'BSCS', '23-1', 34),
('4BSCS23-2', 4, 'BSCS', '23-2', 30);

-- --------------------------------------------------------

--
-- Table structure for table `deg_prog`
--

CREATE TABLE `deg_prog` (
  `degprogID` varchar(4) NOT NULL,
  `name` varchar(43) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `deg_prog`
--

INSERT INTO `deg_prog` (`degprogID`, `name`) VALUES
('BSAM', 'Bachelor of Science in  Applied Mathematics'),
('BSCS', 'Bachelor of Science in Computer Science'),
('BSDS', 'Bachelor of Science in Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `educ_attainment`
--

CREATE TABLE `educ_attainment` (
  `educAttainmentID` varchar(2) NOT NULL,
  `attainment` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `educ_attainment`
--

INSERT INTO `educ_attainment` (`educAttainmentID`, `attainment`) VALUES
('A1', 'Ph.D.'),
('A2', 'M.Sc.'),
('A3', 'M.M'),
('A4', 'MSCS, MICT');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventID` varchar(2) NOT NULL,
  `eventName` varchar(7) DEFAULT NULL,
  `timeID` varchar(4) DEFAULT NULL,
  `count` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventID`, `eventName`, `timeID`, `count`) VALUES
('E1', 'Event 1', '23-1', 50),
('E2', 'Event 2', '23-1', 45),
('E3', 'Event 3', '23-2', 98),
('E4', 'Event 4', '23-1', 35),
('E5', 'Event 5', '23-1', 8),
('E6', 'Event 6', '23-2', 35),
('E8', 'Event 8', '24-1', 54);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `facultyID` varchar(3) NOT NULL,
  `rankID` varchar(7) DEFAULT NULL,
  `educAttainmentID` varchar(2) DEFAULT NULL,
  `publicationID` varchar(3) DEFAULT NULL,
  `timeID` varchar(4) DEFAULT NULL,
  `count` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyID`, `rankID`, `educAttainmentID`, `publicationID`, `timeID`, `count`) VALUES
('F1', 'P1', 'A2', 'PR1', '23-1', 3),
('F10', 'ASSOCP4', 'A3', 'PR1', '23-2', 10),
('F11', 'ASSOCP5', 'A4', 'PR2', '23-1', 5),
('F12', 'ASSISP1', 'A1', 'PR4', '23-2', 8),
('F13', 'ASSISP2', 'A2', 'PR2', '23-1', 12),
('F14', 'ASSISP3', 'A4', 'PR3', '23-2', 23),
('F15', 'ASSISP4', 'A1', 'PR2', '23-1', 9),
('F16', 'ASSISP5', 'A2', 'PR1', '23-2', 6),
('F17', 'ASSISP6', 'A4', 'PR4', '23-1', 2),
('F18', 'INS1', 'A2', 'PR3', '23-2', 2),
('F19', 'INS2', 'A3', 'PR2', '23-1', 4),
('F2', 'P2', 'A1', 'PR2', '23-2', 5),
('F20', 'INS3', 'A2', 'PR5', '23-2', 3),
('F21', 'LEC', 'A2', 'PR1', '23-1', 5),
('F22', 'SLEC', 'A2', 'PR1', '23-2', 1),
('F3', 'P3', 'A2', 'PR3', '23-1', 8),
('F4', 'P4', 'A1', 'PR4', '23-2', 10),
('F5', 'P5', 'A2', 'PR5', '23-1', 10),
('F6', 'P6', 'A1', 'PR5', '23-2', 4),
('F7', 'ASSOCP1', 'A3', 'PR2', '23-1', 6),
('F8', 'ASSOCP2', 'A4', 'PR1', '23-2', 11),
('F9', 'ASSOCP3', 'A2', 'PR3', '23-1', 13);

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `publicationID` varchar(3) NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `timeID` varchar(4) DEFAULT NULL,
  `count` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`publicationID`, `title`, `timeID`, `count`) VALUES
('PR1', 'Research 1', '23-2', 3),
('PR2', 'Research 2', '23-1', 2),
('PR3', 'Research 3', '23-2', 4),
('PR4', 'Research 4', '23-1', 3),
('PR5', 'Research 5', '23-2', 5);

-- --------------------------------------------------------

--
-- Table structure for table `rank_title`
--

CREATE TABLE `rank_title` (
  `rankID` varchar(7) NOT NULL,
  `title` varchar(21) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rank_title`
--

INSERT INTO `rank_title` (`rankID`, `title`) VALUES
('ASSISP1', 'Assistant Professor 1'),
('ASSISP2', 'Assistant Professor 2'),
('ASSISP3', 'Assistant Professor 3'),
('ASSISP4', 'Assistant Professor 4'),
('ASSISP5', 'Assistant Professor 5'),
('ASSISP6', 'Assistant Professor 6'),
('ASSOCP1', 'Associate Professor 1'),
('ASSOCP2', 'Associate Professor 2'),
('ASSOCP3', 'Associate Professor 3'),
('ASSOCP4', 'Associate Professor 4'),
('ASSOCP5', 'Associate Professor 5'),
('INS1', 'Instructor 1'),
('INS2', 'Instructor 2'),
('INS3', 'Instructor 3'),
('LEC', 'Lecturer'),
('P1', 'Professor 1'),
('P2', 'Professor 2'),
('P3', 'Professor 3'),
('P4', 'Professor 4'),
('P5', 'Professor 5'),
('P6', 'Professor 6'),
('SLEC', 'Senior Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `student_awards`
--

CREATE TABLE `student_awards` (
  `awardID` varchar(5) NOT NULL,
  `awardTypeID` varchar(3) DEFAULT NULL,
  `degID` varchar(9) DEFAULT NULL,
  `count` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_awards`
--

INSERT INTO `student_awards` (`awardID`, `awardTypeID`, `degID`, `count`) VALUES
('SAT1', 'US', '1BSAM23-1', 45),
('SAT10', 'US', '1BSCS23-2', 45),
('SAT11', 'US', '2BSCS23-1', 18),
('SAT12', 'CS', '2BSCS23-2', 20),
('SAT13', 'US', '3BSCS23-1', 16),
('SAT14', 'CS', '3BSCS23-2', 23),
('SAT15', 'CS', '4BSCS23-1', 22),
('SAT16', 'SCL', '4BSCS23-2', 24),
('SAT17', 'CS', '1BSDS23-1', 45),
('SAT18', 'CS', '1BSDS23-2', 45),
('SAT2', 'CS', '1BSAM23-2', 45),
('SAT3', 'US', '2BSAM23-1', 23),
('SAT4', 'CS', '2BSAM23-2', 12),
('SAT5', 'CS', '3BSAM23-1', 23),
('SAT6', 'US', '3BSAM23-2', 23),
('SAT7', 'CS', '4BSAM23-1', 12),
('SAT8', 'MCL', '4BSAM23-2', 8),
('SAT9', 'US', '1BSCS23-1', 45);

-- --------------------------------------------------------

--
-- Table structure for table `time_period`
--

CREATE TABLE `time_period` (
  `timeID` varchar(4) NOT NULL,
  `SchoolYear` varchar(9) DEFAULT NULL,
  `semester` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `time_period`
--

INSERT INTO `time_period` (`timeID`, `SchoolYear`, `semester`) VALUES
('23-1', '2022-2023', 1),
('23-2', '2022-2023', 2),
('24-1', '2023-2024', 1),
('24-2', '2023-2024', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `award_type`
--
ALTER TABLE `award_type`
  ADD PRIMARY KEY (`awardTypeID`);

--
-- Indexes for table `college_degree`
--
ALTER TABLE `college_degree`
  ADD PRIMARY KEY (`degID`),
  ADD KEY `fk_degprogID` (`degprogID`),
  ADD KEY `fk_timeID` (`timeID`);

--
-- Indexes for table `deg_prog`
--
ALTER TABLE `deg_prog`
  ADD PRIMARY KEY (`degprogID`);

--
-- Indexes for table `educ_attainment`
--
ALTER TABLE `educ_attainment`
  ADD PRIMARY KEY (`educAttainmentID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `fk_tm_timeID` (`timeID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`facultyID`),
  ADD KEY `fk_rankID` (`rankID`),
  ADD KEY `fk_educAttainmentID` (`educAttainmentID`),
  ADD KEY `fk_publi_publicationID` (`publicationID`),
  ADD KEY `fk_t_timeID` (`timeID`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`publicationID`),
  ADD KEY `fk_tim_timeID` (`timeID`);

--
-- Indexes for table `rank_title`
--
ALTER TABLE `rank_title`
  ADD PRIMARY KEY (`rankID`);

--
-- Indexes for table `student_awards`
--
ALTER TABLE `student_awards`
  ADD PRIMARY KEY (`awardID`),
  ADD KEY `fk_awardTypeID` (`awardTypeID`),
  ADD KEY `fk_degID` (`degID`);

--
-- Indexes for table `time_period`
--
ALTER TABLE `time_period`
  ADD PRIMARY KEY (`timeID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `college_degree`
--
ALTER TABLE `college_degree`
  ADD CONSTRAINT `fk_degprogID` FOREIGN KEY (`degprogID`) REFERENCES `deg_prog` (`degprogID`),
  ADD CONSTRAINT `fk_timeID` FOREIGN KEY (`timeID`) REFERENCES `time_period` (`timeID`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_tm_timeID` FOREIGN KEY (`timeID`) REFERENCES `time_period` (`timeID`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `fk_educAttainmentID` FOREIGN KEY (`educAttainmentID`) REFERENCES `educ_attainment` (`educAttainmentID`),
  ADD CONSTRAINT `fk_publi_publicationID` FOREIGN KEY (`publicationID`) REFERENCES `publication` (`publicationID`),
  ADD CONSTRAINT `fk_rankID` FOREIGN KEY (`rankID`) REFERENCES `rank_title` (`rankID`),
  ADD CONSTRAINT `fk_t_timeID` FOREIGN KEY (`timeID`) REFERENCES `time_period` (`timeID`);

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `fk_tim_timeID` FOREIGN KEY (`timeID`) REFERENCES `time_period` (`timeID`),
  ADD CONSTRAINT `fk_tme_timeID` FOREIGN KEY (`timeID`) REFERENCES `time_period` (`timeID`);

--
-- Constraints for table `student_awards`
--
ALTER TABLE `student_awards`
  ADD CONSTRAINT `fk_awardTypeID` FOREIGN KEY (`awardTypeID`) REFERENCES `award_type` (`awardTypeID`),
  ADD CONSTRAINT `fk_degID` FOREIGN KEY (`degID`) REFERENCES `college_degree` (`degID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
