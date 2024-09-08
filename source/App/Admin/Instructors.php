<?php

namespace Source\App\Admin;

use Source\Models\App\AppKyus;
use Source\Models\Belt;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Models\App\AppBlackBelt;

/**
 * Class Instructors
 * @package Source\App\Admin
 */
class Instructors extends Admin
{
    /**
     * Instructors constructor.
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
        //search redirect
        if (isset($data["s"])) {
            if(!empty($data["s"])){
                $s = str_search($data["s"]);
                echo json_encode(["redirect" => url("/admin/instructors/home/{$s}/1")]);
                return;
            }
            echo json_encode(["redirect" => url("/admin/instructors/home")]);
            return;
        }

        $search = null;
        $users = (new User())->find("level < :l", "l=5");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$users->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/instructors/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/instructors/home/{$all}/"));
        $pager->pager($users->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/instructors/home", [
            "app" => "users/home",
            "head" => $head,
            "search" => $search,
            "users" => $users->order("first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function instructor(?array $data): void
    {
        
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            $userCreate = new User();
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->level = 1;
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userCreate->status = "confirmed";
            $userCreate->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $userCreate->state = $data["state"];
            $userCreate->city = $data["city"];
            $userCreate->address = $data["address"];
            $userCreate->neighborhood = $data["neighborhood"];
            $userCreate->number = $data["number"];
            $userCreate->complement = $data["complement"];
            $userCreate->phone = $data["phone"];
            $userCreate->graduation = $data["graduation"];
            $userCreate->dojo = implode(",", $data["dojo"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/instructors/instructor/{$userCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $userUpdate = (new User())->findById($data["instructor_id"]);

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/instructors/home")]);
                return;
            }

            $userUpdate->first_name = $data["first_name"];
            $userUpdate->last_name = $data["last_name"];
            $userUpdate->email = $data["email"];
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userUpdate->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $userUpdate->state = $data["state"];
            $userUpdate->city = $data["city"];
            $userUpdate->address = $data["address"];
            $userUpdate->neighborhood = $data["neighborhood"];
            $userUpdate->number = $data["number"];
            $userUpdate->complement = $data["complement"];
            $userUpdate->phone = $data["phone"];
            $userUpdate->graduation = $data["graduation"];
            $userUpdate->dojo = implode(",", $data["dojo"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        
        $userId = filter_var($data["instructor_id"], FILTER_VALIDATE_INT);
        $user = (new User())->findById($userId);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($user ? "Detalhes de {$user->fullName()}" : "Novo Instutor"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $blacks = (new AppBlackBelt())->findByTeacher($userId);
        $kyus = (new AppKyus())->findByTeacher($userId);
        
        $graduations = (new Belt())->find("title LIKE '%dan%'")->fetch(true);

        echo $this->view->render("widgets/instructors/instructor", [
            "app" => "users/user",
            "head" => $head,
            "user" => $user,
            "form" => [
                "url" => url("admin/instructors/instructor/{$user->id}"),
                "graduations" => $graduations,
                "data" => $user
            ],
            "blacks" => $blacks,
            "kyus" => $kyus,
        ]);

    }
}