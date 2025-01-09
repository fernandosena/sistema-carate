<?php

namespace Source\App\Admin;

use Source\Models\App\AppStudent;
use Source\Models\User;

/**
 * Class Chart
 * @package Source\App\Admin
 */
class Chart extends Admin
{
    /**
     * Chart constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function quantity(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

        $result = null;
        $table = null;
        $label = null;
        if(!empty($data)){
            //Filtra Instrutor/Dan e Kyus
            if($data["filter"] == 1){
                $result = [
                    "instrutores" => (new User())->quantityDays(null,$data["year"],$data["month"]),
                    "dan" => (new AppStudent())->quantityDays('black', null, null, $data["year"], $data["month"]),
                    "kyus" => (new AppStudent())->quantityDays('kyus', null, null, $data["year"], $data["month"]),
                ];
                $table = [
                    "instrutores" => (new User())->table($data["year"]),
                ];
            }else{
                $result = [
                    "i" => (new AppStudent())->quantityMonth('black', $data["user"], null, $data["year"]),
                    "d" => (new AppStudent())->quantityMonth('kyus', $data["user"], "< 13", $data["year"]),
                    "k" => (new AppStudent())->quantityMonth('kyus', $data["user"], ">= 13", $data["year"]),
                ];
                $table = [
                    "dan" => (new AppStudent())->table('black', $data["user"], null, $data["year"]),
                    "kyu1" => (new AppStudent())->table('kyus', $data["user"], "< 13", $data["year"]),
                    "kyu2" => (new AppStudent())->table('kyus', $data["user"], ">= 13", $data["year"]),                
                ];
            }
            $label = arrayDaysRanger($data["year"], $data["month"]);
        }


        $json["result"] = $result;
        $json["table"] = $table;
        $json["label"] = $label;
        echo json_encode($json);
    }
}