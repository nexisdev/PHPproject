<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\TokenPriceUpdateException;
use App\Helpers\Cache;
use App\Http\Controllers\Controller;
use App\Http\Requests\TokenPriceUpdateRequest;
use App\Models\PayableToken;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewType;
use Spatie\Activitylog\Models\Activity;

class TokenPriceV1Controller extends Controller
{
    /**
     * @return ViewType
     */
    public function index(): ViewType
    {
        $price = Cache::settings('token_price') ?? null;
        $activity = Activity::forEvent('price_update')->orderByDesc('id')->get();
        $payableTokens = PayableToken::active()->get();

        return View::make('admin.token-price.index', ['price' => $price, 'activity' => $activity, 'payableTokens' => $payableTokens]);
    }

    /**
     * @param TokenPriceUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(TokenPriceUpdateRequest $request): RedirectResponse
    {
        try {
            $settings = Setting::find(1);
            $oldPrice = $settings->token_price;
            $settings->update($request->validated());
            Cache::update('token_price', $request->token_price);
        } catch (TokenPriceUpdateException $exception) {
            Log::critical($exception->getMessage());
            return redirect()->back()->with(['error' => 'Cannot update the price, please contact our support']);
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($settings)
            ->withProperties(['old_price' => $oldPrice])
            ->event('price_update')
            ->log('Price was changed by the user: ' . auth()->user()->name);

        return redirect()->back()->with(['success' => 'Successfully updated the token price!']);
    }
}
