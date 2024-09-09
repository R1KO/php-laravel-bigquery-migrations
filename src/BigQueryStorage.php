<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationModelInterface;
use R1KO\Migrate\StorageInterface;
use Carbon\Carbon;
use Google\Cloud\BigQuery\BigQueryClient;

class BigQueryStorage implements StorageInterface
{
    // TODO: implement this
    use UseBigQuery;

    /**
     * @return MigrationModelInterface[]
     */
    public function getList(): array
    {
        $this->checkMigrationSchemaTable();

        $client = $this->getClient();
        // TODO: Remake to use DI Container
        $query = $client
            ->query(sprintf('SELECT * FROM `%s.%s` ORDER BY `created_at`;',
                $this->getDataset(),
                $this->getTableName()
            ));

        $results = $client
            ->runQuery($query)
            ->rows();

        $items = iterator_to_array($results);

        return array_map(fn ($item) => new BigQueryMigrationModel($item), $items);
    }

    public function add(MigrationModelInterface $migration): void
    {
        $result = $this->getClient()
            ->dataset($this->getDataset())
            ->table($this->getTableName())
            ->insertRow([
                'name'       => $migration->getName(),
                'created_at' => Carbon::now(),
            ]);
    }

    public function remove(MigrationModelInterface $migration): void
    {
        $query = $this->getClient()
            ->query(sprintf(
                'DELETE
                FROM `%s.%s`
                WHERE `name` = \'%s\';',
                $this->getDataset(),
                $this->getTableName(),
                $migration->getName()
            ));

        $result = $this->getClient()
            ->runQuery($query);
    }

    private function getClient(): BigQueryClient
    {
        return app(BigQueryClient::class);
    }

    private function getTableName(): string
    {
        return 'migrations_schema';
    }

    private function checkMigrationSchemaTable(): void
    {
        $isExists = $this->getClient()
            ->dataset($this->getDataset())
            ->table($this->getTableName())
            ->exists();

        if ($isExists) {
            return;
        }

        $this->getClient()
            ->dataset($this->getDataset())
            ->createTable($this->getTableName(), [
                'schema' => [
                    'fields' => [
                        [
                            'name' => 'name',
                            'type' => 'STRING',
                            'mode' => 'NULLABLE',
                        ],
                        [
                            'name' => 'created_at',
                            'type' => 'DATETIME',
                            'mode' => 'NULLABLE',
                        ],
                    ],
                ],
            ]);
    }
}
