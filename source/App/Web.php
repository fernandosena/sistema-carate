<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\App\AppPayments;
use Source\Models\App\AppStudent;
use Source\Models\Auth;
use Source\Models\Category;
use Source\Models\Faq\Question;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Certificate;
use Source\Support\Pager;
use Source\Support\Upload;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");

        (new Access())->report();
        (new Online())->report();
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("home", [
            "head" => $head,
            "video" => "lDZGl9Wdc7Y",
        ]);
    }

    public function profile(array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            $user = (new User())->find("document = :d AND id = :id", "d={$data["document"]}&id={$data["user"]}")->fetch();
            if(!$user){
                $user = (new AppStudent())->find("document = :d AND id = :id", "d={$data["document"]}&id={$data["user"]}")->fetch();
            }

            if(!$user){
                $json['message'] = $this->message->warning("Usuário não encontrado")->render();
                echo json_encode($json);
                return;
            }

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $user->fullName(), 600);
                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $user->photo = $image;
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json['message'] = $this->message->success("Usuário Atualizado com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $json['message'] = $this->message->warning("Erro ao enviar, favor use o formulário")->render();
        echo json_encode($json);
        return;
    }

    /**
     * SITE ABOUT
     */
    public function about(): void
    {
        $head = $this->seo->render(
            "Descubra o " . CONF_SITE_NAME . " - " . CONF_SITE_DESC,
            CONF_SITE_DESC,
            url("/sobre"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("about", [
            "head" => $head,
            "video" => "lDZGl9Wdc7Y",
            "faq" => (new Question())
                ->find("channel_id = :id", "id=1", "question, response")
                ->order("order_by")
                ->fetch(true)
        ]);
    }

    /**
     * SITE BLOG
     * @param array|null $data
     */
    public function blog(?array $data): void
    {
        $head = $this->seo->render(
            "Blog - " . CONF_SITE_NAME,
            "Confira em nosso blog dicas e sacadas de como controlar melhorar suas contas. Vamos tomar um café?",
            url("/blog"),
            theme("/assets/images/share.jpg")
        );

        $blog = (new Post())->findPost();
        $pager = new Pager(url("/blog/p/"));
        $pager->pager($blog->count(), 9, ($data['page'] ?? 1));

        echo $this->view->render("blog", [
            "head" => $head,
            "blog" => $blog->order("post_at DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG CATEGORY
     * @param array $data
     */
    public function blogCategory(array $data): void
    {
        $categoryUri = filter_var($data["category"], FILTER_SANITIZE_SPECIAL_CHARS);
        $category = (new Category())->findByUri($categoryUri);

        if (!$category) {
            redirect("/blog");
        }

        $blogCategory = (new Post())->findPost("category = :c", "c={$category->id}");
        $page = (!empty($data['page']) && filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);
        $pager = new Pager(url("/blog/em/{$category->uri}/"));
        $pager->pager($blogCategory->count(), 9, $page);

        $head = $this->seo->render(
            "Artigos em {$category->title} - " . CONF_SITE_NAME,
            $category->description,
            url("/blog/em/{$category->uri}/{$page}"),
            ($category->cover ? image($category->cover, 1200, 628) : theme("/assets/images/share.jpg"))
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "Artigos em {$category->title}",
            "desc" => $category->description,
            "blog" => $blogCategory
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->order("post_at DESC")
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function blogSearch(array $data): void
    {
        if (!empty($data['s'])) {
            $search = str_search($data['s']);
            echo json_encode(["redirect" => url("/blog/buscar/{$search}/1")]);
            return;
        }

        $search = str_search($data['search']);
        $page = (filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);

        if ($search == "all") {
            redirect("/blog");
        }

        $head = $this->seo->render(
            "Pesquisa por {$search} - " . CONF_SITE_NAME,
            "Confira os resultados de sua pesquisa para {$search}",
            url("/blog/buscar/{$search}/{$page}"),
            theme("/assets/images/share.jpg")
        );

        $blogSearch = (new Post())->findPost("MATCH(title, subtitle) AGAINST(:s)", "s={$search}");

        if (!$blogSearch->count()) {
            echo $this->view->render("blog", [
                "head" => $head,
                "title" => "PESQUISA POR:",
                "search" => $search
            ]);
            return;
        }

        $pager = new Pager(url("/blog/buscar/{$search}/"));
        $pager->pager($blogSearch->count(), 9, $page);

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "PESQUISA POR:",
            "search" => $search,
            "blog" => $blogSearch->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG POST
     * @param array $data
     */
    public function blogPost(array $data): void
    {
        $post = (new Post())->findByUri($data['uri']);
        if (!$post) {
            redirect("/404");
        }

        $user = Auth::user();
        if (!$user || $user->level < 5) {
            $post->views += 1;
            $post->save();
        }

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE_NAME,
            $post->subtitle,
            url("/blog/{$post->uri}"),
            ($post->cover ? image($post->cover, 1200, 628) : theme("/assets/images/share.jpg"))
        );

        echo $this->view->render("blog-post", [
            "head" => $head,
            "post" => $post,
            "related" => (new Post())
                ->findPost("category = :c AND id != :i", "c={$post->category}&i={$post->id}")
                ->order("rand()")
                ->limit(3)
                ->fetch(true)
        ]);
    }

    public function student(?array $data){
        $student_id = $data["user_id"];
        $student = (new AppStudent())->findById($student_id);
        if(!$student){
            echo json_encode([
                "message" => $this->message->warning("Estudante informado não existe")->render()
            ]);
            return;
        }
        if($data["type"] == "create"){
            $historic = (new AppPayments());
            $historic->user_id = $student_id;
            $historic->student_id = $student_id;
            $historic->save();
            
        }

        if($data["type"] == "cancel"){
            $historics = (new AppPayments())->find("user_id = :ud AND student_id = :si AND status = :s","ud={$student_id}&si={$student_id}&s=pending")->fetch(true);
            foreach ($historics as $historic) {
                $historic->destroy();
            }
        }

        echo json_encode([
            "renewal" => true
        ]);
        return;
    }

/**
     * SITE CERTIFICATE
     * @param null|array $data
     */
    public function certificate(?array $data): void
    {
        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['document'])) {
                $json['message'] = $this->message->warning("Informe o seu CPF para consultar seu certificado")->render();
                echo json_encode($json);
                return;
            }

            $document = preg_replace("/[^0-9]/", "", $data['document']);

            $users = (new User())->find("document = :d AND status != 'pending'", "d={$document}")->fetch(true);
            if(!$users){
                $users = (new AppStudent())->find("document = :d AND status != 'pending'", "d={$document}")->fetch(true);
            }

            if(!$users){
                $json['message'] = $this->message->warning("Usuário não encontrado")->render();
                echo json_encode($json);
                return;
            }
            
            $data_obj = new \DateTime("now");
            $mes = $data_obj->format('m');

            if(count($users) ==  1){
                $id = $users[0]->id;
                $json['redirect'] = url("/certificado/{$document}/app/{$id}");
            }else{
                $json['redirect'] = url("/certificado/{$document}/mudar");
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Certificado - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/entrar"),
            theme("/assets/images/share.jpg")
        );

        if(empty($data["document"])){
            echo $this->view->render("certificate", [
                "head" => $head,
                "document" => null,
                "certificate" => true
            ]);
            return;
        }

        if(!empty($data["type"]) && $data["type"] == "mudar"){
            $document = $data["document"];
            $user = (new User())->find("document = :d", "d={$document}")->fetch(true);
            
            if(!$user){
                $user = (new AppStudent())->find("document = :d", "d={$document}")->fetch(true);
            }

            if(!$user){
                $this->message->warning("Usuários não encontrado")->flash();
                redirect("/certificado/{$document}/app");
            }

            echo $this->view->render("certificate-students", [
                "head" => $head,
                "document" => $document,
                "students" => $user
            ]);
            return;

        }

        if(!empty($data["type"]) && $data["type"] == "app"){
            $document = $data["document"];
            $id = $data["id"];
            
            if(empty($id)){
                $this->message->warning("Informações não encontradas")->flash();
                redirect("/certificado");
            }
            
            $user = (new User())->find("id = :id AND document = :d", "id={$id}&d={$document}")->fetch();
            if(!$user){
                $user = (new AppStudent())->find("id = :id AND document = :d", "id={$id}&d={$document}")->fetch();
            }

            if(!$user){
                $this->message->warning("Usuário não encontrado")->flash();
                redirect("/certificado/{$document}/app");
            }

            $data_obj = new \DateTime("now");
            $mes = $data_obj->format('m');

            $renew = (verify_renewal_data($user->renewal, $user->last_renewal_data) && ($mes >= 3));

            echo $this->view->render("certificate-app", [
                "head" => $head,
                "document" => $document,
                "user" => $user,
                "verify" => verify_renewal_data($user->renewal, $user->last_renewal_data),
                "renew" => $renew,
            ]);
            return;
        }

        if(!empty($data["type"]) && $data["type"] == "certificado"){
            $document = $data["document"];
            $id = $data["id"];
            if(empty($id)){
                $this->message->warning("Informações não encontradas")->flash();
                redirect("/certificado");
            }

            $user = (new User())->find("id = :id AND document = :d", "id={$id}&d={$document}")->fetch();
            if(!$user){
                $user = (new AppStudent())->find("id = :id AND document = :d", "id={$id}&d={$document}")->fetch();
            }

            if(!$user){
                $this->message->warning("Usuário não encontrado")->flash();
                redirect("/certificado");
            }

            $data_obj = new \DateTime("now");
            $mes = $data_obj->format('m');

            if(verify_renewal_data($user->renewal, $user->last_renewal_data) && ($mes >= 3)){
                $this->message->warning("Usuário pendente")->flash();
                redirect("/certificado/{$document}/app");
            }
    
            // $proximoano = date('Y', strtotime('+1 year'));
            $proximoano = date('Y');

            if(!empty($user->paymentsActivatedLast()->created_at)){
                $renew_data = new \DateTime($user->paymentsActivatedLast()->created_at);
            }else{
                $renew_data = new \DateTime($user->created_at);
            }
            
            $proximoano = $renew_data->format('Y') + 1;

            if((int) $proximoano <= (int) date('Y')){
                $date = "28 de Fevereiro de $proximoano";
            }else{
                $date = "28 de Fevereiro de ".date('Y', strtotime('+1 year'));
            }
            
            if(!empty($user->type)){
                if($user->type == "black"){
                    $model = "certificado_faixa_preta.jpg";
                }else{
                    $model = "certificado_kyu.jpg";
                    $date = "MEMBRO ATIVO $proximoano";
                }
            }else{
                $model = "certificado_instrutor.jpg";
            }
    
            $certificate = (new Certificate(
                $user->fullname(),
                $date,
                $user->document,
                path("assets/images/$model")
            ));
    
            if(!empty($user->type)){
                if($user->type == "kyus"){
                    $model = "certificado_kyu.jpg";
                    $certificate->setColorName(30);
                    $certificate->setColorName(255, 255, 255);
                    $certificate->setXYName(20,110);
    
                    $certificate->setSizeDate(25);
                    $certificate->setColorDate(100, 100, 100);
                    $certificate->setXYDate(20,80);
                    $certificate->setDateMultiCell(265, 10);
                }
            }
            
            $certificate->render();
        }
    }   

    /**
     * SITE LOGIN
     * @param null|array $data
     */
    public function login(?array $data): void
    {
        if (Auth::user()) {
            redirect("/app");
        }

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (request_limit("weblogin", 3, 60 * 5)) {
                $json['message'] = $this->message->error("Você já efetuou 3 tentativas, esse é o limite. Por favor, aguarde 5 minutos para tentar novamente!")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data['email']) || empty($data['password'])) {
                $json['message'] = $this->message->warning("Informe seu email e senha para entrar")->render();
                echo json_encode($json);
                return;
            }

            $save = (!empty($data['save']) ? true : false);
            $auth = new Auth();
            $login = $auth->login($data['email'], $data['password'], $save);

            if ($login) {
                $this->message->success("Seja bem-vindo(a) de volta " . Auth::user()->first_name . "!")->flash();
                $json['redirect'] = url("/app");
            } else {
                $json['message'] = $auth->message()->before("Ooops! ")->render();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Entrar - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/entrar"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("auth-login", [
            "head" => $head,
            "cookie" => filter_input(INPUT_COOKIE, "authEmail")
        ]);
    }

    /**
     * SITE PASSWORD FORGET
     * @param null|array $data
     */
    public function forget(?array $data)
    {
        if (Auth::user()) {
            redirect("/app");
        }

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data["email"])) {
                $json['message'] = $this->message->info("Informe seu e-mail para continuar")->render();
                echo json_encode($json);
                return;
            }

            if (request_repeat("webforget", $data["email"])) {
                $json['message'] = $this->message->error("Ooops! Você já tentou este e-mail antes")->render();
                echo json_encode($json);
                return;
            }

            $auth = new Auth();
            if ($auth->forget($data["email"])) {
                $json["message"] = $this->message->success("Acesse seu e-mail para recuperar a senha")->render();
            } else {
                $json["message"] = $auth->message()->before("Ooops! ")->render();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Recuperar Senha - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/recuperar"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("auth-forget", [
            "head" => $head
        ]);
    }

    /**
     * SITE FORGET RESET
     * @param array $data
     */
    public function reset(array $data): void
    {
        if (Auth::user()) {
            redirect("/app");
        }

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data["password"]) || empty($data["password_re"])) {
                $json["message"] = $this->message->info("Informe e repita a senha para continuar")->render();
                echo json_encode($json);
                return;
            }

            list($email, $code) = explode("|", $data["code"]);
            $auth = new Auth();

            if ($auth->reset($email, $code, $data["password"], $data["password_re"])) {
                $this->message->success("Senha alterada com sucesso. Vamos controlar?")->flash();
                $json["redirect"] = url("/entrar");
            } else {
                $json["message"] = $auth->message()->before("Ooops! ")->render();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Crie sua nova senha no " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/recuperar"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("auth-reset", [
            "head" => $head,
            "code" => $data["code"]
        ]);
    }

    /**
     * SITE REGISTER
     * @param null|array $data
     */
    public function register(?array $data): void
    {
        if (Auth::user()) {
            redirect("/app");
        }

        if (!empty($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Erro ao enviar, favor use o formulário")->render();
                echo json_encode($json);
                return;
            }

            if (in_array("", $data)) {
                $json['message'] = $this->message->info("Informe seus dados para criar sua conta.")->render();
                echo json_encode($json);
                return;
            }

            $auth = new Auth();
            $user = new User();
            $user->bootstrap(
                $data["first_name"],
                $data["last_name"],
                $data["email"],
                $data["password"]
            );

            if ($auth->register($user)) {
                $json['redirect'] = url("/confirma");
            } else {
                $json['message'] = $auth->message()->before("Ooops! ")->render();
            }

            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Criar Conta - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/cadastrar"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("auth-register", [
            "head" => $head
        ]);
    }

    /**
     * SITE OPT-IN CONFIRM
     */
    public function confirm(): void
    {
        $head = $this->seo->render(
            "Confirme Seu Cadastro - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/confirma"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Falta pouco! Confirme seu cadastro.",
                "desc" => "Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro e comece a controlar com o CaféControl",
                "image" => theme("/assets/images/optin-confirm.jpg")
            ]
        ]);
    }

    /**
     * SITE OPT-IN SUCCESS
     * @param array $data
     */
    public function success(array $data): void
    {
        $email = base64_decode($data["email"]);
        $user = (new User())->findByEmail($email);

        if ($user && $user->status != "confirmed") {
            $user->status = "confirmed";
            $user->save();
        }

        $head = $this->seo->render(
            "Bem-vindo(a) ao " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/obrigado"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("optin", [
            "head" => $head,
            "data" => (object)[
                "title" => "Tudo pronto. Você já pode controlar :)",
                "desc" => "Bem-vindo(a) ao seu controle de contas, vamos tomar um café?",
                "image" => theme("/assets/images/optin-success.jpg"),
                "link" => url("/entrar"),
                "linkTitle" => "Fazer Login"
            ],
            "track" => (object)[
                "fb" => "Lead",
                "aw" => "AW-953362805/yAFTCKuakIwBEPXSzMYD"
            ]
        ]);
    }

    /**
     * SITE TERMS
     */
    public function terms(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - Termos de uso",
            CONF_SITE_DESC,
            url("/termos"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("terms", [
            "head" => $head
        ]);
    }

    /**
     * SITE NAV ERROR
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data['errcode']) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Estamos enfrentando problemas!";
                $error->message = "Parece que nosso serviço não está diponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "ENVIAR E-MAIL";
                $error->link = "mailto:" . CONF_MAIL_SUPPORT;
                break;

            case "manutencao":
                $error->code = "OPS";
                $error->title = "Desculpe. Estamos em manutenção!";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;

            default:
                $error->code = $data['errcode'];
                $error->title = "Ooops. Conteúdo indispinível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $head = $this->seo->render(
            "{$error->code} | {$error->title}",
            $error->message,
            url("/ops/{$error->code}"),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}