<?php

namespace Source\App\Admin;

use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Models\Student;
use Source\Models\Belt;
use Source\Models\HistoricBelt;

/**
 * Class Students
 * @package Source\App\Admin
 */
class Students extends Admin
{
    /**
     * Students constructor.
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
            echo json_encode(["redirect" => url("/admin/students/home/{$s}/1")]);
            return;
        }

        $search = null;
        $students = (new Student())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $students = (new Student())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$students->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/students/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/students/home/{$all}/"));
        $pager->pager($students->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Alunos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/students/home", [
            "app" => "students/home",
            "head" => $head,
            "search" => $search,
            "students" => $students->order("first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     */
    public function news(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/students/home/{$s}/1")]);
            return;
        }

        $search = null;
        $students = (new Student())->find("status = 'pending'");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $students = (new Student())->find("status = 'pending' AND MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$students->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/students/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/students/home/{$all}/"));
        $pager->pager($students->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Alunos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/students/home", [
            "app" => "students/home",
            "head" => $head,
            "search" => $search,
            "students" => $students->order("first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function student(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            $studentCreate = new Student();
            $studentCreate->user_id = $data["teacher"]; 
            $studentCreate->first_name = $data["first_name"];
            $studentCreate->last_name = $data["last_name"];
            $studentCreate->email = $data["email"];
            $studentCreate->datebirth = date_fmt_back($data["datebirth"]);
            $studentCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $studentCreate->status = $data["status"];
            $studentCreate->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $studentCreate->state = $data["state"];
            $studentCreate->city = $data["city"];
            $studentCreate->address = $data["address"];
            $studentCreate->neighborhood = $data["neighborhood"];
            $studentCreate->number = $data["number"];
            $studentCreate->complement = $data["complement"];
            $studentCreate->phone = $data["phone"];
            $studentCreate->graduation = $data["graduation"];
            $studentCreate->description = $data["description"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $studentCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $studentCreate->photo = $image;
            }

            if (!$studentCreate->save()) {
                $json["message"] = $studentCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $hbelt = (new HistoricBelt());
            $hbelt->student_id = $studentCreate->id;
            $hbelt->graduation_id = $data["graduation"];
            $hbelt->description = "Definido ao cadastrar aluno";
            $hbelt->save();
            
            $this->message->success("Aluno cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/students/student/{$studentCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $studentUpdate = (new Student())->findById($data["student_id"]);

            if (!$studentUpdate) {
                $this->message->error("Você tentou gerenciar um aluno que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/home")]);
                return;
            }

            $studentUpdate->first_name = $data["first_name"];
            $studentUpdate->last_name = $data["last_name"];
            $studentUpdate->email = $data["email"];
            $studentUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $studentUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $studentUpdate->status = $data["status"];
            $studentUpdate->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $studentUpdate->state = $data["state"];
            $studentUpdate->city = $data["city"];
            $studentUpdate->address = $data["address"];
            $studentUpdate->neighborhood = $data["neighborhood"];
            $studentUpdate->number = $data["number"];
            $studentUpdate->complement = $data["complement"];
            $studentUpdate->phone = $data["phone"];
            $studentUpdate->graduation = $data["graduation"];
            $studentUpdate->description = $data["description"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($studentUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$studentUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$studentUpdate->photo}");
                    (new Thumb())->flush($studentUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $studentUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $studentUpdate->photo = $image;
            }

            if (!$studentUpdate->save()) {
                var_dump($studentUpdate->fail());
                $json["message"] = $studentUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Aluno atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $userDelete = (new User())->findById($data["student_id"]);

            if (!$userDelete) {
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/home")]);
                return;
            }

            if ($userDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}");
                (new Thumb())->flush($userDelete->photo);
            }

            $userDelete->destroy();

            $this->message->success("O Aluno foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/students/home")]);

            return;
        }

        $studentEdit = null;
        if (!empty($data["student_id"])) {
            $studentId = filter_var($data["student_id"], FILTER_VALIDATE_INT);
            $studentEdit = (new Student())->findById($studentId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($studentEdit ? "Perfil de {$studentEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/students/student", [
            "app" => "students/student",
            "head" => $head,
            "student" => $studentEdit,
            "graduations" => (new Belt())->find()->order("id")->fetch(true),
            "teachers" => (new User())->find("level < :l", "l=5")->order("id")->fetch(true)
        ]);
    }
}