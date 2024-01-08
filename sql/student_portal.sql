-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 07:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `baptism`
--

CREATE TABLE `baptism` (
  `baptism_id` int(11) NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `baptism`
--

INSERT INTO `baptism` (`baptism_id`, `place`, `date`) VALUES
(1, 'Valenzuela', '2003-07-28'),
(2, 'Valenzuela', '2024-01-16'),
(3, 'Valenzuela', '2024-01-19'),
(4, 'Valenzuela', '2024-01-19');

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `college_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`college_id`, `year`, `name`, `address`) VALUES
(1, '2019', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines'),
(2, '2019', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines'),
(3, '2019', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `college_calendar`
--

CREATE TABLE `college_calendar` (
  `college_calendar_id` int(11) NOT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `graduation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `confirmation`
--

CREATE TABLE `confirmation` (
  `confirmation_id` int(11) NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `confirmation`
--

INSERT INTO `confirmation` (`confirmation_id`, `place`, `date`) VALUES
(1, 'Valenzuela', '2003-08-30'),
(2, 'Valenzuela', '2024-01-24'),
(3, 'Valenzuela', '2024-01-15'),
(4, 'Valenzuela', '2024-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `contact_information`
--

CREATE TABLE `contact_information` (
  `contact_information_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_information`
--

INSERT INTO `contact_information` (`contact_information_id`, `address`, `city`, `mobile_number`, `email`) VALUES
(1, '34 road 5 San Miguel Ridge Marulas', 'Valenzuela', '9563260888', 'millaminaminalyn@gmail.com'),
(2, '34 road 5 San Miguel Ridge Marulas', 'Valenzuela', '9563260888', 'millaminaminalyn@gmail.com'),
(3, '34 road 5 San Miguel Ridge Marulas', 'Valenzuela', '9563260888', 'millaminaminalyn@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_name`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology'),
(2, 'BSHM', 'Bachelor of Science in Hospitality Management'),
(3, 'BSBA', 'Bachelor of Science in Business Administration'),
(4, 'BEED', 'Bachelor of Elementary Education'),
(5, 'BSE-ENGLISH', 'Bachelor of Secondary Education major in English'),
(6, 'BSE-MATHEMATICS', 'Bachelor of Secondary Education major in Mathematics'),
(7, 'BSCRIM', 'Bachelor of Science in Criminology');

-- --------------------------------------------------------

--
-- Table structure for table `educational_attainment`
--

CREATE TABLE `educational_attainment` (
  `educational_attainment_id` int(11) NOT NULL,
  `kindergarten_id` int(11) DEFAULT NULL,
  `elementary_id` int(11) DEFAULT NULL,
  `junior_high_id` int(11) DEFAULT NULL,
  `senior_high_id` int(11) DEFAULT NULL,
  `college_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `educational_attainment`
--

INSERT INTO `educational_attainment` (`educational_attainment_id`, `kindergarten_id`, `elementary_id`, `junior_high_id`, `senior_high_id`, `college_id`) VALUES
(1, 1, 1, 1, 1, 1),
(2, 2, 2, 2, 2, 2),
(3, 3, 3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `elementary`
--

CREATE TABLE `elementary` (
  `elementary_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `elementary`
--

INSERT INTO `elementary` (`elementary_id`, `year`, `name`, `address`) VALUES
(1, '2005', 'San Miguel Heights Elementary School', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila'),
(2, '2005', 'San Miguel Heights Elementary School', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila'),
(3, '2005', 'San Miguel Heights Elementary School', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `emergency_contact_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `emergency_contact`
--

INSERT INTO `emergency_contact` (`emergency_contact_id`, `name`, `relationship`, `address`, `company`, `company_address`, `mobile_number`) VALUES
(1, 'Ferdinand A. Millamina', 'Father', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9286825931'),
(2, 'Ferdinand A. Millamina', 'Father', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888'),
(3, 'Ferdinand A. Millamina', 'Father', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_subjects`
--

CREATE TABLE `enrolled_subjects` (
  `enrolled_subject_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `prelim` float DEFAULT NULL,
  `midterm` float DEFAULT NULL,
  `finals` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `school_year` varchar(255) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_tbl_id` int(11) DEFAULT NULL,
  `professor_details_id` int(11) DEFAULT NULL,
  `subject_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enrolled_subjects`
--

INSERT INTO `enrolled_subjects` (`enrolled_subject_id`, `student_id`, `subject_id`, `prelim`, `midterm`, `finals`, `total`, `school_year`, `year_level_id`, `semester_tbl_id`, `professor_details_id`, `subject_status`) VALUES
(1, NULL, 188, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, 189, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, 190, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(5, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(6, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(7, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(8, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(9, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', NULL, NULL, NULL, 'enrolled'),
(10, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(11, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(12, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(13, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(14, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(15, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(16, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(17, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(18, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(19, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(20, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(21, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(22, NULL, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(23, NULL, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(24, NULL, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(25, 1, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(26, 1, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(27, 1, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, 'enrolled'),
(44, 2, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(45, 2, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(46, 2, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(47, 2, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(48, 2, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(49, 2, 171, NULL, NULL, NULL, NULL, '2023-2024', 1, 2, NULL, NULL),
(50, 3, 188, 1.5, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(55, 3, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(56, 3, 188, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(57, 3, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(58, 3, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(59, 3, 187, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(60, 3, 189, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(61, 3, 190, NULL, NULL, NULL, NULL, '2023-2024', 1, 1, NULL, NULL),
(62, 3, 171, NULL, NULL, NULL, NULL, '2023-2024', 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_details`
--

CREATE TABLE `enrollment_details` (
  `enrollment_details_id` int(11) NOT NULL,
  `school_year` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_tbl_id` int(11) DEFAULT NULL,
  `admission_type` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enrollment_details`
--

INSERT INTO `enrollment_details` (`enrollment_details_id`, `school_year`, `course_id`, `year_level_id`, `semester_tbl_id`, `admission_type`, `enrollment_date`, `reference_no`) VALUES
(1, '2023-2024', 1, 1, 1, 'Transferee', NULL, NULL),
(2, '2023-2024', 1, 1, 1, 'New Student', '2024-01-08', NULL),
(3, '2023-2024', 1, 1, 1, 'New Student', '2024-01-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `examination_period`
--

CREATE TABLE `examination_period` (
  `examination_period_id` int(11) NOT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `exam_name` varchar(255) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_record`
--

CREATE TABLE `family_record` (
  `family_record_id` int(11) NOT NULL,
  `father_id` int(11) DEFAULT NULL,
  `mother_id` int(11) DEFAULT NULL,
  `emergency_contact_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `family_record`
--

INSERT INTO `family_record` (`family_record_id`, `father_id`, `mother_id`, `emergency_contact_id`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `father`
--

CREATE TABLE `father` (
  `father_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `father`
--

INSERT INTO `father` (`father_id`, `name`, `address`, `company`, `company_address`, `mobile_number`) VALUES
(1, 'Ferdinand A. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9286825931'),
(2, 'Ferdinand A. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888'),
(3, 'Ferdinand A. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888');

-- --------------------------------------------------------

--
-- Table structure for table `gwa`
--

CREATE TABLE `gwa` (
  `gwa_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `gwa` varchar(255) DEFAULT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `handled_subjects`
--

CREATE TABLE `handled_subjects` (
  `handled_subject_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historytbl`
--

CREATE TABLE `historytbl` (
  `id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `junior_high`
--

CREATE TABLE `junior_high` (
  `junior_high_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `junior_high`
--

INSERT INTO `junior_high` (`junior_high_id`, `year`, `name`, `address`) VALUES
(1, '2011', 'Valenzuela National High School', 'R . Valenzuela, Lungsod ng Valenzuela'),
(2, '2011', 'Valenzuela National High School', 'R . Valenzuela, Lungsod ng Valenzuela'),
(3, '2011', 'Valenzuela National High School', 'R . Valenzuela, Lungsod ng Valenzuela');

-- --------------------------------------------------------

--
-- Table structure for table `kindergarten`
--

CREATE TABLE `kindergarten` (
  `kindergarten_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kindergarten`
--

INSERT INTO `kindergarten` (`kindergarten_id`, `year`, `name`, `address`) VALUES
(1, '2004', 'San Miguel Heights ES Kindergarten', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila'),
(2, '2004', 'San Miguel Heights ES Kindergarten', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila'),
(3, '2004', 'San Miguel Heights ES Kindergarten', 'San Miguel Heights Elementary School, Valenzuela City, Metro Manila');

-- --------------------------------------------------------

--
-- Table structure for table `mother`
--

CREATE TABLE `mother` (
  `mother_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mother`
--

INSERT INTO `mother` (`mother_id`, `name`, `address`, `company`, `company_address`, `mobile_number`) VALUES
(1, 'Evelyn D. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888'),
(2, 'Evelyn D. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888'),
(3, 'Evelyn D. Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9563260888');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `datetime`) VALUES
(1, 'Minalyn Millamina completed the enrollment process.', '2024-01-08 23:50:30'),
(2, 'Minalyn Millamina completed the enrollment process.', '2024-01-08 23:50:30'),
(3, 'Minalyn Millamina completed the enrollment process.', '2024-01-08 23:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `open_subjects`
--

CREATE TABLE `open_subjects` (
  `open_subject_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_tbl_id` int(11) DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `open_subjects`
--

INSERT INTO `open_subjects` (`open_subject_id`, `course_id`, `subject_id`, `year_level_id`, `semester_tbl_id`, `isDefault`) VALUES
(400, 1, 188, 1, 2, 0),
(401, 1, 189, 1, 2, 0),
(402, 1, 190, 1, 2, 0),
(403, 2, 117, 1, 1, 0),
(404, 2, 118, 1, 1, 0),
(405, 2, 120, 1, 1, 0),
(406, 2, 121, 1, 1, 0),
(407, 2, 134, 1, 2, 0),
(408, 2, 135, 1, 2, 0),
(409, 2, 136, 1, 2, 0),
(410, 2, 137, 1, 2, 0),
(411, 2, 138, 1, 2, 0),
(412, 7, 1, 1, 1, 0),
(413, 7, 2, 1, 1, 0),
(414, 7, 3, 1, 1, 0),
(415, 7, 4, 1, 1, 0),
(416, 7, 53, 1, 2, 0),
(417, 7, 54, 1, 2, 0),
(418, 7, 55, 1, 2, 0),
(419, 7, 56, 1, 2, 0),
(420, 3, 239, 1, 1, 0),
(421, 3, 240, 1, 1, 0),
(422, 3, 242, 1, 1, 0),
(423, 3, 253, 1, 1, 0),
(424, 1, 171, 1, 1, 0),
(425, 1, 171, 1, 1, 0),
(426, 1, 207, 1, 1, 0),
(427, 1, 176, 1, 1, 0),
(428, 1, 178, 1, 1, 0),
(429, 1, 187, 1, 2, 0),
(430, 1, 189, 1, 2, 0),
(431, 1, 190, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `personal_information`
--

CREATE TABLE `personal_information` (
  `personal_information_id` int(11) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `baptism_id` int(11) DEFAULT NULL,
  `confirmation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `personal_information`
--

INSERT INTO `personal_information` (`personal_information_id`, `gender`, `birthday`, `age`, `birth_place`, `citizenship`, `height`, `weight`, `baptism_id`, `confirmation_id`) VALUES
(1, 'female', '2002-07-24', 21, 'Valenzuela', 'Filipino', 152, 46, 1, 1),
(2, 'female', '2002-07-24', 21, 'Valenzuela', 'Filipino', 152, 46, 2, 2),
(3, 'female', '2002-07-24', 21, 'Valenzuela', 'Filipino', 152, 46, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor_id` int(11) NOT NULL,
  `professor_details_id` int(11) DEFAULT NULL,
  `handled_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professor_details`
--

CREATE TABLE `professor_details` (
  `professor_details_id` int(11) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `record_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `so_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_goodmoral`
--

CREATE TABLE `request_goodmoral` (
  `id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_honorable`
--

CREATE TABLE `request_honorable` (
  `id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_messages`
--

CREATE TABLE `request_messages` (
  `id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_tor`
--

CREATE TABLE `request_tor` (
  `id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_account`
--

CREATE TABLE `school_account` (
  `school_account_id` int(11) NOT NULL,
  `student_number_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `school_account`
--

INSERT INTO `school_account` (`school_account_id`, `student_number_id`, `password`) VALUES
(1, 1, 'NgCePpAH'),
(2, 2, 'ChnUYfjs'),
(3, 3, 'PhkGofNz');

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(255) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester_tbl_id` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester_tbl`
--

CREATE TABLE `semester_tbl` (
  `semester_tbl_id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_tbl`
--

INSERT INTO `semester_tbl` (`semester_tbl_id`, `semester`) VALUES
(1, 'First Semester'),
(2, 'Second Semester');

-- --------------------------------------------------------

--
-- Table structure for table `senior_high`
--

CREATE TABLE `senior_high` (
  `senior_high_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `senior_high`
--

INSERT INTO `senior_high` (`senior_high_id`, `year`, `name`, `address`) VALUES
(1, '2017', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines'),
(2, '2017', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines'),
(3, '2017', 'Our Lady of Lourdes College', '5031 Gen. T. de Leon, Valenzuela, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_number_id` int(11) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_number_id`, `surname`, `first_name`, `middle_name`, `suffix`) VALUES
(1, 1, 'Millamina', 'Minalyn', 'Dalit', ''),
(2, 2, 'Millamina', 'Minalyn', 'Dalit', ''),
(3, 3, 'Millamina', 'Minalyn', 'Dalit', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_information`
--

CREATE TABLE `student_information` (
  `student_information_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `personal_information_id` int(11) DEFAULT NULL,
  `contact_information_id` int(11) DEFAULT NULL,
  `educational_attainment_id` int(11) DEFAULT NULL,
  `family_record_id` int(11) DEFAULT NULL,
  `school_account_id` int(11) DEFAULT NULL,
  `enrollment_details_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `profile_picture` blob DEFAULT NULL,
  `e_sign` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_information`
--

INSERT INTO `student_information` (`student_information_id`, `student_id`, `personal_information_id`, `contact_information_id`, `educational_attainment_id`, `family_record_id`, `school_account_id`, `enrollment_details_id`, `status`, `profile_picture`, `e_sign`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 'enrolled', 0x75706c6f6164732f70726f66696c655f36353938336432353339653232322e36363838303836322e6a7067, NULL),
(2, 2, 2, 2, 2, 2, 2, 2, 'Officially Enrolled', 0x75706c6f6164732f70726f66696c655f36353963313833613631393139312e33303436383634362e6a706567, NULL),
(3, 3, 3, 3, 3, 3, 3, 3, 'Officially Enrolled', 0x75706c6f6164732f70726f66696c655f36353963316137303933363464342e38323433333730332e6a706567, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_number`
--

CREATE TABLE `student_number` (
  `student_number_id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_number`
--

INSERT INTO `student_number` (`student_number_id`, `student_number`) VALUES
(1, 1300401113),
(2, 1323280013),
(3, 1323463013);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `semester_tbl_id` int(11) NOT NULL,
  `year_level_id` int(11) NOT NULL,
  `legend` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `name`, `code`, `unit`, `course_id`, `semester_tbl_id`, `year_level_id`, `legend`) VALUES
(1, 'Understanding the Self	', 'GE 1', '3', 7, 1, 1, 2),
(2, 'Reading in Philippine History', 'GE 2', '3', 7, 1, 1, 2),
(3, 'The Contemporary World', 'GE 3', '3', 7, 1, 1, 2),
(4, 'Mathematics in the Modern World', 'GE 4', '3', 7, 1, 1, 8),
(5, 'Intro to Criminology', 'Crim. 1', '3', 7, 1, 1, 9),
(6, 'Sining ng Komunikasyon', 'EC 1', '3', 7, 1, 1, 1),
(7, 'Fundamental of Martial Arts	', 'PE 1', '2', 7, 1, 1, 12),
(8, 'NSTP 1', 'NSTP 1', '3', 7, 1, 1, 11),
(9, 'OLLC Culture and Ethics 1', 'ELEC 1	', '2', 7, 1, 1, 2),
(10, 'Purposive Communication', 'GE 5', '3', 7, 2, 1, 1),
(11, 'Science, Technology, and Society', 'GE 7', '3', 7, 2, 1, 2),
(12, 'Art Appreciation', 'GEN 6', '3', 7, 2, 1, 2),
(13, 'Science, Technology, and Society', 'GE 7', '3', 7, 2, 1, 2),
(14, 'Ethics', 'GE 8', '3', 7, 2, 1, 2),
(15, 'Intro to Philippine Criminal Justice System', 'CLJ 1', '3', 7, 2, 1, 6),
(16, 'Fundamentals of Investigation and Intelligence 	', 'CDI 1', '4', 7, 2, 1, 3),
(17, 'Arnis and Disarming Techniques', 'PE 2', '2', 7, 2, 1, 11),
(18, 'NSTP 2', 'NSTP 2', '3', 7, 2, 1, 12),
(19, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 7, 2, 1, 2),
(20, 'Theories of Crime Causation', 'Criminology 2', '3', 7, 1, 2, 12),
(21, 'Philippine Literature', 'EC 3', '3', 7, 1, 2, 2),
(22, 'Human Rights Education', 'CLJ 2', '3', 7, 1, 2, 9),
(23, 'First Aid and Water Survival', 'PE 3', '2', 7, 1, 2, 2),
(24, 'Institutional Corrections', 'CA 1', '3', 7, 1, 2, 7),
(25, 'Forensic Photography', 'Forensic 1', '3', 7, 1, 2, 6),
(26, 'Human Rights Education', 'CLJ 2', '3', 7, 1, 2, 2),
(27, 'First Aid and Water Survival', 'PE 3', '2', 7, 1, 2, 2),
(28, 'Institutional Corrections', 'CA 1', '3', 7, 2, 2, 6),
(29, 'Forensic Photography', 'Forensic 1', '3', 7, 2, 2, 6),
(30, 'Character Formation, Nationalism & Patrionism', 'CFLM 1', '3', 7, 2, 2, 2),
(31, 'Specialized Crime Investigation I w/ Legal Medicine', 'CDI 2', '3', 7, 2, 2, 6),
(32, 'Personal Identification Techniques', 'Forensic 2', '3', 7, 2, 2, 2),
(33, 'General Chemistry (Organic)', 'AdGE', '3', 7, 2, 2, 5),
(34, 'Human Behavior & Victomology ', 'Criminology 3', '3', 7, 2, 2, 9),
(35, 'Introduction to Industrial Security Concepts', 'LEA 3', '3', 7, 2, 2, 2),
(36, 'Marksmanship & Combat Shooting', 'PE 4', '2', 7, 2, 2, 12),
(37, 'Non-Institutional Corrections', 'CA 2', '3', 7, 1, 3, 5),
(38, 'Character Formation with Leadership, Decision Making, Mngt. and Amin.', 'CFLM 2', '3', 7, 1, 3, 9),
(39, 'Specialized Crime Investigation 2', 'CDI 3', '3', 7, 1, 3, 6),
(40, 'Forensic Chemistry and Toxicology', 'Forensic 3', '5', 7, 1, 3, 12),
(41, 'Criminal Law (Book 1)', 'CLJ 3', '3', 7, 1, 3, 6),
(42, 'Law Enforcement Operations & Planning with Crime Mapping', 'LEA 4', '3', 7, 1, 3, 12),
(43, 'Traffic Management and Accident Investigation with Driving', 'CDI 4', '3', 7, 1, 3, 6),
(44, 'Professional Conduct and Ethical Standards', 'Criminology 4', '3', 7, 1, 3, 2),
(45, 'Therapeutic Modalities', 'CA 3', '2', 7, 2, 3, 5),
(46, 'Criminal Law (Book 2)', 'CLJ 4', '4', 7, 2, 3, 6),
(47, 'Questioned Documents Examination', 'Forensic 4', '3', 7, 2, 3, 6),
(48, 'Juvenile Delinquency & Juvenile Justice System ', 'Criminology 5', '3', 7, 2, 3, 6),
(49, 'Lie Detection Techniques', 'Forensic 5', '3', 7, 2, 3, 12),
(50, 'Evidence', 'CLJ 5', '3', 7, 2, 3, 6),
(51, 'Technical Englis 1 (Technical Report Writing)', 'CDI 5', '3', 7, 2, 3, 1),
(52, 'Fire Protection and Arson Investigation', 'CDI 6', '3', 7, 2, 3, 4),
(53, 'Internship (On-the-Job-Training)', 'Criminology Pract 1', '3', 7, 1, 4, 11),
(54, 'Dispute Resolution and Crises Incidents Management', 'Criminology 6', '3', 7, 1, 4, 12),
(55, 'Forensic Ballistics', 'Forensic 6', '3', 7, 1, 4, 12),
(56, 'Criminal Procedure and Court Testimony', 'CLJ 6', '3', 7, 1, 4, 6),
(57, 'Criminological Research 1 (Research Methods with Applied Statistics)', 'Criminology 7', '3', 7, 1, 4, 9),
(58, 'Vice and Drug Education and Control', 'CDI 7', '3', 7, 1, 4, 7),
(59, 'Internship (On-the-Job-Training 2)', 'Criminology Pract 2', '3', 7, 2, 4, 11),
(60, 'Criminological Research 2 (Thesis Writing and Presentation)', 'Criminology 8', '3', 7, 2, 4, 6),
(61, 'Technical English 2 (Legal Forms)', 'CDI 8', '3', 7, 2, 4, 1),
(62, 'Introduction to Cybercrime and Environmental Laws and Protections', 'CDI 9', '3', 7, 2, 4, 6),
(63, 'Understanding the Self', 'GE 1', '3', 5, 1, 1, 2),
(64, 'Readings in the Phil. History', 'GE 2', '3', 5, 1, 1, 2),
(65, 'The Contemporary World', 'GE 3', '3', 5, 1, 1, 2),
(66, 'Mathematics in the Modern World', 'GE 4', '3', 5, 1, 1, 8),
(67, 'History of Mathematics', 'SEMC M100', '3', 5, 1, 1, 8),
(68, 'College & Advance Algebra', 'SEMC M101', '3', 5, 1, 1, 8),
(69, 'Physical Education 1', 'PE 1', '3', 5, 1, 1, 11),
(70, 'NSTP 1', 'NSTP 1', '2', 5, 1, 1, 11),
(71, 'OLLC Culture & Ethics', 'ELEC 1', '2', 5, 1, 1, 2),
(72, 'Art Appreciation', 'GE 5', '3', 5, 2, 1, 2),
(73, 'Science, Technology, & Society', 'GE 6', '3', 5, 2, 1, 2),
(74, 'Ethics', 'GE 7', '3', 5, 2, 1, 2),
(75, 'The Child & Adol. Learness & Learning Prin.', 'SEPC 1', '3', 5, 2, 1, 8),
(76, 'Trigonometry', 'SEMC M102', '3', 5, 2, 1, 8),
(77, 'Plane & Solid Geometry', 'SEMC M103', '3', 5, 2, 1, 0),
(78, 'Teachings in Specialized Field', 'ELECT', '3', 5, 2, 1, 11),
(79, 'Physical Education 2', 'PE 2', '2', 5, 2, 1, 11),
(80, 'NSTP 2', 'NSTP 2', '3', 5, 2, 1, 0),
(81, 'OLLC Culture & Ethics 2', 'ELEC 2', '2', 5, 2, 1, 2),
(82, 'Purposive Communication', 'GE 8', '3', 5, 1, 2, 2),
(83, 'Rizal Works & Writings', 'GE 9 RIZAL', '3', 5, 1, 2, 4),
(84, 'Structure of English', 'GE 10', '3', 5, 1, 2, 1),
(85, 'The Teaching Profession', 'SEPC 2', '3', 5, 1, 2, 9),
(86, 'Elementary Statistics and Prob.', 'SEMC M105', '3', 5, 1, 2, 3),
(87, 'Calculus 1 (W/ Analytic Geometry)', 'SEMC M106', '4', 5, 1, 2, 8),
(88, 'Logic and Set Theory', 'SEMC M104', '3', 5, 1, 2, 3),
(89, 'PE 3', 'PE 3', '2', 5, 1, 2, 11),
(90, 'Calculus II', 'SEMC M107', '4', 5, 2, 2, 8),
(91, 'Modern Geometry', 'SEMC M109', '3', 5, 2, 2, 8),
(92, 'Mathematics of Investment', 'SEMC M110', '3', 5, 2, 2, 8),
(93, 'Number Theory', 'SEMC M111', '3', 5, 2, 2, 8),
(94, 'Pananaliksik sa Filipino', 'GE 11', '3', 5, 2, 2, 1),
(95, 'The Teacher & The Community, School Culture & Organizational Leadership', 'SEPC 3', '3', 5, 2, 2, 2),
(96, 'Foundation of Special & Inclusive Educ.', 'SEPC 4', '3', 5, 2, 2, 9),
(97, 'PE 4', 'PE 4', '2', 5, 2, 2, 11),
(98, 'Calculus III', 'SEMC M108', '4', 5, 1, 3, 8),
(99, 'Linear Algebra', 'SEMC M112', '3', 5, 1, 3, 8),
(100, 'Advanced Statistics', 'SEMC M113', '3', 5, 1, 3, 8),
(101, 'Malikhaing Pagsulat', 'GE 12', '3', 5, 1, 3, 4),
(102, 'Abstract Algebra', 'SEMC 114', '3', 5, 1, 3, 8),
(103, 'Facilitating Learner Centered Teaching', 'SEPC 5', '3', 5, 1, 3, 9),
(104, 'Assessment in Learning 1', 'SEPC 6', '3', 5, 1, 3, 2),
(105, 'Technology for Teaching and Learning 1', 'SEPC 7', '3', 5, 1, 3, 2),
(106, 'Problem Solving Mathematical Investigations & Modeling ', 'SEMC 115', '3', 5, 2, 3, 8),
(107, 'Prin. & Stat. of Teaching Math', 'SEMC 116', '3', 5, 2, 3, 8),
(108, 'Tech. for Teaching & Learning 2', 'SEMC 117', '3', 5, 2, 3, 9),
(109, 'Research in Mathematics', 'SEMC 118', '3', 5, 2, 3, 8),
(110, 'Assessment & Eval. In Math', 'SEMC 119', '3', 5, 2, 3, 8),
(111, 'Assessment in Learning 2', 'SPEC 8', '3', 5, 2, 3, 9),
(112, 'The Teacher & School Curriculum', 'SPEC 9', '3', 5, 2, 3, 9),
(113, 'Bldg. & Enhancing New Literacies Across the Curriculum', 'SPEC 10', '3', 5, 2, 3, 2),
(114, 'Field Study 1-3', 'SPEC 11', '3', 5, 1, 4, 2),
(115, 'Field Study 4-6', 'SPEC 12', '3', 5, 1, 4, 2),
(116, 'Teaching Internship', 'SPEC 13', '6', 5, 2, 4, 9),
(117, 'Understanding the Self', 'GE 1', '3', 2, 1, 1, 2),
(118, 'Readings in Philippine History', 'GE 2', '3', 2, 1, 1, 2),
(119, 'Mathematics in the Modern World', 'GE 3', '3', 2, 1, 1, 8),
(120, 'Macro Perspective in Tourism & Hospitality', 'THC 1', '3', 2, 1, 1, 2),
(121, 'Risk Mgmt. as Applied to Safety, Security & Sanitation', 'THC 2', '3', 2, 1, 1, 9),
(122, 'Physical Fitness and Gymnastics', 'PE 1', '2', 2, 1, 1, 11),
(123, 'NSTP 1', 'NSTP 1', '3', 2, 1, 1, 11),
(124, 'OLLC Culture and Ethics', 'ELEC 1', '2', 2, 1, 1, 2),
(125, 'Quality Service Management in Tourism & Hospitality', 'THC 3', '3', 2, 2, 1, 2),
(126, 'Phil. Cul & Tourism & Geography', 'THC 4', '3', 2, 2, 1, 5),
(127, 'Micro Perspective in Tourism & Hospitality', 'THC 5', '3', 2, 2, 1, 2),
(128, 'Kitchen Essen. & Basic Food Prep Hospitality', 'HPC 1', '3', 2, 2, 1, 2),
(129, 'Fundamentals in Lodging Operations', 'HPC 2', '3', 2, 2, 1, 9),
(130, 'Physical Fitness and Gymnastics', 'PE 2', '2', 2, 2, 1, 11),
(131, 'NSTP 2', 'NSTP 2', '3', 2, 2, 1, 11),
(132, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 2, 2, 1, 2),
(133, 'Purposive Communication', 'GE 4', '3', 2, 1, 2, 1),
(134, 'Science, Tech & Society', 'GE 5', '3', 2, 1, 2, 2),
(135, 'Applied Bus. Tools & Tech (PMS) w/ Lab', 'HPC 3', '3', 2, 1, 2, 2),
(136, 'Food Styling and Design', 'HMPE 1', '3', 2, 1, 2, 10),
(137, 'Supply Chain Mgmt. in Hosp. Industry', 'HPC 4', '3', 2, 1, 2, 10),
(138, 'Asian Cuisine', 'HMPE 2', '3', 2, 1, 2, 10),
(139, 'Individua/Dual Sports & Games', 'PE 3', '2', 2, 1, 2, 11),
(140, 'Ethics', 'GE 6', '3', 2, 2, 2, 2),
(141, 'Fundamentals in Food Service Opr', 'HPC 5', '3', 2, 2, 2, 10),
(142, 'Tourism & Hospitality Marketing', 'THC 6', '3', 2, 2, 2, 10),
(143, 'Garde Manger', 'HMPE 3', '3', 2, 2, 2, 9),
(144, 'Sining ng Komunikasyon', 'GE Elect 3', '3', 2, 2, 2, 1),
(145, 'Bread & Pastry', 'HMPE 4', '3', 2, 2, 2, 10),
(146, 'Team Sports & Games', 'PE 4', '2', 2, 2, 2, 11),
(147, 'Panitikang Filipino', 'GE Elect 2', '3', 2, 1, 3, 1),
(148, 'Classical French World', 'HMPE 5', '3', 2, 1, 3, 1),
(149, 'The Contemporary World', 'GE 7', '3', 2, 1, 3, 2),
(150, 'Bar & Beverage Management', 'HMPE 6', '3', 2, 1, 3, 10),
(151, 'Ergonomics & Facilities Planning for the Hospitality Industry', 'HPC 6', '3', 2, 1, 3, 2),
(152, 'Gastronomy (Food & Culture)', 'HMPE 7', '3', 2, 1, 3, 10),
(153, 'Foreign Language 1', 'HPC 7', '3', 2, 1, 3, 1),
(154, 'Arts Appreciation', 'GE 8', '3', 2, 2, 3, 2),
(155, 'Foreign Language 2', 'HPC 8', '3', 2, 2, 3, 1),
(156, 'Multi Cultural Diversity in Workplace for Tourism Professional', 'THC 7', '3', 2, 2, 3, 2),
(157, 'Entrepreneurship in Tourism Hosp.', 'THC 8', '3', 2, 2, 3, 9),
(158, 'Catering Management', 'HMPE 7', '3', 2, 2, 3, 10),
(159, 'Operation Management', 'BME 1', '3', 2, 2, 3, 10),
(160, 'Life & Works of Rizal', 'GE 9', '3', 2, 2, 3, 4),
(161, 'Legal Aspects in Tourism & Hosp', 'THC 9', '3', 2, 1, 4, 10),
(162, 'Research in Hospitality 1', 'HPC 9', '3', 2, 1, 4, 2),
(163, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 2, 1, 4, 2),
(164, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 2, 1, 4, 2),
(165, 'Philippine Popular Culture', 'GE Elect 3', '3', 2, 1, 4, 4),
(166, 'Professional Devt& Applied Ethics', 'THC 10', '3', 2, 1, 4, 2),
(167, 'Strategic Mgmt& Total Quality Mgmt.', 'BME 2', '3', 2, 1, 4, 9),
(168, 'Food & Beverage Operations', 'HMPE 8', '3', 2, 1, 4, 9),
(169, 'Research in Hospitality 2', 'HPC 11', '3', 2, 2, 4, 2),
(170, 'On-The-Job Training- Hotel/Restaurant Local/International (600 hours)', 'OJT', '6', 2, 2, 4, 9),
(171, 'Understanding the Self', 'GE 1', '3', 1, 1, 1, 2),
(172, 'Readings in Philippine History', 'GE 2', '3', 1, 1, 1, 2),
(173, 'The Contemporary World', 'GE 3', '3', 1, 1, 1, 2),
(174, 'Mathematics in the Modern World', 'GE 4', '3', 1, 1, 1, 8),
(175, 'Introduction to Computing', 'IT Comp 1', '3', 1, 1, 1, 9),
(176, 'Physical Fitness & Gymnastics', 'PE 1', '2', 1, 1, 1, 11),
(177, 'NSTP 1', 'NSTP 1', '3', 1, 1, 1, 11),
(178, 'OLLC Culture & Ethics', 'ELEC 1', '3', 1, 1, 1, 2),
(179, 'Purposive Communications', 'GE 5', '3', 1, 2, 1, 1),
(180, 'Art Appreciation', 'GE 6', '3', 1, 2, 1, 2),
(181, 'Science, Technology, and Society', 'GE 7', '3', 1, 2, 1, 2),
(182, 'Ethics', 'GE 8', '3', 1, 2, 1, 2),
(183, 'Computer Programming 1', 'IT Prog 1', '3', 1, 2, 1, 9),
(184, 'Rhythmic Activities', 'PE 2', '2', 1, 2, 1, 11),
(185, 'NSTP 2', 'NSTP 2', '3', 1, 2, 1, 11),
(186, 'OLLC Culture & Ethics', 'ELEC 2', '2', 1, 2, 1, 2),
(187, 'Data Structures & Algorithms', 'DATASA 1', '3', 1, 1, 2, 8),
(188, 'Living in the IT Era', 'GE Elect 1', '3', 1, 1, 2, 9),
(189, 'Comp. Programming 2', 'IT Prog 2', '3', 1, 1, 2, 9),
(190, 'Math, Science, & Technology', 'MATHST 1', '3', 1, 1, 2, 9),
(191, 'Rizal Life & Works', 'RIZAL', '3', 1, 1, 2, 4),
(192, 'Retorika', 'Fil 1', '3', 1, 1, 2, 1),
(193, 'Individual/Dual Sports', 'PE 3', '2', 1, 1, 2, 11),
(194, 'Great Books', 'GE Elect 2', '3', 1, 2, 2, 4),
(195, 'Database Systems', 'Database 1', '3', 1, 2, 2, 9),
(196, 'Panitikang Filipino', 'Fil 2', '3', 1, 2, 2, 1),
(197, 'Discrete Structures', 'DISSTR 1', '3', 1, 2, 2, 9),
(198, 'Platform Technology 1', 'Platec 1', '3', 1, 2, 2, 9),
(199, 'Network Technology 1', 'Netwrk 1', '3', 1, 2, 2, 9),
(200, 'Team Sports & Games', 'PE 4', '2', 1, 2, 2, 11),
(201, 'Information Security & A.', 'INFOSE 1', '3', 1, 1, 3, 9),
(202, 'Networking 2', 'Netwrk 2', '3', 1, 1, 3, 9),
(203, 'IT Technical Writing', 'IT Techw 1', '3', 1, 1, 3, 1),
(204, 'Event Driven Programming 1', 'EVDRPR 1', '3', 1, 1, 3, 9),
(205, 'System Analysis & Design', 'SYANDE 1', '3', 1, 1, 3, 9),
(206, 'Information Mgmt. 1', 'INFMAN 1', '3', 1, 1, 3, 9),
(207, 'Emerging Technologies', 'IT Prof EL 1', '3', 1, 1, 3, 9),
(208, 'Data & Digital Comm.', 'DADICO 1', '3', 1, 2, 3, 9),
(209, 'Management Info System 1', 'MAINFO 1', '3', 1, 2, 3, 9),
(210, 'Capstone Project 1', 'CAPSTNE 1', '3', 1, 2, 3, 9),
(211, 'Integrative Programming 1', 'INTPRG 1', '3', 1, 2, 3, 9),
(212, 'Adv. Database Systems', 'Database 2', '3', 1, 2, 3, 9),
(213, 'Data Mining & Warehousing', 'IT PROF EL. 2', '3', 1, 2, 3, 9),
(214, 'Human Computer Interaction', 'HUCOIN 1', '3', 1, 2, 3, 9),
(215, 'Sys. Admin & Maintenance', 'SYSADM', '3', 1, 1, 4, 9),
(216, 'E-Commerce', 'IT PROF EL.3', '3', 1, 1, 4, 7),
(217, 'Event-Driven Programming 2', 'EVDRPR 2', '3', 1, 1, 4, 9),
(218, 'Seminar in Net. Security', 'IT PROF EL 4', '3', 1, 1, 4, 9),
(219, 'Integrative Programming 2', 'INTPRG 2', '3', 1, 1, 4, 9),
(220, 'IT Capstone Project 2', 'CAPS 2', '3', 1, 1, 4, 9),
(221, 'IT Practicum', 'IT Prac', '6', 1, 2, 4, 9),
(222, 'Understanding the Self', 'GE 1', '3', 3, 1, 1, 2),
(223, 'Readings in Philippine History', 'GE 2', '3', 3, 1, 1, 2),
(224, 'The Contemporary World', 'GE 3', '3', 3, 1, 1, 2),
(225, 'Mathematics in the Modern World', 'GE 4', '3', 3, 1, 1, 8),
(226, 'Basic Microeconomics', 'BACC 1', '3', 3, 1, 1, 10),
(227, 'Physical Fitness and Gymnastics', 'PE 1', '2', 3, 1, 1, 11),
(228, 'OLLC Culture and Ethics 1', 'ELEC 1', '2', 3, 1, 1, 2),
(229, 'Operations Management', 'CBMEC 1', '3', 3, 2, 1, 9),
(230, 'Environmental Management System', 'BAMC 1', '3', 3, 2, 1, 9),
(231, 'Art Appreciation', 'GE 6', '3', 3, 2, 1, 2),
(232, 'Science, Technology and Society', 'GE 7', '3', 3, 2, 1, 2),
(233, 'Ethics', 'GE 8', '3', 3, 2, 1, 2),
(234, 'Rhythmic Activities', 'PE 2', '2', 3, 2, 1, 11),
(235, 'NSTP 2', 'NSTP 2', '3', 3, 2, 1, 11),
(236, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 3, 2, 1, 2),
(237, 'Great Books', 'GE ELEC 1', '3', 3, 1, 2, 4),
(238, 'Philippine Popular Culture', 'GE ELEC 2', '3', 3, 1, 2, 2),
(239, 'Rizals Works and Writings', 'Rizal', '3', 3, 1, 2, 9),
(240, 'Business Law (Obligation and Contracts)', 'BACC 2', '3', 3, 1, 2, 7),
(241, 'Income Taxation', 'BACC 3', '3', 3, 1, 2, 7),
(242, 'Sining ng Komunikasyon', 'FIL 1', '3', 3, 1, 2, 1),
(243, 'Individual/Dual Sports and Games', 'PE 3', '2', 3, 1, 2, 11),
(244, 'Living in IT Era', 'GE ELEC 3', '3', 3, 2, 2, 9),
(245, 'Good Governance and Social Responsibility', 'BACC 4', '3', 3, 2, 2, 2),
(246, 'Human Resource Management', 'BACC 5', '3', 3, 2, 2, 10),
(247, 'International Trade and Agreements', 'BACC 6', '3', 3, 2, 2, 10),
(248, 'Inventory Management and Control', 'BAMC 2', '3', 3, 2, 2, 10),
(249, 'Project Management', 'BAMC 3', '3', 3, 2, 2, 9),
(250, 'Costing and Pricing ', 'BAMC 4', '3', 3, 2, 2, 10),
(251, 'Team Sports and Games', 'PE 4', '2', 3, 2, 2, 11),
(252, 'Strategic Management', 'BMEC 2', '3', 3, 1, 3, 10),
(253, 'Operations Research', 'BAEC 2', '3', 3, 1, 3, 9),
(254, 'Financial Management', 'BAEC 3', '3', 3, 1, 3, 10),
(255, 'Productivity and Quality Tools', 'BAMC 6', '3', 3, 1, 3, 10),
(256, 'Logistics Management', 'BAMC 5', '3', 3, 1, 3, 3),
(257, 'Business Research', 'BACC 7', '3', 3, 2, 3, 10),
(258, 'Marketing Management', 'BAEC 3', '3', 3, 2, 3, 10),
(259, 'Facilities Management', 'BAMC 7', '3', 3, 2, 3, 10),
(260, 'Pananaliksik sa Filipino', 'FIL 2', '3', 3, 2, 3, 1),
(261, 'Managerial Accounting', 'BAEC 4', '3', 3, 2, 3, 10),
(262, 'Personal Finance', 'BAEC 5', '3', 3, 1, 4, 10),
(263, 'Entrepreneurial Management', 'BAEC 6', '3', 3, 1, 4, 9),
(264, 'Thesis Writing/Feasibility Study Writing', 'BACC 8', '3', 3, 1, 4, 9),
(265, 'Special Topics in Operations Management', 'BAMC 8', '3', 3, 2, 4, 9),
(266, 'Practicum/OJT (600hrs)', 'SEPC 13', '6', 3, 2, 4, 9),
(267, 'Understanding the Self', 'GE 1', '3', 6, 1, 1, 2),
(268, 'Readings in Philippine History', 'GE 2', '3', 6, 1, 1, 2),
(269, 'The Contemporary World', 'GE 3', '3', 6, 1, 1, 2),
(270, 'Mathematics in the Modern World', 'GE 4', '3', 6, 1, 1, 8),
(271, 'Intro to Linguistics', 'SEMC EL 100', '3', 6, 1, 1, 1),
(272, 'Language Culture and Society', 'SEMC EL 101', '3', 6, 1, 1, 1),
(273, 'Structure of English', 'SEMC EL 102', '3', 6, 1, 1, 1),
(274, 'Physical Education', 'PE 1', '2', 6, 1, 1, 11),
(275, 'NSTP 1', 'NSTP 1', '3', 6, 1, 1, 11),
(276, 'OLLC Culture and Ethics 1', 'ELEC 1', '2', 6, 1, 1, 2),
(277, 'Art Appreciation', 'GE 5', '3', 6, 2, 1, 2),
(278, 'Science, Technology and Society', 'GE 6', '3', 6, 2, 1, 2),
(279, 'Ethics', 'GE 7', '3', 6, 2, 1, 2),
(280, 'Principles & Theories of Language Acquisition Learning', 'SEMC EL 103', '3', 6, 2, 1, 1),
(281, 'Language Programs and Policies in Multilingual Societies', 'SEMC EL 104', '3', 6, 2, 1, 1),
(282, 'Language Learning Materials Development', 'SEMC EL 105', '3', 6, 2, 1, 1),
(283, 'The Child and Adolescent Learners and Learning Principle', 'SEPC 1', '3', 6, 2, 1, 2),
(284, 'Physical Education 2', 'PE 2', '2', 6, 2, 1, 11),
(285, 'NSTP 2', 'NSTP 2', '3', 6, 2, 1, 11),
(286, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 6, 2, 1, 2),
(287, 'Purposive Communication', 'GE 8', '3', 6, 1, 2, 1),
(288, 'Rizal Works and Writings', 'GE 9 Rizal', '3', 6, 1, 2, 4),
(289, 'Pananaliksik sa Filipino', 'GE 10', '3', 6, 1, 2, 2),
(290, 'Teaching & Assessment of Literature Studies', 'SEMC EL 106', '3', 6, 1, 2, 2),
(291, 'Teaching & Assessment of the Macroskills', 'SEMC EL 107', '3', 6, 1, 2, 9),
(292, 'Teaching and Assessment of the Grammar', 'SEMC EL 108', '3', 6, 1, 2, 1),
(293, 'Speech and Theater Arts', 'SEMC EL 109', '3', 6, 1, 2, 1),
(294, 'PE 3', 'PE 3', '2', 6, 1, 2, 11),
(295, 'The Teaching Profession', 'SEPC 2', '3', 6, 1, 2, 9),
(296, 'Language Education Research', 'SEMC EL 110', '3', 6, 2, 2, 1),
(297, 'Children and Adolescent Literature', 'SEMC EL 111', '3', 6, 2, 2, 1),
(298, 'Mythology and Folklore', 'SEMC EL 112', '3', 6, 2, 2, 2),
(299, 'Survey of Philippine Literature in English', 'SEMC EL 113', '3', 6, 2, 2, 2),
(300, 'The Teacher and the Community, School Culture and Organizational', 'SEPC 3', '3', 6, 2, 2, 2),
(301, 'Malikhaing Pagsulat', 'GE 11', '3', 6, 2, 2, 1),
(302, 'Survey of Afro-Asian Literature', 'SEMC EL 114', '3', 6, 2, 2, 2),
(303, 'PE 4', 'PE 4', '2', 6, 2, 2, 11),
(304, 'Foundation of Special and Inclusive Education', 'SEPC 4', '3', 6, 2, 2, 2),
(305, 'World Literature', 'GE 12', '3', 6, 1, 3, 2),
(306, 'Survey of English and American Literature', 'SEMC EL 115', '3', 6, 1, 3, 2),
(307, 'Contemporary and Popular Literature', 'SEMC EL 116', '3', 6, 1, 3, 2),
(308, 'Literary Criticism', 'SEMC EL 117', '3', 6, 1, 3, 2),
(309, 'Technical Writing', 'SEMC EL 118', '3', 6, 1, 3, 1),
(310, 'Facilitating Learner-Centered Teaching', 'SEPC 5', '3', 6, 1, 3, 9),
(311, 'Assessment in Learning 1', 'SEPC 6', '3', 6, 1, 3, 1),
(312, 'Technology for Teaching and Learning 1', 'SEPC 7', '3', 6, 1, 3, 9),
(313, 'Campus Journalism', 'SEMC EL 119', '3', 6, 2, 3, 2),
(314, 'The Teacher and the School Curriculum', 'SEPC 8', '3', 6, 2, 3, 9),
(315, 'Assessment of Learning 2', 'SEPC 9', '3', 6, 2, 3, 9),
(316, 'Stylistics and Discourse Analysis', 'SE ELECT 1', '3', 6, 2, 3, 9),
(317, 'English for Specific Purposes', 'SE ELECT 2', '3', 6, 2, 3, 9),
(318, 'Technology for Teacher and Learning', 'SEMC EL 120', '3', 6, 2, 3, 9),
(319, 'Building and Enhancing New Literacies Across the Curriculum', 'SEPC 10', '3', 6, 2, 3, 2),
(320, 'Field Study 1', 'SEPC 11', '3', 6, 1, 4, 9),
(321, 'Field Study 2', 'SEPC 12', '3', 6, 1, 4, 9),
(322, 'Teaching Internship', 'SEPC 13', '6', 6, 2, 4, 9),
(323, 'Understanding the Self', 'GE 1', '3', 4, 1, 1, 2),
(324, 'Readings in Philippine History', 'GE 2', '3', 4, 1, 1, 2),
(325, 'The Contemporary World', 'GE 3', '3', 4, 1, 1, 2),
(326, 'Mathematics in the Modern World', 'GE 4', '3', 4, 1, 1, 8),
(327, 'Teaching English in the Elementary', 'EEDMC Eng. 1', '3', 4, 1, 1, 1),
(328, 'Teaching Mathematics in the Primary Grades', 'EEDMC Math. 1', '3', 4, 1, 1, 8),
(329, 'Teaching Social Studies in Elementary Grades (Phil. History & Government)', 'EEDMC SSC. 1', '3', 4, 1, 1, 2),
(330, 'Physical Education 1', 'PE 1', '2', 4, 1, 1, 11),
(331, 'NSTP 1', 'NSTP 1', '3', 4, 1, 1, 11),
(332, 'OLLC Culture and Ethics 1', 'ELEC 1', '2', 4, 1, 1, 2),
(333, 'Art Appreciation', 'GE 5', '3', 4, 2, 1, 2),
(334, 'Science, Technology and Society', 'GE 6', '3', 4, 2, 1, 2),
(335, 'Ethics', 'GE 7', '3', 4, 2, 1, 2),
(336, 'Content and Pedagogy for the Mother Tongue', 'EDDMC MTB MLE', '3', 4, 2, 1, 1),
(337, 'Teaching Math in the Intermediate Grades', 'EEDMC Math 2', '3', 4, 2, 1, 8),
(338, 'Teaching Social Studies in Elementary Grades (Culture and Geography)', 'EEDMC SSC 2', '3', 4, 2, 1, 2),
(339, 'The Child and Adolescent Learners and Learning Principles', 'EEDPC 1', '3', 4, 2, 1, 2),
(340, 'Physical Education 2', 'PE 2', '2', 4, 2, 1, 11),
(341, 'NSTP 2', 'NSTP 2', '3', 4, 2, 1, 11),
(342, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 4, 2, 1, 11),
(343, 'Purposive Communication', 'GE 8', '3', 4, 1, 2, 1),
(344, 'Rizal Works & Writings', 'GE 9 Rizal', '3', 4, 1, 2, 4),
(345, 'The Teaching Profession', 'EEDPC 2', '3', 4, 1, 2, 9),
(346, 'Pagtuturo ng Filipino sa Elementary 1', 'EEDMC Fil. 1', '3', 4, 1, 2, 9),
(347, 'Teaching in the Multi-Grade Classes', 'EED Elec.', '3', 4, 1, 2, 9),
(348, 'Edukasyong Pantahanan at Pangkabuhayan', 'EEDMC TLE 1', '3', 4, 1, 2, 2),
(349, 'Teaching Science in Elementary Grades (Biology and Chemistry', 'EEDMC Sel. 1', '3', 4, 1, 2, 5),
(350, 'PE 3', 'PE 3', '2', 4, 1, 2, 11),
(351, 'The Teacher and the Community School Culture & Orgl Leadership', 'EEDPC 3', '3', 4, 2, 2, 2),
(352, 'Foundations of Special and Inclusive Education', 'EEDPC 4', '3', 4, 2, 2, 9),
(353, 'Structure of English', 'GE 10', '3', 4, 2, 2, 1),
(354, 'Edukasyong Pantahanan at Pangkabuhayan with Entrepreneurship', 'EEDMC TLE 2', '3', 4, 2, 2, 2),
(355, 'Teaching Science in Elementary Grades (Physics, Earth and Space)', 'EEDMC Sci. 2', '3', 4, 2, 2, 9),
(356, 'Teaching English in Elementary Grade through Literature', 'EEDMC Eng 2', '3', 4, 2, 2, 9),
(357, 'Pagtuturo ng Filipino sa Elementarya (II) Panitikan ng Pilipinas', 'EEDMC FB 2', '3', 4, 2, 2, 9),
(358, 'PE 4', 'PE 4', '2', 4, 2, 2, 11),
(359, 'Pananaliksik sa Filipino', 'GE 11-Fil. 1', '3', 4, 1, 3, 1),
(360, 'Facilitating Learner-Centered Teaching', 'EEDPC 5', '3', 4, 1, 3, 9),
(361, 'Assessment of Learning 1', 'EEDPC 6', '3', 4, 1, 3, 9),
(362, 'Technology for Teaching and Learning 1', 'EEDPC 7', '3', 4, 1, 3, 9),
(363, 'Research in Education', 'EEDMC RES', '3', 4, 1, 3, 9),
(364, 'Good Manners and Right Conduct', 'EEDMC VED', '3', 4, 1, 3, 2),
(365, 'Technology for Teaching and Learning in the Elementary Grades', 'EEDMC TTL', '3', 4, 1, 3, 9),
(366, 'Malikhaing Pagsulat', 'GE 12 Fil. 2', '3', 4, 2, 3, 1),
(367, 'Teaching PE and Health in the Elementary Grades', 'EDDMC PEH', '3', 4, 2, 3, 11),
(368, 'Teaching Music in the Elementary Grades', 'EEDMC Mus', '3', 4, 2, 3, 9),
(369, 'Teaching Arts in Elementary Grades', 'EEDMC Arts', '3', 4, 2, 3, 9),
(370, 'Teacher and the School Curriculum', 'EEDPC 8', '3', 4, 2, 3, 9),
(371, 'Assessment of Learning 2', 'EEDPC 9', '3', 4, 2, 3, 9),
(372, 'Building and Enhancing New Literacies Across the Curriculum', 'EEDPC 10', '3', 4, 2, 3, 2),
(373, 'Field Study 1', 'SEPC 11', '3', 4, 1, 4, 9),
(374, 'Field Study 2', 'SEPC 12', '3', 4, 1, 4, 9),
(375, 'Teaching Internship ', 'SEPC 13', '6', 4, 2, 4, 9);

-- --------------------------------------------------------

--
-- Table structure for table `usertbl`
--

CREATE TABLE `usertbl` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `usertype` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usertbl`
--

INSERT INTO `usertbl` (`id`, `username`, `email`, `password`, `usertype`) VALUES
(19, 'dev@user', NULL, 'dev123', 'Developer'),
(33, 'admin', 'millaminaminalyn@gmail.com', 'l4zt9voy', 'Admin'),
(34, 'minalyn', 'millaminaminalyn@gmail.com', 'DRsBydpC', 'Admission'),
(35, 'mina', 'millaminaminalyn@gmail.com', 'BZaKVwot', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE `year_level` (
  `year_level_id` int(11) NOT NULL,
  `year_level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `year_level`
--

INSERT INTO `year_level` (`year_level_id`, `year_level`) VALUES
(1, 'First Year'),
(2, 'Second Year'),
(3, 'Third Year'),
(4, 'Fourth Year');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baptism`
--
ALTER TABLE `baptism`
  ADD PRIMARY KEY (`baptism_id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `college_calendar`
--
ALTER TABLE `college_calendar`
  ADD PRIMARY KEY (`college_calendar_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `confirmation`
--
ALTER TABLE `confirmation`
  ADD PRIMARY KEY (`confirmation_id`);

--
-- Indexes for table `contact_information`
--
ALTER TABLE `contact_information`
  ADD PRIMARY KEY (`contact_information_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  ADD PRIMARY KEY (`educational_attainment_id`),
  ADD KEY `kindergarten_id` (`kindergarten_id`),
  ADD KEY `elementary_id` (`elementary_id`),
  ADD KEY `junior_high_id` (`junior_high_id`),
  ADD KEY `senior_high_id` (`senior_high_id`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `elementary`
--
ALTER TABLE `elementary`
  ADD PRIMARY KEY (`elementary_id`);

--
-- Indexes for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD PRIMARY KEY (`emergency_contact_id`);

--
-- Indexes for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD PRIMARY KEY (`enrolled_subject_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `school_year_id` (`school_year`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_tbl_id`),
  ADD KEY `professor_details_id` (`professor_details_id`);

--
-- Indexes for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD PRIMARY KEY (`enrollment_details_id`),
  ADD KEY `school_year_id` (`school_year`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_tbl_id`);

--
-- Indexes for table `examination_period`
--
ALTER TABLE `examination_period`
  ADD PRIMARY KEY (`examination_period_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `family_record`
--
ALTER TABLE `family_record`
  ADD PRIMARY KEY (`family_record_id`),
  ADD KEY `father_id` (`father_id`),
  ADD KEY `mother_id` (`mother_id`),
  ADD KEY `emergency_contact_id` (`emergency_contact_id`);

--
-- Indexes for table `father`
--
ALTER TABLE `father`
  ADD PRIMARY KEY (`father_id`);

--
-- Indexes for table `gwa`
--
ALTER TABLE `gwa`
  ADD PRIMARY KEY (`gwa_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `year_level_id` (`year_level_id`);

--
-- Indexes for table `handled_subjects`
--
ALTER TABLE `handled_subjects`
  ADD PRIMARY KEY (`handled_subject_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `historytbl`
--
ALTER TABLE `historytbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `junior_high`
--
ALTER TABLE `junior_high`
  ADD PRIMARY KEY (`junior_high_id`);

--
-- Indexes for table `kindergarten`
--
ALTER TABLE `kindergarten`
  ADD PRIMARY KEY (`kindergarten_id`);

--
-- Indexes for table `mother`
--
ALTER TABLE `mother`
  ADD PRIMARY KEY (`mother_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `open_subjects`
--
ALTER TABLE `open_subjects`
  ADD PRIMARY KEY (`open_subject_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_tbl_id`);

--
-- Indexes for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD PRIMARY KEY (`personal_information_id`),
  ADD KEY `baptism_id` (`baptism_id`),
  ADD KEY `confirmation_id` (`confirmation_id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`professor_id`),
  ADD KEY `professor_details_id` (`professor_details_id`),
  ADD KEY `handled_subject_id` (`handled_subject_id`);

--
-- Indexes for table `professor_details`
--
ALTER TABLE `professor_details`
  ADD PRIMARY KEY (`professor_details_id`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `request_goodmoral`
--
ALTER TABLE `request_goodmoral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_honorable`
--
ALTER TABLE `request_honorable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_messages`
--
ALTER TABLE `request_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_tor`
--
ALTER TABLE `request_tor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_account`
--
ALTER TABLE `school_account`
  ADD PRIMARY KEY (`school_account_id`),
  ADD KEY `student_number_id` (`student_number_id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `semester_tbl_id` (`semester_tbl_id`);

--
-- Indexes for table `semester_tbl`
--
ALTER TABLE `semester_tbl`
  ADD PRIMARY KEY (`semester_tbl_id`);

--
-- Indexes for table `senior_high`
--
ALTER TABLE `senior_high`
  ADD PRIMARY KEY (`senior_high_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_number_id` (`student_number_id`);

--
-- Indexes for table `student_information`
--
ALTER TABLE `student_information`
  ADD PRIMARY KEY (`student_information_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `personal_information_id` (`personal_information_id`),
  ADD KEY `contact_information_id` (`contact_information_id`),
  ADD KEY `educational_attainment_id` (`educational_attainment_id`),
  ADD KEY `family_record_id` (`family_record_id`),
  ADD KEY `school_account_id` (`school_account_id`),
  ADD KEY `enrollment_details_id` (`enrollment_details_id`);

--
-- Indexes for table `student_number`
--
ALTER TABLE `student_number`
  ADD PRIMARY KEY (`student_number_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `semester_tbl_id` (`semester_tbl_id`),
  ADD KEY `year_level_id` (`year_level_id`);

--
-- Indexes for table `usertbl`
--
ALTER TABLE `usertbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year_level`
--
ALTER TABLE `year_level`
  ADD PRIMARY KEY (`year_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baptism`
--
ALTER TABLE `baptism`
  MODIFY `baptism_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `college_calendar`
--
ALTER TABLE `college_calendar`
  MODIFY `college_calendar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confirmation`
--
ALTER TABLE `confirmation`
  MODIFY `confirmation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_information`
--
ALTER TABLE `contact_information`
  MODIFY `contact_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  MODIFY `educational_attainment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `elementary`
--
ALTER TABLE `elementary`
  MODIFY `elementary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  MODIFY `enrolled_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  MODIFY `enrollment_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `examination_period`
--
ALTER TABLE `examination_period`
  MODIFY `examination_period_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_record`
--
ALTER TABLE `family_record`
  MODIFY `family_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `father`
--
ALTER TABLE `father`
  MODIFY `father_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gwa`
--
ALTER TABLE `gwa`
  MODIFY `gwa_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `handled_subjects`
--
ALTER TABLE `handled_subjects`
  MODIFY `handled_subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historytbl`
--
ALTER TABLE `historytbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `junior_high`
--
ALTER TABLE `junior_high`
  MODIFY `junior_high_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kindergarten`
--
ALTER TABLE `kindergarten`
  MODIFY `kindergarten_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mother`
--
ALTER TABLE `mother`
  MODIFY `mother_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `open_subjects`
--
ALTER TABLE `open_subjects`
  MODIFY `open_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=432;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `personal_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `professor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professor_details`
--
ALTER TABLE `professor_details`
  MODIFY `professor_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_goodmoral`
--
ALTER TABLE `request_goodmoral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_honorable`
--
ALTER TABLE `request_honorable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_messages`
--
ALTER TABLE `request_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_tor`
--
ALTER TABLE `request_tor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_account`
--
ALTER TABLE `school_account`
  MODIFY `school_account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester_tbl`
--
ALTER TABLE `semester_tbl`
  MODIFY `semester_tbl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `senior_high`
--
ALTER TABLE `senior_high`
  MODIFY `senior_high_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_information`
--
ALTER TABLE `student_information`
  MODIFY `student_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_number`
--
ALTER TABLE `student_number`
  MODIFY `student_number_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `year_level`
--
ALTER TABLE `year_level`
  MODIFY `year_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `college_calendar`
--
ALTER TABLE `college_calendar`
  ADD CONSTRAINT `college_calendar_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `college_calendar_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Constraints for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  ADD CONSTRAINT `educational_attainment_ibfk_1` FOREIGN KEY (`kindergarten_id`) REFERENCES `kindergarten` (`kindergarten_id`),
  ADD CONSTRAINT `educational_attainment_ibfk_2` FOREIGN KEY (`elementary_id`) REFERENCES `elementary` (`elementary_id`),
  ADD CONSTRAINT `educational_attainment_ibfk_3` FOREIGN KEY (`junior_high_id`) REFERENCES `junior_high` (`junior_high_id`),
  ADD CONSTRAINT `educational_attainment_ibfk_4` FOREIGN KEY (`senior_high_id`) REFERENCES `senior_high` (`senior_high_id`),
  ADD CONSTRAINT `educational_attainment_ibfk_5` FOREIGN KEY (`college_id`) REFERENCES `college` (`college_id`);

--
-- Constraints for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD CONSTRAINT `enrolled_subjects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_4` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_5` FOREIGN KEY (`semester_tbl_id`) REFERENCES `semester_tbl` (`semester_tbl_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_6` FOREIGN KEY (`professor_details_id`) REFERENCES `professor_details` (`professor_details_id`);

--
-- Constraints for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD CONSTRAINT `enrollment_details_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `enrollment_details_ibfk_3` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `enrollment_details_ibfk_4` FOREIGN KEY (`semester_tbl_id`) REFERENCES `semester_tbl` (`semester_tbl_id`);

--
-- Constraints for table `examination_period`
--
ALTER TABLE `examination_period`
  ADD CONSTRAINT `examination_period_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `examination_period_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Constraints for table `family_record`
--
ALTER TABLE `family_record`
  ADD CONSTRAINT `family_record_ibfk_1` FOREIGN KEY (`father_id`) REFERENCES `father` (`father_id`),
  ADD CONSTRAINT `family_record_ibfk_2` FOREIGN KEY (`mother_id`) REFERENCES `mother` (`mother_id`),
  ADD CONSTRAINT `family_record_ibfk_3` FOREIGN KEY (`emergency_contact_id`) REFERENCES `emergency_contact` (`emergency_contact_id`);

--
-- Constraints for table `gwa`
--
ALTER TABLE `gwa`
  ADD CONSTRAINT `gwa_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `gwa_ibfk_2` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `gwa_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `gwa_ibfk_4` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`);

--
-- Constraints for table `handled_subjects`
--
ALTER TABLE `handled_subjects`
  ADD CONSTRAINT `handled_subjects_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `handled_subjects_ibfk_2` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `handled_subjects_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `handled_subjects_ibfk_4` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `open_subjects`
--
ALTER TABLE `open_subjects`
  ADD CONSTRAINT `open_subjects_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `open_subjects_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `open_subjects_ibfk_4` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `open_subjects_ibfk_5` FOREIGN KEY (`semester_tbl_id`) REFERENCES `semester_tbl` (`semester_tbl_id`);

--
-- Constraints for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD CONSTRAINT `personal_information_ibfk_1` FOREIGN KEY (`baptism_id`) REFERENCES `baptism` (`baptism_id`),
  ADD CONSTRAINT `personal_information_ibfk_2` FOREIGN KEY (`confirmation_id`) REFERENCES `confirmation` (`confirmation_id`);

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`professor_details_id`) REFERENCES `professor_details` (`professor_details_id`),
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`handled_subject_id`) REFERENCES `handled_subjects` (`handled_subject_id`);

--
-- Constraints for table `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `record_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `school_account`
--
ALTER TABLE `school_account`
  ADD CONSTRAINT `school_account_ibfk_1` FOREIGN KEY (`student_number_id`) REFERENCES `student_number` (`student_number_id`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`semester_tbl_id`) REFERENCES `semester_tbl` (`semester_tbl_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`student_number_id`) REFERENCES `student_number` (`student_number_id`);

--
-- Constraints for table `student_information`
--
ALTER TABLE `student_information`
  ADD CONSTRAINT `student_information_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `student_information_ibfk_2` FOREIGN KEY (`personal_information_id`) REFERENCES `personal_information` (`personal_information_id`),
  ADD CONSTRAINT `student_information_ibfk_3` FOREIGN KEY (`contact_information_id`) REFERENCES `contact_information` (`contact_information_id`),
  ADD CONSTRAINT `student_information_ibfk_4` FOREIGN KEY (`educational_attainment_id`) REFERENCES `educational_attainment` (`educational_attainment_id`),
  ADD CONSTRAINT `student_information_ibfk_5` FOREIGN KEY (`family_record_id`) REFERENCES `family_record` (`family_record_id`),
  ADD CONSTRAINT `student_information_ibfk_6` FOREIGN KEY (`school_account_id`) REFERENCES `school_account` (`school_account_id`),
  ADD CONSTRAINT `student_information_ibfk_7` FOREIGN KEY (`enrollment_details_id`) REFERENCES `enrollment_details` (`enrollment_details_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`semester_tbl_id`) REFERENCES `semester_tbl` (`semester_tbl_id`),
  ADD CONSTRAINT `subjects_ibfk_3` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
