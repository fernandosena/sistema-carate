<?php

namespace Source\Models\App;

use Source\Core\Model;

/**
 * Class AppCategory
 * @package Source\Models\App
 */
class AppCategory extends Model
{
    /**
     * AppCategory constructor.
     */
    public function __construct()
    {
        parent::__construct("app_categories", ["id"], ["name", "type"]);
    }
}