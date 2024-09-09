<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class Output implements OutputInterface
{
    private ConsoleOutputInterface $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function info(string $message)
    {
        $this->line($message, 'info');
    }

    public function error(string $message)
    {
        $this->line($message, 'error');
    }

    private function line(string $string, $style = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled);
    }
}
