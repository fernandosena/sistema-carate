<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class Conf
 * @package Source\Models
 */
class Conf extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("conf", ["id"], ["logo", "title"]);
    }
}