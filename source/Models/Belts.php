<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class Belts
 * @package Source\Models
 */
class Belts extends Model
{
    /**
     * Belts constructor.
     */
    public function __construct()
    {
        parent::__construct("belts", ["id"], ["title", "description"]);
    }
}