GET /index.php?resource=students
GET /index.php?resource=students&id=1
POST /index.php?resource=students
PUT /index.php?resource=students&id=1
DELETE /index.php?resource=students&id=1

AUTH

Register
http://localhost:8000/backend/?resource=auth&action=register
{
"username": "user",
"password": "useruser",
"role": "admin"
}

{
"username": "student",
"password": "studentstudent",
}

{
"username": "user",
"password": "user",
"role": "student",
"student_id": 1
}

Login
http://localhost:8000/backend/?resource=auth
{
"username": "user",
"password": "useruser"
}
