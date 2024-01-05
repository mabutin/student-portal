-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 11:41 AM
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
  `school_year_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `professor_details_id` int(11) DEFAULT NULL,
  `isTaken` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_details`
--

CREATE TABLE `enrollment_details` (
  `enrollment_details_id` int(11) NOT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `open_subjects`
--

CREATE TABLE `open_subjects` (
  `open_subject_id` int(11) NOT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
-- Table structure for table `school_account`
--

CREATE TABLE `school_account` (
  `school_account_id` int(11) NOT NULL,
  `student_number_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `semester` varchar(255) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `student_number`
--

CREATE TABLE `student_number` (
  `student_number_id` int(11) NOT NULL,
  `student_number` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `units` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_level_id` int(11) DEFAULT NULL,
  `legend` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE `year_level` (
  `year_level_id` int(11) NOT NULL,
  `year_level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `professor_details_id` (`professor_details_id`);

--
-- Indexes for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD PRIMARY KEY (`enrollment_details_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_id`);

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
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `year_level_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_id`);

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
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

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
  MODIFY `baptism_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `college_calendar`
--
ALTER TABLE `college_calendar`
  MODIFY `college_calendar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confirmation`
--
ALTER TABLE `confirmation`
  MODIFY `confirmation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_information`
--
ALTER TABLE `contact_information`
  MODIFY `contact_information_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `educational_attainment`
--
ALTER TABLE `educational_attainment`
  MODIFY `educational_attainment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `elementary`
--
ALTER TABLE `elementary`
  MODIFY `elementary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  MODIFY `enrolled_subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  MODIFY `enrollment_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examination_period`
--
ALTER TABLE `examination_period`
  MODIFY `examination_period_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_record`
--
ALTER TABLE `family_record`
  MODIFY `family_record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `father`
--
ALTER TABLE `father`
  MODIFY `father_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `junior_high_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kindergarten`
--
ALTER TABLE `kindergarten`
  MODIFY `kindergarten_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mother`
--
ALTER TABLE `mother`
  MODIFY `mother_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `open_subjects`
--
ALTER TABLE `open_subjects`
  MODIFY `open_subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_information`
--
ALTER TABLE `personal_information`
  MODIFY `personal_information_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `request_messages`
--
ALTER TABLE `request_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_account`
--
ALTER TABLE `school_account`
  MODIFY `school_account_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `senior_high`
--
ALTER TABLE `senior_high`
  MODIFY `senior_high_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_information`
--
ALTER TABLE `student_information`
  MODIFY `student_information_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_number`
--
ALTER TABLE `student_number`
  MODIFY `student_number_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertbl`
--
ALTER TABLE `usertbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `year_level`
--
ALTER TABLE `year_level`
  MODIFY `year_level_id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `enrolled_subjects_ibfk_3` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_4` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_5` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_6` FOREIGN KEY (`professor_details_id`) REFERENCES `professor_details` (`professor_details_id`);

--
-- Constraints for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD CONSTRAINT `enrollment_details_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `enrollment_details_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `enrollment_details_ibfk_3` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `enrollment_details_ibfk_4` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

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
  ADD CONSTRAINT `open_subjects_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `open_subjects_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `open_subjects_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `open_subjects_ibfk_4` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`),
  ADD CONSTRAINT `open_subjects_ibfk_5` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

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
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
