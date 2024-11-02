<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;

/**
 * Class Belt
 * @package Source\Models
 */
class Belt extends Model
{
    /**
     * Belt constructor.
     */
    public function __construct()
    {
        parent::__construct("belts", ["id"], ["title", "age_range"]);
    }

    
    /**
     * @return array
     */
    public function student(): array
    {
        return [
            "all" => (new AppBlackBelt())->find("graduation = :b AND status != :s", "b={$this->id}&s=deactivated")->count()+(new AppKyus())->find("graduation = :b AND status != :s", "b={$this->id}&s=deactivated")->count(),
            "activated" => (new AppBlackBelt())->find("graduation = :b AND status = :s", "b={$this->id}&s=activated")->count()+(new AppKyus())->find("graduation = :b AND status = :s", "b={$this->id}&s=activated")->count(),
            "deactivated" => (new AppBlackBelt())->find("graduation = :b AND status = :s", "b={$this->id}&s=deactivated")->count()+(new AppKyus())->find("graduation = :b AND status = :s", "b={$this->id}&s=deactivated")->count(),
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

        /** Bealt Update */
        if (!empty($this->id)) {
            $bealtId = $this->id;
            if ($this->find("title = :t AND age_range = :a AND id != :i", "t={$this->title}&a={$this->age_range}&i={$bealtId}", "id")->fetch()) {
                $this->message->warning("Esse titulo já está cadastrado para essa idade");
                return false;
            }

            if ($this->find("position = :p AND age_range = :a AND id != :i", "p={$this->position}&a={$this->age_range}&i={$bealtId}", "id")->fetch()) {
                $this->message->warning("Posição já está cadastrado para essa idade");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$bealtId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** Bealt Create */
        if (empty($this->id)) {
            if ($this->find("title = :t AND age_range = :a", "t={$this->title}&a={$this->age_range}", "id")->fetch()) {
                $this->message->warning("Titulo já está cadastrado para essa idade");
                return false;
            }

            if(!empty($this->position)){
                if ($this->find("position = :p AND age_range = :a", "p={$this->position}&a={$this->age_range}", "id")->fetch()) {
                    $this->message->warning("Posição já está cadastrado para essa idade");
                    return false;
                }
            }

            $bealtId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($bealtId))->data();
        return true;
    }
}