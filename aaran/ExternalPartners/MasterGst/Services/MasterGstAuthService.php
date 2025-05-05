<?php

namespace Aaran\ExternalPartners\MasterGst\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MasterGstAuthService
{
    protected string $cacheKey = 'mastergst_token_data';

    public function getAccessToken(): string
    {
        $cached = Cache::get($this->cacheKey);

        if ($cached && isset($cached['token'], $cached['expires_at'])) {
            if (now()->lt($cached['expires_at'])) {
                return $cached['token'];
            }
        }

        return $this->fetchAndCacheToken();
    }

    protected function fetchAndCacheToken(): string
    {
        $response = $this->makeAuthRequest();
        $data = $response->json();

        if (
            $response->ok() &&
            is_array($data) &&
            isset($data['data']['AuthToken'], $data['data']['TokenExpiry'])
        ) {
            $token = $data['data']['AuthToken'];
            $expiresAt = Carbon::parse($data['data']['TokenExpiry']);

            // Store token in cache
            Cache::put($this->cacheKey, [
                'token' => $token,
                'expires_at' => $expiresAt,
            ], $expiresAt);

            // Store token in database
            $this->storeTokenInDatabase($data);

            return $token;
        }

        Log::error('MasterGST Auth failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new \Exception('Failed to authenticate with MasterGST.');
    }

    protected function makeAuthRequest()
    {
        return Http::timeout(30)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'username' => config('mastergst.username'),
                'password' => config('mastergst.password'),
                'ip_address' => config('mastergst.ip_address'),
                'client_id' => config('mastergst.client_id'),
                'client_secret' => config('mastergst.client_secret'),
                'gstin' => config('mastergst.gstin'),
            ])
            ->get('https://api.mastergst.com/einvoice/authenticate', [
                'email' => config('mastergst.email'),
            ]);
    }

    protected function storeTokenInDatabase(array $responseData): void
    {
        DB::table('master_gst_tokens')->updateOrInsert(
            ['id' => 1],
            [
                'token' => $responseData['data']['AuthToken'],
                'expires_at' => $responseData['data']['TokenExpiry'],
                'client_id' => $responseData['data']['Client_id'] ?? null,
                'sek' => $responseData['data']['Sek'] ?? null,
                'txn' => $responseData['header']['txn'] ?? null,
                'status_cd' => $responseData['status_cd'] ?? null,
                'user_id' => auth()->id() ?? null,
                'updated_at'  => now(),
                'created_at'  => now(),
            ]
        );
    }
}
