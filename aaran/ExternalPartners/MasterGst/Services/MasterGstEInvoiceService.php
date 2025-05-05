<?php

namespace Aaran\ExternalPartners\MasterGst\Services;

use Illuminate\Support\Facades\Http;

class MasterGstEInvoiceService
{
    protected MasterGstAuthService $authService;

    public function __construct(MasterGstAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function generateEinvoice(array $payload): array
    {
        $token = $this->authService->getAccessToken();

        $response = Http::timeout(30)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'ip_address' => config('mastergst.ip_address'),
                'client_id' => config('mastergst.client_id'),
                'client_secret' => config('mastergst.client_secret'),
                'username' => config('mastergst.username'),
                'auth-token' => $token,
                'gstin' => config('mastergst.gstin'),
                'Content-Type' => 'application/json',
            ])->post("https://api.mastergst.com/einvoice/type/GENERATE/version/V1_03", [
                'email' => config('mastergst.email')
            ], $payload);

        $data = $response->json();
        dd($data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('e-Invoice generation failed: ' . $response->body());
    }

}
