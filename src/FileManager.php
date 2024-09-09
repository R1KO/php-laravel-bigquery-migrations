<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\ManagerInterface;
use R1KO\Migrate\MigrationExecutableInterface;
use R1KO\Migrate\MigrationModelInterface;
use DirectoryIterator;
use Exception;
use SplFileInfo;

class FileManager implements ManagerInterface
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = realpath($path);
    }

    /**
     * @return MigrationExecutableInterface[]
     */
    public function getList(): array
    {
        $files = [];
        foreach (new DirectoryIterator($this->path) as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->isDir()) {
                continue;
            }
            if ($fileInfo->getType() !== 'file') {
                continue;
            }
            // TODO: add filter by extension
            $files[] = new FileMigration($fileInfo->getFileInfo());
        }

        usort($files, fn(FileMigration $a, FileMigration $b) => $a->getName() <=> $b->getName());

        return $files;
    }

    public function make(string $name): MigrationModelInterface
    {
        $fileName = sprintf('%s_%s', date('Y_m_d_His'), $name);

        $filePath = $this->path . DIRECTORY_SEPARATOR . $fileName . '.php';
        $stubPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'migration.php.stub');
        file_put_contents($filePath, file_get_contents($stubPath));

        return new FileMigration(new SplFileInfo($filePath));
    }

    public function getExecutableByModel(MigrationModelInterface $migration): MigrationExecutableInterface
    {
        $filePath = $this->path . DIRECTORY_SEPARATOR . $migration->getName() . '.php';
        if (!file_exists($filePath)) {
            throw new Exception(sprintf('File "%s" not found', $filePath));
        }

        return new FileMigration(new SplFileInfo($filePath));
    }
}
