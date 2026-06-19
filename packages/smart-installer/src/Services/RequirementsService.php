<?php

namespace Smart\Installer\Services;

/**
 * RequirementsService
 *
 * Checks PHP version, required extensions, and folder write permissions.
 * Pure environment checks.
 */
class RequirementsService
{
    public function checkAll(): array
    {
        return [
            'php_version'  => $this->checkPhpVersion(),
            'extensions'   => $this->checkExtensions(),
            'permissions'  => $this->checkPermissions(),
        ];
    }

    public function allPassed(): bool
    {
        $results = $this->checkAll();

        if (!$results['php_version']['passed']) return false;

        foreach ($results['extensions'] as $ext) {
            if (!$ext['passed']) return false;
        }

        foreach ($results['permissions'] as $perm) {
            if (!$perm['passed']) return false;
        }

        return true;
    }

    public function checkPhpVersion(): array
    {
        $required = config('installer.requirements.min_php_version', '8.2.0');
        $current  = PHP_VERSION;
        $passed   = version_compare($current, $required, '>=');

        return [
            'label'    => "PHP Version (≥ {$required})",
            'current'  => $current,
            'required' => $required,
            'passed'   => $passed,
        ];
    }

    public function checkExtensions(): array
    {
        $extensions = config('installer.requirements.extensions', []);
        $results    = [];

        foreach ($extensions as $ext) {
            $results[] = [
                'label'  => "ext-{$ext}",
                'name'   => $ext,
                'passed' => extension_loaded($ext),
            ];
        }

        return $results;
    }

    public function checkPermissions(): array
    {
        $paths   = config('installer.requirements.writable_paths', []);
        $results = [];

        foreach ($paths as $path) {
            $fullPath = base_path($path);
            $exists   = is_dir($fullPath);
            $writable = $exists && is_writable($fullPath);

            $results[] = [
                'label'  => $path,
                'path'   => $fullPath,
                'exists' => $exists,
                'passed' => $writable,
            ];
        }

        return $results;
    }

    public function getServerInfo(): array
    {
        return [
            'php_version'     => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'os'               => PHP_OS_FAMILY,
            'memory_limit'    => ini_get('memory_limit'),
            'max_execution'   => ini_get('max_execution_time'),
            'upload_max'      => ini_get('upload_max_filesize'),
        ];
    }
}
