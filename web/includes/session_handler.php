<?php
class MariaDBSessionHandler implements SessionHandlerInterface {

    private $pdo;

    public function open(string $savePath, string $sessionName): bool {
        $host = getenv('DB_HOST') ?: '172.16.56.145';
        $dbname = getenv('DB_NAME') ?: 'hosting_inventari';
        $user = getenv('DB_USER') ?: 'myadmin';
        $pass = getenv('DB_PASS') ?: 'proyecto';

        try {
            error_log("🛠 [SessionHandler] Conectando con MariaDB...");
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false,
            ]);
            error_log("[SessionHandler] Conexión exitosa");
            return true;
        } catch (PDOException $e) {
            error_log("[SessionHandler] Fallo de conexión: " . $e->getMessage());
            return false;
        }
    }

    public function close(): bool {
        $this->pdo = null;
        return true;
    }

    public function read(string $id): string|false {
        try {
            $stmt = $this->pdo->prepare("SELECT data FROM php_sessions WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['data'] : '';
        } catch (PDOException $e) {
            error_log("[SessionHandler] Error al leer sesión: " . $e->getMessage());
            return false;
        }
    }

    public function write(string $id, string $data): bool {
        try {
            $timestamp = time();
            $stmt = $this->pdo->prepare("REPLACE INTO php_sessions (id, data, timestamp) VALUES (:id, :data, :timestamp)");
            return $stmt->execute(['id' => $id, 'data' => $data, 'timestamp' => $timestamp]);
        } catch (PDOException $e) {
            error_log("[SessionHandler] Error al escribir sesión: " . $e->getMessage());
            return false;
        }
    }

    public function destroy(string $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("[SessionHandler] Error al destruir sesión: " . $e->getMessage());
            return false;
        }
    }

    public function gc(int $max_lifetime): int|false {
        try {
            $old = time() - $max_lifetime;
            $stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE timestamp < :old");
            $stmt->execute(['old' => $old]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("[SessionHandler] Error en garbage collection: " . $e->getMessage());
            return false;
        }
    }
}

// Configuración de errores (por si se ejecuta fuera del contenedor)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

$handler = new MariaDBSessionHandler();

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.save_path', '/tmp');
    session_set_save_handler($handler, true);

    if (!session_start()) {
        error_log("[SessionHandler] session_start() ha fallado");
    } else {
        error_log("[SessionHandler] session_start() ha funcionado");
    }
} else {
    error_log("SessionHandler] La sesión ya estaba iniciada");
}
