<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationModelInterface;

class BigQueryMigrationModel implements MigrationModelInterface
{
    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }
}
