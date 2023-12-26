-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 07:36 AM
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
(40, 'Valenzuela', '2003-07-28'),
(41, 'Valenzuela', '2003-07-28');

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
(32, '2019', 'Our Lady of Lourdes College', '5031 Gen. T. De Leon Street, Valenzuela City');

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
(40, 'Valenzuela', '2003-08-01'),
(41, 'Valenzuela', '2003-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `contact_information`
--

CREATE TABLE `contact_information` (
  `contact_information_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` enum('Manila','Quezon City','Davao','Caloocan City','Canagatan','Taguig City','Pasig City','Valenzuela','City of Parañaque','Bacoor','Tondo','Las Piñas City','Pasay City','Mandaluyong City','Malabon','San Pedro','Navotas','Santa Ana','General Mariano Alvarez','Payatas','San Andres','Santa Cruz','San Juan','Poblacion','Santamesa','Bagong Silangan','Putatan','Western Bicutan','Banco Filipino International Village','Paco','Malate','Pandacan','San Isidro','San Antonio','Pateros','Tatalon','Sucat','Don Bosco','Lower Bicutan','Bignay','Bagumbayan','Upper Bicutan','Marikina Heights','Central Signal Village','Bayanan','Karuhatan','Bel-Air','Santo Niño','Pansol','Baclaran','West Rembo','Bagong Pag-Asa','Pinyahan') DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_information`
--

INSERT INTO `contact_information` (`contact_information_id`, `address`, `city`, `mobile_number`, `email`) VALUES
(82, '34 Road 5 San Miguel Ridge Marulas', 'Valenzuela', '9563260888', 'millaminaminalyn@gmail.com');

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
(31, 33, 2, 2, 1, 32);

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
(1, '2005', 'San Miguel Elementary School', 'Road 5 Corner Road 3 San Miguel Heights Subdivision, Valenzuela, Philippines'),
(2, '2005', 'San Miguel Elementary School', 'Road 5 Corner Road 3 San Miguel Heights Subdivision, Valenzuela, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `emergency_contact_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `emergency_contact`
--

INSERT INTO `emergency_contact` (`emergency_contact_id`, `name`, `address`, `company`, `company_address`, `mobile_number`, `relationship`) VALUES
(17, 'Ferdinand Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9286825931', 'Father');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_subject`
--

CREATE TABLE `enrolled_subject` (
  `enrolled_subject_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `subject_id` int(255) NOT NULL,
  `grades` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_details`
--

CREATE TABLE `enrollment_details` (
  `enrollment_details_id` int(11) NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year_level` varchar(255) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enrollment_details`
--

INSERT INTO `enrollment_details` (`enrollment_details_id`, `course`, `year_level`, `semester`) VALUES
(85, 'Bachelor of Science in Information Technology', NULL, NULL);

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
(15, 26, 23, 17);

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
  `mobile_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `father`
--

INSERT INTO `father` (`father_id`, `name`, `address`, `company`, `company_address`, `mobile_number`) VALUES
(26, 'Ferdinand Millamina', '34 Road 5 San Miguel Ridge Marulas', 'N/A', 'N/A', '9286825931');

-- --------------------------------------------------------

--
-- Table structure for table `handled_subjects`
--

CREATE TABLE `handled_subjects` (
  `handled_subjects_id` int(255) NOT NULL,
  `subject_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historytbl`
--

CREATE TABLE `historytbl` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `historytbl`
--

INSERT INTO `historytbl` (`id`, `action`, `username`, `timestamp`) VALUES
(8, '\'dev@user\' created a new user account named \'<strong>admin</strong>\' with the role of \'Admin\'', 'dev@user', '2023-12-19 11:07:04'),
(9, '\'admin\' created a new user account named \'<strong>minalyn</strong>\' with the role of \'Admission\'', 'admin', '2023-12-20 07:19:11'),
(10, '\'dev@user\' created a new user account named \'<strong>mina</strong>\' with the role of \'Admin\'', 'dev@user', '2023-12-20 11:38:16');

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
(1, '2011', 'Valenzuela National High School', 'R . Valenzuela, Lungsod ng Valenzuela, 1440 Kalakhang Maynila'),
(2, '2011', 'Valenzuela National High School', 'R . Valenzuela, Lungsod ng Valenzuela, 1440 Kalakhang Maynila');

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
(32, '2004', 'San Miguel ES Kindergarten', 'Road 5 Corner Road 3 San Miguel Heights Subdivision, Valenzuela, Philippines'),
(33, '2004', 'San Miguel ES Kindergarten', 'Road 5 Corner Road 3 San Miguel Heights Subdivision, Valenzuela, Philippines');

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
  `mobile_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mother`
--

INSERT INTO `mother` (`mother_id`, `name`, `address`, `company`, `company_address`, `mobile_number`) VALUES
(23, 'Evelyn Millamina', '34 Road 5 San Miguel Ridge Marulas', 'Waveblock', 'N/A', '919972611');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `datetime`) VALUES
(7, 'Minalyn Millamina submitted an admission form', '2023-12-24 23:24:55');

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
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `baptism_id` int(11) DEFAULT NULL,
  `confirmation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `personal_information`
--

INSERT INTO `personal_information` (`personal_information_id`, `gender`, `birthday`, `age`, `birth_place`, `citizenship`, `height`, `weight`, `baptism_id`, `confirmation_id`) VALUES
(32, 'female', '2002-07-24', 21, 'Valenzuela', 'filipino', 152, 46, 40, 40),
(33, 'female', '2002-07-24', 21, 'Valenzuela City', 'filipino', 152, 46, 41, 41);

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor_id` int(255) NOT NULL,
  `handled_subjects_id` int(11) NOT NULL,
  `professor_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professor_details`
--

CREATE TABLE `professor_details` (
  `professor_details_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_messages`
--

CREATE TABLE `request_messages` (
  `id` int(11) NOT NULL,
  `student_number` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_account`
--

CREATE TABLE `school_account` (
  `school_account_id` int(11) NOT NULL,
  `student_number_id` int(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `school_account`
--

INSERT INTO `school_account` (`school_account_id`, `student_number_id`, `password`) VALUES
(75, 79, 'KrhGyJZM');

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
(1, '2017', 'Our Lady of Lourdes College', '5031 Gen. T. De Leon Street, Valenzuela City');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `students_id` int(11) NOT NULL,
  `student_number_id` int(11) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`students_id`, `student_number_id`, `surname`, `first_name`, `middle_name`, `suffix`) VALUES
(86, 79, 'Millamina', 'Minalyn', 'Dalit', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_information`
--

CREATE TABLE `student_information` (
  `student_information_id` int(255) NOT NULL,
  `enrollment_details_id` int(11) DEFAULT NULL,
  `students_id` int(11) DEFAULT NULL,
  `personal_information_id` int(11) DEFAULT NULL,
  `contact_information_id` int(11) DEFAULT NULL,
  `educational_attainment_id` int(11) DEFAULT NULL,
  `family_record_id` int(11) DEFAULT NULL,
  `school_account_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `profile_picture` blob DEFAULT NULL,
  `e_sign` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_information`
--

INSERT INTO `student_information` (`student_information_id`, `enrollment_details_id`, `students_id`, `personal_information_id`, `contact_information_id`, `educational_attainment_id`, `family_record_id`, `school_account_id`, `status`, `profile_picture`, `e_sign`) VALUES
(75, 85, 86, 33, 82, 31, 15, 75, 'registered', 0x75706c6f6164732f70726f66696c655f36353838363063643566626633352e30393638333730362e6a7067, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_number`
--

CREATE TABLE `student_number` (
  `student_number_id` int(11) NOT NULL,
  `student_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_number`
--

INSERT INTO `student_number` (`student_number_id`, `student_number`) VALUES
(79, '1323091913');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `sub_name` varchar(255) DEFAULT NULL,
  `sub_code` varchar(255) DEFAULT NULL,
  `sub_unit` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `sub_name`, `sub_code`, `sub_unit`, `course`, `semester`, `year`) VALUES
(1, 'GE 1', 'Understanding the Self	', '3', 'BSCRIM', '1st', '1st Year'),
(2, 'Reading in Philippine History', 'GE 2', '3', 'BSCRIM', '1st', '1st Year'),
(3, 'The Contemporary World', 'GE 3', '3', 'BSCRIM', '1st', '1st Year'),
(4, 'Mathematics in the Modern World', 'GE 4', '3', 'BSCRIM', '1st', '1st Year'),
(5, 'Intro to Criminology', 'Crim. 1', '3', 'BSCRIM', '1st', '1st Year'),
(6, 'Sining ng Komunikasyon', 'EC 1', '3', 'BSCRIM', '1st', '1st Year'),
(7, 'Fundamental of Martial Arts	', 'PE 1', '2', 'BSCRIM', '1st', '1st Year'),
(8, 'NSTP 1', 'NSTP 1', '3', 'BSCRIM', '1st', '1st Year'),
(9, 'OLLC Culture and Ethics 1', 'ELEC 1	', '2', 'BSCRIM', '1st', '1st Year'),
(10, 'Purposive Communication', 'GE 5', '3', 'BSCRIM', '2nd', '1st Year'),
(11, 'Science, Technology, and Society', 'GE 7', '3', 'BSCRIM', '2nd', '1st Year'),
(12, 'Art Appreciation', 'GEN 6', '3', 'BSCRIM', '2nd', '1st Year'),
(13, 'Science, Technology, and Society', 'GE 7', '3', 'BSCRIM', '2nd', '1st Year'),
(14, 'Ethics', 'GE 8', '3', 'BSCRIM', '2nd', '1st Year'),
(15, 'Intro to Philippine Criminal Justice System', 'CLJ 1', '3', 'BSCRIM', '2nd', '1st Year'),
(16, 'Fundamentals of Investigation and Intelligence 	', 'CDI 1', '4', 'BSCRIM', '2nd', '1st Year'),
(17, 'Arnis and Disarming Techniques', 'PE 2', '2', 'BSCRIM', '2nd', '1st Year'),
(18, 'NSTP 2', 'NSTP 2', '3', 'BSCRIM', '2nd', '1st Year'),
(19, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 'BSCRIM', '2nd', '1st Year'),
(20, 'Theories of Crime Causation', 'Criminology 2', '3', 'BSCRIM', '1st', '2nd Year'),
(21, 'Philippine Literature', 'EC 3', '3', 'BSCRIM', '1st', '2nd Year'),
(22, 'Human Rights Education', 'CLJ 2', '3', 'BSCRIM', '1st', '2nd Year'),
(23, 'First Aid and Water Survival', 'PE 3', '2', 'BSCRIM', '1st', '2nd Year'),
(24, 'Institutional Corrections', 'CA 1', '3', 'BSCRIM', '1st', '2nd Year'),
(25, 'Forensic Photography', 'Forensic 1', '3', 'BSCRIM', '1st', '2nd Year'),
(26, 'Human Rights Education', 'CLJ 2', '3', 'BSCRIM', '1st', '2nd Year'),
(27, 'First Aid and Water Survival', 'PE 3', '2', 'BSCRIM', '1st', '2nd Year'),
(28, 'Institutional Corrections', 'CA 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(29, 'Forensic Photography', 'Forensic 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(30, 'Character Formation, Nationalism & Patrionism', 'CFLM 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(31, 'Specialized Crime Investigation I w/ Legal Medicine', 'CDI 2', '3', 'BSCRIM', '2nd', '2nd Year'),
(32, 'Personal Identification Techniques', 'Forensic 2', '3', 'BSCRIM', '2nd', '2nd Year'),
(33, 'General Chemistry (Organic)', 'AdGE', '3', 'BSCRIM', '2nd', '2nd Year'),
(34, 'Human Behavior & Victomology ', 'Criminology 3', '3', 'BSCRIM', '2nd', '2nd Year'),
(35, 'Introduction to Industrial Security Concepts', 'LEA 3', '3', 'BSCRIM', '2nd', '2nd Year'),
(36, 'Marksmanship & Combat Shooting', 'PE 4', '2', 'BSCRIM', '2nd', '2nd Year'),
(37, 'Non-Institutional Corrections', 'CA 2', '3', 'BSCRIM', '1st', '3rd Year'),
(38, 'Character Formation with Leadership, Decision Making, Mngt. and Amin.', 'CFLM 2', '3', 'BSCRIM', '1st', '3rd Year'),
(39, 'Specialized Crime Investigation 2', 'CDI 3', '3', 'BSCRIM', '1st', '3rd Year'),
(40, 'Forensic Chemistry and Toxicology', 'Forensic 3', '5', 'BSCRIM', '1st', '3rd Year'),
(41, 'Criminal Law (Book 1)', 'CLJ 3', '3', 'BSCRIM', '1st', '3rd Year'),
(42, 'Law Enforcement Operations & Planning with Crime Mapping', 'LEA 4', '3', 'BSCRIM', '1st', '3rd Year'),
(43, 'Traffic Management and Accident Investigation with Driving', 'CDI 4', '3', 'BSCRIM', '1st', '3rd Year'),
(44, 'Professional Conduct and Ethical Standards', 'Criminology 4', '3', 'BSCRIM', '1st', '3rd Year'),
(45, 'Therapeutic Modalities', 'CA 3', '2', 'BSCRIM', '2nd', '3rd Year'),
(46, 'Criminal Law (Book 2)', 'CLJ 4', '4', 'BSCRIM', '2nd', '3rd Year'),
(47, 'Questioned Documents Examination', 'Forensic 4', '3', 'BSCRIM', '2nd', '3rd Year'),
(48, 'Juvenile Delinquency & Juvenile Justice System ', 'Criminology 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(49, 'Lie Detection Techniques', 'Forensic 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(50, 'Evidence', 'CLJ 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(51, 'Technical Englis 1 (Technical Report Writing)', 'CDI 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(52, 'Fire Protection and Arson Investigation', 'CDI 6', '3', 'BSCRIM', '2nd', '3rd Year'),
(53, 'Internship (On-the-Job-Training)', 'Criminology Pract 1', '3', 'BSCRIM', '1st', '4th Year'),
(54, 'Dispute Resolution and Crises Incidents Management', 'Criminology 6', '3', 'BSCRIM', '1st', '4th Year'),
(55, 'Forensic Ballistics', 'Forensic 6', '3', 'BSCRIM', '1st', '4th Year'),
(56, 'Criminal Procedure and Court Testimony', 'CLJ 6', '3', 'BSCRIM', '1st', '4th Year'),
(57, 'Criminological Research 1 (Research Methods with Applied Statistics)', 'Criminology 7', '3', 'BSCRIM', '1st', '4th Year'),
(58, 'Vice and Drug Education and Control', 'CDI 7', '3', 'BSCRIM', '1st', '4th Year'),
(59, 'Internship (On-the-Job-Training 2)', 'Criminology Pract 2', '3', 'BSCRIM', '2nd', '4th Year'),
(60, 'Criminological Research 2 (Thesis Writing and Presentation)', 'Criminology 8', '3', 'BSCRIM', '2nd', '4th Year'),
(61, 'Technical English 2 (Legal Forms)', 'CDI 8', '3', 'BSCRIM', '2nd', '4th Year'),
(62, 'Introduction to Cybercrime and Environmental Laws and Protections', 'CDI 9', '3', 'BSCRIM', '2nd', '4th Year'),
(63, 'Understanding the Self', 'GE 1', '3', 'BSED', '1st', '1st Year'),
(64, 'Readings in the Phil. History', 'GE 2', '3', 'BSED', '1st', '1st Year'),
(65, 'The Contemporary World', 'GE 3', '3', 'BSED', '1st', '1st Year'),
(66, 'Mathematics in the Modern World', 'GE 4', '3', 'BSED', '1st', '1st Year'),
(67, 'History of Mathematics', 'SEMC M100', '3', 'BSED', '1st', '1st Year'),
(68, 'College & Advance Algebra', 'SEMC M101', '3', 'BSED', '1st', '1st Year'),
(69, 'Physical Education 1', 'PE 1', '3', 'BSED', '1st', '1st Year'),
(70, 'NSTP 1', 'NSTP 1', '2', 'BSED', '1st', '1st Year'),
(71, 'OLLC Culture & Ethics', 'ELEC 1', '2', 'BSED', '1st', '1st Year'),
(72, 'Art Appreciation', 'GE 5', '3', 'BSED', '2nd', '1st Year'),
(73, 'Science, Technology, & Society', 'GE 6', '3', 'BSED', '2nd', '1st Year'),
(74, 'Ethics', 'GE 7', '3', 'BSED', '2nd', '1st Year'),
(75, 'The Child & Adol. Learness & Learning Prin.', 'SEPC 1', '3', 'BSED', '2nd', '1st Year'),
(76, 'Trigonometry', 'SEMC M102', '3', 'BSED', '2nd', '1st Year'),
(77, 'Plane & Solid Geometry', 'SEMC M103', '3', 'BSED', '2nd', '1st Year'),
(78, 'Teachings in Specialized Field', 'ELECT', '3', 'BSED', '2nd', '1st Year'),
(79, 'Physical Education 2', 'PE 2', '2', 'BSED', '2nd', '1st Year'),
(80, 'NSTP 2', 'NSTP 2', '3', 'BSED', '2nd', '1st Year'),
(81, 'OLLC Culture & Ethics 2', 'ELEC 2', '2', 'BSED', '2nd', '1st Year'),
(82, 'Purposive Communication', 'GE 8', '3', 'BSED', '1st', '2nd Year'),
(83, 'Rizal Works & Writings', 'GE 9 RIZAL', '3', 'BSED', '1st', '2nd Year'),
(84, 'Structure of English', 'GE 10', '3', 'BSED', '1st', '2nd Year'),
(85, 'The Teaching Profession', 'SEPC 2', '3', 'BSED', '1st', '2nd Year'),
(86, 'Elementary Statistics and Prob.', 'SEMC M105', '3', 'BSED', '1st', '2nd Year'),
(87, 'Calculus 1 (W/ Analytic Geometry)', 'SEMC M106', '4', 'BSED', '1st', '2nd Year'),
(88, 'Logic and Set Theory', 'SEMC M104', '3', 'BSED', '1st', '2nd Year'),
(89, 'PE 3', 'PE 3', '2', 'BSED', '1st', '2nd Year'),
(90, 'Calculus II', 'SEMC M107', '4', 'BSED', '2nd', '2nd Year'),
(91, 'Modern Geometry', 'SEMC M109', '3', 'BSED', '2nd', '2nd Year'),
(92, 'Mathematics of Investment', 'SEMC M110', '3', 'BSED', '2nd', '2nd Year'),
(93, 'Number Theory', 'SEMC M111', '3', 'BSED', '2nd', '2nd Year'),
(94, 'Pananaliksik sa Filipino', 'GE 11', '3', 'BSED', '2nd', '2nd Year'),
(95, 'The Teacher & The Community, School Culture & Organizational Leadership', 'SEPC 3', '3', 'BSED', '2nd', '2nd Year'),
(96, 'Foundation of Special & Inclusive Educ.', 'SEPC 4', '3', 'BSED', '2nd', '2nd Year'),
(97, 'PE 4', 'PE 4', '2', 'BSED', '2nd', '2nd Year'),
(98, 'Calculus III', 'SEMC M108', '4', 'BSED', '1st', '3rd Year'),
(99, 'Linear Algebra', 'SEMC M112', '3', 'BSED', '1st', '3rd Year'),
(100, 'Advanced Statistics', 'SEMC M113', '3', 'BSED', '1st', '3rd Year'),
(101, 'Malikhaing Pagsulat', 'GE 12', '3', 'BSED', '1st', '3rd Year'),
(102, 'Abstract Algebra', 'SEMC 114', '3', 'BSED', '1st', '3rd Year'),
(103, 'Facilitating Learner Centered Teaching', 'SEPC 5', '3', 'BSED', '1st', '3rd Year'),
(104, 'Assessment in Learning 1', 'SEPC 6', '3', 'BSED', '1st', '3rd Year'),
(105, 'Technology for Teaching and Learning 1', 'SEPC 7', '3', 'BSED', '1st', '3rd Year'),
(106, 'Problem Solving Mathematical Investigations & Modeling ', 'SEMC 115', '3', 'BSED', '2nd', '3rd Year'),
(107, 'Prin. & Stat. of Teaching Math', 'SEMC 116', '3', 'BSED', '2nd', '3rd Year'),
(108, 'Tech. for Teaching & Learning 2', 'SEMC 117', '3', 'BSED', '2nd', '3rd Year'),
(109, 'Research in Mathematics', 'SEMC 118', '3', 'BSED', '2nd', '3rd Year'),
(110, 'Assessment & Eval. In Math', 'SEMC 119', '3', 'BSED', '2nd', '3rd Year'),
(111, 'Assessment in Learning 2', 'SPEC 8', '3', 'BSED', '2nd', '3rd Year'),
(112, 'The Teacher & School Curriculum', 'SPEC 9', '3', 'BSED', '2nd', '3rd Year'),
(113, 'Bldg. & Enhancing New Literacies Across the Curriculum', 'SPEC 10', '3', 'BSED', '2nd', '3rd Year'),
(114, 'Field Study 1-3', 'SPEC 11', '3', 'BSED', '1st', '4th Year'),
(115, 'Field Study 4-6', 'SPEC 12', '3', 'BSED', '1st', '4th Year'),
(116, 'Teaching Internship', 'SPEC 13', '6', 'BSED', '2nd', '4th Year'),
(117, 'Understanding the Self', 'GE 1', '3', 'BSHM', '1st', '1st Year'),
(118, 'Readings in Philippine History', 'GE 2', '3', 'BSHM', '1st', '1st Year'),
(119, 'Mathematics in the Modern World', 'GE 3', '3', 'BSHM', '1st', '1st Year'),
(120, 'Macro Perspective in Tourism & Hospitality', 'THC 1', '3', 'BSHM', '1st', '1st Year'),
(121, 'Risk Mgmt. as Applied to Safety, Security & Sanitation', 'THC 2', '3', 'BSHM', '1st', '1st Year'),
(122, 'Physical Fitness and Gymnastics', 'PE 1', '2', 'BSHM', '1st', '1st Year'),
(123, 'NSTP 1', 'NSTP 1', '3', 'BSHM', '1st', '1st Year'),
(124, 'OLLC Culture and Ethics', 'ELEC 1', '2', 'BSHM', '1st', '1st Year'),
(125, 'Quality Service Management in Tourism & Hospitality', 'THC 3', '3', 'BSHM', '2nd', '1st Year'),
(126, 'Phil. Cul & Tourism & Geography', 'THC 4', '3', 'BSHM', '2nd', '1st Year'),
(127, 'Micro Perspective in Tourism & Hospitality', 'THC 5', '3', 'BSHM', '2nd', '1st Year'),
(128, 'Kitchen Essen. & Basic Food Prep Hospitality', 'HPC 1', '3', 'BSHM', '2nd', '1st Year'),
(129, 'Fundamentals in Lodging Operations', 'HPC 2', '3', 'BSHM', '2nd', '1st Year'),
(130, 'Physical Fitness and Gymnastics', 'PE 2', '2', 'BSHM', '2nd', '1st Year'),
(131, 'NSTP 2', 'NSTP 2', '3', 'BSHM', '2nd', '1st Year'),
(132, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 'BSHM', '2nd', '1st Year'),
(133, 'Purposive Communication', 'GE 4', '3', 'BSHM', '1st', '2nd Year'),
(134, 'Science, Tech & Society', 'GE 5', '3', 'BSHM', '1st', '2nd Year'),
(135, 'Applied Bus. Tools & Tech (PMS) w/ Lab', 'HPC 3', '3', 'BSHM', '1st', '2nd Year'),
(136, 'Food Styling and Design', 'HMPE 1', '3', 'BSHM', '1st', '2nd Year'),
(137, 'Supply Chain Mgmt. in Hosp. Industry', 'HPC 4', '3', 'BSHM', '1st', '2nd Year'),
(138, 'Asian Cuisine', 'HMPE 2', '3', 'BSHM', '1st', '2nd Year'),
(139, 'Individua/Dual Sports & Games', 'PE 3', '2', 'BSHM', '1st', '2nd Year'),
(140, 'Ethics', 'GE 6', '3', 'BSHM', '2nd', '2nd Year'),
(141, 'Fundamentals in Food Service Opr', 'HPC 5', '3', 'BSHM', '2nd', '2nd Year'),
(142, 'Tourism & Hospitality Marketing', 'THC 6', '3', 'BSHM', '2nd', '2nd Year'),
(143, 'Garde Manger', 'HMPE 3', '3', 'BSHM', '2nd', '2nd Year'),
(144, 'Sining ng Komunikasyon', 'GE Elect 3', '3', 'BSHM', '2nd', '2nd Year'),
(145, 'Bread & Pastry', 'HMPE 4', '3', 'BSHM', '2nd', '2nd Year'),
(146, 'Team Sports & Games', 'PE 4', '2', 'BSHM', '2nd', '2nd Year'),
(147, 'Panitikang Filipino', 'GE Elect 2', '3', 'BSHM', '1st', '3rd Year'),
(148, 'Classical French World', 'HMPE 5', '3', 'BSHM', '1st', '3rd Year'),
(149, 'The Contemporary World', 'GE 7', '3', 'BSHM', '1st', '3rd Year'),
(150, 'Bar & Beverage Management', 'HMPE 6', '3', 'BSHM', '1st', '3rd Year'),
(151, 'Ergonomics & Facilities Planning for the Hospitality Industry', 'HPC 6', '3', 'BSHM', '1st', '3rd Year'),
(152, 'Gastronomy (Food & Culture)', 'HMPE 7', '3', 'BSHM', '1st', '3rd Year'),
(153, 'Foreign Language 1', 'HPC 7', '3', 'BSHM', '1st', '3rd Year'),
(154, 'Arts Appreciation', 'GE 8', '3', 'BSHM', '2nd', '3rd Year'),
(155, 'Foreign Language 2', 'HPC 8', '3', 'BSHM', '2nd', '3rd Year'),
(156, 'Multi Cultural Diversity in Workplace for Tourism Professional', 'THC 7', '3', 'BSHM', '2nd', '3rd Year'),
(157, 'Entrepreneurship in Tourism Hosp.', 'THC 8', '3', 'BSHM', '2nd', '3rd Year'),
(158, 'Catering Management', 'HMPE 7', '3', 'BSHM', '2nd', '3rd Year'),
(159, 'Operation Management', 'BME 1', '3', 'BSHM', '2nd', '3rd Year'),
(160, 'Life & Works of Rizal', 'GE 9', '3', 'BSHM', '2nd', '3rd Year'),
(161, 'Legal Aspects in Tourism & Hosp', 'THC 9', '3', 'BSHM', '1st', '4th Year'),
(162, 'Research in Hospitality 1', 'HPC 9', '3', 'BSHM', '1st', '4th Year'),
(163, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 'BSHM', '1st', '4th Year'),
(164, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 'BSHM', '1st', '4th Year'),
(165, 'Philippine Popular Culture', 'GE Elect 3', '3', 'BSHM', '1st', '4th Year'),
(166, 'Professional Devt& Applied Ethics', 'THC 10', '3', 'BSHM', '1st', '4th Year'),
(167, 'Strategic Mgmt& Total Quality Mgmt.', 'BME 2', '3', 'BSHM', '1st', '4th Year'),
(168, 'Food & Beverage Operations', 'HMPE 8', '3', 'BSHM', '1st', '4th Year'),
(169, 'Research in Hospitality 2', 'HPC 11', '3', 'BSHM', '2nd', '4th Year'),
(170, 'On-The-Job Training- Hotel/Restaurant Local/International (600 hours)', 'OJT', '6', 'BSHM', '2nd', '4th Year'),
(171, 'Understanding the Self', 'GE 1', '3', 'BSIT', '1st', '1st Year'),
(172, 'Readings in Philippine History', 'GE 2', '3', 'BSIT', '1st', '1st Year'),
(173, 'The Contemporary World', 'GE 3', '3', 'BSIT', '1st', '1st Year'),
(174, 'Mathematics in the Modern World', 'GE 4', '3', 'BSIT', '1st', '1st Year'),
(175, 'Introduction to Computing', 'IT Comp 1', '3', 'BSIT', '1st', '1st Year'),
(176, 'Physical Fitness & Gymnastics', 'PE 1', '2', 'BSIT', '1st', '1st Year'),
(177, 'NSTP 1', 'NSTP 1', '3', 'BSIT', '1st', '1st Year'),
(178, 'OLLC Culture & Ethics', 'ELEC 1', '3', 'BSIT', '1st', '1st Year'),
(179, 'Purposive Communications', 'GE 5', '3', 'BSIT', '2nd', '1st Year'),
(180, 'Art Appreciation', 'GE 6', '3', 'BSIT', '2nd', '1st Year'),
(181, 'Science, Technology, and Society', 'GE 7', '3', 'BSIT', '2nd', '1st Year'),
(182, 'Ethics', 'GE 8', '3', 'BSIT', '2nd', '1st Year'),
(183, 'Computer Programming 1', 'IT Prog 1', '3', 'BSIT', '2nd', '1st Year'),
(184, 'Rhythmic Activities', 'PE 2', '2', 'BSIT', '2nd', '1st Year'),
(185, 'NSTP 2', 'NSTP 2', '3', 'BSIT', '2nd', '1st Year'),
(186, 'OLLC Culture & Ethics', 'ELEC 2', '2', 'BSIT', '2nd', '1st Year'),
(1, 'GE 1', 'Understanding the Self	', '3', 'BSCRIM', '1st', '1st Year'),
(2, 'Reading in Philippine History', 'GE 2', '3', 'BSCRIM', '1st', '1st Year'),
(3, 'The Contemporary World', 'GE 3', '3', 'BSCRIM', '1st', '1st Year'),
(4, 'Mathematics in the Modern World', 'GE 4', '3', 'BSCRIM', '1st', '1st Year'),
(5, 'Intro to Criminology', 'Crim. 1', '3', 'BSCRIM', '1st', '1st Year'),
(6, 'Sining ng Komunikasyon', 'EC 1', '3', 'BSCRIM', '1st', '1st Year'),
(7, 'Fundamental of Martial Arts	', 'PE 1', '2', 'BSCRIM', '1st', '1st Year'),
(8, 'NSTP 1', 'NSTP 1', '3', 'BSCRIM', '1st', '1st Year'),
(9, 'OLLC Culture and Ethics 1', 'ELEC 1	', '2', 'BSCRIM', '1st', '1st Year'),
(10, 'Purposive Communication', 'GE 5', '3', 'BSCRIM', '2nd', '1st Year'),
(11, 'Science, Technology, and Society', 'GE 7', '3', 'BSCRIM', '2nd', '1st Year'),
(12, 'Art Appreciation', 'GEN 6', '3', 'BSCRIM', '2nd', '1st Year'),
(13, 'Science, Technology, and Society', 'GE 7', '3', 'BSCRIM', '2nd', '1st Year'),
(14, 'Ethics', 'GE 8', '3', 'BSCRIM', '2nd', '1st Year'),
(15, 'Intro to Philippine Criminal Justice System', 'CLJ 1', '3', 'BSCRIM', '2nd', '1st Year'),
(16, 'Fundamentals of Investigation and Intelligence 	', 'CDI 1', '4', 'BSCRIM', '2nd', '1st Year'),
(17, 'Arnis and Disarming Techniques', 'PE 2', '2', 'BSCRIM', '2nd', '1st Year'),
(18, 'NSTP 2', 'NSTP 2', '3', 'BSCRIM', '2nd', '1st Year'),
(19, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 'BSCRIM', '2nd', '1st Year'),
(20, 'Theories of Crime Causation', 'Criminology 2', '3', 'BSCRIM', '1st', '2nd Year'),
(21, 'Philippine Literature', 'EC 3', '3', 'BSCRIM', '1st', '2nd Year'),
(22, 'Human Rights Education', 'CLJ 2', '3', 'BSCRIM', '1st', '2nd Year'),
(23, 'First Aid and Water Survival', 'PE 3', '2', 'BSCRIM', '1st', '2nd Year'),
(24, 'Institutional Corrections', 'CA 1', '3', 'BSCRIM', '1st', '2nd Year'),
(25, 'Forensic Photography', 'Forensic 1', '3', 'BSCRIM', '1st', '2nd Year'),
(26, 'Human Rights Education', 'CLJ 2', '3', 'BSCRIM', '1st', '2nd Year'),
(27, 'First Aid and Water Survival', 'PE 3', '2', 'BSCRIM', '1st', '2nd Year'),
(28, 'Institutional Corrections', 'CA 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(29, 'Forensic Photography', 'Forensic 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(30, 'Character Formation, Nationalism & Patrionism', 'CFLM 1', '3', 'BSCRIM', '2nd', '2nd Year'),
(31, 'Specialized Crime Investigation I w/ Legal Medicine', 'CDI 2', '3', 'BSCRIM', '2nd', '2nd Year'),
(32, 'Personal Identification Techniques', 'Forensic 2', '3', 'BSCRIM', '2nd', '2nd Year'),
(33, 'General Chemistry (Organic)', 'AdGE', '3', 'BSCRIM', '2nd', '2nd Year'),
(34, 'Human Behavior & Victomology ', 'Criminology 3', '3', 'BSCRIM', '2nd', '2nd Year'),
(35, 'Introduction to Industrial Security Concepts', 'LEA 3', '3', 'BSCRIM', '2nd', '2nd Year'),
(36, 'Marksmanship & Combat Shooting', 'PE 4', '2', 'BSCRIM', '2nd', '2nd Year'),
(37, 'Non-Institutional Corrections', 'CA 2', '3', 'BSCRIM', '1st', '3rd Year'),
(38, 'Character Formation with Leadership, Decision Making, Mngt. and Amin.', 'CFLM 2', '3', 'BSCRIM', '1st', '3rd Year'),
(39, 'Specialized Crime Investigation 2', 'CDI 3', '3', 'BSCRIM', '1st', '3rd Year'),
(40, 'Forensic Chemistry and Toxicology', 'Forensic 3', '5', 'BSCRIM', '1st', '3rd Year'),
(41, 'Criminal Law (Book 1)', 'CLJ 3', '3', 'BSCRIM', '1st', '3rd Year'),
(42, 'Law Enforcement Operations & Planning with Crime Mapping', 'LEA 4', '3', 'BSCRIM', '1st', '3rd Year'),
(43, 'Traffic Management and Accident Investigation with Driving', 'CDI 4', '3', 'BSCRIM', '1st', '3rd Year'),
(44, 'Professional Conduct and Ethical Standards', 'Criminology 4', '3', 'BSCRIM', '1st', '3rd Year'),
(45, 'Therapeutic Modalities', 'CA 3', '2', 'BSCRIM', '2nd', '3rd Year'),
(46, 'Criminal Law (Book 2)', 'CLJ 4', '4', 'BSCRIM', '2nd', '3rd Year'),
(47, 'Questioned Documents Examination', 'Forensic 4', '3', 'BSCRIM', '2nd', '3rd Year'),
(48, 'Juvenile Delinquency & Juvenile Justice System ', 'Criminology 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(49, 'Lie Detection Techniques', 'Forensic 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(50, 'Evidence', 'CLJ 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(51, 'Technical Englis 1 (Technical Report Writing)', 'CDI 5', '3', 'BSCRIM', '2nd', '3rd Year'),
(52, 'Fire Protection and Arson Investigation', 'CDI 6', '3', 'BSCRIM', '2nd', '3rd Year'),
(53, 'Internship (On-the-Job-Training)', 'Criminology Pract 1', '3', 'BSCRIM', '1st', '4th Year'),
(54, 'Dispute Resolution and Crises Incidents Management', 'Criminology 6', '3', 'BSCRIM', '1st', '4th Year'),
(55, 'Forensic Ballistics', 'Forensic 6', '3', 'BSCRIM', '1st', '4th Year'),
(56, 'Criminal Procedure and Court Testimony', 'CLJ 6', '3', 'BSCRIM', '1st', '4th Year'),
(57, 'Criminological Research 1 (Research Methods with Applied Statistics)', 'Criminology 7', '3', 'BSCRIM', '1st', '4th Year'),
(58, 'Vice and Drug Education and Control', 'CDI 7', '3', 'BSCRIM', '1st', '4th Year'),
(59, 'Internship (On-the-Job-Training 2)', 'Criminology Pract 2', '3', 'BSCRIM', '2nd', '4th Year'),
(60, 'Criminological Research 2 (Thesis Writing and Presentation)', 'Criminology 8', '3', 'BSCRIM', '2nd', '4th Year'),
(61, 'Technical English 2 (Legal Forms)', 'CDI 8', '3', 'BSCRIM', '2nd', '4th Year'),
(62, 'Introduction to Cybercrime and Environmental Laws and Protections', 'CDI 9', '3', 'BSCRIM', '2nd', '4th Year'),
(63, 'Understanding the Self', 'GE 1', '3', 'BSED', '1st', '1st Year'),
(64, 'Readings in the Phil. History', 'GE 2', '3', 'BSED', '1st', '1st Year'),
(65, 'The Contemporary World', 'GE 3', '3', 'BSED', '1st', '1st Year'),
(66, 'Mathematics in the Modern World', 'GE 4', '3', 'BSED', '1st', '1st Year'),
(67, 'History of Mathematics', 'SEMC M100', '3', 'BSED', '1st', '1st Year'),
(68, 'College & Advance Algebra', 'SEMC M101', '3', 'BSED', '1st', '1st Year'),
(69, 'Physical Education 1', 'PE 1', '3', 'BSED', '1st', '1st Year'),
(70, 'NSTP 1', 'NSTP 1', '2', 'BSED', '1st', '1st Year'),
(71, 'OLLC Culture & Ethics', 'ELEC 1', '2', 'BSED', '1st', '1st Year'),
(72, 'Art Appreciation', 'GE 5', '3', 'BSED', '2nd', '1st Year'),
(73, 'Science, Technology, & Society', 'GE 6', '3', 'BSED', '2nd', '1st Year'),
(74, 'Ethics', 'GE 7', '3', 'BSED', '2nd', '1st Year'),
(75, 'The Child & Adol. Learness & Learning Prin.', 'SEPC 1', '3', 'BSED', '2nd', '1st Year'),
(76, 'Trigonometry', 'SEMC M102', '3', 'BSED', '2nd', '1st Year'),
(77, 'Plane & Solid Geometry', 'SEMC M103', '3', 'BSED', '2nd', '1st Year'),
(78, 'Teachings in Specialized Field', 'ELECT', '3', 'BSED', '2nd', '1st Year'),
(79, 'Physical Education 2', 'PE 2', '2', 'BSED', '2nd', '1st Year'),
(80, 'NSTP 2', 'NSTP 2', '3', 'BSED', '2nd', '1st Year'),
(81, 'OLLC Culture & Ethics 2', 'ELEC 2', '2', 'BSED', '2nd', '1st Year'),
(82, 'Purposive Communication', 'GE 8', '3', 'BSED', '1st', '2nd Year'),
(83, 'Rizal Works & Writings', 'GE 9 RIZAL', '3', 'BSED', '1st', '2nd Year'),
(84, 'Structure of English', 'GE 10', '3', 'BSED', '1st', '2nd Year'),
(85, 'The Teaching Profession', 'SEPC 2', '3', 'BSED', '1st', '2nd Year'),
(86, 'Elementary Statistics and Prob.', 'SEMC M105', '3', 'BSED', '1st', '2nd Year'),
(87, 'Calculus 1 (W/ Analytic Geometry)', 'SEMC M106', '4', 'BSED', '1st', '2nd Year'),
(88, 'Logic and Set Theory', 'SEMC M104', '3', 'BSED', '1st', '2nd Year'),
(89, 'PE 3', 'PE 3', '2', 'BSED', '1st', '2nd Year'),
(90, 'Calculus II', 'SEMC M107', '4', 'BSED', '2nd', '2nd Year'),
(91, 'Modern Geometry', 'SEMC M109', '3', 'BSED', '2nd', '2nd Year'),
(92, 'Mathematics of Investment', 'SEMC M110', '3', 'BSED', '2nd', '2nd Year'),
(93, 'Number Theory', 'SEMC M111', '3', 'BSED', '2nd', '2nd Year'),
(94, 'Pananaliksik sa Filipino', 'GE 11', '3', 'BSED', '2nd', '2nd Year'),
(95, 'The Teacher & The Community, School Culture & Organizational Leadership', 'SEPC 3', '3', 'BSED', '2nd', '2nd Year'),
(96, 'Foundation of Special & Inclusive Educ.', 'SEPC 4', '3', 'BSED', '2nd', '2nd Year'),
(97, 'PE 4', 'PE 4', '2', 'BSED', '2nd', '2nd Year'),
(98, 'Calculus III', 'SEMC M108', '4', 'BSED', '1st', '3rd Year'),
(99, 'Linear Algebra', 'SEMC M112', '3', 'BSED', '1st', '3rd Year'),
(100, 'Advanced Statistics', 'SEMC M113', '3', 'BSED', '1st', '3rd Year'),
(101, 'Malikhaing Pagsulat', 'GE 12', '3', 'BSED', '1st', '3rd Year'),
(102, 'Abstract Algebra', 'SEMC 114', '3', 'BSED', '1st', '3rd Year'),
(103, 'Facilitating Learner Centered Teaching', 'SEPC 5', '3', 'BSED', '1st', '3rd Year'),
(104, 'Assessment in Learning 1', 'SEPC 6', '3', 'BSED', '1st', '3rd Year'),
(105, 'Technology for Teaching and Learning 1', 'SEPC 7', '3', 'BSED', '1st', '3rd Year'),
(106, 'Problem Solving Mathematical Investigations & Modeling ', 'SEMC 115', '3', 'BSED', '2nd', '3rd Year'),
(107, 'Prin. & Stat. of Teaching Math', 'SEMC 116', '3', 'BSED', '2nd', '3rd Year'),
(108, 'Tech. for Teaching & Learning 2', 'SEMC 117', '3', 'BSED', '2nd', '3rd Year'),
(109, 'Research in Mathematics', 'SEMC 118', '3', 'BSED', '2nd', '3rd Year'),
(110, 'Assessment & Eval. In Math', 'SEMC 119', '3', 'BSED', '2nd', '3rd Year'),
(111, 'Assessment in Learning 2', 'SPEC 8', '3', 'BSED', '2nd', '3rd Year'),
(112, 'The Teacher & School Curriculum', 'SPEC 9', '3', 'BSED', '2nd', '3rd Year'),
(113, 'Bldg. & Enhancing New Literacies Across the Curriculum', 'SPEC 10', '3', 'BSED', '2nd', '3rd Year'),
(114, 'Field Study 1-3', 'SPEC 11', '3', 'BSED', '1st', '4th Year'),
(115, 'Field Study 4-6', 'SPEC 12', '3', 'BSED', '1st', '4th Year'),
(116, 'Teaching Internship', 'SPEC 13', '6', 'BSED', '2nd', '4th Year'),
(117, 'Understanding the Self', 'GE 1', '3', 'BSHM', '1st', '1st Year'),
(118, 'Readings in Philippine History', 'GE 2', '3', 'BSHM', '1st', '1st Year'),
(119, 'Mathematics in the Modern World', 'GE 3', '3', 'BSHM', '1st', '1st Year'),
(120, 'Macro Perspective in Tourism & Hospitality', 'THC 1', '3', 'BSHM', '1st', '1st Year'),
(121, 'Risk Mgmt. as Applied to Safety, Security & Sanitation', 'THC 2', '3', 'BSHM', '1st', '1st Year'),
(122, 'Physical Fitness and Gymnastics', 'PE 1', '2', 'BSHM', '1st', '1st Year'),
(123, 'NSTP 1', 'NSTP 1', '3', 'BSHM', '1st', '1st Year'),
(124, 'OLLC Culture and Ethics', 'ELEC 1', '2', 'BSHM', '1st', '1st Year'),
(125, 'Quality Service Management in Tourism & Hospitality', 'THC 3', '3', 'BSHM', '2nd', '1st Year'),
(126, 'Phil. Cul & Tourism & Geography', 'THC 4', '3', 'BSHM', '2nd', '1st Year'),
(127, 'Micro Perspective in Tourism & Hospitality', 'THC 5', '3', 'BSHM', '2nd', '1st Year'),
(128, 'Kitchen Essen. & Basic Food Prep Hospitality', 'HPC 1', '3', 'BSHM', '2nd', '1st Year'),
(129, 'Fundamentals in Lodging Operations', 'HPC 2', '3', 'BSHM', '2nd', '1st Year'),
(130, 'Physical Fitness and Gymnastics', 'PE 2', '2', 'BSHM', '2nd', '1st Year'),
(131, 'NSTP 2', 'NSTP 2', '3', 'BSHM', '2nd', '1st Year'),
(132, 'OLLC Culture and Ethics 2', 'ELEC 2', '2', 'BSHM', '2nd', '1st Year'),
(133, 'Purposive Communication', 'GE 4', '3', 'BSHM', '1st', '2nd Year'),
(134, 'Science, Tech & Society', 'GE 5', '3', 'BSHM', '1st', '2nd Year'),
(135, 'Applied Bus. Tools & Tech (PMS) w/ Lab', 'HPC 3', '3', 'BSHM', '1st', '2nd Year'),
(136, 'Food Styling and Design', 'HMPE 1', '3', 'BSHM', '1st', '2nd Year'),
(137, 'Supply Chain Mgmt. in Hosp. Industry', 'HPC 4', '3', 'BSHM', '1st', '2nd Year'),
(138, 'Asian Cuisine', 'HMPE 2', '3', 'BSHM', '1st', '2nd Year'),
(139, 'Individua/Dual Sports & Games', 'PE 3', '2', 'BSHM', '1st', '2nd Year'),
(140, 'Ethics', 'GE 6', '3', 'BSHM', '2nd', '2nd Year'),
(141, 'Fundamentals in Food Service Opr', 'HPC 5', '3', 'BSHM', '2nd', '2nd Year'),
(142, 'Tourism & Hospitality Marketing', 'THC 6', '3', 'BSHM', '2nd', '2nd Year'),
(143, 'Garde Manger', 'HMPE 3', '3', 'BSHM', '2nd', '2nd Year'),
(144, 'Sining ng Komunikasyon', 'GE Elect 3', '3', 'BSHM', '2nd', '2nd Year'),
(145, 'Bread & Pastry', 'HMPE 4', '3', 'BSHM', '2nd', '2nd Year'),
(146, 'Team Sports & Games', 'PE 4', '2', 'BSHM', '2nd', '2nd Year'),
(147, 'Panitikang Filipino', 'GE Elect 2', '3', 'BSHM', '1st', '3rd Year'),
(148, 'Classical French World', 'HMPE 5', '3', 'BSHM', '1st', '3rd Year'),
(149, 'The Contemporary World', 'GE 7', '3', 'BSHM', '1st', '3rd Year'),
(150, 'Bar & Beverage Management', 'HMPE 6', '3', 'BSHM', '1st', '3rd Year'),
(151, 'Ergonomics & Facilities Planning for the Hospitality Industry', 'HPC 6', '3', 'BSHM', '1st', '3rd Year'),
(152, 'Gastronomy (Food & Culture)', 'HMPE 7', '3', 'BSHM', '1st', '3rd Year'),
(153, 'Foreign Language 1', 'HPC 7', '3', 'BSHM', '1st', '3rd Year'),
(154, 'Arts Appreciation', 'GE 8', '3', 'BSHM', '2nd', '3rd Year'),
(155, 'Foreign Language 2', 'HPC 8', '3', 'BSHM', '2nd', '3rd Year'),
(156, 'Multi Cultural Diversity in Workplace for Tourism Professional', 'THC 7', '3', 'BSHM', '2nd', '3rd Year'),
(157, 'Entrepreneurship in Tourism Hosp.', 'THC 8', '3', 'BSHM', '2nd', '3rd Year'),
(158, 'Catering Management', 'HMPE 7', '3', 'BSHM', '2nd', '3rd Year'),
(159, 'Operation Management', 'BME 1', '3', 'BSHM', '2nd', '3rd Year'),
(160, 'Life & Works of Rizal', 'GE 9', '3', 'BSHM', '2nd', '3rd Year'),
(161, 'Legal Aspects in Tourism & Hosp', 'THC 9', '3', 'BSHM', '1st', '4th Year'),
(162, 'Research in Hospitality 1', 'HPC 9', '3', 'BSHM', '1st', '4th Year'),
(163, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 'BSHM', '1st', '4th Year'),
(164, 'Intro to Meetings, Incentives, Conferences & Event Mgmt. (MICE)', 'HPC 10', '3', 'BSHM', '1st', '4th Year'),
(165, 'Philippine Popular Culture', 'GE Elect 3', '3', 'BSHM', '1st', '4th Year'),
(166, 'Professional Devt& Applied Ethics', 'THC 10', '3', 'BSHM', '1st', '4th Year'),
(167, 'Strategic Mgmt& Total Quality Mgmt.', 'BME 2', '3', 'BSHM', '1st', '4th Year'),
(168, 'Food & Beverage Operations', 'HMPE 8', '3', 'BSHM', '1st', '4th Year'),
(169, 'Research in Hospitality 2', 'HPC 11', '3', 'BSHM', '2nd', '4th Year'),
(170, 'On-The-Job Training- Hotel/Restaurant Local/International (600 hours)', 'OJT', '6', 'BSHM', '2nd', '4th Year'),
(171, 'Understanding the Self', 'GE 1', '3', 'BSIT', '1st', '1st Year'),
(172, 'Readings in Philippine History', 'GE 2', '3', 'BSIT', '1st', '1st Year'),
(173, 'The Contemporary World', 'GE 3', '3', 'BSIT', '1st', '1st Year'),
(174, 'Mathematics in the Modern World', 'GE 4', '3', 'BSIT', '1st', '1st Year'),
(175, 'Introduction to Computing', 'IT Comp 1', '3', 'BSIT', '1st', '1st Year'),
(176, 'Physical Fitness & Gymnastics', 'PE 1', '2', 'BSIT', '1st', '1st Year'),
(177, 'NSTP 1', 'NSTP 1', '3', 'BSIT', '1st', '1st Year'),
(178, 'OLLC Culture & Ethics', 'ELEC 1', '3', 'BSIT', '1st', '1st Year'),
(179, 'Purposive Communications', 'GE 5', '3', 'BSIT', '2nd', '1st Year'),
(180, 'Art Appreciation', 'GE 6', '3', 'BSIT', '2nd', '1st Year'),
(181, 'Science, Technology, and Society', 'GE 7', '3', 'BSIT', '2nd', '1st Year'),
(182, 'Ethics', 'GE 8', '3', 'BSIT', '2nd', '1st Year'),
(183, 'Computer Programming 1', 'IT Prog 1', '3', 'BSIT', '2nd', '1st Year'),
(184, 'Rhythmic Activities', 'PE 2', '2', 'BSIT', '2nd', '1st Year'),
(185, 'NSTP 2', 'NSTP 2', '3', 'BSIT', '2nd', '1st Year'),
(186, 'OLLC Culture & Ethics', 'ELEC 2', '2', 'BSIT', '2nd', '1st Year'),
(26, 'OLLC Culture and Ethics', 'OCE 2', '2', 'Bachelor of Science in Information Technology', '2nd', '2nd Year');

-- --------------------------------------------------------

--
-- Table structure for table `usertbl`
--

CREATE TABLE `usertbl` (
  `id` int(11) NOT NULL,
  `username` varchar(140) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL
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
-- Table structure for table `usertbl_backup`
--

CREATE TABLE `usertbl_backup` (
  `id` int(11) NOT NULL,
  `username` varchar(140) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usertbl_backup`
--

INSERT INTO `usertbl_backup` (`id`, `username`, `email`, `password`, `usertype`) VALUES
(1, 'admin', NULL, 'admin123', 'admin');

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
-- Indexes for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  ADD PRIMARY KEY (`educational_attainment_id`),
  ADD KEY `kindergarten_id` (`kindergarten_id`),
  ADD KEY `college_id` (`college_id`),
  ADD KEY `fk_elementary` (`elementary_id`),
  ADD KEY `fk_junior_high` (`junior_high_id`),
  ADD KEY `fk_senior_high` (`senior_high_id`);

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
-- Indexes for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD PRIMARY KEY (`enrollment_details_id`);

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
-- Indexes for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD PRIMARY KEY (`personal_information_id`),
  ADD KEY `baptism_id` (`baptism_id`),
  ADD KEY `confirmation_id` (`confirmation_id`);

--
-- Indexes for table `request_messages`
--
ALTER TABLE `request_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_account`
--
ALTER TABLE `school_account`
  ADD PRIMARY KEY (`school_account_id`),
  ADD KEY `student_number_id` (`student_number_id`);

--
-- Indexes for table `senior_high`
--
ALTER TABLE `senior_high`
  ADD PRIMARY KEY (`senior_high_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`students_id`),
  ADD KEY `student_number_id` (`student_number_id`);

--
-- Indexes for table `student_information`
--
ALTER TABLE `student_information`
  ADD PRIMARY KEY (`student_information_id`),
  ADD KEY `students_id` (`students_id`),
  ADD KEY `personal_information_id` (`personal_information_id`),
  ADD KEY `contact_information_id` (`contact_information_id`),
  ADD KEY `educational_attainment_id` (`educational_attainment_id`),
  ADD KEY `family_record_id` (`family_record_id`),
  ADD KEY `school_account_id` (`school_account_id`),
  ADD KEY `course_id` (`enrollment_details_id`);

--
-- Indexes for table `student_number`
--
ALTER TABLE `student_number`
  ADD PRIMARY KEY (`student_number_id`);

--
-- Indexes for table `usertbl`
--
ALTER TABLE `usertbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baptism`
--
ALTER TABLE `baptism`
  MODIFY `baptism_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `confirmation`
--
ALTER TABLE `confirmation`
  MODIFY `confirmation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `contact_information`
--
ALTER TABLE `contact_information`
  MODIFY `contact_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  MODIFY `educational_attainment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `elementary`
--
ALTER TABLE `elementary`
  MODIFY `elementary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  MODIFY `enrollment_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `family_record`
--
ALTER TABLE `family_record`
  MODIFY `family_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `father`
--
ALTER TABLE `father`
  MODIFY `father_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `historytbl`
--
ALTER TABLE `historytbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `junior_high`
--
ALTER TABLE `junior_high`
  MODIFY `junior_high_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kindergarten`
--
ALTER TABLE `kindergarten`
  MODIFY `kindergarten_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `mother`
--
ALTER TABLE `mother`
  MODIFY `mother_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `personal_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `request_messages`
--
ALTER TABLE `request_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_account`
--
ALTER TABLE `school_account`
  MODIFY `school_account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `senior_high`
--
ALTER TABLE `senior_high`
  MODIFY `senior_high_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `students_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `student_information`
--
ALTER TABLE `student_information`
  MODIFY `student_information_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `student_number`
--
ALTER TABLE `student_number`
  MODIFY `student_number_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  ADD CONSTRAINT `educational_attainment_ibfk_1` FOREIGN KEY (`kindergarten_id`) REFERENCES `kindergarten` (`kindergarten_id`),
  ADD CONSTRAINT `educational_attainment_ibfk_4` FOREIGN KEY (`college_id`) REFERENCES `college` (`college_id`),
  ADD CONSTRAINT `fk_elementary` FOREIGN KEY (`elementary_id`) REFERENCES `elementary` (`elementary_id`),
  ADD CONSTRAINT `fk_junior_high` FOREIGN KEY (`junior_high_id`) REFERENCES `junior_high` (`junior_high_id`),
  ADD CONSTRAINT `fk_senior_high` FOREIGN KEY (`senior_high_id`) REFERENCES `senior_high` (`senior_high_id`);

--
-- Constraints for table `family_record`
--
ALTER TABLE `family_record`
  ADD CONSTRAINT `family_record_ibfk_1` FOREIGN KEY (`father_id`) REFERENCES `father` (`father_id`),
  ADD CONSTRAINT `family_record_ibfk_2` FOREIGN KEY (`mother_id`) REFERENCES `mother` (`mother_id`),
  ADD CONSTRAINT `family_record_ibfk_3` FOREIGN KEY (`emergency_contact_id`) REFERENCES `emergency_contact` (`emergency_contact_id`);

--
-- Constraints for table `personal_information`
--
ALTER TABLE `personal_information`
  ADD CONSTRAINT `personal_information_ibfk_1` FOREIGN KEY (`baptism_id`) REFERENCES `baptism` (`baptism_id`),
  ADD CONSTRAINT `personal_information_ibfk_2` FOREIGN KEY (`confirmation_id`) REFERENCES `confirmation` (`confirmation_id`);

--
-- Constraints for table `school_account`
--
ALTER TABLE `school_account`
  ADD CONSTRAINT `school_account_ibfk_1` FOREIGN KEY (`student_number_id`) REFERENCES `student_number` (`student_number_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`student_number_id`) REFERENCES `student_number` (`student_number_id`);

--
-- Constraints for table `student_information`
--
ALTER TABLE `student_information`
  ADD CONSTRAINT `student_information_ibfk_1` FOREIGN KEY (`students_id`) REFERENCES `students` (`students_id`),
  ADD CONSTRAINT `student_information_ibfk_2` FOREIGN KEY (`personal_information_id`) REFERENCES `personal_information` (`personal_information_id`),
  ADD CONSTRAINT `student_information_ibfk_3` FOREIGN KEY (`contact_information_id`) REFERENCES `contact_information` (`contact_information_id`),
  ADD CONSTRAINT `student_information_ibfk_4` FOREIGN KEY (`educational_attainment_id`) REFERENCES `educational_attainment` (`educational_attainment_id`),
  ADD CONSTRAINT `student_information_ibfk_5` FOREIGN KEY (`family_record_id`) REFERENCES `family_record` (`family_record_id`),
  ADD CONSTRAINT `student_information_ibfk_6` FOREIGN KEY (`school_account_id`) REFERENCES `school_account` (`school_account_id`),
  ADD CONSTRAINT `student_information_ibfk_7` FOREIGN KEY (`enrollment_details_id`) REFERENCES `enrollment_details` (`enrollment_details_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
