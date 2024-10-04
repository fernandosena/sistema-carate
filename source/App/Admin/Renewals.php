<?php

namespace Source\App\Admin;

use Source\Models\App\AppStudent;
use Source\Models\User;

/**
 * Class Renewals
 * @package Source\App\Admin
 */
class Renewals extends Admin
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function student(?array $data): void
    {
        $list = (new AppStudent())->find()->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Alunos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/renewals/home", [
            "app" => "renewals/home",
            "head" => $head,
            "students" => $list,
        ]);
    }

    /**
     * @param array|null $data
     */
    public function instruncto(?array $data): void
    {
        $list = (new User())->find("level != 5")->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Professores",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/renewals/home", [
            "app" => "renewals/home",
            "head" => $head,
            "students" => $list,
        ]);
    }
}