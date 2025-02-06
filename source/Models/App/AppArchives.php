<?php

namespace Source\Models\App;

use Source\Core\Model;

/**
 * Class AppArchives
 * @package Source\Models\App
 */
class AppArchives extends Model
{
    /**
     * AppArchives constructor.
     */
    public function __construct()
    {
        parent::__construct("app_archives", ["id"], ["archive", "title"]);
    }
}