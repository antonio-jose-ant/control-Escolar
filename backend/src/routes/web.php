<?php
require_once __DIR__ . '/../includes/displayErrors.php';
use App\core\Router;
use App\factory\AuthFactory;
Router::post('/login', function () {
    $data = json_decode(file_get_contents('php://input'), true);
    (new AuthFactory())::login(
        $data['user'] ?? '',
        $data['pass'] ?? ''
    );
});
Router::post('/logout', function () {
    (new AuthFactory())::logout();
});
