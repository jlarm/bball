<?php

namespace App\Models;

use App\Observers\TeamObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(TeamObserver::class)]
class Team extends Model
{
    protected $fillable = [
        'uuid',
        'season_id',
        'name',
        'division',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }
}
