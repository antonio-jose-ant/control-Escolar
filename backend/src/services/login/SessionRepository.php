<?php
namespace App\services\login;
/**
 * Summary of SessionRepository
 *  crea el registro de un iniiicio de secion 
 */
class SessionRepository extends \App\mapping\SESSIONS
{
    public function __construct(private \PDO $pdo)
    {
        parent::__construct($pdo);
    }
    public function create(int $id, string $tokenHash, string $ip, string $ua, string $expires): bool
    {
        return $this->Agregar($id, $tokenHash, $ip, $ua, $expires);
    }

    public function verifyToken(string $tokenHash, int $uId): bool
    {
        $sql = self::SELECT($this->nameTable, ['token_hash'], ["user_id = :id"], limit: 1);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $uId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row)
            return false;

        return hash_equals($row['token_hash'], $tokenHash);
    }
}