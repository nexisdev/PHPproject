<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\SettingsUpdateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsUpdateRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View as ViewType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class SettingsV1Controller extends Controller
{
    /**
     * @return ViewType
     */
    public function index(): ViewType
    {
        $settings = Setting::find(1);

        return View::make('admin.settings.edit', ['settings' => $settings]);
    }

    /**
     * @param SettingsUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(SettingsUpdateRequest $request): RedirectResponse
    {
        try {
            $settings = collect($request->validated())->except(['logo', 'white_paper']);
            $files = ['logo', 'white_paper', 'token_image'];
            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $settings[$file] = $request->$file->store('public/files');
                }
            }

            Setting::find(1)->update($settings->toArray());
        } catch (SettingsUpdateException $exception) {
            Log::critical($exception->getMessage());
            return redirect()
                ->back()
                ->with(['error' => 'Cannot update settings, please contact support!']);
        }

        return redirect()
            ->back()
            ->with(['success' => 'Settings have been updated successfully!']);
    }
}
