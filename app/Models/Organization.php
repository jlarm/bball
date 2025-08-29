<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'logo_path',
    ];

    public static function current(): ?self
    {
        return self::first();
    }

    public static function currentOrDefault(): self
    {
        return self::current() ?? self::create([
            'name' => config('app.name', 'Baseball Organization'),
            'address' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'logo_path' => '',
        ]);
    }

    public static function createOrUpdate(array $data): self
    {
        $organization = self::current();

        if ($organization instanceof self) {
            $organization->update($data);

            return $organization;
        }

        return self::create($data);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        return Storage::url($this->logo_path);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: config('app.name', 'Baseball Organization');
    }

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
        ];
    }
}
