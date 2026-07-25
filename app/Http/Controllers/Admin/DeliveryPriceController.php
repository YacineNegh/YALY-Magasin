<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDeliveryPricesRequest;
use App\Models\Wilaya;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DeliveryPriceController extends Controller
{
    public function index(): View
    {
        return view('admin.delivery-prices.index', [
            'wilayas' => Wilaya::query()
                ->select(['id', 'code', 'name', 'name_ar', 'delivery_price', 'is_delivery_available'])
                ->withCount('communes')
                ->orderBy('code')
                ->get(),
        ]);
    }

    public function update(UpdateDeliveryPricesRequest $request): RedirectResponse
    {
        /** @var array<int|string, array{delivery_price: numeric-string|int|float, is_delivery_available: bool|int|string}> $wilayaInputs */
        $wilayaInputs = $request->validated()['wilayas'];

        Wilaya::query()
            ->whereKey(array_keys($wilayaInputs))
            ->get()
            ->each(function (Wilaya $wilaya) use ($wilayaInputs): void {
                $input = $wilayaInputs[$wilaya->id];

                $wilaya->update([
                    'delivery_price' => $input['delivery_price'],
                    'is_delivery_available' => (bool) $input['is_delivery_available'],
                ]);
            });

        return back()->with('success', 'Delivery prices updated.');
    }
}
