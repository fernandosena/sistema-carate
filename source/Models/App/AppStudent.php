<?php

namespace Source\Models\App;

use Source\Core\Model;
use Source\Models\User;
use Source\Models\Belt;
use Source\Models\HistoricBelt;

/**
 * Class AppStudent
 * @package Source\Models\App
 */
class AppStudent extends Model
{
    /**
     * AppStudent constructor.
     */
    public function __construct()
    {
        parent::__construct("app_students", ["id"], ["user_id", "dojo", "first_name", "last_name", "document", "graduation", "type"]);
    }

    /**
     * @param string $id
     * @param string $columns
     * @return null|array
     */
    public function findByTeacher(int $id, string $columns = "*"): ?array
    {
        $find = $this->find("user_id = :id AND type='black'", "id={$id}", $columns);
        return $find->fetch(true);
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function historicbeltscount(): ?string
    {
        if($this->type == "black"){
            return (new HistoricBelt())->find("black_belt_id = :b AND status = 'pending'", "b={$this->id}")->count();
        }else{
            return (new HistoricBelt())->find("kyus_id = :b AND status = 'pending'", "b={$this->id}")->count();
        }
    }

    /**
     * @return string|null
     */
    public function photo(): ?string
    {
        if ($this->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
            return $this->photo;
        }

        return null;
    }

    /**
     * @return null|Belt
     */
    public function belt(): ?HistoricBelt
    {
        if($this->type){
            if($this->type == "black"){
                return (new HistoricBelt())->find("black_belt_id = :id", "id={$this->id}")->order("graduation_data desc")->fetch();
            }else{
                return (new HistoricBelt())->find("kyus_id = :id", "id={$this->id}")->order("graduation_data desc")->fetch();
            }
        }
        return null;
    }

    /**
     * @return null|array
     */
    public function historic($terms = null, $params = null): ?array
    {
        $historic =  (new HistoricBelt())->find("black_belt_id = :id OR kyus_id = :id {$terms}", "id={$this->id}{$params}")->order("graduation_data DESC");
        return $historic ->fetch(true);
    }

    /**
     * @return null|array
     */
    public function payments(): ?array
    {
        return (new AppPayments())->find("student_id = :id", "id={$this->id}")->order("created_at desc")->fetch(true);
    }
    public function paymentsPendingId()
    {
        $student =  (new AppPayments())->find("student_id = :id AND status = :s", "id={$this->id}&s=pending")->order("created_at desc")->fetch();

        if($student){
            return $student->id;
        }
        return null;
    }
    public function paymentsPendingLast()
    {
        $student =  (new AppPayments())->find("student_id = :id AND status = :s", "id={$this->id}&s=pending")->order("created_at desc")->fetch();

        if($student){
            return $student;
        }
        return null;
    }

    public function quantityMonth($type = null, $user = null, $younger_age = null, $year = null){
        $m = date(format: "Y");
        if(!empty($year)){
            $m = $year;
        }

        $t = null;
        if(!empty($type)){
            $t = "AND type = '{$type}'";
        }

        $u = null;
        if(!empty($user)){
            $u = "AND user_id = {$user}";
        }
        
        $y = null;
        if(!empty($younger_age)){
            $date = date("Y-01-01");
            $y = "AND TIMESTAMPDIFF(YEAR, datebirth, '{$date}') {$younger_age}";
        }

        $sql = "SELECT meses.mes, COALESCE(COUNT(u.created_at), 0) AS quantidade_registros
        FROM (
            SELECT 1 AS mes UNION ALL
            SELECT 2 UNION ALL
            SELECT 3 UNION ALL
            SELECT 4 UNION ALL
            SELECT 5 UNION ALL
            SELECT 6 UNION ALL
            SELECT 7 UNION ALL
            SELECT 8 UNION ALL
            SELECT 9 UNION ALL
            SELECT 10 UNION ALL
            SELECT 11 UNION ALL
            SELECT 12
        ) AS meses
        LEFT JOIN app_students u ON MONTH(u.created_at) = meses.mes AND YEAR(u.created_at) = {$m} {$t} {$u} {$y}
        GROUP BY meses.mes
        ORDER BY meses.mes";

        $datas = $this->query($sql)->fetch(true);
        $dadosPorMes = [];
        foreach($datas as $data){
            $dadosPorMes[$data->mes] = (int)$data->quantidade_registros;
        }

        return $dadosPorMes;
    }

    public function quantityDays($type = null, $user = null, $younger_age = null, $year = null, $month = null){
        $m = date(format: "m");
        if(!empty($month)){
            $m = $month;
        }

        $y = date(format: "Y");
        if(!empty($year)){
            $y = $year;
        }

        $t = null;
        if(!empty($type)){
            $t = "AND type = '{$type}'";
        }

        $u = null;
        if(!empty($user) && $user != "all"){
            $u = "AND user_id = {$user}";
        }
        
        $ya = null;
        if(!empty($younger_age)){
            $date = date("Y-m-d");
            $ya = "AND TIMESTAMPDIFF(YEAR, datebirth, '{$date}') {$younger_age}";
        }

        $sql = "SELECT 
                    n.dia,
                    COALESCE(COUNT(s.id), 0) AS total_cadastrados
                FROM 
                    (
                        SELECT 1 AS dia UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
                        UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
                        UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
                        UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20
                        UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24 UNION ALL SELECT 25
                        UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30
                        UNION ALL SELECT 31
                    ) AS n
                LEFT JOIN 
                    app_students s 
                ON 
                    DAY(s.created_at) = n.dia
                    AND YEAR(s.created_at) = {$y}
                    AND MONTH(s.created_at) = {$m}
                    {$u}       
                    {$t}  
                    {$ya}   
                WHERE 
                    n.dia <= DAY(LAST_DAY('{$y}-{$m}-01'))
                GROUP BY 
                    n.dia
                ORDER BY 
                    n.dia";

        $datas = $this->query($sql)->fetch(true);
        $dadosPorDia = [];
        foreach($datas as $data){
            $dadosPorDia[$data->dia] = (int)$data->total_cadastrados;
        }

        return $dadosPorDia;
    }

    public function quantityGDays($type = null, $user = null, $year = null, $month = null){
        $m = date(format: "m");
        if(!empty($month)){
            $m = $month;
        }

        $y = date(format: "Y");
        if(!empty($year)){
            $y = $year;
        }

        $t = null;
        if(!empty($type)){
            if($type == "black"){
                $t = "AND h.black_belt_id IS NOT NULL";
            }elseif($type == "kyus"){
                $t = "AND h.kyus_id IS NOT NULL";
            }
        }

        $u = null;
        if(!empty($user) && $user != "all"){
            if($type == "black"){
                $u = "AND h.black_belt_id = {$user}";
            }elseif($type == "kyus"){
                $u = "AND h.kyus_id = {$user}";
            }
        }

        $sql = "SELECT 
                    n.dia,
                    COALESCE(COUNT(h.id), 0) AS total_cadastrados
                FROM 
                    (
                        SELECT 1 AS dia UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
                        UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
                        UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
                        UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20
                        UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24 UNION ALL SELECT 25
                        UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30
                        UNION ALL SELECT 31
                    ) AS n
                LEFT JOIN 
                    historic_belts h 
                ON 
                    DAY(h.created_at) = n.dia
                    AND YEAR(h.created_at) = {$y}
                    AND MONTH(h.created_at) = {$m}
                    {$u}       
                    {$t}  
                WHERE 
                    n.dia <= DAY(LAST_DAY('{$y}-{$m}-01'))
                GROUP BY 
                    n.dia
                ORDER BY 
                    n.dia";

        $datas = $this->query($sql)->fetch(true);
        $dadosPorDia = [];
        foreach($datas as $data){
            $dadosPorDia[$data->dia] = (int)$data->total_cadastrados;
        }

        return $dadosPorDia;
    }

    public function table($type = null, $user = null, $younger_age = null, $year = null, $month = null, $search = null, $orderBy = "first_name asc", $start = 0, $length = 0){
        $sqlParams = null;

        $y = date("Y");
        if(!empty($year)){
            $y = $year;
        }

        $m = date("m");
        if(!empty($month)){
            $m = $month;
            $sqlParams .= " AND MONTH(created_at) = {$m}";
        }

        if(!empty($type)){
            $sqlParams .= " AND type = '{$type}'";
        }

        if (!empty($search)) {
            $sqlParams .= " AND name LIKE '%{$search}%'";
        }

        if(!empty($user) && $user !== "all"){
            $sqlParams .= " AND user_id = {$user}";
        }
        
        if(!empty($younger_age)){
            $date = date("Y-01-01");
            $sqlParams .= " AND TIMESTAMPDIFF(YEAR, datebirth, '{$date}') {$younger_age}";
        }

        $sql = "SELECT * FROM app_students WHERE YEAR(created_at) = {$y} {$sqlParams}";
        $result = $this->query($sql);
        $count = $result->count();

        if(!empty($length)){
            $result->limit($length);
        }

        if(!empty($start)){
            $result->offset($start);
        }

        $rows = $result->fetch(true);

        $datas = [];
        foreach($rows as $row){
            $datas[] = [
                "id" => $row->id,
                "name" => $row->fullName(),
                "created_at" => $row->created_at
            ];
        }

        return [
            "quantity" => $count,
            "data" => $datas
        ];
    }

    public function paymentsActivatedLast()
    {
        $student =  (new AppPayments())->find("student_id = :id AND status = :s", "id={$this->id}&s=activated")->order("created_at desc")->fetch();

        if($student){
            return $student;
        }
        return null;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|AppBlackBelt
     */
    public function findByEmail(string $email, string $columns = "*"): ?AppBlackBelt
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }


    /**
     * @param string $document
     * @param string $columns
     * @return null|AppBlackBelt
     */
    public function findByDocument(string $document, string $columns = "*"): ?AppStudent
    {
        $document = preg_replace("/[^0-9]/", "", $document);
        $find = $this->find("document = :d", "d={$document}", $columns);
        return $find->fetch();
    }

    /**
     * @return User
     */
    public function teacher(): User
    {
        return (new User())->find("id = :id", "id={$this->user_id}")->fetch();
    }
    public function getLastGraduation(): Belt|null
    {
        $historic = false;
        if($this->type == 'black'){
            $historic = (new HistoricBelt())->find("black_belt_id = :id AND status = 'approved'", "id={$this->id}")->order("graduation_data desc")->fetch();
        }else{
            $historic = (new HistoricBelt())->find("kyus_id = :id AND status = 'approved'", "id={$this->id}")->order("graduation_data desc")->fetch();
        }

        if($historic){
            return (new Belt())->findById($historic->graduation_id);
        }
        return null;
    }


    /**
     * @param User $user
     * @return object
     */
    public function chartData(User $user): object
    {
        $dateChart = [];
        for ($month = -5; $month <= 0; $month++) {
            $dateChart[] = date("m/Y", strtotime("{$month}month"));
        }


        $chartData = new \stdClass();
        $chartData->categories = "'" . implode("','", $dateChart) . "'";
        $chartData->students = "0,0,0,0,0,0";

        $chart = $this
            ->find("user_id = :user AND created_at >= DATE(now() - INTERVAL 6 MONTH) GROUP BY year(created_at) ASC, month(created_at) ASC",
                "user={$user->id}",
                "year(created_at) AS due_year,
                month(created_at) AS due_month,
                DATE_FORMAT(created_at, '%m/%Y') AS due_date,
                COUNT(*) AS quantity"
            )->limit(6)->fetch(true);

        if ($chart) {
            $chartCategories = [];
            $chartStudents = [];

            foreach ($chart as $chartItem) {
                $chartCategories[] = $chartItem->due_date;
                $chartStudents[] = $chartItem->quantity;
            }

            $chartData->categories = "'" . implode("','", $chartCategories) . "'";
            $chartData->students = implode(",", array_map("abs", $chartStudents));
        }

        return $chartData;
    }
}