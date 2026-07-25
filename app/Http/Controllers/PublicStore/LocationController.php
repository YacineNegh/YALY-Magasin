<?php

namespace App\Http\Controllers\PublicStore;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Wilaya;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function wilayas(): JsonResponse
    {
        $wilayas = Wilaya::query()
            ->deliveryAvailable()
            ->select(['id', 'code', 'name', 'name_ar', 'delivery_price'])
            ->withCount('communes')
            ->orderBy('code')
            ->get();

        return response()->json([
            'data' => $wilayas->map(fn (Wilaya $wilaya): array => [
                'id' => $wilaya->id,
                'code' => $wilaya->code,
                'name' => $wilaya->name,
                'name_ar' => $wilaya->name_ar,
                'label' => str_pad((string) $wilaya->code, 2, '0', STR_PAD_LEFT).' - '.$wilaya->name,
                'delivery_price' => (float) $wilaya->delivery_price,
                'communes_count' => $wilaya->communes_count,
            ]),
        ]);
    }

    public function communes(Wilaya $wilaya): JsonResponse
    {
        abort_unless($wilaya->is_delivery_available, 404);

        $communes = $wilaya->communes()
            ->orderBy('name')
            ->get(['id', 'wilaya_id', 'name', 'name_ar', 'daira_name', 'postal_code']);

        return response()->json([
            'data' => $communes->map(fn (Commune $commune): array => [
                'id' => $commune->id,
                'name' => $commune->name,
                'name_ar' => $commune->name_ar,
                'daira_name' => $commune->daira_name,
                'postal_code' => $commune->postal_code,
            ]),
        ]);
    }
}
