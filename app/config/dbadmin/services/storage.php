<?php

use Lagdo\DbAdmin\Support\Service\Export;
use Lagdo\DbAdmin\Support\Service\Import;

return [
    // 'export' => null, // No export.
    'export' => fn() => new class extends Export\AbstractStorage {
        public function status(): array
        {
            return [
                'storage' => 'export_status',
            ];
        }
        public function path(string $filename): string
        {
            return $filename;
        }
        public function url(string $filename): string
        {
            return "/export.php?file=$filename";
        }
    },

    // 'import' => null, // No import.
    'import' => fn() => new class extends Import\AbstractStorage {
        public function status(): array
        {
            return [
                'storage' => 'import_status',
            ];
        }
        public function path(string $filename): string
        {
            return $filename;
        }
        public function url(string $filename): string
        {
            return "/import.php?file=$filename";
        }
        public function dumps(): array
        {
            return [
                'databases' => [
                    'label' => 'Database dumps',
                    // 'directory' => '',
                    'storage' => 'import_dumps',
                ],
            ];
        }
        public function dumpLabels(): array
        {
            return [
                '6aefc8cb1e449.sql' => 'Sample import database',
            ];
        }
    },
];
