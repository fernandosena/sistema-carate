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

$route->get("/certificado", "Web:certificate");
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

$route->get("/", "App:home");
$route->get("/perfil", "App:profile");
$route->get("/sair", "App:logout");
$route->post("/dash", "App:dash");
$route->post("/launch", "App:launch");
$route->post("/remove/{invoice}", "App:remove");
$route->post("/support", "App:support");
$route->post("/onpaid", "App:onpaid");
$route->post("/filter", "App:filter");
$route->post("/profile", "App:profile");
$route->post("/wallets/{wallet}", "App:wallets");

$route->get("/alunos", "Students:students");
$route->post("/alunos", "Students:students");
$route->get("/aluno/{id}", "Students:student");

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

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:home");
$route->post("/dash/home", "Dash:home");
$route->get("/logoff", "Dash:logoff");

//users
$route->get("/users/home", "Users:home");
$route->post("/users/home", "Users:home");
$route->get("/users/home/{search}/{page}", "Users:home");
$route->get("/users/user", "Users:user");
$route->post("/users/user", "Users:user");
$route->get("/users/user/{user_id}", "Users:user");
$route->post("/users/user/{user_id}", "Users:user");

//student
$route->get("/students/home", "Students:home");
$route->post("/students/home", "Students:home");
$route->get("/students/home/{search}/{page}", "Students:home");
$route->get("/students/student", "Students:student");
$route->post("/students/student", "Students:student");
$route->get("/students/student/{student_id}", "Students:student");
$route->post("/students/student/{student_id}", "Students:student");

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