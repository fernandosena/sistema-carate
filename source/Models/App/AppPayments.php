<?php

namespace Source\Models\App;

use Source\Core\Model;
use Source\Models\User;

/**
 * Class AppPayments
 * @package Source\Models
 */
class AppPayments extends Model
{
    /**
     * Payments constructor.
     */
    public function __construct()
    {
        parent::__construct("app_payments", ["id"], ["user_id", "value"]);
    }
}