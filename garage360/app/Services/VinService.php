<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VinService
{
    public function decode(string $vin): array
    {
        $response = Http::timeout(10)
            ->get("https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/{$vin}", [
                'format' => 'json',
            ]);

        if ($response->failed()) {
            return [];
        }

        $make  = null;
        $model = null;
        $year  = null;

        foreach ($response->json('Results', []) as $item) {
            $variable = $item['Variable'] ?? '';
            $value    = isset($item['Value']) && $item['Value'] !== '' ? $item['Value'] : null;

            match ($variable) {
                'Make'        => $make  = $value,
                'Model'       => $model = $value,
                'Model Year'  => $year  = $value,
                default       => null,
            };
        }

        if (!$make || !$model) {
            return [];
        }

        return compact('make', 'model', 'year');
    }
}
