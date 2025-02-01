<?php

namespace Source\Models\App;

use Source\Core\Model;
use Source\Models\User;
use Source\Models\Belt;
use Source\Models\HistoricBelt;

/**
 * Class AppKyus
 * @package Source\Models\App
 */
class AppKyus extends Model
{
    /**
     * AppKyus constructor.
     */
    public function __construct()
    {
        parent::__construct("app_students", ["id"], ["user_id", "dojo", "first_name", "last_name", "datebirth", "document", "graduation"]);
    }
    
    /**
     * @param User $user
     * @param string $type
     * @param array|null $filter
     * @param int|null $limit
     * @return array|null
     */
    public function filter(User $user, string $type, ?array $filter, ?int $limit = null): ?array
    {
        $status = (!empty($filter["status"]) && $filter["status"] == "activated" ? "AND status = 'activated'" : (!empty($filter["status"]) && $filter["status"] == "deactivated" ? "AND status = 'deactivated'" : null));

        $belts = (!empty($filter["belts"]) && $filter["belts"] != "all" ? "AND belts = '{$filter["belts"]}'" : null);

        $due_year = (!empty($filter["date"]) ? explode("-", $filter["date"])[1] : date("Y"));
        $due_month = (!empty($filter["date"]) ? explode("-", $filter["date"])[0] : date("m"));
        $created_at = "AND (year(created_at) = '{$due_year}' AND month(created_at) = '{$due_month}')";

        $due = $this->find(
            "user_id = :user {$status} {$belts} {$created_at}",
            "user={$user->id}"
        )->order("day(created_at) ASC");

        if ($limit) {
            $due->limit($limit);
        }

        return $due->fetch(true);
    }
    
    /**
     * @param string $id
     * @param string $columns
     * @return null|array
     */
    public function findByTeacher(int $id, string $columns = "*"): ?array
    {
        $find = $this->find("user_id = :id AND type='kyus'", "id={$id}", $columns);
        return $find->order("dojo")->fetch(true);
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
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
    public function belt(): ?Belt
    {
        if($this->graduation){
            return (new Belt())->find("id = :id", "id={$this->graduation}")->fetch();
        }
        return null;
    }

    /**
     * @return null|array
     */
    public function historic(): ?array
    {
        return (new HistoricBelt())->find("kyus_id = :id", "id={$this->id}")->order("created_at desc")->fetch(true);
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|AppKyus
     */
    public function findByEmail(string $email, string $columns = "*"): ?AppKyus
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }


    /**
     * @param string $document
     * @param string $columns
     * @return null|AppKyus
     */
    public function findByDocument(string $document, string $columns = "*"): ?AppKyus
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

        $chart = (new AppBlackBelt())
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

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Preencha todos os campos obrigatórios");
            return false;
        }

        /** AppBlackBelt Update */
        if (!empty($this->id)) {
            $AppBlackBeltId = $this->id;

            if ($this->find("document = :d AND id != :i", "d={$this->document}&i={$AppBlackBeltId}", "id")->fetch()) {
                $this->message->warning("O CPF informado já está cadastrado");
                return false;
            }

            if(!empty($this->document)){
                if ((new User())->find("document = :d", "d={$this->document}", "id")->fetch()) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            $this->type = "kyus";
            $this->update($this->safe(), "id = :id", "id={$AppBlackBeltId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** AppBlackBelt Create */
        if (empty($this->id)) {
            if ($this->findByDocument($this->document, "id")) {
                $this->message->warning("O CPF informado já está cadastrado");
                return false;
            }

            if(!empty($this->document)){
                if ((new User())->find("document = :d", "d={$this->document}", "id")->fetch()) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            $this->type = "kyus";
            $AppBlackBeltId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($AppBlackBeltId))->data();
        return true;
    }
}