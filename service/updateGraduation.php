<?php
require __DIR__ . "/../vendor/autoload.php";


$users = (new \Source\Models\User())->find("level != 5 AND next_graduation IS NULL")->fetch(true);
foreach($users as $user){
  $graduation = (new \Source\Models\Belt())->findById($user->graduation);
  if(!empty($graduation->graduation_time)){
    $data = new DateTime($user->created_at);
    $data->modify("+{$graduation->graduation_time} year");
    $data_final = $data->format('Y-m-d');
    $user->next_graduation = $data_final;
    $user->save();
  }
}


$blacks = (new \Source\Models\App\AppBlackBelt())->find("next_graduation IS NULL")->fetch(true);
foreach($blacks as $black){
  $graduation = (new \Source\Models\Belt())->findById($black->graduation);
  if(!empty($graduation->graduation_time)){
    $data = new DateTime($black->created_at);
    $data->modify("+{$graduation->graduation_time} year");
    $data_final = $data->format('Y-m-d');
    $black->next_graduation = $data_final;
    $black->save();
  }
}
