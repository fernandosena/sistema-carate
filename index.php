<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "Web:login");

//auth
$route->group(null);
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");
$route->get("/cadastrar", "Web:register");
$route->post("/cadastrar", "Web:register");
$route->get("/recuperar", "Web:forget");
$route->post("/recuperar", "Web:forget");
$route->get("/recuperar/{code}", "Web:reset");
$route->post("/recuperar/resetar", "Web:reset");
$route->post("/web/alunos", "Web:student");

$route->get("/certificado", "Web:certificate");
$route->get("/certificado/{document}/{type}", "Web:certificate");
$route->get("/certificado/{document}/{type}/{id}", "Web:certificate");
$route->post("/certificado", "Web:certificate");

//optin
$route->group(null);
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");

/**
 * APP
 */
$route->namespace("Source\App\App");
$route->group("/app");

$route->get("/", handler: "App:home");
$route->post("/graduation", "App:getgraduation");
$route->get("/regularization", "App:regularization");
$route->post("/regularization", "App:regularization");
$route->get("/perfil", "App:profile");
$route->get("/sair", "App:logout");
$route->post("/dash", "App:dash");
$route->post("/launch", "App:launch");
$route->post("/remove/{invoice}", "App:remove");
$route->post("/support", "App:support");
$route->post("/onpaid", "App:onpaid");
$route->post("/profile", "App:profile");
$route->post("/wallets/{wallet}", "App:wallets");

$route->get("/pagamentos", "Payments:pagamentos");
$route->post("/pagamentos/gerar", "Payments:pagamentosGerar");

$route->get("/alunos/{type}", "Students:students");
$route->post("/alunos", "Students:students");
$route->post("/alunos/faixa", "Students:belt");
$route->get("/aluno/{type}/{id}", "Students:student");

$route->get("/receber", "Income:income");
$route->get("/receber/{status}/{category}/{date}", "Income:income");

$route->get("/pagar", "Expense:expense");
$route->get("/pagar/{status}/{category}/{date}", "Expense:expense");

$route->get("/fixas", "Fixed:fixed");

$route->get("/fatura/{invoice}", "Invoice:invoice");
$route->post("/invoice/{invoice}", "Invoice:invoice");

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");

//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");
$route->post("/login", "Login:login");

$route->post("/chart/quantity", "Chart:quantity");
$route->post("/chart/table", "Chart:table");

$route->post("/dojo", "Admin:getdojo");
$route->post("/conf", "Admin:conf");

$route->get("/renewals/students", "Renewals:student");
$route->post("/renewals/students", "Renewals:student");
$route->get("/renewals/instrunctos", "Renewals:instruncto");
$route->post("/renewals", "Renewals:home");

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:home");
$route->post("/dash/home", "Dash:home");
$route->get("/logoff", "Dash:logoff");

//users
$route->get("/instructors/home", "Instructors:home");
$route->post("/instructors/home", "Instructors:home");
$route->get("/instructors/home/{search}/{page}", "Instructors:home");
$route->get("/instructors/instructor", "Instructors:Instructor");
$route->post("/instructors/instructor", "Instructors:Instructor");
$route->get("/instructors/instructor/{instructor_id}", "Instructors:instructor");
$route->get("/instructors/instructor/{instructor_id}/profile", "Instructors:profile");
$route->post("/instructors/instructor/{instructor_id}", "Instructors:instructor");

//student
$route->get("/students/{instructor}/{type}/home/{filter}", "Students:home");
$route->post("/students/home", "Students:home");

$route->get("/students/novos", "Students:news");
$route->get("/students/{type}/home/{search}/{page}", "Students:home");
$route->get("/students/{type}/student", "Students:student");
$route->post("/students/{type}/student", "Students:student");
$route->get("/students/{type}/student/{student_id}", "Students:student");
$route->post("/students/{type}/student/{student_id}", "Students:student");

$route->post("/post/students/status", "Students:status");
$route->post("/post/students/payment", "Students:payment");

$route->post("/post/instructor/payment", "Instructors:payment");


//belts
$route->get("/belts/home", "Belts:home");
$route->post("/belts/home", "Belts:home");
$route->get("/belts/home/{search}/{page}", "Belts:home");
$route->get("/belts/belt", "Belts:belt");
$route->post("/belts/belt", "Belts:belt");
$route->get("/belts/belt/{belt_id}", "Belts:belt");
$route->post("/belts/belt/{belt_id}", "Belts:belt");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

//END ADMIN
$route->namespace("Source\App");

/**
 * PAY ROUTES
 */
$route->group("/pay");
$route->post("/create", "Pay:create");
$route->post("/update", "Pay:update");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();