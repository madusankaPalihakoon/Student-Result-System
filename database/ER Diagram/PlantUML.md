@startuml
entity Users {
+user_id : INT <<PK>>
username : VARCHAR
password : VARCHAR
role : ENUM(admin, student)
}

entity Students {
+student_id : INT <<PK>>
name : VARCHAR
email : VARCHAR
course_id : INT <<FK>>
}

entity Courses {
+course_id : INT <<PK>>
course_name : VARCHAR
}

entity Subjects {
+subject_id : INT <<PK>>
subject_name : VARCHAR
credits : INT
}

entity Exams {
+exam_id : INT <<PK>>
exam_name : VARCHAR
exam_date : DATE
}

entity Results {
+result_id : INT <<PK>>
student_id : INT <<FK>>
subject_id : INT <<FK>>
exam_id : INT <<FK>>
marks : DECIMAL
grade : VARCHAR
}

' Relationships
Courses ||--o{ Students
Students ||--o{ Results
Subjects ||--o{ Results
Exams ||--o{ Results
Users ||--|| Students : "login for"

@enduml
