<?php

namespace Lagdo\DbAdmin\Demo;

use Commando\Command;
use Lagdo\DbAdmin\Driver\Sql\Dto\QueryStreamDto;
use Lagdo\DbAdmin\Support\Driver\DriverProxy;
use League\CLImate\CLImate;

use function Jaxon\jaxon;
use function rtrim;

class SplitterCommand
{
    /**
     * @var DriverProxy
     */
    private DriverProxy $driver;

    /**
     * @var CLImate
     */
    private CLImate $io;

    /**
     * @var Command
     */
    private Command $command;

    public function __construct()
    {
        $this->driver = jaxon()->di()->g(DriverProxy::class);
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
     * @param QueryStreamDto $stream
     * @param resource $fd
     *
     * @return bool
     */
    private function readLineFromFile(QueryStreamDto $stream, mixed $fd): bool
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
        $this->driver->selectDatabase('dbadmin-pgsql-14');

        $queryLineReader = fn(QueryStreamDto $stream) =>
            $this->readLineFromFile($stream, $this->command['file']);
        $stream = new QueryStreamDto($queryLineReader);

        $queries = $this->driver->helper()->statement()->splitQueries($stream);
        foreach ($queries as $query) {
            $this->io->blue("<<< Query number {$stream->queryCount}:");
            $this->io->blue($query);
            $this->io->blue('<<<');
        }
    }
}
