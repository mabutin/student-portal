CREATE DATABASE IF NOT EXISTS student_portall;


CREATE TABLE student_number (
    student_number_id INT(11) PRIMARY KEY,
    student_number INT(20)
);

CREATE TABLE baptism (
    baptism_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    place VARCHAR(255),
    date VARCHAR(255)
);

CREATE TABLE confirmation (
    confirmation_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    place VARCHAR(255),
    date VARCHAR(255)
);

CREATE TABLE personal_information (
    personal_information_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    gender ENUM('male', 'female'),
    birthday DATE,
    age INT(3),
    birth_place VARCHAR(255),
    citizenship VARCHAR(255),
    height FLOAT(11),
    weight FLOAT(11),
    baptism_id INT(11),
    confirmation_id INT(11),

    FOREIGN KEY (baptism_id) REFERENCES baptism(baptism_id),
    FOREIGN KEY (confirmation_id) REFERENCES confirmation(confirmation_id)
);


CREATE TABLE kindergarten (
    kindergarten_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE elementary (
    elementary_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE junior_high (
    junior_high_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE senior_high (
    senior_high_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE college (
    college_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255)
);

CREATE TABLE educational_attainment (
    educational_attainment_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kindergarten_id INT(11),
    elementary_id INT(11),
    junior_high_id INT(11),
    senior_high_id INT(11),
    college_id INT(11),

    FOREIGN KEY (kindergarten_id) REFERENCES kindergarten(kindergarten_id),
    FOREIGN KEY (elementary_id) REFERENCES elementary(elementary_id),
    FOREIGN KEY (junior_high_id) REFERENCES junior_high(junior_high_id),
    FOREIGN KEY (senior_high_id) REFERENCES senior_high(senior_high_id),
    FOREIGN KEY (college_id) REFERENCES college(college_id)
);

CREATE TABLE father (
    father_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    address VARCHAR(255),
    company VARCHAR(255),
    company_address VARCHAR(255),
    mobile_number VARCHAR(255)
);

CREATE TABLE mother (
    mother_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    address VARCHAR(255),
    company VARCHAR(255),
    company_address VARCHAR(255),
    mobile_number VARCHAR(255)
);

CREATE TABLE emergency_contact (
    emergency_contact_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    relationship VARCHAR(255),
    address VARCHAR(255),
    company VARCHAR(255),
    company_address VARCHAR(255),
    mobile_number VARCHAR(255)
);

CREATE TABLE family_record (
    family_record_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    father_id INT(11),
    mother_id INT(11),
    emergency_contact_id INT(11),

    FOREIGN KEY (father_id) REFERENCES father(father_id),
    FOREIGN KEY (mother_id) REFERENCES mother(mother_id),
    FOREIGN KEY (emergency_contact_id) REFERENCES emergency_contact(emergency_contact_id)
);

CREATE TABLE contact_information (
    contact_information_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255),
    city VARCHAR(255),
    mobile_number VARCHAR(20),
    email VARCHAR(255)
);

CREATE TABLE school_account (
    school_account_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_number_id INT(11),
    password VARCHAR(255),

    FOREIGN KEY (student_number_id) REFERENCES student_number(student_number_id)
);

CREATE TABLE students (
    student_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_number_id INT(11),
    surname VARCHAR(255),
    first_name VARCHAR(255),
    middle_name VARCHAR(255),
    suffix VARCHAR(255),

    FOREIGN KEY (student_number_id) REFERENCES student_number(student_number_id)
);

CREATE TABLE school_year (
    school_year_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    school_year VARCHAR(255),
    start DATE,
    end DATE
);

CREATE TABLE semester (
    semester_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    semester VARCHAR(255),
    start DATE,
    end DATE
);

CREATE TABLE course (
    course_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(255),
    course_name VARCHAR(255)
);

CREATE TABLE year_level (
    year_level_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    year_level VARCHAR(255)
);

CREATE TABLE enrollment_details (
    enrollment_details_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    school_year_id VARCHAR(255),
    course_id VARCHAR(255),
    year_level_id VARCHAR(255),
    semester_id INT(11),
    enrollment_date DATE,

    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id),
    FOREIGN KEY (year_level_id) REFERENCES year_level(year_level_id),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id)
);

