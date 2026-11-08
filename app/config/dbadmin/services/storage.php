<?php

use Lagdo\DbAdmin\Support\Service\Export;
use Lagdo\DbAdmin\Support\Service\Import;

return [
    // 'export' => null, // No export.
    'export' => fn() => new class extends Export\AbstractStorage {
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

    // 'import' => null, // No import.
    'import' => fn() => new class extends Import\AbstractStorage {
        protected function storage(): string
        {
            return 'imports';
        }
        public function url(string $filename): string
        {
            return "/import.php?file=$filename";
        }
        protected function path(string $filename): string
        {
            return "users/$filename";
        }
    },
];
