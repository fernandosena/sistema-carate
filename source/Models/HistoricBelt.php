<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\App\AppBlackBelt;
use Source\Models\Belt;
use Source\Models\User;

/**
 * Class HistoricBelt
 * @package Source\Models
 */
class HistoricBelt extends Model
{
    /**
     * HistoricBelt constructor.
     */
    public function __construct()
    {
        parent::__construct("historic_belts", ["id"], ["graduation_id", "description"]);
    }

    /**
     * @param Student $student
     * @param Belt $belt
     * @param string $description
     * @return HistoricBelt
     */
    public function bootstrap(
        Student $student,
        Belt $belt,
        string $description,
    ): HistoricBelt {
        $this->student_id = $student->id;
        $this->graduation_id = $belt->id;
        $this->description = $description;
        return $this;
    }

    /**
     * @return null|User
     */
    public function user(): ?User
    {
        return (new User())->find("id = :id", "id={$this->instructor_id}")->fetch();
    }

    /**
     * @return null|Belt
     */
    public function findBelt($id): ?Belt
    {
        return (new Belt())->find("id = :id", "id={$id}")->fetch();
    }

}