<?php

namespace App\Observers;

use App\Models\Organization;
use Str;

class OrganizationObserver
{
    public function creating(Organization $organization): bool
    {
        if (Organization::count() > 0) {
            return false;
        }

        $organization->uuid = (string) Str::uuid();

        return true;
    }
}
