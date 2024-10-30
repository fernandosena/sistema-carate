<?php

require __DIR__ . "/../vendor/autoload.php";

$student = new \Source\Models\App\AppStudent();
$students = $student->find("type = 'kyus' ")->fetch(true);

foreach ($students as $student) {
    var_dump($student);
}