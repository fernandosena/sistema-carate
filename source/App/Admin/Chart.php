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
        $label = null;
        if(!empty($data)){
            //Filtra Instrutor/Dan e Kyus
            $result = [
                "instrutores" => (new User())->quantityDays($data["instructor"],$data["year"],$data["month"]),
                "dan" => (new AppStudent())->quantityDays('black', $data["instructor"], null, $data["year"], $data["month"]),
                "kyus" => (new AppStudent())->quantityDays('kyus', $data["instructor"], null, $data["year"], $data["month"]),
            ];
            $label = arrayDaysRanger($data["year"], $data["month"]);
        }
        $json["result"] = $result;
        $json["label"] = $label;
        echo json_encode($json);
    }

    public function table(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

        // Parâmetros enviados pelo DataTables
        $draw = $data['draw'];
        $start = $data['start'];
        $length = $data['length'];
        $search = $data['search']['value'];
        
        // Ordenação
        $orderColumnIndex = $_POST['order'][0]['column'];
        $orderDirection = $_POST['order'][0]['dir'];
        $columns = array("first_name", "created_at");
        $orderBy = $columns[$orderColumnIndex] . " " . $orderDirection;

        if(!empty($data)){
            //Filtra Instrutor/Dan e Kyus
            if($data["filter"] == 1){
                if($data["type"] == "intructor"){
                    $result = (new User())->table($data["instructor"], $data["year"], $data["month"], $search, $orderBy, $start, $length);
                }else{
                    $result = (new AppStudent())->table($data["type"],$data["instructor"], null, $data["year"], $data["month"], $search, $orderBy, $start, $length);
                }

                $response = array(
                    "draw" => intval($_POST['draw']),
                    "recordsTotal" => $result["quantity"], // Total de registros sem filtro
                    "recordsFiltered" => count($result["data"] ?? []), // Total de registros com filtro (neste exemplo, igual ao total)
                    "data" => $result["data"]
                ); 
            }
        }
        echo json_encode($response);
        return;
    }
}