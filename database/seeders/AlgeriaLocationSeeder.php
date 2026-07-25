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

        foreach (collect($communes)->groupBy('wilaya_code') as $wilayaCode => $wilayaCommunes) {
            /** @var array<string, mixed> $firstCommune */
            $firstCommune = $wilayaCommunes->first();

            $wilaya = Wilaya::firstOrNew(['code' => (int) $wilayaCode]);
            $wilaya->name = (string) $firstCommune['wilaya_name_fr'];
            $wilaya->name_ar = (string) $firstCommune['wilaya_name_ar'];

            if (! $wilaya->exists) {
                $wilaya->delivery_price = $this->defaultDeliveryPrice((int) $wilayaCode);
                $wilaya->is_delivery_available = true;
            }

            $wilaya->save();

            foreach ($wilayaCommunes as $commune) {
                Commune::updateOrCreate(
                    ['geoalgeria_id' => (int) $commune['id']],
                    [
                        'wilaya_id' => $wilaya->id,
                        'name' => (string) $commune['commune_name_fr'],
                        'name_ar' => (string) $commune['commune_name_ar'],
                        'daira_name' => (string) $commune['daira_name_fr'],
                        'postal_code' => (string) $commune['postal_code'],
                    ],
                );
            }
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
