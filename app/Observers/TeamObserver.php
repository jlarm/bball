<?php

namespace App\Observers;

use App\Models\Team;
use Str;

class TeamObserver
{
    public function creating(Team $team): void
    {
        $team->uuid = (string) Str::uuid();
    }
}
