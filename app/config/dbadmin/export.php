<?php

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

use function Jaxon\storage;

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.stores.exports options.
    return storage()->get('exports');
}

function getExportPath(string $filename): string
{
    return "users/$filename";
}

return [
    'writer' => function(string $content, string $filename): string {
        try {
            $storage = getExportStorage();
            $storage->write(getExportPath($filename), "$content\n");
        } catch (FilesystemException|UnableToWriteFile) {
            return '';
        }
        // Return the link to the exported file.
        return "/export.php?file=$filename";
    },
    'reader' => function(string $filename): string {
        try {
            $storage = getExportStorage();
            $filepath = getExportPath($filename);
            return !$storage->fileExists($filepath) ?
                "No file $filename found." : $storage->read($filepath);
        } catch (FilesystemException|UnableToReadFile) {
            return "No file $filename found.";
        }
    },
];
