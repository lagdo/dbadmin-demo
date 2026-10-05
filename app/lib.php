<?php

use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\DbAuditPackage;

if (!function_exists('env'))
{
    function env(string $name, mixed $default = null): mixed
    {
        return $_ENV[$name] ?? $default;
    }
}

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

function base_dir(): string
{
    return dirname(__DIR__);
}

function log_file(): string
{
    return base_dir() . '/logs/' . page();
}

function setup_file(): string
{
    return __DIR__ . '/config/jaxon.php';
}

function setup_app(): void
{
    $configDir = __DIR__ . '/config/dbadmin';
    ($_GET['page'] ?? '') !== 'audit' ?
        DbAdminPackage::register($configDir, 'ajax.php') :
        DbAuditPackage::register($configDir, 'ajax.php?page=audit');
}
