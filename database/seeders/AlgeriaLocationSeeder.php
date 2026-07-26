<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AlgeriaLocationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/geoalgeria_communes.json');

        if (! File::exists($path)) {
            return;
        }

        /** @var array<int, array<string, mixed>> $communes */
        $communes = json_decode(File::get($path), true, flags: JSON_THROW_ON_ERROR);

        \Illuminate\Support\Facades\DB::disableQueryLog();

        $wilayasData = [];
        $communesData = [];

        // Prepare Wilayas data
        foreach (collect($communes)->groupBy('wilaya_code') as $wilayaCode => $wilayaCommunes) {
            $firstCommune = $wilayaCommunes->first();
            $wilayasData[] = [
                'code' => (int) $wilayaCode,
                'name' => (string) $firstCommune['wilaya_name_fr'],
                'name_ar' => (string) $firstCommune['wilaya_name_ar'],
                'delivery_price' => $this->defaultDeliveryPrice((int) $wilayaCode),
                'is_delivery_available' => true,
            ];
        }

        // Bulk upsert Wilayas
        Wilaya::upsert($wilayasData, ['code'], ['name', 'name_ar']);

        // Fetch the inserted Wilayas to map their IDs
        $wilayaMap = Wilaya::pluck('id', 'code');

        // Prepare Communes data
        foreach ($communes as $commune) {
            $communesData[] = [
                'geoalgeria_id' => (int) $commune['id'],
                'wilaya_id' => $wilayaMap[$commune['wilaya_code']],
                'name' => (string) $commune['commune_name_fr'],
                'name_ar' => (string) $commune['commune_name_ar'],
                'daira_name' => (string) $commune['daira_name_fr'],
                'postal_code' => (string) $commune['postal_code'],
            ];
        }

        // Bulk upsert Communes in chunks to avoid query length limits
        foreach (array_chunk($communesData, 500) as $chunk) {
            Commune::upsert($chunk, ['geoalgeria_id'], ['wilaya_id', 'name', 'name_ar', 'daira_name', 'postal_code']);
        }
    }

    private function defaultDeliveryPrice(int $wilayaCode): int
    {
        $centerWilayas = [2, 6, 9, 10, 15, 16, 26, 35, 42, 44];
        $farSouthWilayas = [1, 11, 30, 33, 37, 49, 50, 52, 56, 58];
        $newHighPlateauWilayas = [59, 60, 61, 64, 65, 66, 67, 68, 69];

        if (in_array($wilayaCode, $centerWilayas, true)) {
            return 500;
        }

        if (in_array($wilayaCode, $farSouthWilayas, true)) {
            return 1400;
        }

        if (in_array($wilayaCode, $newHighPlateauWilayas, true)) {
            return 900;
        }

        if ($wilayaCode >= 49) {
            return 1200;
        }

        return 700;
    }
}
