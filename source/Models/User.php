<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;
use Source\Models\App\AppPayments;
use Source\Models\App\AppStudent;
use Source\Models\Belt;

/**
 * Class User Active Record Pattern
 *
 * @author Fernando C. Sena <fernandocarvalho.sena@gmail.com>
 * @package Source\Models
 */
class User extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["id"], ["first_name", "last_name", "email", "password", "document", "zip", "address", "neighborhood", "number", "phone", "graduation", "dojo"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string|null $document
     * @return User
     */
    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $document = null
    ): User {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->document = $document;
        return $this;
    }

    /**
     * @param string $email
     * @param string $columns
     * @return null|User
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $find = $this->find("email = :email", "email={$email}", $columns);
        return $find->fetch();
    }

    /**
     * @param string $document
     * @param string $columns
     * @return null|User
     */
    public function findByDocument(string $document, string $columns = "*"): ?User
    {
        $document = preg_replace("/[^0-9]/", "", $document);
        $find = $this->find("document = :d", "d={$document}", $columns);
        return $find->fetch();
    }

    public function historicbeltscount(): bool
    {
        return false;
    }

    /**
     * @return null|array
     */
    public function historic($terms = null, $params = null): ?array
    {
        return (new HistoricBelt())->find("instructor_id = :id{$terms}", "id={$this->id}{$params}")->order("created_at desc")->fetch(true);
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
     * @return array
     */
    public function student(): array
    {
        return [
            "all" => (new AppStudent())->find("user_id = :u and status != :s", "u={$this->id}&s=deactivated")->count(),
            "activated" => (new AppStudent())->find("user_id = :u AND status = :s", "u={$this->id}&s=activated")->count(),
            "deactivated" => (new AppStudent())->find("user_id = :u AND status = :s", "u={$this->id}&s=deactivated")->count(),
            "pending" => (new AppStudent())->find("user_id = :u AND status = :s", "u={$this->id}&s=pending")->count(),
        ];
    }

    public function quantityMonth($user = null, $month = null){
        
        $m = date("Y");
        if(!empty($month)){
            $m = $month;
        }

        $u = null;
        if(!empty($user)){
            $u = "AND id = {$user}";
        }

        $datas = $this->query("SELECT meses.mes, COALESCE(COUNT(u.created_at), 0) AS quantidade_registros
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
        LEFT JOIN users u ON MONTH(u.created_at) = meses.mes AND YEAR(u.created_at) = {$m} AND u.level != 5 {$u}
        GROUP BY meses.mes
        ORDER BY meses.mes")->fetch(true);


        $dadosPorMes = [];
        foreach($datas as $data){
            $dadosPorMes[$data->mes] = (int)$data->quantidade_registros;
        }

        return $dadosPorMes;
    }

    public function quantityDays($user = null, $year = null, $month = null){
        $y = date("Y");
        if(!empty($year)){
            $y = $year;
        }

        $m = date("m");
        if(!empty($month)){
            $m = $month;
        }

        $u = null;
        if(!empty($user) && $user != "all"){
            $u = "AND users.id = {$user}";
        }

        $sql = "SELECT 
            n.dia,
            COALESCE(COUNT(users.id), 0) AS total_cadastrados
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
            users 
        ON 
            DAY(users.created_at) = n.dia
            AND YEAR(users.created_at) = {$y}
            AND MONTH(users.created_at) = {$m}
            AND users.level != 5 
            {$u}            
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

    public function quantityGDays($user = null, $year = null, $month = null){
        $y = date("Y");
        if(!empty($year)){
            $y = $year;
        }

        $m = date("m");
        if(!empty($month)){
            $m = $month;
        }

        $u = null;
        if(!empty($user)){
            $u = "AND h.instructor_id = {$user}";
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

    public function table($user = null, $year = null, $month = null, $search = null, $orderBy = "first_name asc", $start = 0, $length = 10){
        $terms = null;
        $params = null;

        $y = date("Y");
        if(!empty($year)){
            $y = $year;
            $terms .= " AND YEAR(created_at) = :y";
            $params .= "&y={$y}";
        }

        $m = date("m");
        if(!empty($month)){
            $m = $month;
            $terms .= " AND MONTH(created_at) = :m";
            $params .= "&m={$m}";
        }

        if (!empty($search)) {
            $terms .= " AND name LIKE :search OR created_at LIKE :search";
            $params .= "&search='%{$search}%'";
        }

        if(!empty($user) && $user !== "all"){
            $terms .= " AND id = :id";
            $params .= "&id={$user}";
        }

        $result = $this->find("level != :l {$terms}", "l=5{$params}")->order($orderBy);
        
        $rows = $result->limit($length )->offset($start)->fetch(true);

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                "id" => $row->id,
                "name" => $row->fullname(),
                "created_at" => date("d/m/Y", strtotime($row->created_at))
            ];
        }

        return [
            "quantity" => $result->count(),
            "data" => $data
        ];
    }
    
    public function getLastGraduation()
    {
        return null;
    }

    public function paymentsPendingLast()
    {
        $instructor =  (new AppPayments())->find("instructor_id = :id AND status = :s", "id={$this->id}&s=pending")->order("created_at desc")->fetch();
        if($instructor){
            return $instructor;
        }
        return null;
    }
    public function paymentsActivatedLast()
    {
        $instructor =  (new AppPayments())->find("instructor_id = :id AND status = :s", "id={$this->id}&s=activated")->order("created_at desc")->fetch();

        if($instructor){
            return $instructor;
        }
        return null;
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

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = passwd($this->password);
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }
            
            if(!empty($this->document)){
                if ((new AppStudent())->find("document = :d", "d={$this->document}", "id")->fetch()) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            if(!empty($this->document)){
                if ($this->find("document = :d AND id != :i", "d={$this->document}&i={$userId}", "id")->fetch()) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            $this->update($this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email, "id")) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            if(!empty($this->document)){
                if ($this->findByDocument($this->document, "id")) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            if(!empty($this->document)){
                if ((new AppStudent())->find("document = :d", "d={$this->document}", "id")->fetch()) {
                    $this->message->warning("O CPF informado já está cadastrado");
                    return false;
                }
            }

            $userId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return true;
    }
}