<?php

namespace Source\App\App;

use Source\Models\HistoricBelt;
use Source\Support\Upload;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;
use Source\Models\User;
use Source\Models\Belt;
use Source\Models\App\AppStudent;

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
        //search redirect
        if (isset($data["s"])) {
            if(!empty($data["s"])){
                $s = str_search($data["s"]);
                echo json_encode(["redirect" => url("/admin/users/home/{$s}/1")]);
                return;
            }
            echo json_encode(["redirect" => url("/app/alunos/home")]);
            return;
        }

        if (!empty($data["action"]) && $data["action"] == "payment") {
            $user_id = $data["user_id"];
            $student_id = $data["student_id"];

            $user = (new User())->findById($user_id);
            if(!$user){
                echo json_encode([
                    "message" => $this->message->warning("Usuario informado não existe")->render()
                ]);
                return;
            }

            $student = (new AppStudent())->findById($student_id);
            if(!$student){
                echo json_encode([
                    "message" => $this->message->warning("Estudante informado não existe")->render()
                ]);
                return;
            }

            $student->renewal = 'pending';
            $student->renewal_data = date("Y-m-d");

            if(!$student->save()){
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

        if (!empty($data["action"]) && !empty($data["type"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            #cadastra faixa preta
            if($data["type"] == "black"){
                $studentCreate = new AppBlackBelt();
                $studentCreate->email = $data["email"];
            }else{
                #cadastra faixa Kyus
                $studentCreate = new AppKyus();
                if(!empty($data["mother_name"])){
                    $studentCreate->mother_name = $data["mother_name"];
                }
            }

            $studentCreate->user_id = $this->user->id;
            $studentCreate->first_name = $data["first_name"];
            $studentCreate->last_name = $data["last_name"];
            $studentCreate->datebirth = date_fmt_back($data["datebirth"]);
            $studentCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
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
            $studentCreate->dojo = $data["dojo"];

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

            if($data["type"] == "black"){
                $hbelt->black_belt_id = $studentCreate->id;
            }else{
                $hbelt->kyus_id = $studentCreate->id;
            }

            $hbelt->graduation_id = $data["graduation"];
            $hbelt->status = "activated";
            $hbelt->description = "Definido ao cadastrar aluno - (Cadastrado por: {$this->user->email})";
            $hbelt->save();

            $this->message->success("Aluno cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/app/alunos/{$data["type"]}");
            echo json_encode($json);
            return;
        }
        
        if ((!empty($data["action"]) && $data["action"] == "update") && !empty($data["id"])) {
            $student = (new AppBlackBelt())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();

            if (!$student) {
                $json["message"] = $this->message->error("Ooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            $student->first_name = $data["first_name"];
            $student->last_name = $data["last_name"];
            $student->email = $data["email"];
            $student->datebirth = date_fmt_back($data["datebirth"]);
            $student->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $student->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $student->state = $data["state"];
            $student->city = $data["city"];
            $student->address = $data["address"];
            $student->neighborhood = $data["neighborhood"];
            $student->number = $data["number"];
            $student->complement = $data["complement"];
            $student->phone = $data["phone"];
            $student->description = $data["description"];
            $student->dojo = $data["dojo"];
            $student->status = $data["status"];

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

            if($data["type"] == "black"){
                $hbelt->black_belt_id = $student->id;
            }else{
                $hbelt->kyus_id = $student->id;
            }

            $hbelt->graduation_id = $data["graduation"];
            $hbelt->description = $data["description"];
            $hbelt->save();

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, O aluno foi atualizado com sucesso!")->render();
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

        if($data["type"] == "black"){
            $students = (new AppBlackBelt())->find("user_id = :user AND type = 'black'",
                "user={$this->user->id}}")->fetch(true);
            $type = "black";
        }else{
            $students = (new AppKyus())->find("user_id = :user AND type = 'kyus'",
                "user={$this->user->id}")->fetch(true);
            $type = "kyus";
        }

        echo $this->view->render("widgets/students/home", [
            "user" => $this->user,
            "head" => $head,
            "type" => $type,
            "students" => $students,
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

    public function belt(array $data): void
    {
        if($data["type"] == "black"){
            $student = (new AppBlackBelt())->find("user_id = :user AND id = :id",
        "user={$this->user->id}&id={$data["id"]}")->fetch();
        }else{
            $student = (new AppKyus())->find("user_id = :user AND id = :id",
        "user={$this->user->id}&id={$data["id"]}")->fetch();
        }

        if (!$student) {
            $json["message"] = $this->message->error("Ooops! aluno inrormado não encontrado")->render();
            echo json_encode($json);
            return;
        }

        if ($student->status == "pending") {
            $json["message"] = $this->message->warning("Ooops! aluno esta pendente, não pode ser alterado no momento. tente novamente mais tarde")->render();
            echo json_encode($json);
            return;
        }

        $student->status = "pending";

        // if (!$student->save()) {
        //     $json["message"] = $student->message()->render();
        //     echo json_encode($json);
        //     return;
        // }

        $dataNascimento = new \DateTime($student->datebirth);
        $dataAtual = new \DateTime();
        $diferenca = $dataAtual->diff($dataNascimento);

        if($diferenca->y < 13){
            $type_age = 1;
        }else{
            $type_age = 2;
        }

        //Consulta graduação
        $findGraduation = (new Belt())->findById($student->graduation);
        if (!$findGraduation) {
            $json["message"] = $this->message->warning("A graduação do usuário não foi encontrada")->render();
            echo json_encode($json);
            return;
        }

        $newGraduation = $findGraduation->position + 1;
        $nextGraduation = (new Belt())->find("age_range = :a AND position = :p","a={$type_age}&p={$newGraduation}")->limit(1)->fetch();
        
        if (!$nextGraduation) {
            $json["message"] = $this->message->warning("Não foi eonctrada uma proxima graduação para o usuário")->render();
            echo json_encode($json);
            return;
        }

        $hbelt = (new HistoricBelt());
        if($data["type"] == "black"){
            $hbelt->black_belt_id = $student->id;
        }else{
            $hbelt->kyus_id = $student->id;
        }
        
        $hbelt->graduation_id = $nextGraduation->id;
        $hbelt->description = "Graduação realizada pelo usuário: {$this->user->email}";
        $hbelt->save();

        $json["message"] = $this->message->success("Pronto {$this->user->first_name}, A Graduação do aluno foi atualizado com sucesso!")->render();
        $json["renewal"] = true;
        echo json_encode($json);
        return;
    }

    /**
     * @param array $data
     */
    public function student(array $data): void
    {
        $head = $this->seo->render(
            "Aluno - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
        

        if($data["type"] == "black"){
            $student = (new AppBlackBelt())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();
        }else{
            $student = (new AppKyus())->find("user_id = :user AND id = :id",
                    "user={$this->user->id}&id={$data["id"]}")->fetch();
        }

        if (!$student) {
            $this->message->error("Ooops! Você tentou acessar um aluno que não existe")->flash();
            redirect("/app");
        }

        if($data["type"] == "black"){
            $belts = (new Belt())
                ->find("title LIKE '%dan%'")
                ->order("title")
                ->fetch(true);
        }else{
            $belts = (new Belt())
            ->find("title NOT LIKE '%dan%'")
                ->order("title")
                ->fetch(true);
        }
        echo $this->view->render("widgets/students/detail", [
            "head" => $head,
            "student" => $student,
            "type" => $data["type"],
            "belts" => $belts
        ]);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function filter(array $data): void
    {
        $status = (!empty($data["status"]) ? $data["status"] : "all");
        $category = (!empty($data["belt"]) ? $data["belt"] : "all");

        $redirect = ($data["filter"] == "income" ? "receber" : "pagar");
        $json["redirect"] = url("/app/{$redirect}/{$status}/{$category}/");
        echo json_encode($json);
    }
}