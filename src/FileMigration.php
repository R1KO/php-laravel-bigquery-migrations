<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationExecutableInterface;
use R1KO\Migrate\MigrationInterface;
use SplFileInfo;

class FileMigration implements MigrationExecutableInterface
{
    private SplFileInfo $file;

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function getName(): string
    {
        return $this->file->getBasename('.'.$this->file->getExtension());
    }

    public function execute(...$args): void
    {
        $this->factoryInstance()
            ->with(...$args)
            ->up();
    }

    public function rollback(...$args): void
    {
        $this->factoryInstance()
            ->with(...$args)
            ->down();
    }

    private function factoryInstance(): MigrationInterface
    {
        $instance = require_once $this->file->getRealPath();
        assert($instance instanceof MigrationInterface);

        return $instance;
    }
}
