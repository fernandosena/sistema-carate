<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\Conf;
use Source\Models\User;
use Source\Support\Upload;

/**
 * Class Admin
 * @package Source\App\Admin
 */
class Admin extends Controller
{
    /**
     * @var \Source\Models\User|null
     */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/");

        $this->user = Auth::user(5);

        if (!$this->user || $this->user->level < 5) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/admin/login");
        }
    }

    public function conf(?array $data): void
    {
        $config = (new Conf());
        $find = $config->findById(1);
        if(empty($find)){
            $find = $config;
        }

        $find->title = $data["title"];
        $find->price = (!empty($data["price"]) ? str_replace([".", ","], ["", "."], $data["price"]) : 0);;

        if (!empty($_FILES["photo"])) {
            $files = $_FILES["photo"];
            $upload = new Upload();
            $image = $upload->image($files, "logo", 150);

            if (!$image) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }

            $find->logo = $image;
        }       
        
        if (!$find->save()) {
            $json["message"] = $find->message()->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Configurações salvas com sucesso...")->flash();
        $json["redirect"] = url("/admin/");
        echo json_encode($json);
        return;
    }

    public function getdojo(?array $data): void
    {
        $dados = [];
        if(!empty($data["valor"])){
            $dojo = (new User())->findById($data["valor"]);
            if(!empty($dojo)){
                $d = explode(",", $dojo->dojo);
                foreach ($d as $k => $v){
                    $dados[] = [
                        'id' => $v, 'nome' => $v
                    ];
                }
            }
        }
        echo json_encode($dados);
    }
}