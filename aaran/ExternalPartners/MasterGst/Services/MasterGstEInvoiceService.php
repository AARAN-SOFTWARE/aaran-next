<?php

namespace Aaran\ExternalPartners\MasterGst\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MasterGstEInvoiceService
{
    protected string $baseUrl;


    public function getAccessToken(): string
    {
        $cacheKey = 'mastergst_token';

        // Step 1: Check cache
        if ($token = Cache::get($cacheKey)) {
            return $token;
        }

        // Step 2: Check DB for non-expired token
        $record = DB::table('master_gst_tokens')
            ->where('id', '1')
            ->where('expires_at', '>', now())
            ->first();

        if ($record) {
            // Repopulate cache and session
            Cache::put($cacheKey, $record->token, now()->diffInSeconds($record->expires_at));
            session(['mastergst_token' => $record->token]);

            return $record->token;
        }

        // Step 3: Request new token from API
        $response = Http::timeout(30)->withOptions(['verify' => false]) // 👈 Skip SSL verification
        ->withHeaders([
            'username' => config('mastergst.username'),
            'password' => config('mastergst.password'),
            'ip_address' => config('mastergst.ip_address'),
            'client_id' => config('mastergst.client_id'),
            'client_secret' => config('mastergst.client_secret'),
            'gstin' => config('mastergst.gstin'),
        ])->get('https://api.mastergst.com/einvoice/authenticate', [
            'email' => config('mastergst.email'),
        ]);

        $data = $response->json();

        dd($data);

        // Check if response is OK and has the expected structure
        if (
            $response->ok() &&
            is_array($data) &&
            isset($data['data']['AuthToken'])
        ) {
            $token = $data['data']['AuthToken'];
            $expiresAt = now()->addHour(); // Valid for 1 hour

            // Store in DB
            DB::table('master_gst_tokens')->updateOrInsert(
                ['id' => 1],
                [
                    'token' => $token,
                    'expires_at' => $expiresAt,
                    'user_id' => auth()->id(),
                ]
            );

            // Store in cache and session
            Cache::put($cacheKey, $token, 3600);
            session(['mastergst_token' => $token]);

            return $token;
        } else {
            // Log full response for debugging
            Log::error('MasterGST Auth failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \Exception('Authentication failed with MasterGST.');
        }
    }


    public
    function generateEinvoice(array $payload): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post("{$this->baseUrl}/invoice", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('e-Invoice generation failed: ' . $response->body());
    }

    public
    function cancelEinvoice(string $irn, string $cancelReason, string $cancelRemarks): array
    {
        $token = $this->getAccessToken();

        $payload = [
            'irn' => $irn,
            'CnlRsn' => $cancelReason,
            'CnlRem' => $cancelRemarks,
        ];

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/cancel", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Cancel e-Invoice failed: ' . $response->body());
    }

    public
    function getEinvoiceByIrn(string $irn): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/irn/$irn");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Fetching IRN details failed: ' . $response->body());
    }

    public
    function getEinvoicePdf(string $irn): string
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/irn/$irn/pdf");

        if ($response->successful()) {
            return $response->body();
        }

        throw new \Exception('Fetching e-Invoice PDF failed: ' . $response->body());
    }

    /**
     * Get E-Way Bill details for an IRN
     */
    public
    function getEwayBillByIrn(string $irn): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/ewaybill/$irn");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Fetching E-Way Bill details failed: ' . $response->body());
    }

    /**
     * Cancel E-Way Bill with reason and remarks.
     */
    public
    function cancelEwayBill(string $ewayBillNo, string $cancelReasonCode, string $cancelRemarks): array
    {
        $token = $this->getAccessToken();

        $payload = [
            'ewbNo' => $ewayBillNo,
            'cancelRsnCode' => $cancelReasonCode,
            'cancelRmrk' => $cancelRemarks,
        ];

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/ewaybill/cancel", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Cancel E-Way Bill failed: ' . $response->body());
    }

    /**
     * Generate only E-Way Bill (if IRN already exists).
     */
    public
    function generateEwayBill(array $payload): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/ewaybill", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('E-Way Bill generation failed: ' . $response->body());
    }
}
