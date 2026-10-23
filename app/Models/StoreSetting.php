<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StoreSetting extends Model
{
    use HasFactory;

    /**
     * Cache key prefix for store settings.
     */
    public const CACHE_PREFIX = 'store_setting_';
    public const CACHE_PUBLIC_KEY = 'store_settings_public';
    public const CACHE_GROUP_PREFIX = 'store_settings_group_';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'description',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(function (self $setting) {
            $setting->invalidateCache();
        });

        static::deleted(function (self $setting) {
            $setting->invalidateCache();
        });
    }

    /**
     * Get typed value based on setting type.
     */
    public function getTypedValueAttribute(): mixed
    {
        return self::castValue($this->value, $this->type);
    }

    /**
     * Cast raw value to its appropriate PHP type.
     */
    public static function castValue(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'int' => (int) $value,
            'float', 'double' => (float) $value,
            'json', 'array' => json_decode($value, true) ?? [],
            default => (string) $value,
        };
    }

    /**
     * Serialize a typed PHP value into a string for storage.
     */
    public static function serializeValue(mixed $value, ?string $type = null): string
    {
        if (is_array($value) || is_object($value) || $type === 'json' || $type === 'array') {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }

    /**
     * Retrieve a setting value by key with caching.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = self::CACHE_PREFIX . $key;

        return Cache::rememberForever($cacheKey, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();

            return $setting ? $setting->typed_value : $default;
        });
    }

    /**
     * Set or update a setting value by key.
     */
    public static function set(
        string $key,
        mixed $value,
        ?string $type = null,
        string $group = 'general',
        ?string $description = null,
        bool $isPublic = false
    ): self {
        $detectedType = $type ?? match (true) {
            is_bool($value) => 'boolean',
            is_int($value) => 'integer',
            is_float($value) => 'float',
            is_array($value) => 'json',
            default => 'string',
        };

        $serializedValue = self::serializeValue($value, $detectedType);

        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $serializedValue,
                'type' => $detectedType,
                'description' => $description,
                'is_public' => $isPublic,
            ]
        );

        $setting->invalidateCache();

        return $setting;
    }

    /**
     * Check if a setting key exists.
     */
    public static function has(string $key): bool
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Retrieve all settings in a specific group as key-value pairs.
     *
     * @return array<string, mixed>
     */
    public static function getByGroup(string $group): array
    {
        $cacheKey = self::CACHE_GROUP_PREFIX . $group;

        return Cache::rememberForever($cacheKey, function () use ($group) {
            return self::where('group', $group)
                ->get()
                ->mapWithKeys(fn (self $setting) => [$setting->key => $setting->typed_value])
                ->all();
        });
    }

    /**
     * Retrieve all public settings for the store front/API.
     *
     * @return array<string, mixed>
     */
    public static function getPublicSettings(): array
    {
        return Cache::rememberForever(self::CACHE_PUBLIC_KEY, function () {
            return self::where('is_public', true)
                ->get()
                ->mapWithKeys(fn (self $setting) => [$setting->key => $setting->typed_value])
                ->all();
        });
    }

    /**
     * Invalidate caches associated with this setting.
     */
    public function invalidateCache(): void
    {
        Cache::forget(self::CACHE_PREFIX . $this->key);
        Cache::forget(self::CACHE_GROUP_PREFIX . $this->group);
        Cache::forget(self::CACHE_PUBLIC_KEY);
    }

    /**
     * Scope query to public settings.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope query by group.
     */
    public function scopeInGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }
}
