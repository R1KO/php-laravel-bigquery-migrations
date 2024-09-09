<?php

namespace R1KO\BigQueryLaravelMigrate\Console\Commands;

use Illuminate\Console\Command;

class RunMigrations extends AbstractMigration
{
    protected $signature = 'bigquery:migrate {--connection=} {--dataset=}';

    protected $description = 'Setup tables on bigquery';

    public function handle(): int
    {
        $this->getMigrator()->migrate($this->getClient(), $this->getDataset());

        return Command::SUCCESS;
    }
}
