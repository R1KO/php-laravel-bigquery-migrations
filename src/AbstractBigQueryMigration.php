<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationInterface;
use Google\Cloud\BigQuery\BigQueryClient;

abstract class AbstractBigQueryMigration implements MigrationInterface
{
    private BigQueryClient $bigQueryClient;
    private string $dataset;

    public function with(...$args): MigrationInterface
    {
        /** @var BigQueryClient $bigQueryClient */
        $bigQueryClient = $args[0];
        assert($bigQueryClient instanceof BigQueryClient);

        /** @var string $dataset */
        $dataset = $args[1];
        assert(is_string($dataset));

        $this->bigQueryClient = $bigQueryClient;
        $this->dataset = $dataset;

        return $this;
    }

    protected function getClient(): BigQueryClient
    {
        return $this->bigQueryClient;
    }

    protected function getDataset(): string
    {
        return $this->dataset;
    }
}
