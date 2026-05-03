1. Project Overview (What You Are Building)

A Student Result System is a web application to:
        - Manage students, subjects, and marks
        - Calculate results (pass/fail, GPA, averages)
        - Allow **Admin** to manage data
        - Allow **Users (students)** to view results

2. System Architecture 

    Tier 1 – Presentation Layer
        - HTML, CSS, JavaScript
        - Pages: Login, Dashboard, Results

    Tier 2 – Application Layer
        - PHP (core only, NO frameworks)
        - Handles logic, DB connection

    Tier 3 – Data Layer
        - MySQL database

3. Project Folder Structure

```
student-result-system/
│
├── config/
│   └── db.php
│
├── models/
│   └── studentModel.php
│
├── controllers/
│   └── studentController.php
│
├── views/
│   ├── login.php
│   ├── dashboard.php
│   ├── results.php
│
├── assets/
│   ├── css/
│   └── js/
│
├── sql/
│   ├── schema.sql
│   ├── procedures.sql
│   ├── triggers.sql
│   └── views.sql
│
└── index.php
```

4. Database Design



Tables Design

1. users

```sql
user_id (PK)
username
password
role (admin/student)
```

2. students

```sql
student_id (PK)
name
email
course
```

3. subjects

```sql
subject_id (PK)
subject_name
credits
```

4. results

```sql
result_id (PK)
student_id (FK)
subject_id (FK)
marks
grade
```

5. exams

```sql
exam_id (PK)
exam_name
date
```

---

Relationships
    - Student → Results (1:M)
    - Subject → Results (1:M)
    - Student → Exams


6. MySQL Features 

    1. Stored Procedures 

```sql
CREATE PROCEDURE GetStudentResults(IN sid INT)
BEGIN
    SELECT s.name, sub.subject_name, r.marks
    FROM results r
    JOIN students s ON r.student_id = s.student_id
    JOIN subjects sub ON r.subject_id = sub.subject_id
    WHERE s.student_id = sid;
END;
```

   2. Triggers 


```sql
CREATE TRIGGER calculate_grade
BEFORE INSERT ON results
FOR EACH ROW
BEGIN
    IF NEW.marks >= 75 THEN
        SET NEW.grade = 'A';
    ELSEIF NEW.marks >= 50 THEN
        SET NEW.grade = 'C';
    ELSE
        SET NEW.grade = 'F';
    END IF;
END;
```

3. Views

```sql
CREATE VIEW student_summary AS
SELECT student_id, AVG(marks) AS average_marks
FROM results
GROUP BY student_id;
```

---

4. Index

```sql
CREATE INDEX idx_student_id ON results(student_id);
```

---

5. Transaction Example

```sql
START TRANSACTION;

INSERT INTO results VALUES (...);
UPDATE students SET ...;

COMMIT;
```

6. Complex Queries 
    - JOIN
    - GROUP BY
    - Subqueries

    7. PHP Development

        Login System
            - Admin / Student roles
            - Session-based login

        CRUD Operations
       
        | Function | Description    |
        | -------- | -------------- |
        | Create   | Add student    |
        | Read     | View results   |
        | Update   | Edit marks     |
        | Delete   | Remove student |



 Database Connection

```php
$conn = new PDO("mysql:host=localhost;dbname=student_db", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

8. UI Pages 

    Login Page
        - Username/password

    Admin Dashboard
        - Manage students, subjects, results

    Student Dashboard
        - View own results

    Report Page
        - Average marks
        - Top students


11. ER Diagram 

Entities:
    - Student
    - Subject
    - Result
    - User
    - Exam

Relationships:
    - Student → Result
    - Subject → Result


12. Development Plan (2 Weeks Strategy)

Week 1
    - Database design
    - ER diagram
    - SQL (tables, procedures, triggers)

Week 2
    - PHP + UI
    - Testing
    - Documentation
