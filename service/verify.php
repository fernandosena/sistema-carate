<?php

require __DIR__ . "/../vendor/autoload.php";

$student = new \Source\Models\App\AppStudent();
$students = $student->find()->limit(1)->fetch(true);

foreach ($students as $student) {
    $data_obj = new DateTime($student->last_renewal_data);
    $ano = $data_obj->format('Y');

    if($ano < date('Y')){
        $qtdYear = abs($ano - date('Y'));
        if(($qtdYear == 1) && (date('m') >= 3) && ($student->status != "pending")){
            $student->status = "pending";
            $student->save();
        }

        if(($qtdYear >= 2) && ($student->status != "canceled")){
            $student->status = "canceled";
            $student->save();
        }
    }
}