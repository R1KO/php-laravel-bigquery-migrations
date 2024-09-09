<?php

namespace R1KO\BigQueryLaravelMigrate;

use R1KO\Migrate\MigrationModelInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property Carbon $created_at
 * @mixin Builder
 */
class EloquentMigrationModel extends Model implements MigrationModelInterface
{
    use HasFactory;

    protected $table = 'bigquery_migrations';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'created_at',
    ];

    protected $dates = [
        'created_at',
    ];

    public function getName(): string
    {
        return $this->name;
    }
}
