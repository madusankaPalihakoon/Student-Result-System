@echo off
echo Creating Student Result System structure...

REM Create main folders
mkdir config
mkdir core
mkdir models
mkdir controllers
mkdir routes

REM Create files in config
type nul > config\database.php

REM Create files in core
type nul > core\Database.php
type nul > core\Response.php

REM Create files in models
type nul > models\Student.php
type nul > models\Subject.php
type nul > models\Result.php
type nul > models\User.php

REM Create files in controllers
type nul > controllers\StudentController.php
type nul > controllers\SubjectController.php
type nul > controllers\ResultController.php
type nul > controllers\AuthController.php

REM Create files in routes
type nul > routes\api.php

REM Create root file
type nul > index.php

echo.
echo  Structure created successfully!
pause
