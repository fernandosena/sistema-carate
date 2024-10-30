<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;
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
            "all" => (new AppBlackBelt())->find("user_id = :u and status != :s", "u={$this->id}&s=deactivated")->count(),
            "activated" => (new AppBlackBelt())->find("user_id = :u AND status = :s", "u={$this->id}&s=activated")->count(),
            "deactivated" => (new AppBlackBelt())->find("user_id = :u AND status = :s", "u={$this->id}&s=deactivated")->count(),
            "pending" => (new AppBlackBelt())->find("user_id = :u AND status = :s", "u={$this->id}&s=pending")->count(),
        ];
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
                if ((new AppBlackBelt())->find("document = :d", "d={$this->document}", "id")->fetch()) {
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
                if ((new AppBlackBelt())->find("document = :d", "d={$this->document}", "id")->fetch()) {
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