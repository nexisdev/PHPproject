<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ClearCacheException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewType;

class CacheV1Controller extends Controller
{
    /**
     * @return ViewType
     */
    public function index(): ViewType
    {
        return View::make('admin.cache.index');
    }

    /**
     * @return RedirectResponse
     */
    public function clearCache(): RedirectResponse
    {
        try {
            Artisan::call('clear-cache');
        } catch (ClearCacheException $exception) {
            Log::critical($exception->getMessage());
            return redirect()->back()->with(['error' => 'Cannot clear the cache, please contact our support!']);
        }

        return redirect()->back()->with(['success' => 'The cache was cleared successfully!']);
    }
}
