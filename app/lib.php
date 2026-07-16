<?php

function page(): string
{
    return ($_GET['page'] ?? '') === 'audit' ? 'dbaudit' : 'dbadmin';
}

function base_dir(): string
{
    return dirname(__DIR__);
}
