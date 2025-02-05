<?php

namespace Source\Models\App;

use Source\Core\Model;
use Source\Models\User;

/**
 * Class AppTransfers
 * @package Source\Models\App
 */
class AppTransfers extends Model
{
    /**
     * AppTransfers constructor.
     */
    public function __construct()
    {
        parent::__construct("app_transfers", ["id"], ["id_of", "id_from", "student_id", "status"]);
    }

    public function student(){
        return (new AppStudent())->findById($this->student_id);
    }

    public function instructor(){
        return (new User())->findById($this->id_of);
    }
}