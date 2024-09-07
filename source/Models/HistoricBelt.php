<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\Student;
use Source\Models\Belt;

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
        parent::__construct("historic_belts", ["id"], ["student_id", "graduation_id", "description"]);
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
     * @return null|Belt
     */
    public function findBelt($id): ?Belt
    {
        return (new Belt())->find("id = :id", "id={$id}")->fetch();
    }

}