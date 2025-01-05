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
        if(!empty($data)){
            //Filtra Instrutor/Dan e Kyus
            if($data["filter"] == 1){
                $result = [
                    "instrutores" => (new User())->quantityMonth(null,$data["year"]),
                    "dan" => (new AppStudent())->quantityMonth('black', null, null, $data["year"]),
                    "kyus" => (new AppStudent())->quantityMonth('kyus', null, null, $data["year"]),
                ];
            }else{
                $result = [
                    "i" => (new AppStudent())->quantityMonth('black', $data["user"], null, $data["year"]),
                    "d" => (new AppStudent())->quantityMonth('kyus', $data["user"], "< 13", $data["year"]),
                    "k" => (new AppStudent())->quantityMonth('kyus', $data["user"], ">= 13", $data["year"]),
                ];
            }
        }

        $json["result"] = $result;
        echo json_encode($json);
    }
}