<?php
namespace App\Services\login;
use App\Services\login\UserRepository;
use App\Services\login\LoginAttemptRepository;
use App\Services\login\SessionRepository;
use App\Services\login\SessionRepositoryLogout;
use App\services\ip\IpResolver;
use App\Services\login\TokenService;
use App\helpers\ResponsServer;
use App\factory\ipFactory;
class AuthService
{
    private $users;
    private $rs;
    private $sessions;
    private $logs;
    private $ipFactory;
    private $tokens;
    private $ipResolve;
    private $justLogaut;
    public function __construct(private \PDO $conexion)
    {
        $this->users = new UserRepository($conexion);
        $this->sessions = new SessionRepository($conexion);
        $this->logs = new LoginAttemptRepository($conexion);
        $this->tokens = new TokenService();
        $this->ipResolve = new IpResolver();
        $this->rs = new ResponsServer();
        $this->justLogaut = new SessionRepositoryLogout($conexion);
        $this->ipFactory = new IpFactory();
    }
    public function auth(string $user, string $pass, string $ua)
    {
        if (empty($user)) {
            $this->rs->error("Parametro usuario vacio " . $user, -10, 200);
        }
        if (empty($pass)) {
            $this->rs->error("Parametro Contraseña vacio", -10, 200);

        }
        $logValidaUser = $this->users->findByEmail($user);
        $ip = $this->ipResolve->get_client_ip();
        if ($this->ipFactory->ipBloqued($user, $ip)) {
            $this->logs->registrarIntento($user, $ip, $ua, 'blocked', 'ip bloqueada por intentos fallidos');
            $this->rs->error("intenta mas tarde", -11, 200, ['F-H-bloqueo' => date('Y-m-d H:i:s')]);
        }
        if ($this->ipFactory->blockFailedAttempts($user, $ip)) {
            $this->logs->registrarIntento($user, $ip, $ua, 'temporarily_blocked', 'mas de 5 intentos fallidos en los ultimos 5 minutos');
            $this->rs->error("intenta mas tarde", -11, 200, ['F-H-bloqueo' => date('Y-m-d H:i:s')]);
        }
        if (!$logValidaUser) {
            $this->logs->registrarIntento($user, $ip, $ua, 'fail', 'Credenciales incorrectas');
            $this->rs->error("Usuario y/o contraseña incorrecto", -11, 200);
        }
        $hashBD = $logValidaUser['password_hash'];
        // 2. Validar contraseña


        if (!password_verify($pass, $hashBD)) {
            $this->logs->registrarIntento($user, $ip, $ua, 'fail', 'Credenciales incorrectas');
            $this->rs->error("Usuario y/o contraseña incorrecto", -11, 200);
        }
        $this->logs->registrarIntento($user, $ip, $ua, 'success', '');
        $this->createSession($logValidaUser['id'], $ip, $ua);
        $this->rs->success(null, 1);
    }
    public function exit($token)
    {
        session_start();
        $hash = $this->tokens->searchTokenBD($token);
        try {
            $this->justLogaut->Delete($hash);
        } catch (\Exception $e) {
            throw $e;
        }
        setcookie('session_token', '', [
            'expires' => time() - 3600, // Hace que expire inmediatamente (hace 1 hora)
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        $_SESSION = [];                    // limpiar variables internas
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 3600,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        return true;

    }
    private function createSession($id, $ip, $ua)
    {
        session_start();
        $hashes = $this->tokens->createToken();
        $expires = new \DateTime('+1 days');
        try {
            $this->sessions->create($id, $hashes['hash'], $ip, $ua, $expires->format('Y-m-d H:i:s'));
        } catch (\Exception $e) {
            throw $e;
        }
        setcookie('session_token', $hashes['raw'], [
            'expires' => $expires->getTimestamp(),
            'path' => '/',
            'domain' => '',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        $_SESSION['uid'] = $id;
        return $hashes['raw'];
    }
}