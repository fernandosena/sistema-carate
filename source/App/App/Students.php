<?php

namespace Source\App\App;

use Source\Models\HistoricBelt;
use Source\Support\Upload;
use Source\Models\Student;
use Source\Models\Belt;

/**
 * Class Students
 * @package Source\App\App
 */
class Students extends App
{
    /**
     * Students constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function students(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            $studentCreate = new Student();
            $studentCreate->user_id = $this->user->id;
            $studentCreate->first_name = $data["first_name"];
            $studentCreate->last_name = $data["last_name"];
            $studentCreate->email = $data["email"];
            $studentCreate->document = $data["document"];
            $studentCreate->phone = $data["phone"];
            $studentCreate->belts = $data["belts"];
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
            $hbelt->belt_id = $data["belts"];
            $hbelt->description = "Definido ao cadastrar aluno";
            $hbelt->save();

            $this->message->success("Aluno cadastrado com sucesso...")->flash();
            // $json["redirect"] = url("/admin/users/user/{$studentCreate->id}");
            $json["redirect"] = url("/app/alunos");

            echo json_encode($json);
            return;
        }
        
        $head = $this->seo->render(
            "Meus Alunos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("widgets/students/home", [
            "user" => $this->user,
            "head" => $head,
            "students" => (new Student())->filter($this->user, "income", ($data ?? null)),
            "belts" => (new Belt())
                ->find()
                ->order("title")
                ->fetch(true),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "belt" => ($data["belt"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }
    /**
     * @param array $data
     */
    public function student(array $data): void
    {

        if (!empty($data["update"]) && !empty($data["id"])) {
            $student = (new Student())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();

            if (!$student) {
                $json["message"] = $this->message->error("Ooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            $student->first_name = $data["first_name"];
            $student->last_name = $data["last_name"];
            $student->email = $data["email"];
            $student->document = $data["document"];
            $student->phone = $data["phone"];
            $student->description = $data["description"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $student->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $student->photo = $image;
            }

            if (!$student->save()) {
                $json["message"] = $student->message()->render();
                echo json_encode($json);
                return;
            }

            $hbelt = (new HistoricBelt());
            $hbelt->student_id = $student->id;
            $hbelt->belt_id = $data["belts"];
            $hbelt->description = $data["description"];
            $hbelt->save();

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, O aluno foi atualizado com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Aluno - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $student = (new Student())->find("user_id = :user AND id = :id",
            "user={$this->user->id}&id={$data["id"]}")->fetch();

        if (!$student) {
            $this->message->error("Ooops! Você tentou acessar um aluno que não existe")->flash();
            redirect("/app");
        }

        echo $this->view->render("widgets/students/detail", [
            "head" => $head,
            "student" => $student,
            "belts" => (new Belt())
                ->find()
                ->order("title")
                ->fetch(true),
        ]);
    }

}