<?php

namespace Source\App\App;

use Source\Models\App\AppPayments;
use Source\Models\App\AppTransfers;
use Source\Models\HistoricBelt;
use Source\Models\User;
use Source\Support\Upload;
use Source\Models\Belt;
use Source\Models\App\AppStudent;
use stdClass;

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

        //Realiza as renovações
        if (!empty($data["action"]) && $data["action"] == "payment") {
            $student_id = $data["student_id"];

            $student = (new AppStudent())->find("user_id = :ud AND id = :id", "ud={$this->user->id}&id={$student_id}")->fetch();
            if(!$student){
                echo json_encode([
                    "message" => $this->message->warning("Estudante informado não existe")->render()
                ]);
                return;
            }
            if($data["type"] == "create"){
                $historic = (new AppPayments());
                $historic->user_id = $this->user->id;
                $historic->student_id = $student_id;
                $historic->save();
                
            }

            if($data["type"] == "cancel"){
                $historics = (new AppPayments())->find("user_id = :ud AND student_id = :si AND status = :s","ud={$this->user->id}&si={$student_id}&s=pending")->fetch(true);
                foreach ($historics as $historic) {
                    $historic->destroy();
                }
            }

            echo json_encode([
                "renewal" => true
            ]);
            return;
        }

        if (!empty($data["action"]) && $data["action"] == "transfer") {
            $transfer_id = $data["transfer_id"];
            
            $transfer = (new AppTransfers())->find("id_from = :f AND id = :id", "f={$this->user->id}&id={$transfer_id}")->fetch();
            if(!$transfer){
                echo json_encode([
                    "message" => $this->message->warning("Tranferencia informada não encontrada")->render()
                ]);
                return;
            }

            if($data["type"] == "approved"){
                $student = (new AppStudent())->findById($transfer->student_id);
                if(!$student){
                    echo json_encode([
                        "message" => $this->message->warning("O Aluno informado não foi encontrado")->render()
                    ]);
                    return;
                }

                $student->user_id = $this->user->id; 
                $student->dojo = $transfer->dojo;

                if(!$student->save()){
                    $student->message()->flash();
                    echo json_encode(["reload" => true]);
                    return;
                }

                $transfer->status = "approved";
                $transfer->save();
                
                $this->message->success("Tranferência aprovada com sucesso...")->flash();
                echo json_encode(["reload" => true]);
                return;                
            }else{
                if(!$transfer->destroy()){
                    $transfer->message()->flash();
                    echo json_encode(["reload" => true]);
                    return;
                }

                $this->message->success("Tranferência reprovada com sucesso...")->flash();
                echo json_encode(["reload" => true]);
                return;
            }

        }

        if (!empty($data["action"]) && !empty($data["type"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);

            #cadastra faixa preta
            if($data["type"] == "black"){
                $graduation = (new Belt())->findById($data["graduation"]);
                $studentCreate = new AppStudent();
                $studentCreate->type = "black";

                if(!empty($graduation->graduation_time)){
                    $studentCreate->next_graduation = date("Y-m-d", strtotime("+{$graduation->graduation_time} years"));
                }
            }else{
                #cadastra faixa Kyus
                $studentCreate = new AppStudent();
                $studentCreate->type = "kyus";
                if(!empty($data["mother_name"])){
                    $studentCreate->mother_name = $data["mother_name"];
                }
            }

            $studentCreate->email = $data["email"];
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
            $studentCreate->status = "pending";

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

            if(!empty($data["belt"]) || !empty($data["date"])){
                if (count($data["belt"]) !== count($data["date"])) {
                    $json["message"] = $this->message->warning("A quantidade de Graduações passadas informadas não confere com a quantidade de datas")->render();
                    echo json_encode($json);
                    return;
                }

                for ($i = 0; $i < count($data["date"]); $i++) {
                    $date = $data["date"][$i];

                    // 1. Converter a data para um objeto DateTime
                    $dateObj = \DateTime::createFromFormat('Y-m-d', $date); // Ajuste o formato se necessário

                    if ($dateObj === false) {
                        $json["message"] = $this->message->warning("Formato de data inválido: " . $date)->render();
                        echo json_encode($json);
                        return;
                    }

                    // 2. Obter a data de ontem
                    $yesterday = new \DateTime('now');

                    // 3. Comparar as datas
                    if ($dateObj > $yesterday) {
                        $json["message"] = $this->message->warning("A data " . $date . " é posterior a ontem.")->render();
                        echo json_encode($json);
                        return;
                    }
                }
            }

            //Cadastra o aluno
            if (!$studentCreate->save()) {
                $json["message"] = $studentCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $gErros = [];
            $hbelIdSaves = [];
            //Cadastra o historico de graduação
            if (count($data["belt"]) === count($data["date"])) {
                $register = false;
                $graduationAtual = (new Belt())->findById($data["graduation"]);

                for ($i = 0; $i < count($data["belt"]); $i++) {
                    $graduation = (new Belt())->findById($data["belt"][$i]);
                    $hbelt = (new HistoricBelt());

                    if($data["type"] == "black"){
                        $hbelt->black_belt_id = $studentCreate->id;
                    }else{
                        $hbelt->kyus_id = $studentCreate->id;
                    }

                    if($graduationAtual->type_student == "black"){
                        if($graduation->type_student == "black"){
                            //Verifica position
                            if(!empty($graduationAtual->position) && $graduation->position >= $graduationAtual->position){
                                $gErros[] = [
                                    "erro" => "A gradução '{$graduation->title}' não pode ser superior ao atual"
                                ];
                                break;
                            }
                        }
                        $register = true;
                    }else{
                        if($graduation->type_student == "black"){
                            $gErros[] = [
                                "erro" => "A gradução '{$graduation->title}' não pode ser usado para alunos kyus"
                            ];
                            break;
                        }

                        if(!empty($graduationAtual->position) && $graduation->position >= $graduationAtual->position && $graduation->age_range == $graduationAtual->age_range){
                            $gErros[] = [
                                "erro" => "A gradução '{$graduation->title}' não pode ser superior ao atual"
                            ];
                            break;
                        }

                        $register = true;
                    }

                    if($register){
                        $hbelt->graduation_id = $data["belt"][$i];
                        $hbelt->status = "approved";
                        $hbelt->description = "Histórico inserido pelo Instrutor {$this->user->fullName()}, na data de ";
                        $hbelt->graduation_data = $data["date"][$i];
                        $hbelt->save();
                        $hbelIdSaves[] = $hbelt->id;
                    }
                }
            }

            //Exlui os historicos cadastrados se existir algum erro
            if(!empty($gErros) && !empty($hbelIdSaves)){
                foreach($hbelIdSaves as $hbelIdSave){
                    $graduationRemove = (new HistoricBelt())->findById($hbelIdSave);
                    $graduationRemove->destroy();
                }

                //Exclui usuario;
                $studentCreate->destroy();
            }

            //Mostrar os erros
            if(!empty($gErros)){
                //Exclui usuario;
                $studentCreate->destroy();

                $msg = "";
                foreach($gErros as $gErro){
                    $msg .= $this->message->error($gErro["erro"])->render();
                }
                $json["message"] = $msg;
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
            $hbelt->status = "approved";
            $hbelt->description = "Cadastro inserido pelo Instrutor {$this->user->fullName()}, na data de ";
            $hbelt->graduation_data = date("Y-m-d");
            $hbelt->save();

            $this->message->success("Aluno cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/app/alunos/{$data["type"]}");
            echo json_encode($json);
            return;
        }
        
        if ((!empty($data["action"]) && $data["action"] == "update") && !empty($data["id"])) {
            #cadastra faixa preta
            if($data["type"] == "black"){
                $student = (new AppStudent())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();
            }else{
                #cadastra faixa Kyus
                $student = (new AppStudent())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();;
                if(!empty($data["mother_name"])){
                    $student->mother_name = $data["mother_name"];
                }
            }

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

            if(!empty($data["belt"]) || !empty($data["date"])){
                if (count($data["belt"]) !== count($data["date"])) {
                    $json["message"] = $this->message->warning("A quantidade de Graduações passadas informadas não confere com a quantidade de datas")->render();
                    echo json_encode($json);
                    return;
                }

                for ($i = 0; $i < count($data["date"]); $i++) {
                    $date = $data["date"][$i];

                    // 1. Converter a data para um objeto DateTime
                    $dateObj = \DateTime::createFromFormat('Y-m-d', $date); // Ajuste o formato se necessário

                    if ($dateObj === false) {
                        $json["message"] = $this->message->warning("Formato de data inválido: " . $date)->render();
                        echo json_encode($json);
                        return;
                    }

                    // 2. Obter a data de ontem
                    $yesterday = new \DateTime('now');

                    // 3. Comparar as datas
                    if ($dateObj > $yesterday) {
                        $json["message"] = $this->message->warning("A data " . $date . " é posterior a ontem.")->render();
                        echo json_encode($json);
                        return;
                    }
                }
            }
            
            //Cadastrar o aluno
            if (!$student->save()) {
                $json["message"] = $student->message()->render();
                echo json_encode($json);
                return;
            }

            $gErros = [];
            $hbelIdSaves = [];
            //Cadastra o historico de graduação
            if (count($data["belt"]) === count($data["date"])) {
                $register = false;
                $graduationAtual = $student->getLastGraduation();
                for ($i = 0; $i < count($data["belt"]); $i++) {
                    $graduation = (new Belt())->findById($data["belt"][$i]);
                    $hbelt = (new HistoricBelt());

                    if($data["type"] == "black"){
                        $hbelt->black_belt_id = $student->id;
                    }else{
                        $hbelt->kyus_id = $student->id;
                    }

                    if($graduationAtual->type_student == "black"){
                        if($graduation->type_student == "black"){
                            //Verifica position
                            if(!empty($graduationAtual->position) && $graduation->position >= $graduationAtual->position){
                                $gErros[] = [
                                    "erro" => "A gradução '{$graduation->title}' não pode ser superior ao atual"
                                ];
                            }
                        }
                        $register = true;
                    }else{
                        if($graduation->type_student == "black"){
                            $gErros[] = [
                                "erro" => "A gradução '{$graduation->title}' não pode ser usado para alunos kyus"
                            ];
                            break;
                        }

                        if(!empty($graduationAtual->position) && $graduation->position >= $graduationAtual->position && $graduation->age_range == $graduationAtual->age_range && $graduationAtual->type_student == "black"){
                            $gErros[] = [
                                "erro" => "A gradução '{$graduation->title}' não pode ser superior ao atual"
                            ];
                            break;
                        }

                        $register = true;
                    }

                    if($register){
                        $hbelt->graduation_id = $data["belt"][$i];
                        $hbelt->status = "approved";
                        $hbelt->description = "Histórico inserido pelo Instrutor {$this->user->fullName()}, na data de ";
                        $hbelt->graduation_data = $data["date"][$i];
                        $hbelt->save();
                        $hbelIdSaves[] = $hbelt->id;
                    }
                }
            }

            //Exlui os historicos cadastrados se existir algum erro
            if(!empty($gErros) && !empty($hbelIdSaves)){
                foreach($hbelIdSaves as $hbelIdSave){
                    $graduationRemove = (new HistoricBelt())->findById($hbelIdSave);
                    $graduationRemove->destroy();
                }
            }

            //Mostrar os erros
            if(!empty($gErros)){
                $msg = "";
                foreach($gErros as $gErro){
                    $msg .= $this->message->error($gErro["erro"])->render();
                }
                $json["message"] = $msg;
                echo json_encode($json);
                return;
            }

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

        //Pesquisa os estuantes
        $students = (new AppStudent())->find("user_id = :user AND type = :type",
        "user={$this->user->id}&type={$data["type"]}")->order("first_name asc")->fetch(true);

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
        
        if($data["type"] == "black"){
            $type = "black";
        }else{
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
        if($data["action"] == "update-reverse"){
            if($data["type"] == "black"){
                $studentUpdate = (new AppStudent())->find("id = :id AND user_id = :u","id={$data["id"]}&u={$this->user->id}")->fetch();   
                $historics = (new HistoricBelt())->find("black_belt_id = :h AND status = 'pending'", "h={$studentUpdate->id}")->fetch(true);                  
            }else{
                #atualizar faixa Kyus
                $studentUpdate = (new AppStudent())->find("id = :id AND user_id = :u","id={$data["id"]}&u={$this->user->id}")->fetch(); 
                $historics = (new HistoricBelt())->find("kyus_id = :k AND status = 'pending'", "k={$studentUpdate->id}")->fetch(true);
            }

            if (!$studentUpdate) {
                $json["message"] = $this->message->warning("O aluno informado não foi encontrado")->render();
                echo json_encode($json);
                return;
            }

            if(!empty($historics)){
                foreach($historics as $historic){
                    $historic->destroy();
                }
            }

            $this->message->success("Graduação reprovada com sucesso...")->flash();
            $json["renewal"] = true;
            echo json_encode($json);
            return;
        }

        if($data["action"] == "update-graduation"){
            //update-graduation
            $student = (new AppStudent())->find("user_id = :user AND id = :id",
            "user={$this->user->id}&id={$data["id"]}")->fetch();
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

            $dataNascimento = new \DateTime($student->datebirth);
            $dataAtual = new \DateTime();
            $diferenca = $dataAtual->diff($dataNascimento);

            if($diferenca->y < 13){
                $type_age = 1;
            }else{
                $type_age = 2;
            }

            //Consulta ultima graduação
            $findGraduation = $student->getLastGraduation();

            if (!$findGraduation) {
                $json["message"] = $this->message->warning("A graduação do usuário não foi encontrada")->render();
                echo json_encode($json);
                return;
            }

            
            if($findGraduation->title == "Sem graduação IOGKF"){
                $nextGraduation = new stdClass();
                $nextGraduation->id = $data["graduation"];
            }else{
                $newGraduation = $findGraduation->position + 1;
                $nextGraduation = (new Belt())->find("age_range = :a AND position = :p","a={$type_age}&p={$newGraduation}")->limit(1)->fetch();
                
                if (!$nextGraduation) {
                    $json["message"] = $this->message->warning("Não foi encontrar uma proxima graduação para o usuário")->render();
                    echo json_encode($json);
                    return;
                }
            }

            $hbelt = (new HistoricBelt());
            if($data["type"] == "black"){
                $hbelt->black_belt_id = $student->id;
            }else{
                $hbelt->kyus_id = $student->id;
            }
            
            $hbelt->graduation_id = $nextGraduation->id;
            $hbelt->description = "Graduação realizada pelo usuário: {$this->user->email}";
            $hbelt->date = $data["date"];
            $hbelt->save();

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, A Graduação do aluno foi enviada com sucesso!")->render();
            $json["renewal"] = true;
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }
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
            $student = (new AppStudent())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["id"]}")->fetch();
        }else{
            $student = (new AppStudent())->find("user_id = :user AND id = :id",
                    "user={$this->user->id}&id={$data["id"]}")->fetch();
        }

        if (!$student) {
            $this->message->error("Ooops! Você tentou acessar um aluno que não existe")->flash();
            redirect("/app");
        }

        if($data["type"] == "black"){
            $belts = (new Belt())
                ->find("title LIKE '%dan%'")
                ->order("graduation_data ASC")
                ->fetch(true);
        }else{
            $belts = (new Belt())
            ->find("title NOT LIKE '%dan%'")
                ->order("graduation_data ASC")
                ->fetch(true);
        }
        echo $this->view->render("widgets/students/detail", [
            "head" => $head,
            "student" => $student,
            "type" => $data["type"],
            "belts" => $belts,
            "teachers" => (new User())->find("level != 5")->fetch(true)
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