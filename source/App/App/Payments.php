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

        $valor = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);


        //Cadastra dados
        $paymentCreate = new AppPayments();
        $paymentCreate->user_id = $this->user->id;
        $paymentCreate->value = $valor;
        $paymentCreate->qtd_alunos = $data["students"];
        
        if (!$paymentCreate->save()) {
            var_dump($paymentCreate->fail());
            $json["message"] = $paymentCreate->message()->render();
            echo json_encode($json);
            return;
        }

        //Gera PIX
        $payer = [
            "first_name" => $this->user->first_name,
            "email"      => $this->user->email
        ];

        $informations = [
            "description"        => "Pagamento de {$this->user->fullName()}",
            "external_reference" => $paymentCreate->id,
            "transaction_amount" => (float) $valor,
            "payment_method_id"  => "pix"
        ];

        $payment = array_merge(["payer" => $payer], $informations);
        $payment = json_encode($payment);
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.mercadopago.com/v1/payments",
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => $payment,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.CONF_MERCADOPAGO_TOKEN,
                'Content-Type: application/json',
                'X-Idempotency-Key: '.$paymentCreate->id
            ]
        ]);
    
        // Resposta do Mercado Pago com os dados de pagamento.
        $response = curl_exec($curl);
        curl_close($curl);

        if($response){            
            $response = json_decode($response, true);
            $response = $response['point_of_interaction']['transaction_data'];
                        
            $json["message"] = $this->message->success("Tudo certo, seu PIX foi gerado com sucesso")->render();
            $json["pix"] = [
                "code" => $response['qr_code'],
                "qrCode" => $response['qr_code_base64']
            ];
        }else{
            $json["message"] = $this->message->error("Erro ao gerar PIX tente novamnete mais tarde")->render();            
        }
        echo json_encode($json);
    }
}