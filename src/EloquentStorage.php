<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationModelInterface;
use R1KO\Migrate\StorageInterface;
use Carbon\Carbon;

class EloquentStorage implements StorageInterface
{
    /**
     * @return MigrationModelInterface[]
     */
    public function getList(): array
    {
        $items = BigQueryMigrationModel::query()
            ->orderBy('created_at', 'ASC')
            ->get();

        return $items->all();
    }

    public function add(MigrationModelInterface $migration): void
    {
        BigQueryMigrationModel::create([
            'name'       => $migration->getName(),
            'created_at' => Carbon::now(),
        ]);
    }

    public function remove(MigrationModelInterface $migration): void
    {
        BigQueryMigrationModel::query()
            ->where('name', $migration->getName())
            ->delete();
    }
}
