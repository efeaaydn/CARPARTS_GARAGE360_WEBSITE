<?php

namespace App\Http\Controllers;

use App\Services\VinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VinController extends Controller
{
    public function __construct(private VinService $vinService) {}

    public function decode(Request $request): JsonResponse
    {
        $request->validate([
            'vin' => ['required', 'string', 'size:17', 'regex:/^[A-HJ-NPR-Z0-9]{17}$/i'],
        ]);

        $data = $this->vinService->decode($request->input('vin'));

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'VIN numarası doğrulanamadı veya araç bilgisi bulunamadı.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'make'    => $data['make'],
            'model'   => $data['model'],
            'year'    => $data['year'],
        ]);
    }
}
