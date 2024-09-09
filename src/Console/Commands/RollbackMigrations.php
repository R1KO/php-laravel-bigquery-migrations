<?php

namespace R1KO\BigQueryLaravelMigrate\Console\Commands;

use App\Libs\BigQueryMigrations\BigQueryStorage;
use Illuminate\Console\Command;

class RollbackMigrations extends AbstractMigration
{
    protected $signature = 'bigquery:rollback';

    protected $description = 'Rollback tables on bigquery';

    public function handle(): int
    {
        $connection = $this->getConnectionOption();
        if ($connection) {
            $this->setConnection($connection);
        }

        $dataset = $this->getDatasetOption();
        if ($dataset) {
            $this->setDataset($dataset);
        }

        $this->getMigrator()->rollback($this->getClient(), $this->getDataset());

        return Command::SUCCESS;
    }
}
