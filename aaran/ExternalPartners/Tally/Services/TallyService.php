<?php

namespace Aaran\ExternalPartners\Tally\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Exception;

class TallyService
{
    public mixed $baseUrl;

    public function __construct()
    {
        // Example: Tally default HTTP port
        $this->baseUrl = 'http://localhost:9000';
    }

    /**
     * Send a raw XML request to Tally and return the response
     *
     * @param string $xmlRequest
     * @return array
     */
    public function sendRequest(string $xmlRequest): array
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/xml'
            ])->withBody($xmlRequest, 'application/xml')->post($this->baseUrl);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Handle successful response
     *
     * @param Response $response
     * @return array
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return [
                'status' => 'success',
                'body' => $response->body(), // This will be raw XML
            ];
        }

        return $this->handleError(new Exception('Tally API Error: ' . $response->body()));
    }

    /**
     * Handle exceptions and errors
     *
     * @param Exception $e
     * @return array
     */
    protected function handleError(Exception $e): array
    {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}
