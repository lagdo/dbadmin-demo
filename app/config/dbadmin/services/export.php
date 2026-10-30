<?php

use Lagdo\DbAdmin\Support\Service\Export\AbstractFileSystem;

return [
    // 'default' => null, // No export.
    'default' => fn() => new class extends AbstractFileSystem {
        protected function storage(): string
        {
            return 'exports';
        }
        protected function url(string $filename): string
        {
            return "/export.php?file=$filename";
        }
        protected function path(string $filename): string
        {
            return "users/$filename";
        }
    },
];
