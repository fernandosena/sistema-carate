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
        if ($this->photo && file_exists(__DIR__ . "/../../" . CONF_UPLOAD_DIR . "/{$this->photo}")) {
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
                return (new HistoricBelt())->find("black_belt_id = :id", "id={$this->id}")->order("created_at desc")->fetch();
            }else{
                return (new HistoricBelt())->find("kyus_id = :id", "id={$this->id}")->order("created_at desc")->fetch();
            }
        }
        return null;
    }

    /**
     * @return null|array
     */
    public function historic($terms = null, $params = null): ?array
    {
        return (new HistoricBelt())->find("black_belt_id = :id OR kyus_id = :id {$terms}", "id={$this->id}{$params}")->order("created_at desc")->fetch(true);
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