CREATE TABLE student_information (
    student_information_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11),
    personal_information_id INT(11),
    contact_information_id INT(11),
    educational_attainment_id INT(11),
    family_record_id INT(11),
    school_account_id INT(11),
    enrollment_details_id INT(11),
    status VARCHAR(20),
    profile_picture BLOB,
    e_sign BLOB,

    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (personal_information_id) REFERENCES personal_information(personal_information_id),
    FOREIGN KEY (contact_information_id) REFERENCES contact_information(contact_information_id),
    FOREIGN KEY (educational_attainment_id) REFERENCES educational_attainment(educational_attainment_id),
    FOREIGN KEY (family_record_id) REFERENCES family_record(family_record_id),
    FOREIGN KEY (school_account_id) REFERENCES school_account(school_account_id),
    FOREIGN KEY (enrollment_details_id) REFERENCES enrollment_details(enrollment_details_id)
);

CREATE TABLE examination_period (
    examination_period_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    school_year_id VARCHAR(255),
    semester_id INT(11),
    exam_name VARCHAR(255),
    start DATE,
    end DATE,

    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id)
);

CREATE TABLE subjects (
    subject_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255),
    name VARCHAR(255) UNIQUE,
    units VARCHAR(255),
    course_id VARCHAR(255),
    year_level VARCHAR(255),
    legend INT(11),
    
    FOREIGN KEY (course_id) REFERENCES course(course_id),
    FOREIGN KEY (year_level) REFERENCES year_level(year_level)
);

CREATE TABLE open_subjects (
    open_subject_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    school_year_id VARCHAR(255),
    course_id VARCHAR(255),
    subject_id INT(11),
    year_level VARCHAR(255),
    semester_id INT(11),
    isDefault BOOLEAN,

    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id),
    FOREIGN KEY (year_level) REFERENCES year_level(year_level),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id)
);

CREATE TABLE professor_details (
    professor_details_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(255),
    first_name VARCHAR(255),
    middle_name VARCHAR(255),
    suffix VARCHAR(255)
);

CREATE TABLE enrolled_subjects (
    enrolled_subject_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11),
    subject_name VARCHAR(255),
    prelim VARCHAR(255),
    midterm VARCHAR(255),
    finals VARCHAR(255),
    total VARCHAR(255),
    school_year_id VARCHAR(255),
    year_level VARCHAR(255),
    semester_id INT(11),
    professor_details_id INT(11),
    isTaken BOOLEAN,

    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (subject_name) REFERENCES subjects(name),
    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (year_level) REFERENCES year_level(year_level),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id),
    FOREIGN KEY (professor_details_id) REFERENCES professor_details(professor_details_id)
);

CREATE TABLE handled_subjects (
    handled_subjects INT(11) AUTO_INCREMENT PRIMARY KEY,
    subject_id INT(11),
    school_year_id VARCHAR(255),
    year_level VARCHAR(255),
    semester_id INT(11),

    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (year_level) REFERENCES year_level(year_level),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)

);

CREATE TABLE professor(
    professor_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    professor_details_id INT(11),
    handled_subjects_id INT(11),

    FOREIGN KEY (professor_details_id) REFERENCES professor_details(professor_details_id),
    FOREIGN KEY (handled_subjects_id) REFERENCES handled_subjects(handled_subjects_id)
);

CREATE TABLE gwa (
    gwa_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11),
    gwa VARCHAR(255),
    school_year_id VARCHAR(255),
    year_level VARCHAR(255),
    semester_id INT(11),

    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id),
    FOREIGN KEY (year_level) REFERENCES year_level(year_level)
);

CREATE TABLE college_calendar (
    college_calendar_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    school_year_id INT(11),
    semester_id INT(11),
    graduation_date DATE,

    FOREIGN KEY (school_year_id) REFERENCES school_year(school_year_id),
    FOREIGN KEY (semester_id) REFERENCES semester(semester_id)
);

CREATE TABLE record (
    record_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11),
    so_number VARCHAR(255),

    FOREIGN KEY (student_id) REFERENCES students(student_id)

);

CREATE TABLE historytbl (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255),
    username VARCHAR(255),
    timestamp timestamp
);

CREATE TABLE notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255),
    datetime datetime
);

CREATE TABLE request_messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_number INT(20),
    message text,
    request_datetime datetime
);

CREATE TABLE usertbl (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    usertype VARCHAR(255)
);

COMMIT;