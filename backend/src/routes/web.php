<?php
require_once __DIR__ . '/../includes/displayErrors.php';
use App\Router\Router;
use App\services\LoginService;
use App\Config\Database;
Router::post('/login', function () {
    $data = json_decode(file_get_contents('php://input'), true);
    $db = new Database();
    $auth = new LoginService(
        $data['user'] ?? '',
        $data['pass'] ?? '',
        $db->getConnection()
    );
    $auth->login();
});

Router::post('/registrar', function () {
    $db = new Database();
    $auth = new LoginService(
        $_POST['User'] ?? '',
        $_POST['Pass'] ?? '',
        $db->getConnection()
    );
    $auth->register();
});

Router::get('/users/{id}', function ($id) {
    echo json_encode([
        "user" => $id
    ]);
});

Router::post('/logout', function () {
    echo json_encode(["logout" => true]);
});
