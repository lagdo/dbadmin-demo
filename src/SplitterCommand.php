<?php

namespace Lagdo\DbAdmin\Demo;

use Commando\Command;
use Lagdo\DbAdmin\Driver\Sql\Dto\QueryCodeDto;
use Lagdo\DbAdmin\Support\Driver\DriverProxy;
use League\CLImate\CLImate;

use function Jaxon\jaxon;

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

        $this->io = new CLImate;

        $this->command = new Command();
        // Define a flag "-t" a.k.a. "--title"
        $this->command->setHelp('Split the content of a SQL file into separate queries.')
            ->option('f')
            ->aka('file')
            ->describedAs('The SQL file')
            ->must(fn(string $path) => file_exists($path))
            ->map(fn(string $path) => fopen($path, 'r', true))
            ->require();
    }

    /**
     * @param QueryCodeDto $queryDto
     * @param resource $fd
     *
     * @return bool
     */
    private function readLineFromFile(QueryCodeDto $queryDto, mixed $fd): bool
    {
        if (!($queryLine = fgets($fd))) {
            return false;
        }

        $queryDto->queryLine = $queryLine;
        $queryDto->lineNumber++;

        $queryLine = rtrim($queryLine); // Remove the newline char.
        $this->io->green(">>> Line number {$queryDto->lineNumber}: {$queryLine}");
        return true;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->driver->selectDatabase('dbadmin-pgsql-14');

        $queryLineReader = fn(QueryCodeDto $dto) =>
            $this->readLineFromFile($dto, $this->command['file']);
        $queryDto = new QueryCodeDto($queryLineReader);

        $queries = $this->driver->helper()->statement()->splitQueries($queryDto);
        foreach ($queries as $query) {
            $this->io->blue("<<< Query number {$queryDto->queryCount}:");
            $this->io->blue($query);
            $this->io->blue('<<<');
        }
    }
}
