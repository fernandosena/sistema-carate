<?php

namespace Source\App\Admin;

use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppStudent;
use Source\Models\Belt;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

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
    public function home(?array $data): void
    {
        $list = (new AppStudent())->find()->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Faixas",
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