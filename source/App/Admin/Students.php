<?php

namespace Source\App\Admin;

use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;
use Source\Models\App\AppStudent;
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
        $students = (new AppStudent())->find("type = :t", "t={$data["type"]}")->fetch(true);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Alunos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/students/home", [
            "app" => "students/{$data["type"]}/home",
            "head" => $head,
            "type" => $data["type"],
            "students" => $students,
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
        $students = (new AppBlackBelt())->find("status = 'pending'");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $students = (new AppBlackBelt())->find("status = 'pending' AND MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
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
            "app" => "students/{$data["type"]}/home",
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

            if($data["type"] == "black"){
                $studentCreate = new AppBlackBelt();
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
            }else{
                $studentCreate = new AppKyus();
                $studentCreate->user_id = $data["teacher"]; 
                $studentCreate->first_name = $data["first_name"];
                $studentCreate->last_name = $data["last_name"];
                $studentCreate->datebirth = date_fmt_back($data["datebirth"]);
                $studentCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
                $studentCreate->graduation = $data["graduation"];
                $studentCreate->description = $data["description"];
            }

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
            $hbelt->description = "Definido ao cadastrar aluno";
            $hbelt->save();
            
            $this->message->success("Aluno cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/students/{$data["type"]}/student/{$studentCreate->id}");

            echo json_encode($json);
            return;
        }

        if (!empty($data["action"]) && $data["action"] == "payment") {
            $user_id = $data["user_id"];
            $student_id = $data["student_id"];

            $user = (new User())->findById(id: $user_id);
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

            $student->renewal = null;
            $student->last_renewal_data = date("Y-m-d");

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
        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            
            #atualizar faixa preta
            if($data["type"] == "black"){
                $studentUpdate = (new AppBlackBelt())->findById($data["student_id"]);
            }else{
                #atualizar faixa Kyus
                $studentUpdate = (new AppKyus())->findById($data["student_id"]);
            }

            if (!$studentUpdate) {
                $this->message->error("Você tentou gerenciar um aluno que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/{$data["type"]}/home")]);
                return;
            }

            #atualizar faixa preta
            if($data["type"] == "black"){
                $studentUpdate->user_id = $data["teacher"]; 
                $studentUpdate->first_name = $data["first_name"];
                $studentUpdate->last_name = $data["last_name"];
                $studentUpdate->email = $data["email"];
                $studentUpdate->datebirth = date_fmt_back($data["datebirth"]);
                $studentUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
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
                $studentUpdate->status = $data["status"];
            }else{
                #atualizar faixa Kyus
                $studentUpdate->user_id = $data["teacher"]; 
                $studentUpdate->first_name = $data["first_name"];
                $studentUpdate->last_name = $data["last_name"];
                $studentUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
                $studentUpdate->datebirth = date_fmt_back($data["datebirth"]);
                $studentUpdate->graduation = $data["graduation"];
                $studentUpdate->description = $data["description"];
                $studentUpdate->status = $data["status"];
            }

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

            if($data["type"] == "black"){
                $hbelt = (new HistoricBelt());
                $find = $hbelt->find("black_belt_id = :id AND graduation_id = :gid", "id={$studentUpdate->id}&gid={$data["graduation"]}")->count();
                
                if(!$find){
                    $hbelt->black_belt_id = $studentUpdate->id;
                    $hbelt->graduation_id = $data["graduation"];
                    $hbelt->description = "Alteração de graduação realizada pelo administrador";
                    $hbelt->save();
                }
            }else{
                $hbelt = (new HistoricBelt());
                $find = $hbelt->find("kyus_id = :id AND graduation_id = :gid", "id={$studentUpdate->id}&gid={$data["graduation"]}")->count();

                if(!$find){
                    $hbelt->kyus_id = $studentUpdate->id;
                    $hbelt->graduation_id = $data["graduation"];
                    $hbelt->description = "Alteração de graduação realizada pelo administrador";
                    $hbelt->save();
                }
            }

            $this->message->success("Aluno atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            #atualizar faixa preta
            if($data["type"] == "black"){
                $studentDelete = (new AppBlackBelt())->findById($data["student_id"]);
            }else{
                #atualizar faixa Kyus
                $studentDelete = (new AppKyus())->findById($data["student_id"]);
            }

            if (!$studentDelete) {
                $this->message->error("Você tentou remover um aluno que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/instructors/home")]);
                return;
            }

            $studentDelete->destroy();
            $this->message->success("Estudante excluído com sucesso...")->flash();

            echo json_encode(["redirect" => url("/admin/instructors/home")]);
            return;
        }

        //update graduation
        if (!empty($data["action"]) && $data["action"] == "update_graduation") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            
            $historic = (new HistoricBelt())->findById($data["historic_id"]);

            if (!$historic) {
                $this->message->error("Você tentou gerênciar um historico que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/{$data["type"]}/home")]);
                return;
            }

            #atualizar faixa preta
            if($data["type"] == "black"){
                $studentUpdate = (new AppBlackBelt())->findById($historic->black_belt_id);
            }else{
                #atualizar faixa Kyus
                $studentUpdate = (new AppKyus())->findById($historic->kyus_id);
            }
            
            if($data["type_action"] == "approved"){
                $studentUpdate->graduation = $historic->graduation_id;
                $studentUpdate->status = "activated";
                if($studentUpdate->save()){
                    $historic->status = "approved";
                    $historic->save();
                }
                $this->message->success("Graduação aprovada com sucesso...")->flash();
            }else{
                $studentUpdate->graduation = $historic->graduation_id;
                $studentUpdate->status = "activated";
                if($studentUpdate->save()){
                    $historic->status = "disapprove";
                    $historic->save();
                }
                $this->message->success("Graduação reprovada com sucesso...")->flash();
            }

            echo json_encode(["reload" => true]);
            return;
        }

        $studentEdit = null;
        if (!empty($data["student_id"])) {
            $studentId = filter_var($data["student_id"], FILTER_VALIDATE_INT);
            if($data["type"] == "black"){
                $studentEdit = (new AppBlackBelt())->findById($studentId);
            }else{
                $studentEdit = (new AppKyus())->findById($studentId);
            }
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($studentEdit ? "Perfil de {$studentEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        
        if($data["type"] == "black"){
            $graduations =(new Belt())->find("title LIKE '%dan%'")->order("title")->fetch(true);
        }else{
            $graduations =(new Belt())->find("title NOT LIKE '%dan%'")->order("title")->fetch(true);
        }

        echo $this->view->render("widgets/students/student", [
            "app" => "students/student",
            "head" => $head,
            "form" => [
                "url" => url("admin/students/{$data["type"]}/student/{$studentEdit->id}"),
                "graduations" => $graduations,
                "data" => $studentEdit,
                "type" => $data["type"],
                "teachers" => (new User())->find("level < :l", "l=5")->order("id")->fetch(true)
            ],
        ]);
    }
}