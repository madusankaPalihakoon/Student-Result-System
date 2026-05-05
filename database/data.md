 1. Insert Order (IMPORTANT)

You must insert in this order to avoid FK errors:

text
courses → students → subjects → exams → users → results

 2. Sample Data (Full SQL)

 Courses (5 rows)

sql
INSERT INTO courses (course_name) VALUES
('Information Technology'),
('Business Management'),
('Engineering'),
('Software Engineering'),
('Data Science');

 Students (5 rows)
sql
INSERT INTO students (name, email, course_id) VALUES
('Sanjay Madusanka', 'sanjay@gmail.com', 1),
('Nimal Perera', 'nimal@gmail.com', 2),
('Kamal Silva', 'kamal@gmail.com', 3),
('Amara Fernando', 'amara@gmail.com', 4),
('Kavindu Jayasinghe', 'kavindu@gmail.com', 5);

 Subjects (5 rows)

sql
INSERT INTO subjects (subject_name, credits) VALUES
('Database Systems', 3),
('Programming Fundamentals', 4),
('Computer Networks', 3),
('Software Engineering', 4),
('Data Structures', 3);

 Exams (5 rows)

sql
INSERT INTO exams (exam_name, exam_date) VALUES
('Mid Exam', '2026-05-01'),
('Final Exam', '2026-06-15'),
('Quiz 1', '2026-04-10'),
('Quiz 2', '2026-04-20'),
('Assignment', '2026-05-10');




 Users (5 rows)

 Passwords must be hashed (IMPORTANT for login)

sql
INSERT INTO users (username, password, role, student_id) VALUES
('admin', '$2y$10$abcdefghijklmnopqrstuv', 'admin', NULL),
('sanjay', '$2y$10$abcdefghijklmnopqrstuv', 'student', 1),
('nimal', '$2y$10$abcdefghijklmnopqrstuv', 'student', 2),
('kamal', '$2y$10$abcdefghijklmnopqrstuv', 'student', 3),
('amara', '$2y$10$abcdefghijklmnopqrstuv', 'student', 4);


Replace hash using PHP:

php
echo password_hash("123456", PASSWORD_DEFAULT);




 Results (5+ rows)

Your trigger will auto-generate grade 

sql
INSERT INTO results (student_id, subject_id, exam_id, marks) VALUES
(1, 1, 1, 85),
(1, 2, 2, 78),
(2, 1, 1, 65),
(3, 3, 2, 45),
(4, 4, 1, 90),
(5, 5, 2, 55);


 3. Verify Data (IMPORTANT for demo)

Run these:

sql
SELECT * FROM students;
SELECT * FROM subjects;
SELECT * FROM results;
SELECT * FROM users;


4. Test Stored Procedure

sql
CALL GetStudentResults(1);


5. Test View

sql
SELECT * FROM student_summary;
SELECT * FROM top_students;


6. Common Issues

- Foreign key error
 Insert order wrong

- Login not working
 Password not hashed correctly

- Grade empty
 Trigger not created or not firing



7. What You Achieve

✔ Realistic dataset
✔ Ready for screenshots
✔ Works with joins
✔ Works with procedures
✔ Works with triggers
✔ Perfect for viva demo

---
Next Step

INSERT INTO results (student_id, subject_id, exam_id, marks) VALUES

-- Student 1 (Sanjay)
(1, 1, 1, 85),
(1, 2, 1, 78),
(1, 3, 2, 88),
(1, 4, 2, 92),

-- Student 2 (Nimal)
(2, 1, 1, 65),
(2, 2, 1, 55),
(2, 3, 2, 60),
(2, 5, 2, 70),

-- Student 3 (Kamal)
(3, 1, 1, 45),
(3, 2, 1, 50),
(3, 3, 2, 40),
(3, 4, 2, 55),

-- Student 4 (Amara)
(4, 1, 1, 90),
(4, 2, 1, 88),
(4, 3, 2, 95),
(4, 5, 2, 85),

-- Student 5 (Kavindu)
(5, 1, 1, 72),
(5, 2, 1, 68),
(5, 4, 2, 75),
(5, 5, 2, 80);
