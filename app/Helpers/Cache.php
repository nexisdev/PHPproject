<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache as CacheProvider;

class Cache
{
    /**
     * @param string $key
     * @return mixed
     */
    public static function settings(string $key): mixed
    {
        return CacheProvider::get('settings')?->$key;
    }

    public static function allSettings(): array
    {
        return CacheProvider::get('settings')->toArray();
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return bool
     */
    public static function update(string $key, ?string $value): bool
    {
        return CacheProvider::put($key, $value);
    }

    /**
     * @return bool
     */
    public static function flush(): bool
    {
        return CacheProvider::flush();
    }
}
