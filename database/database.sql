CREATE DATABASE student_result_system;
USE student_result_system;

CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL
);

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    course_id INT,
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL
);

CREATE TABLE exams (
    exam_id INT AUTO_INCREMENT PRIMARY KEY,
    exam_name VARCHAR(100),
    exam_date DATE
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','student') NOT NULL,
    student_id INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    exam_id INT,
    marks DECIMAL(5,2),
    grade VARCHAR(2),

    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id),
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
);

CREATE INDEX idx_student ON results(student_id);
CREATE INDEX idx_subject ON results(subject_id);

DELIMITER //

CREATE PROCEDURE GetStudentResults(IN sid INT)
BEGIN
    SELECT s.name, sub.subject_name, r.marks, r.grade
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN subjects sub ON r.subject_id = sub.subject_id
    WHERE s.student_id = sid;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetAverage(IN sid INT)
BEGIN
    SELECT AVG(marks) AS average_marks
    FROM results
    WHERE student_id = sid;
END //

DELIMITER ;


DELIMITER //

CREATE TRIGGER before_insert_result
BEFORE INSERT ON results
FOR EACH ROW
BEGIN
    IF NEW.marks >= 75 THEN
        SET NEW.grade = 'A';
    ELSEIF NEW.marks >= 65 THEN
        SET NEW.grade = 'B';
    ELSEIF NEW.marks >= 50 THEN
        SET NEW.grade = 'C';
    ELSE
        SET NEW.grade = 'F';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER before_update_result
BEFORE UPDATE ON results
FOR EACH ROW
BEGIN
    IF NEW.marks >= 75 THEN
        SET NEW.grade = 'A';
    ELSEIF NEW.marks >= 50 THEN
        SET NEW.grade = 'C';
    ELSE
        SET NEW.grade = 'F';
    END IF;
END //

DELIMITER ;


CREATE VIEW student_summary AS
SELECT student_id, AVG(marks) AS avg_marks
FROM results
GROUP BY student_id;

CREATE VIEW top_students AS
SELECT s.name, AVG(r.marks) AS avg_marks
FROM results r
JOIN students s ON r.student_id = s.student_id
GROUP BY r.student_id
ORDER BY avg_marks DESC;