<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    private const CACHE_KEY = 'tcmb_eur_try_rate';
    private const CACHE_TTL = 3600; // 1 saat
    private const FALLBACK  = 38.0; // TCMB erişilemezse güvenli fallback

    /**
     * TCMB'den güncel EUR/TRY alış kurunu döndürür.
     * Sonuç 1 saat cache'lenir.
     */
    public function getEurToTry(): float
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->fetchFromTcmb() ?? self::FALLBACK;
        });
    }

    /**
     * EUR tutarını TRY'ye çevirir.
     */
    public function eurToTry(float $eur): float
    {
        return round($eur * $this->getEurToTry(), 2);
    }

    /**
     * Cache'i temizleyip kuru yeniler (admin ihtiyacı için).
     */
    public function refresh(): float
    {
        Cache::forget(self::CACHE_KEY);
        return $this->getEurToTry();
    }

    private function fetchFromTcmb(): ?float
    {
        try {
            // TCMB günlük kur XML feed'i
            $response = Http::timeout(8)->get('https://www.tcmb.gov.tr/kurlar/today.xml');

            if (!$response->successful()) {
                return null;
            }

            $xml = simplexml_load_string($response->body());

            foreach ($xml->Currency as $currency) {
                if ((string) $currency['CurrencyCode'] === 'EUR') {
                    // ForexBuying kuru (alış)
                    $rate = (float) str_replace(',', '.', (string) $currency->ForexBuying);
                    return $rate > 0 ? $rate : null;
                }
            }
        } catch (\Throwable) {
            // TCMB erişilemez — null döner, caller fallback kullanır
        }

        return null;
    }
}
