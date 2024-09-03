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
}