<?php

namespace Source\App\Admin;

use Source\Core\Controller;
use Source\Models\Auth;
use Source\Models\User;

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

        $this->user = Auth::user();

        if (!$this->user || $this->user->level < 5) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/admin/login");
        }
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