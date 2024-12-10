<?php

namespace Source\App\Admin;

use Source\Models\App\AppStudent;
use Source\Models\User;
use Source\Models\HistoricBelt;
use Source\Models\Belt;
use Source\Models\App\AppBlackBelt;
use Source\Models\App\AppKyus;

/**
 * Class Renewals
 * @package Source\App\Admin
 */
class Renewals extends Admin
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
    public function student(?array $data): void
    {
        //update graduation
        if (!empty($data["action"]) && $data["action"] == "update_graduation") {
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if(empty($data["type_student"])){
                $json["message"] = $this->message->warning("Informe o tipo de aluno")->render();
                echo json_encode($json);
                return;
            }

            #atualizar faixa preta
            if($data["type_student"] == "black"){
                $studentUpdate = (new AppBlackBelt())->findById($data["student_id"]);                
            }else{
                #atualizar faixa Kyus
                $studentUpdate = (new AppKyus())->findById($data["student_id"]);
            }

            if (!$studentUpdate) {
                $json["message"] = $this->message->warning("O aluno informado não foi encontrado")->render();
                echo json_encode($json);
                return;
            }
            
            $dataNascimento = new \DateTime($studentUpdate->datebirth);
            $dataAtual = new \DateTime();
            $diferenca = $dataAtual->diff($dataNascimento);

            if($diferenca->y < 13){
                $type_age = 1;
            }else{
                $type_age = 2;
            }

            
            //Consulta graduação
            $findGraduation = (new Belt())->findById($studentUpdate->graduation);
            if (!$findGraduation) {
                $json["message"] = $this->message->warning("A graduação do usuário não foi encontrada")->render();
                echo json_encode($json);
                return;
            }

            if(empty($findGraduation->position)){
                if($data["type_student"] == "black"){
                    $findGraduation = (new Belt())->find("type_student = :t","t=black")->order("position ASC")->limit(1)->fetch();
                    var_dump($findGraduation);
                }else{
                    $findGraduation = (new Belt())->find("age_range = :a AND type_student = :t","a={$type_age}&t=kyus")->order("position ASC")->limit(1)->fetch();
                }
                $newGraduation = $findGraduation->position;
            }else{
                $newGraduation = $findGraduation->position + 1;
            }

            $nextGraduation = (new Belt())->find("age_range = :a AND position = :p","a={$type_age}&p={$newGraduation}")->limit(1)->fetch();
            
            if (!$nextGraduation) {
                $json["message"] = $this->message->warning("Não foi eonctrada uma proxima graduação para o usuário")->render();
                echo json_encode($json);
                return;
            }

            if($data["type_action"] == "approved"){
                if($nextGraduation->type_student == "black"){
                    $studentUpdate = (new AppStudent())->findById($data["student_id"]);
                    $studentUpdate->type = "black";
                }

                $studentUpdate->graduation = $nextGraduation->id;
                $studentUpdate->status = "activated";

                //Se o aluno for black e tiver tempo na graduação deve-se alterar next_graduation
                if($nextGraduation->type_student == "black"){
                    if(!empty($nextGraduation->graduation_time)){
                        $studentUpdate->next_graduation = date("Y-m-d", strtotime("+{$nextGraduation->graduation_time} years"));
                    }
            
                }

                if($studentUpdate->save()){
                    if($nextGraduation->type_student == "black"){
                        $historics = (new HistoricBelt())->find("black_belt_id = :h AND status = 'pending'", "h={$studentUpdate->id}")->fetch(true);     
                    }else{
                        #atualizar faixa Kyus
                        $historics = (new HistoricBelt())->find("kyus_id = :k AND status = 'pending'", "k={$studentUpdate->id}")->fetch(true); 
                    }

                    if(!empty($historics)){
                        foreach($historics as $historic){
                            $historic->status = "approved";
                            $historic->save();
                        }
                    }
                }
                $this->message->success("Graduação aprovada com sucesso...")->flash();
            }else{
                $studentUpdate->status = "activated";
                if($studentUpdate->save()){
                    if($data["type_student"] == "black"){
                        $historics = (new HistoricBelt())->find("black_belt_id = :h AND status = 'pending'", "h={$studentUpdate->id}")->fetch(true);     
                    }else{
                        #atualizar faixa Kyus
                        $historics = (new HistoricBelt())->find("kyus_id = :k AND status = 'pending'", "k={$studentUpdate->id}")->fetch(true); 
                    }

                    if(!empty($historics)){
                        foreach($historics as $historic){
                            $historic->destroy();
                        }
                    }
                }
                $this->message->success("Graduação reprovada com sucesso...")->flash();
            }
            echo json_encode(["reload" => true]);
            return;
        }

        $list = (new AppStudent())->find()->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Alunos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
        echo $this->view->render("widgets/renewals/home", [
            "app" => "renewals/home",
            "head" => $head,
            "students" => $list,
        ]);
    }

    /**
     * @param array|null $data
     */
    public function instruncto(?array $data): void
    {
        $list = (new User())->find("level != 5")->fetch(true);
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Professores",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/renewals/home", [
            "app" => "renewals/home",
            "head" => $head,
            "students" => $list,
        ]);
    }
}