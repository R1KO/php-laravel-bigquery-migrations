<?php

namespace R1KO\BigQueryLaravelMigrate\Console\Commands;

use Illuminate\Console\Command;

class CreateMigration extends AbstractMigration
{
    protected $signature = 'bigquery:make {name}';

    protected $description = 'Create a migration file for bigquery';

    public function handle(): int
    {
        $name = $this->argument('name');
        $this->getMigrator()->make($name);

        return Command::SUCCESS;
    }
}
