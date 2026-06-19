<?php

namespace Smart\Installer\Services;

use PDO;
use PDOException;

class DatabaseService
{
    public function testConnection(array $config): array
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $config['host'],
                $config['port'],
                $config['database']
            );

            $pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT            => 5,
            ]);

            $pdo->query('SELECT 1');
            $version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);

            return [
                'success' => true,
                'message' => 'Connection successful.',
                'server'  => $version,
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $this->sanitizeError($e->getMessage()),
            ];
        }
    }

    public function saveConfiguration(array $config): bool
    {
        $map = [
            'DB_HOST'     => $config['host'],
            'DB_PORT'     => $config['port'],
            'DB_DATABASE' => $config['database'],
            'DB_USERNAME' => $config['username'],
            'DB_PASSWORD' => $config['password'],
        ];

        foreach ($map as $key => $value) {
            $this->setEnvValue($key, $value);
        }

        // Reload DB config for the current request so migrations work immediately
        config([
            'database.connections.mysql.host'     => $config['host'],
            'database.connections.mysql.port'     => $config['port'],
            'database.connections.mysql.database' => $config['database'],
            'database.connections.mysql.username' => $config['username'],
            'database.connections.mysql.password' => $config['password'],
        ]);

        return true;
    }

    /**
     * Force SESSION_DRIVER=file in both .env and live config.
     *
     * Fixes SQLSTATE[42S02] sessions table error: if SESSION_DRIVER=database
     * (a common default), Laravel tries to read the `sessions` table BEFORE
     * migrations run. File-based sessions avoid this entirely during install.
     */
    public function forceFileSession(): void
    {
        $this->setEnvValue('SESSION_DRIVER', 'file');
        config(['session.driver' => 'file']);
    }

    public function generateAppKey(): string
    {
        $key = 'base64:' . base64_encode(random_bytes(32));
        $this->setEnvValue('APP_KEY', $key);
        config(['app.key' => $key]);
        return $key;
    }

    public function setEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $example = base_path('.env.example');
            if (file_exists($example)) {
                copy($example, $envPath);
            } else {
                file_put_contents($envPath, '');
            }
        }

        $content = file_get_contents($envPath);

        $needsQuotes = preg_match('/[\s#"\'\\\\]/', $value);
        $formatted   = $needsQuotes ? '"' . addslashes($value) . '"' : $value;

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$formatted}", $content);
        } else {
            $content .= "\n{$key}={$formatted}";
        }

        file_put_contents($envPath, $content);
    }

    protected function sanitizeError(string $message): string
    {
        $message = preg_replace('/password=[^\s;]+/i', 'password=***', $message);
        return $message;
    }
}
