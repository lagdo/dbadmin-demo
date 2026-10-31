<?php

use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Lagdo\DbAdmin\App\Ui\AdminUiBuilder;
use Lagdo\DbAdmin\App\Ui\AuditUiBuilder;

use function Jaxon\attr;
use function Jaxon\jaxon;

if (!function_exists('env')) {
    function env(string $name, mixed $default = null): mixed
    {
        return $_ENV[$name] ?? $default;
    }
}

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

function ui_builder(): mixed
{
    $class = ($_GET['page'] ?? '') === 'audit' ?
        AuditUiBuilder::class : AdminUiBuilder::class;
    return jaxon()->di()->g($class);
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

function send_error(string $message): void
{
    header('Content-Type: text/plain; charset=utf-8');
    echo $message, "\n";
}

function setup_app(): void
{
    $configDir = __DIR__ . '/config/dbadmin';
    ($_GET['page'] ?? '') !== 'audit' ?
        DbAdminPackage::register($configDir, 'ajax.php') :
        DbAuditPackage::register($configDir, 'ajax.php?page=audit');
}

function jaxon_css(): string
{
    return jaxon()->css();
}

function jaxon_js(): string
{
    return jaxon()->js();
}

function jaxon_script(): string
{
    return jaxon()->script();
}

function jaxon_ready(): string
{
    $class = ($_GET['page'] ?? '') === 'audit' ?
        DbAuditPackage::class : DbAdminPackage::class;
    return attr()->package($class, 'ready');
}
