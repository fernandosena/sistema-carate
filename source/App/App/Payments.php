<?php

namespace Source\App\App;

use Source\Models\App\AppPayments;

/**
 * Class Payments
 * @package Source\App\App
 */
class Payments extends App
{
    /**
     * Students constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function pagamentos(?array $data): void
    {
        $head = $this->seo->render(
            "Pagamentos | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
        
        $payment = (new AppPayments())->find("user_id = :id", "id={$this->user->id}")->fetch(true);
        echo $this->view->render("widgets/pagamentos/home", [
            "head" => $head,
            "payments" => $payment
        ]);
    }

    public function pagamentosGerar(array $data): void
    {
        if (request_limit("apppix", 20, 60 * 2)) {
            $json["message"] = $this->message->warning("Foi muito rápido {$this->user->first_name}! Por favor aguarde 2 minutos para gerar um novo pix.")->render();
            echo json_encode($json);
            return;
        }

        //Gera PIX
        
        //Cadastra dados
        $valor = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        
        $payment = new AppPayments();
        $payment->user_id = $this->user->id;
        $payment->value = $valor;
        $payment->qtd_alunos = $data["students"];
        
        if (!$payment->save()) {
            var_dump($payment->fail());
            $json["message"] = $payment->message()->render();
            echo json_encode($json);
            return;
        }

        $json["message"] = $this->message->success("Tudo certo, seu PIX foi gerado com sucesso")->render();
        $json["pix"] = [
            "code" => 0,
            "qrCode" => 0
        ];
        echo json_encode($json);
    }
}