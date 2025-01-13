<?php

namespace Source\App\Admin;

use Source\Models\App\AppStudent;
use Source\Models\Auth;
use Source\Models\App\AppPlan;
use Source\Models\App\AppSubscription;
use Source\Models\Category;
use Source\Models\Post;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Models\Belt;

/**
 * Class Dash
 * @package Source\App\Admin
 */
class Dash extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/admin/dash/home");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        //real time access
        if (!empty($data["refresh"])) {
            $list = null;
            $items = (new Online())->findByActive();
            if ($items) {
                foreach ($items as $item) {
                    $list[] = [
                        "dates" => date_fmt($item->created_at, "H\hi") . " - " . date_fmt($item->updated_at, "H\hi"),
                        "user" => ($item->user ? $item->user()->fullName() : "Guest User"),
                        "pages" => $item->pages,
                        "url" => $item->url
                    ];
                }
            }

            echo json_encode([
                "count" => (new Online())->findByActive(true),
                "list" => $list
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        $infoBlacks = (new AppStudent())->find("next_graduation IS NOT NULL AND DATEDIFF(next_graduation, CURDATE()) BETWEEN 0 AND 185")->order("next_graduation DESC")->fetch(true);
        $infoInstructors = (new User())->find("next_graduation IS NOT NULL AND DATEDIFF(next_graduation, CURDATE()) BETWEEN 0 AND 185")->order("next_graduation DESC")->fetch(true);

        $year = date("Y");

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "info" => [
                "black" => $infoBlacks,
                "instructors" => $infoInstructors
            ],
            "quantity" => [
                "teachers" => (new User())->find("level < 5")->count(),
                "black" => (new AppStudent())->find("type = 'black'")->count(),
                "kyus" => (new AppStudent())->find("type = 'kyus'")->count(),
                "belts" => (new Belt())->find()->count(),
            ],
            "amount_days" => [
                "instrutores" => (new User())->quantityDays(),
                "dan" => (new AppStudent())->quantityDays('black'),
                "kyus" => (new AppStudent())->quantityDays('kyus'),
                "instrutoresG" => (new User())->quantityGDays(),
                "danG" => (new AppStudent())->quantityGDays('black'),
                "kyusG" => (new AppStudent())->quantityGDays('kyus'),
            ],
            "instructors" => (new User())->find("level != 5")->fetch(true),
            "control" => (object)[
                "subscribers" => (new AppSubscription())->find("pay_status = :s", "s=active")->count(),
                "plans" => (new AppPlan())->find("status = :s", "s=active")->count(),
                "recurrence" => (new AppSubscription())->recurrence()
            ],
            "blog" => (object)[
                "posts" => (new Post())->find("status = 'post'")->count(),
                "drafts" => (new Post())->find("status = 'draft'")->count(),
                "categories" => (new Category())->find("type = 'post'")->count()
            ],
            "users" => (object)[
                "users" => (new User())->find("level < 5")->count(),
                "admins" => (new User())->find("level >= 5")->count()
            ],
            "online" => (new Online())->findByActive(),
            "onlineCount" => (new Online())->findByActive(true)
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->first_name}.")->flash();

        Auth::logout(5);
        redirect("/admin/login");
    }
}