<?php

namespace Source\App\Admin;

use Source\Models\Belt;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class Belts
 * @package Source\App\Admin
 */
class Belts extends Admin
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
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/belts/home/{$s}/1")]);
            return;
        }

        $search = null;
        $belts = (new Belt())->find();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Faixas",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/belts/home", [
            "app" => "belts/home",
            "head" => $head,
            "search" => $search,
            "belts" => $belts
            ->order("age_range ASC, position")
            ->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function belt(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            $beltCreate = new Belt();
            $beltCreate->title = $data["title"];
            $beltCreate->age_range = $data["age_range"];

            if(!empty($data["position"])){
                $beltCreate->position = $data["position"];
            }

            if (!$beltCreate->save()) {
                $json["message"] = $beltCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Graduação cadastrada com sucesso...")->flash();
            $json["redirect"] = url("/admin/belts/belt");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $beltUpdate = (new Belt())->findById($data["belt_id"]);

            if (!$beltUpdate) {
                $this->message->error("Você tentou gerenciar uma Graduação que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/belts/home")]);
                return;
            }

            $beltUpdate->title = $data["title"];
            $beltUpdate->age_range = $data["age_range"];

            if(!empty($data["position"])){
                $beltUpdate->position = $data["position"];
            }

            if (!$beltUpdate->save()) {
                $json["message"] = $beltUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Graduação atualizada com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $beltEdit = null;
        if (!empty($data["belt_id"])) {
            $beltId = filter_var($data["belt_id"], FILTER_VALIDATE_INT);
            $beltEdit = (new Belt())->findById($beltId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($beltEdit ? "Graduação {$beltEdit->title}" : "Nova Graduação"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/belts/belt", [
            "app" => "belts/belt",
            "head" => $head,
            "belt" => $beltEdit
        ]);
    }

    /**
     * @param array|null $data
     */
    public function list(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/belts/list/{$s}/1")]);
            return;
        }

        $search = null;
        $belts = (new Belt())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $belts = (new Belt())->find("title = :title", "title={$search}");
            if (!$belts->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/belts/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/belts/list/{$all}/"));
        $pager->pager($belts->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Faixas",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/belts/home", [
            "app" => "belts/home",
            "head" => $head,
            
            "search" => $search,
            "belts" => $belts->order("title")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }
}