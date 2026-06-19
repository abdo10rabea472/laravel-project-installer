<?php

namespace Smart\Installer\Services;

class EnvironmentService
{
    protected string $envPath;
    protected ?array $parsed = null;

    public function __construct()
    {
        $this->envPath = base_path('.env');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->parse()[$key] ?? $default;
    }

    public function set(string $key, string $value): bool
    {
        $this->ensureEnvExists();
        $content   = file_get_contents($this->envPath);
        $formatted = $this->formatValue($value);

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$formatted}", $content);
        } else {
            $content .= "\n{$key}={$formatted}";
        }

        $result       = (bool) file_put_contents($this->envPath, $content);
        $this->parsed = null;
        return $result;
    }

    public function setMany(array $values): bool
    {
        foreach ($values as $key => $value) {
            $this->set((string) $key, (string) $value);
        }
        return true;
    }

    public function ensureEnvExists(): bool
    {
        if (file_exists($this->envPath)) {
            return true;
        }

        $example = base_path('.env.example');
        if (file_exists($example)) {
            copy($example, $this->envPath);
        } else {
            file_put_contents($this->envPath, $this->minimalEnvStub());
        }

        $this->parsed = null;
        return true;
    }

    protected function parse(): array
    {
        if ($this->parsed !== null) {
            return $this->parsed;
        }

        if (!file_exists($this->envPath)) {
            return $this->parsed = [];
        }

        $lines  = file($this->envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $result = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $result[trim($key)] = trim($value, " \t\"'");
        }

        return $this->parsed = $result;
    }

    protected function formatValue(string $value): string
    {
        if (preg_match('/[\s#"\'\\\\]/', $value)) {
            return '"' . addslashes($value) . '"';
        }
        return $value;
    }

    protected function minimalEnvStub(): string
    {
        return <<<ENV
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync

MAIL_MAILER=log
ENV;
    }
}
