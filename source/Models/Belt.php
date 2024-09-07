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
        parent::__construct("belts", ["id"], ["title", "description", "age_range"]);
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
}