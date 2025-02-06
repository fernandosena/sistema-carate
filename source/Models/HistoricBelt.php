<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppStudent;
use Source\Models\Belt;
use Source\Models\User;

/**
 * Class HistoricBelt
 * @package Source\Models
 */
class HistoricBelt extends Model
{
    /**
     * HistoricBelt constructor.
     */
    public function __construct()
    {
        parent::__construct("historic_belts", ["id"], ["graduation_id", "description"]);
    }

    /**
     * @param Student $student
     * @param Belt $belt
     * @param string $description
     * @return HistoricBelt
     */
    public function bootstrap(
        Student $student,
        Belt $belt,
        string $description,
    ): HistoricBelt {
        $this->student_id = $student->id;
        $this->graduation_id = $belt->id;
        $this->description = $description;
        return $this;
    }

    /**
     * @return null|User
     */
    public function user(): ?User
    {
        return (new User())->find("id = :id", "id={$this->instructor_id}")->fetch();
    }
    public function userId($id): ?User
    {
        return (new User())->find("id = :id", "id={$id}")->fetch();
    }
    public function studentId($id): ?AppStudent
    {
        return (new AppStudent())->find("id = :id", "id={$id}")->fetch();
    }
    

    /**
     * @return null|Belt
     */
    public function findBelt($id): ?Belt
    {
        return (new Belt())->find("id = :id", "id={$id}")->fetch();
    }

    /**
     * @return null|Belt
     */
    public function belt(): ?Belt
    {
        return (new Belt())->find("id = :id", "id={$this->graduation_id}")->fetch();
    }

    public function table($type = null, $user = null, $younger_age = null, $year = null, $month = null, $search = null, $orderBy = "created_at asc", $start = 0, $length = 0){
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

        if (!empty($search)) {
            $sqlParams .= " AND description LIKE '%{$search}%'";
        }

        if(!empty($user) && $user !== "all"){
            $sqlParams .= " AND instructor_id = {$user}";
        }

        if(!empty($type)){
            if($type == 'black'){
                $sqlParams .= " AND black_belt_id IS NOT NULL";
            }else if($type == 'kyus'){
                $sqlParams .= " AND kyus_id IS NOT NULL";
            }
        }

        $sql = "SELECT * FROM historic_belts WHERE YEAR(created_at) = {$y} {$sqlParams}";
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
            $name = null;
            if(!empty($row->black_belt_id) || !empty($row->kyus_id)){
                if(!empty($row->black_belt_id)){
                    $name = $this->studentId($row->black_belt_id)->first_name;
                }else{
                    $name = $this->studentId($row->kyus_id)->first_name;
                }
            }else{
                $name = $this->userId($row->instructor_id)->first_name;
            }

            $graduation = $this->findBelt($row->graduation_id)->title;
            $datas[] = [
                "id" => $row->id,
                "name" => $name,
                "graduation" => $graduation,
                "created_at" => $row->created_at
            ];
        }

        return [
            "quantity" => $count,
            "data" => $datas
        ];
    }
}