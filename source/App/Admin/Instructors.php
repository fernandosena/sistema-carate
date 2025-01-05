<?php

namespace Source\App\Admin;

use Source\Models\App\AppPayments;
use Source\Models\App\AppStudent;
use Source\Models\Belt;
use Source\Models\HistoricBelt;
use Source\Models\User;
use Source\Support\Thumb;
use Source\Support\Upload;

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

        $users = (new User())->find("level < :l", "l=5")->fetch(true);

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
            "users" => $users,
        ]);
    }

    public function profile(?array $data): void
    {

        $userId = filter_var($data["instructor_id"], FILTER_VALIDATE_INT);
        $user = (new User())->findById($userId);

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Perfil",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        $graduations = (new Belt())->find("title LIKE '%IOGKF%'  OR title LIKE '%dan%'")->fetch(true);
        echo $this->view->render("widgets/instructors/profile", [
            "app" => "users/home",
            "head" => $head,
            "user" => $user,
            "form" => [
                "url" => url("admin/instructors/instructor/{$user->id}"),
                "graduations" => $graduations,
                "data" => $user
            ],
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

            $graduation = (new Belt())->findById($data["graduation"]);
            
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
            if(!empty($graduation->graduation_time)){
                $userCreate->next_graduation = date("Y-m-d", strtotime("+{$graduation->graduation_time} years"));
            }
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
            $hbelt->status = "approved";
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
            $graduation = (new Belt())->findById($data["graduation"]);

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

            if($userUpdate->level != 5){
                $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            }
            
            $userUpdate->zip = preg_replace("/[^0-9]/", "", $data["zip"]);
            $userUpdate->state = $data["state"];
            $userUpdate->city = $data["city"];
            $userUpdate->address = $data["address"];
            $userUpdate->neighborhood = $data["neighborhood"];
            $userUpdate->number = $data["number"];
            $userUpdate->complement = $data["complement"];
            $userUpdate->phone = $data["phone"];

            if(!empty($graduation->graduation_time)){
                if($userUpdate->graduation != $data["graduation"]){
                    $userUpdate->next_graduation = date("Y-m-d", strtotime("+{$graduation->graduation_time} years"));
                }
            }
            
            $userUpdate->graduation = $data["graduation"];
            $userUpdate->status = $data["status"];

            if(!empty($userUpdate->dojo) && !empty($data["dojo"])){
                if($userUpdate->dojo != $data["dojo"]){
                    $dojodb = explode(",", $userUpdate->dojo);

                    $diferenca1 = implode(",", array_diff($dojodb, $data["dojo"]));

                    $student = (new AppStudent())->find("user_id = :id AND dojo IN (:dojo)", "id=$userUpdate->id,&dojo=$diferenca1");
                    if($student->count()){
                        $json["message"] = $this->message->warning("Não foi possivel atualizar pois já existe um estuante cadastrados no dojo retirado")->render();
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
        
        $graduations = (new Belt())->find("title LIKE '%IOGKF%'  OR title LIKE '%dan%'")->fetch(true);

        $payments = (new AppPayments())->find("user_id = :id", "id={$user->id}")->fetch(true);

        $date = date('Y-01-01');

        $all = (new AppStudent())->find("user_id = :id", "id={$user->id}");
        $dan = (new AppStudent())->find("user_id = :id AND type = :t", "id={$user->id}&t=black");
        $kyu1 = (new AppStudent())->query("SELECT * FROM app_students WHERE user_id = :id AND `type` = :t AND TIMESTAMPDIFF(YEAR, datebirth, '$date') < :y", "id={$user->id}&t=kyus&y=13");
        $kyu2 = (new AppStudent())->query("SELECT * FROM app_students WHERE user_id = :id AND `type` = :t AND TIMESTAMPDIFF(YEAR, datebirth, '$date') >= :y", "id={$user->id}&t=kyus&y=13");

        echo $this->view->render("widgets/instructors/instructor", [
            "app" => "users/user",
            "head" => $head,
            "user" => $user,
            "payments" => $payments,
            "form" => [
                "url" => url("admin/instructors/instructor/{$user->id}"),
                "graduations" => $graduations,
                "data" => $user
            ],
            "amount_month" => [
                "dan" => (new AppStudent())->quantityMonth('black', $user->id),
                "kyus1" => (new AppStudent())->quantityMonth('kyus', $user->id, "< 13"),
                "kyus2" => (new AppStudent())->quantityMonth('kyus', $user->id, ">= 13"),
            ],
            "table" => [
                "dan" => (new AppStudent())->table('black', $user->id),
                "kyus1" => (new AppStudent())->table('kyus', $user->id, "< 13"),
                "kyus2" => (new AppStudent())->table('kyus', $user->id, ">= 13"),
            ],
            "students" => [
                "all"=> [
                    "count" => $all->count(),
                    "data" => $all->fetch(true)
                ],
                "dan"=> [
                    "count" => $dan->count(),
                    "data" => $dan->fetch(true)
                ],
                "kyu1"=> [
                    "count" => $kyu1->count(),
                    "data" => $kyu1->fetch(true)
                ],
                "kyu2"=> [
                    "count" => $kyu2->count(),
                    "data" => $kyu2->fetch(true)
                ],
            ]
        ]);

    }
    
    public function payment(?array $data): void
    {
        if(empty($data['type'])){
            $json["message"] = $this->message->warning("O tipo do processso não foi informado")->render();
            echo json_encode($json);
            return;
        }

        if(empty($data['id'])){
            $json["message"] = $this->message->warning("O ID do pagamento não foi informado")->render();
            echo json_encode($json);
            return;
        }

        $payment = (new AppPayments())->findById($data['id']);
        if(empty($payment)){
            $json["message"] = $this->message->warning("O pagamento informado não foi encontrado")->render();
            echo json_encode($json);
            return;
        }

        if($data["type"] == 'activated'){
            $payment->status = 'activated';
            if(!$payment->save()){
                $json["message"] = $this->message->error("Não foi possivel atualizar o pagamento")->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Pagamento Atualizado com sucesso")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }else{
            if(!$payment->destroy()){
                $json["message"] = $this->message->error("Não foi possivel excluir o pagamento")->render();
                echo json_encode($json);
                return;
            }
            $this->message->success("Pagamento Excluido com sucesso")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }
    }
}