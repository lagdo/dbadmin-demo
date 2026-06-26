<?php

namespace Lagdo\DbAdmin\Demo;

use Commando\Command;
use Lagdo\DbAdmin\Support\Service\Query\QuerySplitter;
use Lagdo\DbAdmin\Support\Service\Query\QueryStream;
use League\CLImate\CLImate;

use function fgets;
use function file_exists;
use function fopen;
use function rtrim;

class SplitterCommand
{
    /**
     * @var CLImate
     */
    private CLImate $io;

    /**
     * @var Command
     */
    private Command $command;

    /**
     * @param QuerySplitter $splitter
     */
    public function __construct(private QuerySplitter $splitter)
    {
        $this->io = new CLImate();

        $this->command = new Command();
        // Define a flag "-f" a.k.a. "--file"
        $this->command->setHelp('Split the content of a SQL file into separate queries.')
            ->option('f')
            ->aka('file')
            ->describedAs('The SQL file')
            ->must(fn(string $path) => file_exists($path))
            ->map(fn(string $path) => fopen($path, 'r', true))
            ->require();
    }

    /**
     * @param QueryStream $stream
     * @param resource $fd
     *
     * @return bool
     */
    private function readLineFromFile(QueryStream $stream, mixed $fd): bool
    {
        if (!($queryLine = fgets($fd))) {
            return false;
        }

        $stream->queryLine = $queryLine;
        $stream->lineNumber++;
        // Remove the newline char.
        $this->io->green(">>> Line number {$stream->lineNumber}: " . rtrim($queryLine));

        return true;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $queryLineReader = fn(QueryStream $stream) =>
            $this->readLineFromFile($stream, $this->command['file']);
        $stream = new QueryStream($queryLineReader);

        $queries = $this->splitter->splitQueries($stream);
        foreach ($queries as $query) {
            $this->io->blue("<<< Query number {$stream->queryCount}:");
            $this->io->blue($query);
            $this->io->blue('<<<');
        }
    }
}
