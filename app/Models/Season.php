<?php

namespace App\Models;

use App\Observers\SeasonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SeasonObserver::class)]
class Season extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
    ];

    public function scopeOrderBySeasonAndYear(Builder $query): Builder
    {
        return $query->orderByRaw('CAST(SUBSTR(name, -4) AS INTEGER)')
            ->orderByRaw("
            CASE
                WHEN INSTR(LOWER(name), 'spring') > 0 THEN 1
                WHEN INSTR(LOWER(name), 'summer') > 0 THEN 2
                WHEN INSTR(LOWER(name), 'fall') > 0 THEN 3
                WHEN INSTR(LOWER(name), 'winter') > 0 THEN 4
                ELSE 5
            END
        ");
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }
}
