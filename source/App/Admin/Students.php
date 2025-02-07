<?php

namespace Source\App\Admin;

use Source\Models\App\AppPayments;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;
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
        if($data['instructor'] != "all"){
            $instructor = "user_id = {$data['instructor']} AND";
        }
        
        if($data["type"] != "black"){
            if($data['filter'] == 'maior'){
                $filter = " >= 13";
            }elseif($data['filter'] == 'menor'){
                $filter = " < 13";
            }

            $date = date('Y-01-01');
            $students = (new AppStudent())->query("SELECT * FROM app_students WHERE {$instructor} `type` = :t AND TIMESTAMPDIFF(YEAR, datebirth, '$date') $filter ORDER BY first_name ASC", "t={$data["type"]}")->fetch(true);
        }else{
            $students = (new AppStudent())->find("{$instructor} type = :t", "t={$data["type"]}")->order("first_name asc")->fetch(true);
        }


        $usersActive = [];
        $usersDebit = [];

        foreach($students as $student){
            $budges = false;
            $btnOptions = false;
            $lastPayment = $student->paymentsPendingLast();

            //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
            $paymentsActivatedLast = $student->paymentsActivatedLast();

            if(!$lastPayment){
                if($paymentsActivatedLast){
                    $budges = verify_renew($paymentsActivatedLast->created_at);
                }else{
                    $budges = verify_renew($student->created_at);
                }

                if($budges){
                    $btnOptions = true;
                }
            }

            if(!$budges && !$btnOptions){
                $usersDebit[] = $student;
            }else{
                $usersActive[] = $student;
            }
        }

        $students = array_merge($usersDebit, $usersActive);

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
        $students = (new AppStudent())->find("status = 'pending'");

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

    public function status(?array $data): void
    {
        if(empty($data['type'])){
            $json["message"] = $this->message->warning("O tipo do processso não foi informado")->render();
            echo json_encode($json);
            return;
        }

        if(empty($data['student_id'])){
            $json["message"] = $this->message->warning("O estudante não foi informado")->render();
            echo json_encode($json);
            return;
        }

        $student = (new AppStudent())->findById($data['student_id']);
        if(empty($student)){
            $json["message"] = $this->message->warning("O estudante informado não foi encontrado")->render();
            echo json_encode($json);
            return;
        }

        //Atualiza para pendente
        if($data["type"] == 'pending'){
            $student->status = 'pending';
        }else{
            $student->status = 'activated';            
        }

        if(!$student->save()){
            $json["message"] = $this->message->error("Não foi possivel atualizar aluno")->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Aluno Atualizado com sucesso")->flash();
        $json["reload"] = true;
        echo json_encode($json);
        return;
    }


    public function payment(?array $data): void
    {
        if(empty($data['type'])){
            $json["message"] = $this->message->warning("O tipo do processso não foi informado")->render();
            echo json_encode($json);
            return;
        }

        if(empty($data['id'])){
            $json["message"] = $this->message->warning("O iID do pagamento não foi informado")->render();
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

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function student(?array $data): void
    {
        if (!empty($data["action"]) && $data["action"] == "status") {
            $user_id = $data["user_id"];
            $student_id = $data["student_id"];
            $status = $data["status"];

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

            $student->status = $status;

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
 
            $studentUpdate = (new AppStudent())->findById($data["student_id"]);

            if (!$studentUpdate) {
                $this->message->error("Você tentou gerenciar um aluno que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/{$data["type"]}/home")]);
                return;
            }

            #atualizar faixa preta
            if($data["type"] == "black"){
                $graduation = (new Belt())->findById($data["graduation"]);

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

                if(!empty($graduation->graduation_time)){
                    if($studentUpdate->graduation != $data["graduation"]){
                        $studentUpdate->next_graduation = date("Y-m-d", strtotime("+{$graduation->graduation_time} years"));
                    }
                }
                
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
                $find = $hbelt->find("black_belt_id = :id OR  AND graduation_id = :gid", "id={$studentUpdate->id}&gid={$data["graduation"]}")->count();
                
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

            $studentDelete = (new AppStudent())->findById($data["student_id"]);

            if($data["type"] == "black"){
                $historics = (new HistoricBelt())->find("black_belt_id = :id", "id={$data["student_id"]}'")->fetch(true);
            }else{
                #atualizar faixa Kyus
                $historics = (new HistoricBelt())->find("kyus_id = :id", "id={$data["student_id"]}'")->fetch(true);
            }

            if (!$studentDelete) {
                $this->message->error("Você tentou remover um aluno que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/instructors/home")]);
                return;
            }

            if(!empty($historics)){
                foreach ($historics as $historic) {
                    $historic->destroy();
                }
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
            $studentUpdate = (new AppStudent())->findById($historic->black_belt_id ?? $historic->kyus_id);
            
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
                    $historic->destroy();
                }
                $this->message->success("Graduação reprovada com sucesso...")->flash();
            }

            echo json_encode(["reload" => true]);
            return;
        }

        //delete graduation
        if (!empty($data["action"]) && $data["action"] == "delete_graduation") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            
            $historic = (new HistoricBelt())->findById($data["historic_id"]);

            if (!$historic) {
                $this->message->error("Você tentou gerênciar um historico que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/students/{$data["type"]}/home")]);
                return;
            }
            
            if($historic->destroy()){
                $this->message->success("Graduação excluida com sucesso...")->flash();
            }else{
                $this->message->error("Erro ao excluir graduação")->flash();
            }

            echo json_encode(["reload" => true]);
            return;
        }

        $studentEdit = null;
        if (!empty($data["student_id"])) {
            $studentId = filter_var($data["student_id"], FILTER_VALIDATE_INT);
            $studentEdit = (new AppStudent())->findById($studentId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($studentEdit ? "Perfil de {$studentEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        
        if($data["type"] == "black"){
            $graduations =(new Belt())->find("title LIKE '%IOGKF%'  OR title LIKE '%dan (%'")->order("title")->fetch(true);
        }else{
            $graduations =(new Belt())->find("title NOT LIKE '%dan%'")->order("title")->fetch(true);
        }
        
        echo $this->view->render("widgets/students/student", [
            "app" => "students/student",
            "head" => $head,
            "payments" => (new AppPayments())->find("student_id = :id", "id={$data["student_id"]}")->fetch(true),
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