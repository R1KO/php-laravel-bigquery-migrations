<?php

namespace R1KO\BigQueryLaravelMigrate\Console\Commands;

use R1KO\BigQueryLaravelMigrate\BigQueryStorage;
use R1KO\BigQueryLaravelMigrate\FileManager;
use R1KO\BigQueryLaravelMigrate\Output;
use R1KO\Migrate\Migrator;
use Illuminate\Console\Command;

abstract class AbstractMigration extends Command
{
    public function getMigrator(): Migrator
    {
        $storage = new BigQueryStorage();
        $folderName = 'bigquery_migrations';

        return new Migrator(
            new FileManager(base_path('database/'.$folderName)),
            $storage,
            new Output()
        );
    }
}
