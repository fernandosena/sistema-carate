<?php

namespace Source\Models;

use Source\Core\Model;

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
        parent::__construct("belts", ["id"], ["title", "color", "description"]);
    }

    /**
     * @return array
     */
    public function student(): array
    {
        return [
            "all" => (new Student())->find("belts = :b", "b={$this->id}")->count(),
            "activated" => (new Student())->find("belts = :b AND status = :s", "b={$this->id}&s=activated")->count(),
            "deactivated" => (new Student())->find("belts = :b AND status = :s", "b={$this->id}&s=deactivated")->count(),
        ];
    }
}