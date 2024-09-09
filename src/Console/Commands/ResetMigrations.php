<?php

namespace R1KO\BigQueryLaravelMigrate\Console\Commands;

use Google\Cloud\BigQuery\Table;
use Illuminate\Console\Command;

class ResetMigrations extends AbstractMigration
{
    protected $signature = 'bigquery:reset';

    protected $description = 'Remove all tables on bigquery and run migration';

    public function handle(): int
    {
        $this->removeAllTables();
        $this->info('DONE');

        return Command::SUCCESS;
    }

    private function removeAllTables(): void
    {
        $tables = $this->getClient()
            ->dataset($this->getDataset())
            ->tables();

        foreach ($tables as $table) {
            if (!$table->exists()) {
                continue;
            }
            /** @var Table $table */
            $table->delete();
            dump($table->id(), $table->identity());
        }
    }
}
