<?php

namespace Source\App\Admin;

use Source\Models\App\AppKyus;
use Source\Models\Belt;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Models\App\AppBlackBelt;
use Source\Models\HistoricBelt;

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
            $userCreate->status = $data["status"];

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

            $hbelt = (new HistoricBelt());
            $hbelt->instructor_id = $userCreate->id;

            $graduation = graduation_data($data["graduation"]);
            
            if($graduation){
                $hbelt->graduation_data = $graduation;
            }

            $hbelt->graduation_id = $data["graduation"];
            $hbelt->description = "Definido ao cadastrar instrutor";
            $hbelt->save();

            $this->message->success("Instrutor cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/instructors/instructor/{$userCreate->id}");

            echo json_encode($json);
            return;
        }

        if (!empty($data["action"]) && $data["action"] == "payment") {
            $user_id = $data["user_id"];
            $instruncto_id = $data["instruncto_id"];

            $user = (new User())->findById($user_id);
            if(!$user){
                echo json_encode([
                    "message" => $this->message->warning("Usuario informado não existe")->render()
                ]);
                return;
            }

            $instruncto = (new User())->findById($instruncto_id);
            if(!$instruncto){
                echo json_encode([
                    "message" => $this->message->warning("Instrutor informado não existe")->render()
                ]);
                return;
            }

            $instruncto->renewal = null;
            $instruncto->last_renewal_data = date("Y-m-d");

            if(!$instruncto->save()){
                echo json_encode([
                    "message" => $this->message->error("Erro ao atualizar usuario")->render()
                ]);
                return;
            }

            echo json_encode([
                "renewal" => true
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $userUpdate = (new User())->findById($data["instructor_id"]);

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um instrutor que não existe")->flash();
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
            $userUpdate->status = $data["status"];

            if(!empty($userUpdate->dojo) && !empty($data["dojo"])){
                if($userUpdate->dojo != $data["dojo"]){
                    $dojodb = explode(",", $userUpdate->dojo);

                    $diferenca1 = implode(",", array_diff($dojodb, $data["dojo"]));


                    $appKyus = (new AppKyus())->find("user_id = :id AND dojo IN (:dojo)", "id=$userUpdate->id, &dojo=$diferenca1");
                    if($appKyus->count()){
                        $json["message"] = $this->message->warning("Não foi possivel atualizar pois já existe Kyus cadastrados no dojo retirado")->render();
                        echo json_encode($json);
                        return;
                    }

                    $appBlackBelt = (new AppBlackBelt())->find("user_id = :id AND dojo IN (:dojo)", "id=$userUpdate->id, &dojo=$diferenca1");
                    if($appBlackBelt->count()){
                        $json["message"] = $this->message->warning("Não foi possivel atualizar pois já existe Faixas pretas cadastrados no dojo retirado")->render();
                        echo json_encode($json);
                        return;
                    }

                    $userUpdate->dojo = implode(",", $data["dojo"]);
                }
            }

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


        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            
            $userDelete = (new User())->findById($data["instructor_id"]);

            if (!$userDelete) {
                $this->message->error("Você tentou remover um instrutor que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/instructors/home")]);
                return;
            }

            $userDelete->destroy();
            $this->message->success("Instrutor excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/instructors/home")]);
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
        
        $graduations = (new Belt())->find("title LIKE '%IOGKF%'  OR title LIKE '%dan%'")->fetch(true);

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