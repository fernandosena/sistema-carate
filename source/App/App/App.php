<?php

namespace Source\App\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\App\AppArchives;
use Source\Models\App\AppPayments;
use Source\Models\App\AppTransfers;
use Source\Models\Auth;
use Source\Models\Belt;
use Source\Models\App\AppCategory;
use Source\Models\App\AppInvoice;
use Source\Models\App\AppOrder;
use Source\Models\App\AppPlan;
use Source\Models\App\AppSubscription;
use Source\Models\App\AppWallet;
use Source\Models\App\AppStudent;
use Source\Models\HistoricBelt;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;

/**
 * Class App
 * @package Source\App
 */
class App extends Controller
{
    /** @var User */
    protected $user;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }

        if($this->user->level == 5){
            Auth::logout();
            redirect("/admin");
        }
        
        (new Access())->report();
        (new Online())->report();

        (new AppWallet())->start($this->user);
        (new AppInvoice())->fixed($this->user, 3);

        $msg = false;
        $lastPayment = $this->user->paymentsPendingLast();
        //Verifica se existe um ultimo pagamento (oportunidade para cancelar)
        $paymentsActivatedLast = $this->user->paymentsActivatedLast();

        if(!$lastPayment){
            if($paymentsActivatedLast){
                $budges = verify_renew($paymentsActivatedLast->created_at);
            }else{
                $budges = verify_renew($this->user->created_at);
            }
            if($budges){
                $msg = true;
            }
        }

        if($msg){
            $this->message->info("IMPORTANTE: Atualize a sua filiação de instrutor! ")->after("<a href='".url("/app/regularization'")."'>Clique aqui</a>")->flash();
        }

        $data_obj = new \DateTime("now");
        $mes = $data_obj->format('m');;
        if($msg && ($mes >= 3)){
            $this->message->error("Usuário pendente para regularização, realize o pagamento")->flash();
            if(!str_contains($_SERVER["REQUEST_URI"], "regularization") && !str_contains($_SERVER["REQUEST_URI"], "sair")){
                redirect("app/regularization");
            }
        }
    }

    public function getBelts(?array $data): void
    {
        if($data["type"] == 'black'){
            $historicLast = (new HistoricBelt())->find("black_belt_id = :id AND status = 'approved'", "id={$data["id"]}")->order("graduation_data desc")->fetch();
        }else{
            $historicLast = (new HistoricBelt())->find("kyus_id = :id AND status = 'approved'", "id={$data["id"]}")->order("graduation_data desc")->fetch();
        }

        $belts = (new Belt())
        ->find()
        ->order("type_student ASC, age_range ASC, title DESC")
        ->fetch(true);

        $json = [];

        foreach ($belts as $belt) {
            $json[] = [
                "id" => $belt->id,
                "title" => $belt->title,
                "type_student" => $belt->type_student,
                "age_range" => $belt->age_range,
            ];
        };

        echo json_encode([
            "data" => $historicLast->graduation_data,
            "dados" => $json
        ]);
    }

    public function transfer(?array $data): void
    {
        if(!empty($data["dojo"]) && str_contains($data["dojo"], '|') && !empty($data["id"]) && !empty($data["type"])){

            $dados = explode("|", $data["dojo"]);

            //Consulta Aluno
            $student = (new AppStudent())->find("user_id = :uid AND id = :id", "uid={$this->user->id}&id={$data["id"]}")->fetch();
            if (!$student) {
                $json["message"] = $this->message->warning("O Aluno informado não foi encontrado")->render();
                echo json_encode($json);
                return;
            }

            //Consulta Instrutor
            $instructor = (new User())->findById($dados[0]);
            if (!$instructor) {
                $json["message"] = $this->message->warning("O Instrutor informado não foi encontrado")->render();
                echo json_encode($json);
                return;
            }

            //Consulta Dojo
            $dojos = explode(",", $instructor->dojo);
            if (!in_array($dados[1], $dojos)) {
                $json["message"] = $this->message->warning("O Sojo informado não foi encontrado")->render();
                echo json_encode($json);
                return;
            }

            //Verifica se tem um registro pendente de tranferencia desse usuário
            $transfer = (new AppTransfers())->find("student_id = :id AND status = 'pending'", "id={$data["id"]}")->fetch();
            if ($transfer) {
                $json["message"] = $this->message->warning("Esse aluno já foi tranferido")->render();
                echo json_encode($json);
                return;
            }
            
            //Cadastra tranferencia
            $transfer = (new AppTransfers());
            $transfer->id_of = $this->user->id;
            $transfer->id_from = $dados[0];
            $transfer->student_id = $data["id"];
            $transfer->dojo = $dados[1];
            $transfer->status = "pending";
            
            if (!$transfer->save()) {
                $json["message"] = $transfer->message()->before("Ooops! ")->render();
                echo json_encode($json);
                return;
            }
            
            $this->message->success("Aluno tranferido com sucesso, aguardando aprovação do instrutor")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        if(!empty($data['action'])){
            if($data["action"] == "cancel"){
                //Consulta Aluno na tabela de tranferencia
                $tranfer = (new AppTransfers())->find("id_of = :of AND student_id = :id AND status = 'pending'", "of={$this->user->id}&id={$data["student_id"]}")->fetch();
                if(!$tranfer->destroy()){
                    $json["message"] = $tranfer->message()->before("Ooops! ")->render();
                    echo json_encode($json);
                    return;
                }

                $this->message->success("Tranferencia cancelada com sucesso!")->flash();
                echo json_encode(["reload" => true]);
                return;
            }
        }

        $json["message"] = $this->message->error("Informe os dados solicitados antes de enviar")->render();
        echo json_encode($json);
    }

    public function documents(?array $data): void
    {
        $head = $this->seo->render(
            "Documentos " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
        echo $this->view->render("documents", [
            "head" => $head,
            "documents" => (new AppArchives())->find()->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function dash(?array $data): void
    {
        if (!empty($data["wallet"])) {
            $session = new Session();

            if ($data["wallet"] == "all") {
                $session->unset("walletfilter");
                echo json_encode(["filter" => true]);
                return;
            }

            $wallet = filter_var($data["wallet"], FILTER_VALIDATE_INT);
            $getWallet = (new AppWallet())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$wallet}")->count();

            if ($getWallet) {
                $session->set("walletfilter", $wallet);
            }

            echo json_encode(["filter" => true]);
            return;
        }

        //CHART UPDATE
        $chartData = (new AppInvoice())->chartData($this->user);
        $categories = str_replace("'", "", explode(",", $chartData->categories));
        $json["chart"] = [
            "categories" => $categories,
            "income" => array_map("abs", explode(",", $chartData->income)),
            "expense" => array_map("abs", explode(",", $chartData->expense))
        ];

        //WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        $wallet->wallet = str_price($wallet->wallet);
        $wallet->status = ($wallet->balance == "positive" ? "gradient-green" : "gradient-red");
        $wallet->income = str_price($wallet->income);
        $wallet->expense = str_price($wallet->expense);
        $json["wallet"] = $wallet;

        echo json_encode($json);
    }

    /**
     * APP HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            "Olá {$this->user->first_name}. Vamos controlar? - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        //CHART
        $chartData = (new AppStudent())->chartData($this->user);
        //END CHART

        //INCOME && EXPENSE
        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        $income = (new AppInvoice())
            ->find("user_id = :user AND type = 'income' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "user={$this->user->id}")
            ->order("due_at")
            ->fetch(true);

        $expense = (new AppInvoice())
            ->find("user_id = :user AND type = 'expense' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "user={$this->user->id}")
            ->order("due_at")
            ->fetch(true);
        //END INCOME && EXPENSE

        //WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        //END WALLET
        
        //STUDENTS
        $student = (new AppStudent())->find("user_id = :id", "id={$this->user->id}")->count();
        //END STUDENTS

        echo $this->view->render("home", [
            "head" => $head,
            "studentscount" => $student,
            "chart" => $chartData,
            "income" => $income,
            "expense" => $expense,
            "wallet" => $wallet,
            "notices" => (new AppStudent())
                ->find("mother_name IS NOT NULL AND TIMESTAMPDIFF(YEAR, datebirth, CURDATE()) >= 18")
                ->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function income(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas receitas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=income", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "income",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "income", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    public function getgraduation(?array $data): void
    {
        $dados = [];
        $valor = $data["valor"];

        if(!empty($valor)){
            if($valor < 13){
                $type_age = "age_range = 1 AND title NOT LIKE '%dan%'";
            }else{
                $type_age = "(age_range = 2 AND title NOT LIKE '%dan (%') OR title LIKE '%/%' OR title LIKE '%dan Jr%'";
            }

            $graduations = (new Belt())->find("({$type_age} OR position IS NULL)")->order("position ASC")->fetch(true);
            if(!empty($graduations)){
                foreach ($graduations as $graduation){
                    $dados[] = [
                        'id' => $graduation->id, 'nome' => $graduation->title
                    ];
                }
            }
        }
        echo json_encode($dados);
    }

    /**
     * @param array|null $data
     */
    public function expense(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=expense", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "expense",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "expense", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    /**
     *
     */
    public function fixed(): void
    {
        $head = $this->seo->render(
            "Minhas contas fixas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        echo $this->view->render("recurrences", [
            "head" => $head,
            "invoices" => (new AppInvoice())->find("user_id = :user AND type IN('fixed_income', 'fixed_expense') {$whereWallet}",
                "user={$this->user->id}")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function wallets(?array $data): void
    {
        //create
        if (!empty($data["wallet"]) && !empty($data["wallet_name"])) {

            //PREMIUM RESOURCE
            $subscribe = (new AppSubscription())->find("user_id = :user AND status != :status",
                "user={$this->user->id}&status=canceled");

            if (!$subscribe->count()) {
                $this->message->error("Desculpe {$this->user->first_name}, para criar novas carteiras é preciso ser PRO. Confira abaixo...")->flash();
                echo json_encode(["redirect" => url("/app/assinatura")]);
                return;
            }

            $wallet = new AppWallet();
            $wallet->user_id = $this->user->id;
            $wallet->wallet = filter_var($data["wallet_name"], FILTER_SANITIZE_SPECIAL_CHARS);
            $wallet->save();

            echo json_encode(["reload" => true]);
            return;
        }

        //edit
        if (!empty($data["wallet"]) && !empty($data["wallet_edit"])) {
            $wallet = (new AppWallet())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["wallet"]}")->fetch();

            if ($wallet) {
                $wallet->wallet = filter_var($data["wallet_edit"], FILTER_SANITIZE_SPECIAL_CHARS);
                $wallet->save();
            }

            echo json_encode(["wallet_edit" => true]);
            return;
        }

        //delete
        if (!empty($data["wallet"]) && !empty($data["wallet_remove"])) {
            $wallet = (new AppWallet())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["wallet"]}")->fetch();

            if ($wallet) {
                $wallet->destroy();
                (new Session())->unset("walletfilter");
            }

            echo json_encode(["wallet_remove" => true]);
            return;
        }

        $head = $this->seo->render(
            "Minhas carteiras - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $wallets = (new AppWallet())
            ->find("user_id = :user", "user={$this->user->id}")
            ->order("wallet")
            ->fetch(true);

        echo $this->view->render("wallets", [
            "head" => $head,
            "wallets" => $wallets
        ]);
    }

    
    /**
     * @param array $data
     */
    public function launch(array $data): void
    {
        if (request_limit("applaunch", 20, 60 * 5)) {
            $json["message"] = $this->message->warning("Foi muito rápido {$this->user->first_name}! Por favor aguarde 5 minutos para novos lançamentos.")->render();
            echo json_encode($json);
            return;
        }

        $invoice = new AppInvoice();

        $data["value"] = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        if (!$invoice->launch($this->user, $data)) {
            $json["message"] = $invoice->message()->render();
            echo json_encode($json);
            return;
        }

        $type = ($invoice->type == "income" ? "receita" : "despesa");
        $this->message->success("Tudo certo, sua {$type} foi lançada com sucesso")->flash();

        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function support(array $data): void
    {
        if (empty($data["message"])) {
            $json["message"] = $this->message->warning("Para enviar escreva sua mensagem.")->render();
            echo json_encode($json);
            return;
        }

        if (request_limit("appsupport", 3, 60 * 5)) {
            $json["message"] = $this->message->warning("Por favor, aguarde 5 minutos para enviar novos contatos, sugestões ou reclamações")->render();
            echo json_encode($json);
            return;
        }

        if (request_repeat("message", $data["message"])) {
            $json["message"] = $this->message->info("Já recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->render();
            echo json_encode($json);
            return;
        }

        $subject = date_fmt() . " - {$data["subject"]}";
        $message = "Mensagem enviada por: {$this->user->first_name} {$this->user->last_name} ({$this->user->email})\n\n";
        $message .= filter_var($data["message"], FILTER_SANITIZE_STRING);

        $view = new View(__DIR__ . "/../../../shared/views/email");
        $body = $view->render("mail", [
            "subject" => $subject,
            "message" => str_textarea($message)
        ]);

        (new Email())->bootstrap(
            $subject,
            $body,
            CONF_MAIL_SUPPORT,
            "Suporte " . CONF_SITE_NAME
        )->send();

        $this->message->success("Recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->flash();
        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     */
    public function onpaid(array $data): void
    {
        $invoice = (new AppInvoice())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
            ->fetch();

        if (!$invoice) {
            $this->message->error("Ooops! Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }

        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save();

        $y = date("Y");
        $m = date("m");
        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

        $json["onpaid"] = (new AppInvoice())->balanceMonth($this->user, $y, $m, $invoice->type);
        echo json_encode($json);
    }

    /**
     * @param array $data
     */
    public function invoice(array $data): void
    {
        if (!empty($data["update"])) {
            $invoice = (new AppInvoice())->find("user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["invoice"]}")->fetch();

            if (!$invoice) {
                $json["message"] = $this->message->error("Ooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            if ($data["due_day"] < 1 || $data["due_day"] > $dayOfMonth = date("t", strtotime($invoice->due_at))) {
                $json["message"] = $this->message->warning("O vencimento deve ser entre dia 1 e dia {$dayOfMonth} para este mês.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);
            $due_day = date("Y-m", strtotime($invoice->due_at)) . "-" . $data["due_day"];
            $invoice->category_id = $data["category"];
            $invoice->description = $data["description"];
            $invoice->due_at = date("Y-m-d", strtotime($due_day));
            $invoice->value = str_replace([".", ","], ["", "."], $data["value"]);
            $invoice->wallet_id = $data["wallet"];
            $invoice->status = $data["status"];

            if (!$invoice->save()) {
                $json["message"] = $invoice->message()->before("Ooops! ")->after(" {$this->user->first_name}.")->render();
                echo json_encode($json);
                return;
            }

            $invoiceOf = (new AppInvoice())->find("user_id = :user AND invoice_of = :of",
                "user={$this->user->id}&of={$invoice->id}")->fetch(true);

            if (!empty($invoiceOf) && in_array($invoice->type, ["fixed_income", "fixed_expense"])) {
                foreach ($invoiceOf as $invoiceItem) {
                    if ($data["status"] == "unpaid" && $invoiceItem->status == "unpaid") {
                        $invoiceItem->destroy();
                    } else {
                        $due_day = date("Y-m", strtotime($invoiceItem->due_at)) . "-" . $data["due_day"];
                        $invoiceItem->category_id = $data["category"];
                        $invoiceItem->description = $data["description"];
                        $invoiceItem->wallet_id = $data["wallet"];

                        if ($invoiceItem->status == "unpaid") {
                            $invoiceItem->value = str_replace([".", ","], ["", "."], $data["value"]);
                            $invoiceItem->due_at = date("Y-m-d", strtotime($due_day));
                        }

                        $invoiceItem->save();
                    }
                }
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, a atualização foi efetuada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Aluguel - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $invoice = (new AppInvoice())->find("user_id = :user AND id = :invoice",
            "user={$this->user->id}&invoice={$data["invoice"]}")->fetch();

        if (!$invoice) {
            $this->message->error("Ooops! Você tentou acessar uma fatura que não existe")->flash();
            redirect("/app");
        }

        echo $this->view->render("invoice", [
            "head" => $head,
            "invoice" => $invoice,
            "wallets" => (new AppWallet())
                ->find("user_id = :user", "user={$this->user->id}", "id, wallet")
                ->order("wallet")
                ->fetch(true),
            "categories" => (new AppCategory())
                ->find("type = :type", "type={$invoice->category()->type}")
                ->order("order_by, name")
                ->fetch(true)
        ]);
    }

    /**
     * @param array $data
     */
    public function remove(array $data): void
    {
        $invoice = (new AppInvoice())->find("user_id = :user AND id = :invoice",
            "user={$this->user->id}&invoice={$data["invoice"]}")->fetch();

        if ($invoice) {
            $invoice->destroy();
        }

        $this->message->success("Tudo pronto {$this->user->first_name}. O lançamento foi removido com sucesso!")->flash();
        $json["redirect"] = url("/app");
        echo json_encode($json);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {
        if (!empty($data["update"])) {
            $user = (new User())->findById($this->user->id);

            if($data["repassword"] != $data["password"]){
                $json["message"] = $this->message->warning("A senhas informadas não são iguais")->render();
                echo json_encode($json);
                return;
            }

            $user->password = $data["password"];
            
            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}. Seus dados foram atualizados com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
    }

    public function graduations(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas graduações - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("graduations", [
            "head" => $head,
            "historics" => $this->user->historic(),
        ]);
    }

    public function signature(?array $data): void
    {
        $head = $this->seo->render(
            "Assinatura - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("signature", [
            "head" => $head,
            "subscription" => (new AppSubscription())
                ->find("user_id = :user AND status != :status", "user={$this->user->id}&status=canceled")
                ->fetch(),
            "orders" => (new AppOrder())
                ->find("user_id = :user", "user={$this->user->id}")
                ->order("created_at DESC")
                ->fetch(true),
            "plans" => (new AppPlan())
                ->find("status = :status", "status=active")
                ->order("name, price")
                ->fetch(true)
        ]);
    }
    
    public function regularization(?array $data): void
    {
        $head = $this->seo->render(
            "Regularização - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $user = (new User())->findById($this->user->id);
        if(!$user){
            echo json_encode([
                "message" => $this->message->warning("Usuario informado não existe")->render()
            ]);
            return;
        }

        //Realiza as renovações
        if (!empty($data["action"]) && $data["action"] == "payment") {
            if($data["type"] == "create"){
                $historic = (new AppPayments());
                $historic->user_id = $this->user->id;
                $historic->instructor_id = $this->user->id;
                $historic->save();
            }

            if($data["type"] == "cancel"){
                $historics = (new AppPayments())->find("user_id = :ud AND instructor_id = :si AND status = :s","ud={$this->user->id}&si={$this->user->id}&s=pending")->fetch(true);
                foreach ($historics as $historic) {
                    $historic->destroy();
                }
            }

            echo json_encode([
                "reload" => true
            ]);
            return;
        }

        echo $this->view->render("regularization", [
            "head" => $head,
            "user" => $user
        ]);
    }


    /**
     * APP LOGOUT
     */
    public function logout(): void
    {
        $this->message->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/entrar");
    }
}